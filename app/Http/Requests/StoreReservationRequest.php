<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'datetime' => 'required|date',
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
        ];
    }
}
