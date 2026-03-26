<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedirPresupuesto extends Model
{
    use HasFactory;

    public const ESTADO_PENDIENTE = 'pendiente';
    public const ESTADO_ACEPTADO_EMPRESA = 'aceptado_empresa';
    public const ESTADO_RECHAZADO_EMPRESA = 'rechazado_empresa';
    public const ESTADO_PENDIENTE_USUARIO = 'pendiente_usuario';
    public const ESTADO_ACEPTADO_USUARIO = 'aceptado_usuario';
    public const ESTADO_RECHAZADO_USUARIO = 'rechazado_usuario';

    protected $table = 'pedir_presupuestos';

    protected $fillable = [
        'empresa_id',
        'tipo_producto_id',
        'boda_id',
        'user_id',
        'reserva_id',
        'producto_id',
        'modalidad',
        'fecha',
        'fecha_inicio',
        'fecha_fin',
        'nombre',
        'telefono',
        'mensaje',
        'email',
        'estado',
        'importe_ofertado',
        'comentario_empresa',
        'fecha_respuesta',
        'invitados',
        'presupuesto'
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'fecha_respuesta' => 'datetime',
        'importe_ofertado' => 'decimal:2',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'tipo_producto_id');
    }

    public function boda()
    {
        return $this->belongsTo(Boda::class, 'boda_id');
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
