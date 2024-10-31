<?php

namespace App\Http\Requests;

use App\Enum\VotableType;
use Illuminate\Foundation\Http\FormRequest;

class VotableRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:' . implode(',', VotableType::toArray())]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
