<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    public function boda()
    {
        return $this->belongsTo(Boda::class, 'boda_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function perfil()
    {
        return $this->hasOneThrough(PerfilUsuario::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }
}
