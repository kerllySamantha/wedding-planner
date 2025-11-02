<?php

namespace Database\Seeders;

use App\Models\Boda;
use App\Models\Invitado;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvitadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invitadosUsers = User::role('invitado')->get();

        if ($invitadosUsers->isEmpty() || Boda::count() === 0) {
            return; 
        }

        foreach ($invitadosUsers as $user) {
            Invitado::create([
                'boda_id' => Boda::inRandomOrder()->first()->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
