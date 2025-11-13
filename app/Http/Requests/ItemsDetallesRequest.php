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
            'categoria_id' => 'required|integer|exists:categorias,id',
            'tipo_producto_id' => 'required|integer|exists:tipo_productos,id',
            'nombre_categoria_personalizada' => 'nullable|string',
            'nombre_tipo_personalizado' => 'nullable|string',
            'precio_unitario' => 'nullable|numeric',
            'cantidad' => 'nullable|integer',
            'total_item' => 'numeric',
            'es_personalizado' => 'boolean',
            'notas' => 'nullable|string'
        ];
    }

    public function messages(): array {
        return [
            'presupuesto_id.required' => 'El ID del presupuesto es obligatorio.',
            'presupuesto_id.integer' => 'El ID del presupuesto debe ser un número entero.',
            'presupuesto_id.exists' => 'El presupuesto seleccionado no existe.',

            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.integer' => 'El ID de la categoría debe ser un número entero.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',

            'tipo_producto_id.required' => 'El tipo de producto es obligatorio.',
            'tipo_producto_id.integer' => 'El ID del tipo de producto debe ser un número entero.',
            'tipo_producto_id.exists' => 'El tipo de producto seleccionado no existe.',

            'nombre_categoria_personalizada.string' => 'El nombre de la categoría personalizada debe ser un texto.',
            'nombre_tipo_personalizado.string' => 'El nombre del tipo personalizado debe ser un texto.',

            'precio_unitario.numeric' => 'El precio unitario debe ser un valor numérico.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'total_item.numeric' => 'El total del ítem debe ser un número.',

            'es_personalizado.boolean' => 'El campo "es personalizado" debe ser verdadero o falso.',

            'notas.string' => 'Las notas deben ser un texto.',
        ];
    }
}
