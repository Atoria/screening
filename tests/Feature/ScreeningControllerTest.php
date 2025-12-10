<?php

use App\Enums\HeadacheFrequencyEnum;
use App\Models\Screening;

it('displays screenings index', function () {
    Screening::factory()->count(3)->create();

    $response = $this->get(route('screenings.index'));

    $response->assertStatus(200)
        ->assertViewIs('screenings.index')
        ->assertViewHas('screenings');
});

it('displays screening create form', function () {
    $response = $this->get(route('screenings.create'));

    $response->assertStatus(200)
        ->assertViewIs('screenings.create');
});

it('stores a new screening and shows the result page', function () {
    $data = [
        'first_name' => 'John',
        'date_of_birth' => '1990-01-01',
        'headache_frequency' => HeadacheFrequencyEnum::WEEKLY->value,
        'daily_frequency' => null,
    ];

    $response = $this->post(route('screenings.store'), $data);

    $this->assertDatabaseHas('screenings', [
        'first_name' => 'John',
        'date_of_birth' => '1990-01-01',
    ]);

    $screening = Screening::first();

    $response->assertStatus(200)
        ->assertViewIs('screenings.show')
        ->assertViewHas('screening', function ($viewScreening) use ($screening) {
            return $viewScreening->id === $screening->id;
        });
});

it('stores a daily screening with required daily_frequency', function () {
    $data = [
        'first_name' => 'Jane',
        'date_of_birth' => '1990-01-01',
        'headache_frequency' => HeadacheFrequencyEnum::DAILY->value,
        'daily_frequency' => '5+',
    ];

    $response = $this->post(route('screenings.store'), $data);

    $response->assertStatus(200);

    $this->assertDatabaseHas('screenings', [
        'first_name' => 'Jane',
        'headache_frequency' => HeadacheFrequencyEnum::DAILY->value,
        'daily_frequency' => '5+',
    ]);
});

it('rejects daily frequency without daily_frequency field', function () {
    $data = [
        'first_name' => 'Jane',
        'date_of_birth' => '1990-01-01',
        'headache_frequency' => HeadacheFrequencyEnum::DAILY->value,
    ];

    $response = $this->from(route('screenings.create'))
        ->post(route('screenings.store'), $data);

    $response->assertStatus(302)
        ->assertSessionHasErrors('daily_frequency');
});

it('shows a single screening', function () {
    $screening = Screening::factory()->create();

    $response = $this->get(route('screenings.show', $screening));

    $response->assertStatus(200)
        ->assertViewIs('screenings.show')
        ->assertViewHas('screening', function ($viewScreening) use ($screening) {
            return $viewScreening->id === $screening->id;
        });
});
