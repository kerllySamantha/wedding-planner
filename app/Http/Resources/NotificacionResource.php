<?php

namespace App\Http\Resources;

use App\Models\PedirPresupuesto;
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
        $referencia = $this->whenLoaded('referencia', function () {
            if ($this->referencia instanceof PedirPresupuesto) {
                return [
                    'id' => $this->referencia->id,
                    'importe_ofertado' => $this->referencia->importe_ofertado,
                    'estado' => $this->referencia->estado,
                    'producto_id' => $this->referencia->producto_id,
                    'modalidad' => $this->referencia->modalidad,
                    'fecha_inicio' => $this->referencia->fecha_inicio,
                    'fecha_fin' => $this->referencia->fecha_fin,
                ];
            }

            return $this->referencia;
        });

        return [
            'id' => $this->id,
            'tipo' => $this->tipo,
            'titulo' => $this->titulo,
            'mensaje' => $this->mensaje,
            'leido' => $this->leido,
            'referencia_id' => $this->referencia_id,
            'referencia_type' => $this->referencia_type,
            'referencia' => $referencia,
            // 'created_at' => $this->created_at,
        ];
    }
}
