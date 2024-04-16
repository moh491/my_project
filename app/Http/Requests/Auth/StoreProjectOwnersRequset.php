<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectOwnersRequset extends FormRequest
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
            'first_name' => ['required' , 'string' , 'max:255'] ,
            'last_name' => ['required' , 'string' , 'max:255'] ,
            'email' => ['required' , 'string' , 'max:255' ] ,
            'password' => ['required' , 'confirmed'],
            'field_id'=>['required'],
            'about'=>['required','string' ],
        ];
    }
}