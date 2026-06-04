<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTareaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'      => 'sometimes|required|string|max:200',
            'descripcion' => 'sometimes|nullable|string|max:1000',
            'fecha_limite' => 'sometimes|nullable|date',
            'completada'  => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'   => 'El título de la tarea es obligatorio.',
            'titulo.max'        => 'El título no puede superar 200 caracteres.',
            'descripcion.max'   => 'La descripción no puede superar 1000 caracteres.',
            'fecha_limite.date' => 'La fecha límite no tiene un formato válido.',
        ];
    }
}
