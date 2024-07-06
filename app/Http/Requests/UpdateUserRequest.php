<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        return [
            'username' => ['required', 'max:191', 'string'],
            'email' => ['required', 'max:191', 'string', 'email', 'unique:users,email,' . auth()->id()],
            'old_password' => ['old_password_match'],
            'new_password' => [
                'min:8',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[A-Z])(?=.*[^a-zA-Z\d]).*$/'
            ],
            'confirm_password' => ['same:new_password'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'The email must be a valid email address format.',
            'email.unique' => 'Email has already been taken.',
            'old_password.old_password_match' => 'The current password is incorrect.',
            'new_password.min' => 'The new password must be at least 8 characters.',
            'new_password.regex' => 'The new password must contain at least one character, one number, and one uppercase letter.',
            'confirm_password.same' => 'The confirmation password must match the new password.',
        ];
    }
}
