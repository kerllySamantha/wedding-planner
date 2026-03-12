<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
private $fillable = ['user_id', 'mensaje', 'titulo', 'tipo', 'referencia_id'];

public function user(){
    return $this->belongsTo(User::class);
}
}
