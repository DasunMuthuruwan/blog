<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    
    public function prepareForValidation()
    {
        $this->merge([
            'login_type' => filter_var($this->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        if ($this->login_type === 'email') {
            return [
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:5',
            ];
        } else {
            return [
                'login_id' => 'required|exists:users,username',
                'password' => 'required|min:5',
            ];
        }
    }

    public function messages(): array
    {
        return [
            'login_id.required' => 'Enter your email or username',
            'login_id.email' => 'Invalid email address',
            'login_id.exists' => 'No account found for this :attribute',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 5 characters',
        ];
    }

    public function attributes(): array
    {
        return [
            'login_id' => $this->login_type,
        ];
    }
}
