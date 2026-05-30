<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Resenia;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReseniaSeeder extends Seeder
{
    public function run(): void
    {
        $url = 'http://weddingplaner.local';

        $javier = User::where('email', 'javier@example.com')->first();
        $maria  = User::where('email', 'maria@example.com')->first();
        $sonia  = User::where('email', 'sonia@example.com')->first();
        $carmen = User::where('email', 'carmen@example.com')->first();

        $catering   = Empresa::where('nombre_empresa', 'Catering La Alhambra')->first();
        $fotografia = Empresa::where('nombre_empresa', 'Fotografía Segovia')->first();

        // ── JAVIER ───────────────────────────────────────────────────────────────
        if ($javier && $fotografia) {
            Resenia::create([
                'user_id'    => $javier->id,
                'empresa_id' => $fotografia->id,
                'comentario' => 'El servicio fue excelente, todo salió como esperaba. Las fotos quedaron increíbles.',
                'puntuacion' => 5,
                'fotos'      => json_encode([
                    ['path' => "imagenes/usuario_{$javier->id}/imagen_1.jpg", 'url' => "$url/storage/imagenes/usuario_{$javier->id}/imagen_1.jpg"],
                    ['path' => "imagenes/usuario_{$javier->id}/imagen_2.jpg", 'url' => "$url/storage/imagenes/usuario_{$javier->id}/imagen_2.jpg"],
                    ['path' => "imagenes/usuario_{$javier->id}/imagen_3.jpg", 'url' => "$url/storage/imagenes/usuario_{$javier->id}/imagen_3.jpg"],
                    ['path' => "imagenes/usuario_{$javier->id}/imagen_4.jpg", 'url' => "$url/storage/imagenes/usuario_{$javier->id}/imagen_4.jpg"],
                ]),
            ]);
        }

        if ($javier && $catering) {
            Resenia::create([
                'user_id'    => $javier->id,
                'empresa_id' => $catering->id,
                'comentario' => 'Nuestros invitados quedaron encantados con la comida, estaba todo buenísimo. El aperitivo lo hicimos en unos jardines sin ningún problema y luego fuimos a su salón a comer. Para nosotros salió todo perfecto. Sin duda los aconsejo.',
                'puntuacion' => 5,
            ]);
        }

        // ── MARÍA ────────────────────────────────────────────────────────────────
        if ($maria && $catering) {
            Resenia::create([
                'user_id'    => $maria->id,
                'empresa_id' => $catering->id,
                'comentario' => 'Buen trabajo, aunque tardaron un poco más de lo acordado. La comida estaba muy rica.',
                'puntuacion' => 4,
                'fotos'      => json_encode([
                    ['path' => "imagenes/usuario_{$maria->id}/imagen_1.jpg", 'url' => "$url/storage/imagenes/usuario_{$maria->id}/imagen_1.jpg"],
                    ['path' => "imagenes/usuario_{$maria->id}/imagen_2.jpg", 'url' => "$url/storage/imagenes/usuario_{$maria->id}/imagen_2.jpg"],
                    ['path' => "imagenes/usuario_{$maria->id}/imagen_3.jpg", 'url' => "$url/storage/imagenes/usuario_{$maria->id}/imagen_3.jpg"],
                ]),
            ]);
        }

        // ── SONIA ────────────────────────────────────────────────────────────────
        if ($sonia && $fotografia) {
            Resenia::create([
                'user_id'    => $sonia->id,
                'empresa_id' => $fotografia->id,
                'comentario' => 'Fotografía Segovia superó todas nuestras expectativas. Cada momento quedó perfectamente capturado. El álbum es una obra de arte, lo recomendamos sin dudarlo.',
                'puntuacion' => 5,
                'fotos'      => json_encode([
                    ['path' => "imagenes/usuario_{$sonia->id}/imagen_1.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_1.jpg"],
                    ['path' => "imagenes/usuario_{$sonia->id}/imagen_2.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_2.jpg"],
                    ['path' => "imagenes/usuario_{$sonia->id}/imagen_3.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_3.jpg"],
                    ['path' => "imagenes/usuario_{$sonia->id}/imagen_4.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_4.jpg"],
                    ['path' => "imagenes/usuario_{$sonia->id}/imagen_5.jpg", 'url' => "$url/storage/imagenes/usuario_{$sonia->id}/imagen_5.jpg"],
                ]),
            ]);
        }

        if ($sonia && $catering) {
            Resenia::create([
                'user_id'    => $sonia->id,
                'empresa_id' => $catering->id,
                'comentario' => 'El catering estuvo espectacular. Los 100 invitados quedaron más que satisfechos. El menú degustación fue un acierto total y el cocktail de bienvenida impresionó a todos.',
                'puntuacion' => 5,
            ]);
        }

        // ── CARMEN ───────────────────────────────────────────────────────────────
        if ($carmen && $fotografia) {
            Resenia::create([
                'user_id'    => $carmen->id,
                'empresa_id' => $fotografia->id,
                'comentario' => 'La sesión en la playa fue mágica. Los fotógrafos supieron adaptarse perfectamente al entorno y a la luz del atardecer. Las fotos reflejan exactamente cómo vivimos ese día.',
                'puntuacion' => 5,
                'fotos'      => json_encode([
                    ['path' => "imagenes/usuario_{$carmen->id}/imagen_1.jpg", 'url' => "$url/storage/imagenes/usuario_{$carmen->id}/imagen_1.jpg"],
                    ['path' => "imagenes/usuario_{$carmen->id}/imagen_2.jpg", 'url' => "$url/storage/imagenes/usuario_{$carmen->id}/imagen_2.jpg"],
                    ['path' => "imagenes/usuario_{$carmen->id}/imagen_3.jpg", 'url' => "$url/storage/imagenes/usuario_{$carmen->id}/imagen_3.jpg"],
                    ['path' => "imagenes/usuario_{$carmen->id}/imagen_4.jpg", 'url' => "$url/storage/imagenes/usuario_{$carmen->id}/imagen_4.jpg"],
                ]),
            ]);
        }

        if ($carmen && $catering) {
            Resenia::create([
                'user_id'    => $carmen->id,
                'empresa_id' => $catering->id,
                'comentario' => 'El catering fue impecable. La terraza con vistas al mar para el cocktail fue un detalle precioso. La comida, la presentación y el servicio estuvieron a la altura de la ocasión.',
                'puntuacion' => 4,
            ]);
        }

        $this->command->info('ReseniaSeeder: reseñas creadas para Javier, María, Sonia y Carmen.');
    }
}
