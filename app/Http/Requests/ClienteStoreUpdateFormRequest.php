<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteStoreUpdateFormRequest extends FormRequest
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
        $cliente_id = $this->segment(3);

        return [
            'nome'              => 'required|min:3|max:50',
            'email'             => "required|min:10|max:80|unique:clientes,email,{$cliente_id},id",
            'telefone'          => 'required|min:9|',
            'data_nascimento'   => 'required|date|',
            'endereco'          => 'required|min:10|',
            'bairro'            => 'required|min:10|',
            'cep'               => 'required|min:9|',
            'data_cadastro'     => 'date',
        ];
    }
}
