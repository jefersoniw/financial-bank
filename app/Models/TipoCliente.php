<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCliente extends Model
{
    use HasFactory;

    protected $table = 'tipo_cliente';
    public $timestamps = false;
    protected $fillable = [
        'desc_tipo'
    ];

    public function conta()
    {
        return $this->belongsTo(Conta::class, 'id', 'tipo_conta_id');
    }

    public function createTipoCliente($request)
    {
        $tipoCliente = new self;
        $tipoCliente->desc_tipo = $request['desc_tipo'];
        if (!$tipoCliente->save()) {
            throw new Exception("Erro ao salvar tipo cliente");
        }

        return $tipoCliente;
    }
}
