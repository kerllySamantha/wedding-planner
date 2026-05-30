<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\Empresa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservasJavierBodaSeeder extends Seeder
{
    public function run(): void
    {
        $javier = User::where('email', 'javier@example.com')->first();
        if (!$javier) {
            $this->command->warn('No se encontró javier@example.com.');
            return;
        }

        $boda = Boda::where('usuario_id', $javier->id)->first();
        if (!$boda) {
            $this->command->warn('No se encontró la boda de Javier.');
            return;
        }

        $catering = Empresa::where('nombre_empresa', 'Catering La Alhambra')->first();
        $fotografia = Empresa::where('nombre_empresa', 'Fotografía Segovia')->first();

        if ($catering) {
            $producto = $catering->productos()->first();
            DB::table('reservas')->insert([
                'user_id'      => $javier->id,
                'empresa_id'   => $catering->id,
                'producto_id'  => $producto?->id,
                'boda_id'      => $boda->id,
                'fecha_inicio' => Carbon::create(2024, 9, 15, 13, 0, 0),
                'fecha_fin'    => Carbon::create(2024, 9, 15, 23, 0, 0),
                'tipo_reserva' => 'servicio',
                'estado'       => 'confirmada',
                'origen'       => 'usuario',
                'all_day'      => false,
                'notas'        => 'Catering completo para boda — 10 horas.',
                'created_at'   => Carbon::create(2024, 2, 5),
                'updated_at'   => Carbon::create(2024, 2, 5),
            ]);
        }

        if ($fotografia) {
            $producto = $fotografia->productos()->first();
            DB::table('reservas')->insert([
                'user_id'      => $javier->id,
                'empresa_id'   => $fotografia->id,
                'producto_id'  => $producto?->id,
                'boda_id'      => $boda->id,
                'fecha_inicio' => Carbon::create(2024, 9, 15, 11, 0, 0),
                'fecha_fin'    => Carbon::create(2024, 9, 15, 21, 0, 0),
                'tipo_reserva' => 'servicio',
                'estado'       => 'confirmada',
                'origen'       => 'usuario',
                'all_day'      => false,
                'notas'        => 'Reportaje fotográfico completo de boda.',
                'created_at'   => Carbon::create(2024, 2, 5),
                'updated_at'   => Carbon::create(2024, 2, 5),
            ]);
        }

        $this->command->info("Reservas confirmadas de Javier creadas (Catering La Alhambra + Fotografía Segovia).");
    }
}
