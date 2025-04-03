<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'role' => 'required|exists:roles,id',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom complet est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.unique' => 'Cet email est déjà utilisé',
            'phone.required' => 'Le téléphone est obligatoire',
            'role.required' => 'Le rôle est obligatoire',
            'services.*.exists' => 'Un des services sélectionnés est invalide'
        ];
    }
}
