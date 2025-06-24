<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-dark">
                <i class="bi bi-list-task me-2"></i>My Tasks
            </h2>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> New Task
            </a>
        </div>
    </x-slot>

    <!-- Task Filters and Stats Row -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-list"></i> All Tasks
                                </a>
                                <a href="{{ route('tasks.index') }}?status=pending" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-clock"></i> Pending
                                </a>
                                <a href="{{ route('tasks.index') }}?status=in_progress" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-play-circle"></i> In Progress
                                </a>
                                <a href="{{ route('tasks.index') }}?status=completed" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-check-circle"></i> Completed
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <small class="text-muted">
                                Total: <strong>{{ $tasks->count() }}</strong> tasks
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Grid -->
    <div class="row">
        @forelse($tasks as $task)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $task->title }}</h5>
                            <div class="dropdown">
                                <button class="btn btn-link btn-sm text-muted p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
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
                                            <button type="submit" class="dropdown-item text-danger" 
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        @if($task->description)
                            <p class="card-text text-muted small">{{ Str::limit($task->description, 100) }}</p>
                        @endif
                        
                        <!-- Status and Priority Badges -->
                        <div class="mb-3">
                            <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'primary' : ($task->status === 'cancelled' ? 'danger' : 'secondary')) }}">
                                <i class="bi bi-{{ $task->status === 'completed' ? 'check-circle' : ($task->status === 'in_progress' ? 'play-circle' : ($task->status === 'cancelled' ? 'x-circle' : 'circle')) }}"></i>
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                            
                            <span class="badge bg-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning text-dark' : ($task->priority === 'medium' ? 'info' : 'secondary')) }}">
                                <i class="bi bi-flag-fill"></i>
                                {{ ucfirst($task->priority) }}
                            </span>
                            
                            @if($task->category)
                                <span class="badge" style="background-color: {{ $task->category->color }}; color: white;">
                                    <i class="bi bi-folder-fill"></i>
                                    {{ $task->category->name }}
                                </span>
                            @endif
                        </div>
                        
                        <!-- Due Date and Time Info -->
                        @if($task->due_date)
                            <div class="mb-2">
                                <small class="text-muted {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-danger fw-bold' : '' }}">
                                    <i class="bi bi-calendar-event"></i> 
                                    Due: {{ $task->due_date->format('M d, Y g:i A') }}
                                    @if($task->due_date->isPast() && $task->status !== 'completed')
                                        <span class="text-danger">(Overdue)</span>
                                    @elseif($task->due_date->isToday())
                                        <span class="text-warning">(Due Today)</span>
                                    @endif
                                </small>
                            </div>
                        @endif
                        
                        <!-- Action Buttons -->
                        <div class="d-flex gap-1">
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-secondary btn-sm flex-fill">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </div>
                    </div>
                    
                    <!-- Card Footer with Metadata -->
                    <div class="card-footer bg-light border-0 small text-muted">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-clock"></i> 
                                Created {{ $task->created_at->diffForHumans() }}
                            </span>
                            @if($task->updated_at->diffInMinutes($task->created_at) > 1)
                                <span>
                                    <i class="bi bi-pencil"></i> 
                                    Updated {{ $task->updated_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-list-task display-1 text-muted mb-3"></i>
                        <h3 class="text-muted mb-3">No tasks yet</h3>
                        <p class="text-muted mb-4">Create your first task to get started with managing your work.</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-plus-circle"></i> Create Your First Task
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Custom Styles -->
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
            padding: 0.4em 0.6em;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</x-app-layout>
