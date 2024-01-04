<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoClienteRequest;
use App\Models\TipoCliente;
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
        $tipoCliente = $this->tipoCliente->createTipoCliente($request->validated());

        if (!empty($user['error'])) {

            return response()->json([
                $tipoCliente
            ], 400);
        }

        return \response()->json([
            $tipoCliente
        ], 200);
    }
}
