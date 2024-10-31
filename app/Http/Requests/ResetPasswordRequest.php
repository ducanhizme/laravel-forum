<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="ResetPasswordRequest",
 *     type="object",
 *     required={"password"},
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="New password",
 *         minLength=10,
 *         example="P@ssw0rd123",
 *         pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{10,}$"
 *     )
 * )
 */
class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages():array
    {
        return [
            'password.required' => 'Please enter a password.',
            'password.min' => 'Your password must be at least 10 characters long.',
            'password.regex' => 'Your password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];
    }
}
