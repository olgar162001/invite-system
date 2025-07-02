@extends('layouts.app')

@section('content')
@section('title', 'Card Templates')
    @include('../partials.sidebar')
    <div class="container">
        <h1 class="text-center">Templates</h1>
        
        @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="mb-3">
                <a href="{{ route('templates.create') }}" class="btn btn-primary">Create New Template</a>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow">
                    <div class="card-header pb-0">
                        <h6>Card Templates Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Preview</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">File
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($templates as $i => $template)
                                        <tr>
                                            <td class="text-sm text-center">{{ $i + 1 }}</td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('storage/' . $template->preview_image) }}"
                                                            class="avatar avatar-sm me-3" alt="preview">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-xs text-secondary mb-0">Preview</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm mb-0">{{ $template->name }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm mb-0">{{ $template->template_file }}</p>
                                            </td>
                                            <td class="text-sm d-flex align-items-center justify-content-center gap-2">
                                                <a href="{{ route('templates.edit', $template->id) }}" class="text-warning"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('templates.destroy', $template->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this template?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="border-0 bg-transparent text-danger"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-sm text-secondary">No templates found.</td>
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
@endsection