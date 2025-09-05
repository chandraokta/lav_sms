@extends('layouts.master')

@section('page_title', 'Kelola Tahun Ajaran')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h4 class="card-title mb-0"><i class="icon-calendar mr-2"></i> Kelola Tahun Ajaran</h4>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-highlight mb-4">
                        <li class="nav-item">
                            <a href="#all-sessions" class="nav-link active rounded-pill mr-2" data-toggle="tab">
                                <i class="icon-list mr-2"></i> Semua Tahun Ajaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#new-session" class="nav-link rounded-pill" data-toggle="tab">
                                <i class="icon-plus2 mr-2"></i> Tambah Tahun Ajaran
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all-sessions">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white header-elements-inline">
                                    <h5 class="card-title mb-0"><i class="icon-list mr-2"></i> Daftar Tahun Ajaran</h5>
                                    <div class="header-elements">
                                        <div class="list-icons">
                                            <a class="list-icons-item text-white" data-action="collapse"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(isset($sessions) && $sessions->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped datatable-button-html5-columns" id="sessions-table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center" width="5%">No</th>
                                                        <th>Nama Tahun Ajaran</th>
                                                        <th class="text-center">Tanggal Mulai</th>
                                                        <th class="text-center">Tanggal Selesai</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($sessions as $session)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                            <i class="icon-calendar text-white"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <span class="font-weight-semibold">{{ $session->name }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">{{ $session->start_date ?? 'N/A' }}</td>
                                                            <td class="text-center">{{ $session->end_date ?? 'N/A' }}</td>
                                                            <td class="text-center">
                                                                @if($session->active)
                                                                    <span class="badge badge-success">Aktif</span>
                                                                @else
                                                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="list-icons">
                                                                    <div class="dropdown">
                                                                        <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown">
                                                                            <i class="icon-menu9"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a href="{{ route('sessions.edit', Qs::hash($session->id)) }}" class="dropdown-item">
                                                                                <i class="icon-pencil7"></i> Edit
                                                                            </a>
                                                                            <a href="#" data-id="{{ Qs::hash($session->id) }}" data-name="{{ $session->name }}" data-toggle="modal" data-target="#delete-session-modal" class="dropdown-item delete-session">
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
                                            <strong>Informasi:</strong> Tidak ada tahun ajaran yang tersedia.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="new-session">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                                        <p class="mb-0">Isi form di bawah ini untuk menambahkan tahun ajaran baru. Pastikan semua field diisi dengan benar.</p>
                                    </div>

                                    <div class="card border-primary shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0"><i class="icon-plus2 mr-2"></i>Form Tambah Tahun Ajaran</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ route('sessions.store') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="font-weight-semibold">Nama Tahun Ajaran <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama tahun ajaran" required>
                                                    <small class="form-text text-muted">Contoh: Tahun Ajaran 2023/2024</small>
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-semibold">Tanggal Mulai</label>
                                                    <input type="date" name="start_date" class="form-control">
                                                    <small class="form-text text-muted">Tanggal mulai tahun ajaran (opsional).</small>
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-semibold">Tanggal Selesai</label>
                                                    <input type="date" name="end_date" class="form-control">
                                                    <small class="form-text text-muted">Tanggal selesai tahun ajaran (opsional).</small>
                                                </div>

                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="active" class="form-check-input">
                                                            Tandai sebagai tahun ajaran aktif
                                                        </label>
                                                    </div>
                                                    <small class="form-text text-muted">Hanya satu tahun ajaran yang bisa aktif pada satu waktu.</small>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                                                        <i class="icon-plus2 mr-2"></i> Tambah Tahun Ajaran
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
<div class="modal fade" id="delete-session-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="icon-trash mr-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus tahun ajaran <strong id="delete-session-name"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form method="post" id="delete-session-form">
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
    // Initialize DataTables for sessions table
    if ($('#sessions-table').length > 0 && !$.fn.DataTable.isDataTable('#sessions-table')) {
        $('#sessions-table').DataTable({
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
    $('.delete-session').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#delete-session-name').text(name);
        $('#delete-session-form').attr('action', '{{ route('sessions.destroy', '') }}/' + id);
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