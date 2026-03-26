<?php

namespace App\Console\Commands;

use App\Models\PedirPresupuesto;
use App\Models\Reserva;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpirarReservasHold extends Command
{
    protected $signature = 'reservas:expirar-holds';
    protected $description = 'Expira reservas bloqueadas cuyo hold ha vencido';

    public function handle()
    {
        $now = now();

        $expiradas = Reserva::where('estado', 'bloqueada')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', $now)
            ->pluck('id');

        if ($expiradas->isEmpty()) {
            $this->info('No hay reservas expiradas.');
            return 0;
        }

        DB::transaction(function () use ($expiradas, $now) {
            Reserva::whereIn('id', $expiradas)->update([
                'estado' => 'cancelada',
                'updated_at' => $now,
            ]);

            PedirPresupuesto::whereIn('reserva_id', $expiradas)->update([
                'reserva_id' => null,
                'updated_at' => $now,
            ]);
        });

        $this->info("Reservas expiradas: {$expiradas->count()}");

        return 0;
    }
}
