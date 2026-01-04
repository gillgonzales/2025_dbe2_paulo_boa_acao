<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('user');

        return [//Em atualizações não aplicamos require para não obrigar a alteração.
            'name'      => ' sometimes | string | max:50 | min:3',
            'email'     => [' sometimes', 'email', Rule::unique('users')->ignore($userId)],
            'password'  => ' sometimes | string | min:8',
        ];
    }
}
