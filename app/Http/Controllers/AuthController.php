<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REGISTRO
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'cliente',   // todos se registran como cliente por defecto
        ]);

        return redirect('/login')
            ->with('success', 'Usuario registrado correctamente');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin(Request $request)
    {
        // Si viene con ?intent=producto_5 o ?intent=curso_3, lo guarda en sesión
        if ($request->has('intent')) {
            session(['pending_cart_add' => $request->intent]);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credenciales = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credenciales)) {

            $request->session()->regenerate();

            // ← AQUÍ AGREGA ESTA LÍNEA
            \App\Http\Controllers\CarritoController::migrarSesionABD();

            $user = Auth::user();

            // ─── Si hay una intención de agregar al carrito, procesarla ───
            if (session()->has('pending_cart_add')) {
                $intent = session()->pull('pending_cart_add'); // ej: "producto_5"
                $partes = explode('_', $intent);

                if (count($partes) === 2) {
                    [$tipo, $id] = $partes;

                    // Buscar el item
                    if ($tipo === 'producto') {
                        $item = \App\Models\Producto::find($id);
                    } elseif ($tipo === 'curso') {
                        $item = \App\Models\Curso::find($id);
                    } else {
                        $item = null;
                    }

                    if ($item) {
                        // Agregar al carrito (sesión)
                        $carrito = session('carrito', []);
                        $key = "{$tipo}_{$id}";

                        if (isset($carrito[$key])) {
                            $carrito[$key]['cantidad']++;
                        } else {
                            $carrito[$key] = [
                                'key'      => $key,
                                'tipo'     => $tipo,
                                'id'       => $id,
                                'nombre'   => $item->nombre,
                                'precio'   => $item->precio,
                                'imagen'   => $item->imagen ?? null,
                                'cantidad' => 1,
                            ];
                        }
                        session(['carrito' => $carrito]);

                        // Redirigir al carrito directamente
                        return redirect('/carrito')
                            ->with('success', "'{$item->nombre}' fue agregado a tu carrito.");
                    }
                }
            }

            // Si no había intención pendiente, redirigir según rol
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Correo o contraseña incorrectos.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
