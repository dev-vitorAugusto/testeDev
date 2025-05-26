<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VendasController;
use Illuminate\Support\Facades\Route;

// COLOCANDO A TELA DE REGISTRO COMO TELA INICIAL DO SISTEMA 
Route::get('/', function () {
    return view('/auth/register');
});

// DEFININDO ROTAS DE OUTRAS ELAS JUNTO COM A AUTENTICAÇÃO
Route::get('/dashboard', [ClienteController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

// DEFININDO ROTA E CHAMADNO O MÉTODO STORE()
Route::post('/vendas', [VendasController::class, 'store'])->name('vendas.store');

// DEFININFO ROTA E CHAMANDO INDEX()
Route::get('/vendas', [VendasController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('vendas'); 

// ROTAS PARA EDITAR E EXCLUIR OS DADOS DE VENDAS
Route::get('/vendas/{id}', [VendasController::class, 'edit'])->name('vendas.edit');
Route::put('/vendas/{id}', [VendasController::class, 'update'])->name('vendas.update');
Route::delete('/vendas/{id}', [VendasController::class, 'destroy'])->name('vendas.destroy');


// AUTENTICAÇÃO PADRÃO DO BREEZE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
