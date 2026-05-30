<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class EmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user') ?? $this->route('id');

        return [
            // Datos de usuario
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'fotoPerfil' => [
                'nullable',
                'string',
            ],

            'password' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],

            'rol' => ['required', 'string', 'exists:roles,name'],

            // Datos de empresa
            'nombre_empresa' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:20'],
            'descripcion' => ['nullable', 'string'],
            'tipo_servicio' => ['required', 'string'],
            'poblacion_id' => ['required', 'exists:poblaciones,id'],

            'logo' => ['nullable', 'string'],

            'fotos' => ['nullable', 'array'],
            'fotos.*.path' => ['required_with:fotos', 'string'],
            'fotos.*.url' => ['required_with:fotos', 'string'],

            'user_id' => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del usuario es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'rol.required' => 'Debes asignar un rol al usuario.',
            'rol.exists' => 'El rol seleccionado no existe.',

            'nombre_empresa.required' => 'El nombre de la empresa es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'tipo_servicio.required' => 'El tipo de empresa es obligatorio.',
            'poblacion_id.required' => 'La población es obligatoria.',
            'poblacion_id.exists' => 'La población seleccionada no existe.',
            'user_id.prohibited' => 'No puedes asignar un usuario manualmente.',
        ];
    }
}