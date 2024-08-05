<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
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
            'company_name'=>'sometimes',
            'employment_type'=>'required',
            'location_type'=>'required',
            'location'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'position_id'=>'required',
            'company_id'=>'sometimes',
            'description'=>'required',
        ];
    }
}
