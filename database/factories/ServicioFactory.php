<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Servicio>
 */
class ServicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombre = $this->faker->unique()->randomElement([
            "Banquete",
            "Mesa de postres",
            "Mesa de fruta",
            "Barra libre",
            "Decoración floral",
            "Decoración temática",
            "DJ para bodas",
            "Música en vivo",
            "Suite nupcial",
            "Parking para invitados",
            "Espacio para ceremonia civil",
            "Animación infantil",
            "Fotografía y video",
            "Carpas y toldos",
            "Coffee break"
        ]);

        return [
            'nombre' => $nombre,
            'slug' => Str::slug($nombre),
            'descripcion' => $this->faker->sentence(10),
            'icono' => $this->faker->randomElement([
                "utensils",
                "birthday-cake",
                "apple-alt",
                "cocktail",
                "flower",
                "palette",
                "music",
                "guitar",
                "bed",
                "parking",
                "church",
                "child",
                "camera",
                "tent",
                "coffee"
            ])
        ];
    
    }
}
