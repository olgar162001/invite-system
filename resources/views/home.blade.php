@extends('layouts.app')

@section('content')
    @include('partials.sidebar')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}

    <div class="container">
        <h1 class="text-center text-dark">Dashboard</h1>
        <hr style="margin: auto; width: 8%;">

    {{-- Total Events --}}
        <div class="container mx-2 d-flex flex-wrap my-2">
            {{-- Card section --}}
            <div class="card card-width border-0 m-2 bg-primary-subtle shadow">
                <div class="card-header">
                    <h2>Total Events</h2>
                </div>
                <div class="card-body py-4 d-flex justify-content-between">
                    <div>
                        <p class="card-text">Number of Events</p>                        
                        <h3 class="card-text">{{count($events)}}</h3>
                    </div>
                </div>

            </div>
            {{-- End card section --}}

            {{-- Card section --}}
            <div class="card card-width m-2 border-0 bg-primary-subtle shadow">
                <div class="card-header">
                    <h2>Templates</h2>
                </div>
                <div class="card-body py-4 d-flex justify-content-between">
                    <div>
                        <p class="card-text">Number of Templates</p>
                        
                            <h3 class="card-text">1</h3>   
                    </div>
                </div>
            </div>
            {{-- End card section --}}
            
            {{-- Card section --}}
            {{-- <div class="card m-2 card-width border-0 bg-primary-subtle shadow">
                <div class="card-header d-flex align-items-center justify-content-between"> 
                    <h2>Pending Events</h2>
                </div>

                <div class="card-body py-4 d-flex justify-content-between">
                    <div>
                        <p class="card-text">Number of Pending Events</p>
                            <h3 class="card-text">N/A</h3>

                    </div>
                </div>
            </div> --}}
            {{-- End card section --}}

        </div>

        {{-- Table --}}
        <div class="container mt-4">
            <h2 class="text-center text-dark">Your Events</h2>

            <div class="table-responsive-md container-fluid">
                <table class="table table-rounded table-secondary table-striped table-hover">
                    <tr>
                        <th>s/n</th>
                        <th>Event Name</th>
                        <th>No. of Guests</th>
                        <th>Venue</th>
                        <th>Location</th>
                        <th>Date</th>
                        {{-- <th>Pending</th> --}}
                        {{-- <th>Not Attending</th> --}}
                        <th>Action</th>
                    </tr>
    
                    <tbody class="table-group-divider">
                        @if(count($events) > 0)
                            @foreach ($events as $i => $event)
                                <tr>
                                    <td>{{$i + 1}}</td>
                                    <td>{{$event->event_name}}</td>
                                    <td>{{(count($event->guest))}}</td>
                                    <td>{{$event->venue}}</td>
                                    <td><a href="{{$event->location_link}}">{{$event->location_name}}</a></td>
                                    <td>{{$event->date}}</td>
                                    {{-- <td>{{$pending}}</td> --}}
                                    {{-- <td>{{$not}}</td> --}}
                                        <td class="d-flex align-items-center">
                                            {{-- <a href="/event/{{$event->id}}/edit" class="text-success"><span class="fas fa-edit"></span></a>
                                            <form action="/event/{{$event->id}}" method="POST">
                                                {{ csrf_field() }}
                                                {{method_field('DELETE')}}
                                                <button type="submit" value="" class="fas fa-trash text-danger border-0 bg-transparent"></button>
                                            </form> --}}
                                            <a href="/event/{{$event->id}}" class="btn btn-success bg-gradient">Guests</a>
                                        </td>
                                    </tr>
                            @endforeach
                        @else
                            <tr>
                                <td></td>
                                <td>No Events Found</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                {{-- <td></td> --}}
                                {{-- <td></td> --}}
                            </tr>    
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

@endsection
