<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'director' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'banner' => ['nullable', 'mimes:png,webp,jpeg,jpg', 'max:1024'],
            'poster' => ['nullable', 'mimes:png,webp,jpeg,jpg', 'max:1024'],
            'trailer_url' => ['required', 'url', 'max:255'],
            'release_date' => ['required', 'date'],
            'duration' => ['required', 'integer', 'min:1'],
        ];
    }
}
