<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificacionResource extends JsonResource
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
            'tipo' => $this->tipo,
            'titulo' => $this->titulo,
            'mensaje' => $this->mensaje,
            'leido' => $this->leido,
            'referencia_id' => $this->referencia_id,
            'referencia_type' => $this->referencia_type,
            'referencia' => $this->whenLoaded('referencia'),
            // 'created_at' => $this->created_at,
        ];
    }
}
