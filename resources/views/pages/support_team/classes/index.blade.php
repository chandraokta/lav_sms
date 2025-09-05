@extends('layouts.master')

@section('page_title', 'Kelola Kelas')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h4 class="card-title mb-0"><i class="icon-chalkboard mr-2"></i> Kelola Kelas</h4>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs nav-tabs-highlight mb-4">
                        <li class="nav-item">
                            <a href="#all-classes" class="nav-link active rounded-pill mr-2" data-toggle="tab">
                                <i class="icon-list mr-2"></i> Semua Kelas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#new-class" class="nav-link rounded-pill" data-toggle="tab">
                                <i class="icon-plus2 mr-2"></i> Tambah Kelas
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- All Classes Tab -->
                        <div class="tab-pane fade show active" id="all-classes">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white header-elements-inline">
                                    <h5 class="card-title mb-0"><i class="icon-list mr-2"></i> Daftar Semua Kelas</h5>
                                    <div class="header-elements">
                                        <div class="list-icons">
                                            <a class="list-icons-item text-white" data-action="collapse"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(isset($my_classes) && $my_classes->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped datatable-button-html5-columns" id="classes-table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center" width="5%">No</th>
                                                        <th>Nama Kelas</th>
                                                        <th class="text-center">Tipe Kelas</th>
                                                        <th class="text-center">Jumlah Bagian</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($my_classes as $class)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                            <i class="icon-chalkboard text-white"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <span class="font-weight-semibold">{{ $class->name }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge badge-primary">{{ $class->class_type->name ?? 'N/A' }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge badge-info">{{ $class->section->count() }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="list-icons">
                                                                    <div class="dropdown">
                                                                        <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown">
                                                                            <i class="icon-menu9"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a href="{{ route('classes.edit', Qs::hash($class->id)) }}" class="dropdown-item">
                                                                                <i class="icon-pencil7"></i> Edit
                                                                            </a>
                                                                            <a href="#" data-id="{{ Qs::hash($class->id) }}" data-name="{{ $class->name }}" data-toggle="modal" data-target="#delete-class-modal" class="dropdown-item delete-class">
                                                                                <i class="icon-trash"></i> Hapus
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info text-center rounded-lg">
                                            <i class="icon-info22 mr-2"></i> 
                                            <strong>Informasi:</strong> Tidak ada data kelas yang tersedia.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Add New Class Tab -->
                        <div class="tab-pane fade" id="new-class">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                                        <p class="mb-0">Isi form di bawah ini untuk menambahkan kelas baru. Pastikan semua field diisi dengan benar.</p>
                                    </div>

                                    <div class="card border-primary shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0"><i class="icon-plus2 mr-2"></i>Form Tambah Kelas</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ route('classes.store') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="font-weight-semibold">Nama Kelas <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama kelas" required>
                                                    <small class="form-text text-muted">Contoh: Kelas 10, Kelas 11, Kelas 12</small>
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-semibold">Tipe Kelas <span class="text-danger">*</span></label>
                                                    <select name="class_type_id" class="form-control select-search" required data-placeholder="Pilih Tipe Kelas">
                                                        <option value=""></option>
                                                        @foreach($class_types as $type)
                                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-muted">Pilih tipe kelas yang sesuai.</small>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                                                        <i class="icon-plus2 mr-2"></i> Tambah Kelas
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

<!-- Delete Modal -->
<div class="modal fade" id="delete-class-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="icon-trash mr-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kelas <strong id="delete-class-name"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form method="post" id="delete-class-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTables for classes table
    if ($('#classes-table').length > 0 && !$.fn.DataTable.isDataTable('#classes-table')) {
        $('#classes-table').DataTable({
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
    
    // Set up delete modal
    $('.delete-class').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#delete-class-name').text(name);
        $('#delete-class-form').attr('action', '{{ route('classes.destroy', '') }}/' + id);
    });
    
    // Initialize select2 for better dropdowns
    if ($('.select-search').length > 0) {
        $('.select-search').select2({
            minimumResultsForSearch: Infinity
        });
    }
});
</script>
@endsection