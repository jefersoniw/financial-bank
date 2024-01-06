<?php

namespace App\Http\Controllers;

use App\Models\Historico;
use App\Models\User;
use Illuminate\Http\Request;

class HistoricoController extends Controller
{
    private $historico;

    public function __construct(Historico $historico)
    {
        $this->historico = $historico;
    }

    public function index(User $user)
    {
        return \response()->json([
            'total_transacoes' => $this->historico
                ->with(
                    'user',
                    'transacao',
                    'conta'
                )
                ->where('user_id', $user->id)->count(),
            'histórico_transacoes' => $this->historico
                ->with(
                    'user',
                    'transacao',
                    'conta'
                )
                ->where('user_id', $user->id)
                ->get()
        ], 200);
    }
}
