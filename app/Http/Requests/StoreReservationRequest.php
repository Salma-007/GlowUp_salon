<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'datetime' => [
                'required',
                'date',
                'after_or_equal:' . now()->addHours(2)->toDateTimeString(), 
                function ($attribute, $value, $fail) {
                    $datetime = Carbon::parse($value);
                    $startTime = $datetime->copy()->setTime(9, 0, 0);
                    $endTime = $datetime->copy()->setTime(16, 0, 0);

                    if ($datetime->lt($startTime) || $datetime->gt($endTime)) {
                        $fail('L\'horaire doit être entre 9:00 et 16:00.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'L\'employé est obligatoire.',
            'employee_id.exists' => 'L\'employé sélectionné est invalide.',
            'service_id.required' => 'Le service est obligatoire.',
            'service_id.exists' => 'Le service sélectionné est invalide.',
            'datetime.required' => 'La date et l\'heure sont obligatoires.',
            'datetime.date' => 'La date et l\'heure doivent être une date valide.',
            'datetime.after_or_equal' => 'La date et l\'heure doivent être au moins 2 heures après l\'heure actuelle.',
        ];
    }
}
