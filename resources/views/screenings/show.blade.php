@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Screening Result</div>
                <div class="card-body">
                    <h5>{{ $screening->result_message }}</h5>

                    <hr>

                    <p><strong>Name:</strong> {{ $screening->first_name }}</p>
                    <p><strong>Date of birth:</strong> {{ $screening->date_of_birth->format('Y-m-d') }}</p>
                    <p><strong>Age:</strong> {{ $screening->date_of_birth->age }}</p>
                    <p><strong>Migraine frequency:</strong> {{ $screening->headache_frequency }}</p>
                    @if($screening->headache_frequency === 'Daily')
                        <p><strong>Daily frequency:</strong> {{ $screening->daily_frequency }}</p>
                    @endif
                    <p><strong>Eligible:</strong> {{ $screening->eligible ? 'Yes' : 'No' }}</p>
                    <p><strong>Cohort:</strong> {{ $screening->cohort ?? 'N/A' }}</p>

                    <a href="{{ route('screenings.create') }}" class="btn btn-primary mt-3">Screen another subject</a>
                </div>
            </div>
        </div>
    </div>
@endsection
