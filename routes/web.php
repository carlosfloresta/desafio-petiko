<?php

use App\Http\Controllers\FormPedidoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FormPedidoController::class, 'index'])->name('form-pedido');

Route::post('/busca-cep', [FormPedidoController::class, 'buscaCep'])->name('busca-cep');

Route::post('/salvar', [FormPedidoController::class, 'create'])->name('salvar');
