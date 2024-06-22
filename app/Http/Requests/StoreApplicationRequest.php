<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class StoreApplicationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    #[ArrayShape(['job_id' => "string", 'freelancer_id' => "string", 'is_accepted' => "string", 'status' => "string"])] public function rules(): array
    {
        return [
            'job_id' => 'required|exists:jobs,id',
            'freelancer_id' => 'required|exists:freelancers,id',
            'is_accepted' => 'required|boolean',
            'status' => 'required|in:reviewed,accepted,rejected,pending',
        ];
    }
}
