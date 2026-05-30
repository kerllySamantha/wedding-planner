<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReseniaRequest extends FormRequest
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
            'user_id' => 'required',
            'empresa_id' => 'required',
            'puntuacion' => 'integer',
            'comentario' => 'string',
            'fotos' => 'nullable|array',
            'fotos.*' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Para realizar la reserva es necesario el id del usuario',
            // 'user_id.string' => 'El id del usuario para la reserva debe de ser un string',

            'empresa_id.required' => 'Para realizar la reserva es necesario el id de la empresa',
            // 'empresa_id.string' => 'El id de la empresa para la reserva debe de ser un string',

            // 'puntuacion.required' => 'La puntiacion es obligaro,'

            'puntucacion.integer' => 'La puntuacion debe ser un numero',

            'comentario.string' => 'El comentario debe de ser un string',
            // 'fotos.required' => 'Las fotos son obligatorias',
            // 'fotos.*.image' => 'Cada archivo debe ser una imagen válida.',
            // 'fotos.*.mimes' => 'Las imágenes deben ser jpeg, png, jpg o gif.',
            // 'fotos.*.max' => 'Cada imagen no puede superar los 2 MB.',

        ];
    }
}