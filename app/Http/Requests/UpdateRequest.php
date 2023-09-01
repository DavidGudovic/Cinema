<?php

namespace App\Http\Requests;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
    * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
    */
    public function rules(): array
    {
        $user = $this->route('user');

        $rules = [
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'name' => 'required',
        ];

        // If the admin is making the request, make password fields optional
        if (auth()->user()->role === Roles::ADMIN) {
            $rules['current_password'] = 'nullable|min:8';
            $rules['new_password'] = 'nullable|min:8';
        } else {
            $rules['current_password'] = 'required|min:8';
            $rules['new_password'] = 'required|min:8';
        }

        return $rules;
    }

}
