<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanUpdateRequest extends FormRequest
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
            'price'=>'sometimes',
            'description'=>'sometimes',
            'features'=>'array',
            'features.*.id'=>'required',
            'features.*.value'=>'required',
            'delivery_options'=>'array',
            'delivery_options.*.id'=>'sometimes',
            'delivery_options.*.days'=>'sometimes',
            'delivery_options.*.increase'=>'sometimes'
        ];
    }
}
