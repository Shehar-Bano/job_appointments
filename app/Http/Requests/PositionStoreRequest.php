<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionStoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'requirement' => 'required|array', // Expect an array for requirement
            'description' => 'required|string',
            
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'The job title is required',
            'job_type.required' => 'The job type is required',
            'requirement.required' => 'Please provide job requirements',
            'description.required' => 'Please provide a description',

        ];
    }
}
