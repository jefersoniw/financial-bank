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

    public function createTipoCliente($request)
    {
        try {

            $tipoCliente = new self;
            $tipoCliente->desc_tipo = $request['desc_tipo'];
            if (!$tipoCliente->save()) {
                throw new Exception("Erro ao salvar tipo cliente");
            }

            return [
                'error' => false,
                'msg' => 'Tipo de cliente salvo com sucesso!',
                'dados' => $tipoCliente
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
        }
    }
}
