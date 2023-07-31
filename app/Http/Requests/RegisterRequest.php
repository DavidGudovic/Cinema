<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
          'username' => 'required|unique:users,username',
          'email' => 'required|email|unique:users,email',
          'name' => 'required|max:40',
          'password' => 'required|confirmed|min:8',
          'role' => 'required'
        ];
    }
}
