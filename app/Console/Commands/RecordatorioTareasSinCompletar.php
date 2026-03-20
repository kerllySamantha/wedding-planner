<?php

namespace App\Console\Commands;

use App\Events\NuevaNotificacion;
use App\Models\Presupuesto;
use App\Models\Notificacion;
use Illuminate\Console\Command;
use Carbon\Carbon;

class RecordatorioTareasSinCompletar extends Command
{
    protected $signature = 'recordatorio:tareas-pendientes';
    protected $description = 'Recuerda tareas/presupuestos sin completar';

    public function handle()
    {
       $presupuestos = Presupuesto::where('estado', '!=', 'confirmado')
    ->whereHas('boda', fn($q) => 
        $q->whereBetween('fecha_boda', [
            Carbon::now(),
            Carbon::now()->addDays(30)
        ])
    )
    ->with('boda.usuario')
    ->get();

        foreach ($presupuestos as $presupuesto) {
            $userId = $presupuesto->boda?->user_id;
            if (!$userId) continue;

            $notif = Notificacion::create([
                'user_id'         => $userId,
                'tipo'            => 'tarea_pendiente',
                'titulo'          => 'Tienes elementos sin confirmar',
                'mensaje'         => 'Tu boda está próxima y hay presupuestos pendientes de confirmar.',
                'referencia_id'   => $presupuesto->boda_id,
                'referencia_type' => \App\Models\Boda::class,
            ]);

            broadcast(new NuevaNotificacion($notif));
        }

        $this->info("Recordatorios de tareas enviados: {$presupuestos->count()}");
    }
}