@extends('layouts.app')

@section('content')
@include('partials.sidebar')
    <div class="container  bg-secondary-subtle rounded p-4">
        <h1 class="text-center">Edit Event</h1>
        <div class="container px-4">
            <form action="/event/{{$event->id}}" method="POST" class="form">
                {{csrf_field()}}
                {{method_field('PUT')}}

                <div class="form-group my-4">
                    <label for="Event name" class="form-label">Event Name</label>
                    <input type="text" name="event_name" value="{{$event->event_name}}" class="form-control">
                </div>

                <div class="form-group my-4">
                    <label for="Event host" class="form-label">Event Host</label>
                    <input type="text" name="event_host" value="{{$event->event_host}}" class="form-control">
                </div>
    
                <div class="form-group my-4">
                    <label for="Event name" class="form-label">Event Type</label>
                    <select class="form-select" name="event_type" value="{{$event->event_type}}">
                        <option value="Wedding">Wedding</option>
                    </select>
                </div>
    
                <div class="row my-4">
                    <div class="form-group col">
                        <label for="groom" class="form-label">Groom</label>
                        <input type="text" name="groom" value="{{$event->groom}}" class="form-control">
                    </div>
    
                    <div class="form-group col">
                        <label for="bride" class="form-label">Bride</label>
                        <input type="text" name="bride" value="{{$event->bride}}" class="form-control">
                    </div>
                </div>
                
    
                <div class="row my-4">
                    <div class="form-group col">
                        <label for="Date" class="form-label">Date</label>
                        <input type="date" name="date" value="{{$event->date}}" class="form-control">
                    </div>
        
                    <div class="form-group col">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" name="time" value="{{$event->time}}" class="form-control">
                    </div>
                </div>
                
    
                <div class="form-group my-4">
                    <label for="venue" class="form-label">Venue</label>
                    <input type="text" name="venue" value="{{$event->venue}}" class="form-control">
                </div>
    
                {{-- Location --}}
                <div class="row my-4">
                    <div class="form-group col">
                        <label for="location_name" class="form-label">Location Name</label>
                        <input type="text" name="location_name" value="{{$event->location_name}}" title="Provide Location Name eg Serena Hotel" class="form-control">
                    </div>

                    <div class="form-group col">
                        <label for="location" class="form-label">Location Link</label>
                        <input type="text" name="location_link" value="{{$event->location_link}}" title="Please provide Google maps valid location link" class="form-control">
                    </div>
                </div>
    
                <div class="form-group my-4">
                    <label for="contacts" class="form-label">Contacts</label>
                    <input type="tel" name="contacts" value="{{$event->contacts}}" class="form-control">
                </div>
    
                <div class="form-group my-4">
                    <input type="submit" value="Edit Event" class="form-control btn btn-success bg-gradient">
                </div>   
            </form>
        </div>    
    </div>
@endsection