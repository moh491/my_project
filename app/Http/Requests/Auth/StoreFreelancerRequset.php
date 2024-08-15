<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFreelancerRequset extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => ['required' , 'string' , 'max:255'] ,
            'email' => ['required' , 'string' , 'max:255' , 'unique:freelancers' ] ,
            'password' => ['required'],
            'about'=>['required','string' ],
            'location'=>['required']    ,
            'time_zone'=>['required'],
            'position_id'=>['required'],
            'skills'=>['required','array'],
            'languages'=>['required','array'],
            'profile'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];
    }
}
