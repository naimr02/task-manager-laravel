<?php
// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
	{
		$query = Auth::user()
			->tasks()
			->with('category')
			->latest();

		if ($request->filled('status') && in_array($request->status, [
			'pending','in_progress','completed'
		])) {
			$query->where('status', $request->status);
		}

		$tasks = $query->get();

		return view('tasks.index', compact('tasks'));
	}


    public function create()
    {
        $categories = Auth::user()->categories;
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date|after:now',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Auth::user()->tasks()->create($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
	{
		$this->authorize('view', $task);
		$task->load('category'); // Eager load the category relationship
		return view('tasks.show', compact('task'));
	}

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $categories = Auth::user()->categories;
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
