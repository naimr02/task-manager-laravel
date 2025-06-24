<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-dark">
                <i class="bi bi-eye me-2"></i>Task Details
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil"></i> Edit Task
                </a>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Tasks
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <!-- Main Task Details -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="h5 mb-2 text-dark fw-bold">{{ $task->title }}</h3>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'primary' : ($task->status === 'cancelled' ? 'danger' : 'secondary')) }}">
                                    <i class="bi bi-{{ $task->status === 'completed' ? 'check-circle' : ($task->status === 'in_progress' ? 'play-circle' : ($task->status === 'cancelled' ? 'x-circle' : 'circle')) }}"></i>
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                                <span class="badge bg-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning text-dark' : ($task->priority === 'medium' ? 'info' : 'secondary')) }}">
                                    <i class="bi bi-flag-fill"></i>
                                    {{ ucfirst($task->priority) }} Priority
                                </span>
                                @if($task->category)
                                    <span class="badge" style="background-color: {{ $task->category->color }}; color: white;">
                                        <i class="bi bi-folder-fill"></i>
                                        {{ $task->category->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('tasks.edit', $task) }}">
                                    <i class="bi bi-pencil"></i> Edit Task
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this task?')">
                                            <i class="bi bi-trash"></i> Delete Task
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($task->description)
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="bi bi-card-text me-1"></i>Description
                            </h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0">{{ $task->description }}</p>
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

                    <!-- Quick Status Update -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">
                            <i class="bi bi-arrow-repeat me-1"></i>Quick Status Update
                        </h6>
                        <form method="POST" action="{{ route('tasks.update', $task) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="title" value="{{ $task->title }}">
                            <input type="hidden" name="description" value="{{ $task->description }}">
                            <input type="hidden" name="priority" value="{{ $task->priority }}">
                            <input type="hidden" name="due_date" value="{{ $task->due_date }}">
                            <input type="hidden" name="category_id" value="{{ $task->category_id }}">
                            
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="status" value="pending" id="status-pending" {{ $task->status === 'pending' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="btn btn-outline-secondary btn-sm" for="status-pending">
                                    <i class="bi bi-circle"></i> Pending
                                </label>

                                <input type="radio" class="btn-check" name="status" value="in_progress" id="status-progress" {{ $task->status === 'in_progress' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="btn btn-outline-primary btn-sm" for="status-progress">
                                    <i class="bi bi-play-circle"></i> In Progress
                                </label>

                                <input type="radio" class="btn-check" name="status" value="completed" id="status-completed" {{ $task->status === 'completed' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="btn btn-outline-success btn-sm" for="status-completed">
                                    <i class="bi bi-check-circle"></i> Completed
                                </label>

                                <input type="radio" class="btn-check" name="status" value="cancelled" id="status-cancelled" {{ $task->status === 'cancelled' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="btn btn-outline-danger btn-sm" for="status-cancelled">
                                    <i class="bi bi-x-circle"></i> Cancelled
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task Information Sidebar -->
        <div class="col-lg-4">
            <!-- Task Metadata -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-1"></i>Task Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">
                                    <i class="bi bi-calendar-plus me-1"></i>Created
                                </span>
                                <span class="fw-medium">{{ $task->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">
                                    <i class="bi bi-clock-history me-1"></i>Last Updated
                                </span>
                                <span class="fw-medium">{{ $task->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        @if($task->due_date)
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">
                                        <i class="bi bi-calendar-event me-1"></i>Due Date
                                    </span>
                                    <span class="fw-medium {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-danger' : '' }}">
                                        {{ $task->due_date->format('M d, Y g:i A') }}
                                        @if($task->due_date->isPast() && $task->status !== 'completed')
                                            <small class="text-danger d-block">
                                                <i class="bi bi-exclamation-triangle"></i> Overdue
                                            </small>
                                        @elseif($task->due_date->isToday())
                                            <small class="text-warning d-block">
                                                <i class="bi bi-clock"></i> Due Today
                                            </small>
                                        @elseif($task->due_date->isTomorrow())
                                            <small class="text-info d-block">
                                                <i class="bi bi-arrow-right"></i> Due Tomorrow
                                            </small>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted">
                                        <i class="bi bi-calendar-x me-1"></i>Due Date
                                    </span>
                                    <span class="text-muted">Not set</span>
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted">
                                    <i class="bi bi-person me-1"></i>Owner
                                </span>
                                <span class="fw-medium">{{ $task->user->name }}</span>
                            </div>
                        </div>

                        @if($task->category)
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted">
                                        <i class="bi bi-folder me-1"></i>Category
                                    </span>
                                    <a href="{{ route('categories.show', $task->category) }}" class="text-decoration-none">
                                        <span class="badge" style="background-color: {{ $task->category->color }}; color: white;">
                                            {{ $task->category->name }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted">
                                        <i class="bi bi-folder me-1"></i>Category
                                    </span>
                                    <span class="text-muted">Uncategorized</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Progress Indicator -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-bar-chart me-1"></i>Task Progress
                    </h6>
                </div>
                <div class="card-body text-center">
                    @php
                        $progressPercentage = match($task->status) {
                            'pending' => 0,
                            'in_progress' => 50,
                            'completed' => 100,
                            'cancelled' => 0,
                            default => 0
                        };
                        $progressColor = match($task->status) {
                            'pending' => 'secondary',
                            'in_progress' => 'primary',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                            default => 'secondary'
                        };
                    @endphp
                    
                    <div class="mb-3">
                        <div class="progress" style="height: 15px;">
                            <div class="progress-bar bg-{{ $progressColor }}" role="progressbar" 
                                 style="width: {{ $progressPercentage }}%"
                                 aria-valuenow="{{ $progressPercentage }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                {{ $progressPercentage }}%
                            </div>
                        </div>
                    </div>
                    
                    <h4 class="text-{{ $progressColor }} mb-2">{{ $progressPercentage }}% Complete</h4>
                    <p class="text-muted mb-0">
                        Status: <strong>{{ ucfirst(str_replace('_', ' ', $task->status)) }}</strong>
                    </p>
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
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit Task
                        </a>
                        
                        @if($task->status !== 'completed')
                            <form method="POST" action="{{ route('tasks.update', $task) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="title" value="{{ $task->title }}">
                                <input type="hidden" name="description" value="{{ $task->description }}">
                                <input type="hidden" name="priority" value="{{ $task->priority }}">
                                <input type="hidden" name="due_date" value="{{ $task->due_date }}">
                                <input type="hidden" name="category_id" value="{{ $task->category_id }}">
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-check-circle"></i> Mark Complete
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('tasks.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-plus-circle"></i> Create Similar Task
                        </a>
                        
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" 
                                    onclick="return confirm('Are you sure you want to delete this task? This action cannot be undone.')">
                                <i class="bi bi-trash"></i> Delete Task
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for enhanced styling -->
    <style>
        .btn-check:checked + .btn {
            transform: scale(1.05);
        }
        
        .progress {
            border-radius: 10px;
        }
        
        .progress-bar {
            border-radius: 10px;
            transition: width 0.3s ease;
        }
        
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
        
        .border-bottom:last-child {
            border-bottom: none !important;
        }
    </style>
</x-app-layout>
