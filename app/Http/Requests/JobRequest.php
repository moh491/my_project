<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'position_id'=>'required',
            'location_type'=>'required',
            'employment_type'=>'required',
            'level'=>'required',
            'description'=>'required',
            'requirements'=>'required',
            'responsibilities'=>'required',
            'min_salary'=>'required',
            'max_salary'=>'required',
        ];
    }
}
