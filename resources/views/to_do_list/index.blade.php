@extends('layouts.app')

@section('title', 'To-Do List')
@section('content')
    @include('partials.sidebar')

    <div class="container">
        <h2>To-Do List</h2>

        <a href="{{ route('tasks.create') }}" class="btn btn-dark my-3"><i class="fa fa-add"></i> Add Task</a>

        @forelse($tasks as $task)
            <div class="card my-3 col-4">
                <div class="card-body">
                <div class="d-flex gap-2 align-items-center mb-2">
                    <h4 class="card-title m-0 text-dark">
                        {{ $task->title }}
                    </h4>
                        <span class="badge rounded-pill
                            @if($task->status === 'Completed') text-bg-success 
                            @elseif($task->status === 'In Progress') text-bg-info 
                            @else text-bg-secondary @endif">
                            {{ $task->status }}
                        </span>
                </div>

                    <p class="mb-1"><strong>Due:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'N/A' }}</p>
                    <p class="mb-1"><strong>Assigned To:</strong> {{ $task->assigned_to ?? 'Unassigned' }}</p>
                    <p class="mb-2"><strong>Notes:</strong> {{ $task->description ?? 'None' }}</p>

                    <div>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
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
