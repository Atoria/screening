@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subject Screening Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('screenings.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">First name</label>
                            <input type="text" name="first_name"
                                   class="form-control @error('first_name') is-invalid @enderror"
                                   value="{{ old('first_name') }}" required>
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth"
                                   class="form-control @error('date_of_birth') is-invalid @enderror"
                                   value="{{ old('date_of_birth') }}" required>
                            @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Migraine frequency</label>
                            <select name="headache_frequency" id="headache_frequency"
                                    class="form-select @error('headache_frequency') is-invalid @enderror" required>
                                <option value="">-- Select --</option>
                                @foreach(\App\Enums\HeadacheFrequencyEnum::cases() as $case)
                                    <option
                                        value="{{ $case->value }}"
                                        @selected(old('headache_frequency') === $case->value)
                                    >
                                        {{ ucfirst($case->value) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('headache_frequency')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="daily_frequency_group" style="display:none;">
                            <label class="form-label">Daily frequency (if Daily)</label>
                            <select name="daily_frequency"
                                    class="form-select @error('daily_frequency') is-invalid @enderror">
                                <option value="">-- Select --</option>
                                @foreach(\App\Enums\DailyFrequencyEnum::cases() as $case)
                                    <option
                                        value="{{ $case->value }}"
                                        @selected(old('daily_frequency') === $case->value)
                                    >
                                        {{ $case->value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('daily_frequency')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleDailyFrequency() {
            const select = document.getElementById('headache_frequency');
            const group = document.getElementById('daily_frequency_group');

            const DAILY = "{{ \App\Enums\HeadacheFrequencyEnum::DAILY->value }}";

            if (select && group) {
                if (select.value === DAILY) {
                    group.style.display = 'block';
                } else {
                    group.style.display = 'none';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('headache_frequency');
            if (select) {
                select.addEventListener('change', toggleDailyFrequency);
                toggleDailyFrequency();
            }
        });
    </script>
@endpush
