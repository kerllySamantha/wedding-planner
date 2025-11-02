<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            // 'password' => [
            //     'required',
            //     'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/'
            // ],
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
            'rol' => 'required|string|exists:roles,name',


        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo del nombre es obligatorio',
            'name.string' => 'El nombre no debe ser numerico. ',

            'email.required' => 'El email es obligatorio',
            'email.email' => 'El campo debe de tener formato de email',

            'password.required' => 'El campo de la contraseña es obligatorio',
            // 'password' => 'La contraseña debe tener mínimo 8 caracteres, incluir mayúsculas, minúsculas, números y símbolos.',
        ];
    }
}