<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PagoController extends Controller
{
    /**
     * Tasa de conversión Soles → Dólares.
     * Sandbox de PayPal funciona mejor con USD.
     */
    private float $tasaCambio = 3.75; // 1 USD ≈ 3.75 PEN

    /**
     * Iniciar el pago: redirige al usuario a PayPal.
     */
    public function iniciar($pedidoId)
    {
        $pedido = Pedido::with('detalles')
            ->where('user_id', Auth::id())
            ->where('estado', 'pendiente')
            ->findOrFail($pedidoId);

        // Convertir soles a dólares
        $totalUSD = round($pedido->total / $this->tasaCambio, 2);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.exito', $pedido->id),
                "cancel_url" => route('paypal.cancelar', $pedido->id),
                "brand_name" => "Academia Triunfadores",
                "user_action" => "PAY_NOW",
            ],
            "purchase_units" => [[
                "reference_id" => (string) $pedido->id,
                "description"  => "Pedido #{$pedido->id} - Academia Triunfadores",
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($totalUSD, 2, '.', ''),
                ],
            ]],
        ]);

        // Si PayPal devolvió un link de aprobación, redirigir
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    // Guardamos el order_id de PayPal para asociarlo después
                    $pedido->update(['transaction_id' => $response['id']]);
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('carrito.index')
            ->with('error', 'No se pudo conectar con PayPal. Intenta de nuevo.');
    }

    /**
     * El usuario completó el pago → capturar y marcar como pagado.
     */
    public function exito(Request $request, $pedidoId)
    {
        $pedido = Pedido::where('user_id', Auth::id())->findOrFail($pedidoId);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // Capturar el pago usando el token que devuelve PayPal
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $pedido->update([
                'estado' => 'pagado',
                'transaction_id' => $response['id'],
            ]);

            return redirect()->route('pedidos.show', $pedido->id)
                ->with('success', '¡Pago realizado con éxito! Tu pedido #' . $pedido->id . ' está pagado.');
        }

        return redirect()->route('pedidos.show', $pedido->id)
            ->with('error', 'El pago no se completó. Si el problema persiste, contáctanos.');
    }

    /**
     * El usuario canceló el pago → marcar pedido como cancelado.
     */
    public function cancelar($pedidoId)
    {
        $pedido = Pedido::where('user_id', Auth::id())->findOrFail($pedidoId);

        // Devolver el stock de los productos
        foreach ($pedido->detalles as $detalle) {
            if ($detalle->item_type === 'producto') {
                \App\Models\Producto::where('id', $detalle->item_id)
                    ->increment('stock', $detalle->cantidad);
            }
        }

        $pedido->update(['estado' => 'cancelado']);

        return redirect()->route('pedidos.show', $pedido->id)
            ->with('error', 'Pago cancelado. Tu pedido fue cancelado y el stock devuelto.');
    }
}