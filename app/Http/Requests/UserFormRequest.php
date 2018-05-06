<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
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
            'name' => 'required|min:5',
            'username' => ['required', 'min:6', Rule::unique('users', 'username')->ignore($this->request->get('id'))],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->request->get('id'))],
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages()
    {
        return [
            'username.unique' => 'Este nome de usuário já está registrado.',
            'email.unique' => 'Este email já está registrado.'
        ];
    }
}
