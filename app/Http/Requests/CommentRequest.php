<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return match($this->method()){
            'POST' => [
                'content' => ['required', 'string'],
            ],
        };
    }

    public function authorize(): bool
    {
        return true;
    }
}
