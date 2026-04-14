<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ReservaRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'empresa_id' => 'required|exists:empresas,id',
            'boda_id' => 'nullable|exists:bodas,id',
            'pedir_presupuesto_id' => 'nullable|exists:pedir_presupuestos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:pendiente,confirmada,cancelada,bloqueada',
            'origen' => 'nullable|in:usuario,proveedor',
            'notas' => 'nullable|string',
            'servicio_id' => 'nullable|exists:servicios,id',
            'producto_id' => 'nullable|exists:productos,id',

        ];
    }

    public function messages(): array
    {
        return [
            // 'fecha.required' => 'La fecha es obligatoria',
            // 'estado.required' => 'El estado es obligatorio',
            'empresa_id.required' => 'Debe existir un proveedor asociado.',
            'fecha_inicio.required' => 'Debe elegir una fecha de inicio.',
            'fecha_fin.after_or_equal' => 'La fecha final debe ser mayor o igual a la fecha de inicio.',
            'estado.in' => 'El estado no es válido.',
        ];
    }
}
