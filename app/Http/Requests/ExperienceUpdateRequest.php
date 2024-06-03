<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceUpdateRequest extends FormRequest
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
            'company_name'=>'string',
            'employment_type'=>'sometimes',
            'location_type'=>'sometimes',
            'location'=>'string',
            'start_date'=>'sometimes',
            'end_date'=>'sometimes',
            'position_id'=>'sometimes',
            'company_id'=>'sometimes',
            'description'=>'text',
        ];
    }
}
