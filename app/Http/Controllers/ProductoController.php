<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    // ─── PÚBLICO: tienda ────────────────────────────────────────────────────────
    public function tienda()
    {
        $productos = Producto::activos()->latest()->paginate(12);
        return view('tienda.index', compact('productos'));
    }

    public function detalle($id)
    {
        $producto = Producto::findOrFail($id);
        return view('tienda.detalle', compact('producto'));
    }

    // ─── ADMIN: CRUD ────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Producto::query();

        // Buscador
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('categoria', 'like', "%{$buscar}%");
            });
        }

        // Filtro por estado
        if ($request->filled('estado') && in_array($request->estado, ['activo', 'inactivo'])) {
            $query->where('estado', $request->estado);
        }

        $productos = $query->latest()->paginate(10)->withQueryString();

        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.productos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'categoria'   => 'nullable|string|max:100',
            'estado'      => 'required|in:activo,inactivo',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.productos.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'categoria'   => 'nullable|string|max:100',
            'estado'      => 'required|in:activo,inactivo',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        Producto::findOrFail($id)->delete();
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado.');
    }
}
