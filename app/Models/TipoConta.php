<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoConta extends Model
{
    use HasFactory;

    protected $table = 'tipo_conta';
    public $timestamps = false;
    protected $fillable = [
        'desc_tipo'
    ];

    public function createTipoConta($request)
    {
        $tipoConta = new self;
        $tipoConta->desc_tipo = $request['desc_tipo'];
        if (!$tipoConta->save()) {
            throw new Exception("Erro ao cadastrar tipo de conta");
        }

        return $tipoConta;
    }
}
