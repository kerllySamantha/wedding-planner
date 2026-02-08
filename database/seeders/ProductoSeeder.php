<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Producto::factory()->count(10)->create();

        $productos = [
            [
                'empresa_id' => 7,
                'tipo_producto_id' => 57,
                'nombre' => 'Carpa Elegante',
                'descripcion' => 'Carpa de lujo para bodas al aire libre, con decoración personalizada.',
                'precio_min' => 10000,
                'precio_max' => 40000,
            ],
            [
                'empresa_id' => 7,
                'tipo_producto_id' => 57,
                'nombre' => 'Carpa Estándar',
                'descripcion' => 'Carpa estándar para eventos, resistente y espaciosa.',
                'precio_min' => 5000,
                'precio_max' => 20000,
            ],
            [
                'empresa_id' => 7,
                'tipo_producto_id' => 57,
                'nombre' => 'Carpa Premium',
                'descripcion' => 'Carpa premium con iluminación y mobiliario incluido.',
                'precio_min' => 15000,
                'precio_max' => 55000,
            ],
            [
                'empresa_id' => 1,
                'tipo_producto_id' => 8,
                'nombre' => 'Finger Foods / Bocadillos',
                'descripcion' => 'Mini sándwiches o sliders (de carne, pollo, vegetales, etc.)',
                'precio_min' => 1500,
                'precio_max' => 2500,
            ],
            [
                'empresa_id' => 1,
                'tipo_producto_id' => 8,
                'nombre' => 'Snacks temáticos',
                'descripcion' => 'Chips gourmet, frutos secos, palomitas de sabores, Mini pizzas o empanadas',
                'precio_min' => 1500,
                'precio_max' => 2500,
            ],
            [
                'empresa_id' => 1,
                'tipo_producto_id' => 8,
                'nombre' => 'Estación de quesos y embutidos',
                'descripcion' => 'Tabla variada de quesos, embutidos, frutas secas y panes artesanales.',
                'precio_min' => 2000,
                'precio_max' => 3500,
            ],
            [
                'empresa_id' => 1,
                'tipo_producto_id' => 8,
                'nombre' => 'Mini postres',
                'descripcion' => 'Variedad de mini postres como tartaletas, cupcakes, mousse, etc.',
                'precio_min' => 1500,
                'precio_max' => 3000,
            ],

            [
                'empresa_id' => 8,
                'tipo_producto_id' => 38,
                'nombre' => 'Joyería Tradicional de Plata',
                'descripcion' => 'Exquisita joyería tradicional elaborada a mano por artesanos expertos, utilizando plata de la más alta pureza. Cada pieza refleja la riqueza cultural y el arte ancestral, perfecta para quienes valoran la autenticidad y la elegancia.',
                'precio_min' => 500,
                'precio_max' => 8000,
            ],
            [
                'empresa_id' => 8,
                'tipo_producto_id' => 38,
                'nombre' => 'Collares y Pulseras Artesanales',
                'descripcion' => 'Colección exclusiva de collares y pulseras tradicionales, elaborados con materiales nobles y acabados impecables. Cada pieza es un testimonio del trabajo artesanal que combina diseño clásico con tendencias contemporáneas.',
                'precio_min' => 700,
                'precio_max' => 6500,
            ],
            [
                'empresa_id' => 8,
                'tipo_producto_id' => 38,
                'nombre' => 'Anillos Tradicionales con Piedras Preciosas',
                'descripcion' => 'Anillos hechos a mano con diseños tradicionales, engastados con piedras preciosas seleccionadas cuidadosamente para resaltar su brillo y color. Cada anillo es una obra de arte que simboliza elegancia y distinción.',
                'precio_min' => 1200,
                'precio_max' => 8000,
            ],
            [
                'empresa_id' => 8,
                'tipo_producto_id' => 38,
                'nombre' => 'Pendientes Tradicionales de Oro',
                'descripcion' => 'Pendientes elaborados con oro de alta calidad, siguiendo diseños tradicionales que han pasado de generación en generación. Perfectos para realzar cualquier atuendo con un toque de sofisticación y herencia cultural.',
                'precio_min' => 1500,
                'precio_max' => 7500,
            ],
            [
                'empresa_id' => 2,
                'tipo_producto_id' => 3,
                'nombre' => 'Video Completo de Evento Cinematográfico',
                'descripcion' => 'Capturamos cada momento especial de tu evento con calidad cinematográfica, desde la preparación hasta el cierre. Nuestro equipo profesional utiliza tecnología avanzada para ofrecer un video emotivo y dinámico que revive la experiencia completa.',
                'precio_min' => 1500,
                'precio_max' => 7500,

            ],
            [
                'empresa_id' => 2,
                'tipo_producto_id' => 3,
                'nombre' => 'Cobertura Audiovisual Completa de Evento',
                'descripcion' => 'Producción audiovisual profesional que captura todos los aspectos de tu evento, con enfoque en la narrativa visual y la calidad técnica. Incluye grabación en alta definición, edición creativa y entrega en formatos digitales adaptados a tus necesidades.',
                'precio_min' => 1800,
                'precio_max' => 7000,
            ],
            [
                'empresa_id' => 2,
                'tipo_producto_id' => 3,
                'nombre' => 'Video Profesional de Evento',
                'descripcion' => 'Servicio de grabación y edición profesional para eventos cinematográficos, garantizando una producción de alta calidad que captura la esencia y emoción del momento. Ideal para documentales, festivales y lanzamientos de películas.',
                'precio_min' => 1500,
                'precio_max' => 7500,
            ],


            [
                "empresa_id" => 4,
                "tipo_producto_id" => 22,
                "nombre" => "Vestido de Novia Corte Princesa Clásico",
                "descripcion" => "Un diseño atemporal con falda amplia y corsé estructurado, confeccionado en satén de seda. Ideal para novias que buscan un look regio y romántico. Incluye posibilidad de personalización en escote y mangas.",
                "precio_min" => 2500,
                "precio_max" => 6800
            ],
            [
                'empresa_id' => 4,
                'tipo_producto_id' => 22,
                'nombre' => 'Vestido de Novia Corte Sirena Moderno',
                'descripcion' => 'Silueta ceñida que se abre desde la rodilla, realizado en encaje chantilly y tul ilusión. Destaca por su espalda descubierta con detalles de pedrería. Perfecto para una novia audaz y elegante.',
                'precio_min' => 3200,
                'precio_max' => 7400,
            ],
            [
                'empresa_id' => 4,
                'tipo_producto_id' => 22,
                'nombre' => 'Vestido de Novia Corte A Bohemio',
                'descripcion' => 'Confeccionado en crepé ligero y con aplicaciones de macramé en mangas acampanadas. Su silueta fluida y escote en V lo hacen perfecto para bodas al aire libre y un estilo más relajado.',
                'precio_min' => 1800,
                'precio_max' => 4500,
            ],
            [
                'empresa_id' => 4,
                'tipo_producto_id' => 22,
                'nombre' => 'Vestido de Novia Minimalista Recto',
                'descripcion' => 'Diseño liso y depurado en mikado de seda, con corte recto y escote barco. Elegancia pura para novias que prefieren la sutileza y un acabado impecable. Posibilidad de añadir velo o cola desmontable.',
                'precio_min' => 1600,
                'precio_max' => 5200,
            ],
            [
                'empresa_id' => 4,
                'tipo_producto_id' => 22,
                'nombre' => 'Vestido de Novia Estilo Vintage con Manga Larga',
                'descripcion' => 'Inspirado en los años 20, con cuerpo de encaje guipur y mangas largas transparentes bordadas. Falda de corte A con caída suave. Un toque de glamour y nostalgia para tu gran día.',
                'precio_min' => 2800,
                'precio_max' => 6100,
            ],
            [
                'empresa_id' => 5,
                'tipo_producto_id' => 37,
                'nombre' => 'Anillo de compromiso en oro blanco',
                'descripcion' => 'Elegante anillo de compromiso en oro blanco de 18 quilates con diamante central talla brillante. Diseño clásico y atemporal para un momento inolvidable.',
                'precio_min' => 3500,
                'precio_max' => 7200,
            ],
            [
                'empresa_id' => 5,
                'tipo_producto_id' => 37,
                'nombre' => 'Collar de perlas naturales',
                'descripcion' => 'Collar confeccionado con perlas cultivadas de alta calidad, con cierre de plata esterlina. Perfecto para ocasiones especiales y bodas.',
                'precio_min' => 2800,
                'precio_max' => 5400,
            ],
            [
                'empresa_id' => 5,
                'tipo_producto_id' => 37,
                'nombre' => 'Pendientes de oro amarillo y zafiros',
                'descripcion' => 'Pendientes delicados en oro amarillo de 14 quilates con zafiros azules y pequeños diamantes que aportan brillo y elegancia.',
                'precio_min' => 2200,
                'precio_max' => 4800,
            ],
            [
                'empresa_id' => 5,
                'tipo_producto_id' => 37,
                'nombre' => 'Pulsera de plata con detalles grabados',
                'descripcion' => 'Pulsera artesanal en plata esterlina con grabados personalizados. Ideal para regalar o para complementar un look sofisticado.',
                'precio_min' => 1500,
                'precio_max' => 3200,
            ],
            [
                'empresa_id' => 5,
                'tipo_producto_id' => 37,
                'nombre' => 'Sortija vintage con esmeralda',
                'descripcion' => 'Sortija estilo vintage con esmeralda central y detalles en oro rosa. Un diseño único que evoca glamour y nostalgia.',
                'precio_min' => 4000,
                'precio_max' => 7500,
            ],
            [
                'empresa_id' => 5,
                'tipo_producto_id' => 37,
                'nombre' => 'Juego de pendientes y collar en plata y circonitas',
                'descripcion' => 'Conjunto elegante de pendientes y collar en plata con circonitas brillantes, perfecto para novias y eventos especiales.',
                'precio_min' => 3000,
                'precio_max' => 6200,
            ],

            [
                'empresa_id' => 6,
                'tipo_producto_id' => 10,
                'nombre' => 'Pastel de boda clásico',
                'descripcion' => 'Pastel de boda elaborado artesanalmente con ingredientes de primera calidad, decorado con detalles personalizados que reflejan la esencia de tu celebración. Perfecto para un momento inolvidable.',
                'precio_min' => 1200,
                'precio_max' => 6000,
            ],
            [
                'empresa_id' => 6,
                'tipo_producto_id' => 11,
                'nombre' => 'Cupcakes personalizados para eventos',
                'descripcion' => 'Deliciosos cupcakes hechos a mano con diseños únicos y sabores variados, ideales para complementar la mesa dulce de tu boda o evento especial.',
                'precio_min' => 400,
                'precio_max' => 2500,
            ],
            [
                'empresa_id' => 6,
                'tipo_producto_id' => 12,
                'nombre' => 'Mesa de postres variada',
                'descripcion' => 'Amplia selección de postres y dulces artesanales, desde galletas y mini tartas hasta helados y bombones, perfecta para endulzar tu celebración y sorprender a tus invitados.',
                'precio_min' => 1500,
                'precio_max' => 7000,
            ],
            [
                'empresa_id' => 6,
                'tipo_producto_id' => 10,
                'nombre' => 'Pastel de boda moderno y elegante',
                'descripcion' => 'Pastel de boda con diseño contemporáneo, sabores innovadores y acabados sofisticados, elaborado con ingredientes frescos y de alta calidad para un evento memorable.',
                'precio_min' => 1800,
                'precio_max' => 7500,
            ],
            [
                'empresa_id' => 6,
                'tipo_producto_id' => 11,
                'nombre' => 'Cupcakes gourmet personalizados',
                'descripcion' => 'Cupcakes artesanales con una amplia variedad de sabores y decoraciones personalizadas, ideales para darle un toque dulce y original a tu evento.',
                'precio_min' => 500,
                'precio_max' => 3000,
            ],
            [
                'empresa_id' => 6,
                'tipo_producto_id' => 12,
                'nombre' => 'Mesa de postres premium',
                'descripcion' => 'Selección exclusiva de postres artesanales de alta gama, con presentaciones elegantes y sabores únicos, perfecta para eventos que buscan un toque de distinción y sofisticación.',
                'precio_min' => 2500,
                'precio_max' => 9000,
            ],
            [

                'empresa_id' => 3,
                'tipo_producto_id' => 10,
                'nombre' => 'Pastel clásico de boda',
                'descripcion' => 'Pastel artesanal elaborado con ingredientes de alta calidad, decorado con detalles personalizados para hacer tu boda inolvidable.',
                'precio_min' => 1200,
                'precio_max' => 6000,

            ],
            [
                'empresa_id' => 3,
                'tipo_producto_id' => 10,
                'nombre' => 'Pastel moderno y elegante',
                'descripcion' => 'Diseño contemporáneo con sabores innovadores y acabados sofisticados, perfecto para bodas con estilo único.',
                'precio_min' => 1800,
                'precio_max' => 7500,
            ],
            [
                'empresa_id' => 3,
                'tipo_producto_id' => 11,
                'nombre' => 'Cupcakes artesanales variados',
                'descripcion' => 'Cupcakes hechos a mano con una amplia variedad de sabores y decoraciones personalizadas para complementar tu evento.',
                'precio_min' => 400,
                'precio_max' => 2500,
            ],
            [
                'empresa_id' => 3,
                'tipo_producto_id' => 11,
                'nombre' => 'Cupcakes gourmet personalizados',
                'descripcion' => 'Deliciosos cupcakes con diseños únicos y sabores exclusivos, ideales para bodas y celebraciones especiales.',
                'precio_min' => 500,
                'precio_max' => 3000,
            ]



















        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }


    }
}
