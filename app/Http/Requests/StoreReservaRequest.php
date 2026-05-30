<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'              => 'nullable|exists:users,id',
            'empresa_id'           => 'required|exists:empresas,id',
            'boda_id'              => 'nullable|exists:bodas,id',
            'pedir_presupuesto_id' => 'nullable|exists:pedir_presupuestos,id',
            'fecha_inicio'         => 'required|date',
            'fecha_fin'            => 'nullable|date|after_or_equal:fecha_inicio',
            'estado'               => 'required|in:pendiente,confirmada,cancelada,bloqueada',
            'origen'               => 'nullable|in:usuario,proveedor',
            'notas'                => 'nullable|string',
            'servicio_id'          => 'nullable|exists:servicios,id',
            'producto_id'          => 'nullable|exists:productos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'empresa_id.required'      => 'Debe indicarse un proveedor.',
            'empresa_id.exists'        => 'El proveedor indicado no existe.',
            'fecha_inicio.required'    => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date'        => 'La fecha de inicio no tiene un formato válido.',
            'fecha_fin.date'           => 'La fecha de fin no tiene un formato válido.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'estado.required'          => 'El estado de la reserva es obligatorio.',
            'estado.in'                => 'El estado no es válido. Valores permitidos: pendiente, confirmada, cancelada, bloqueada.',
            'origen.in'                => 'El origen no es válido. Valores permitidos: usuario, proveedor.',
            'user_id.exists'           => 'El usuario indicado no existe.',
            'boda_id.exists'           => 'La boda indicada no existe.',
        ];
    }
}
