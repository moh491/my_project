<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyrRequest extends FormRequest
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
            'name'=>['required','string'],
            'logo'=>['image:jpeg,png,jpg,gif,svg|max:2048','required'],
            'email'=>['required'],
            'password' => ['required'],
            'about'=>['required'],
            'location'=>['required'],
            'field_id'=>['required'],
        ];
    }
}
