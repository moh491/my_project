<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyBrofileRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
             //'email' => 'sometimes|string|email|max:255|unique:company,email,' . $this->user()->id,
            'location' => 'sometimes|string|max:255',
            'website' => 'sometimes|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'sometimes|string',
            'field_ids' => 'sometimes|array',
            'field_ids.*' => 'required|exists:fields,id',
        ];
    }
}
