@extends('layouts.app')

@section('content')
@section('title', 'Events')
    @include('partials.sidebar')
    <div class="container">
        <h1 class="text-center">Events</h1>
        <div class="container">
            <hr style="margin: auto; width: 8%;">
            <div class="container">
                <div class="container d-flex justify-content-start">
                    <a href="/event/create" class="btn btn-dark bg-gradient mb-3"><i class="fa fa-plus me-1"></i> Create
                        Event</a>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4 shadow">
                            <div class="card-header pb-0">
                                <h6>Events Table</h6>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    S/N</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Event Name & Type</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Host</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Date & Time</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Venue</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Location</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Template</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($events) > 0)
                                                @foreach ($events as $i => $event)
                                                    <tr>
                                                        <td class="text-sm text-center">{{ $i + 1 }}</td>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">{{ $event->event_name }}</h6>
                                                                    <p class="text-xs text-secondary mb-0">{{ $event->event_type }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-xs text-center">{{ $event->event_host }}</td>
                                                        <td class="text-center">
                                                            <p class="text-xs font-weight-bold mb-0">{{ $event->date }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $event->time }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs mb-0">{{ $event->venue }}</p>
                                                        </td>
                                                        <td class="text-sm">
                                                            <a href="{{ $event->location_link }}" target="_blank"
                                                                class="text-primary">
                                                                {{ $event->location_name }}
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $event->template->name ?? 'N/A' }}</p>
                                                        </td>
                                                        <td class="text-sm d-flex align-items-center">
                                                            <div class="d-flex align-items-center gap-2 justify-content-center">
                                                                <a href="{{ url('/event/' . $event->id . '/edit') }}"
                                                                    class="text-success" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ url('/event/' . $event->id) }}" method="POST"
                                                                    onsubmit="return confirm('Delete this event?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="border-0 bg-transparent text-danger" title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                                <a href="{{ url('/event/' . $event->id) }}"
                                                                    class="btn btn-sm btn-success mt-3 bg-gradient" title="Guests">
                                                                    Guests
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="10" class="text-center text-sm text-secondary">No Events Found
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection