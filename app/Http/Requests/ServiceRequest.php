<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'description' => 'required|string',
            'preview'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'plans'=>'required',
            'plans.*.features'=>'array',
            'features' => 'required',
            'plans.*.delivery_options'=>'array',
            'skills'=>'required|array'
        ];
    }
}
