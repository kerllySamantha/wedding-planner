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
            'id' => $this->id,

            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'estado' => $this->estado,
            'origen' => $this->origen,
            'notas' => $this->notas,

            'usuario' => $this->usuario ? [
                'id' => $this->usuario->id,
                'nombre' => $this->usuario->name,
            ] : null,

            'empresa' => [
                'id' => $this->empresa->id,
                'nombre' => $this->empresa->nombre_empresa
            ],

            'boda' => $this->boda ? [
                'id' => $this->boda->id,
                'nombre_pareja' => $this->boda->nombre_pareja,
                'fecha' => $this->boda->fecha,
                'ubicacion' => $this->boda->ubicacion,
                'usuario_id' => $this->boda->user_id,
            ] : null,
            'tipo_reserva' => $this->tipo_reserva,

            // 'servicio' => $this->servicio ? [
            //     'id' => $this->servicio->id,
            //     'nombre' => $this->servicio->nombre
            // ] : null,
            'producto' => $this->producto ? [
                'id' => $this->producto->id,
                'nombre' => $this->producto->nombre,
                'categoria' => $this->producto->tipoProducto->categoria->nombre ?? "",
                'tipo_producto' => $this->producto->tipoProducto->nombre ?? "",
                // 'modalidad' => $this->producto->tipoProducto->modalidad ?? "",
            ] : null,
            
            


        ];
    }
}
