<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boda extends Model
{
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function invitados()
    {
        return $this->hasMany(Invitado::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function poblacion()
    {
        return $this->belongsTo(Poblacion::class, 'poblacion_id');
    }

    public function tareas()
    {
        return   $this->hasMany(Tarea::class, 'id', 'boda_id');
    }

    public function presupuesto()
    {
        return  $this->hasMany(Presupuesto::class);
    }
}
