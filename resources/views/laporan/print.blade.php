@extends('layouts.master')
@section('page_title', 'Cetak Rapor Siswa')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-file-text2 mr-2"></i> Cetak Rapor Siswa</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('laporan.rekap') }}" class="btn btn-secondary">
                        <i class="icon-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                <div>
                    <a href="{{ route('laporan.print.download', $student->user_id) }}" class="btn btn-success">
                        <i class="icon-file-download mr-1"></i> Download CSV
                    </a>
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="icon-printer mr-1"></i> Cetak Rapor
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <h3>RAPOR SISWA</h3>
                        <h4>SEKOLAH MENENGAH PERTAMA</h4>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td>Nama Siswa</td>
                            <td>:</td>
                            <td>{{ $student->user->name }}</td>
                        </tr>
                        <tr>
                            <td>NIS</td>
                            <td>:</td>
                            <td>{{ $student->adm_no }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td>Kelas</td>
                            <td>:</td>
                            <td>{{ $student->my_class->name }}</td>
                        </tr>
                        <tr>
                            <td>Tahun Ajaran</td>
                            <td>:</td>
                            <td>{{ Qs::getCurrentSession() }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h5>A. Nilai Akademik</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                @foreach($marks as $exam_id => $examMarks)
                                <th>{{ $examMarks->first()->exam->name }}</th>
                                @endforeach
                                <th>Rata-rata</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($marks->first() as $mark)
                            <tr>
                                <td>{{ $mark->subject->name }}</td>
                                @foreach($marks as $exam_id => $examMarks)
                                    @php
                                        $subjectMark = $examMarks->where('subject_id', $mark->subject_id)->first();
                                    @endphp
                                    <td>{{ $subjectMark ? $subjectMark->exm : '-' }}</td>
                                @endforeach
                                <td>
                                    @php
                                        $subjectMarks = collect();
                                        foreach($marks as $exam_id => $examMarks) {
                                            $subjectMark = $examMarks->where('subject_id', $mark->subject_id)->first();
                                            if($subjectMark) {
                                                $subjectMarks->push($subjectMark->exm);
                                            }
                                        }
                                        $average = $subjectMarks->count() > 0 ? round($subjectMarks->avg(), 2) : 0;
                                    @endphp
                                    {{ $subjectMarks->count() > 0 ? $average : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>B. Kehadiran</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hadir</th>
                                <th>Sakit</th>
                                <th>Izin</th>
                                <th>Alpa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @php
                                        $hadir = $attendances->where('status', 'H')->count();
                                    @endphp
                                    {{ $hadir }}
                                </td>
                                <td>
                                    @php
                                        $sakit = $attendances->where('status', 'S')->count();
                                    @endphp
                                    {{ $sakit }}
                                </td>
                                <td>
                                    @php
                                        $izin = $attendances->where('status', 'I')->count();
                                    @endphp
                                    {{ $izin }}
                                </td>
                                <td>
                                    @php
                                        $alpa = $attendances->where('status', 'A')->count();
                                    @endphp
                                    {{ $alpa }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-6 text-center">
                    <p>Orang Tua/Wali</p>
                    <br><br><br>
                    <p>_______________________</p>
                </div>
                <div class="col-md-6 text-center">
                    <p>Guru Kelas</p>
                    <br><br><br>
                    <p>_______________________</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .card-header, .btn, .sidebar {
                display: none;
            }
            .card {
                box-shadow: none;
                border: none;
            }
        }
    </style>
@endsection