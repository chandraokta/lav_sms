@extends('layouts.master')

@section('page_title', 'Manajemen Siswa')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h4 class="card-title mb-0"><i class="icon-user-circle mr-2"></i> Manajemen Siswa</h4>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Main Tabs Navigation -->
                    <ul class="nav nav-tabs nav-tabs-highlight mb-4">
                        <li class="nav-item">
                            <a href="#manajemen-siswa" class="nav-link active rounded-pill mr-2" data-toggle="tab">
                                <i class="icon-user-circle mr-2"></i> Manajemen Siswa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#input-siswa" class="nav-link rounded-pill" data-toggle="tab">
                                <i class="icon-user-circle mr-2"></i> Input Siswa
                            </a>
                        </li>
                    </ul>

                    <!-- Main Tabs Content -->
                    <div class="tab-content">
                        <!-- Tab 1: Manajemen Siswa (shows all students) -->
                        <div class="tab-pane fade show active" id="manajemen-siswa">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white header-elements-inline">
                                    <h5 class="card-title mb-0"><i class="icon-user-circle mr-2"></i> Daftar Seluruh Siswa</h5>
                                    <div class="header-elements">
                                        <div class="list-icons">
                                            <a class="list-icons-item text-white" data-action="collapse"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($all_students->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped datatable-button-html5-columns" id="students-table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center" width="5%">No</th>
                                                        <th>Nama Siswa</th>
                                                        <th class="text-center">NIS</th>
                                                        <th class="text-center">Kelas</th>
                                                        <th class="text-center">Bagian</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($all_students as $student)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        @php
                                                                            $hasValidPhoto = !empty($student->user->photo) && 
                                                                                           $student->user->photo !== Qs::getDefaultUserImage() && 
                                                                                           (filter_var($student->user->photo, FILTER_VALIDATE_URL) || 
                                                                                           (file_exists(public_path(str_replace(asset(''), '', $student->user->photo)))));
                                                                        @endphp
                                                                        @if($hasValidPhoto)
                                                                            <img src="{{ $student->user->photo }}" class="rounded-circle" width="32" height="32" alt="photo" onerror="this.onerror=null;this.closest('div').innerHTML='<div class=\'bg-primary rounded-circle d-flex align-items-center justify-content-center\' style=\'width: 32px; height: 32px;\'><i class=\'icon-user-circle text-white\'></i></div>';">
                                                                        @else
                                                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                                <i class="icon-user-circle text-white"></i>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        <span class="font-weight-semibold">{{ $student->user->name ?? 'N/A' }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">{{ $student->adm_no ?? 'N/A' }}</td>
                                                            <td class="text-center">
                                                                <span class="badge badge-primary">{{ ($student->my_class ? $student->my_class->name : 'N/A') ?? 'N/A' }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge badge-info">{{ ($student->section ? $student->section->name : 'N/A') ?? 'N/A' }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info text-center rounded-lg">
                                            <i class="icon-info-circle mr-2"></i> 
                                            <strong>Informasi:</strong> Tidak ada data siswa yang tersedia.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Input Siswa (contains nested tabs for input methods) -->
                        <div class="tab-pane fade" id="input-siswa">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white header-elements-inline">
                                    <h5 class="card-title mb-0"><i class="icon-user-plus mr-2"></i> Metode Input Siswa</h5>
                                    <div class="header-elements">
                                        <div class="list-icons">
                                            <a class="list-icons-item text-white" data-action="collapse"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Nested Tabs Navigation -->
                                    <ul class="nav nav-tabs nav-tabs-highlight mb-4">
                                        <li class="nav-item">
                                            <a href="#input-manual" class="nav-link active rounded-pill mr-2" data-toggle="tab">
                                                <i class="icon-user-plus mr-2"></i> Input Manual
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#input-csv" class="nav-link rounded-pill" data-toggle="tab">
                                                <i class="icon-file-upload mr-2"></i> Input dengan File CSV
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Nested Tabs Content -->
                                    <div class="tab-content">
                                        <!-- Nested Tab 1: Input Manual -->
                                        <div class="tab-pane fade show active" id="input-manual">
                                            <div class="row">
                                                <div class="col-lg-8 offset-lg-2">
                                                    <div class="alert alert-warning border-0 alert-dismissible rounded-lg">
                                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                                        <h5 class="alert-heading font-weight-bold"><i class="icon-exclamation-circle mr-2"></i> Input Manual Siswa</h5>
                                                        <p class="mb-0">Masukkan data siswa secara manual dengan mengisi form di bawah ini. Anda dapat memasukkan beberapa nama sekaligus dengan memisahkannya menggunakan baris baru.</p>
                                                    </div>

                                                    <div class="card border-warning shadow-sm">
                                                        <div class="card-header bg-warning text-white">
                                                            <h5 class="card-title mb-0"><i class="icon-user-plus mr-2"></i>Form Input Siswa Manual</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <form method="post" action="{{ route('students.import_manual') }}">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label class="font-weight-semibold">Nama Siswa <span class="text-danger">*</span></label>
                                                                    <textarea name="student_names" class="form-control" rows="8" placeholder="Masukkan nama siswa (satu nama per baris)&#10;Contoh:&#10;Ahmad Budi&#10;Siti Nurhaliza&#10;Budi Santoso&#10;Dewi Lestari" required></textarea>
                                                                    <small class="form-text text-muted">Masukkan satu nama siswa per baris. Maksimal 100 karakter per nama.</small>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="font-weight-semibold">Kelas <span class="text-danger">*</span></label>
                                                                    <select name="class_id" class="form-control select-search" required data-placeholder="Pilih Kelas">
                                                                        <option value=""></option>
                                                                        @foreach($my_classes as $class)
                                                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <small class="form-text text-muted">Pilih kelas untuk semua siswa yang akan diinput.</small>
                                                                </div>

                                                                <div class="text-center mt-4">
                                                                    <button type="submit" class="btn btn-warning btn-lg rounded-pill px-4">
                                                                        <i class="icon-user-plus mr-2"></i> Tambah Siswa
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Nested Tab 2: Input dengan File CSV -->
                                        <div class="tab-pane fade" id="input-csv">
                                            <div class="row">
                                                <div class="col-lg-8 offset-lg-2">
                                                    <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                                        <h5 class="alert-heading font-weight-bold"><i class="icon-info-circle mr-2"></i> Petunjuk Import CSV</h5>
                                                        <ul class="mb-0">
                                                            <li>Gunakan format CSV untuk mengimport data siswa secara massal</li>
                                                            <li>Template harus memiliki kolom: Nama (kolom lain akan diabaikan)</li>
                                                            <li>Masukkan satu nama siswa per baris dalam file CSV</li>
                                                            <li>Pilih kelas untuk semua siswa yang akan diimport</li>
                                                            <li>Simpan file dan upload menggunakan form di bawah</li>
                                                        </ul>
                                                    </div>

                                                    <div class="text-center mb-4">
                                                        <a href="{{ route('download_template_public') }}" class="btn btn-success btn-lg rounded-pill px-4">
                                                            <i class="icon-file-download mr-2"></i> Download Template CSV
                                                        </a>
                                                    </div>

                                                    <div class="card border-primary shadow-sm">
                                                        <div class="card-header bg-primary text-white">
                                                            <h5 class="card-title mb-0"><i class="icon-file-upload mr-2"></i>Upload File CSV</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <form method="post" enctype="multipart/form-data" action="{{ route('students.import') }}">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label class="font-weight-semibold">Pilih File CSV <span class="text-danger">*</span></label>
                                                                    <input required type="file" name="excel_file" class="form-control-file" accept=".csv">
                                                                    <small class="form-text text-muted">Hanya file CSV yang didukung. Maksimal ukuran file 2MB.</small>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="font-weight-semibold">Kelas <span class="text-danger">*</span></label>
                                                                    <select name="class_id" class="form-control select-search" required data-placeholder="Pilih Kelas">
                                                                        <option value=""></option>
                                                                        @foreach($my_classes as $class)
                                                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <small class="form-text text-muted">Pilih kelas untuk semua siswa dalam file CSV.</small>
                                                                </div>

                                                                <div class="text-center mt-4">
                                                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                                                                        <i class="icon-file-upload mr-2"></i> Import Siswa
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
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
    .icon-fallback {
        display: inline-block;
        width: 16px;
        height: 16px;
        background-color: currentColor;
        border-radius: 50%;
        position: relative;
    }
    .icon-fallback:before {
        content: "";
        position: absolute;
        top: 25%;
        left: 25%;
        width: 50%;
        height: 50%;
        background-color: white;
        border-radius: 50%;
    }
    .icon-fallback:after {
        content: "";
        position: absolute;
        top: 60%;
        left: 10%;
        width: 80%;
        height: 20%;
        background-color: white;
        border-radius: 2px;
    }
</style>
<script>
$(document).ready(function() {
    // Initialize DataTables for student table with destroy option to prevent reinitialization error
    if ($('#students-table').length > 0 && !$.fn.DataTable.isDataTable('#students-table')) {
        $('#students-table').DataTable({
            buttons: [
                { extend: 'copyHtml5', className: 'btn btn-light' },
                { extend: 'csvHtml5', className: 'btn btn-light' },
                { extend: 'excelHtml5', className: 'btn btn-light' },
                { extend: 'pdfHtml5', className: 'btn btn-light' },
                { extend: 'print', className: 'btn btn-light' }
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"B>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            responsive: true,
            pageLength: 25,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
            }
        });
    }
    
    // Handle tab shown event to reinitialize DataTable when needed
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href");
        if (target === '#manajemen-siswa') {
            if ($('#students-table').length > 0) {
                if (!$.fn.DataTable.isDataTable('#students-table')) {
                    $('#students-table').DataTable({
                        buttons: [
                            { extend: 'copyHtml5', className: 'btn btn-light' },
                            { extend: 'csvHtml5', className: 'btn btn-light' },
                            { extend: 'excelHtml5', className: 'btn btn-light' },
                            { extend: 'pdfHtml5', className: 'btn btn-light' },
                            { extend: 'print', className: 'btn btn-light' }
                        ],
                        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"B>>' +
                             '<"row"<"col-sm-12"tr>>' +
                             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                        responsive: true,
                        pageLength: 25,
                        language: {
                            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
                        }
                    });
                }
            }
        }
    });
    
    // Initialize select2 for better dropdowns
    if ($('.select-search').length > 0) {
        $('.select-search').select2({
            minimumResultsForSearch: Infinity
        });
    }
    
    // Fallback for icon loading issues
    $('.icon-user-circle').each(function() {
        if ($(this).css('font-family').indexOf('IcoMoon') === -1) {
            $(this).addClass('icon-fallback').html('');
        }
    });
});
</script>
@endsection