<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MensajeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'emisor' => [
                'id' =>  $this->emisor->id,
                'nombre' =>  $this->emisor->name,
                'rol' => $this->emisor->getRoleNames()->first(),
            ],
            'receptor' => [
                'id' => $this->receptor->id,
                'nombre' =>  $this->receptor->name,
                'rol' => $this->emisor->getRoleNames()->first(),
            ],
            'contenido' => $this->contenido,
            'archivo' => $this->archivo,
            'leido' => $this->leido
        ];
    }
}
