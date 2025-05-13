<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController; // Importa el RegisterController
use App\Http\Controllers\TuControladorDeCompra; // Importa el controlador de compra
use App\Http\Controllers\AuthController; // Asegúrate de que AuthController esté importado

// Ruta para la página de bienvenida (ahora manejada por EventoController)
Route::get('/', [EventoController::class, 'showBienvenida'])->name('bienvenida');

// Rutas para mostrar la lista de eventos (si la necesitas en otra URL)

// Rutas de login utilizando el LoginController con middleware 'guest'
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Rutas de registro utilizando el RegisterController con middleware 'guest'
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Asumo que AuthController maneja el logout

// Rutas de restablecimiento de contraseña (generadas por Laravel)
Auth::routes(['register' => false, 'reset' => true, 'verify' => false, 'login' => false]); // Excluye las rutas de autenticación predeterminadas

// Ruta para "Contáctanos"
Route::get('/contactanos', function () {
    return view('contactanos');
})->name('contactanos');


// Rutas protegidas para eventos (solo usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/eventos/crear', [EventoController::class, 'create'])->name('eventos.create');
    Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
    Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');

    // Rutas del carrito DENTRO del middleware 'auth'

    Route::post('/carrito/agregar/{evento}', [TuControladorDeCompra::class, 'agregar'])->name('carrito.agregar');
    Route::get('/carrito/obtener', [TuControladorDeCompra::class, 'obtener'])->name('carrito.obtener');
    Route::delete('/carrito/eliminar/{itemId}', [TuControladorDeCompra::class, 'eliminar'])->name('carrito.eliminar');
});

//Vista para cada uno de los eventos que tengo implementados
Route::get('/comprar/evento/{id}', [TuControladorDeCompra::class, 'mostrarFormularioCompra'])->name('comprar.evento');
Route::get('/categorias/conciertos', [EventoController::class, 'mostrarConciertos'])->name('categorias.conciertos');
Route::get('/categorias/conciertos/remover', [EventoController::class, 'removerFiltroConciertos'])->name('categorias.conciertos.remover');
Route::get('/categorias/deportes', [EventoController::class, 'mostrarDeportes'])->name('categorias.deportes');
Route::get('/categorias/deportes/remover', [EventoController::class, 'removerFiltroDeportes'])->name('categorias.deportes.remover');
Route::get('/categorias/experiencias', [EventoController::class, 'mostrarExperiencias'])->name('categorias.experiencias');
Route::get('/categorias/experiencias/remover', [EventoController::class, 'removerFiltroExperiencias'])->name('categorias.experiencias.remover');
Route::get('/categorias/familia', [EventoController::class, 'mostrarFamilia'])->name('categorias.familia');
Route::get('/categorias/familia/remover', [EventoController::class, 'removerFiltroFamilia'])->name('categorias.familia.remover');
Route::get('/categorias/festival', [EventoController::class, 'mostrarFestival'])->name('categorias.festival');
Route::get('/categorias/festival/remover', [EventoController::class, 'removerFiltroFestival'])->name('categorias.festival.remover');
Route::get('/categorias/forosseminarios', [EventoController::class, 'mostrarForosseminarios'])->name('categorias.forosseminarios');
Route::get('/categorias/forosseminarios/remover', [EventoController::class, 'removerFiltroForosseminarios'])->name('categorias.forosseminarios.remover');
Route::get('/categorias/museoexposiciones', [EventoController::class, 'mostrarMuseoexposiciones'])->name('categorias.museoexposiciones');
Route::get('/categorias/museoexposiciones/remover', [EventoController::class, 'removerFiltroMuseoexposiciones'])->name('categorias.museoexposiciones.remover');
Route::get('/categorias/teatro', [EventoController::class, 'mostrarTeatro'])->name('categorias.teatro');
Route::get('/categorias/teatro/remover', [EventoController::class, 'removerFiltroTeatro'])->name('categorias.teatro.remover');



Route::get('/buscar', [EventoController::class, 'buscar'])->name('eventos.buscar');