<?php

namespace App\Models;

use App\Enums\CohortEnum;
use App\Enums\HeadacheFrequencyEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    public const AGE_LIMIT = 18;

    protected $fillable = [
        'first_name',
        'date_of_birth',
        'headache_frequency',
        'daily_frequency',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'headache_frequency' => HeadacheFrequencyEnum::class,
    ];


    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth
            ? Carbon::parse($this->date_of_birth)->age
            : null;
    }

    public function isEligible(): bool
    {
        return $this->date_of_birth && $this->age >= self::AGE_LIMIT;
    }

    public function getEligibleAttribute(): bool
    {
        return $this->isEligible();
    }

    public function getCohortAttribute(): ?string
    {
        if (!$this->isEligible()) {
            return null;
        }

        /** @var HeadacheFrequencyEnum $frequency */
        $frequency = $this->headache_frequency;

        return match ($frequency) {
            HeadacheFrequencyEnum::MONTHLY,
            HeadacheFrequencyEnum::WEEKLY => CohortEnum::A->value,
            HeadacheFrequencyEnum::DAILY => CohortEnum::B->value,
        };
    }

    public function getResultMessageAttribute(): string
    {
        if (!$this->isEligible()) {
            return 'Participants must be over 18 years of age';
        }

        $cohort = $this->cohort;

        return match ($cohort) {
            CohortEnum::A->value => "Participant {$this->first_name} is assigned to Cohort A",
            CohortEnum::B->value => "Candidate {$this->first_name} is assigned to Cohort B",
            default => '',
        };
    }
}
