<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvitadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'boda_id' => 'sometimes|required|exists:bodas,id',
            'user_id' => 'sometimes|required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'boda_id.required' => 'La boda es obligatoria.',
            'boda_id.exists'   => 'La boda indicada no existe.',
            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.exists'   => 'El usuario indicado no existe.',
        ];
    }
}
