<?php

namespace App\Http\Requests;

use App\Enums\Employment_Type;
use App\Enums\Level;
use App\Enums\Location_Type;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=>'required',
            'position_id'=>'required',
            'location_type'=> ['required', new EnumValue(Location_Type::class)],
            'employment_type'=> ['required', new EnumValue(Employment_Type::class)],
            'level'=> ['required', new EnumValue(Level::class)],
            'description'=>'required',
            'requirements'=>'required',
            'responsibilities'=>'required',
            'min_salary'=>'required',
            'max_salary'=>'required',
        ];
    }
}
