<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProvinciaResourse extends JsonResource
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
            'nombre' => $this->nombre,
            
            // 'poblaciones'  => $this->poblaciones->map(function ($poblaciones) {
            //     return [
            //         'id' => $poblaciones->id, 
            //         'nombre' => $poblaciones->nombre,
                     
            //     ];
            // })->unique('id')->values(),

        ];
        // return parent::toArray($request);
    }
}
