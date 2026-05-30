<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateEmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $empresa = $this->route('empresa');
        $userId = $empresa->user_id;

        return [

            /*
            |--------------------------------------------------------------------------
            | DATOS USUARIO
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'fotoPerfil' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'password' => [
                'nullable',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],

            'rol' => [
                'sometimes',
                'string',
                'exists:roles,name',
            ],

            /*
            |--------------------------------------------------------------------------
            | DATOS EMPRESA
            |--------------------------------------------------------------------------
            */

            'nombre_empresa' => [
                'required',
                'string',
                'max:255',
            ],

            'direccion' => [
                'required',
                'string',
                'max:255',
            ],

            'telefono' => [
                'required',
                'string',
                'max:20',
            ],

            'descripcion' => [
                'nullable',
                'string',
            ],

            'tipo_servicio' => [
                'required',
                'string',
            ],

            'poblacion_id' => [
                'required',
                'exists:poblaciones,id',
            ],

            'logo' => [
                'sometimes',
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | GALERIA
            |--------------------------------------------------------------------------
            */

            'fotos' => [
                'nullable',
                'array',
            ],

            'fotos.*.path' => [
                'required_with:fotos',
                'string',
            ],

            'fotos.*.url' => [
                'required_with:fotos',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | PRODUCTOS
            |--------------------------------------------------------------------------
            */

            'productos' => [
                'sometimes',
                'array',
            ],

            'productos.*.id' => [
                'nullable',
                'integer',
                Rule::exists('productos', 'id')->where(function ($query) use ($empresa) {

                    $query->where(function ($subQuery) use ($empresa) {

                        $subQuery
                            ->where('empresa_id', $empresa->id)
                            ->orWhereNull('empresa_id');

                    });

                }),
            ],

            'productos.*.nombre' => [
                'required_with:productos',
                'string',
                'max:255',
            ],

            'productos.*.descripcion' => [
                'nullable',
                'string',
            ],

            'productos.*.precio_min' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'productos.*.precio_max' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | ELIMINADOS
            |--------------------------------------------------------------------------
            */

            'productos_eliminados' => [
                'sometimes',
                'array',
            ],

            'productos_eliminados.*' => [
                'integer',
            ],

            /*
            |--------------------------------------------------------------------------
            | TIPO PRODUCTO
            |--------------------------------------------------------------------------
            */

            'productos.*.tipo_producto_id' => [
                'nullable',
                'integer',
                'exists:tipo_productos,id',
            ],

            'productos.*.tipo_producto_nombre' => [
                'required_without:productos.*.tipo_producto_id',
                'string',
                'max:255',
            ],

            'productos.*.tipo_producto_descripcion' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | CATEGORIA
            |--------------------------------------------------------------------------
            */

            'productos.*.categoria_nombre' => [
                'required_without:productos.*.tipo_producto_id',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'email.unique' => 'Este email ya está en uso por otro usuario.',
            'email.email' => 'El formato del email no es válido.',

            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',

            'logo.image' => 'El logo debe ser una imagen.',
            'logo.max' => 'El logo no puede superar los 5MB.',

            'fotos.*.path.required_with' => 'La ruta de la imagen es obligatoria.',
            'fotos.*.url.required_with' => 'La URL de la imagen es obligatoria.',

            'productos.required' => 'Debes añadir al menos un producto.',

            'productos.*.id.exists' =>
                'Uno o más productos no pertenecen a esta empresa ni al catálogo general.',
        ];
    }
}