<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    private $contas;

    public function __construct(Conta $contas)
    {
        $this->contas = $contas;
    }
}
