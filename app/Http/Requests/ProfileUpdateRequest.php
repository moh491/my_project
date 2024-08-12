<?php

namespace App\Http\Requests;

use App\Enums\Level;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'first_name' => 'string|max:255',
            'Last_name' => ['string', 'max:255'],
            'location' => ['sometimes'],
            'time_zone' => ['sometimes'],
            'position_id' => ['sometimes'],
            'profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'languages' => 'array',
            'languages.*.language' => 'required',
            'languages.*.level' => ['required', new EnumValue(Level::class)],
            'skills'=>'array',
        ];
    }
}
