<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends Model
{

    protected $fillable = ['usuario_id', 'direccion', 'telefono'];

    
    public function user(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
