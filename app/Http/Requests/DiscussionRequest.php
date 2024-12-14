<?php

namespace App\Http\Requests;

use App\Enum\DiscussionStatus;
use Illuminate\Foundation\Http\FormRequest;

class DiscussionRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => [
                'tags'=> ['required', 'array'],
                'title' => ['required', 'string'],
                'content' => ['required', 'string'],
            ],
            'PUT', 'PATCH' => [
                'title' => ['nullable'],
                'content' => ['nullable'],
                'status' => ['nullable', 'string:in' . implode(',', DiscussionStatus::toArray())],
            ],
            default => [
                'title' => ['nullable'],
                'content' => ['required'],
            ],
        };
    }

    public function authorize(): bool
    {
        return true;
    }
}
