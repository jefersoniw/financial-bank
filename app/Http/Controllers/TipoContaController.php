<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoContaRequest;
use App\Models\TipoConta;
use Exception;
use Illuminate\Http\Request;

class TipoContaController extends Controller
{
    private $tipoConta;

    public function __construct(TipoConta $tipoConta)
    {
        $this->tipoConta = $tipoConta;
    }

    public function index()
    {
        return \response()->json([
            $this->tipoConta->all()
        ], 200);
    }

    public function store(TipoContaRequest $request)
    {
        try {
            $tipoConta = $this->tipoConta->createTipoConta($request->validated());

            return \response()->json([
                'msg' => 'Tipo de conta criada com sucesso!',
                'dados' => $tipoConta
            ], 200);
        } catch (Exception $e) {
            return \response()->json([
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ], 200);
        }
    }

    public function delete(TipoConta $tipoConta)
    {
        $tipoConta->delete();

        return \response()->json([
            'msg' => 'Tipo de conta excluído com sucesso!'
        ]);
    }
}
