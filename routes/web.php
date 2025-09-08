<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', [VideoController::class, 'index'])->name('welcome');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rota para a página de gerenciamento de sugestões
    Route::get('/gerenciar-sugestoes', [\App\Http\Controllers\DashboardController::class, 'index'])->name('sugestoes.gerenciar');

    // Grupo de rotas para gerenciamento de sugestões
    Route::prefix('sugestoes')->name('sugestoes.')->group(function () {
        Route::post('/', [\App\Http\Controllers\SugestaoController::class, 'store'])->name('store');
        Route::get('/{sugestao}/edit', [\App\Http\Controllers\SugestaoController::class, 'edit'])->name('edit');
        Route::put('/{sugestao}', [\App\Http\Controllers\SugestaoController::class, 'update'])->name('update');
        Route::delete('/{sugestao}', [\App\Http\Controllers\SugestaoController::class, 'destroy'])->name('destroy');
    });
});


require __DIR__.'/auth.php';
