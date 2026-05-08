<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            "name"     => "required|string|max:255",
            "email"    => "required|email|unique:users,email",
            "password" => "required|min:6",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "O nome é obrigatório",
            "email.required" => "O email é obrigatório",
            "email.email" => "O email deve ser válido",
            "email.unique" => "O email já está cadastrado",
            "password.required" => "A senha é obrigatória",
            "password.min" => "A senha deve ter no mínimo 6 caracteres",
        ];
    }
}
