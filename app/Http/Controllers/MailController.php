<?php

namespace App\Http\Controllers;

use App\Mail\EnvioEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function enviarCorreo()
{
    Mail::to('test@test.com')->send(new EnvioEmail());

    return response()->json([
        'message' => 'Correo enviado'
    ]);
}
}
