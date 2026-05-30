<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePedirPresupuestoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'     => 'sometimes|required|string|max:255',
            'telefono'   => 'sometimes|required|string|max:20',
            'mensaje'    => 'sometimes|required|string|max:600',
            'email'      => 'sometimes|required|email|max:250',
            'invitados'  => 'sometimes|required|integer',
            'fecha'      => 'nullable|date|after:today',
            'presupuesto'=> 'nullable|numeric|decimal:0,2',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'    => 'El nombre es obligatorio.',
            'telefono.required'  => 'El teléfono es obligatorio.',
            'mensaje.required'   => 'El mensaje es obligatorio.',
            'mensaje.max'        => 'El mensaje no puede superar los 600 caracteres.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'El correo electrónico no tiene un formato válido.',
            'invitados.required' => 'El número de invitados es obligatorio.',
            'invitados.integer'  => 'El número de invitados debe ser un número entero.',
            'fecha.date'         => 'La fecha no tiene un formato válido.',
            'fecha.after'        => 'La fecha debe ser posterior a hoy.',
        ];
    }
}
