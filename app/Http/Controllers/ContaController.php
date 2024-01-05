<?php

namespace App\Http\Controllers;

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
            $this->contas->with('users', 'tipo_conta')
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $conta = $this->contas->createConta($request->all());

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

    public function update(Conta $conta, Request $request)
    {
    }
}
