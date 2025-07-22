@extends('layouts.app')

@section('title', 'To-Do List')
@section('content')
@include('partials.sidebar')

<div class="container">
    <h2>Add To-Do item</h2>
    <form action="{{ route('to_do.store') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Task Title -->
            <div class="mb-3 col-md-6 col-sm-12">
                <label for="title" class="form-label">Task Name</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <!-- Due Date -->
            <div class="mb-3 col-md-6 col-sm-12">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <!-- Status -->
            <div class="mb-3 col-md-6 col-sm-12">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <!-- Assigned To (Optional) -->
            <div class="mb-3 col-md-6 col-sm-12">
                <label for="assigned_to" class="form-label">Assigned To (Optional)</label>
                <input type="text" name="assigned_to" class="form-control" placeholder="e.g. John Doe or Event Manager">
            </div>
        </div>

        <div class="row">
            <!-- Description / Notes -->
            <div class="mb-3 col-md-6 col-sm-12">
                <label for="description" class="form-label">Notes</label>
                <textarea name="description" class="form-control" rows="3"
                    placeholder="Add any notes or additional details..."></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save Task</button>
    </form>
</div>
@endsection