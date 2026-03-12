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

        $url_servidor = "http://wedding_planer.local";
        $url_local = "http://127.0.0.1:8000";
        $resenias = [
            [
                'user_id' => 3,
                'empresa_id' => 2,
                'comentario' => 'El servicio fue excelente, todo salió como esperaba.',
                'puntuacion' => 5,
                'fotos' => json_encode([
                    [
                        "path" => "imagenes/usuario_2/imagen_1.jpg",
                        "url" => $url_servidor."/storage/imagenes/usuario_2/imagen_1.jpg",
                    ],
                    [
                        "path" => "imagenes/usuario_2/imagen_2.jpg",
                        "url" => $url_servidor."/storage/imagenes/usuario_2/imagen_2.jpg"
                    ],
                    [
                        "path" => "imagenes/usuario_2/imagen_3.jpg",
                        "url" => $url_servidor."/storage/imagenes/usuario_2/imagen_3.jpg"
                    ],
                    [
                        "path" => "imagenes/usuario_2/imagen_4.jpg",
                        "url" => $url_servidor."/storage/imagenes/usuario_2/imagen_4.jpg"
                    ],


                ]),
            ],
            [
                'user_id' => 3,
                'empresa_id' => 1,
                'comentario' => 'Nuestros invitados quedaron encantados con la comida,
                 estaba todo buenísimo, el aperitivo los hicimos en unos jardines ajenos 
                 a la empresa sin ningún problema y luego fuimos a su salón a comer.
                  Para nosotros salió todo perfecto, seguro que hubo algún fallo pero ese
                   día la verdad que solo estás para pasarlo bien y 
                más después del tiempo que llevamos con el tema Covid. Sin duda los aconsejo.',
                'puntuacion' => 5,
                

            ],
            [
                'user_id' => 2,
                'empresa_id' => 1,
                'comentario' => 'Buen trabajo, aunque tardaron un poco más de lo acordado.',
                'puntuacion' => 4,
                'fotos' => json_encode([
                    [
                        'path' => 'imagenes/usuario_4/imagen_1.webp',
                        'url' => "$url_servidor/storage/imagenes/usuario_4/imagen_1.webp",
                    ],
                    [
                        'path' => 'imagenes/usuario_4/imagen_2.webp',
                        'url' => "$url_servidor/storage/imagenes/usuario_4/imagen_2.webp",
                    ],
                    [
                        'path' => 'imagenes/usuario_4/imagen_5.webp',
                        'url' => "$url_servidor/storage/imagenes/usuario_4/imagen_5.webp",
                    ],
                    [
                        'path' => 'imagenes/usuario_4/imagen_6.webp',
                        'url' => "$url_servidor/storage/imagenes/usuario_4/imagen_6.webp",
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