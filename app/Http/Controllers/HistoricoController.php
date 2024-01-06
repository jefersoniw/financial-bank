<?php

namespace App\Http\Controllers;

use App\Models\Historico;
use Illuminate\Http\Request;

class HistoricoController extends Controller
{
    private $historico;

    public function __construct(Historico $historico)
    {
        $this->historico = $historico;
    }

    public function index()
    {
        return \response()->json([
            $this->historico
                ->with(
                    'user',
                    'transacao',
                    'conta'
                )
                ->get()
        ], 200);
    }
}
