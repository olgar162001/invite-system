@extends('layouts.app')

@section('content')
    @include('partials.sidebar')

    <div class="container">
        <h1 class="text-center">Manage Customers</h1>
        <hr style="margin: auto; width: 8%;">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between">
            <a href="{{ route('home') }}" class="btn btn-dark bg-gradient mb-3">
                <i class="fa fa-arrow-left me-1"></i> Go Back
            </a>
            <button class="btn btn-dark bg-gradient mb-3" data-bs-toggle="modal" data-bs-target="#customerModal">
                <i class="fa fa-plus me-1"></i> Add Customer
            </button>
        </div>

        <div class="table-responsive-md">
            <table class="table table-rounded table-secondary table-striped table-hover">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $i => $customer)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>
                                <span class="badge rounded-pill {{ $customer->status ? 'text-bg-success' : 'text-bg-danger' }}">
                                    {{ $customer->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('customers.edit', $customer) }}" class="text-success me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger border-0 p-0">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.impersonate', $customer->id) }}" class="text-success me-2">
                                    create event
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Customers Available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding a Customer -->
    <div class="modal fade" id="customerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Add Customer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-secondary-subtle">
                    <form action="{{ route('customers.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Add Customer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
