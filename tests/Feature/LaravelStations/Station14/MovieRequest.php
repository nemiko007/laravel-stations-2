<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieRequest extends FormRequest
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
        $uniqueRule = Rule::unique('movies', 'title');
        if ($this->movie) {
            $uniqueRule->ignore($this->movie->id);
        }

        return [
            'title' => ['required', 'string', 'max:255', $uniqueRule],
            'image_url' => ['required', 'url'],
            'published_year' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'is_showing' => ['required', 'boolean'],
            'genre' => ['required', 'string'],
        ];
    }
}