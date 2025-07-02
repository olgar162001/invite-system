@extends('layouts.app')

@section('content')
    @include('partials.sidebar')

    <div class="container">
        <h1 class="text-center">Show Guests</h1>
        <hr style="margin: auto; width: 8%;">

        <!-- Back & Add Guest Buttons -->
        <div class="container d-flex justify-content-between">
            <a href="/event" class="btn btn-dark bg-gradient mb-3">
                <i class="fa fa-arrow-left me-1"></i> Go Back
            </a>
            <a href="" class="btn btn-dark bg-gradient mb-3" data-bs-toggle="modal" data-bs-target="#guestModal">
                <i class="fa fa-plus me-1"></i> Add Guest
            </a>
        </div>

        <!-- Event Details -->
        <div class="container d-flex justify-content-between">
            <h3>Event: {{$event->event_name}}</h3>
            <h3>Type: {{$event->event_type}}</h3>
        </div>

        <!-- Search Form + Show All Button -->
        <div class="container my-3 d-flex">
            <form action="{{ route('guest.search', $event->id) }}" method="GET" class="d-flex me-2">
                <input type="text" name="token" class="form-control me-2" placeholder="Enter guest token" required>
                <button type="submit" class="btn btn-success">Search & Check-in</button>
            </form>

            @if(request()->has('token'))
                <a href="{{ route('event.show', $event->id) }}" class="btn btn-dark">Show All</a>
            @endif
        </div>

        <div id="guestSection" data-event-id="{{ $event->id }}">


            <!-- Button for Sending Invitations -->
            <button id="sendInvitesBtn" class="btn btn-success bg-gradient m-4">Send Invitations</button>

            <!-- Guests Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 shadow">
                        <div class="card-header pb-0">
                            <h6>Guest List</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                S/N</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Title</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Guest Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Email</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Phone</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Type</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($guests as $i => $guest)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" name="guest_ids[]" value="{{ $guest->id }}"
                                                        class="guestCheckbox">
                                                </td>
                                                <td class="text-sm">{{ $i + 1 }}</td>
                                                <td class="text-sm">{{ $guest->title }}</td>
                                                <td class="text-sm">{{ $guest->name }}</td>
                                                <td class="text-sm">{{ $guest->email }}</td>
                                                <td class="text-sm">{{ $guest->phone }}</td>
                                                <td class="text-sm">{{ $guest->type }}</td>
                                                <td>
                                                    @if ($guest->status == 0)
                                                        <span class="badge bg-gradient-danger">Not Attending</span>
                                                    @elseif ($guest->status == 1)
                                                        <span class="badge bg-gradient-warning">Pending</span>
                                                    @elseif ($guest->status == 2)
                                                        <span class="badge bg-gradient-success">Attending</span>
                                                    @endif
                                                </td>
                                                <td class="text-sm d-flex align-items-center gap-2">
                                                    <a href="{{ route('guest.edit', $guest->id) }}" class="text-success"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="/card-template/{{ $guest->id }}" class="text-warning-emphasis"
                                                        title="View Card">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('guest.delete', $guest->id) }}" method="POST"
                                                        class="delete-form d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="bg-transparent border-0 text-danger delete-btn"
                                                            title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @if ($guest->status == '2')
                                                        <a href="/guest/{{ $guest->id }}/check"
                                                            class="btn btn-dark btn-sm bg-gradient" title="Check In">
                                                            Check
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-sm text-secondary">No Guests Invited
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
        <!-- Modal for Adding a Guest -->
        <div class="modal fade" id="guestModal" tabindex="-1" aria-labelledby="guestModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="guestModalLabel">Add Guest</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-secondary-subtle">
                        <form action="/{{$event->id}}/create" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group my-2">
                                <label for="Name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group my-2">
                                <label for="Title" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                            <div class="form-group my-2">
                                <label for="Email" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="form-group my-2">
                                <label for="Phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" class="form-control">
                            </div>
                            <div class="form-group my-2">
                                <label for="Type" class="form-label">Type</label>
                                <select name="type" class="form-select">
                                    <option value="Single">Single</option>
                                    <option value="Double">Double</option>
                                </select>
                            </div>

                            <hr>

                            <!-- Bulk Import Section -->
                            <div class="form-group my-2">
                                <label for="csv_file" class="form-label">Import Guests (CSV/Excel)</label>
                                <input type="file" name="csv_file" class="form-control" accept=".csv,.xlsx">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark bg-gradient"
                                    data-bs-dismiss="modal">Close</button>
                                <input type="submit" value="Add Guest" class="btn btn-success bg-gradient">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript for Select All and Delete Confirmation -->
        <script>
            // Handle "Select All" functionality
            document.getElementById("selectAll").addEventListener("change", function () {
                let checkboxes = document.querySelectorAll(".guestCheckbox");
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });

            // Handle Delete Confirmation
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".delete-btn").forEach(button => {
                    button.addEventListener("click", function () {
                        if (confirm("Are you sure you want to delete this guest?")) {
                            this.closest("form").submit();
                        }
                    });
                });
            });

            // Handle Sending Invitations
            document.getElementById("sendInvitesBtn").onclick = null;
            document.getElementById("sendInvitesBtn").addEventListener("click", function () {
                let selectedGuests = [];
                document.querySelectorAll(".guestCheckbox:checked").forEach(checkbox => {
                    selectedGuests.push(checkbox.value);
                });

                if (selectedGuests.length === 0) {
                    alert("Please select at least one guest.");
                    return;
                }

                // Grab event ID from data attribute
                const eventId = document.getElementById("guestSection").dataset.eventId;

                fetch("{{ route('send.invitations') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        guest_ids: selectedGuests,
                        event_id: eventId
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        alert("Invitations sent successfully!");
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
            });
        </script>
@endsection