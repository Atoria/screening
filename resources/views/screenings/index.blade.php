@extends('layouts.app')

@section('content')
    <h2 class="mb-3">All Screenings</h2>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>First name</th>
            <th>DOB</th>
            <th>Frequency</th>
            <th>Daily freq</th>
            <th>Eligible</th>
            <th>Cohort</th>
            <th>Message</th>
            <th>Created at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($screenings as $screening)
            <tr>
                <td>{{ $screening->id }}</td>
                <td>{{ $screening->first_name }}</td>
                <td>{{ $screening->date_of_birth->format('Y-m-d') }}</td>
                <td>{{ ucfirst($screening->headache_frequency->value) }}</td>
                <td>{{ $screening->daily_frequency ?? '—' }}</td>
                <td>{{ $screening->eligible ? 'Yes' : 'No' }}</td>
                <td>{{ $screening->cohort ?? 'N/A' }}</td>
                <td>{{ $screening->result_message }}</td>
                <td>{{ $screening->created_at->format('Y-m-d H:i') }}</td>
                <td>
                    <a href="{{ route('screenings.show', $screening) }}"
                       class="btn btn-sm btn-primary">
                        View
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center">No screenings yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $screenings->links() }}
@endsection
