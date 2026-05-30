<?php

namespace App\Console\Commands;

use App\Events\NuevaNotificacion;
use App\Mail\ReseniasDisponiblesEmail;
use App\Models\Boda;
use App\Models\Notificacion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class NotificarReseniasPostBoda extends Command
{
    protected $signature = 'resenias:notificar-post-boda';
    protected $description = 'Notifica a los usuarios cuya boda acaba de pasar que pueden dejar reseñas';

    public function handle()
    {
        // Bodas cuya fecha fue ayer (acabaron de pasar)
        $bodas = Boda::whereDate('fecha_boda', Carbon::yesterday()->toDateString())
            ->with(['usuario', 'reservas.empresa'])
            ->get();

        $enviados = 0;

        foreach ($bodas as $boda) {
            $usuario = $boda->usuario;
            if (!$usuario) continue;

            // Evitar notificar dos veces
            $yaNotificado = Notificacion::where('user_id', $usuario->id)
                ->where('tipo', 'resenias_disponibles')
                ->whereDate('created_at', today())
                ->exists();

            if ($yaNotificado) continue;

            // Empresas que participaron (reservas de esta boda)
            $empresas = $boda->reservas
                ->pluck('empresa')
                ->filter()
                ->unique('id')
                ->values();

            if ($empresas->isEmpty()) continue;

            // Notificación in-app
            $notif = Notificacion::create([
                'user_id'         => $usuario->id,
                'tipo'            => 'resenias_disponibles',
                'titulo'          => '¡Valora a tus proveedores!',
                'mensaje'         => 'Tu boda ya ha pasado. Puedes dejar reseñas a los ' . $empresas->count() . ' proveedor(es) que participaron.',
                'referencia_id'   => $boda->id,
                'referencia_type' => Boda::class,
            ]);

            broadcast(new NuevaNotificacion($notif));

            // Correo electrónico
            if ($usuario->email) {
                Mail::to($usuario->email)->send(new ReseniasDisponiblesEmail($usuario, $empresas));
            }

            $enviados++;
        }

        $this->info("Notificaciones post-boda enviadas: {$enviados}");
    }
}
