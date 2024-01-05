<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransacaoDepositoRequest;
use App\Http\Requests\TransacaoSaqueRequest;
use App\Models\Conta;
use App\Models\TipoTransacao;
use App\Models\Transacao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransacaoController extends Controller
{
    private $transacao;
    private $tipoTransacao;
    private $conta;

    public function __construct(
        Transacao $transacao,
        TipoTransacao $tipoTransacao,
        Conta $conta
    ) {
        $this->transacao = $transacao;
        $this->tipoTransacao = $tipoTransacao;
        $this->conta = $conta;
    }

    public function index()
    {
        return \response()->json([
            $this->transacao
                ->with('conta', 'tipo_transacao')
                ->get()
        ], 200);
    }

    public function sacar(TransacaoSaqueRequest $request)
    {
        DB::beginTransaction();
        try {

            // DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return \response()->json([
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function depositar(TransacaoDepositoRequest $request)
    {
        DB::beginTransaction();
        try {

            $transacaoDeposito = $this
                ->tipoTransacao
                ->where('id', 2)
                ->first();

            $dados = [
                'valor_transacao' => $request->valor_transacao,
                'tipo_transacao_id' => $transacaoDeposito->id
            ];

            $conta = $this->conta->depositar($request->validated());

            $transacao = $this->transacao->createTransacao($dados, $conta);

            dd($transacao);

            //SALVANDO EM HISTÓRICO

            // DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return \response()->json([
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
}
