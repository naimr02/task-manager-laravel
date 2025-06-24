<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-dark">
                <i class="bi bi-folder-open me-2"></i>Category Details
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil"></i> Edit Category
                </a>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Categories
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <!-- Category Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background-color: {{ $category->color }}; color: white;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="h5 mb-2 fw-bold">{{ $category->name }}</h3>
                            <small class="opacity-75">
                                <i class="bi bi-calendar-plus"></i> Created {{ $category->created_at->format('M d, Y') }}
                            </small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('categories.edit', $category) }}">
                                    <i class="bi bi-pencil"></i> Edit Category
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" 
                                                onclick="return confirm('Are you sure you want to delete this category? All tasks in this category will become uncategorized.')">
                                            <i class="bi bi-trash"></i> Delete Category
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($category->description)
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="bi bi-card-text me-1"></i>Description
                            </h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0">{{ $category->description }}</p>
                            </div>
                        </div>
                    @else
                        <div class="mb-4">
                            <div class="text-center py-3 bg-light rounded">
                                <i class="bi bi-file-text text-muted"></i>
                                <p class="mb-0 text-muted">No description provided</p>
                            </div>
                        </div>
                    @endif

                    <!-- Category Tasks -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-muted mb-0">
                                <i class="bi bi-list-task me-1"></i>Tasks in this Category ({{ $tasks->count() }})
                            </h6>
                            <a href="{{ route('tasks.create') }}?category_id={{ $category->id }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-circle"></i> Add Task
                            </a>
                        </div>

                        @forelse($tasks as $task)
                            <div class="card mb-2 border-start" style="border-left-color: {{ $category->color }} !important; border-left-width: 4px !important;">
                                <div class="card-body py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none">
                                                    {{ $task->title }}
                                                </a>
                                            </h6>
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'primary' : 'secondary') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                                <span class="badge bg-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning text-dark' : 'secondary') }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                                @if($task->due_date)
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar"></i> Due: {{ $task->due_date->format('M d') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <h5 class="mt-3 text-muted">No tasks in this category</h5>
                                <p class="text-muted">Create your first task for this category.</p>
                                <a href="{{ route('tasks.create') }}?category_id={{ $category->id }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Create Task
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Statistics Sidebar -->
        <div class="col-lg-4">
            <!-- Category Stats -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-bar-chart me-1"></i>Category Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">Total Tasks</span>
                                <span class="fw-bold">{{ $tasks->count() }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">Completed</span>
                                <span class="fw-bold text-success">{{ $tasks->where('status', 'completed')->count() }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">In Progress</span>
                                <span class="fw-bold text-primary">{{ $tasks->where('status', 'in_progress')->count() }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">Pending</span>
                                <span class="fw-bold text-warning">{{ $tasks->where('status', 'pending')->count() }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">Overdue</span>
                                <span class="fw-bold text-danger">
                                    {{ $tasks->where('due_date', '<', now())->whereNotIn('status', ['completed', 'cancelled'])->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-1"></i>Category Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">Color Theme</span>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle" style="width: 20px; height: 20px; background-color: {{ $category->color }};"></div>
                                    <span class="fw-medium">{{ $category->color }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">Created Date</span>
                                <span class="fw-medium">{{ $category->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">Last Updated</span>
                                <span class="fw-medium">{{ $category->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning me-1"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit Category
                        </a>
                        <a href="{{ route('tasks.create') }}?category_id={{ $category->id }}" class="btn btn-outline-primary">
                            <i class="bi bi-plus-circle"></i> Add New Task
                        </a>
                        <a href="{{ route('tasks.index') }}?category={{ $category->id }}" class="btn btn-outline-info">
                            <i class="bi bi-filter"></i> View All Tasks
                        </a>
                        <a href="{{ route('categories.create') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-folder-plus"></i> Create New Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
