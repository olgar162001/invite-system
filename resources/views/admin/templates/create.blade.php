@extends('layouts.app')

@section('content')
@include('../partials.sidebar')
<div class="container">
    <h2>Create Template</h2>

    <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Template Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="preview_image" class="form-label">Preview Image</label>
            <input type="file" name="preview_image" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label for="template_file" class="form-label">Template File (e.g. Blade path or file name)</label>
            <input type="text" name="template_file" class="form-control" required value="{{ old('template_file') }}">
        </div>

        <button type="submit" class="btn btn-primary">Save Template</button>
        <a href="{{ route('templates.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
