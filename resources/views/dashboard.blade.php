<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-dark">
                <i class="bi bi-speedometer2 me-2"></i>{{ __('Task Manager Dashboard') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> New Task
                </a>
                <a href="{{ route('categories.create') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-folder-plus"></i> New Category
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Statistics Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Tasks
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ Auth::user()->tasks()->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-list-task fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Completed Tasks
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ Auth::user()->tasks()->where('status', 'completed')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                In Progress
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ Auth::user()->tasks()->where('status', 'in_progress')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-hourglass-split fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Overdue Tasks
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ Auth::user()->tasks()->where('due_date', '<', now())->whereNotIn('status', ['completed', 'cancelled'])->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Recent Tasks Column -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-clock-history me-2"></i>Recent Tasks
                    </h6>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    @forelse(Auth::user()->tasks()->latest()->limit(5)->get() as $task)
                        <div class="d-flex align-items-center py-2 border-bottom">
                            <div class="flex-shrink-0 me-3">
                                @if($task->status === 'completed')
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @elseif($task->status === 'in_progress')
                                    <i class="bi bi-play-circle-fill text-warning"></i>
                                @elseif($task->due_date && $task->due_date->isPast() && $task->status !== 'completed')
                                    <i class="bi bi-exclamation-circle-fill text-danger"></i>
                                @else
                                    <i class="bi bi-circle text-secondary"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none">
                                                {{ $task->title }}
                                            </a>
                                        </h6>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="badge bg-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            @if($task->category)
                                                <span class="badge" style="background-color: {{ $task->category->color }}">
                                                    {{ $task->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($task->due_date)
                                            <small class="text-muted">
                                                <i class="bi bi-calendar"></i> 
                                                Due: {{ $task->due_date->format('M d, Y') }}
                                                @if($task->due_date->isPast() && $task->status !== 'completed')
                                                    <span class="text-danger">(Overdue)</span>
                                                @endif
                                            </small>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('tasks.show', $task) }}">
                                                    <i class="bi bi-eye"></i> View
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('tasks.edit', $task) }}">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">No tasks yet</h5>
                            <p class="text-muted">Create your first task to get started!</p>
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Create Task
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-xl-4 col-lg-5">
            <!-- Priority Tasks -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>High Priority Tasks
                    </h6>
                </div>
                <div class="card-body">
                    @forelse(Auth::user()->tasks()->whereIn('priority', ['urgent', 'high'])->whereNotIn('status', ['completed', 'cancelled'])->limit(3)->get() as $task)
                        <div class="d-flex align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="flex-shrink-0 me-2">
                                <span class="badge bg-{{ $task->priority === 'urgent' ? 'danger' : 'warning' }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none">
                                        {{ Str::limit($task->title, 30) }}
                                    </a>
                                </h6>
                                @if($task->due_date)
                                    <small class="text-muted">
                                        Due: {{ $task->due_date->format('M d') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="bi bi-check-circle text-success"></i>
                            <p class="mb-0 text-muted">No high priority tasks!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Categories Overview -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="bi bi-folder me-2"></i>Categories
                    </h6>
                </div>
                <div class="card-body">
                    @forelse(Auth::user()->categories()->withCount('tasks')->limit(5)->get() as $category)
                        <div class="d-flex align-items-center justify-content-between py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="width: 12px; height: 12px; background-color: {{ $category->color }};"></div>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        <a href="{{ route('categories.show', $category) }}" class="text-decoration-none">
                                            {{ $category->name }}
                                        </a>
                                    </h6>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark">{{ $category->tasks_count }}</span>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="bi bi-folder-plus text-muted"></i>
                            <p class="mb-2 text-muted">No categories yet</p>
                            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-outline-primary">
                                Create Category
                            </a>
                        </div>
                    @endforelse
                    
                    @if(Auth::user()->categories()->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-info">
                                View All Categories
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="bi bi-lightning me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Create New Task
                        </a>
                        <a href="{{ route('categories.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-folder-plus"></i> Add Category
                        </a>
                        <a href="{{ route('tasks.index') }}?status=pending" class="btn btn-outline-warning">
                            <i class="bi bi-list-ul"></i> View Pending Tasks
                        </a>
                        <a href="{{ route('tasks.index') }}?status=completed" class="btn btn-outline-success">
                            <i class="bi bi-check-all"></i> View Completed Tasks
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for dashboard styling -->
    <style>
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }
        .text-xs {
            font-size: 0.7rem;
        }
        .card {
            transition: all 0.3s;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .dropdown-toggle::after {
            display: none;
        }
    </style>
</x-app-layout>
