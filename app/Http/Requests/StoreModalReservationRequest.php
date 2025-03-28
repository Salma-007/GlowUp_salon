<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModalReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'datetime' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'L\'employé est obligatoire.',
            'employee_id.exists' => 'L\'employé sélectionné est invalide.',
            'datetime.required' => 'La date et l\'heure sont obligatoires.',
            'datetime.date' => 'La date et l\'heure doivent être une date valide.',
        ];
    }
}
