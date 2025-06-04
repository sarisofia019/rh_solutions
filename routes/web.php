<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\ContratoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Usuario\UsuarioAuthController;



// Ruta de inicio de sesión (vista)
Route::get('/', function () {
    return view('login');
})->name('login');
//----------------------- Rutas para el login y logout -----------------------------------------------//
// Ruta para enviar formulario de login General
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');//Login general

//--------------Rutas del Login y Logout Para el Admin-----------------//
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

//--------------Rutas del Login y Logout Para el Usuario-----------------//
Route::get('/usuario/login', [UsuarioAuthController::class, 'showLoginForm'])->name('usuario.login');
Route::post('/usuario/login', [UsuarioAuthController::class, 'login'])->name('usuario.login.submit');
Route::post('/usuario/logout', [UsuarioAuthController::class, 'logout'])->name('usuario.logout');


// Ruta protegida
Route::middleware('auth:usuario')->group(function () {
    Route::get('/usuario/dashboard', function () {
        return view('user.dashboard'); // crea esta vista también
    })->name('usuario.dashboard');
});

//-------------------------------------------------------------------------------------------------//

// --------------------- Recuperación de contraseña ----------------------------//

// 1. Mostrar formulario para ingresar la cédula
Route::get('password/request', [PasswordResetController::class, 'showRequestForm'])->name('password.request');

// 2. Enviar código por email o mensaje
Route::post('password/send-code', [PasswordResetController::class, 'sendCode'])->name('password.sendCode');

// 3. Mostrar formulario para ingresar el código de verificación
Route::get('password/verify', [PasswordResetController::class, 'showVerifyForm'])->name('password.verify');

// 4. Verificar el código ingresado
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

// 5. Mostrar formulario para cambiar la contraseña
Route::get('password/change', [PasswordResetController::class, 'showChangeForm'])->name('password.change');

// 6. Actualizar la contraseña en la base de datos
Route::post('password/update', [PasswordResetController::class, 'updatePassword'])->name('password.update');

/////////////////////// rutas para el admin ///////////////////////////////////////////////////////
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Aquí puedes agregar más rutas de admin protegidas

    // ruta para la lista
    Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');

    // esta ruta llama al controlador UsuarioController y se trae el reponse JSON
    Route::get('/admin/usuarios/{id}', [UsuarioController::class, 'obtenerUsuario'])->name('usuarios.obtener');

    // eliminar
    Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'eliminarUsuario'])->name('usuarios.eliminar');

    // buscar
    Route::get('/admin/usuarios/buscar', [UsuarioController::class, 'buscarUsuarios'])->name('usuarios.buscar');

    // editar
    Route::put('/admin/usuarios/editar/{id}', [UsuarioController::class, 'editarUsuario'])->name('usuarios.editar');

    // habilitar e inhabilitar
    Route::post('/admin/usuarios/inhabilitar/{id}', [UsuarioController::class, 'inhabilitarUsuario'])->name('usuarios.inhabilitar');
    Route::post('/admin/usuarios/habilitar/{id}', [UsuarioController::class, 'habilitarUsuario'])->name('usuarios.habilitar');

    // Listar contratos
    Route::get('/admin/contratos', [ContratoController::class, 'index'])->name('contratos.index');

    // Crear contrato
    Route::post('/admin/contratos', [ContratoController::class, 'store'])->name('contratos.store');

    // Editar contrato
    Route::put('/admin/contratos/{id}', [ContratoController::class, 'update'])->name('contratos.update');

    // Eliminar contrato
    Route::delete('/admin/contratos/{id}', [ContratoController::class, 'destroy'])->name('contratos.destroy');

    // Generar certificado en PDF
    Route::get('/admin/contratos/certificado/{id}', [ContratoController::class, 'generarCertificado'])->name('contratos.certificado');



});
//////////////////////////////////////////////////////////////////////////////////////////////////
