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
        <button type="button" class="btn btn-dark bg-gradient mb-3" data-bs-toggle="modal" data-bs-target="#guestModal">
            <i class="fa fa-plus me-1"></i> Add Guest
        </button>
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

        <!-- Send Invitations Button -->
        <button id="sendInvitesBtn" class="btn btn-success bg-gradient m-4">Send Invitations</button>

        <!-- Guests Table -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow">
                    <div class="card-header pb-0"><h6>Guest List</h6></div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>S/N</th>
                                        <th>Title</th>
                                        <th>Guest Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($guests as $i => $guest)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="guest_ids[]" value="{{ $guest->id }}" class="guestCheckbox">
                                        </td>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $guest->title }}</td>
                                        <td>{{ $guest->name }}</td>
                                        <td>{{ $guest->email }}</td>
                                        <td>{{ $guest->phone }}</td>
                                        <td>{{ $guest->type }}</td>
                                        <td>
                                            @if ($guest->status == 0)
                                                <span class="badge bg-gradient-danger">Not Attending</span>
                                            @elseif ($guest->status == 1)
                                                <span class="badge bg-gradient-warning">Pending</span>
                                            @elseif ($guest->status == 2)
                                                <span class="badge bg-gradient-success">Attending</span>
                                            @endif
                                        </td>
                                        <td class="d-flex align-items-center gap-2">
                                            <!-- Edit Guest -->
                                            <button type="button" class="text-success bg-transparent border-0 edit-btn"
                                                data-bs-toggle="modal" data-bs-target="#editGuestModal"
                                                data-id="{{ $guest->id }}"
                                                data-name="{{ $guest->name }}"
                                                data-title="{{ $guest->title }}"
                                                data-email="{{ $guest->email }}"
                                                data-phone="{{ $guest->phone }}"
                                                data-type="{{ $guest->type }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- View Card -->
                                            <a href="/card-template/{{ $guest->id }}" class="text-warning-emphasis">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Delete Guest -->
                                            <form action="{{ route('guest.delete', $guest->id) }}" method="POST" class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="bg-transparent border-0 text-danger delete-btn">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                            @if ($guest->status == '2')
                                                <a href="/guest/{{ $guest->id }}/check" class="btn btn-dark btn-sm bg-gradient">Check</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-secondary">No Guests Invited</td>
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

    <!-- Add Guest Modal -->
    <div class="modal fade" id="guestModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Guest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-secondary-subtle">
                    <form action="/{{$event->id}}/create" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group my-2">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group my-2">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group my-2">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="form-group my-2">
                            <label>Phone</label>
                            <input type="tel" name="phone" class="form-control">
                        </div>
                        <div class="form-group my-2">
                            <label>Type</label>
                            <select name="type" class="form-select">
                                <option value="Single">Single</option>
                                <option value="Double">Double</option>
                            </select>
                        </div>

                        <hr>
                        <div class="form-group my-2">
                            <label>Import Guests (CSV/Excel)</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv,.xlsx">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="Add Guest" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Guest Modal -->
    <div class="modal fade" id="editGuestModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Guest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-secondary-subtle">
                    <form id="editGuestForm" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="event_id" id="editEventId" value="{{ $event->id }}">


                        <div class="form-group my-2">
                            <label>Name</label>
                            <input type="text" name="name" id="editName" class="form-control">
                        </div>
                        <div class="form-group my-2">
                            <label>Title</label>
                            <input type="text" name="title" id="editTitle" class="form-control">
                        </div>
                        <div class="form-group my-2">
                            <label>Email</label>
                            <input type="text" name="email" id="editEmail" class="form-control">
                        </div>
                        <div class="form-group my-2">
                            <label>Phone</label>
                            <input type="tel" name="phone" id="editPhone" class="form-control">
                        </div>
                        <div class="form-group my-2">
                            <label>Type</label>
                            <select name="type" id="editType" class="form-select">
                                <option value="Single">Single</option>
                                <option value="Double">Double</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="Update Guest" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JS Scripts -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Select All
        document.getElementById("selectAll").addEventListener("change", function () {
            document.querySelectorAll(".guestCheckbox").forEach(cb => cb.checked = this.checked);
        });

        // Delete
        document.querySelectorAll(".delete-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                if(confirm("Are you sure you want to delete this guest?")) {
                    this.closest("form").submit();
                }
            });
        });

        // Send Invitations
        document.getElementById("sendInvitesBtn").addEventListener("click", function () {
            let selectedGuests = Array.from(document.querySelectorAll(".guestCheckbox:checked")).map(cb => cb.value);
            if(selectedGuests.length === 0) { alert("Please select at least one guest."); return; }

            fetch("{{ route('send.invitations') }}", {
                method: "POST",
                headers: {"Content-Type":"application/json","X-CSRF-TOKEN":"{{ csrf_token() }}"},
                body: JSON.stringify({guest_ids:selectedGuests,event_id:document.getElementById("guestSection").dataset.eventId})
            }).then(res => res.json()).then(data => alert("Invitation Sent Successfully: "+data.message))
            .catch(err => console.error(err));
        });

        // Edit Guest Modal
        document.querySelectorAll(".edit-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                const editForm = document.getElementById("editGuestForm");
                const id = this.dataset.id;
                editForm.action = "{{ route('guest.update', ':id') }}".replace(':id', id);
                document.getElementById("editName").value = this.dataset.name;
                document.getElementById("editTitle").value = this.dataset.title;
                document.getElementById("editEmail").value = this.dataset.email;
                document.getElementById("editPhone").value = this.dataset.phone;
                document.getElementById("editType").value = this.dataset.type;
            });
        });
    });
</script>
@endsection
