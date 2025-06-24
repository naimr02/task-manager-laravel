<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-dark">
                <i class="bi bi-folder-plus me-2"></i>Create New Category
            </h2>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Categories
            </a>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-folder-plus me-2"></i>Category Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        
                        <!-- Category Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                <i class="bi bi-tag me-1"></i>Category Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter category name (e.g., Work, Personal, Projects)"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Choose a descriptive name that helps organize your tasks.
                            </div>
                        </div>

                        <!-- Category Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-card-text me-1"></i>Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Briefly describe what this category is for (optional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-lightbulb"></i> Add context to help you and others understand this category's purpose.
                            </div>
                        </div>

                        <!-- Color Picker -->
                        <div class="mb-4">
                            <label for="color" class="form-label fw-bold">
                                <i class="bi bi-palette me-1"></i>Category Color <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="color" 
                                           class="form-control form-control-color @error('color') is-invalid @enderror" 
                                           id="color" 
                                           name="color" 
                                           value="{{ old('color', '#007bff') }}"
                                           title="Choose a color">
                                    @error('color')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted">Preview:</span>
                                        <div id="colorPreview" class="rounded-circle border" style="width: 30px; height: 30px; background-color: #007bff;"></div>
                                        <span id="colorValue" class="badge bg-secondary">#007bff</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-eye"></i> This color will be used to identify tasks in this category.
                            </div>
                        </div>

                        <!-- Quick Color Options -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-palette2 me-1"></i>Quick Color Options
                            </label>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-outline-secondary color-option" data-color="#007bff" style="background-color: #007bff; width: 40px; height: 40px; border-radius: 50%;"></button>
                                <button type="button" class="btn btn-outline-secondary color-option" data-color="#28a745" style="background-color: #28a745; width: 40px; height: 40px; border-radius: 50%;"></button>
                                <button type="button" class="btn btn-outline-secondary color-option" data-color="#dc3545" style="background-color: #dc3545; width: 40px; height: 40px; border-radius: 50%;"></button>
                                <button type="button" class="btn btn-outline-secondary color-option" data-color="#ffc107" style="background-color: #ffc107; width: 40px; height: 40px; border-radius: 50%;"></button>
                                <button type="button" class="btn btn-outline-secondary color-option" data-color="#17a2b8" style="background-color: #17a2b8; width: 40px; height: 40px; border-radius: 50%;"></button>
                                <button type="button" class="btn btn-outline-secondary color-option" data-color="#6f42c1" style="background-color: #6f42c1; width: 40px; height: 40px; border-radius: 50%;"></button>
                                <button type="button" class="btn btn-outline-secondary color-option" data-color="#fd7e14" style="background-color: #fd7e14; width: 40px; height: 40px; border-radius: 50%;"></button>
                                <button type="button" class="btn btn-outline-secondary color-option" data-color="#e83e8c" style="background-color: #e83e8c; width: 40px; height: 40px; border-radius: 50%;"></button>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-cursor"></i> Click any color above to quickly select it.
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <button type="submit" class="btn btn-primary btn-lg px-4">
                                        <i class="bi bi-check-circle me-2"></i>Create Category
                                    </button>
                                    
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                        <i class="bi bi-x-circle me-2"></i>Cancel
                                    </a>
                                    
                                    <button type="reset" class="btn btn-outline-info btn-lg px-4">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                                    </button>
                                </div>
                                
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-shield-check"></i> 
                                        Categories help organize your tasks and improve productivity.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for color picker functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorInput = document.getElementById('color');
            const colorPreview = document.getElementById('colorPreview');
            const colorValue = document.getElementById('colorValue');
            const colorOptions = document.querySelectorAll('.color-option');

            // Update preview when color input changes
            colorInput.addEventListener('input', function() {
                const color = this.value;
                colorPreview.style.backgroundColor = color;
                colorValue.textContent = color;
            });

            // Handle quick color option clicks
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const color = this.getAttribute('data-color');
                    colorInput.value = color;
                    colorPreview.style.backgroundColor = color;
                    colorValue.textContent = color;
                    
                    // Remove active class from all options
                    colorOptions.forEach(opt => opt.classList.remove('active'));
                    // Add active class to clicked option
                    this.classList.add('active');
                });
            });

            // Form validation
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('button[type="submit"]');
            
            form.addEventListener('input', function() {
                const name = document.getElementById('name').value.trim();
                const color = document.getElementById('color').value;
                
                if (name && color) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Create Category';
                } else {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>Please fill required fields';
                }
            });
        });
    </script>

    <style>
        .form-control:focus, .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .color-option:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }
        
        .color-option.active {
            border: 3px solid #000 !important;
            transform: scale(1.1);
        }
        
        .form-control-color {
            width: 100%;
            height: 45px;
        }
        
        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
        }
    </style>
</x-app-layout>
