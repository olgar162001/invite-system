@extends('layouts.app')

@section('content')
@include('partials.sidebar')

<div class="container mt-5">
    <h2 class="text-center mb-4 text-dark">Assign SMS Units to Customer</h2>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('sms.assign.store') }}" class="card p-4 shadow-sm bg-light">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="user_id" class="form-label">Customer</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Select Customer --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                    @endforeach
                </select>
                @error('user_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="event_id" class="form-label">Event</label>
                <select name="event_id" id="event_id" class="form-select" required>
                    <option value="">-- Select Event --</option>
                </select>
                @error('event_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="units" class="form-label">SMS Units</label>
            <input type="number" name="units" id="units" class="form-control" min="1" required>
            @error('units')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Assign Units</button>
        </div>
    </form>

    {{-- Existing Assignments --}}
    <div class="mt-5">
        <h4 class="mb-3">Current SMS Unit Assignments</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Customer</th>
                        <th>Event</th>
                        <th>Units Assigned</th>
                        <th>Units Used</th>
                        <th>Remaining</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allocations as $allocation)
                        <tr>
                            <td>{{ $allocation->user->name }}</td>
                            <td>{{ $allocation->event->title }}</td>
                            <td>{{ $allocation->units_assigned }}</td>
                            <td>{{ $allocation->units_used }}</td>
                            <td class="{{ $allocation->units_used >= $allocation->units_assigned ? 'text-danger' : '' }}">
                                {{ $allocation->units_assigned - $allocation->units_used }}
                            </td>
                            <td>{{ $allocation->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No allocations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userSelect = document.getElementById('user_id');
        const eventSelect = document.getElementById('event_id');

        userSelect.addEventListener('change', function () {
            const userId = this.value;
            eventSelect.innerHTML = '<option value="">-- Select Event --</option>';

            if (!userId) return;

            fetch(`/customer/${userId}/events`)
                .then(response => response.json())
                .then(events => {
                    events.forEach(event => {
                        const option = document.createElement('option');
                        option.value = event.id;
                        option.textContent = event.title;
                        eventSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Failed to fetch events:', error);
                });
        });
    });
</script>
@endsection
