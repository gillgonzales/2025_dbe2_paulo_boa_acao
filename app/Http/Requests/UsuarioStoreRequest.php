<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioStoreRequest extends FormRequest
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
            "nome" => "required",
            "email" => "required | email | unique:usuarios,email",
            "telefone" => "required | size: 11",
            "cep" => "required | size: 8",
            "endereco" => "required",
            "numero" => "nullable | numeric",
            "complemento" => "nullable",
            "bairro" => "nullable | max: 20",
            "cidade" => "required",
            "uf" => "required | size: 2",
            "senha" => "required | max: 12",
            "tipo" => "required | size: 1"
        ];
    }
}
