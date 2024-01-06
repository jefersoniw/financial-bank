<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransacaoDepositoRequest;
use App\Http\Requests\TransacaoSaqueRequest;
use App\Models\Conta;
use App\Models\Historico;
use App\Models\TipoTransacao;
use App\Models\Transacao;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransacaoController extends Controller
{
    private $transacao;
    private $tipoTransacao;
    private $conta;
    private $historico;
    private $user;

    public function __construct(
        Transacao $transacao,
        TipoTransacao $tipoTransacao,
        Conta $conta,
        Historico $historico,
        User $user
    ) {
        $this->transacao = $transacao;
        $this->tipoTransacao = $tipoTransacao;
        $this->conta = $conta;
        $this->historico = $historico;
        $this->user = $user;
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
            $transacaoSaque = $this
                ->tipoTransacao
                ->where('id', 1)
                ->first();

            $dados = [
                'valor_transacao' => $request->valor_transacao,
                'tipo_transacao_id' => $transacaoSaque->id
            ];

            $verificaConta = $this->conta
                ->where('agencia', $request['agencia'])
                ->where('num_conta', $request['num_conta'])
                ->first();

            if ($verificaConta->saldo_disponivel < $dados['valor_transacao']) {

                return \response()->json([
                    'error' => true,
                    'msg' => 'Saldo insuficiente para ocorrer a transação!'
                ], 200);
            }

            $conta = $this->conta->sacar($dados, $verificaConta);

            $transacao = $this->transacao->createTransacao($dados, $conta);

            $user = $this->user->find($conta->user_id);

            $this->historico->createHistorico($user, $transacao, $conta);

            DB::commit();

            return response()->json([
                'msg' => 'Saque realizado com sucesso!',
                'saldo_disponivel' => $conta->saldo_disponivel,
                'dados' => $this->transacao->with('conta', 'tipo_transacao')->get(),
            ], 200);
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

            $verificaConta = $this->conta
                ->where('agencia', $request['agencia'])
                ->where('num_conta', $request['num_conta'])
                ->first();

            $conta = $this->conta->depositar($dados, $verificaConta);

            $transacao = $this->transacao->createTransacao($dados, $conta);

            $user = $this->user->find($conta->user_id);

            $this->historico->createHistorico($user, $transacao, $conta);

            DB::commit();

            return response()->json([
                'msg' => 'Depósito realizado com sucesso!',
                'saldo_disponivel' => $conta->saldo_disponivel,
                'dados' => $this->transacao->with('conta', 'tipo_transacao')->get(),
            ], 200);
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
