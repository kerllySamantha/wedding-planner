<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
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
            'nombre_empresa' => $this->nombre_empresa,
            'direccion' => $this->direccion,
            'telefonono' => $this->telefono,
            'descripcion' => $this->descripcion,
            'tipo_servicio' => $this->tipo_servicio,
            'logo' => $this->logo,
            'poblacion' => [
                'nombre' => $this->poblacion->nombre ?? "",
                'id' => $this->poblacion->id ?? "",
            ],
            'provincia' => [
                'nombre' => $this->poblacion->provincia->nombre ?? "",
                'id' => $this->poblacion->provincia->id ?? "",
            ],
            'fotos' => $fotos,
            'usuario' => new UserResource($this->usuario),
            'productos' => $this->productos->map(fn($producto) => [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'precio_min' => $producto->precio_min,
                'precio_max' => $producto->precio_max,
                'tipo_producto' => [
                    'id' => $producto->tipoProducto->id,
                    'nombre' => $producto->tipoProducto->nombre,
                ],
                'categoria' => [
                    'id' => $producto->tipoProducto->categoria->id,
                    'nombre' => $producto->tipoProducto->categoria->nombre,
                ],
            ]),

        ];

        // 'categoria' => new CategoriaResource($this->categoria),
        // 'servicios' =>  $this->servicios ? $this->servicios->map(function ($servicio) {
        //     return new ServicioResource($servicio);
        // }) : [],



    }
}
