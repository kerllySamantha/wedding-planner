<?php

namespace App;

enum EstadoPedirPresupuesto: string
{
    case PENDIENTE = 'pendiente';
    case PENDIENTE_USUARIO = 'pendiente_usuario';
    case ACEPTADO_EMPRESA = 'aceptado_empresa';
    case ACEPTADO_USUARIO = 'aceptado_usuario';
    case RECHAZADO_EMPRESA = 'rechazado_empresa';
    case RECHAZADO_USUARIO = 'rechazado_usuario';
}
