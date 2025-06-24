<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Display list of categories
    public function index()
    {
        $categories = Auth::user()->categories()->withCount('tasks')->get();
        return view('categories.index', compact('categories'));
    }

    // Show form to create a new category
    public function create()
    {
        return view('categories.create');
    }

    // Store a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        Auth::user()->categories()->create($request->all());
        return redirect()->route('categories.index')
                         ->with('success', 'Category created successfully.');
    }

    // Show a single category
    public function show(Category $category)
    {
        $this->authorize('view', $category);
        $tasks = $category->tasks()->latest()->get();
        return view('categories.show', compact('category', 'tasks'));
    }

    // Show form to edit an existing category
    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        return view('categories.edit', compact('category'));
    }

    // Update an existing category
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')
                         ->with('success', 'Category updated successfully.');
    }

    // Delete a category
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        return redirect()->route('categories.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
