@extends('layouts.master')

@section('page_title', 'Lembar Tabulasi Nilai')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h4 class="card-title mb-0"><i class="icon-books mr-2"></i> Lembar Tabulasi Nilai</h4>
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
                            <a href="#select-exam" class="nav-link active rounded-pill mr-2" data-toggle="tab">
                                <i class="icon-filter3 mr-2"></i> Pilih Ujian & Kelas
                            </a>
                        </li>
                        @if($selected)
                            <li class="nav-item">
                                <a href="#tabulation-sheet" class="nav-link rounded-pill" data-toggle="tab">
                                    <i class="icon-table2 mr-2"></i> Lembar Tabulasi
                                </a>
                            </li>
                        @endif
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="select-exam">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                                        <p class="mb-0">Pilih ujian dan kelas untuk melihat lembar tabulasi nilai. Pastikan data nilai sudah diinput sebelum melihat tabulasi.</p>
                                    </div>

                                    <div class="card border-primary shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0"><i class="icon-filter3 mr-2"></i>Form Pilih Ujian & Kelas</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ route('marks.tabulation_select') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exam_id" class="font-weight-semibold">Ujian: <span class="text-danger">*</span></label>
                                                            <select required id="exam_id" name="exam_id" class="form-control select-search" data-placeholder="Pilih Ujian">
                                                                <option value=""></option>
                                                                @foreach($exams as $exm)
                                                                    <option {{ ($selected && $exam_id == $exm->id) ? 'selected' : '' }} value="{{ $exm->id }}">{{ $exm->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <small class="form-text text-muted">Pilih ujian yang akan ditampilkan tabulasinya.</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="my_class_id" class="font-weight-semibold">Kelas: <span class="text-danger">*</span></label>
                                                            <select onchange="getClassSections(this.value)" required id="my_class_id" name="my_class_id" class="form-control select-search" data-placeholder="Pilih Kelas">
                                                                <option value=""></option>
                                                                @foreach($my_classes as $mc)
                                                                    <option {{ ($selected && $my_class_id == $mc->id) ? 'selected' : '' }} value="{{ $mc->id }}">{{ $mc->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <small class="form-text text-muted">Pilih kelas untuk tabulasi nilai.</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="section_id" class="font-weight-semibold">Bagian:</label>
                                                            <select id="section_id" name="section_id" class="form-control select-search" data-placeholder="Pilih Bagian">
                                                                <option value="">Semua Bagian</option>
                                                                @if($selected && $sections)
                                                                    @foreach($sections as $sec)
                                                                        <option {{ ($selected && $section_id == $sec->id) ? 'selected' : '' }} value="{{ $sec->id }}">{{ $sec->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <small class="form-text text-muted">Pilih bagian kelas (opsional).</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                                                        <i class="icon-filter3 mr-2"></i> Tampilkan Tabulasi
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($selected)
                            <div class="tab-pane fade" id="tabulation-sheet">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white header-elements-inline">
                                        <h5 class="card-title mb-0"><i class="icon-table2 mr-2"></i> Tabulasi Nilai - {{ $exam->name }} ({{ $class->name }})</h5>
                                        <div class="header-elements">
                                            <div class="list-icons">
                                                <a class="list-icons-item text-white" data-action="collapse"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if($students->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped datatable-button-html5-columns" id="tabulation-table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th class="text-center" width="5%">No</th>
                                                            <th>Nama Siswa</th>
                                                            <th class="text-center">NIS</th>
                                                            @foreach($subjects as $sub)
                                                                <th class="text-center">{{ $sub->slug }}</th>
                                                            @endforeach
                                                            <th class="text-center">Total</th>
                                                            <th class="text-center">Rata-rata</th>
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
                                                                @foreach($subjects as $sub)
                                                                    @php
                                                                        $mark = $marks->where('student_id', $s->user_id)->where('subject_id', $sub->id)->first();
                                                                    @endphp
                                                                    <td class="text-center">{{ $mark ? $mark->exm : 'N/A' }}</td>
                                                                @endforeach
                                                                <td class="text-center font-weight-bold">{{ $s->total_marks ?? 0 }}</td>
                                                                <td class="text-center font-weight-bold">{{ $s->avg_marks ?? 0 }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <div class="text-center mt-4">
                                                <a href="{{ route('marks.tabulation_print', [$exam_id, $my_class_id, $section_id]) }}" target="_blank" class="btn btn-primary btn-lg rounded-pill px-4">
                                                    <i class="icon-printer mr-2"></i> Cetak Tabulasi
                                                </a>
                                            </div>
                                        @else
                                            <div class="alert alert-info text-center rounded-lg">
                                                <i class="icon-info22 mr-2"></i> 
                                                <strong>Informasi:</strong> Tidak ada data nilai untuk ujian {{ $exam->name }} di kelas {{ $class->name }}.
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

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTables for tabulation table
    if ($('#tabulation-table').length > 0 && !$.fn.DataTable.isDataTable('#tabulation-table')) {
        $('#tabulation-table').DataTable({
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
    
    // Initialize select2 for better dropdowns
    if ($('.select-search').length > 0) {
        $('.select-search').select2({
            minimumResultsForSearch: Infinity
        });
    }
});

function getClassSections(classId) {
    if (classId !== '') {
        $.ajax({
            url: '{{ route('get_class_sections') }}/' + classId,
            type: 'GET',
            success: function(data) {
                $('#section_id').empty();
                $('#section_id').append('<option value="">Semua Bagian</option>');
                $.each(data, function(key, value) {
                    $('#section_id').append('<option value="' + key + '">' + value + '</option>');
                });
                $('#section_id').trigger('change');
            }
        });
    } else {
        $('#section_id').empty();
        $('#section_id').append('<option value="">Semua Bagian</option>');
    }
}
</script>
@endsection