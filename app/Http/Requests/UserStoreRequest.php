<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => 'string|required|min:3',
            'cpfcnpj' => 'required|numeric|min:11',
            'email' => 'string|required|email',
            'password' => 'string|required',
            'rep_password' => 'string|required|same:password'
        ];
    }
}
