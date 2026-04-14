<?php

namespace App\Http\Requests;

use App\Models\Producto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'tipo_producto_id' => [
                'required',
                'integer',
                Rule::exists('tipo_productos', 'id'),
                function ($attribute, $value, $fail) {
                    $empresaId = $this->input('empresa_id');
                    if (!$empresaId) {
                        return;
                    }

                    $existeEnCatalogo = Producto::where('empresa_id', $empresaId)
                        ->where('tipo_producto_id', $value)
                        ->exists();

                    if (!$existeEnCatalogo) {
                        $fail('El proveedor no tiene productos de ese tipo.');
                    }
                },
            ],
            'user_id' => 'required|exists:users,id',
            'boda_id' => 'nullable|exists:bodas,id',
            'fecha' => 'nullable|date|after:today',
            'fecha_boda' => 'nullable|date|after:today',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'mensaje' => 'required|string|max:600',
            'email' => 'required|email|max:250',
            'invitados' => 'required|integer',
            'presupuesto' => 'required_without:presupuesto_estimado|numeric|decimal:0,2',
            'presupuesto_estimado' => 'required_without:presupuesto|numeric|decimal:0,2',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'fecha' => $this->input('fecha', $this->input('fecha_boda')),
            'presupuesto' => $this->input('presupuesto', $this->input('presupuesto_estimado')),
        ]);
    }

    public function messages(): array
    {
        return [
            'empresa_id.required' => 'La empresa es obligatoria.',
            'empresa_id.exists' => 'La empresa no existe.',
            'tipo_producto_id.required' => 'El tipo de producto es obligatorio.',
            'tipo_producto_id.exists' => 'El tipo de producto no existe.',
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
