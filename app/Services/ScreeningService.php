<?php

namespace App\Services;

use App\Models\Screening;
use App\Enums\HeadacheFrequencyEnum;

class ScreeningService
{
    public function createFromData(array $data): Screening
    {
        $headacheFrequency = HeadacheFrequencyEnum::from($data['headache_frequency']);

        return Screening::create([
            'first_name' => $data['first_name'],
            'date_of_birth' => $data['date_of_birth'],
            'headache_frequency' => $headacheFrequency,
            'daily_frequency' => $headacheFrequency === HeadacheFrequencyEnum::DAILY
                ? ($data['daily_frequency'] ?? null)
                : null,
        ]);
    }
}
