<?php

namespace App\Console\Commands;

use App\Events\NuevaNotificacion;
use App\Models\Boda;
use App\Models\Notificacion;
use Illuminate\Console\Command;
use Carbon\Carbon;

class RecordatorioBodaProxima extends Command
{
    protected $signature = 'recordatorio:boda-proxima';
    protected $description = 'Notifica cuando una boda está próxima';

    public function handle()
    {
        // Bodas en 7 días
       $bodas = Boda::whereDate('fecha_boda', Carbon::now()->addDays(7)->toDateString())
    ->with('usuario')
    ->get();

        foreach ($bodas as $boda) {
            $ya_notificado = Notificacion::where('user_id', $boda->user_id)
                ->where('tipo', 'boda_proxima')
                ->whereDate('created_at', today())
                ->exists();

            if ($ya_notificado) continue;

            $notif = Notificacion::create([
                'user_id'         => $boda->user_id,
                'tipo'            => 'boda_proxima',
                'titulo'          => '¡Tu boda es en 7 días!',
                'mensaje'         => 'Recuerda confirmar todos los detalles con tus proveedores.',
                'referencia_id'   => $boda->id,
                'referencia_type' => Boda::class,
            ]);

            broadcast(new NuevaNotificacion($notif));
        }

        $this->info("Recordatorios de boda enviados: {$bodas->count()}");
    }
}