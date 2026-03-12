<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemDetallesResource extends JsonResource
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
            'presupuesto_id' => $this->presupuesto_id,
            'tipo_producto_id' => $this->tipo_producto_id,
            'nombre_tipo_personalizado' => $this->nombre_tipo_personalizado,
            'monto_estimado' => $this->monto_estimado,
            'monto_pagado' => $this->monto_pagado ?? 0,
            'diferencia' => ($this->monto_estimado ?? 0) - ($this->monto_pagado ?? 0),
            'es_personalizado' => $this->es_personalizado,
            'notas' => $this->notas,
        ];
    }
}
