<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioUpdateRequest extends FormRequest
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
            'title'=>'string',
            'description'=>'required',
            'date'=>'sometimes',
            'preview'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'demo'=>'string',
            'link'=>'string',
            'skills'=>['array'],
            'existImages' => 'array',
            'contributors'=>['array']
        ];
    }
}
