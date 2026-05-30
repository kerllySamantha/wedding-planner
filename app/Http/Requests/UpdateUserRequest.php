<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('usuario') ?? $this->route('user') ?? $this->route('id');

        return [
            'name'       => ['sometimes', 'required', 'string', 'max:255'],
            'email'      => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password'   => ['nullable', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'rol'        => ['sometimes', 'required', 'string', 'exists:roles,name'],
            'fotoPerfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'El nombre es obligatorio.',
            'name.string'       => 'El nombre debe ser texto.',
            'name.max'          => 'El nombre no puede superar los 255 caracteres.',
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'El correo electrónico no tiene un formato válido.',
            'email.unique'      => 'Este correo electrónico ya está en uso.',
            'rol.required'      => 'El rol es obligatorio.',
            'rol.exists'        => 'El rol indicado no existe.',
            'fotoPerfil.image'  => 'La foto de perfil debe ser una imagen.',
            'fotoPerfil.mimes'  => 'La foto de perfil debe ser JPG, PNG, WEBP o GIF.',
            'fotoPerfil.max'    => 'La foto de perfil no puede superar los 5 MB.',
        ];
    }
}
