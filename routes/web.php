<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\SocieteController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\TypeStageController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('module:dashboard,lecture')
        ->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])
        ->middleware('module:users,lecture')
        ->name('users');
    Route::get('/users/create', [UserController::class, 'create'])
        ->middleware('module:users,ecriture')
        ->name('users.create');
    Route::post('/users', [UserController::class, 'store'])
        ->middleware('module:users,ecriture')
        ->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('module:users,modification')
        ->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])
        ->middleware('module:users,modification')
        ->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('module:users,suppression')
        ->name('users.destroy');

    // Routes pour les nomenclatures
    Route::get('/nomenclatures', [NomenclatureController::class, 'index'])
        ->middleware('module:nomenclatures,lecture')
        ->name('nomenclatures');
    Route::get('/nomenclatures/create', [NomenclatureController::class, 'create'])
        ->middleware('module:nomenclatures,ecriture')
        ->name('nomenclatures.create');
    Route::post('/nomenclatures', [NomenclatureController::class, 'store'])
        ->middleware('module:nomenclatures,ecriture')
        ->name('nomenclatures.store');
    Route::get('/nomenclatures/{nomenclature}/edit', [NomenclatureController::class, 'edit'])
        ->middleware('module:nomenclatures,modification')
        ->name('nomenclatures.edit');
    Route::put('/nomenclatures/{nomenclature}', [NomenclatureController::class, 'update'])
        ->middleware('module:nomenclatures,modification')
        ->name('nomenclatures.update');
    Route::delete('/nomenclatures/{nomenclature}', [NomenclatureController::class, 'destroy'])
        ->middleware('module:nomenclatures,suppression')
        ->name('nomenclatures.destroy');

    // Routes pour les sociétés
    Route::get('/societes', [SocieteController::class, 'index'])
        ->middleware('module:societes,lecture')
        ->name('societes');
    Route::get('/societes/create', [SocieteController::class, 'create'])
        ->middleware('module:societes,ecriture')
        ->name('societes.create');
    Route::post('/societes', [SocieteController::class, 'store'])
        ->middleware('module:societes,ecriture')
        ->name('societes.store');
    Route::get('/societes/{id}/edit', [SocieteController::class, 'edit'])
        ->middleware('module:societes,modification')
        ->name('societes.edit');
    Route::put('/societes/{id}', [SocieteController::class, 'update'])
        ->middleware('module:societes,modification')
        ->name('societes.update');
    Route::delete('/societes/{id}', [SocieteController::class, 'destroy'])
        ->middleware('module:societes,suppression')
        ->name('societes.delete');

    // Routes pour les stages
    Route::get('/stages', [StageController::class, 'index'])
        ->middleware('module:stages,lecture')
        ->name('stages');
    Route::get('/stages/create', [StageController::class, 'create'])
        ->middleware('module:stages,ecriture')
        ->name('stages.create');
    Route::post('/stages', [StageController::class, 'store'])
        ->middleware('module:stages,ecriture')
        ->name('stages.store');
    Route::get('/stages/{stage}/edit', [StageController::class, 'edit'])
        ->middleware('module:stages,modification')
        ->name('stages.edit');
    Route::put('/stages/{stage}', [StageController::class, 'update'])
        ->middleware('module:stages,modification')
        ->name('stages.update');
    Route::delete('/stages/{stage}', [StageController::class, 'destroy'])
        ->middleware('module:stages,suppression')
        ->name('stages.delete');

    // Routes pour les types de stages
    Route::get('/type-stages', [TypeStageController::class, 'index'])
        ->middleware('module:type-stages,lecture')
        ->name('type-stages');
    Route::get('/type-stages/create', [TypeStageController::class, 'create'])
        ->middleware('module:type-stages,ecriture')
        ->name('type-stages.create');
    Route::post('/type-stages', [TypeStageController::class, 'store'])
        ->middleware('module:type-stages,ecriture')
        ->name('type-stages.store');
    Route::get('/type-stages/{id}/edit', [TypeStageController::class, 'edit'])
        ->middleware('module:type-stages,modification')
        ->name('type-stages.edit');
    Route::put('/type-stages/{id}', [TypeStageController::class, 'update'])
        ->middleware('module:type-stages,modification')
        ->name('type-stages.update');
    Route::delete('/type-stages/{id}', [TypeStageController::class, 'destroy'])
        ->middleware('module:type-stages,suppression')
        ->name('type-stages.destroy');

    // Routes pour les groupes et droits
    Route::get('/groupes', [GroupeController::class, 'index'])
        ->middleware('module:groupes,lecture')
        ->name('groupes');
    Route::get('/groupes/create', [GroupeController::class, 'create'])
        ->middleware('module:groupes,ecriture')
        ->name('groupes.create');
    Route::post('/groupes', [GroupeController::class, 'store'])
        ->middleware('module:groupes,ecriture')
        ->name('groupes.store');
    Route::get('/groupes/{groupe}/edit', [GroupeController::class, 'edit'])
        ->middleware('module:groupes,modification')
        ->name('groupes.edit');
    Route::put('/groupes/{groupe}', [GroupeController::class, 'update'])
        ->middleware('module:groupes,modification')
        ->name('groupes.update');
    Route::delete('/groupes/{groupe}', [GroupeController::class, 'destroy'])
        ->middleware('module:groupes,suppression')
        ->name('groupes.destroy');
});
