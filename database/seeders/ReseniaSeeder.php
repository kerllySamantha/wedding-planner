<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resenia;

class ReseniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resenias = [
            [
                'user_id' => 1,
                'empresa_id' => 2,
                'comentario' => 'El servicio fue excelente, todo salió como esperaba.',
                'puntuacion' => 5,
                'fotos' => json_encode([
                    [
                        "path" =>  "imagenes/usuario_2/68e2a18817460.jepg",
                        "url" => "http://127.0.0.1:8000/storage/imagenes/usuario_2/68e2a18817460.jepg",
                    ],
                    [
                        "path" => "imagenes/usuario_2/68e2a0c16d7f7.jepg",
                        "url" =>  "http://127.0.0.1:8000/storage/imagenes/usuario_2/68e2a0c16d7f7.jepg"
                    ],
                    [
                        "path" =>  "imagenes/usuario_2/68e2a229784b4.jepg",
                        "url" =>  "http://127.0.0.1:8000/storage/imagenes/usuario_2/68e2a229784b4.jepg"
                    ],
                   

                ]),
            ],
            [
                'user_id' => 2,
                'empresa_id' => 1,
                'comentario' => 'Buen trabajo, aunque tardaron un poco más de lo acordado.',
                'puntuacion' => 4,
                'fotos' => json_encode([
                    [
                        'path' => 'imagenes/usuario_4/imagen_1.webp',
                        'url' => "http://127.0.0.1:8000/storage/imagenes/usuario_4/imagen_1.webp",
                    ],
                    [
                        'path' => 'imagenes/usuario_4/imagen_2.webp',
                        'url' => "http://127.0.0.1:8000/storage/imagenes/usuario_4/imagen_2.webp",
                    ],
                    [
                        'path' => 'imagenes/usuario_4/imagen_5.webp',
                        'url' => "http://127.0.0.1:8000/storage/imagenes/usuario_4/imagen_5.webp",
                    ],
                    [
                        'path' => 'imagenes/usuario_4/imagen_6.webp',
                        'url' => "http://127.0.0.1:8000/storage/imagenes/usuario_4/imagen_6.webp",
                    ],
                ]),
            ],
            // [
            //     'user_id' => 3,
            //     'empresa_id' => 3,
            //     'comentario' => 'La atención fue buena, pero el resultado final no fue lo que esperaba.',
            //     'puntuacion' => 3,
            //     'fotos' => json_encode([]),
            // ],
        ];

        foreach ($resenias as $data) {
            Resenia::create($data);
        }
    }
}