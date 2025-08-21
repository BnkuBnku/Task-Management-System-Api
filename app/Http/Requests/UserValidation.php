<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserValidation extends FormRequest
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
    public static function rules()
    {
        return [
            "name"              => ['required', Rule::unique('users','name')],
            'email'             => ['required','email', Rule::unique('users','email')],
            'password'          => ['required', 'min:12', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_#])[A-Za-z\d@$!%*?&_#]+$/'],
            'confirm_password'  => ['required', 'same:password'],
        ];
    }

    public static function message()
    {
        return [
            'name.required'             => 'Nickname is required',
            'name.unique'               => 'Nickname already exists',
            'email.required'            => 'Email is required.',
            'email.unique'              => 'Email already exists.',
            'email.email'               => 'Must be a valid email.',
            'password.required'         => 'Password is required.',
            'password.min'              => 'Password must be at least 12 characters.',
            'password.regex'            => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.',
            'confirm_password.required' => 'Confirm Password is required.',
        ];
    }
}
