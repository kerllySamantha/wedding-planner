<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends Model
{
    
    use HasFactory;

    protected $fillable = ['usuario_id', 'direccion', 'telefono', 'fecha_boda', 'poblacion_id'];

    protected $casts = [
    'fecha_boda' => 'date',
];

    
    public function user(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

     public function poblacion(){
        return $this->belongsTo(Poblacion::class, 'poblacion_id');
    }
}
