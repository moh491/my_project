<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'price' => 'required',
            'description' => 'required|max:100',
            'type'=>'required',
            'features'=>'array',
            'features.*.id'=>'required',
            'features.*.value'=>'required',
            'delivery_options'=>'array',
            'delivery_options.*.days'=>'required',
            'delivery_options.*.increase'=>'required',
        ];
    }
}
