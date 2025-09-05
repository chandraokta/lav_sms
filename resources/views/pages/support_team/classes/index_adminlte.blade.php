@extends('layouts.master')
@section('page_title', 'Manage Classes')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chalkboard mr-2"></i>
                        Manage Classes
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs" id="classesTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="all-classes-tab" data-toggle="tab" href="#all-classes" role="tab">
                                <i class="fas fa-list mr-1"></i> All Classes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="new-class-tab" data-toggle="tab" href="#new-class" role="tab">
                                <i class="fas fa-plus-circle mr-1"></i> Create New Class
                            </a>
                        </li>
                        @if(Qs::userIsTeamSA() || Qs::userIsTeacher())
                        <li class="nav-item">
                            <a href="/lav_sms/public/students/create" class="nav-link">
                                <i class="fas fa-user-plus mr-1"></i> Add Student
                            </a>
                        </li>
                        @endif
                    </ul>
                    
                    <!-- Tab Content -->
                    <div class="tab-content pt-3" id="classesTabContent">
                        <!-- All Classes Tab -->
                        <div class="tab-pane fade show active" id="all-classes" role="tabpanel">
                            @if(Qs::userIsSuperAdmin() || Qs::userIsTeacher())
                            <form method="post" action="{{ route('classes.bulk_destroy') }}" onsubmit="return confirm('Are you sure you want to delete selected classes? This action cannot be undone.')">
                                @csrf
                                @method('delete')
                                
                                <!-- Bulk Actions -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="card card-outline card-info">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="select-all">
                                                        <label class="custom-control-label font-weight-bold" for="select-all">Select All Classes</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-danger" id="bulk-delete-btn" disabled>
                                                        <i class="fas fa-trash-alt mr-1"></i> Delete Selected
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Classes Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped" id="classesTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="width: 40px;" class="text-center">
                                                    <input type="checkbox" id="select-all-header" class="custom-control-input">
                                                </th>
                                                <th style="width: 50px;">#</th>
                                                <th>Class Name</th>
                                                <th style="width: 150px;">Class Type</th>
                                                <th style="width: 120px;" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($my_classes as $c)
                                            <tr class="class-row" data-id="{{ $c->id }}">
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input class-checkbox" 
                                                               id="class-{{ $c->id }}" name="selected_classes[]" 
                                                               value="{{ $c->id }}">
                                                        <label class="custom-control-label" for="class-{{ $c->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="font-weight-bold">{{ $loop->iteration }}</td>
                                                <td class="font-weight-semibold">{{ $c->name }}</td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $c->class_type->name }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        @if(Qs::userIsTeamSA() || Qs::userIsTeacher())
                                                            <a href="{{ route('classes.edit', $c->id) }}" 
                                                               class="btn btn-sm btn-primary" title="Edit Class">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endif
                                                        
                                                        @if(Qs::userIsSuperAdmin() || Qs::userIsTeacher())
                                                            <button type="button" class="btn btn-sm btn-danger" 
                                                                    onclick="confirmDelete({{ $c->id }})" title="Delete Class">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            <form method="post" id="item-delete-{{ $c->id }}" 
                                                                  action="{{ route('classes.destroy', $c->id) }}" class="d-none">
                                                                @csrf 
                                                                @method('delete')
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            @else
                            <!-- Read-only view for non-admin users -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Class Name</th>
                                            <th style="width: 150px;">Class Type</th>
                                            <th style="width: 80px;" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($my_classes as $c)
                                        <tr>
                                            <td class="font-weight-bold">{{ $loop->iteration }}</td>
                                            <td class="font-weight-semibold">{{ $c->name }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $c->class_type->name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    @if(Qs::userIsTeamSA() || Qs::userIsTeacher())
                                                        <a href="{{ route('classes.edit', $c->id) }}" 
                                                           class="btn btn-sm btn-primary" title="Edit Class">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Create New Class Tab -->
                        <div class="tab-pane fade" id="new-class" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-plus-square mr-2"></i>
                                                Create New Class
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-info">
                                                <h5><i class="icon fas fa-info-circle"></i> Information</h5>
                                                <p>When a class is created, a Section will be automatically created for the class. You can edit it or add more sections to the class at <a target="_blank" href="{{ route('sections.index') }}">Manage Sections</a>.</p>
                                            </div>
                                            
                                            <form class="ajax-store" method="post" action="{{ route('classes.store') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="class-name" class="font-weight-semibold">
                                                        Class Name <span class="text-danger">*</span>
                                                    </label>
                                                    <input name="name" id="class-name" value="{{ old('name') }}" 
                                                           required type="text" class="form-control" 
                                                           placeholder="Enter class name">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="class_type_id" class="font-weight-semibold">
                                                        Class Type <span class="text-danger">*</span>
                                                    </label>
                                                    <select required class="form-control select2" name="class_type_id" id="class_type_id">
                                                        <option value="">-- Select Class Type --</option>
                                                        @foreach($class_types as $ct)
                                                            <option {{ old('class_type_id') == $ct->id ? 'selected' : '' }} 
                                                                    value="{{ $ct->id }}">{{ $ct->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group text-center">
                                                    <button id="ajax-btn" type="submit" class="btn btn-primary btn-lg">
                                                        <i class="fas fa-paper-plane mr-1"></i> Create Class
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    
    // Initialize DataTable
    $('#classesTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });
    
    // Select all checkboxes
    document.getElementById('select-all-header').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.class-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            // Add visual feedback
            const row = checkbox.closest('.class-row');
            if (row) {
                if (this.checked) {
                    row.classList.add('table-active');
                } else {
                    row.classList.remove('table-active');
                }
            }
        });
        updateBulkDeleteButton();
    });
    
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.class-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            // Add visual feedback
            const row = checkbox.closest('.class-row');
            if (row) {
                if (this.checked) {
                    row.classList.add('table-active');
                } else {
                    row.classList.remove('table-active');
                }
            }
        });
        updateBulkDeleteButton();
    });
    
    // Update bulk delete button state
    document.querySelectorAll('.class-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Add visual feedback
            const row = this.closest('.class-row');
            if (row) {
                if (this.checked) {
                    row.classList.add('table-active');
                } else {
                    row.classList.remove('table-active');
                }
            }
            updateBulkDeleteButton();
        });
    });
    
    // Handle bulk delete button click
    document.getElementById('bulk-delete-btn').addEventListener('click', function(e) {
        e.preventDefault();
        const checkboxes = document.querySelectorAll('.class-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one class to delete.');
            return;
        }
        
        if (confirm('Are you sure you want to delete ' + checkboxes.length + ' selected class(es)? This action cannot be undone.')) {
            // Submit the form
            this.closest('form').submit();
        }
    });
    
    function updateBulkDeleteButton() {
        const checkboxes = document.querySelectorAll('.class-checkbox:checked');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        bulkDeleteBtn.disabled = checkboxes.length === 0;
        
        // Add animation effect
        if (checkboxes.length > 0) {
            bulkDeleteBtn.classList.add('btn-animated');
            setTimeout(() => {
                bulkDeleteBtn.classList.remove('btn-animated');
            }, 300);
        }
    }
    
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this class? This action cannot be undone.')) {
            document.getElementById('item-delete-' + id).submit();
        }
    }
</script>
@endsection