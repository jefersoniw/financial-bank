<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;
    protected $table = 'transacao';
    protected $fillable = [
        'tipo_transacao_id',
        'valor_transacao',
        'conta_id'
    ];

    public function tipo_transacao()
    {
        return $this->hasOne(TipoTransacao::class, 'id', 'tipo_transacao_id');
    }

    public function conta()
    {
        return $this->hasOne(Conta::class, 'id', 'conta_id');
    }

    public function createTransacao($request, Conta $conta)
    {
        $transacao = new self;
        $transacao->tipo_transacao_id = $request['tipo_transacao_id'];
        $transacao->valor_transacao = $request['valor_transacao'];
        $transacao->conta_id = $conta->id;
        if (!$transacao->save()) {
            throw new Exception("erro ao salvar transação");
        }

        return $transacao;
    }
}
