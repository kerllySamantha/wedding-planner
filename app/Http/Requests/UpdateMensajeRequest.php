<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMensajeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contenido' => 'sometimes|required|string',
            'archivo'   => 'nullable|string|max:255',
            'leido'     => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'contenido.required' => 'El contenido del mensaje es obligatorio.',
            'contenido.string'   => 'El contenido debe ser texto.',
            'archivo.string'     => 'El archivo debe ser una URL o ruta válida.',
            'archivo.max'        => 'La ruta del archivo no puede superar los 255 caracteres.',
            'leido.boolean'      => 'El campo "leído" debe ser verdadero o falso.',
        ];
    }
}
