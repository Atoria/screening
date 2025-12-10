<?php

namespace App\Models;

use App\Enums\CohortEnum;
use App\Enums\HeadacheFrequencyEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    private const AGE_LIMIT = 18;
    protected $fillable = [
        'first_name',
        'date_of_birth',
        'headache_frequency',
        'daily_frequency',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
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

    public function getEligibleAttribute($value): bool
    {
        return $this->isEligible();
    }

    public function getCohortAttribute(): ?string
    {
        if (!$this->isEligible()) {
            return null;
        }

        if (in_array($this->headache_frequency, [HeadacheFrequencyEnum::MONTHLY->value, HeadacheFrequencyEnum::WEEKLY->value])) {
            return CohortEnum::A->value;
        }

        if ($this->headache_frequency === HeadacheFrequencyEnum::DAILY->value) {
            return CohortEnum::B->value;
        }

        return null;
    }

    public function getResultMessageAttribute(): string
    {
        if (!$this->isEligible()) {
            return 'Participants must be over 18 years of age';
        }

        $cohort = $this->cohort;

        if ($cohort === CohortEnum::A->value) {
            return "Participant {$this->first_name} is assigned to Cohort A";
        }

        if ($cohort === CohortEnum::B->value) {
            return "Candidate {$this->first_name} is assigned to Cohort B";
        }

        return '';
    }

}
