<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\AuxiliarController;

// Página pública
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Formulario de registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Procesar registro
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');


// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:usuario'])->group(function () {
    Route::get('/home', [UsuarioController::class, 'home'])->name('usuario.home');
    Route::get('/catalogo', [UsuarioController::class, 'home'])->name('usuario.catalogo');

    // Rutas del carrito
    Route::get('/carrito', [UsuarioController::class, 'carrito'])->name('usuario.carrito');
    Route::post('/carrito/agregar/{id}', [UsuarioController::class, 'agregarAlCarrito'])->name('carrito.agregar');
    Route::post('/carrito/quitar/{itemId}', [UsuarioController::class, 'eliminarDelCarrito'])->name('carrito.quitar');
    Route::post('/carrito/checkout', [UsuarioController::class, 'realizarPedido'])->name('carrito.checkout');

    // detalle carrito
    Route::get('/producto/{id}', [UsuarioController::class, 'detalleProducto'])->name('usuario.detalle_producto');
});

Route::get('/test-aux', [AuxiliarController::class, 'productos']);

Route::middleware(['web', 'auth', 'role:auxiliar de bodega'])->group(function () {
    // Dashboard auxiliar
    Route::get('/auxiliar/dashboard', function () {
        return view('auxiliar.dashboard');
    })->name('auxiliar.dashboard');
    // Productos (listar y formulario)
    Route::get('/productos-auxiliar', [AuxiliarController::class, 'productos'])->name('auxiliar.productos');
    // Crear producto
    Route::post('/productos-auxiliar', [AuxiliarController::class, 'storeProducto'])->name('auxiliar.productos.store');
    // Editar producto (formulario)
    Route::get('/productos-auxiliar/{id}/editar', [AuxiliarController::class, 'editProducto'])->name('auxiliar.productos.edit');
    // Actualizar producto
    Route::post('/productos-auxiliar/{id}', [AuxiliarController::class, 'updateProducto'])->name('auxiliar.productos.update');
    // Eliminar producto
    Route::delete('/productos-auxiliar/{id}', [AuxiliarController::class, 'destroyProducto'])->name('auxiliar.productos.destroy');
});

Route::middleware(['auth', 'role:vendedor'])->group(function () {
    // Panel principal: historial, productos, compradores
    Route::get('/vendedor/dashboard', [VendedorController::class, 'panel'])->name('vendedor.dashboard'); // Renderiza vendedor/panel.blade.php
    // Registrar venta
    Route::post('/vendedor/venta', [VendedorController::class, 'registrarVenta'])->name('vendedor.registrarVenta');
});
