<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoContaRequest;
use App\Models\TipoConta;
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
        $tipoConta = $this->tipoConta->createTipoConta($request->validated());

        if (!empty($tipoConta['error'])) {

            return response()->json([
                $tipoConta
            ], 400);
        }

        return \response()->json([
            $tipoConta
        ], 200);
    }

    public function delete(TipoConta $tipoConta)
    {
        $tipoConta->delete();

        return \response()->json([
            'msg' => 'Tipo de conta excluído com sucesso!'
        ]);
    }
}
