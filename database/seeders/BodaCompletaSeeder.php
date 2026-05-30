<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\PerfilUsuario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BodaCompletaSeeder extends Seeder
{
    public function run(): void
    {
       $password = 'Jglpdj*2125';

        $url = 'http://weddingplaner.local';

        // ── LAURA: boda terminada hace 3 días, sin reseñas ni fotos aún ──────────
        $fechaLaura = Carbon::now()->subDays(3)->format('Y-m-d');

        $laura = User::create([
            'name'     => 'Laura García',
            'email'    => 'laura@example.com',
            'password' => bcrypt($password),
        ]);
        $laura->assignRole('usuario');

        PerfilUsuario::create([
            'usuario_id'   => $laura->id,
            'telefono'     => '600111222',
            'direccion'    => 'Calle Mayor 25, Segovia',
            'poblacion_id' => 282,
            'fecha_boda'   => $fechaLaura,
        ]);

        Boda::create([
            'usuario_id'    => $laura->id,
            'nombre_pareja' => 'Laura & Marcos',
            'fecha_boda'    => $fechaLaura,
            'ubicacion'     => 'Segovia, España',
            'poblacion_id'  => 282,
            'notas'         => 'Boda recién celebrada. Pendiente subir fotos y dejar reseñas.',
            'fotos'         => json_encode([]),
        ]);

        $this->command->info("Creado laura@example.com — boda hace 3 días ({$fechaLaura}), sin reseñas ni fotos.");

        // ── SONIA: boda completada 2025-09-20 ────────────────────────────────────
        $sonia = User::create([
            'name'     => 'Sonia Valdés',
            'email'    => 'sonia@example.com',
            'password' => bcrypt($password),
        ]);
        $sonia->assignRole('usuario');

        PerfilUsuario::create([
            'usuario_id'   => $sonia->id,
            'telefono'     => '616219052',
            'direccion'    => 'Avenida de León, 25, Val de Ebo',
            'poblacion_id' => 162,
            'fecha_boda'   => '2025-09-20',
        ]);

        Boda::create([
            'usuario_id'    => $sonia->id,
            'nombre_pareja' => 'Sonia & Marcos',
            'fecha_boda'    => '2025-09-20',
            'ubicacion'     => 'Alicante, España',
            'poblacion_id'  => 147,
            'notas'         => 'Boda ya celebrada en Alicante.',
            'fotos'         => json_encode([
                ['path' => "imagenes/usuario_{$sonia->id}/imagen_1.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_1.jpg"],
                ['path' => "imagenes/usuario_{$sonia->id}/imagen_2.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_2.jpg"],
                ['path' => "imagenes/usuario_{$sonia->id}/imagen_3.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_3.jpg"],
                ['path' => "imagenes/usuario_{$sonia->id}/imagen_4.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_4.jpg"],
                ['path' => "imagenes/usuario_{$sonia->id}/imagen_5.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_5.jpg"],
                ['path' => "imagenes/usuario_{$sonia->id}/imagen_6.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_6.jpg"],
                ['path' => "imagenes/usuario_{$sonia->id}/imagen_7.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_7.jpg"],
            ]),
        ]);

        $this->command->info("Creado sonia@example.com (id={$sonia->id}) — boda completada 2025-09-20. Imágenes en imagenes/usuario_{$sonia->id}/");

        // ── CARMEN: boda completada 2025-04-10 ────────────────────────────────────
        $carmen = User::create([
            'name'     => 'Carmen LLorca',
            'email'    => 'carmen@example.com',
            'password' => bcrypt($password),
        ]);
        $carmen->assignRole('usuario');

        PerfilUsuario::create([
            'usuario_id'   => $carmen->id,
            'telefono'     => '622074029',
            'direccion'    => 'Plaza de España, 14, Murcia',
            'poblacion_id' => 365,
            'fecha_boda'   => '2025-04-10',
        ]);

        Boda::create([
            'usuario_id'    => $carmen->id,
            'nombre_pareja' => 'Carmen & Rafael',
            'fecha_boda'    => '2025-04-10',
            'ubicacion'     => 'Águilas, Murcia',
            'poblacion_id'  => 365,
            'notas'         => 'Boda ya celebrada en Águilas. Ceremonia en la playa.',
            'fotos'         => json_encode([
                ['path' => "imagenes/usuario_{$carmen->id}/imagen_1.jpg", 'url' => "$url/storage/imagenes/usuario_{$carmen->id}/imagen_1.jpg"],
                ['path' => "imagenes/usuario_{$carmen->id}/imagen_2.jpg", 'url' => "$url/storage/imagenes/usuario_{$carmen->id}/imagen_2.jpg"],
                ['path' => "imagenes/usuario_{$carmen->id}/imagen_3.jpg", 'url' => "$url/storage/imagenes/usuario_{$carmen->id}/imagen_3.jpg"],
                ['path' => "imagenes/usuario_{$carmen->id}/imagen_4.jpg", 'url' => "$url/storage/imagenes/usuario_{$carmen->id}/imagen_4.jpg"],
                ['path' => "imagenes/usuario_{$carmen->id}/imagen_5.jpg", 'url' => "$url/storage/imagenes/usuario_{$carmen->id}/imagen_5.jpg"],
                ['path' => "imagenes/usuario_{$carmen->id}/imagen_6.jpg", 'url' => "$url/storage/imagenes/usuario_{$carmen->id}/imagen_6.jpg"],
            ]),
        ]);

        $this->command->info("Creado carmen@example.com (id={$carmen->id}) — boda completada 2025-04-10. Imágenes en imagenes/usuario_{$carmen->id}/");
    }
}
