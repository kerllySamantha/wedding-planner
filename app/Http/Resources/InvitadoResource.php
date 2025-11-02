<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvitadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'boda' => [
                'id' => $this->boda->id,
                'nombre_pareja ' => $this->boda->nombre_pareja,
                'fecha_boda '    => $this->boda->fecha_boda,
                'ubicacion '     => $this->boda->ubicacion
            ],
            'usuario' => new UserResource($this->user)
        ];
    }
}