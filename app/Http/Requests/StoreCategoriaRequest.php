<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCategoriaRequest extends FormRequest
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
        return [
            'nombre'     => 'required|string|max:255',
            'descripcion'=> 'nullable|string|max:1000',
            'icono'      => 'nullable|string|max:255',
            'icono_file' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'slug'       => 'nullable|string|max:255|unique:categorias,slug',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'     => 'El nombre de la categoría es obligatorio.',
            'nombre.string'       => 'El nombre debe ser texto.',
            'nombre.max'          => 'El nombre no puede superar los 255 caracteres.',
            'descripcion.string'  => 'La descripción debe ser texto.',
            'descripcion.max'     => 'La descripción no puede superar los 1000 caracteres.',
            'icono_file.mimes'    => 'El icono debe ser JPG, PNG, WEBP o SVG.',
            'icono_file.max'      => 'El icono no puede superar los 5 MB.',
            'slug.unique'         => 'Este identificador (slug) ya está en uso.',
        ];
    }
}
