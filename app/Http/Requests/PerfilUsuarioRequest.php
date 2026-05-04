<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PerfilUsuarioRequest extends FormRequest
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
     * @return array<string, 
     */

    public function rules(): array
    {
        return [
            // Usuario
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'rol' => 'required|string|exists:roles,name',


            // Perfil
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'poblacion_id' => 'required|exists:poblaciones,id',
            'fecha_boda' => 'required|date|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            // 'user_id.required'   => 'El usuario es obligatorio.',
            // 'user_id.exists'     => 'El usuario seleccionado no existe.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser un texto válido.',
            'direccion.max' => 'La dirección no puede superar los 255 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser un texto válido.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',

        ];
    }
}