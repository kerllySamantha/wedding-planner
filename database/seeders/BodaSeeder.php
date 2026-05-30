<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\PerfilUsuario;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BodaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = PerfilUsuario::inRandomOrder()->take(3)->pluck('usuario_id');
        $url_servidor = "http://weddingplaner.local";
        $url_local = "http://127.0.0.1:8000";

        $bodas = [
            [
                'nombre_pareja' => 'Maria & Tomas',
                'fecha_boda' => '2025-03-15',
                'ubicacion' => 'Sevilla, España',
                // // 'presupuesto_total' => 12000.50,
                'usuario_id' => 2,
                'poblacion_id' => 291,
                'notas' => 'Ceremonia al aire libre, menú vegetariano.',
                'fotos' => json_encode([
                    [
                        "path" => "imagenes/usuario_2/imagen.jpg",
                        "url" => "$url_servidor/storage/imagenes/usuario_2/imagen_1.jpg",
                    ],
                    [
                        "path" => "imagenes/usuario_2/imagen_2.jpg",
                        "url" => "$url_servidor/storage/imagenes/usuario_2/imagen_2.jpg"
                    ],
                    [
                        "path" => "imagenes/usuario_2/imagen_3.jpg",
                        "url" => "$url_servidor/storage/imagenes/usuario_2/imagen_3.jpg"
                    ],
                    [
                        "path" => "imagenes/usuario_2/imagen_4.jpg",
                        "url" => "$url_servidor/storage/imagenes/usuario_2/imagen_4.jpg"
                    ],


                ]),
            ],
            [
                'nombre_pareja' => 'Juana & Javier',
                'fecha_boda' => '2024-09-15',
                'ubicacion' => 'Madrid, España',
                // 'presupuesto_total' => 15000,
                'usuario_id' => 3,
                'poblacion_id' => 218,
                'notas' => 'Boda temática vintage, música en vivo.',
                'fotos' => json_encode([
                    [
                        'path' => 'imagenes/usuario_3/imagen_1.jpg',
                        'url' => "$url_servidor/storage/imagenes/usuario_3/imagen_1.jpg",
                    ],
                    [
                        'path' => 'imagenes/usuario_3/imagen_2.jpg',
                        'url' => "$url_servidor/storage/imagenes/usuario_3/imagen_2.jpg",
                    ],
                    [
                        'path' => 'imagenes/usuario_3/imagen_3.jpg',
                        'url' => "$url_servidor/storage/imagenes/usuario_3/imagen_3.jpg",
                    ],
                    [
                        'path' => 'imagenes/usuario_3/imagen_4.jpg',
                        'url' => "$url_servidor/storage/imagenes/usuario_3/imagen_4.jpg",
                    ],
                    [
                        'path' => 'imagenes/usuario_3/imagen_5.jpg',
                        'url' => "$url_servidor/storage/imagenes/usuario_3/imagen_5.jpg",
                    ],
                    [
                        'path' => 'imagenes/usuario_3/imagen_6.jpg',
                        'url' => "$url_servidor/storage/imagenes/usuario_3/imagen_6.jpg",
                    ],
                ]),
            ],
            // [
            //     'nombre_pareja' => 'Ana & Carlos',
            //     'fecha_boda' => '2035-08-10',
            //     'ubicacion' => 'Barcelona, España',
            //      'presupuesto_total' => 18000.75,
            //     'notas' => 'Ceremonia religiosa, invitados internacionales.',
            // ],
        ];

        foreach ($bodas as $bodaData) {
            Boda::create($bodaData);
        }
    }
}
