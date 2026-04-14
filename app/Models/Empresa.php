<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_empresa',
        'direccion',
        'telefono',
        'descripcion',
        'logo',
        'fotos',
        'categoria_id',
        'user_id'
    ];
    
    function usuario() {
       return  $this->belongsTo(User::class, 'user_id');
    }

    // public function categoria()
    // {
    //     return $this->belongsTo(Categoria::class);
    // }

    public function resenias()
    {
        return $this->hasMany(Resenia::class);
    }

    public function reservas(){
        return $this->hasMany(Reserva::class, 'empresa_id');
    }

    public function poblacion()
    {
        return $this->belongsTo(Poblacion::class, 'poblacion_id');
    }

    // public function servicios()
    // {
    //     return $this->belongsToMany(Servicio::class, 'empresa_servicio');
    // }

    public function productos(){
        return $this->hasMany(Producto::class);
    }

    public function pedirPresupuestos()
    {
        return $this->hasMany(PedirPresupuesto::class, 'empresa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
