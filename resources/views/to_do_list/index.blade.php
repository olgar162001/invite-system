@extends('layouts.app')

@section('title', 'To-Do List')
@section('content')
    @include('partials.sidebar')

    <div class="container">
        <h2>To-Do List</h2>

        <a href="{{ route('to_do.create') }}" class="btn btn-primary mb-3">Add Task</a>

        @forelse($tasks as $task)
            <div class="card my-3">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $task->title }}
                        <span class="badge 
                            @if($task->status === 'Completed') bg-success 
                            @elseif($task->status === 'In Progress') bg-info 
                            @else bg-secondary @endif">
                            {{ $task->status }}
                        </span>
                    </h5>

                    <p class="mb-1"><strong>Due:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'N/A' }}</p>
                    <p class="mb-1"><strong>Assigned To:</strong> {{ $task->assigned_to ?? 'Unassigned' }}</p>
                    <p class="mb-2"><strong>Notes:</strong> {{ $task->description ?? 'None' }}</p>

                    <div>
                        <a href="{{ route('to_do.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('to_do.destroy', $task) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No tasks available.</p>
        @endforelse
    </div>
@endsection
