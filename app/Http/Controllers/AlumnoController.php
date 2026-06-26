<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumno::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellido', 'like', "%{$buscar}%")
                  ->orWhere('curso', 'like', "%{$buscar}%");
            });
        }

        $alumnos = $query->latest()->paginate(15)->withQueryString();

        return view('admin.alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        return view('admin.alumnos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo'   => 'required|string|max:50|unique:alumnos,codigo',
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'edad'     => 'required|integer|min:1|max:120',
            'curso'    => 'required|string|max:100',
        ]);

        Alumno::create($data);

        return redirect()->route('admin.alumnos.index')
            ->with('success', 'Alumno registrado correctamente.');
    }

    public function edit($id)
    {
        $alumno = Alumno::findOrFail($id);
        return view('admin.alumnos.edit', compact('alumno'));
    }

    public function update(Request $request, $id)
    {
        $alumno = Alumno::findOrFail($id);

        $data = $request->validate([
            'codigo'   => 'required|string|max:50|unique:alumnos,codigo,' . $alumno->id,
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'edad'     => 'required|integer|min:1|max:120',
            'curso'    => 'required|string|max:100',
        ]);

        $alumno->update($data);

        return redirect()->route('admin.alumnos.index')
            ->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy($id)
    {
        Alumno::findOrFail($id)->delete();
        return redirect()->route('admin.alumnos.index')
            ->with('success', 'Alumno eliminado.');
    }
}