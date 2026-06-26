<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\BlogController;

// ═══════════════════════════════════════════════════════════════════
// RUTAS PÚBLICAS (sin login)
// ═══════════════════════════════════════════════════════════════════

Route::get('/', fn() => view('index'));
Route::get('/nosotros', fn() => view('nosotros'));
Route::get('/galeria', fn() => view('galeria'));
Route::get('/contactos', fn() => view('contactos'));

// Blog público
Route::get('/blog', [BlogController::class, 'lista'])->name('blog.lista');
Route::get('/blog/{slug}', [BlogController::class, 'detalle'])->name('blog.detalle');

// Catálogo público de cursos
Route::get('/cursos', [CursoController::class, 'catalogo'])->name('cursos.catalogo');
Route::get('/cursos/{id}', [CursoController::class, 'detalle'])->name('cursos.detalle');

// Tienda pública de productos
Route::get('/tienda', [ProductoController::class, 'tienda'])->name('tienda.index');
Route::get('/tienda/{id}', [ProductoController::class, 'detalle'])->name('tienda.detalle');



// ─── AUTH ──────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ═══════════════════════════════════════════════════════════════════
// RUTAS PRIVADAS (requieren login)
// ═══════════════════════════════════════════════════════════════════

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // ─── CARRITO (requiere login) ───
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::delete('/carrito/quitar/{key}', [CarritoController::class, 'quitar'])->name('carrito.quitar');
    Route::patch('/carrito/actualizar/{key}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
    Route::post('/carrito/confirmar', [CarritoController::class, 'confirmar'])->name('carrito.confirmar');

    // ─── MIS PEDIDOS ───
    Route::get('/mis-pedidos', [PedidoController::class, 'misPedidos'])->name('pedidos.mis');
    Route::get('/mis-pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');

    // ─── PAGOS PAYPAL ───
    Route::get('/checkout/paypal/{pedido}', [\App\Http\Controllers\PagoController::class, 'iniciar'])->name('paypal.iniciar');
    Route::get('/checkout/paypal/{pedido}/exito', [\App\Http\Controllers\PagoController::class, 'exito'])->name('paypal.exito');
    Route::get('/checkout/paypal/{pedido}/cancelar', [\App\Http\Controllers\PagoController::class, 'cancelar'])->name('paypal.cancelar');
});

// ═══════════════════════════════════════════════════════════════════
// RUTAS ADMIN (requieren login + role=admin)
// ═══════════════════════════════════════════════════════════════════

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // Gestión de alumnos
    Route::get('/alumnos',                [AlumnoController::class, 'index'])->name('alumnos.index');
    Route::get('/alumnos/create',         [AlumnoController::class, 'create'])->name('alumnos.create');
    Route::post('/alumnos',               [AlumnoController::class, 'store'])->name('alumnos.store');
    Route::get('/alumnos/{id}/edit',      [AlumnoController::class, 'edit'])->name('alumnos.edit');
    Route::put('/alumnos/{id}',           [AlumnoController::class, 'update'])->name('alumnos.update');
    Route::delete('/alumnos/{id}',        [AlumnoController::class, 'destroy'])->name('alumnos.destroy');

    // Gestión de cursos
    Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/create', [CursoController::class, 'create'])->name('cursos.create');
    Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
    Route::get('/cursos/{id}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
    Route::put('/cursos/{id}', [CursoController::class, 'update'])->name('cursos.update');
    Route::delete('/cursos/{id}', [CursoController::class, 'destroy'])->name('cursos.destroy');

    // Gestión de productos
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Gestión de pedidos
    Route::get('/pedidos', [PedidoController::class, 'adminIndex'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [PedidoController::class, 'adminShow'])->name('pedidos.show');

    // Gestión de blog
    Route::get('/blog', [BlogController::class, 'adminLista'])->name('blog.lista');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');
});
