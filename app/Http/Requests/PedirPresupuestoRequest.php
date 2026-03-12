<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedirPresupuestoRequest extends FormRequest
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
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
            'boda_id' => 'nullable|exists:bodas,id',
            'fecha' => 'nullable|date|after:today',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'mensaje' => 'required|string|max:600',
            'email' => 'required|email|max:250',
            'invitados' => 'required|integer',
            'presupuesto' => 'required|numeric|decimal:0,2'
        ];
    }

    public function messages(): array
    {
        return [
            'empresa_id.required' => 'La empresa es obligatoria.',
            'empresa_id.exists' => 'La empresa no existe.',
            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.exists' => 'El usuario no existe.',
            'boda_id.exists' => 'La boda no existe.',
            'fecha.date' => 'La fecha no es valida.',
            'fecha.after' => 'La fecha debe ser futura.',
            'mensaje.required' => 'Debes escribir un mensaje.',
            'nombre.required' => 'El nombre es obligatorio.',
            'telefono.required' => 'El telefono es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es valido.',
        ];
    }
}
