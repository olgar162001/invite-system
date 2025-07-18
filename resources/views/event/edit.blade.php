@extends('layouts.app')

@section('content')
@include('partials.sidebar')
    <div class="container bg-secondary-subtle rounded p-4">
        <h1 class="text-center">Edit Event</h1>
        <div class="container px-4">
            <form action="/event/{{$event->id}}" method="POST" class="form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="customer_id" value="{{ $event->user_id }}">


                <div class="form-group my-4">
                    <label for="event_name" class="form-label">Event Name</label>
                    <input type="text" name="event_name" value="{{ $event->event_name }}" class="form-control">
                </div>

                <div class="form-group my-4">
                    <label for="event_host" class="form-label">Event Host</label>
                    <input type="text" name="event_host" value="{{ $event->event_host }}" class="form-control">
                </div>

                <div class="form-group my-4">
                    <label for="event_type" class="form-label">Event Type</label>
                    <select class="form-select" name="event_type">
                        <option value="Wedding" {{ $event->event_type == 'Wedding' ? 'selected' : '' }}>Wedding</option>
                        <!-- Add more types as needed -->
                    </select>
                </div>

                {{-- Template Selection --}}
                <div class="form-group my-4">
                    <label for="template_id" class="form-label">Invitation Template</label>
                    <select name="template_id" class="form-select">
                        <option value="">Select a template</option>
                        @foreach($templates as $template)
                            <option value="{{ $template->id }}" {{ $event->template_id == $template->id ? 'selected' : '' }}>
                                {{ $template->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row my-4">
                    <div class="form-group col">
                        <label for="groom" class="form-label">Groom</label>
                        <input type="text" name="groom" value="{{ $event->groom }}" class="form-control">
                    </div>

                    <div class="form-group col">
                        <label for="bride" class="form-label">Bride</label>
                        <input type="text" name="bride" value="{{ $event->bride }}" class="form-control">
                    </div>
                </div>

                <div class="row my-4">
                    <div class="form-group col">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" value="{{ $event->date }}" class="form-control">
                    </div>

                    <div class="form-group col">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" name="time" value="{{ $event->time }}" class="form-control">
                    </div>
                </div>

                <div class="form-group my-4">
                    <label for="venue" class="form-label">Venue</label>
                    <input type="text" name="venue" value="{{ $event->venue }}" class="form-control">
                </div>

                <div class="row my-4">
                    <div class="form-group col">
                        <label for="location_name" class="form-label">Location Name</label>
                        <input type="text" name="location_name" value="{{ $event->location_name }}" class="form-control">
                    </div>

                    <div class="form-group col">
                        <label for="location_link" class="form-label">Location Link</label>
                        <input type="text" name="location_link" value="{{ $event->location_link }}" class="form-control">
                    </div>
                </div>

                <div class="form-group my-4">
                    <label for="contacts" class="form-label">Contacts</label>
                    <input type="tel" name="contacts" value="{{ $event->contacts }}" class="form-control">
                </div>

                {{-- Optional Media Uploads --}}
                <div class="form-group my-4">
                    <label for="image" class="form-label">Event Image (Optional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="form-group my-4">
                    <label for="video" class="form-label">Event Video (Optional)</label>
                    <input type="file" name="video" class="form-control" accept="video/*">
                </div>

                <div class="form-group my-4">
                    <label for="audio" class="form-label">Audio Message (Optional)</label>
                    <input type="file" name="audio" class="form-control" accept="audio/*">
                </div>

                <div class="form-group my-4">
                    <input type="submit" value="Update Event" class="form-control btn btn-success bg-gradient">
                </div>
            </form>
        </div>
    </div>
@endsection
