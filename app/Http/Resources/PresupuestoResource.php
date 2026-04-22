<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresupuestoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'boda_id' => $this->boda_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'monto_total' => $this->monto_total,
            'monto_pagado' => $this->monto_pagado,
            'estado' => $this->estado,
            'fecha_creacion' => $this->fecha_creacion

        ];
    }
}
