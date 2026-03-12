<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemsDetallesRequest extends FormRequest
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
            'presupuesto_id' => 'required|integer|exists:presupuestos,id',
            'tipo_producto_id' => 'required|integer|exists:tipo_productos,id',
            'nombre_tipo_personalizado' => 'nullable|string|max:255',
            'monto_estimado' => 'required|numeric|min:0',
            'monto_pagado' => 'nullable|numeric|min:0|lte:monto_estimado',
            'es_personalizado' => 'boolean',
            'notas' => 'nullable|string'
        ];
    }

    public function messages(): array {
        return [
            'presupuesto_id.required' => 'El ID del presupuesto es obligatorio.',
            'presupuesto_id.integer' => 'El ID del presupuesto debe ser un numero entero.',
            'presupuesto_id.exists' => 'El presupuesto seleccionado no existe.',

            'tipo_producto_id.required' => 'El tipo de producto es obligatorio.',
            'tipo_producto_id.integer' => 'El ID del tipo de producto debe ser un numero entero.',
            'tipo_producto_id.exists' => 'El tipo de producto seleccionado no existe.',

            'nombre_tipo_personalizado.string' => 'El nombre del item debe ser un texto.',
            'nombre_tipo_personalizado.max' => 'El nombre del item no puede superar 255 caracteres.',

            'monto_estimado.required' => 'El monto estimado es obligatorio.',
            'monto_estimado.numeric' => 'El monto estimado debe ser un valor numerico.',
            'monto_estimado.min' => 'El monto estimado debe ser mayor o igual a 0.',

            'monto_pagado.numeric' => 'El monto pagado debe ser un valor numerico.',
            'monto_pagado.min' => 'El monto pagado debe ser mayor o igual a 0.',
            'monto_pagado.lte' => 'El monto pagado no puede superar el monto estimado.',

            'es_personalizado.boolean' => 'El campo "es personalizado" debe ser verdadero o falso.',

            'notas.string' => 'Las notas deben ser un texto.',
        ];
    }
}
