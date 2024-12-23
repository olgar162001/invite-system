@extends('layouts.app')

@section('content')
@include('partials.sidebar')
    <div class="container  bg-secondary-subtle rounded p-4">
        <h1 class="text-center">Create Event</h1>
        <div class="container px-4">
            <form action="/event" method="POST" class="form">
                @csrf

                <div class="form-group my-4">
                    <label for="Event name" class="form-label">Event Name</label>
                    <input type="text" name="event_name" class="form-control">
                </div>

                <div class="form-group my-4">
                    <label for="Event host" class="form-label">Event Host</label>
                    <input type="text" name="event_host" class="form-control">
                </div>
    
                <div class="form-group my-4">
                    <label for="Event name" class="form-label">Event Type</label>
                    <select class="form-select" name="event_type">
                        <option value="Wedding">Wedding</option>
                    </select>
                </div>
    
                <div class="row my-4">
                    <div class="form-group col">
                        <label for="groom" class="form-label">Groom</label>
                        <input type="text" name="groom" class="form-control">
                    </div>
    
                    <div class="form-group col">
                        <label for="bride" class="form-label">Bride</label>
                        <input type="text" name="bride" class="form-control">
                    </div>
                </div>
                
    
                <div class="row my-4">
                    <div class="form-group col">
                        <label for="Date" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control">
                    </div>
        
                    <div class="form-group col">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" name="time" class="form-control">
                    </div>
                </div>
                
    
                <div class="form-group my-4">
                    <label for="venue" class="form-label">Venue</label>
                    <input type="text" name="venue" class="form-control">
                </div>
    
                {{-- Location --}}
                <div class="row my-4">
                    <div class="form-group col">
                        <label for="location_name" class="form-label">Location Name</label>
                        <input type="text" name="location_name" title="Provide Location Name eg Serena Hotel" class="form-control">
                    </div>

                    <div class="form-group col">
                        <label for="location" class="form-label">Location Link</label>
                        <input type="text" name="location_link" title="Please provide Google maps valid location link" class="form-control">
                    </div>
                </div>
    
                <div class="form-group my-4">
                    <label for="contacts" class="form-label">Contacts</label>
                    <input type="tel" name="contacts" class="form-control">
                </div>
    
                <div class="form-group my-4">
                    <input type="submit" value="Create Event" class="form-control btn btn-success bg-gradient">
                </div>   
            </form>
        </div>    
    </div>
@endsection