<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'estado'       => 'sometimes|required|in:pendiente,confirmada,cancelada,bloqueada',
            'origen'       => 'nullable|in:usuario,proveedor',
            'notas'        => 'nullable|string',
            'servicio_id'  => 'nullable|exists:servicios,id',
            'producto_id'  => 'nullable|exists:productos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_inicio.required'    => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date'        => 'La fecha de inicio no tiene un formato válido.',
            'fecha_fin.date'           => 'La fecha de fin no tiene un formato válido.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'estado.required'          => 'El estado de la reserva es obligatorio.',
            'estado.in'                => 'El estado no es válido. Valores permitidos: pendiente, confirmada, cancelada, bloqueada.',
            'origen.in'                => 'El origen no es válido. Valores permitidos: usuario, proveedor.',
        ];
    }
}
