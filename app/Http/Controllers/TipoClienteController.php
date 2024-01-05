<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoClienteRequest;
use App\Models\TipoCliente;
use Exception;
use Illuminate\Http\Request;

class TipoClienteController extends Controller
{
    private $tipoCliente;

    public function __construct(TipoCliente $tipoCliente)
    {
        $this->tipoCliente = $tipoCliente;
    }

    public function index()
    {
        return response()->json([
            $this->tipoCliente->all()
        ], 200);
    }

    public function store(TipoClienteRequest $request)
    {

        try {

            $tipoCliente = $this->tipoCliente->createTipoCliente($request->validated());

            return \response()->json([
                $tipoCliente
            ], 200);
        } catch (Exception $e) {
            return \response()->json([
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function delete(TipoCliente $tipoCliente)
    {
        $tipoCliente->delete();

        return \response()->json([
            'Tipo cliente excluído com sucesso!'
        ], 200);
    }
}
