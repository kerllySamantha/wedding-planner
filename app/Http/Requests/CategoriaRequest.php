<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->slug ?? $this->nombre),
        ]);
    }

    public function rules(): array
    {
        $categoria = $this->route('categoria');
        $categoriaId = is_object($categoria) ? $categoria->id : $this->id;

        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'icono' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categorias,slug,' . $categoriaId,
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
            'descripcion.string' => 'La descripcion debe ser una cadena de texto.',
            'descripcion.max' => 'La descripcion no puede superar los 1000 caracteres.',
        ];
    }
}
