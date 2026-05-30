<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password'   => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'rol'        => ['required', 'string', 'exists:roles,name'],
            'fotoPerfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'El nombre es obligatorio.',
            'name.string'        => 'El nombre debe ser texto.',
            'name.max'           => 'El nombre no puede superar los 255 caracteres.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'El correo electrónico no tiene un formato válido.',
            'email.unique'       => 'Este correo electrónico ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password'           => 'La contraseña debe tener mínimo 8 caracteres, incluir mayúsculas, minúsculas, números y símbolos.',
            'rol.required'       => 'El rol es obligatorio.',
            'rol.exists'         => 'El rol indicado no existe.',
            'fotoPerfil.image'   => 'La foto de perfil debe ser una imagen.',
            'fotoPerfil.mimes'   => 'La foto de perfil debe ser JPG, PNG, WEBP o GIF.',
            'fotoPerfil.max'     => 'La foto de perfil no puede superar los 5 MB.',
        ];
    }
}
