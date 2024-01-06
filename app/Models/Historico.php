<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    use HasFactory;
    protected $table = 'historico';
    protected $fillable = [
        'user_id',
        'transacao_id',
        'conta_id',
        'saldo',
    ];

    public function createHistorico(User $user, Transacao $transacao, Conta $conta)
    {
        $historico = new self;
        $historico->user_id = $user->id;
        $historico->transacao_id = $transacao->id;
        $historico->conta_id = $conta->id;
        $historico->saldo = $conta->saldo_disponivel;
        if (!$historico->save()) {
            throw new Exception("erro ao salvar histórico!");
        }

        return $historico;
    }
}
