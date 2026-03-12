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
                'required',
                Rule::in([
                    PedirPresupuesto::ESTADO_ACEPTADO_EMPRESA,
                    PedirPresupuesto::ESTADO_RECHAZADO_EMPRESA,
                ]),
            ],
            'importe_ofertado' => [
                'nullable',
                'numeric',
                'min:0',
                Rule::requiredIf(
                    $this->input('estado') === PedirPresupuesto::ESTADO_ACEPTADO_EMPRESA
                ),
            ],
            'comentario_empresa' => 'nullable|string',
           
        ];
    }

    public function messages(): array
    {
        return [
            'estado.required' => 'El estado de la respuesta es obligatorio.',
            'estado.in' => 'El estado indicado no es valido para la respuesta de la empresa.',
            'importe_ofertado.required' => 'El importe ofertado es obligatorio cuando la empresa acepta.',
            'importe_ofertado.numeric' => 'El importe ofertado debe ser numerico.',
            'importe_ofertado.min' => 'El importe ofertado no puede ser negativo.',
        ];
    }
}
