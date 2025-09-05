@extends('layouts.master')
@section('page_title', 'Absensi per Kelas')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-calendar3 mr-2"></i> Absensi per Kelas</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-group mb-0">
                            <label class="col-form-label font-weight-bold">Kelas: {{ $class->name }}</label>
                        </div>
                        <div>
                            <a href="{{ route('absensi.class.export', $class->id) }}" class="btn btn-success">
                                <i class="icon-file-download mr-1"></i> Export CSV
                            </a>
                            <a href="{{ route('absensi.rekap') }}" class="btn btn-secondary">
                                <i class="icon-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
                    
                    @if($attendances->count() > 0)
                        @foreach($attendances as $date => $attendanceGroup)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Tanggal: {{ $date }}</h6>
                                    <div class="header-elements">
                                        <a href="{{ route('absensi.edit', ['class_id' => $class->id, 'date' => $date]) }}" class="btn btn-primary btn-sm">Edit</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Siswa</th>
                                                    <th>NIS</th>
                                                    <th>Status Kehadiran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($attendanceGroup as $attendance)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $attendance->student->name }}</td>
                                                        <td>{{ $attendance->student->student_record->adm_no ?? 'N/A' }}</td>
                                                        <td>
                                                            @if($attendance->status == 'H')
                                                                Hadir (H)
                                                            @elseif($attendance->status == 'S')
                                                                Sakit (S)
                                                            @elseif($attendance->status == 'I')
                                                                Izin (I)
                                                            @elseif($attendance->status == 'A')
                                                                Alpa (A)
                                                            @else
                                                                {{ $attendance->status }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">Tidak ada data absensi untuk kelas ini.</div>
                    @endif
                </div>
            </div>

            <div class="text-right">
                <a href="{{ route('absensi.rekap') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection