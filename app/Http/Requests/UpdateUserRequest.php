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
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'The email must be a valid email address format.',
            'email.unique' => 'Email has already been taken.',
        ];
    }
}
