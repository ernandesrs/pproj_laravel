<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\Medias\ImageController as AdminImageController;
use App\Http\Controllers\AppStarter;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Member\MemberController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\FrontController;

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
Route::post('/email/verification-notification', [VerificationController::class, "sendLink"])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

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
Route::get("/", [FrontController::class, "index"])->name("front.index");
Route::get("/p/{slug}", [FrontController::class, "dinamicPage"])->name("front.dinamicPage");
if (env("APP_ENV") == "local") {
    Route::get("/builder/builder", [AppStarter::class, "index"]);
}

/**
 *
 * MEMBER ROUTES
 *
 */
Route::group([
    'prefix' => 'member',
    'middleware' => 'member',
], function () {

    Route::get("/", [MemberController::class, "index"])->name("member.index");
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

    Route::get("/", [AdminController::class, "index"])->name("admin.index");

    // USUÁRIOS
    Route::get("/usuarios", [AdminUserController::class, "index"])->name("admin.users.index");
    Route::get("/usuario/novo", [AdminUserController::class, "create"])->name("admin.users.create");
    Route::post("/usuario/salvar", [AdminUserController::class, "store"])->name("admin.users.store");
    Route::get("/usuario/ver/{user}", [AdminUserController::class, "show"])->name("admin.users.show");
    Route::get("/usuario/editar/{user}", [AdminUserController::class, "edit"])->name("admin.users.edit");
    Route::post("/usuario/atualizar/{user}", [AdminUserController::class, "update"])->name("admin.users.update");
    Route::post("/usuario/excluir-foto/{user}", [AdminUserController::class, "photoRemove"])->name("admin.users.photoRemove");
    Route::post("/usuario/excluir/{user}", [AdminUserController::class, "destroy"])->name("admin.users.destroy");
    Route::post("/usuario/promover/{user}", [AdminUserController::class, "promote"])->name("admin.users.promote");
    Route::post("/usuario/rebaixar/{user}", [AdminUserController::class, "demote"])->name("admin.users.demote");

    // MEDIAS: IMAGES
    Route::get("/midias/imagens", [AdminImageController::class, "index"])->name("admin.medias.images.index");
    Route::post("/midias/imagens", [AdminImageController::class, "index"])->name("admin.medias.images.index");
    Route::post("/midias/imagem/salvar", [AdminImageController::class, "store"])->name("admin.medias.images.store");
    Route::post("/midias/imagem/ver/{image}", [AdminImageController::class, "show"])->name("admin.medias.images.show");
    Route::post("/midias/imagem/atualizar/{image}", [AdminImageController::class, "update"])->name("admin.medias.images.update");
    Route::post("/midias/imagem/excluir/{image}", [AdminImageController::class, "destroy"])->name("admin.medias.images.destroy");

    // PÁGINAS
    Route::get("/paginas", [AdminPageController::class, "index"])->name("admin.pages.index");
    Route::get("/pagina/novo", [AdminPageController::class, "create"])->name("admin.pages.create");
    Route::post("/pagina/salvar", [AdminPageController::class, "store"])->name("admin.pages.store");
    Route::get("/pagina/editar/{page}", [AdminPageController::class, "edit"])->name("admin.pages.edit");
    Route::post("/pagina/update/{page}", [AdminPageController::class, "update"])->name("admin.pages.update");
    Route::post("/pagina/excluir/{page}", [AdminPageController::class, "destroy"])->name("admin.pages.destroy");
    Route::post("/pagina/excluir-capa/{page}", [AdminPageController::class, "coverRemove"])->name("admin.pages.coverRemove");
});
