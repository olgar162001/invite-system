@extends('layouts.app')

@section('content')
    @include('partials.sidebar')
    <div class="container">
        <h1 class="text-center">Events</h1>
        <div class="container">
            <hr style="margin: auto; width: 8%;">
            <div class="container">
                <div class="container d-flex justify-content-start">
                    <a href="/event/create" class="btn btn-dark bg-gradient mb-3"><i class="fa fa-plus me-1"></i> Create Event</a>
                </div>
                
                <div class="table-responsive-md container-fluid">
                    <table class="table table-rounded table-secondary table-striped table-hover">
                        <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Event Name</th>
                                <th>Event Host</th>
                                <th>Event Type</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Venue</th>
                                <th>Location</th>
                                <th>Template</th> {{-- New column --}}
                                <th>Action</th>
                            </tr>
                        </thead>
    
                        <tbody class="table-group-divider">
                            @if(count($events) > 0)
                                @foreach ($events as $i => $event)
                                    <tr>
                                        <td>{{$i + 1}}</td>
                                        <td>{{$event->event_name}}</td>
                                        <td>{{$event->event_host}}</td>
                                        <td>{{$event->event_type}}</td>
                                        <td>{{$event->date}}</td>
                                        <td>{{$event->time}}</td>
                                        <td>{{$event->venue}}</td>
                                        <td><a href="{{$event->location_link}}">{{$event->location_name}}</a></td>
                                        <td>{{ $event->template->name ?? 'N/A' }}</td> {{-- Show template name or fallback --}}
                                        <td class="d-flex align-items-center gap-2">
                                            <a href="/event/{{$event->id}}/edit" class="text-success"><span class="fas fa-edit"></span></a>
                                            <form action="/event/{{$event->id}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="fas fa-trash text-danger border-0 bg-transparent"></button>
                                            </form>
                                            <a href="/event/{{$event->id}}" class="btn btn-success bg-gradient">Guests</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">No Events Found</td>
                                </tr>    
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
