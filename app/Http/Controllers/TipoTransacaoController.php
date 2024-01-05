<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoTransacaoRequest;
use App\Models\TipoTransacao;
use Exception;
use Illuminate\Http\Request;

class TipoTransacaoController extends Controller
{
    private $tipoTransacao;

    public function __construct(TipoTransacao $tipoTransacao)
    {
        $this->tipoTransacao = $tipoTransacao;
    }

    public function index()
    {
        return \response()->json([
            $this->tipoTransacao->all()
        ], 200);
    }

    public function store(TipoTransacaoRequest $request)
    {
        try {
            $tipoTransacao = $this->tipoTransacao->createTipoTransacao($request->validated());

            return \response()->json([
                'msg' => 'Tipo transação cadastrado com sucesso!',
                'dados' => $tipoTransacao
            ], 200);
        } catch (Exception $e) {
            return \response()->json([
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function delete(TipoTransacao $tipoTransacao)
    {
        $tipoTransacao->delete();

        return \response()->json([
            'msg' => 'Tipo de transação excluída com sucesso!'
        ], 200);
    }
}
