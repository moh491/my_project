<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'required|url|max:255',
            'about' => 'required|string',
//            'withdrawal_balance' => 'nullable|numeric',
//            'available_balance' => 'nullable|numeric',
//            'suspended_balance' => 'nullable|numeric',
            'position_id' => 'required|exists:positions,id',
            'members' => 'sometimes|array',
            'members.*.id' => 'required|exists:freelancers,id',
            'members.*.position_id' => 'required|exists:positions,id',
            'skills' => 'sometimes|array',
            'skills.*' => 'required|exists:skills,id',
        ];
    }
}
