<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReseniasDisponiblesEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly mixed $usuario,
        public readonly mixed $empresas,
    ) {}

    public function build()
    {
        return $this
            ->subject('¡Tu boda ha pasado! Valora a tus proveedores')
            ->view('emails.resenias_disponibles');
    }
}
