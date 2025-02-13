@extends('layouts.app')
@section('content')
    @include('partials.sidebar')

    <div class="container">
        <h1 class="text-center">Manage Customers</h1>
        <hr style="margin: auto; width: 8%;">

        <!-- Back & Add Customer Buttons -->
        <div class="container d-flex justify-content-between">
            <a href="/home" class="btn btn-dark bg-gradient mb-3">
                <i class="fa fa-arrow-left me-1"></i> Go Back
            </a>
            <a href="" class="btn btn-dark bg-gradient mb-3" data-bs-toggle="modal" data-bs-target="#customerModal">
                <i class="fa fa-plus me-1"></i> Add Customer
            </a>
        </div>

        <!-- Customers Table -->
        <div class="table-responsive-md container-fluid">
            <table class="table table-rounded table-secondary table-striped table-hover">
                <tr>
                    <th>s/n</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <tbody class="table-group-divider">
                    @if(count($customers) > 0)
                        @foreach ($customers as $i => $customer)
                            <tr>
                                <td>{{$i + 1}}</td>
                                <td>{{$customer->name}}</td>
                                <td>{{$customer->email}}</td>
                                <td>{{$customer->phone}}</td>
                                <td>
                                    @if ($customer->status == 1)
                                        <span class="badge rounded-pill text-bg-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="d-flex align-items-center">
                                    <a href="/customers/{{$customer->id}}/edit" class="text-success me-2">
                                        <span class="fas fa-edit"></span>
                                    </a>
                                    <form action="/customers/{{$customer->id}}" method="POST">
                                        {{ csrf_field() }}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="fas fa-trash text-danger border-0 bg-transparent"></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">No Customers Available</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding a Customer -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="customerModalLabel">Add Customer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-secondary-subtle">
                    <form action="{{ route('customers.store') }}" method="post">
                        @csrf
                        <div class="form-group my-2">
                            <label for="Name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group my-2">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group my-2">
                            <label for="Phone" class="form-label">Phone</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark bg-gradient" data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="Add Customer" class="btn btn-success bg-gradient">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
