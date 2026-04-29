<?php

namespace App\Http\Requests;

use App\Models\PedirPresupuesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResponderPedirPresupuestoRequest extends FormRequest
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
            'estado' => [
                'nullable',
                Rule::in([
                    PedirPresupuesto::ESTADO_ACEPTADO_EMPRESA,
                    PedirPresupuesto::ESTADO_RECHAZADO_EMPRESA,
                ]),
            ],
            'producto_id' => [
                'nullable',
                'integer',
                'exists:productos,id',
            ],
            'producto_personalizado_nombre' => [
                'nullable',
                'string',
                'max:255',
            ],
            'modalidad' => [
                'nullable',
                Rule::in(['producto', 'servicio', 'dia']),
            ],
            'fecha_inicio' => [
                'nullable',
                'date',
            ],
            'fecha_fin' => [
                'nullable',
                'date',
                'after:fecha_inicio',
            ],
            'importe_ofertado' => [
                'nullable',
                'numeric',
                'min:0',
                Rule::requiredIf(
                    $this->input('estado') !== PedirPresupuesto::ESTADO_RECHAZADO_EMPRESA
                ),
            ],
            'comentario_empresa' => 'nullable|string',
           
        ];
    }

    public function messages(): array
    {
        return [
            'estado.in' => 'El estado indicado no es valido para la respuesta de la empresa.',
            'producto_id.required' => 'El producto es obligatorio para la propuesta.',
            'producto_personalizado_nombre.max' => 'El nombre del producto personalizado no puede superar 255 caracteres.',
            'producto_id.exists' => 'El producto indicado no existe.',
            'modalidad.in' => 'La modalidad no es valida.',
            'fecha_inicio.date' => 'La fecha de inicio no es valida.',
            'fecha_fin.date' => 'La fecha de fin no es valida.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la de inicio.',
            'importe_ofertado.required' => 'El importe ofertado es obligatorio cuando la empresa acepta.',
            'importe_ofertado.numeric' => 'El importe ofertado debe ser numerico.',
            'importe_ofertado.min' => 'El importe ofertado no puede ser negativo.',
        ];
    }
}
