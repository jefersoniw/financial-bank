<?php

namespace App\Models;

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
    }

    public function editConta(Conta $conta, $request)
    {
    }
}
