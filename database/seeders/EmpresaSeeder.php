<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresaUsers = User::role('empresa')->get()->values()->all();
        $url_servidor  = "http://weddingplaner.local";
        $url_local = "http://127.0.0.1:8000";

        $empresas = [
            [
                'nombre_empresa' => 'Catering La Alhambra',
                'direccion' => 'Calle Reyes Católicos 12, Granada',
                'telefono' => '958123456',
                'descripcion' => 'Expertos en cocina andaluza para bodas y eventos.',
                'user_id' => $empresaUsers[0]->id,
                // 'categoria_id' => 3,
                'tipo_servicio' => 'Servicio de Catering',
                'poblacion_id' => 131,
                // 'servicios' => [1, 3, 5],

                'fotos' => json_encode(
                    [
                        [
                            'path' => 'imagenes/usuario_4/imagen_1.webp',
                            'url' => "$url_servidor/storage/imagenes/usuario_4/imagen_1.webp",
                        ],
                        [
                            'path' => 'imagenes/usuario_4/imagen_2.webp',
                            'url' => "$url_servidor/storage/imagenes/usuario_4/imagen_2.webp",
                        ],
                        [
                            'path' => 'imagenes/usuario_4/imagen_3.webp',
                            'url' => "$url_servidor/storage/imagenes/usuario_4/imagen_3.webp",
                        ],
                        [
                            'path' => 'imagenes/usuario_4/imagen_3.webp',
                            'url' => "$url_servidor/storage/imagenes/usuario_4/imagen_3.webp",
                        ],
                    ]
                )

            ],
            [
                'nombre_empresa' => 'Fotografía Segovia',
                'direccion' => 'Plaza Mayor 5, Segovia',
                'telefono' => '921654321',
                'descripcion' => 'Fotografía profesional con más de 20 años de experiencia.',
                'user_id' => $empresaUsers[1]->id,
                'tipo_servicio' => 'Fotografia',
                // 'categoria_id' => 6,
                // 'servicios' => [2, 4],
                'poblacion_id' => 282,
                'fotos' => json_encode(
                    [
                        [
                            'path' => 'imagen/empresa_4/imagen_1.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_4/imagen_1.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_4/imagen_2.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_4/imagen_2.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_4/imagen_3.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_4/imagen_3.webp",
                        ],

                        [
                            'path' => 'imagenes/empresa_4/imagen_4.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_4/imagen_4.webp",
                        ],


                    ]
                ),
            ],
            [
                'nombre_empresa' => 'Panadería El Trigal',
                'direccion' => 'Calle Real 12, Segovia',
                'telefono' => '921123456',
                'tipo_servicio' => 'Servicio de Pasteleria y Panaderia',
                'descripcion' => 'Panadería artesanal con recetas tradicionales segovianas.
                Panadería Maeso nace en un pequeño obrador artesano, en un hermoso pueblo
                de Guadalajara, Checa. Todo comenzó cuando se unió la pasión por la panadería, los eventos, la decoración y la organización de la propia boda de sus dueños. El conocimiento
                previo en organización de eventos, el gusto por los pequeños detalles y todas las maravillosas ideas que salen de sus cabezas harán que tu día especial sea mucho más dulce.',
                'user_id' => $empresaUsers[2]->id,
                // 'categoria_id' => 4,
                'poblacion_id' => 282,
                // 'servicios' => [6, 7],
                'fotos' => json_encode(
                    [
                        [
                            'path' => 'imagen/empresa_3/imagen_1.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_3/imagen_1.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_3/imagen_2.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_3/imagen_2.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_3/imagen_3.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_3/imagen_3.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_3/imagen_4.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_3/imagen_4.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_3/imagen_5.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_3/imagen_5.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_3/imagen_6.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_3/imagen_6.webp",
                        ],

                    ]
                ),
            ],
            [
                'nombre_empresa' => 'Valdés & Pastor',
                'direccion' => 'Avenida de la Constitución 23, Segovia',
                'telefono' => '921987654',
                'tipo_servicio' => 'Vestidos Novia',
                // 'servicios' => [8, 9],
                'descripcion' => ' es un
                taller especializado en el diseño y la creación de vestidos de novia, madrina, fiesta y comunión. Cuenta con un amplio abanico de diseños entre los que escoger, además de la posibilidad de poder realizar diseños a medida en su taller, adaptándose a todos tus sueños.',
                'user_id' => $empresaUsers[3]->id,
                // 'categoria_id' => 9,
                'poblacion_id' => 282,
                'fotos' => json_encode(
                    [
                        [
                            'path' => 'imagen/empresa_5/imagen_1.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_5/imagen_1.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_5/imagen_2.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_5/imagen_2.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_5/imagen_3.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_5/imagen_3.webp",
                        ],

                        [
                            'path' => 'imagenes/empresa_5/imagen_5.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_5/imagen_4.webp",
                        ],


                    ]
                ),
            ],
            [
                'nombre_empresa' => 'Joyeria Marga Mirá',
                'direccion' => 'Calle San Juan 8, Segovia',
                'telefono' => '921112233',
                'tipo_servicio' => 'Expertos e joyas',
                'descripcion' => 'Joyería Marga Mira es una
                 joyería familiar con taller de joyería en Segobia,
                  cuenta con la experiencia de varias generaciones de servicio y destaca por su trato cercano y un gran
                catálogo de joyas, tanto para la novia como para el novio. La elección de las alianzas de boda será algo sencillo, sumando otro acierto del amor en el día de vuestra boda.',
                'user_id' => $empresaUsers[4]->id,

                // 'categoria_id' => 14,
                'poblacion_id' => 282,
                'fotos' => json_encode(
                    [
                        [
                            'path' => 'imagen/empresa_6/imagen_1.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_6/imagen_1.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_6/imagen_2.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_6/imagen_2.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_6/imagen_3.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_6/imagen_3.webp",
                        ],

                        [
                            'path' => 'imagenes/empresa_6/imagen_4.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_6/imagen_4.webp",
                        ],


                    ]
                ),
            ],
            [
                'nombre_empresa' => 'Los Dulces de Yania',
                'direccion' => ' Carrer l Ermita,80,
                local 1,',
                'telefono' => '921445566',
                'tipo_servicio' => 'Dulcerias',
                'descripcion' => '¿A quién le amarga un dulce?
                ¡Y si son Los Dulces de Yania, todavía menos! Y es que la propuesta que te ofrece esta
                 empresa para el día de tu boda será realmente
                irresistible. Sus creaciones no solo enamoran por su presentación, ¡su sabor es incomparable! Si quieres reponer fuerzas durante la fiesta y darle ese toque especial a la celebración, ¡date el capricho más dulce!
                Endulza tu gran día con unos postres irresistibles
                Los Dulces de Yania podrá encargarse de elaborar todo tipo de
                 postres y dulces para tu evento. Con dedicación y mucho mimo, te
                  sorprenderá con una amplia variedad de opciones: desde el clásico
                  donut bar hasta originales copas, galletas o helados. ¿Con cuál te quedas?
                Ningún invitado resistirá la tentación… Es más: ¡te lo agradecerán!
                 Contar con un candy bar durante la fiesta marca la diferencia y permite cargar
                  las pilas para seguir dándolo todo en la pista de baile.',
                'user_id' => $empresaUsers[4]->id,
                // 'categoria_id' => 4,
                'poblacion_id' => 47,
                'fotos' => json_encode(
                    [
                        [
                            'path' => 'imagen/empresa_8/imagen_1.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_8/imagen_1.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_8/imagen_2.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_8/imagen_2.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_8/imagen_3.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_8/imagen_3.webp",
                        ],

                        [
                            'path' => 'imagenes/empresa_8/imagen_4.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_8/imagen_4.webp",
                        ],


                    ]
                ),
            ],
            [
                'nombre_empresa' => 'Carpas 24/7',
                'direccion' => 'Calle Real 18, Cox',
                'telefono' => '921556677',
                'tipo_servicio' => 'Carpas portables',
                'descripcion' => '¿Sueñas con una celebración al aire libre, pero quieres
                 la tranquilidad de contar con un espacio
                cubierto elegante y seguro? En Carpas 24/7 transformamos
                cualquier entorno en un lugar mágico hecho a tu medida.
                Hablamos de diseñarun escenario que refleje tu esencia,
                que sorprenda a tus invitados y convierta tu boda en un recuerdo inolvidable.
                Desde carpas beduinas con un aire bohemio, jaimas con encanto exótico o
                 entelados de madera llenos de calidez, hasta dobles techos que transmiten
                  sofisticación.',
                'user_id' => $empresaUsers[5]->id,
                'poblacion_id' => 75,
                // 'categoria_id' => 16,
                'fotos' => json_encode(
                    [
                        [
                            'path' => 'imagen/empresa_7/imagen_1.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_7/imagen_1.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_7/imagen_2.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_7/imagen_2.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_7/imagen_3.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_7/imagen_3.webp",
                        ],

                        [
                            'path' => 'imagenes/empresa_7/imagen_4.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_7/imagen_4.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_7/imagen_5.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_7/imagen_5.webp",
                        ],


                    ]
                ),
            ],

            [
                'nombre_empresa' => 'Joyería Oro Viejo',
                'direccion' => 'Calle Mayor 10, Segovia',
                'poblacion_id' => 282,
                'telefono' => '921667788',
                'tipo_servicio' => 'Joyeria Lujo',
                'descripcion' => 'Venta de joyas y relojes de alta calidad.',
                'user_id' => $empresaUsers[6]->id,
                // 'categoria_id' => 14,
                'fotos' => json_encode(
                    [
                        [
                            'path' => 'imagenes/empresa_9/imagen_1.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_9/imagen_1.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_9/imagen_2.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_9/imagen_2.webp",
                        ],
                        [
                            'path' => 'imagenes/empresa_9/imagen_3.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_9/imagen_3.webp",
                        ],

                        [
                            'path' => 'imagenes/empresa_9/imagen_4.webp',
                            'url' => "$url_servidor/storage/imagenes/empresa_9/imagen_4.webp",
                        ],


                    ]
                ),
            ],
        ];

        $empresaUsers = User::role('empresa')->get(); 

        foreach ($empresas as $index => $data) {
            // Asignar un usuario único a cada empresa
            if (isset($empresaUsers[$index])) {
                $data['user_id'] = $empresaUsers[$index]->id;
            } else {
                $data['user_id'] = null;
            }

            Empresa::create($data);
        }
    }
}
