<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-dark">
                <i class="bi bi-folder me-2"></i>Categories
            </h2>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> New Category
            </a>
        </div>
    </x-slot>

    <div class="row">
        @forelse($categories as $category)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center" 
                         style="background-color: {{ $category->color }};">
                        <h5 class="mb-0">{{ $category->name }}</h5>
                        <span class="badge badge-light text-dark">{{ $category->tasks_count }} tasks</span>
                    </div>
                    <div class="card-body">
                        @if($category->description)
                            <p class="card-text text-muted">{{ Str::limit($category->description, 100) }}</p>
                        @else
                            <p class="card-text text-muted fst-italic">No description provided</p>
                        @endif
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> Created {{ $category->created_at->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                        onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-folder-plus display-1 text-muted"></i>
                    <h3 class="mt-3">No categories yet</h3>
                    <p class="text-muted">Create your first category to organize your tasks.</p>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Create Category
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Enhanced styling for better visual appeal -->
    <style>
        .card {
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        
        .badge {
            font-size: 0.75em;
            padding: 0.5em 0.75em;
        }
        
        .card-header {
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .btn {
            transition: all 0.2s ease;
        }
        
        .btn:hover {
            transform: scale(1.05);
        }
    </style>
</x-app-layout>
