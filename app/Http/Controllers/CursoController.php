<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    // ─── PÚBLICO: catálogo de cursos ────────────────────────────────────────────
    public function catalogo()
    {
        $cursos = Curso::activos()->latest()->paginate(9);
        return view('cursos.catalogo', compact('cursos'));
    }

    public function detalle($id)
    {
        $curso = Curso::findOrFail($id);
        return view('cursos.detalle', compact('curso'));
    }

    // ─── ADMIN: CRUD ────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Curso::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('categoria', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('nivel') && in_array($request->nivel, ['básico', 'intermedio', 'avanzado'])) {
            $query->where('nivel', $request->nivel);
        }

        $cursos = $query->latest()->paginate(10)->withQueryString();

        return view('admin.cursos.lista', compact('cursos'));
    }
    public function create()
    {
        return view('admin.cursos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'duracion'    => 'nullable|string|max:100',
            'categoria'   => 'nullable|string|max:100',
            'nivel'       => 'required|in:básico,intermedio,avanzado',
            'estado'      => 'required|in:activo,inactivo',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('cursos', 'public');
        }

        Curso::create($data);

        return redirect()->route('admin.cursos.index')
            ->with('success', 'Curso creado correctamente.');
    }

    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        return view('admin.cursos.edit', compact('curso'));
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'duracion'    => 'nullable|string|max:100',
            'categoria'   => 'nullable|string|max:100',
            'nivel'       => 'required|in:básico,intermedio,avanzado',
            'estado'      => 'required|in:activo,inactivo',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('cursos', 'public');
        }

        $curso->update($data);

        return redirect()->route('admin.cursos.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy($id)
    {
        Curso::findOrFail($id)->delete();
        return redirect()->route('admin.cursos.index')
            ->with('success', 'Curso eliminado.');
    }
}
