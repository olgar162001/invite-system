<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\ToDo;

class ToDoController extends Controller
{
    public function index()
    {
        $tasks = ToDo::all();
        return view('to_do_list.index', compact('tasks'));
    }

    public function todo()
    {
        $todos = Task::all();
        return view('to_do_list.todo', compact('todos'));
    }


    public function create()
    {
        return view('to_do_list.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'status'      => 'nullable|in:Pending,In Progress,Completed',
            'assigned_to' => 'nullable|string|max:255',
        ]);

        ToDo::create([
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'status'      => $request->status ?? 'Pending',
            'assigned_to' => $request->assigned_to,
            
        ]);

        return redirect()->route('to_do.index')->with('success', 'Task created.');
    }

    public function edit(ToDo $to_do)
    {
        return view('to_do_list.edit', compact('to_do'));
    }

    public function update(Request $request, ToDo $to_do)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'status'      => 'nullable|in:Pending,In Progress,Completed',
            'assigned_to' => 'nullable|string|max:255',
            
        ]);

        $to_do->update([
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'status'      => $request->status ?? 'Pending',
            'assigned_to' => $request->assigned_to,
            
        ]);

        return redirect()->route('to_do.index')->with('success', 'Task updated.');
    }

    public function destroy(ToDo $to_do)
    {
        $to_do->delete();
        return back()->with('success', 'Task deleted.');
    }
}
