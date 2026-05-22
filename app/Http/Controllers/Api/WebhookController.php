<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Reserva;
use Illuminate\Http\Request;

use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig     = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload, $sig, config('services.stripe.webhook_secret')
            );
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Firma inválida'], 400);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Payload inválido'], 400);
        }

        match ($event->type) {
            'account.updated'           => $this->cuentaActualizada($event->data->object),
            'transfer.created'          => $this->transferenciaCreada($event->data->object),
            'payment_intent.succeeded'  => $this->pagoExitoso($event->data->object),
            'payment_intent.payment_failed' => $this->pagoFallido($event->data->object),
            default                     => null,
        };

        return response()->json(['status' => 'ok']);
    }

    private function cuentaActualizada($account): void
    {
        Empresa::where('stripe_account_id', $account->id)->update([
            'stripe_onboarding_complete' => $account->details_submitted,
        ]);
    }

    private function transferenciaCreada($transfer): void
    {
        // Registrar transferencia hacia la cuenta conectada del proveedor si se requiere auditoría
    }

    private function pagoExitoso($paymentIntent): void
    {
        $reservaId = $paymentIntent->metadata->reserva_id ?? null;

        if (!$reservaId) {
            return;
        }

        $reserva = Reserva::find($reservaId);

        if ($reserva && $reserva->estado === 'bloqueada') {
            $reserva->update([
                'estado'     => 'confirmada',
                'expires_at' => null,
            ]);
        }
    }

    private function pagoFallido($paymentIntent): void
    {
        $reservaId = $paymentIntent->metadata->reserva_id ?? null;

        if (!$reservaId) {
            return;
        }

        Reserva::where('id', $reservaId)
            ->where('estado', 'bloqueada')
            ->update(['estado' => 'cancelada']);
    }
}
