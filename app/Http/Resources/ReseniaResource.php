<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReseniaResource extends JsonResource
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
            'comentario' => $this->comentario,
            'puntuacion' => $this->puntuacion,
            'fotos' => $fotosConUrl,
            'usuario' => [
                'id' => $this->usuario->id,
                'name' => $this->usuario->name,
            ],
            'empresa' => [
                'id' => $this->empresa->id,
                'nombre' => $this->empresa->nombre_empresa,
            ],
        ];
    }
}