<?php

namespace App\Support;

use App\Events\NuevaNotificacion;
use App\Models\Notificacion;

class NotificacionHelper
{
    public static function crear(
        int $userId,
        string $tipo,
        string $titulo,
        string $mensaje,
        ?object $referencia = null
    ): Notificacion {
        $notificacion = Notificacion::create([
            'user_id' => $userId,
            'tipo' => $tipo,
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'referencia_id' => $referencia?->id,
            'referencia_type' => $referencia ? $referencia::class : null,
        ]);

        $notificacion->load('referencia');
        broadcast(new NuevaNotificacion($notificacion));

        return $notificacion;
    }
}
