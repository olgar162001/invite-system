@extends('layouts.app')

@section('content')
@section('title', 'Assign SMS')
    @include('partials.sidebar')

    <div class="container mt-5">
        <h2 class="text-center mb-4 text-dark">Assign SMS Units to Customer</h2>

        {{-- Form --}}
        <form method="POST" action="{{ route('sms.assign.store') }}" class="card p-4 shadow-sm bg-white">
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

            <div class="mb-3 col-md-6 col-sm-12">
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
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 shadow">
                        <div class="card-header pb-0">
                            <h6>SMS Allocations</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Customer</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Event</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Units Assigned</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Units Used</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Remaining</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($allocations as $allocation)
                                            <tr>
                                                <td class="text-sm">{{ $allocation->user->name }}</td>
                                                <td class="text-sm">{{ $allocation->event->title }}</td>
                                                <td class="text-sm">{{ $allocation->units_assigned }}</td>
                                                <td class="text-sm">{{ $allocation->units_used }}</td>
                                                <td
                                                    class="text-sm {{ $allocation->units_used >= $allocation->units_assigned ? 'text-danger' : 'text-success' }}">
                                                    {{ $allocation->units_assigned - $allocation->units_used }}
                                                </td>
                                                <td class="text-sm">{{ $allocation->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-sm text-secondary">No allocations found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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