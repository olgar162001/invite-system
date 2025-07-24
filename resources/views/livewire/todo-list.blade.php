<div class="py-4">
    <div class="row d-flex gap-3">
        <!-- Form Column -->
        <div class="col-md-5">
            <h4>Add New To-do</h4>
            <form wire:submit.prevent="addTodo">
                <div class="row">
                    <div class="mb-3 col-10">
                        <input type="text" wire:model="newTodo" class="form-control" placeholder="Enter to-do item...">
                        @error('newTodo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-gradient bg-gradient-info col-2">
                        <i class="fa fa-plus fs-6"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Todo List Column -->
        <div class="col-md-6">
            <h4 class="">To-do List</h4>
            <ul class="list-group">
                @forelse ($todos as $todo)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input me-2"
                                wire:click="toggleCompleted({{ $todo->id }})" {{ $todo->completed ? 'checked' : '' }}>
                            <label
                                class="form-check-label {{ $todo->completed ? 'text-decoration-line-through text-muted' : '' }} mb-0">
                                {{ $todo->title }}
                            </label>
                        </div>
                        <a class="fa fa-trash text-danger" href="#" wire:click="deleteTodo({{ $todo->id }})">
                        </a>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No tasks yet. Add one on the left!</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>