<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'usuario' => [
                'id' => $this->usuario->id,
                'nombre' => $this->usuario->name
            ],
            'fecha' => $this->fecha,
            'estado' => $this->estado,
            'boda' => [
                'id' => $this->boda->id,
                'fecha' => $this->boda->fecha,
                'nombre_pareja' => $this->boda->nombre_pareja,
                'ubicacion' => $this->boda->ubicacion,
            ],
            'empresa' => [
                'id' => $this->empresa->id,
                'nombre_empresa' =>  $this->empresa->id
            ]
        ];
    }
}
