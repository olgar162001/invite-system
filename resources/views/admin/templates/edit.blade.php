@extends('layouts.app')

@section('content')
@include('../partials.sidebar')
<div class="container">
    <h2>Edit Template</h2>

    <form action="{{ route('templates.update', $template->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Template Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $template->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Current Preview</label><br>
            <img src="{{ asset('storage/' . $template->preview_image) }}" alt="Preview" width="120">
        </div>

        <div class="mb-3">
            <label for="preview_image" class="form-label">New Preview Image (optional)</label>
            <input type="file" name="preview_image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="template_file" class="form-label">Template File</label>
            <input type="text" name="template_file" class="form-control" required value="{{ old('template_file', $template->template_file) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Template</button>
        <a href="{{ route('templates.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
