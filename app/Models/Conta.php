<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conta extends Model
{
    use HasFactory;
    protected $table = 'contas';
    protected $fillable = [
        'user_id',
        'tipo_conta_id',
        'agencia',
        'num_conta',
        'saldo_disponivel',
        'dt_abertura',
        'dt_encerramento'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function tipo_conta()
    {
        return $this->hasOne(TipoConta::class, 'id', 'tipo_conta_id');
    }

    public function transacao()
    {
        return $this->belongsTo(Transacao::class, 'id', 'tipo_transacao_id');
    }

    public function historico()
    {
        return $this->belongsTo(Historico::class, 'id', 'conta_id');
    }

    public function createConta($request)
    {

        $conta = new self;
        $conta->user_id = $request['user_id'];
        $conta->tipo_conta_id = $request['tipo_conta_id'];
        $conta->agencia = $request['agencia'];
        $conta->num_conta = $request['num_conta'];
        $conta->saldo_disponivel = $request['saldo_disponivel'];
        $conta->dt_abertura = date('Y-m-d H:i:s');
        if (!$conta->save()) {
            throw new Exception("Erro ao criar conta!");
        }

        return $conta;
    }

    public function encerrarConta(Conta $conta)
    {
        $conta->dt_encerramento = date('Y-m-d H:i:s');
        if (!$conta->save()) {
            throw new Exception("Erro ao encerrar conta!");
        }

        return $conta;
    }

    public function depositar($request, Conta $conta)
    {
        $conta->saldo_disponivel = $conta->saldo_disponivel + $request['valor_transacao'];
        if (!$conta->save()) {
            throw new Exception("Erro ao realizar um deposito na conta!");
        }

        return $conta;
    }

    public function sacar($request, Conta $conta)
    {
        $conta->saldo_disponivel = $conta->saldo_disponivel - $request['valor_transacao'];
        if (!$conta->save()) {
            throw new Exception("Erro ao realizar um saque na conta!");
        }

        return $conta;
    }
}
