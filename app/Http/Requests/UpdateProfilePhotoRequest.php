<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePhotoRequest extends FormRequest
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
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'profile_photo.max' => 'La photo ne doit pas dépasser 2Mo',
            'profile_photo.mimes' => 'Le format de la photo doit être JPEG, PNG, JPG ou GIF',
        ];
    }
}
