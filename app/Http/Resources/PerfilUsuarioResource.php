<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerfilUsuarioResource extends JsonResource
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
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'fecha_boda' => $this->fecha_boda,
            'usuario' => new UserResource($this->user),
            'poblacion' => [
                'nombre' => $this->poblacion->nombre ?? "",
                'id' => $this->poblacion->id ?? "",
            ],
            'provincia' => [
                'nombre' => $this->poblacion->provincia->nombre ?? "",
                'id' => $this->poblacion->provincia->id ?? "",
            ],
        ];
    }
}
