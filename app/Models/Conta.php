<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function editConta(Conta $conta, $request)
    {
    }
}
