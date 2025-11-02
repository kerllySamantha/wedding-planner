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
            'presupuesto_total' => $this->presupuesto_total,
            'notas' => $this->notas,
            'fotos' => $fotos
        ];


    }
}