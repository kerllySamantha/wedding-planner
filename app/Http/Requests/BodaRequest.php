<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BodaRequest extends FormRequest
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
            'nombre_pareja' => 'required|string',
            'fecha_boda' => 'required|date|after_or_equal:today',
            'ubicacion' => 'required|string|max:255',
            'user_id' => 'nullable',
            'presupuesto_total' => 'nullable|numeric',
            'notas' => 'nullable|string',
            'fotos' => 'required|array',
            'fotos.*' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_pareja.required' => 'El nombre de la pareja es obligatorio.',
            'nombre_pareja.string' => 'Debe ser un string.',
            'ubicacion.required' => 'La ubicacion es obligatoria',
            'fecha_boda.required' => 'La fecha de la boda es obligatoria.',
            'fecha_boda.date' => 'La fecha debe ser válida.',
            'fecha_boda.after_or_equal' => 'La fecha de la boda debe ser igual o mayor a la actual.',
        ];
    }
}