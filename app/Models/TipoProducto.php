<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model

{
    // use HasFactory;
    
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }


    public function productos(){
        return $this->hasMany(Producto::class);
    }

    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class);
    }
}
