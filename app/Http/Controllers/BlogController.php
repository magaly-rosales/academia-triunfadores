<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // ─── PÚBLICO: lista de posts ─────────────────────────────────────────────
    public function lista()
    {
        $posts = Post::publicados()->latest('publicado_en')->paginate(9);
        return view('blog.lista', compact('posts'));
    }

    // ─── PÚBLICO: detalle de un post ────────────────────────────────────────
    public function detalle($slug)
    {
        $post = Post::publicados()->where('slug', $slug)->firstOrFail();
        // Posts recientes para el sidebar
        $recientes = Post::publicados()->where('id', '!=', $post->id)->latest('publicado_en')->take(4)->get();
        return view('blog.detalle', compact('post', 'recientes'));
    }

    // ─── ADMIN: lista de todos los posts ────────────────────────────────────
    public function adminLista(Request $request)
    {
        $query = Post::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                    ->orWhere('categoria', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado') && in_array($request->estado, ['borrador', 'publicado'])) {
            $query->where('estado', $request->estado);
        }

        $posts = $query->latest()->paginate(10)->withQueryString();

        return view('admin.blog.lista', compact('posts'));
    }

    // ─── ADMIN: formulario crear ─────────────────────────────────────────────
    public function create()
    {
        return view('admin.blog.create');
    }

    // ─── ADMIN: guardar nuevo post ───────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'     => 'required|string|max:255',
            'resumen'    => 'nullable|string|max:500',
            'contenido'  => 'required|string',
            'categoria'  => 'nullable|string|max:100',
            'estado'     => 'required|in:borrador,publicado',
            'imagen'     => 'nullable|image|max:2048',
        ]);

        $data['slug']    = Post::generarSlug($request->titulo);
        $data['user_id'] = Auth::id();

        if ($request->estado === 'publicado') {
            $data['publicado_en'] = now();
        }

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('blog', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.blog.lista')
            ->with('success', 'Post creado correctamente.');
    }

    // ─── ADMIN: formulario editar ────────────────────────────────────────────
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.blog.edit', compact('post'));
    }

    // ─── ADMIN: actualizar post ──────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $data = $request->validate([
            'titulo'    => 'required|string|max:255',
            'resumen'   => 'nullable|string|max:500',
            'contenido' => 'required|string',
            'categoria' => 'nullable|string|max:100',
            'estado'    => 'required|in:borrador,publicado',
            'imagen'    => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Post::generarSlug($request->titulo);

        if ($request->estado === 'publicado' && !$post->publicado_en) {
            $data['publicado_en'] = now();
        }

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('blog', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.blog.lista')
            ->with('success', 'Post actualizado correctamente.');
    }

    // ─── ADMIN: eliminar post ────────────────────────────────────────────────
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('admin.blog.lista')
            ->with('success', 'Post eliminado.');
    }
}
