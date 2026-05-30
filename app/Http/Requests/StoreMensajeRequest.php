<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMensajeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'emisor_id'   => 'required|exists:users,id',
            'receptor_id' => 'required|exists:users,id',
            'contenido'   => 'required|string',
            'archivo'     => 'nullable|string|max:255',
            'leido'       => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'emisor_id.required'   => 'El emisor es obligatorio.',
            'emisor_id.exists'     => 'El emisor no existe en el sistema.',
            'receptor_id.required' => 'El receptor es obligatorio.',
            'receptor_id.exists'   => 'El receptor no existe en el sistema.',
            'contenido.required'   => 'El contenido del mensaje es obligatorio.',
            'contenido.string'     => 'El contenido debe ser texto.',
            'archivo.string'       => 'El archivo debe ser una URL o ruta válida.',
            'archivo.max'          => 'La ruta del archivo no puede superar los 255 caracteres.',
            'leido.boolean'        => 'El campo "leído" debe ser verdadero o falso.',
        ];
    }
}
