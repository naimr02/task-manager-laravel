<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-dark">
                <i class="bi bi-pencil me-2"></i>Edit Task
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-eye"></i> View Task
                </a>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Tasks
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-card-checklist me-2"></i>Update Task Details
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Task Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="bi bi-type me-1"></i>Task Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $task->title) }}" 
                                   placeholder="Enter a descriptive task title"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Choose a clear, specific title that describes what needs to be done.
                            </div>
                        </div>

                        <!-- Task Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-card-text me-1"></i>Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Provide detailed information about this task (optional)">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-lightbulb"></i> Add context, requirements, or notes to help you complete this task.
                            </div>
                        </div>

                        <!-- Status and Priority Row -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">
                                    <i class="bi bi-flag me-1"></i>Task Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>
                                        <i class="bi bi-circle"></i> Pending
                                    </option>
                                    <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>
                                        <i class="bi bi-play-circle"></i> In Progress
                                    </option>
                                    <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>
                                        <i class="bi bi-check-circle"></i> Completed
                                    </option>
                                    <option value="cancelled" {{ old('status', $task->status) === 'cancelled' ? 'selected' : '' }}>
                                        <i class="bi bi-x-circle"></i> Cancelled
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="priority" class="form-label fw-bold">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Priority Level <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" 
                                        name="priority" 
                                        required>
                                    <option value="">Select Priority</option>
                                    <option value="low" class="text-secondary" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>
                                        🟢 Low Priority
                                    </option>
                                    <option value="medium" class="text-info" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>
                                        🔵 Medium Priority
                                    </option>
                                    <option value="high" class="text-warning" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>
                                        🟡 High Priority
                                    </option>
                                    <option value="urgent" class="text-danger" {{ old('priority', $task->priority) === 'urgent' ? 'selected' : '' }}>
                                        🔴 Urgent Priority
                                    </option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Due Date and Category Row -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="due_date" class="form-label fw-bold">
                                    <i class="bi bi-calendar-event me-1"></i>Due Date & Time
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('due_date') is-invalid @enderror" 
                                       id="due_date" 
                                       name="due_date" 
                                       value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '') }}">
                                @error('due_date')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-clock"></i> Set a deadline to help prioritize your work.
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-bold">
                                    <i class="bi bi-folder me-1"></i>Category
                                </label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" 
                                        name="category_id">
                                    <option value="">No Category</option>
                                    @forelse($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}
                                                data-color="{{ $category->color }}">
                                            {{ $category->name }}
                                        </option>
                                    @empty
                                        <option value="" disabled>No categories available</option>
                                    @endforelse
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-tag"></i> Organize your tasks by grouping them into categories.
                                    @if($categories->isEmpty())
                                        <a href="{{ route('categories.create') }}" class="text-decoration-none">
                                            Create your first category
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Current Task Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="card-title text-muted mb-3">
                                            <i class="bi bi-info-circle me-1"></i>Current Task Information
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <small class="text-muted d-block">Created On</small>
                                                <strong>{{ $task->created_at->format('M d, Y g:i A') }}</strong>
                                            </div>
                                            <div class="col-md-3">
                                                <small class="text-muted d-block">Last Updated</small>
                                                <strong>{{ $task->updated_at->format('M d, Y g:i A') }}</strong>
                                            </div>
                                            <div class="col-md-3">
                                                <small class="text-muted d-block">Current Status</small>
                                                <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'primary' : 'secondary') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </div>
                                            <div class="col-md-3">
                                                <small class="text-muted d-block">Current Priority</small>
                                                <span class="badge bg-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning text-dark' : 'secondary') }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-0 bg-white">
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                                <i class="bi bi-check-circle me-2"></i>Update Task
                                            </button>
                                            
                                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary btn-lg px-4">
                                                <i class="bi bi-x-circle me-2"></i>Cancel Changes
                                            </a>
                                            
                                            <button type="button" class="btn btn-outline-info btn-lg px-4" onclick="resetForm()">
                                                <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                                            </button>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="bi bi-shield-check"></i> 
                                                Your changes will be saved securely and can be reverted if needed.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Task Modal -->
    <div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteTaskModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>Delete Task
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="bi bi-trash3 text-danger" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Are you sure?</h4>
                        <p class="text-muted">
                            You are about to delete the task "<strong>{{ $task->title }}</strong>". 
                            This action cannot be undone and all task data will be permanently removed.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash3"></i> Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Floating Button -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
        <div class="dropdown dropup">
            <button class="btn btn-primary rounded-circle btn-lg shadow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">Quick Actions</h6></li>
                <li><a class="dropdown-item" href="{{ route('tasks.show', $task) }}">
                    <i class="bi bi-eye"></i> View Task
                </a></li>
                <li><a class="dropdown-item" href="{{ route('tasks.create') }}">
                    <i class="bi bi-plus-circle"></i> Create New Task
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteTaskModal">
                    <i class="bi bi-trash"></i> Delete Task
                </a></li>
            </ul>
        </div>
    </div>

    <!-- Custom JavaScript and CSS -->
    <script>
        // Form reset functionality
        function resetForm() {
            if (confirm('Are you sure you want to reset all changes? This will restore the original task values.')) {
                document.querySelector('form').reset();
                // Restore original values
                document.getElementById('title').value = '{{ $task->title }}';
                document.getElementById('description').value = '{{ $task->description }}';
                document.getElementById('status').value = '{{ $task->status }}';
                document.getElementById('priority').value = '{{ $task->priority }}';
                document.getElementById('due_date').value = '{{ $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '' }}';
                document.getElementById('category_id').value = '{{ $task->category_id }}';
            }
        }

        // Form validation enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('button[type="submit"]');
            
            form.addEventListener('input', function() {
                const title = document.getElementById('title').value.trim();
                const status = document.getElementById('status').value;
                const priority = document.getElementById('priority').value;
                
                if (title && status && priority) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Update Task';
                } else {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>Please fill required fields';
                }
            });

            // Category color preview
            const categorySelect = document.getElementById('category_id');
            categorySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const color = selectedOption.getAttribute('data-color');
                if (color) {
                    this.style.borderLeft = `4px solid ${color}`;
                } else {
                    this.style.borderLeft = '';
                }
            });

            // Initialize category color on load
            const initialCategory = categorySelect.options[categorySelect.selectedIndex];
            if (initialCategory && initialCategory.getAttribute('data-color')) {
                categorySelect.style.borderLeft = `4px solid ${initialCategory.getAttribute('data-color')}`;
            }
        });

        // Auto-save functionality (optional)
        let autoSaveTimer;
        document.querySelectorAll('input, textarea, select').forEach(element => {
            element.addEventListener('input', function() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(function() {
                    // Auto-save logic can be implemented here
                    console.log('Auto-save triggered');
                }, 5000); // Save after 5 seconds of inactivity
            });
        });
    </script>

    <style>
        .form-control:focus, .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
        }
        
        .card {
            transition: all 0.3s ease;
        }
        
        .floating-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .form-label {
            margin-bottom: 0.75rem;
        }
        
        .invalid-feedback {
            display: block;
        }
        
        .badge {
            font-size: 0.75em;
            padding: 0.5em 0.75em;
        }
        
        @media (max-width: 768px) {
            .btn-lg {
                padding: 0.5rem 1rem;
                font-size: 1rem;
            }
            
            .d-flex.gap-3 {
                gap: 1rem !important;
            }
        }
    </style>
</x-app-layout>
