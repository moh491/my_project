<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class StoreProjectRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape(['worker_type' => "string", 'worker_id' => "string", 'status' => "string", 'title' => "string", 'description' => "string", 'min_budget' => "string", 'max_budget' => "string", 'duration' => "string", 'field_id' => "string", 'ideal_skills' => "string"])]
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|string',
            'min_budget' => 'required|numeric',
            'max_budget' => 'required|numeric',
            'field_id' => 'required|integer|exists:fields,id',
            'skills' => 'required|array',
            'skills.*' => 'integer|exists:skills,id',
            'ideal_skills' => 'nullable|array'
        ];
    }

}
