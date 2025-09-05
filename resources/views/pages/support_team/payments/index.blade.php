@extends('layouts.master')

@section('page_title', 'Kelola Pembayaran')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h4 class="card-title mb-0"><i class="icon-cash2 mr-2"></i> Kelola Pembayaran</h4>
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
                            <a href="#select-year" class="nav-link active rounded-pill mr-2" data-toggle="tab">
                                <i class="icon-calendar mr-2"></i> Pilih Tahun
                            </a>
                        </li>
                        @if($selected)
                            <li class="nav-item">
                                <a href="#select-class" class="nav-link rounded-pill" data-toggle="tab">
                                    <i class="icon-chalkboard mr-2"></i> Pilih Kelas
                                </a>
                            </li>
                            @if($selected && $classes)
                                <li class="nav-item">
                                    <a href="#manage-payments" class="nav-link rounded-pill" data-toggle="tab">
                                        <i class="icon-cash2 mr-2"></i> Kelola Pembayaran
                                    </a>
                                </li>
                            @endif
                        @endif
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="select-year">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                                        <p class="mb-0">Pilih tahun ajaran untuk mengelola pembayaran siswa. Pastikan tahun yang dipilih sudah tersedia dalam sistem.</p>
                                    </div>

                                    <div class="card border-primary shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0"><i class="icon-calendar mr-2"></i>Form Pilih Tahun Ajaran</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ route('payments.select_year') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="year" class="font-weight-semibold">Pilih Tahun <span class="text-danger">*</span></label>
                                                    <select data-placeholder="Pilih Tahun" required id="year" name="year" class="form-control select-search">
                                                        <option value=""></option>
                                                        @foreach($years as $yr)
                                                            <option {{ ($selected && $year == $yr->year) ? 'selected' : '' }} value="{{ $yr->year }}">{{ $yr->year }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-muted">Pilih tahun ajaran yang akan dikelola pembayarannya.</small>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                                                        <i class="icon-paperplane mr-2"></i> Lanjutkan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($selected)
                            <div class="tab-pane fade" id="select-class">
                                <div class="row">
                                    <div class="col-lg-8 offset-lg-2">
                                        <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                            <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                                            <p class="mb-0">Pilih kelas untuk mengelola pembayaran siswa pada tahun ajaran {{ $year }}.</p>
                                        </div>

                                        <div class="card border-primary shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="card-title mb-0"><i class="icon-chalkboard mr-2"></i>Form Pilih Kelas</h5>
                                            </div>
                                            <div class="card-body">
                                                <form method="post" action="{{ route('payments.select_class') }}">
                                                    @csrf
                                                    <input type="hidden" name="year" value="{{ $year }}">
                                                    <div class="form-group">
                                                        <label for="class_id" class="font-weight-semibold">Pilih Kelas <span class="text-danger">*</span></label>
                                                        <select required id="class_id" name="class_id" class="form-control select-search" data-placeholder="Pilih Kelas">
                                                            <option value=""></option>
                                                            @foreach($classes as $cl)
                                                                <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-muted">Pilih kelas yang akan dikelola pembayarannya.</small>
                                                    </div>

                                                    <div class="text-center mt-4">
                                                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                                                            <i class="icon-paperplane mr-2"></i> Lanjutkan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($selected && $classes)
                            <div class="tab-pane fade" id="manage-payments">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white header-elements-inline">
                                        <h5 class="card-title mb-0"><i class="icon-cash2 mr-2"></i> Pembayaran - Tahun {{ $year }}</h5>
                                        <div class="header-elements">
                                            <div class="list-icons">
                                                <a class="list-icons-item text-white" data-action="collapse"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                            <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi Kelas</h5>
                                            <p class="mb-0">Mengelola pembayaran untuk kelas <strong>{{ $class->name }}</strong> pada tahun ajaran {{ $year }}.</p>
                                        </div>

                                        @if($students->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped datatable-button-html5-columns" id="payments-table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th class="text-center" width="5%">No</th>
                                                            <th>Nama Siswa</th>
                                                            <th class="text-center">NIS</th>
                                                            <th class="text-center">Total Tagihan</th>
                                                            <th class="text-center">Total Bayar</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($students as $s)
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="mr-3">
                                                                            @if($s->user->photo && $s->user->photo != Qs::getDefaultUserImage())
                                                                                <img src="{{ $s->user->photo }}" class="rounded-circle" width="32" height="32" alt="photo">
                                                                            @else
                                                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                                    <i class="icon-user text-white"></i>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div>
                                                                            <span class="font-weight-semibold">{{ $s->user->name ?? 'N/A' }}</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">{{ $s->adm_no ?? 'N/A' }}</td>
                                                                <td class="text-center">Rp {{ number_format($s->total_bill, 0, ',', '.') }}</td>
                                                                <td class="text-center">Rp {{ number_format($s->total_paid, 0, ',', '.') }}</td>
                                                                <td class="text-center">
                                                                    @if($s->total_bill <= $s->total_paid)
                                                                        <span class="badge badge-success">Lunas</span>
                                                                    @else
                                                                        <span class="badge badge-warning">Belum Lunas</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="list-icons">
                                                                        <div class="dropdown">
                                                                            <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown">
                                                                                <i class="icon-menu9"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a href="{{ route('payments.invoice', [$s->id, $year]) }}" class="dropdown-item">
                                                                                    <i class="icon-file-text2"></i> Lihat Invoice
                                                                                </a>
                                                                                <a href="{{ route('payments.receipts', $s->id) }}" class="dropdown-item">
                                                                                    <i class="icon-receipt"></i> Lihat Bukti Bayar
                                                                                </a>
                                                                                <a href="#" data-id="{{ $s->id }}" data-name="{{ $s->user->name }}" data-toggle="modal" data-target="#pay-now-modal" class="dropdown-item pay-now">
                                                                                    <i class="icon-coins"></i> Bayar Sekarang
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
                                                <strong>Informasi:</strong> Tidak ada siswa dalam kelas {{ $class->name }}.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pay Now Modal -->
<div class="modal fade" id="pay-now-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="icon-coins mr-2"></i>Bayar Sekarang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda ingin melakukan pembayaran untuk <strong id="pay-student-name"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form method="post" id="pay-now-form" action="">
                    @csrf
                    <button type="submit" class="btn btn-primary">Bayar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTables for payments table
    if ($('#payments-table').length > 0 && !$.fn.DataTable.isDataTable('#payments-table')) {
        $('#payments-table').DataTable({
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
    
    // Set up pay now modal
    $('.pay-now').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#pay-student-name').text(name);
        $('#pay-now-form').attr('action', '{{ route('payments.pay_now', '') }}/' + id);
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