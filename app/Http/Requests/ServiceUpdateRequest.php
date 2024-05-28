<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'description'=>'text',
            'image'=>'string',
            'plans'=>'array',
            'plans.*.id'=>'required',
            'plans.*.price' => 'sometimes|numeric',
            'plans.*.description'=>'sometimes',
            'plans.*.features'=>'array',
            'plans.*.features.*.id'=>'required',
            'plans.*.features.*.value'=>'sometimes',
            'plans.*.delivery_option'=>'array',
            'plans.*.delivery_option.*.id'=>'required',
            'plans.*.delivery_option.*.days'=>'sometimes',
            'plans.*.delivery_option.*.increase'=>'sometimes',


        ];
    }
}
