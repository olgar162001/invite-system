<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class TodoList extends Component
{

    public $todos;
    public $newTodo;
    public $showModal = false;

    protected $rules = [
        'newTodo' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->todos = Task::orderBy('created_at', 'desc')->get();
    }

    public function updated()
    {
        $this->todos = Task::orderBy('created_at', 'desc')->get();
    }

    public function toggleCompleted($id)
    {
        $todo = Task::find($id);
        $todo->completed = !$todo->completed;
        $todo->save();
        $this->updated();

         $this->dispatch('todo:toggled');
    }

    public function addTodo()
    {
        $this->validate();

        Task::create([
            'title' => $this->newTodo,
            'completed' => false,
        ]);

        $this->newTodo = '';
        $this->showModal = false;
        $this->updated();

        $this->dispatch('todo:added');
    }

    public function deleteTodo($id)
    {
        $todo = Task::find($id);

        if ($todo) {
            $todo->delete();
            $this->updated();

            $this->dispatch('todo:deleted');
        }
    }

    public function render()
    {
        return view('livewire.todo-list')->layout('layouts.app');
    }
}
