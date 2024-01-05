<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'tipo_conta_id' => 'required|numeric',
            'agencia' => 'required|numeric',
            'num_conta' => 'required|numeric',
            'saldo_disponivel' => 'required'
        ];
    }
}
