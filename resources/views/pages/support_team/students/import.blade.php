@extends('layouts.master')
@section('page_title', 'Import Students')
@section('content')
    <div class="card">
        <div class="card-header bg-white header-elements-inline">
            <h6 class="card-title">Import Students</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        <li class="nav-item">
                            <a href="#excel-import" class="nav-link active rounded-pill mr-1" data-toggle="tab">
                                <i class="icon-file-excel mr-2"></i> Import from Excel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#manual-import" class="nav-link rounded-pill" data-toggle="tab">
                                <i class="icon-pencil5 mr-2"></i> Manual Entry (Urgent)
                            </a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-4">
                        <!-- Excel Import Tab -->
                        <div class="tab-pane fade show active" id="excel-import">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Instructions</h5>
                                        <ul>
                                            <li>Download the CSV template file first</li>
                                            <li>Template contains one column: Name</li>
                                            <li>Enter one student name per line</li>
                                            <li>Select the class from the dropdown below</li>
                                            <li>Save the file and upload using the form below</li>
                                        </ul>
                                    </div>

                                    <div class="text-center mb-4">
                                        <a href="{{ route('download_template_public') }}" class="btn btn-success btn-lg">
                                            <i class="icon-file-excel mr-2"></i> Download CSV Template
                                        </a>
                                    </div>

                                    <div class="card border-primary border-2 rounded-lg">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0"><i class="icon-upload mr-2"></i>Upload Excel File</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" enctype="multipart/form-data" action="{{ route('students.import') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="font-weight-semibold">Select CSV File <span class="text-danger">*</span></label>
                                                    <input required type="file" name="excel_file" class="form-control-file" accept=".csv">
                                                    <small class="form-text text-muted">Only CSV files are supported</small>
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-semibold">Class <span class="text-danger">*</span></label>
                                                    <select name="class_id" class="form-control select-search" required>
                                                        <option value="">-- Select Class --</option>
                                                        @foreach($classes as $class)
                                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">
                                                        <i class="icon-upload mr-2"></i> Import Students
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Manual Import Tab -->
                        <div class="tab-pane fade" id="manual-import">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="alert alert-warning border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-warning mr-2"></i> Urgent Entry</h5>
                                        <p class="mb-0">Enter student names and assign them to classes quickly. Only basic information is required.</p>
                                    </div>

                                    <div class="card border-warning border-2 rounded-lg">
                                        <div class="card-header bg-warning text-white">
                                            <h5 class="card-title mb-0"><i class="icon-user-plus mr-2"></i>Quick Student Entry</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ route('students.import_manual') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="font-weight-semibold">Student Names <span class="text-danger">*</span></label>
                                                    <textarea name="student_names" class="form-control" rows="6" placeholder="Enter one student name per line&#10;Example:&#10;Ahmad Budi&#10;Siti Nurhaliza&#10;Budi Santoso" required></textarea>
                                                    <small class="form-text text-muted">Enter one student name per line</small>
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-semibold">Class <span class="text-danger">*</span></label>
                                                    <select name="class_id" class="form-control select-search" required>
                                                        <option value="">-- Select Class --</option>
                                                        @foreach($classes as $class)
                                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-warning btn-lg px-5 rounded-pill">
                                                        <i class="icon-user-plus mr-2"></i> Add Students
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
@endsection