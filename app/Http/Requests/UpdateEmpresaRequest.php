<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmpresaRequest extends FormRequest
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
        // Obtenemos el user_id de la empresa que viene en la ruta
        $empresa = $this->route('empresa');
        $userId = $empresa->user_id;

        return [
            // --- Datos del usuario ---
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($userId), // ← ignora el usuario actual
            ],
            'password' => 'sometimes|nullable|string|min:8',
            'rol' => 'sometimes|string|exists:roles,name',

            // --- Datos de la empresa ---
            'nombre_empresa' => 'sometimes|string|max:255',
            'direccion' => 'sometimes|nullable|string',
            'telefono' => 'sometimes|nullable|string|max:20',
            'descripcion' => 'sometimes|nullable|string',
            'tipo_servicio' => 'sometimes|nullable|string',
            'poblacion_id' => 'sometimes|nullable|exists:poblaciones,id',
            'logo' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'fotos' => 'sometimes|nullable|array',
            'fotos.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'productos' => 'sometimes|nullable|array',
            'productos.*.id' => 'sometimes|nullable|exists:productos,id',
            'productos.*.nombre' => 'required_with:productos|string|max:255',
            'productos.*.descripcion' => 'nullable|string',
            'productos.*.precio_min' => 'nullable|numeric|min:0', // ← corregido
            'productos.*.precio_max' => 'nullable|numeric|min:0', // ← corregido


            // TipoProducto
            'productos.*.tipo_producto_nombre' => 'required_with:productos|string|max:255',
            'productos.*.tipo_producto_descripcion' => 'nullable|string',
            'productos.*.modalidad' => 'nullable|string',

            // Categoria
            'productos.*.categoria_nombre' => 'required_with:productos|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Este email ya está en uso por otro usuario.',
            'email.email' => 'El formato del email no es válido.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'logo.image' => 'El logo debe ser una imagen.',
            'logo.max' => 'El logo no puede superar los 2MB.',
        ];
    }
}
