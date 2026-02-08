<?php

namespace App\Helpers;

class Helper
{
    public static function colorPorEstado($estado)
    {
        return match ($estado) {
            'pendiente' => '#f3c623',
            'confirmada' => '#28a745',
            'rechazada' => '#dc3545',
            'cancelada' => '#170a61',
            'bloqueada' => '#6c757d',
            default => '#6c757d'
        };
    }
}
