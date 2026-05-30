<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'rol' => $this->getRoleNames()->first(),
            'fotoPerfil' => $this->fotoPerfil
                ? (str_starts_with($this->fotoPerfil, 'http') || str_starts_with($this->fotoPerfil, '/')
                    ? $this->fotoPerfil
                    : asset('storage/' . $this->fotoPerfil))
                : null,
        ];
    }
}
