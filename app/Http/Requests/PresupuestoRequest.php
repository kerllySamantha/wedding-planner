<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class PresupuestoRequest extends FormRequest
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
            'boda_id' => 'required|integer|exists:bodas,id',
            // 'nombre' => 'required|string',
            // 'descripcion' => 'nullable|string',
            'tipo_producto_id' => 'required|integer|exists:tipo_productos,id',
            'monto_total' => 'required|numeric',
            'estado' => 'boolean',
            'fecha_creacion' => 'required|date'
        ];
    }

    public function messages(): array
    {
        return [
            'boda.id.required' => 'El id de la boda es obligatoria',
            'boda_id.integer' => 'El id de la boda debe ser un número entero.',
            'boda_id.exists' => 'La boda seleccionada no existe.',
            // 'nombre.required' => 'El nombre es obligatorio',
            // 'nombre.string' => 'El campo debe ser un texto',
            // 'descripcion.string' => 'El campo debe ser un texto',
            // 'monto_total.required' => 'El montoo es obligatorio',
            'monto.total.numeric' => 'El campo debe ser un numero decimal',
            'estado.boolean' => 'El estado debe ser un booleano',
            'fecha_creacion.required' => 'La fecha de creación es obligatoria.',
            'fecha_creacion.date' => 'La fecha de creación debe tener un formato válido.'
        ];
    }
}
