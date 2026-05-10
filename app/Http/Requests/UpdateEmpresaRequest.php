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
            'name' => 'required|string|max:255',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($userId), // ← ignora el usuario actual
            ],
            'password' => 'sometimes|nullable|string|min:8',
            'rol' => 'sometimes|string|exists:roles,name',

            // --- Datos de la empresa ---
            'nombre_empresa' => 'required|string|max:255',
            'direccion' => 'required|string',
            'telefono' => 'sometimes|nullable|string|max:20',
            'descripcion' => 'sometimes|nullable|string',
            'tipo_servicio' => 'sometimes|nullable|string',
            'poblacion_id' => 'required|exists:poblaciones,id',
            'logo' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'fotos' => 'sometimes|nullable|array',
            'fotos.*.path' => 'required|string',
            'fotos.*.url' => 'required|string',
            'productos' => 'required|array|min:1',
            'productos.*.id' => [
                'nullable',
                'integer',
                Rule::exists('productos', 'id'),
            ],
            'productos.*.nombre' => 'required_with:productos|string|max:255',
            'productos.*.descripcion' => 'nullable|string',
            'productos.*.precio_min' => 'nullable|numeric|min:0', // ← corregido
            'productos.*.precio_max' => 'nullable|numeric|min:0|gte:productos.*.precio_min',
            'productos_eliminados.*' => [
                'integer',
                Rule::exists('productos', 'id')->where(function ($q) use ($empresa) {
                    $q->where('empresa_id', $empresa->id);
                }),
            ],
            'productos_eliminados' => 'sometimes|array',


            // TipoProducto
            'productos.*.tipo_producto_nombre' => 'required_with:productos|string|max:255',
            'productos.*.tipo_producto_descripcion' => 'nullable|string',
            // 'productos.*.modalidad' => 'nullable|string',

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
            'fotos.*.path.required' => 'La ruta de la imagen es obligatoria.',
            'fotos.*.url.required' => 'La URL de la imagen es obligatoria.',
            'productos.*.id.exists' => 'Uno o más productos no pertenecen a esta empresa.',
        ];
    }
}
