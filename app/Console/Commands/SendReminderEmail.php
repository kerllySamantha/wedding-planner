<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail extends Command
{
    protected $signature = 'email:send-reminder';

    protected $description = 'Enviar correo automático';

    public function handle()
    {
        Mail::raw('Este es un correo automático desde Laravel', function ($message) {
            $message->to('destino@gmail.com')
                    ->subject('Correo automático');
        });

        $this->info('Correo enviado correctamente');
    }
}