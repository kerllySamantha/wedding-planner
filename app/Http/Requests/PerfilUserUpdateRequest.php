<?php

namespace App\Http\Requests;

use App\Models\PerfilUsuario;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class PerfilUserUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [

            // Usuario
            'name' => 'required|string|max:255',
            'fotoPerfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(
                PerfilUsuario::find($this->route('perfile'))?->usuario_id
                ),
            ],

            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],

            'rol' => 'required|string|exists:roles,name',

            // Perfil
            'direccion' => 'required|string|max:255',

            'telefono' => 'required|string|max:20',

            'poblacion_id' => 'required|exists:poblaciones,id',

            'fecha_boda' => 'nullable|date|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [

            // Usuario
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes introducir un correo válido.',
            'email.unique' => 'Este correo ya está registrado.',

            'password.confirmed' => 'Las contraseñas no coinciden.',

            'rol.required' => 'Debes seleccionar un rol.',
            'rol.exists' => 'El rol seleccionado no es válido.',

            // Perfil
            'direccion.required' => 'La dirección es obligatoria.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',

            'poblacion_id.required' => 'Debes seleccionar una población.',
            'poblacion_id.exists' => 'La población seleccionada no es válida.',

            'fecha_boda.date' => 'La fecha de boda no es válida.',
            'fecha_boda.after_or_equal' => 'La fecha de boda no puede ser anterior a hoy.',
        ];
    }
}
