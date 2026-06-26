<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
class PedidoController extends Controller
{
    // ─── CLIENTE: ver su pedido confirmado ──────────────────────────────────────
    public function show($id)
    {
        $pedido = Pedido::with('detalles')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        return view('carrito.confirmacion', compact('pedido'));
    }

    // ─── CLIENTE: historial de sus pedidos ──────────────────────────────────────
    public function misPedidos()
    {
        $pedidos = Pedido::with('detalles')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('carrito.mis_pedidos', compact('pedidos'));
    }

    // ─── ADMIN: listado con buscador y filtros ──────────────────────────────────
    public function adminIndex(Request $request)
    {
        $query = Pedido::with('user');

        // Filtro por estado
        if ($request->filled('estado') && in_array($request->estado, ['pendiente', 'pagado', 'cancelado'])) {
            $query->where('estado', $request->estado);
        }

        // Buscador (por # pedido, nombre o email del cliente)
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('id', $buscar)
                  ->orWhereHas('user', function ($sub) use ($buscar) {
                      $sub->where('name', 'like', "%{$buscar}%")
                          ->orWhere('email', 'like', "%{$buscar}%");
                  });
            });
        }

        $pedidos = $query->latest()->paginate(15)->withQueryString();

        // Estadísticas rápidas
        $stats = [
            'total'      => Pedido::count(),
            'pendientes' => Pedido::where('estado', 'pendiente')->count(),
            'pagados'    => Pedido::where('estado', 'pagado')->count(),
            'cancelados' => Pedido::where('estado', 'cancelado')->count(),
            'ingresos'   => Pedido::where('estado', 'pagado')->sum('total'),
        ];

        return view('admin.pedidos.index', compact('pedidos', 'stats'));
    }

    // ─── ADMIN: ver detalle de un pedido ────────────────────────────────────────
    public function adminShow($id)
    {
        $pedido = Pedido::with(['detalles', 'user'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }
}