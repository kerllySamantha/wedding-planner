<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
        ]);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $reserva = Reserva::with('pedirPresupuesto')->findOrFail($request->reserva_id);

        if ($reserva->estado !== 'bloqueada') {
            return response()->json(['error' => 'La reserva no está pendiente de pago.'], 409);
        }

        $importe = $reserva->pedirPresupuesto?->importe_ofertado;

        if (!$importe || $importe <= 0) {
            return response()->json(['error' => 'No hay importe definido para esta reserva.'], 422);
        }

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount'   => (int) round($importe * 100),
            'currency' => 'eur',
            'metadata' => ['reserva_id' => $reserva->id],
        ]);

        return response()->json([
            'client_secret' => $paymentIntent->client_secret,
        ]);
    }
}
