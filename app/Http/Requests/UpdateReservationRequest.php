<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' => 'required|exists:users,id',
            'datetime' => [
                'required',
                'date',
                'after_or_equal:' . now()->addHours(2)->toDateTimeString(),
                function ($attribute, $value, $fail) {
                    $datetime = Carbon::parse($value);
                    $startTime = $datetime->copy()->setTime(9, 0, 0);
                    $endTime = $datetime->copy()->setTime(16, 0, 0);

                    if ($datetime->lt($startTime)) {
                        $fail('Les réservations ne sont pas acceptées avant 9:00.');
                    }
                    
                    if ($datetime->gt($endTime)) {
                        $fail('Les réservations ne sont pas acceptées après 16:00.');
                    }
                },
            ],
            'end_time' => 'nullable|date|after:datetime', 
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'La sélection d\'un employé est obligatoire.',
            'employee_id.exists' => 'L\'employé sélectionné n\'existe pas dans notre système.',
            'datetime.required' => 'La date et heure de réservation sont obligatoires.',
            'datetime.date' => 'Le format de la date et heure est invalide.',
            'datetime.after_or_equal' => 'La réservation doit être programmée au moins 2 heures à l\'avance.',
            'end_time.date' => 'L\'heure de fin doit être une date valide.',
            'end_time.after' => 'L\'heure de fin doit être postérieure à l\'heure de début.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $reservation = $this->route('reservation');
            $service = $reservation->service; 
            
            if ($this->datetime) {
                $proposedEnd = Carbon::parse($this->datetime)->addMinutes($service->duration);
                
                $conflictingReservation = Reservation::where('employee_id', $this->employee_id)
                    ->where(function($query) use ($proposedEnd) {
                        $query->whereBetween('datetime', [$this->datetime, $proposedEnd])
                              ->orWhereBetween('end_time', [$this->datetime, $proposedEnd])
                              ->orWhere(function($q) use ($proposedEnd) {
                                  $q->where('datetime', '<', $this->datetime)
                                    ->where('end_time', '>', $proposedEnd);
                              });
                    })
                    ->where('id', '!=', $reservation->id)
                    ->whereNotIn('status', ['Done', 'Refused'])
                    ->exists();
    
                if ($conflictingReservation) {
                    $validator->errors()->add('datetime', 'L\'employé a déjà une réservation pendant ce créneau.');
                }
            }
        });
    }
}