<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoadorStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'      => 'required | string | max:50 | min:3',
            'user_id'      => ['required', 'integer', 'exists:users,id','unique:doadores,user_id'],
            'telefone'      => ' required | string | max:11 | min:11',
            'documento'     => ' required | string | max:14 | min:11 | unique:doadores',
            'endereco'     => ' string ',
            'cidade'     => ' string ',
            'estado'     => ' string | min:2',
            'cep'     => ' string | min:8 ',
            'documento_tipo'  => ' required | string | min:2',
        ];
    }

     public function messages()
    {
        return [
            'nome.require'      => 'O nome é obrigatório!!',
            'nome.max'          => 'O nome deve ter no máximo 50 caracteres!',
            'telefone.require'   => 'O telefone é obrigatório!!',
            'documento.require'      => 'O documento é obrigatório!!',
            'documento.unique'      => 'Documento indiponível, já está em uso.',
            'documento_tipo.require'  => 'O tipo de documento é obrigatório!!',
        ];
    }
}
