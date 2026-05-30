<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotaBodaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'boda_id'   => 'required|exists:bodas,id',
            'titulo'    => 'nullable|string|max:150',
            'contenido' => 'required|string|max:1000',
            'categoria' => 'required|string|in:flores,musica,decoracion,catering,vestido,otros',
        ];
    }

    public function messages(): array
    {
        return [
            'boda_id.required'   => 'El campo boda es obligatorio.',
            'boda_id.exists'     => 'La boda indicada no existe.',
            'titulo.max'         => 'El título no puede superar 150 caracteres.',
            'contenido.required' => 'El contenido de la nota es obligatorio.',
            'contenido.max'      => 'El contenido no puede superar 1000 caracteres.',
            'categoria.required' => 'La categoría es obligatoria.',
            'categoria.in'       => 'La categoría no es válida.',
        ];
    }
}
