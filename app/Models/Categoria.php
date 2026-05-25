<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'icono',
        'descripcion',
        'slug',
    ];

    // public function empresas(){
    //     return $this->hasMany(Empresa::class);
    // }

    public function tipoProducto()
    {
        return $this->hasMany(TipoProducto::class);
    }
}
