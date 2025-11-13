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
            'categoria_id' => $this->categoria_id,
            'tipo_producto_id' => $this->tipo_producto_id,
            'nombre_categoria_personalizada' => $this->nombre_categoria_personalizada,
            'nombre_tipo_personalizado' => $this->nombre_tipo_personalizado,
            'precio_unitario' => $this->precio_unitario,
            'cantidad' => $this->cantidad,
            'total_item' => $this->total_item,
            'es_personalizado' => $this->es_personalizado,
            'notas' => $this->notas,
        ];;
    }
}
