<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReseniaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'      => 'required|exists:users,id',
            'empresa_id'   => 'required|exists:empresas,id',
            'puntuacion'   => 'required|integer|min:1|max:5',
            'comentario'   => 'required|string|min:20|max:700',
            'fotos'        => 'nullable|array|max:6',
            'fotos.*.path' => 'required_with:fotos|string',
            'fotos.*.url'  => 'required_with:fotos|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'      => 'El identificador de usuario es obligatorio.',
            'user_id.exists'        => 'El usuario indicado no existe.',
            'empresa_id.required'   => 'El identificador del proveedor es obligatorio.',
            'empresa_id.exists'     => 'El proveedor indicado no existe.',
            'puntuacion.required'   => 'La puntuación es obligatoria.',
            'puntuacion.integer'    => 'La puntuación debe ser un número entero.',
            'puntuacion.min'        => 'La puntuación mínima es 1.',
            'puntuacion.max'        => 'La puntuación máxima es 5.',
            'comentario.required'   => 'El comentario es obligatorio.',
            'comentario.string'     => 'El comentario debe ser texto.',
            'comentario.min'        => 'El comentario debe tener al menos 20 caracteres.',
            'comentario.max'        => 'El comentario no puede superar los 700 caracteres.',
            'fotos.array'           => 'Las fotos deben enviarse como lista.',
            'fotos.max'             => 'Puedes subir un máximo de 6 fotos.',
            'fotos.*.path.required_with' => 'Cada foto debe incluir la ruta del archivo.',
            'fotos.*.url.required_with'  => 'Cada foto debe incluir la URL de acceso.',
        ];
    }
}
