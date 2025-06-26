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

        <!-- Button for Sending Invitations -->
        <button id="sendInvitesBtn" class="btn btn-success bg-gradient m-4">Send Invitations</button>

        <!-- Guests Table -->
        <div class="table-responsive-md container-fluid">
            <table class="table table-rounded table-secondary table-striped table-hover">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>s/n</th>
                        <th>Title</th>
                        <th>Guest Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody class="table-group-divider">
                    @if(count($guests) > 0)
                        @foreach ($guests as $i => $guest)
                            <tr>
                                <td><input type="checkbox" name="guest_ids[]" value="{{ $guest->id }}" class="guestCheckbox"></td>
                                <td>{{$i + 1}}</td>
                                <td>{{$guest->title}}</td>
                                <td>{{$guest->name}}</td>
                                <td>{{$guest->email}}</td>
                                <td>{{$guest->phone}}</td>
                                <td>{{$guest->type}}</td>

                                <td>
                                    @if ($guest->status == 0)
                                        <span class="badge rounded-pill text-bg-danger">Not Attending</span>
                                    @elseif ($guest->status == 1)
                                        <span class="badge rounded-pill text-bg-warning">Pending</span>
                                    @elseif ($guest->status == 2)
                                        <span class="badge rounded-pill text-bg-success">Attending</span>
                                    @endif
                                </td>

                                <td class="d-flex align-items-center">
                                    <a href="{{route('guest.edit', $guest->id)}}" class="text-success">
                                        <span class="fas fa-edit"></span>
                                    </a>
                                    <a href="/card-template/{{$guest->id}}" class="text-warning-emphasis mx-1" title="View Card">
                                        <span class="fas fa-eye"></span>
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{route('guest.delete', $guest->id)}}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="fas fa-trash text-danger border-0 bg-transparent delete-btn"></button>
                                    </form>

                                    <!--<a href="#" onclick="sendWhatsAppMessage('{{ $guest->phone }}', '{{ $guest->invite_link }}')" class="btn btn-success bg-gradient">
                                        Send invitation
                                    </a>-->
                                    @if ($guest->status == '2')
                                        <a href="/guest/{{$guest->id}}/check" class="btn btn-dark mx-1 bg-gradient">Check</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center">No Guests Invited</td>
                        </tr>    
                    @endif
                </tbody>
            </table>
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
                            <button type="button" class="btn btn-dark bg-gradient" data-bs-dismiss="modal">Close</button>
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
        document.getElementById("selectAll").addEventListener("change", function() {
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
        document.getElementById("sendInvitesBtn").addEventListener("click", function() {
            let selectedGuests = [];
            document.querySelectorAll(".guestCheckbox:checked").forEach(checkbox => {
                selectedGuests.push(checkbox.value);
            });

            if (selectedGuests.length === 0) {
                alert("Please select at least one guest.");
                return;
            }

            // Send POST request to Laravel route
            fetch("{{ route('send.invitations') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ guest_ids: selectedGuests })
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
