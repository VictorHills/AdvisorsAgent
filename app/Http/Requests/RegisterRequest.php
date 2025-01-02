<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'phone' => 'required|integer|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'agency_name' => 'required|string|max:255',
            'business_registration_number' => 'required|string|max:255',
            'role_name' => 'required|string|max:255',
            'is_terms_and_condition_accepted' => 'required|boolean',
            'bdm_officer_id' => 'nullable|exists:users,id',
        ];
    }
}
