<?php

namespace Database\Factories;

use App\Enums\HeadacheFrequencyEnum;
use App\Models\Screening;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<\App\Models\Screening>
 */
class ScreeningFactory extends Factory
{
    protected $model = Screening::class;

    public function definition(): array
    {
        $age = $this->faker->numberBetween(1, 100);
        $dob = Carbon::now()->subYears($age)->subDays($this->faker->numberBetween(0, 365));

        $frequency = $this->faker->randomElement(HeadacheFrequencyEnum::cases());

        $dailyFrequency = null;
        if ($frequency === HeadacheFrequencyEnum::DAILY) {
            $dailyFrequency = $this->faker->randomElement(HeadacheFrequencyEnum::cases());
        }

        return [
            'first_name' => $this->faker->firstName(),
            'date_of_birth' => $dob->toDateString(),
            'headache_frequency' => $frequency,
            'daily_frequency' => $dailyFrequency,
        ];
    }

    public function underage(): self
    {
        return $this->state(function () {
            $dob = Carbon::now()->subYears(Screening::AGE_LIMIT - 1);

            return [
                'date_of_birth' => $dob->toDateString(),
            ];
        });
    }

    public function adult(): self
    {
        return $this->state(function () {
            $dob = Carbon::now()->subYears(Screening::AGE_LIMIT + 5);

            return [
                'date_of_birth' => $dob->toDateString(),
            ];
        });
    }

    public function daily(): self
    {
        return $this->state(function () {
            return [
                'headache_frequency' => HeadacheFrequencyEnum::DAILY,
                'daily_frequency' => '3-4',
            ];
        });
    }

    public function weekly(): self
    {
        return $this->state(function () {
            return [
                'headache_frequency' => HeadacheFrequencyEnum::WEEKLY,
                'daily_frequency' => null,
            ];
        });
    }

    public function monthly(): self
    {
        return $this->state(function () {
            return [
                'headache_frequency' => HeadacheFrequencyEnum::MONTHLY,
                'daily_frequency' => null,
            ];
        });
    }
}
