<?php

use App\Enums\HeadacheFrequencyEnum;
use App\Models\Screening;
use App\Services\ScreeningService;

it('creates screening with non-daily frequency and null daily_frequency', function () {
    $service = app(ScreeningService::class);

    $data = [
        'first_name' => 'John',
        'date_of_birth' => '1990-01-01',
        'headache_frequency' => HeadacheFrequencyEnum::WEEKLY->value,
        'daily_frequency' => \App\Enums\DailyFrequencyEnum::FIVE_PLUS->value,
    ];

    $screening = $service->createFromData($data);

    expect($screening)->toBeInstanceOf(Screening::class)
        ->and($screening->first_name)->toBe('John')
        ->and($screening->date_of_birth->toDateString())->toBe('1990-01-01')
        ->and($screening->headache_frequency)->toBeInstanceOf(HeadacheFrequencyEnum::class)
        ->and($screening->headache_frequency)->toBe(HeadacheFrequencyEnum::WEEKLY)
        ->and($screening->daily_frequency)->toBeNull();
});

it('creates screening with daily frequency and keeps daily_frequency', function () {
    $service = app(ScreeningService::class);

    $data = [
        'first_name' => 'John',
        'date_of_birth' => '1985-06-15',
        'headache_frequency' => HeadacheFrequencyEnum::DAILY->value,
        'daily_frequency' => \App\Enums\DailyFrequencyEnum::THREE_FOUR->value,
    ];

    $screening = $service->createFromData($data);

    expect($screening->headache_frequency)->toBe(HeadacheFrequencyEnum::DAILY)
        ->and($screening->daily_frequency)->toBe(\App\Enums\DailyFrequencyEnum::THREE_FOUR->value);
});

it('creates screening with daily frequency and null daily_frequency when not provided', function () {
    $service = app(ScreeningService::class);

    $data = [
        'first_name' => 'John',
        'date_of_birth' => '1995-03-10',
        'headache_frequency' => HeadacheFrequencyEnum::DAILY->value,
    ];

    $screening = $service->createFromData($data);

    expect($screening->headache_frequency)->toBe(HeadacheFrequencyEnum::DAILY)
        ->and($screening->daily_frequency)->toBeNull();
});
