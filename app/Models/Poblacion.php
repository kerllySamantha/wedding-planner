<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poblacion extends Model
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    protected $table = 'poblaciones';

    public function provincia() {
        return $this->belongsTo(Provincia::class, 'id_provincia');
    }


    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'poblacion_id', 'id');

    }

     public function perfiles()
    {
        return $this->hasMany(PerfilUsuario::class, 'poblacion_id', 'id');

    }
}