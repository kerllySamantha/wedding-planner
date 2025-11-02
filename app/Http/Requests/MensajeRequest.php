<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MensajeRequest extends FormRequest
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
        return [
            'emisor_id'   => 'required|exists:users,id',
            'receptor_id' => 'required|exists:users,id',
            'contenido'   => 'required|string',
            'archivo'     => 'nullable|string|max:255',
            'leido'       => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'emisor_id.required'   => 'El emisor es obligatorio.',
            'emisor_id.exists'     => 'El emisor no existe en la base de datos.',
            'receptor_id.required' => 'El receptor es obligatorio.',
            'receptor_id.exists'   => 'El receptor no existe en la base de datos.',
            'contenido.required'   => 'El contenido del mensaje es obligatorio.',
            'archivo.string'       => 'El archivo debe ser un texto válido (ej. URL o ruta).',
            'archivo.max'          => 'El archivo no puede superar los 255 caracteres.',
            'leido.boolean'        => 'El campo leído debe ser verdadero o falso.',
        ];
    }
}
