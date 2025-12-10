<?php

namespace App\Http\Requests;

use App\Enums\DailyFrequencyEnum;
use App\Enums\HeadacheFrequencyEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreScreeningRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'headache_frequency' => [
                'required',
                'string',
                'in:' . implode(',', array_column(HeadacheFrequencyEnum::cases(), 'value'))
            ],
            'daily_frequency' => [
                'nullable',
                'string',
                'in:' . implode(',', array_column(DailyFrequencyEnum::cases(), 'value')),
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->headache_frequency === HeadacheFrequencyEnum::DAILY->value && empty($this->daily_frequency)) {
                $validator->errors()->add(
                    'daily_frequency',
                    'Daily frequency is required when migraine frequency is daily.'
                );
            }
        });
    }
}
