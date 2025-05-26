<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VendasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/auth/register');
});

Route::get('/dashboard', [ClienteController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

// Para salvar a venda
Route::post('/vendas', [VendasController::class, 'store'])->name('vendas.store');

// Para listar as vendas já feitas
Route::get('/vendas', [VendasController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('vendas'); 

// ROTAS PARA EDITAR E EXCLUIR OS DADOS DE VENDAS
Route::get('/vendas/{id}', [VendasController::class, 'edit'])->name('vendas.edit');
Route::put('/vendas/{id}', [VendasController::class, 'update'])->name('vendas.update');
Route::delete('/vendas/{id}', [VendasController::class, 'destroy'])->name('vendas.destroy');


    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
