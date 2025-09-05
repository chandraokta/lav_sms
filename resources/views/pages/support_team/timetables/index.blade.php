@extends('layouts.master')

@section('page_title', 'Kelola Jadwal Pelajaran')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h4 class="card-title mb-0"><i class="icon-table2 mr-2"></i> Kelola Jadwal Pelajaran</h4>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-highlight mb-4">
                        @if(Qs::userIsTeamSA())
                        <li class="nav-item">
                            <a href="#add-tt" class="nav-link active rounded-pill mr-2" data-toggle="tab">
                                <i class="icon-plus2 mr-2"></i> Buat Jadwal
                            </a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle rounded-pill" data-toggle="dropdown">
                                <i class="icon-table2 mr-2"></i> Tampilkan Jadwal
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach($my_classes as $mc)
                                    <a href="#ttr{{ $mc->id }}" class="dropdown-item" data-toggle="tab">{{ $mc->name }}</a>
                                @endforeach
                            </div>
                        </li>
                    </ul>

                    <div class="tab-content">
                        @if(Qs::userIsTeamSA())
                        <div class="tab-pane fade show active" id="add-tt">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                                        <p class="mb-0">Gunakan form di bawah ini untuk membuat jadwal pelajaran baru. Pastikan semua informasi diisi dengan benar.</p>
                                    </div>

                                    <div class="card border-primary shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0"><i class="icon-plus2 mr-2"></i>Form Buat Jadwal Pelajaran</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ route('tt.store') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="name" class="font-weight-semibold">Nama Jadwal <span class="text-danger">*</span></label>
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama jadwal" required>
                                                    <small class="form-text text-muted">Contoh: Jadwal Pelajaran Semester 1, Jadwal Ujian Tengah Semester</small>
                                                </div>

                                                <div class="form-group">
                                                    <label for="my_class_id" class="font-weight-semibold">Kelas <span class="text-danger">*</span></label>
                                                    <select id="my_class_id" name="my_class_id" class="form-control select-search" required data-placeholder="Pilih Kelas">
                                                        <option value=""></option>
                                                        @foreach($my_classes as $mc)
                                                            <option value="{{ $mc->id }}">{{ $mc->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-muted">Pilih kelas untuk jadwal ini.</small>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exam_id" class="font-weight-semibold">Ujian (Opsional)</label>
                                                    <select id="exam_id" name="exam_id" class="form-control select-search" data-placeholder="Pilih Ujian">
                                                        <option value=""></option>
                                                        @foreach($exams as $exam)
                                                            <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-muted">Pilih ujian jika jadwal ini untuk ujian.</small>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                                                        <i class="icon-plus2 mr-2"></i> Buat Jadwal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @foreach($my_classes as $mc)
                            <div class="tab-pane fade" id="ttr{{ $mc->id }}">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white header-elements-inline">
                                        <h5 class="card-title mb-0"><i class="icon-table2 mr-2"></i> Jadwal Pelajaran - {{ $mc->name }}</h5>
                                        <div class="header-elements">
                                            <div class="list-icons">
                                                <a class="list-icons-item text-white" data-action="collapse"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $ttr = $tt_records->where('my_class_id', $mc->id)->first();
                                        @endphp
                                        
                                        @if($ttr)
                                            <div class="alert alert-success border-0 alert-dismissible rounded-lg">
                                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                                <h5 class="alert-heading font-weight-bold"><i class="icon-check mr-2"></i> Jadwal Tersedia</h5>
                                                <p class="mb-0">Jadwal pelajaran untuk kelas <strong>{{ $mc->name }}</strong> sudah dibuat.</p>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th class="text-center">Hari</th>
                                                            <th class="text-center">Waktu</th>
                                                            <th class="text-center">Mata Pelajaran</th>
                                                            <th class="text-center">Guru</th>
                                                            @if(Qs::userIsTeamSA())
                                                                <th class="text-center">Aksi</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($ttr->time_slots as $ts)
                                                            <tr>
                                                                <td class="text-center">{{ $ts->day }}</td>
                                                                <td class="text-center">{{ $ts->time_from }} - {{ $ts->time_to }}</td>
                                                                <td class="text-center">{{ $ts->subject->name ?? 'N/A' }}</td>
                                                                <td class="text-center">{{ $ts->teacher->name ?? 'N/A' }}</td>
                                                                @if(Qs::userIsTeamSA())
                                                                    <td class="text-center">
                                                                        <div class="list-icons">
                                                                            <div class="dropdown">
                                                                                <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown">
                                                                                    <i class="icon-menu9"></i>
                                                                                </a>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    <a href="{{ route('ttr.edit', $ts->id) }}" class="dropdown-item">
                                                                                        <i class="icon-pencil7"></i> Edit
                                                                                    </a>
                                                                                    <a href="#" data-id="{{ $ts->id }}" data-toggle="modal" data-target="#delete-tt-modal" class="dropdown-item delete-tt">
                                                                                        <i class="icon-trash"></i> Hapus
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            @if(Qs::userIsTeamSA())
                                                <div class="text-center mt-4">
                                                    <a href="{{ route('ttr.manage', $ttr->id) }}" class="btn btn-primary btn-lg rounded-pill px-4">
                                                        <i class="icon-pencil7 mr-2"></i> Kelola Jadwal
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-info text-center rounded-lg">
                                                <i class="icon-info22 mr-2"></i> 
                                                <strong>Informasi:</strong> Jadwal pelajaran untuk kelas {{ $mc->name }} belum dibuat.
                                                @if(Qs::userIsTeamSA())
                                                    <br><a href="#add-tt" data-toggle="tab">Klik di sini untuk membuat jadwal</a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete-tt-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="icon-trash mr-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus jadwal ini?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form method="post" id="delete-tt-form">
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
    // Set up delete modal
    $('.delete-tt').on('click', function() {
        var id = $(this).data('id');
        $('#delete-tt-form').attr('action', '{{ route('ts.destroy', '') }}/' + id);
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