<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\CarritoItem;

class CarritoController extends Controller
{
    // ─── HELPER: obtener el carrito (BD si logueado, sesión si no) ─────────────
    private function obtenerCarrito(): array
    {
        if (Auth::check()) {
            // Logueado: cargar desde BD
            $items = CarritoItem::where('user_id', Auth::id())->get();
            $carrito = [];
            foreach ($items as $item) {
                $key = "{$item->item_type}_{$item->item_id}";
                $carrito[$key] = [
                    'key'      => $key,
                    'tipo'     => $item->item_type,
                    'id'       => $item->item_id,
                    'nombre'   => $item->nombre_item,
                    'precio'   => (float) $item->precio,
                    'imagen'   => $item->imagen,
                    'cantidad' => $item->cantidad,
                ];
            }
            return $carrito;
        }

        // Invitado: usar sesión
        return session('carrito', []);
    }

    // ─── HELPER: guardar el carrito ───────────────────────────────────────────
    private function guardarCarrito(array $carrito): void
    {
        if (Auth::check()) {
            // Logueado: sincronizar con BD
            CarritoItem::where('user_id', Auth::id())->delete();
            foreach ($carrito as $item) {
                CarritoItem::create([
                    'user_id'     => Auth::id(),
                    'item_type'   => $item['tipo'],
                    'item_id'     => $item['id'],
                    'nombre_item' => $item['nombre'],
                    'precio'      => $item['precio'],
                    'imagen'      => $item['imagen'],
                    'cantidad'    => $item['cantidad'],
                ]);
            }
        } else {
            session(['carrito' => $carrito]);
        }
    }

    // ─── VER CARRITO ──────────────────────────────────────────────────────────
    public function index()
    {
        $carrito = $this->obtenerCarrito();
        $total   = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], $carrito));

        return view('carrito.index', compact('carrito', 'total'));
    }

    // ─── AGREGAR ÍTEM ─────────────────────────────────────────────────────────
    public function agregar(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:curso,producto',
            'item_id'   => 'required|integer',
        ]);

        $tipo = $request->item_type;
        $id   = $request->item_id;

        if ($tipo === 'curso') {
            $item = Curso::findOrFail($id);
        } else {
            $item = Producto::findOrFail($id);
            if ($item->stock <= 0) {
                return back()->with('error', "El producto '{$item->nombre}' no tiene stock disponible.");
            }
        }

        $carrito = $this->obtenerCarrito();
        $key = "{$tipo}_{$id}";

        if (isset($carrito[$key])) {
            if ($tipo === 'producto' && ($carrito[$key]['cantidad'] + 1) > $item->stock) {
                return back()->with('error', "Solo hay {$item->stock} unidades disponibles de '{$item->nombre}'.");
            }
            $carrito[$key]['cantidad']++;
        } else {
            $carrito[$key] = [
                'key'      => $key,
                'tipo'     => $tipo,
                'id'       => $id,
                'nombre'   => $item->nombre,
                'precio'   => (float) $item->precio,
                'imagen'   => $item->imagen ?? null,
                'cantidad' => 1,
            ];
        }

        $this->guardarCarrito($carrito);

        return back()->with('success', "'{$item->nombre}' agregado al carrito.");
    }

    // ─── QUITAR UN ÍTEM ───────────────────────────────────────────────────────
    public function quitar(string $key)
    {
        $carrito = $this->obtenerCarrito();
        unset($carrito[$key]);
        $this->guardarCarrito($carrito);

        return redirect()->route('carrito.index')->with('success', 'Ítem eliminado.');
    }

    // ─── ACTUALIZAR CANTIDAD ──────────────────────────────────────────────────
    public function actualizar(Request $request, string $key)
    {
        $request->validate(['cantidad' => 'required|integer|min:1']);

        $carrito = $this->obtenerCarrito();

        if (!isset($carrito[$key])) {
            if ($request->wantsJson()) {
                return response()->json(['ok' => false, 'message' => 'Ítem no encontrado.'], 404);
            }
            return redirect()->route('carrito.index')->with('error', 'Ítem no encontrado.');
        }

        if ($carrito[$key]['tipo'] === 'producto') {
            $producto = Producto::find($carrito[$key]['id']);
            if ($producto && $request->cantidad > $producto->stock) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'ok' => false,
                        'message' => "Solo hay {$producto->stock} unidades disponibles.",
                        'stock_max' => $producto->stock,
                    ], 422);
                }
                return back()->with('error', "Solo hay {$producto->stock} unidades disponibles.");
            }
        }

        $carrito[$key]['cantidad'] = $request->cantidad;
        $this->guardarCarrito($carrito);

        $subtotal   = $carrito[$key]['precio'] * $carrito[$key]['cantidad'];
        $total      = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], $carrito));
        $totalItems = array_sum(array_column($carrito, 'cantidad'));

        if ($request->wantsJson()) {
            return response()->json([
                'ok'          => true,
                'key'         => $key,
                'cantidad'    => $carrito[$key]['cantidad'],
                'subtotal'    => number_format($subtotal, 2),
                'total'       => number_format($total, 2),
                'total_items' => $totalItems,
            ]);
        }

        return redirect()->route('carrito.index')->with('success', 'Cantidad actualizada.');
    }

    // ─── VACIAR EL CARRITO ────────────────────────────────────────────────────
    public function vaciar()
    {
        if (Auth::check()) {
            CarritoItem::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('carrito');
        }

        return redirect()->route('carrito.index')->with('success', 'Carrito vaciado.');
    }

    // ─── CONFIRMAR PEDIDO ─────────────────────────────────────────────────────
    public function confirmar(Request $request)
    {
        $carrito = $this->obtenerCarrito();

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        $metodoPago = $request->input('metodo_pago', 'efectivo');

        // Revalidar stock
        foreach ($carrito as $item) {
            if ($item['tipo'] === 'producto') {
                $producto = Producto::find($item['id']);
                if (!$producto || $producto->stock < $item['cantidad']) {
                    return redirect()->route('carrito.index')
                        ->with('error', "No hay stock suficiente de '{$item['nombre']}'.");
                }
            }
        }

        $total = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], $carrito));

        try {
            $pedido = DB::transaction(function () use ($carrito, $total, $metodoPago) {
                $pedido = Pedido::create([
                    'user_id'     => Auth::id(),
                    'total'       => $total,
                    'estado'      => 'pendiente',
                    'metodo_pago' => $metodoPago,
                ]);

                foreach ($carrito as $item) {
                    DetallePedido::create([
                        'pedido_id'       => $pedido->id,
                        'item_type'       => $item['tipo'],
                        'item_id'         => $item['id'],
                        'nombre_item'     => $item['nombre'],
                        'precio_unitario' => $item['precio'],
                        'cantidad'        => $item['cantidad'],
                        'subtotal'        => $item['precio'] * $item['cantidad'],
                    ]);

                    if ($item['tipo'] === 'producto') {
                        Producto::where('id', $item['id'])
                            ->decrement('stock', $item['cantidad']);
                    }
                }

                return $pedido;
            });
        } catch (\Exception $e) {
            return redirect()->route('carrito.index')
                ->with('error', 'Hubo un problema al procesar tu pedido. Intenta de nuevo.');
        }

        // Vaciar carrito (BD + sesión por si acaso)
        CarritoItem::where('user_id', Auth::id())->delete();
        session()->forget('carrito');

        if ($metodoPago === 'paypal') {
            return redirect()->route('paypal.iniciar', $pedido->id);
        }

        return redirect()->route('pedidos.show', $pedido->id)
            ->with('success', '¡Pedido #' . $pedido->id . ' confirmado!');
    }

    // ─── FUSIONAR CARRITO DE SESIÓN A BD (al hacer login) ─────────────────────
    public static function migrarSesionABD(): void
    {
        if (!Auth::check()) return;

        $carritoSesion = session('carrito', []);
        if (empty($carritoSesion)) return;

        foreach ($carritoSesion as $item) {
            $existente = CarritoItem::where('user_id', Auth::id())
                ->where('item_type', $item['tipo'])
                ->where('item_id', $item['id'])
                ->first();

            if ($existente) {
                $existente->increment('cantidad', $item['cantidad']);
            } else {
                CarritoItem::create([
                    'user_id'     => Auth::id(),
                    'item_type'   => $item['tipo'],
                    'item_id'     => $item['id'],
                    'nombre_item' => $item['nombre'],
                    'precio'      => $item['precio'],
                    'imagen'      => $item['imagen'] ?? null,
                    'cantidad'    => $item['cantidad'],
                ]);
            }
        }

        session()->forget('carrito');
    }
}