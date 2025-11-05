<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateStudentApplicationRequest extends FormRequest
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
            'course_id' => 'required|exists:advisor_db.courses,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'email' => 'required|email|unique:student_applications,email',
            'phone_number' => 'required|string|unique:student_applications,phone_number',
            'country' => 'required|string|max:255',
            'class_of_degree' => 'required|string|max:255',
            'schools_of_choice' => 'required|array',
            'country_of_preference' => 'required|array',
            'additional_notes' => 'nullable|string',
            'signature' => 'nullable|string',
            'application_documents' => 'nullable|array',
        ];
    }
}
