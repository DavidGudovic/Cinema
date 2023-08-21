<?php

namespace App\Http\Requests\Requestable;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'response' => ['required'],
            'action' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
