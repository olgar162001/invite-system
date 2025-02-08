@extends('layouts.app')
@section('content')
    @include('partials.sidebar')

    <div class="container">
        <h1 class="text-center">Show Guests</h1>

        <div class="container">
            <hr style="margin: auto; width: 8%;">

            <div class="container d-flex justify-content-between">
                <a href="/event" class="btn btn-dark bg-gradient mb-3">
                    <i class="fa fa-arrow-left me-1"></i> Go Back
                </a>
                <a href="" class="btn btn-dark bg-gradient mb-3" data-bs-toggle="modal" data-bs-target="#guestModal">
                    <i class="fa fa-plus me-1"></i> Add Guest
                </a>
            </div>

            <div class="container d-flex justify-content-between">
                <h3>Event: {{$event->event_name}}</h3>
                <h3>Type: {{$event->event_type}}</h3>
            </div>

            <!-- Search Form for Checking In by Token -->
            <div class="container my-3">
                <form action="{{ route('guest.search', $event->id) }}" method="GET" class="d-flex">
                    <input type="text" name="token" class="form-control me-2" placeholder="Enter guest token" required>
                    <button type="submit" class="btn btn-success">Search & Check-in</button>
                </form>
            </div>

            <div class="table-responsive-md container-fluid">
                <table class="table table-rounded table-secondary table-striped table-hover">
                    <tr>
                        <th>s/n</th>
                        <th>Title</th>
                        <th>Guest Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    <tbody class="table-group-divider">
                        @if(count($guests) > 0)
                            @foreach ($guests as $i => $guest)
                                <tr>
                                    <td>{{$i + 1}}</td>
                                    <td>{{$guest->title}}</td>
                                    <td>{{$guest->name}}</td>
                                    <td>{{$guest->email}}</td>
                                    <td>{{$guest->phone}}</td>
                                    <td>{{$guest->type}}</td>

                                    @if ($guest->status == 0)
                                        <td><span class="badge rounded-pill text-bg-danger">Not Attending</span></td>
                                    @elseif ($guest->status == 1)
                                        <td><span class="badge rounded-pill text-bg-warning">Pending</span></td>
                                    @elseif ($guest->status == 2)
                                        <td><span class="badge rounded-pill text-bg-success">Attending</span></td>
                                    @endif

                                    @if ($guest->check_status == '0')
                                        <td class="d-flex align-items-center">
                                            <a href="/guest/{{$guest->id}}/edit" class="text-success">
                                                <span class="fas fa-edit"></span>
                                            </a>
                                            <a href="/card-template/{{$guest->id}}" class="text-warning-emphasis mx-1" title="View Card">
                                                <span class="fas fa-eye"></span>
                                            </a>
                                            <form action="/guest/{{$guest->id}}" method="POST">
                                                {{ csrf_field() }}
                                                {{method_field('DELETE')}}
                                                <button type="submit" class="fas fa-trash text-danger border-0 bg-transparent"></button>
                                            </form>
                                            <a href="#" onclick="sendWhatsAppMessage('{{ $guest->phone }}', '{{ $guest->invite_link }}')" class="btn btn-success bg-gradient">Send invitation</a>
                                            @if ($guest->status == '2')
                                                <a href="/guest/{{$guest->id}}/check" class="btn btn-dark mx-1 bg-gradient">Check</a>
                                            @endif
                                        </td>
                                    @else
                                        <td><span class="fa fa-xl fa-check"></span></td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">No Guests Invited</td>
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
                        <form action="/guest/{{$event->id}}/create" method="post">
                            @csrf
                            <div class="form-group my-2">
                                <label for="Name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group my-2">
                                <label for="Title" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group my-2">
                                <label for="Email" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            <div class="form-group my-2">
                                <label for="Phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group my-2">
                                <label for="Type" class="form-label">Type</label>
                                <select name="type" class="form-select">
                                    <option value="Single">Single</option>
                                    <option value="Double">Double</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark bg-gradient" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Add Guest" class="btn btn-success bg-gradient">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
