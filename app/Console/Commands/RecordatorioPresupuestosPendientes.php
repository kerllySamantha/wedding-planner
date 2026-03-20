<?php

namespace App\Console\Commands;

use App\Events\NuevaNotificacion;
use App\Models\PedirPresupuesto;
use App\Models\Notificacion;
use Illuminate\Console\Command;
use Carbon\Carbon;

class RecordatorioPresupuestosPendientes extends Command
{
    protected $signature = 'recordatorio:presupuestos-pendientes';
    protected $description = 'Recuerda a las empresas responder presupuestos pendientes';

    public function handle()
    {
        $pendientes = PedirPresupuesto::where('estado', 'pendiente')
            ->where('created_at', '<=', Carbon::now()->subDays(2))
            ->with('empresa.usuario')
            ->get();

        foreach ($pendientes as $presupuesto) {
            $userId = $presupuesto->empresa?->user_id;
            if (!$userId) continue;

            $ya_notificado = Notificacion::where('user_id', $userId)
                ->where('tipo', 'presupuesto_pendiente')
                ->where('referencia_id', $presupuesto->id)
                ->whereDate('created_at', today())
                ->exists();

            if ($ya_notificado) continue;

            $notif = Notificacion::create([
                'user_id'         => $userId,
                'tipo'            => 'presupuesto_pendiente',
                'titulo'          => 'Presupuesto sin responder',
                'mensaje'         => "Tienes una solicitud de {$presupuesto->nombre} pendiente de respuesta.",
                'referencia_id'   => $presupuesto->id,
                'referencia_type' => PedirPresupuesto::class,
            ]);

            broadcast(new NuevaNotificacion($notif));
        }

        $this->info("Recordatorios de presupuestos enviados: {$pendientes->count()}");
    }
}