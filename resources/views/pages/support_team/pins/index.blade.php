@extends('layouts.master')

@section('page_title', 'PIN Ujian')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h4 class="card-title mb-0"><i class="icon-key mr-2"></i> PIN Ujian</h4>
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
                            <a href="#valid-pins" class="nav-link active rounded-pill mr-2" data-toggle="tab">
                                <i class="icon-key mr-2"></i> PIN Valid
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#used-pins" class="nav-link rounded-pill" data-toggle="tab">
                                <i class="icon-key2 mr-2"></i> PIN Terpakai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#create-pins" class="nav-link rounded-pill" data-toggle="tab">
                                <i class="icon-plus2 mr-2"></i> Buat PIN
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="valid-pins">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                                        <p class="mb-0">Terdapat <strong>{{ $pin_count }}</strong> PIN valid yang belum digunakan.</p>
                                    </div>
                                </div>
                            </div>

                            @if($valid_pins->count() > 0)
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white header-elements-inline">
                                        <h5 class="card-title mb-0"><i class="icon-key mr-2"></i> Daftar PIN Valid</h5>
                                        <div class="header-elements">
                                            <div class="list-icons">
                                                <a class="list-icons-item text-white" data-action="collapse"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped datatable-button-html5-columns" id="valid-pins-table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center" width="5%">No</th>
                                                        <th>PIN</th>
                                                        <th class="text-center">Tanggal Dibuat</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($valid_pins->chunk(4) as $chunk)
                                                        @foreach($chunk as $pin)
                                                            <tr>
                                                                <td class="text-center">{{ $loop->parent->iteration * 4 + $loop->iteration }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="mr-3">
                                                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                                <i class="icon-key text-white"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <span class="font-weight-semibold">{{ $pin->pin_code }}</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">{{ $pin->created_at->format('d/m/Y H:i') }}</td>
                                                                <td class="text-center">
                                                                    <div class="list-icons">
                                                                        <div class="dropdown">
                                                                            <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown">
                                                                                <i class="icon-menu9"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a href="#" data-pin="{{ $pin->pin_code }}" class="dropdown-item copy-pin">
                                                                                    <i class="icon-copy"></i> Salin PIN
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info text-center rounded-lg">
                                    <i class="icon-info22 mr-2"></i> 
                                    <strong>Informasi:</strong> Tidak ada PIN valid yang tersedia.
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="used-pins">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                                        <p class="mb-0">Berikut adalah daftar PIN yang sudah digunakan.</p>
                                    </div>
                                </div>
                            </div>

                            @if($used_pins->count() > 0)
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white header-elements-inline">
                                        <h5 class="card-title mb-0"><i class="icon-key2 mr-2"></i> Daftar PIN Terpakai</h5>
                                        <div class="header-elements">
                                            <div class="list-icons">
                                                <a class="list-icons-item text-white" data-action="collapse"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped datatable-button-html5-columns" id="used-pins-table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center" width="5%">No</th>
                                                        <th>PIN</th>
                                                        <th class="text-center">Tanggal Digunakan</th>
                                                        <th class="text-center">Digunakan Oleh</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($used_pins as $pin)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                            <i class="icon-key2 text-white"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <span class="font-weight-semibold">{{ $pin->pin_code }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">{{ $pin->used_at ? $pin->used_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                                            <td class="text-center">{{ $pin->user ? $pin->user->name : 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info text-center rounded-lg">
                                    <i class="icon-info22 mr-2"></i> 
                                    <strong>Informasi:</strong> Tidak ada PIN yang sudah digunakan.
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="create-pins">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="alert alert-warning border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-warning mr-2"></i> Perhatian</h5>
                                        <p class="mb-0">Pastikan jumlah PIN yang akan dibuat sesuai dengan kebutuhan. PIN yang sudah dibuat tidak dapat dihapus.</p>
                                    </div>

                                    <div class="card border-warning shadow-sm">
                                        <div class="card-header bg-warning text-white">
                                            <h5 class="card-title mb-0"><i class="icon-plus2 mr-2"></i>Form Buat PIN Ujian</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ route('pins.store') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="pin_count" class="font-weight-semibold">Jumlah PIN <span class="text-danger">*</span></label>
                                                    <input type="number" id="pin_count" name="pin_count" class="form-control" min="1" max="1000" placeholder="Masukkan jumlah PIN" required>
                                                    <small class="form-text text-muted">Jumlah PIN yang akan dibuat (maksimal 1000 PIN sekaligus).</small>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-warning btn-lg rounded-pill px-4">
                                                        <i class="icon-plus2 mr-2"></i> Buat PIN
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
$(document).ready(function() {
    // Initialize DataTables for valid pins table
    if ($('#valid-pins-table').length > 0 && !$.fn.DataTable.isDataTable('#valid-pins-table')) {
        $('#valid-pins-table').DataTable({
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
    
    // Initialize DataTables for used pins table
    if ($('#used-pins-table').length > 0 && !$.fn.DataTable.isDataTable('#used-pins-table')) {
        $('#used-pins-table').DataTable({
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
    
    // Copy PIN functionality
    $('.copy-pin').on('click', function(e) {
        e.preventDefault();
        var pin = $(this).data('pin');
        navigator.clipboard.writeText(pin).then(function() {
            alert('PIN berhasil disalin ke clipboard: ' + pin);
        }).catch(function(err) {
            console.error('Gagal menyalin PIN: ', err);
            alert('Gagal menyalin PIN. Silakan salin manual: ' + pin);
        });
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