<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBodaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_pareja' => 'sometimes|required|string|max:255',
            'fecha_boda'    => 'sometimes|required|date|after:today',
            'ubicacion'     => 'sometimes|required|string|max:255',
            'notas'         => 'nullable|string',
            'poblacion_id'  => 'nullable|integer|exists:poblaciones,id',
            'fotos'         => 'nullable|array',
            'fotos.*'       => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_pareja.required' => 'El nombre de la pareja es obligatorio.',
            'fecha_boda.required'    => 'La fecha de la boda es obligatoria.',
            'fecha_boda.date'        => 'La fecha de la boda debe ser una fecha válida.',
            'fecha_boda.after'       => 'La fecha de la boda debe ser posterior a hoy.',
            'ubicacion.required'     => 'La ubicación es obligatoria.',
            'poblacion_id.exists'    => 'La población seleccionada no existe.',
        ];
    }
}
