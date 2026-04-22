<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class EmpresaRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
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
            'nombre_empresa' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'descripcion' => 'nullable|string',
            'logo' => 'nullable|string',
            'fotos' => 'nullable|array',
            'tipo_servicio' => 'required|string',
            'fotos.*' => 'nullable|string',
            'poblacion_id' => 'required|exists:poblaciones,id',
            // 'categoria_id' => 'required|exists:categorias,id',
            'user_id' => 'prohibited',
        ];
    }

    public function messages(): array
    {
        return [
            // nombre_empresa
            'nombre_empresa.required' => 'El nombre de la empresa es obligatorio.',
            'nombre_empresa.string' => 'El nombre de la empresa debe ser un texto válido.',
            'nombre_empresa.max' => 'El nombre de la empresa no puede tener más de 255 caracteres.',

            
            // direccion
            
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser un texto válido.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',

            // telefono  ← FALTA
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser un texto válido.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',

            // tipo_servicio  ← FALTA
            'tipo_servicio.required' => 'El tipo de empresa es obligatorio.',
            'tipo_servicio.string' => 'El tipo de empresa debe ser un texto válido.',

            // poblacion_id  ← FALTA
            'poblacion_id.required' => 'La población es obligatoria.',
            'poblacion_id.exists' => 'La población seleccionada no existe.',

            // name
            'name.required' => 'El nombre del usuario es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            // email
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado.',  // ← FALTA
            'email.max' => 'El email no puede tener más de 255 caracteres.',

            // password
            'password.required' => 'La contraseña es obligatoria.',

            // rol
            'rol.required' => 'Debes asignar un rol al usuario.',
            'rol.exists' => 'El rol seleccionado no existe.',  // ← FALTA

            // user_id
            'user_id.prohibited' => 'No puedes asignar un usuario manualmente.',  // ← FALTA
        ];
    }
}