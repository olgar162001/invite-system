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
                <a href="/event/create" class="btn btn-dark bg-gradient mb-3"><i class="fa fa-plus me-1"></i> Create Event</a>
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
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S/N</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Event Name & Type</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Host</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date & Time</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Venue</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Template</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($events) > 0)
                                            @foreach ($events as $i => $event)
                                                <tr data-id="{{ $event->id }}"
                                                    data-event_name="{{ $event->event_name }}"
                                                    data-event_host="{{ $event->event_host }}"
                                                    data-event_type="{{ $event->event_type }}"
                                                    data-template_id="{{ $event->template_id }}"
                                                    data-groom="{{ $event->groom }}"
                                                    data-bride="{{ $event->bride }}"
                                                    data-date="{{ $event->date }}"
                                                    data-time="{{ $event->time }}"
                                                    data-venue="{{ $event->venue }}"
                                                    data-location_name="{{ $event->location_name }}"
                                                    data-location_link="{{ $event->location_link }}"
                                                    data-contacts="{{ $event->contacts }}"
                                                >
                                                    <td class="text-sm text-center">{{ $i + 1 }}</td>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $event->event_name }}</h6>
                                                                <p class="text-xs text-secondary mb-0">{{ $event->event_type }}</p>
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
                                                        <a href="{{ $event->location_link }}" target="_blank" class="text-primary">
                                                            {{ $event->location_name }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $event->template->name ?? 'N/A' }}</p>
                                                    </td>
                                                    <td class="text-sm d-flex align-items-center">
                                                        <div class="d-flex align-items-center gap-2 justify-content-center">
                                                            <button class="btn btn-link text-success edit-btn p-0" title="Edit" data-bs-toggle="modal" data-bs-target="#editEventModal">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <form action="{{ url('/event/' . $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="border-0 bg-transparent text-danger" title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                            <a href="{{ url('/event/' . $event->id) }}" class="btn btn-sm btn-success mt-3 bg-gradient" title="Guests">
                                                                Guests
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center text-sm text-secondary">No Events Found</td>
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

    <!-- Edit Event Modal -->
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editEventModalLabel">Edit Event</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-secondary-subtle">
                    <form id="editEventForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="customer_id" value="{{ $event->user_id }}">

                        <div class="form-group my-2">
                            <label for="editEventName" class="form-label">Event Name</label>
                            <input type="text" name="event_name" id="editEventName" class="form-control">
                        </div>

                        <div class="form-group my-2">
                            <label for="editEventHost" class="form-label">Event Host</label>
                            <input type="text" name="event_host" id="editEventHost" class="form-control">
                        </div>

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


                        <div class="row my-2">
                            <div class="form-group col">
                                <label for="editDate" class="form-label">Date</label>
                                <input type="date" name="date" id="editDate" class="form-control">
                            </div>
                            <div class="form-group col">
                                <label for="editTime" class="form-label">Time</label>
                                <input type="time" name="time" id="editTime" class="form-control">
                            </div>
                        </div>

                        <div class="form-group my-2">
                            <label for="editVenue" class="form-label">Venue</label>
                            <input type="text" name="venue" id="editVenue" class="form-control">
                        </div>

                        <div class="row my-2">
                            <div class="form-group col">
                                <label for="editLocationName" class="form-label">Location Name</label>
                                <input type="text" name="location_name" id="editLocationName" class="form-control">
                            </div>
                            <div class="form-group col">
                                <label for="editLocationLink" class="form-label">Location Link</label>
                                <input type="text" name="location_link" id="editLocationLink" class="form-control">
                            </div>
                        </div>

                        <div class="form-group my-2">
                            <label for="editContacts" class="form-label">Contacts</label>
                            <input type="tel" name="contacts" id="editContacts" class="form-control">
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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark bg-gradient" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="Update Event" class="btn btn-success bg-gradient">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JS to handle edit modal -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-btn");
    const editForm = document.getElementById("editEventForm");

    editButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");

            // Set form action
            editForm.action = `/event/${row.dataset.id}`;

            // Fill fields
            document.getElementById("editCustomerId").value = row.dataset.customer_id || '';
            document.getElementById("editEventName").value = row.dataset.event_name;
            document.getElementById("editEventHost").value = row.dataset.event_host;
            document.getElementById("editEventType").value = row.dataset.event_type;
            document.getElementById("editTemplateId").value = row.dataset.template_id;
            document.getElementById("editGroom").value = row.dataset.groom;
            document.getElementById("editBride").value = row.dataset.bride;
            document.getElementById("editDate").value = row.dataset.date;
            document.getElementById("editTime").value = row.dataset.time;
            document.getElementById("editVenue").value = row.dataset.venue;
            document.getElementById("editLocationName").value = row.dataset.location_name;
            document.getElementById("editLocationLink").value = row.dataset.location_link;
            document.getElementById("editContacts").value = row.dataset.contacts;
        });
    });
});

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
