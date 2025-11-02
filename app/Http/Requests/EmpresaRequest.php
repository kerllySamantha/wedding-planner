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
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
            'rol' => 'required|string|exists:roles,name',
            'nombre_empresa' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'descripcion' => 'nullable|string',
            'logo' => 'nullable|string',
            'fotos' => 'required|array',
            'tipo_servicio' => 'string',
            'fotos.*' => 'string',
            // 'categoria_id' => 'required|exists:categorias,id',
            'user_id' => 'prohibited',
        ];
    }

    public function messages(): array
    {
        return [
            // Empresa
            'nombre_empresa.required' => 'El nombre de la empresa es obligatorio.',
            'nombre_empresa.string'   => 'El nombre de la empresa debe ser un texto válido.',
            'nombre_empresa.max'      => 'El nombre de la empresa no puede tener más de 255 caracteres.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string'   => 'La dirección debe ser un texto válido.',
            'direccion.max'      => 'La dirección no puede tener más de 255 caracteres.',

            // 'logo.string' => 'El logo debe ser un texto válido (URL o nombre de archivo).',

            // 'fotos.string' => 'Las fotos deben enviarse como texto o URL.',

            // 'descripcion.string'   => 'La descripción debe ser un texto válido.',

            // 'categoria_id.required' => 'Debes seleccionar una categoría.',
            // 'categoria_id.exists'   => 'La categoría seleccionada no existe.',

            // Usuario
            'name.required' => 'El nombre del usuario es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'rol.required' => 'Debes asignar un rol al usuario.',
        ];
    }
}