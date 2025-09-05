@extends('layouts.master')
@section('page_title', 'Laporan Nilai Siswa - ' . $class->name)
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title font-weight-bold text-primary"><i class="icon-file-text2 mr-2"></i>Laporan Nilai Siswa - {{ $class->name }}</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="{{ route('laporan.rekap') }}" class="btn btn-secondary">
                    <i class="icon-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div>
                <form method="post" action="{{ route('laporan.student.download') }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-file-download mr-1"></i> Download CSV
                    </button>
                </form>
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="icon-printer mr-1"></i> Cetak Laporan
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable-button-html5-columns">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        @foreach($subjects as $subject)
                            <th>{{ $subject->name }}</th>
                        @endforeach
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->adm_no }}</td>
                            @foreach($subjects as $subject)
                                <td class="text-center">
                                    @php
                                        $studentMarks = $marks->get($student->id, collect());
                                        $subjectMark = $studentMarks->firstWhere('subject_id', $subject->id);
                                        echo $subjectMark ? $subjectMark->exm : '-';
                                    @endphp
                                </td>
                            @endforeach
                            <td class="text-center">
                                <a href="{{ route('laporan.print', $student->user_id) }}" 
                                   class="btn btn-sm btn-success rounded-pill" 
                                   title="Cetak Rapor">
                                    <i class="icon-printer"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="alert alert-info border-0 rounded-lg">
                    <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                    <ul class="mb-0">
                        <li>Klik ikon printer <i class="icon-printer"></i> untuk mencetak rapor individual siswa</li>
                        <li>Gunakan tombol "Cetak Laporan" di atas untuk mencetak seluruh laporan</li>
                        <li>Nilai yang kosong ditampilkan dengan tanda "-"</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection