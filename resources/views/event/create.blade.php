@extends('layouts.app')

@section('content')
@section('title', 'Create Event')
@include('partials.sidebar')

<div class="container rounded p-4">
    <h1 class="text-center">Create Event</h1>
    <div class="container px-4">
        <form action="/event" method="POST" class="form" enctype="multipart/form-data">
            @csrf

            <!-- Event Name -->
            <div class="form-group my-4">
                <label for="event_name" class="form-label">Event Name</label>
                <input type="text" name="event_name" class="form-control" required>
            </div>

            <!-- Event Host -->
            <div class="form-group my-4">
                <label for="event_host" class="form-label">Event Host</label>
                <input type="text" name="event_host" class="form-control" required>
            </div>

            <!-- Event Type -->
            <div class="form-group my-4">
                <label for="event_type" class="form-label">Event Type</label>
                <select class="form-select" name="event_type" id="event_type" required>
                    <option value="">Select Event Type</option>
                    <option value="Wedding">Wedding</option>
                    <option value="Meeting">Meeting</option>
                    <option value="Conference">Conference</option>
                    <option value="Birthday">Birthday</option>
                    <option value="Funeral">Funeral</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <!-- Template Selection -->
            <div class="form-group my-4">
                <label for="template_id" class="form-label">Invitation Template (Optional)</label>
                <select name="template_id" class="form-select">
                    <option value="">Select Template</option>
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Wedding-specific fields -->
            <div id="wedding_fields" style="display:none;">
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
            </div>

            <!-- Date and Time -->
            <div class="row my-4">
                <div class="form-group col">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="form-group col">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" name="time" class="form-control" required>
                </div>
            </div>

            <!-- Venue -->
            <div class="form-group my-4">
                <label for="venue" class="form-label">Venue</label>
                <input type="text" name="venue" class="form-control" required>
            </div>

            <!-- Location -->
            <div class="row my-4">
                <div class="form-group col">
                    <label for="location_name" class="form-label">Location Name</label>
                    <input type="text" name="location_name" class="form-control" title="Provide Location Name eg Serena Hotel">
                </div>

                <div class="form-group col">
                    <label for="location_link" class="form-label">Location Link</label>
                    <input type="text" name="location_link" class="form-control" title="Please provide Google maps valid location link">
                </div>
            </div>

            <!-- Contacts -->
            <div class="form-group my-4">
                <label for="contacts" class="form-label">Contacts</label>
                <input type="tel" name="contacts" class="form-control">
            </div>

            <!-- Uploads -->
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

            <!-- Submit -->
            <div class="form-group my-4">
                <input type="submit" value="Create Event" class="form-control btn btn-success bg-gradient">
            </div>   
        </form>
    </div>    
</div>

<script>
    document.getElementById('event_type').addEventListener('change', function () {
        let weddingFields = document.getElementById('wedding_fields');
        if (this.value === 'Wedding') {
            weddingFields.style.display = 'block';
        } else {
            weddingFields.style.display = 'none';
        }
    });
</script>
@endsection
