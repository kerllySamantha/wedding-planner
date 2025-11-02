<?php

namespace App\Http\Resources;

use App\Models\Poblacion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PoblacionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' =>  PoblacionResourse::collection($this->collection)
        ];
    }
}
