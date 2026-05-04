<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BodaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fotos = is_array($this->fotos)
            ? $this->fotos
            : (json_decode($this->fotos, true) ?? []);

        $fotosConUrl = collect($fotos)->map(function ($foto) {
            if (is_array($foto)) {
                return $foto;
            }

            return [
                'path' => $foto,
                'url' => asset('storage/' . $foto),
            ];
        });

        return [
            'id' => $this->id,
            'nombre_pareja' => $this->nombre_pareja,
            'fecha_boda' => $this->fecha_boda,
            'ubicacion' => $this->ubicacion,
            'poblacion' => [
                'nombre' => $this->poblacion ? $this->poblacion->nombre : "",
                'id' => $this->poblacion ? $this->poblacion->id : ""
            ],
            'provincia' => [
                'nombre' => $this->poblacion ? $this->poblacion->provincia->nombre : "",
                'id' =>  $this->poblacion ? $this->poblacion->provincia->id : "",
            ],
            'usuario' => new UserResource($this->usuario),
            // 'presupuesto_total' => $this->presupuesto_total,
            'notas' => $this->notas,
            'presupuestos' => $this->presupuesto->map(
                fn($tipo) => [
                    'id' => $tipo->id,
                    'tipo' => [
                        'id' => $tipo->tipoProducto->id,
                        'nombre' => $tipo->tipoProducto->nombre,
                    ],
                    // 'nombre' => $tipo->nombre,
                    // 'descripcion' => $tipo->descripcion,
                    'monto_total' => (float) $tipo->monto_total,
                    'estado' =>  $tipo->estado,
                    'monto_pagado' => (float) $tipo->monto_pagado,
                    'fecha_creacion' => $tipo->fecha_creacion
                ]
            ),
            'resumen_presupuesto' => [
                'total_estimado' => (float) $this->presupuesto->sum('monto_total'),
                'total_pagado' => (float) $this->presupuesto->sum('monto_pagado'),
                'pendiente_pago' => (float) max(
                    0,
                    $this->presupuesto->sum('monto_total') - $this->presupuesto->sum('monto_pagado')
                ),
            ],
            'proveedores' => $this->reservas
                ->filter(fn($reserva) => !is_null($reserva->empresa))
                ->map(fn($reserva) => [
                    'reserva_id' => $reserva->id,
                    'empresa_id' => $reserva->empresa->id,
                    'nombre' => $reserva->empresa->nombre_empresa,
                    'estado_reserva' => $reserva->estado,
                    'tipo_reserva' => $reserva->tipo_reserva,
                ])
                ->unique('empresa_id')
                ->values(),

            'fotos' => $fotos
        ];
    }
}
