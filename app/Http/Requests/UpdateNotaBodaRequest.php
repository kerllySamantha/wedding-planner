<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotaBodaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'    => 'sometimes|nullable|string|max:150',
            'contenido' => 'sometimes|required|string|max:1000',
            'categoria' => 'sometimes|required|string|in:flores,musica,decoracion,catering,vestido,otros',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.max'         => 'El título no puede superar 150 caracteres.',
            'contenido.required' => 'El contenido de la nota es obligatorio.',
            'contenido.max'      => 'El contenido no puede superar 1000 caracteres.',
            'categoria.required' => 'La categoría es obligatoria.',
            'categoria.in'       => 'La categoría no es válida.',
        ];
    }
}
