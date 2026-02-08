<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio_max' => $this->precio_max,
            'precio_min' => $this->precio_min,
            'empresa' => [
                'id' => $this->empresa->id,
                'nombre' => $this->empresa->nombre_empresa
            ],
            'tipo_producto' => [
                'id' => $this->tipoProducto->id,
                'nombre' => $this->tipoProducto->nombre,
                'modalidad' => $this->tipoProducto->modalidad,
            ],

        ];
    }
}
