<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\Empresa;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;

class ReservaFotografiaSeeder extends Seeder
{
    public function run(): void
    {
        $empresa = Empresa::where('nombre_empresa', 'Fotografía Segovia')->first();

        if (!$empresa) {
            $this->command->warn('No se encontró "Fotografía Segovia". Ejecuta EmpresaSeeder primero.');
            return;
        }

        $bodas    = Boda::all();
        $productos = $empresa->productos()->get();

        if ($productos->isEmpty()) {
            $this->command->warn('Fotografía Segovia no tiene productos. Ejecuta ProductoSeeder primero.');
            return;
        }

        $notas = [
            'Reportaje de boda completo, ceremonia y banquete.',
            'Sesión fotográfica pre-boda en exteriores de Segovia.',
            'Cobertura fotográfica y vídeo del enlace civil.',
            'Fotografía artística para álbum de boda.',
            'Sesión de vídeo cinematográfico con edición highlight.',
            'Reportaje fotográfico + vídeo + álbum físico premium.',
            'Cobertura 12 horas con segundo fotógrafo incluido.',
            'Pack completo: fotos HD + vídeo + drone aéreo.',
            'Sesión trash the dress post-boda en Alcázar de Segovia.',
            'Reportaje de preboda en el casco histórico.',
            'Cobertura religiosa en Catedral de Segovia.',
            'Vídeo emocional con testimonios de invitados.',
        ];

        $reservas = [];
        $count    = 0;

        // 2025 y 2026 – todos los meses con carga variable (más en primavera/verano)
        $planificacion = [
            2025 => [
                1 => 2, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 5,
                7 => 5, 8 => 4, 9 => 4, 10 => 3, 11 => 2, 12 => 2,
            ],
            2026 => [
                1 => 2, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 5,
                7 => 5, 8 => 4, 9 => 4, 10 => 3, 11 => 2, 12 => 2,
            ],
        ];

        foreach ($planificacion as $año => $meses) {
            foreach ($meses as $mes => $cantidad) {
                for ($i = 0; $i < $cantidad; $i++) {
                    $diasDelMes = Carbon::create($año, $mes)->daysInMonth;

                    // Sábados preferidos para bodas; resto de días para sesiones previas
                    $esBoda   = rand(0, 9) < 7; // 70% bodas en sábado
                    $fecha    = Carbon::create($año, $mes, rand(1, $diasDelMes));
                    if ($esBoda) {
                        // Desplazar al sábado más próximo del mes
                        $dia = rand(1, 4) * 7 - (6 - Carbon::create($año, $mes, 1)->dayOfWeek);
                        $dia = max(1, min($diasDelMes, $dia + rand(-1, 1)));
                        $fecha = Carbon::create($año, $mes, $dia);
                    }

                    $horaInicio    = $esBoda ? rand(10, 13) : rand(9, 16);
                    $duracionHoras = $esBoda ? rand(8, 12)  : rand(2, 5);

                    $fechaInicio = $fecha->copy()->setTime($horaInicio, 0, 0);
                    $fechaFin    = $fechaInicio->copy()->addHours($duracionHoras);

                    // Reserva creada entre 1 y 8 meses antes de la boda
                    $creadaEn = $fechaInicio->copy()->subDays(rand(30, 240));

                    $estado = $this->estadoPonderado($año, $mes);

                    $reservas[] = [
                        'user_id'    => $empresa->user_id,
                        'empresa_id' => $empresa->id,
                        'producto_id' => $productos->random()->id,
                        'boda_id'    => $bodas->isNotEmpty() ? $bodas->random()->id : null,
                        'fecha_inicio' => $fechaInicio,
                        'fecha_fin'    => $fechaFin,
                        'tipo_reserva' => 'servicio',
                        'estado'       => $estado,
                        'origen'       => rand(0, 2) === 0 ? 'proveedor' : 'usuario',
                        'all_day'      => false,
                        'notas'        => $notas[array_rand($notas)],
                        'created_at'   => $creadaEn,
                        'updated_at'   => $creadaEn,
                    ];

                    $count++;
                }
            }
        }

        DB::table('reservas')->insert($reservas);
        $this->command->info("Creadas {$count} reservas para Fotografía Segovia (2025–2026).");
    }

    /**
     * Distribución de estados: pasado → más confirmadas/canceladas;
     * futuro → más pendientes y confirmadas.
     */
    private function estadoPonderado(int $año, int $mes): string
    {
        $esPasado = Carbon::create($año, $mes)->isPast();

        $pesos = $esPasado
            ? ['confirmada' => 55, 'cancelada' => 20, 'rechazada' => 15, 'pendiente' => 10]
            : ['confirmada' => 45, 'pendiente'  => 35, 'cancelada' => 12, 'rechazada' => 8];

        $total = array_sum($pesos);
        $rand  = rand(1, $total);
        $acum  = 0;

        foreach ($pesos as $estado => $peso) {
            $acum += $peso;
            if ($rand <= $acum) {
                return $estado;
            }
        }

        return 'confirmada';
    }
}
