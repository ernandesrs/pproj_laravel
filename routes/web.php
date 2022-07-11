<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Member\MemberController;
use Illuminate\Support\Facades\Route;

/**
 *
 * AUTH ROUTES
 *
 */
Route::get("/login", [LoginController::class, "login"])->middleware('guest')->name("auth.login");
Route::post("/authenticate", [LoginController::class, "authenticate"])->middleware('guest')->name("auth.authenticate");
Route::get("/logout", [LoginController::class, "logout"])->middleware('auth')->name("auth.logout");

Route::get("/register", [RegisterController::class, "register"])->middleware('guest')->name("auth.register");
Route::post("/store", [RegisterController::class, "store"])->middleware('guest')->name("auth.store");

// AVISO PARA USUÁRIO VERIFICAR O EMAIL
Route::get('/email/verify', [VerificationController::class, "notice"])->middleware('auth')->name('verification.notice');

// VERIFICA O EMAIL
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, "verify"])->middleware(['auth', 'signed'])->name('verification.verify');

// REENVIA O LINK DE VERIFICAÇÃO
Route::post('/email/verification-notification', [VerificationController::class, "VerificationController@sendLink"])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// VIEW DE ESQUECI A SENHA
Route::get('/forgot-password', [ForgotController::class, "forgotForm"])->middleware('guest')->name('password.request');

// ENVIO DE EMAIL COM LINK DE RECUPERAÇÃO DE SENHA
Route::post('/forgot-password', [ForgotController::class, "sendLink"])->middleware('guest')->name('password.email');

// VIEW DE RESET DE SENHA
Route::get('/reset-password/{token}', [ResetController::class, "resetForm"])->middleware('guest')->name('password.reset');

// RECUPERAÇÃO DE SENHA
Route::post('/reset-password', [ResetController::class, "updatePassword"])->middleware('guest')->name('password.update');

/**
 *
 * FRONT ROUTES
 *
 */
Route::get('/', function () {
    return view('front.home', ["pageTitle" => "Página inicial"]);
})->name("front.home");

/**
 *
 * MEMBER ROUTES
 *
 */
Route::group([
    'prefix' => 'member',
    'middleware' => 'member',
], function () {

    Route::get("/", [MemberController::class, "home"])->name("member.home");
    Route::get("/example-1", [MemberController::class, "example"])->name("member.example");
    Route::get("/example-2", [MemberController::class, "exampleTwo"])->name("member.exampleTwo");

    Route::get("/perfil", [MemberController::class, "profile"])->name("member.profile");
    Route::post("/atualizar-perfil", [MemberController::class, "profileUpdate"])->name("member.profileUpdate");
});

/**
 *
 * ADMIN ROUTES
 *
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin'
], function () {

    Route::get("/", [AdminController::class, "home"])->name("admin.home");

    Route::get("/usuarios/lista", [UserController::class, "index"])->name("admin.users.index");
    Route::get("/usuario/novo", [UserController::class, "create"])->name("admin.users.create");
    Route::post("/usuario/salvar", [UserController::class, "store"])->name("admin.users.store");
    Route::get("/usuario/ver/{user}", [UserController::class, "show"])->name("admin.users.show");
    Route::get("/usuario/editar/{user}", [UserController::class, "edit"])->name("admin.users.edit");
    Route::post("/usuario/atualizar/{user}", [UserController::class, "update"])->name("admin.users.update");
    Route::post("/usuario/excluir-foto/{user}", [UserController::class, "photoRemove"])->name("admin.users.photoRemove");
    Route::post("/usuario/excluir/{user}", [UserController::class, "destroy"])->name("admin.users.destroy");

    //
});
