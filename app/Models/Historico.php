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

    public function transacao()
    {
        return $this->hasOne(Transacao::class, 'id', 'transacao_id');
    }

    public function conta()
    {
        return $this->hasOne(Conta::class, 'id', 'conta_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

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
