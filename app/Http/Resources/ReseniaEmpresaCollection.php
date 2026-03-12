<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReseniaEmpresaCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        $total = $this->collection->count();
        $grouped = $this->collection->groupBy('puntuacion');

        $porcentaje = function ($rating) use ($grouped, $total) {
            if ($total === 0) {
                return 0;
            }

            $cantidad = $grouped->get($rating)?->count() ?? 0;
            return round(($cantidad / $total) * 100, 1);
        };

        return [
            'estadisticas' => [
                'promedio' => $total > 0
                    ? round($this->collection->avg('puntuacion'), 1)
                    : 0,

                'total' => $total,

                'estrellas' => [
                    5 => [
                        'rating' => 5,
                        'total' => $grouped->get(5)?->count() ?? 0,
                        'porcentaje' => $porcentaje(5)
                    ],
                    4 => [
                        'rating' => 4,
                        'total' => $grouped->get(4)?->count() ?? 0,
                        'porcentaje' => $porcentaje(4)
                    ],
                    3 => [
                        'rating' => 3,
                        'total' => $grouped->get(3)?->count() ?? 0,
                        'porcentaje' => $porcentaje(3)
                    ],
                    2 => [
                        'rating' => 2,
                        'total' => $grouped->get(2)?->count() ?? 0,
                        'porcentaje' => $porcentaje(2)
                    ],
                    1 => [
                        'rating' => 1,
                        'total' => $grouped->get(1)?->count() ?? 0,
                        'porcentaje' => $porcentaje(1)
                    ],
                ],
            ],

            'data' => $this->collection,

            'links' => [
                'next' => $this->nextPageUrl(),
                'prev' => $this->previousPageUrl(),
            ]
        ];
    }
}