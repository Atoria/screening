<?php

use App\Enums\CohortEnum;
use App\Enums\HeadacheFrequencyEnum;
use App\Models\Screening;
use Illuminate\Support\Carbon;

it('calculates age correctly', function () {
    $dob = Carbon::now()->subYears(30)->toDateString();

    $screening = new Screening([
        'first_name'         => 'John',
        'date_of_birth'      => $dob,
        'headache_frequency' => HeadacheFrequencyEnum::WEEKLY,
    ]);

    expect($screening->age)->toBe(30);
});

it('returns null age when date_of_birth is missing', function () {
    $screening = new Screening([
        'first_name'         => 'John',
        'headache_frequency' => HeadacheFrequencyEnum::MONTHLY,
    ]);

    expect($screening->age)->toBeNull();
});

it('determines eligibility based on age limit', function () {
    $eighteenDob = Carbon::now()->subYears(Screening::AGE_LIMIT)->toDateString();

    $screening18 = new Screening([
        'first_name'         => 'John',
        'date_of_birth'      => $eighteenDob,
        'headache_frequency' => HeadacheFrequencyEnum::WEEKLY,
    ]);

    expect($screening18->isEligible())->toBeTrue()
        ->and($screening18->eligible)->toBeTrue();

    $underDob = Carbon::now()->subYears(Screening::AGE_LIMIT - 1)->toDateString();

    $underage = new Screening([
        'first_name'         => 'John',
        'date_of_birth'      => $underDob,
        'headache_frequency' => HeadacheFrequencyEnum::WEEKLY,
    ]);

    expect($underage->isEligible())->toBeFalse()
        ->and($underage->eligible)->toBeFalse();
});

it('is not eligible when date_of_birth is missing', function () {
    $screening = new Screening([
        'first_name'         => 'John',
        'headache_frequency' => HeadacheFrequencyEnum::WEEKLY,
    ]);

    expect($screening->isEligible())->toBeFalse()
        ->and($screening->eligible)->toBeFalse();
});

it('assigns cohort A for monthly or weekly when eligible', function () {
    $dob = Carbon::now()->subYears(25)->toDateString();

    $monthly = new Screening([
        'first_name'         => 'John',
        'date_of_birth'      => $dob,
        'headache_frequency' => HeadacheFrequencyEnum::MONTHLY,
    ]);

    $weekly = new Screening([
        'first_name'         => 'John',
        'date_of_birth'      => $dob,
        'headache_frequency' => HeadacheFrequencyEnum::WEEKLY,
    ]);

    expect($monthly->cohort)->toBe(CohortEnum::A->value)
        ->and($weekly->cohort)->toBe(CohortEnum::A->value);
});

it('assigns cohort B for daily when eligible', function () {
    $dob = Carbon::now()->subYears(40)->toDateString();

    $daily = new Screening([
        'first_name'         => 'John',
        'date_of_birth'      => $dob,
        'headache_frequency' => HeadacheFrequencyEnum::DAILY,
    ]);

    expect($daily->cohort)->toBe(CohortEnum::B->value);
});

it('cohort is null when not eligible', function () {
    $dob = Carbon::now()->subYears(Screening::AGE_LIMIT - 2)->toDateString();

    $screening = new Screening([
        'first_name'         => 'John',
        'date_of_birth'      => $dob,
        'headache_frequency' => HeadacheFrequencyEnum::DAILY,
    ]);

    expect($screening->cohort)->toBeNull();
});

it('returns proper result message for underage candidate', function () {
    $dob = Carbon::now()->subYears(Screening::AGE_LIMIT - 2)->toDateString();

    $screening = new Screening([
        'first_name'         => 'John',
        'date_of_birth'      => $dob,
        'headache_frequency' => HeadacheFrequencyEnum::WEEKLY,
    ]);

    expect($screening->result_message)
        ->toBe('Participants must be over 18 years of age');
});

it('returns proper result message for cohort A', function () {
    $dob = Carbon::now()->subYears(30)->toDateString();

    $screening = new Screening([
        'first_name'         => 'John',
        'date_of_birth'      => $dob,
        'headache_frequency' => HeadacheFrequencyEnum::WEEKLY,
    ]);

    expect($screening->result_message)
        ->toBe('Participant John is assigned to Cohort A');
});

it('returns proper result message for cohort B', function () {
    $dob = Carbon::now()->subYears(30)->toDateString();

    $screening = new Screening([
        'first_name'         => 'John',
        'date_of_birth'      => $dob,
        'headache_frequency' => HeadacheFrequencyEnum::DAILY,
    ]);

    expect($screening->result_message)
        ->toBe('Candidate John is assigned to Cohort B');
});

it('returns empty result message if eligible but cohort logic somehow fails', function () {
    $screening = Mockery::mock(Screening::class)->makePartial();
    $screening->first_name = 'John';
    $screening->shouldReceive('isEligible')->andReturn(true);
    $screening->shouldReceive('getAttribute')->with('cohort')->andReturn('X');

    $result = $screening->getResultMessageAttribute();

    expect($result)->toBe('');
});
