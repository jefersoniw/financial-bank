<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTransacao extends Model
{
    use HasFactory;
    protected $table = 'tipo_transacao';
    public $timestamps = false;
    protected $fillable = [
        'desc_transacao'
    ];

    public function transacao()
    {
        return $this->belongsTo(Transacao::class, 'id', 'tipo_transacao_id');
    }

    public function createTipoTransacao($request)
    {
        $tipoTransacao = new self;
        $tipoTransacao->desc_transacao = $request['desc_transacao'];
        if (!$tipoTransacao->save()) {
            throw new Exception("erro ao cadastrar tipo de transacao!");
        }

        return $tipoTransacao;
    }
}
