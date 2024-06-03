<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateUpdateRequest extends FormRequest
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
            'start_date'=>'sometimes',
            'end_date'=>'sometimes',
            'image'=>['image:jpeg,png,jpg,gif,svg|max:2048'],
            'link'=>'sometimes',
            'credentials_id'=>'sometimes',
        ];
    }
}
