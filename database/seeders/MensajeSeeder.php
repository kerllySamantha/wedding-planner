<?php

namespace Database\Seeders;

use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MensajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = User::all();

        if ($usuarios->count() < 2) {
            $this->command->info('Se necesitan al menos 2 usuarios para crear mensajes.');
            return;
        }

        $mensajes = [
            [
                'emisor_id' => $usuarios[0]->id,
                'receptor_id' => $usuarios[1]->id,
                'contenido' => '¡Hola! ¿Cómo estás?',
                'archivo' => null,
                'leido' => false,
            ],
            [
                'emisor_id' => $usuarios[1]->id,
                'receptor_id' => $usuarios[0]->id,
                'contenido' => 'Bien, gracias. ¿Y tú?',
                'archivo' => null,
                'leido' => false,
            ],
            [
                'emisor_id' => $usuarios[0]->id,
                'receptor_id' => $usuarios[1]->id,
                'contenido' => 'Te envío el contrato firmado.',
                'archivo' => null,
                'leido' => true,
            ],
        ];

        foreach ($mensajes as $mensaje) {
            Mensaje::create($mensaje);
        }
    }
}
