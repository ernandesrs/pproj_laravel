<?php

use App\Http\Controllers\Admin\AdminController;
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
    return view('welcome');
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
});
