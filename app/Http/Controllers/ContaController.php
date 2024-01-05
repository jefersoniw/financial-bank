<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaStoreRequest;
use App\Models\Conta;
use Exception;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    private $contas;

    public function __construct(Conta $contas)
    {
        $this->contas = $contas;
    }

    public function index()
    {
        return \response()->json([
            $this->contas
                ->with('user', 'tipo_conta')
                ->whereNull('dt_encerramento')
                ->get()
        ], 200);
    }

    public function store(ContaStoreRequest $request)
    {
        try {
            $conta = $this->contas->createConta($request->validated());

            return \response()->json([
                'msg' => 'Conta criada com sucesso!',
                'dados' => $conta
            ], 200);
        } catch (Exception $e) {
            return \response()->json([
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function encerrar(Conta $conta)
    {
        try {

            if ($conta->saldo_disponivel > 0) {
                return \response()->json([
                    'error' => true,
                    'msg' => 'Não foi possível encerrar a conta, favor zerar o saldo disponível!',
                ], 200);
            }

            $encerrar = $this->contas->encerrarConta($conta);
            return \response()->json([
                'msg' => 'Conta encerrada com sucesso!',
                'dados' => $encerrar
            ], 200);
        } catch (Exception $e) {
            return \response()->json([
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}
