<?php

use App\Http\Controllers\ContaController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\TipoClienteController;
use App\Http\Controllers\TipoContaController;
use App\Http\Controllers\TipoTransacaoController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'users'], function () {

    route::get('/', [userController::class, 'index']);
    route::post('/', [userController::class, 'store']);
    route::get('/{user}', [userController::class, 'show']);
    route::put('/{user}', [userController::class, 'update']);
    route::put('/{user}/deactive', [userController::class, 'desativarUser']);
});

Route::group(['prefix' => 'tipo-clientes'], function () {

    route::get('/', [TipoClienteController::class, 'index']);
    route::post('/', [TipoClienteController::class, 'store']);
    route::delete('/{tipoCliente}', [TipoClienteController::class, 'delete']);
});

Route::group(['prefix' => 'tipo-contas'], function () {

    route::get('/', [TipoContaController::class, 'index']);
    route::post('/', [TipoContaController::class, 'store']);
    route::delete('/{tipoConta}', [TipoContaController::class, 'delete']);
});

Route::group(['prefix' => 'contas'], function () {

    route::get('/', [ContaController::class, 'index']);
    route::post('/', [ContaController::class, 'store']);
    route::put('/{conta}/encerrar', [ContaController::class, 'encerrar']);
});

Route::group(['prefix' => 'tipo-transacoes'], function () {

    route::get('/', [TipoTransacaoController::class, 'index']);
    route::post('/', [TipoTransacaoController::class, 'store']);
    route::delete('/{tipoTransacao}', [TipoTransacaoController::class, 'delete']);
});

Route::group(['prefix' => 'transacao'], function () {

    route::get('/', [TransacaoController::class, 'index']);
    route::post('/deposito', [TransacaoController::class, 'depositar']);
    route::post('/saque', [TransacaoController::class, 'sacar']);
});

Route::group(['prefix' => 'historico'], function () {

    route::get('/{user}', [HistoricoController::class, 'index']);
});
