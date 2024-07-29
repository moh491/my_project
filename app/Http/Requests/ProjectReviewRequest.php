<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectReviewRequest extends FormRequest
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
            'professionalism'=>'required|min:1|max:5' ,
            'communication'=>'required|min:1|max:5' ,
            'quality'=>'required|min:1|max:5',
            'commit_to_deadlines'=>'required|min:1|max:5' ,
            're_employee'=>'required|min:1|max:5' ,
            'experience'=>'required|min:1|max:5' ,
            'description'=>'required' ,
        ];
    }
}
