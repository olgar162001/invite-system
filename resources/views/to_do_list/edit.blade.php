@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Task</h2>

    <form action="{{ route('tasks.update', $to_do->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-2">
            <label for="title">Task Title</label>
            <input type="text" name="title" value="{{ $to_do->title }}" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="description">Notes</label>
            <textarea name="description" class="form-control">{{ $to_do->description }}</textarea>
        </div>

        <div class="mb-2">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" value="{{ $to_do->due_date }}" class="form-control">
        </div>

        <div class="mb-2">
            <label for="status">Status</label>
            <select name="status" class="form-control">
                <option value="Pending" {{ $to_do->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="In Progress" {{ $to_do->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Completed" {{ $to_do->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="mb-2">
            <label for="assigned_to">Assigned To</label>
            <input type="text" name="assigned_to" value="{{ $to_do->assigned_to }}" class="form-control">
        </div>

        
        <button type="submit" class="btn btn-dark">Update</button>
    </form>
</div>
@endsection
