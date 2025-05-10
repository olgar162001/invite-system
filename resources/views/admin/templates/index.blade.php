@extends('layouts.app')

@section('content')
@include('../partials.sidebar')
<div class="container">
    <h1 class="text-center">Templates</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(Auth::check() && Auth::user()->role === 'admin')
    <div class="mb-3">
        <a href="{{ route('templates.create') }}" class="btn btn-primary">Create New Template</a>
    </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Preview</th>
                    <th>Name</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $i => $template)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $template->preview_image) }}" alt="Preview" width="80">
                        </td>
                        <td>{{ $template->name }}</td>
                        <td>{{ $template->template_file }}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('templates.edit', $template->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('templates.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this template?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No templates found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
