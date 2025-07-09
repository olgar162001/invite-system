@extends('layouts.app')

@section('content')
@section('title', 'Customers')
    @include('partials.sidebar')

    <div class="container">
        <h1 class="text-center">Manage Customers</h1>
        <hr style="margin: auto; width: 8%;">

        <div class="d-flex justify-content-between">
            <a href="{{ route('home') }}" class="btn btn-dark bg-gradient mb-3">
                <i class="fa fa-arrow-left me-1"></i> Go Back
            </a>
            <button class="btn btn-dark bg-gradient mb-3" data-bs-toggle="modal" data-bs-target="#customerModal">
                <i class="fa fa-plus me-1"></i> Add Customer
            </button>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow">
                    <div class="card-header pb-0">
                        <h6>Customers Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S/N
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Phone</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $i => $customer)
                                        <tr>
                                            <td class="text-sm text-center">{{ $i + 1 }}</td>
                                            <td>
                                                <p class="text-sm mb-0">{{ $customer->name }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm mb-0">{{ $customer->email }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm mb-0">{{ $customer->phone }}</p>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill {{ $customer->status ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                    {{ $customer->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="text-sm d-flex align-items-center justify-content-center gap-2">
                                                <a href="{{  url('/customers/' . $customer->id . '/edit') }}" class="text-warning"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ url('/customers/'. $customer->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="border-0 bg-transparent text-danger"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('admin.impersonate', $customer->id) }}"
                                                    class="btn btn-sm btn-success mt-3 bg-gradient" title="Login as Customer">
                                                    Login as Customer
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-sm text-secondary">No Customers Available
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