<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resenia extends Model
{

    protected $casts = [
        'fotos' => 'array',
    ];

    
    function usuario(){
       return $this->belongsTo(User::class, 'user_id');
    }

    // function perfilusuario(){
    //     $this->belongsTo(PerfilUsuario::class);
    // }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}