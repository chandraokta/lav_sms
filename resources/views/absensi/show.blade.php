@extends('layouts.master')
@section('page_title', 'Detail Absensi')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-calendar3 mr-2"></i> Detail Absensi</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <label class="col-form-label font-weight-bold">Kelas: {{ $class->name }}</label><br>
                            <label class="col-form-label font-weight-bold">Tanggal: {{ date('d F Y', strtotime($date)) }}</label>
                        </div>
                        <div>
                            <a href="{{ route('absensi.show.export', ['class_id' => $class->id, 'date' => $date]) }}" class="btn btn-success">
                                <i class="icon-file-download mr-1"></i> Export CSV
                            </a>
                        </div>
                    </div>
                </div>
            </div>
                    
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
                                @forelse($attendances as $attendance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attendance->student->name }}</td>
                                        <td>{{ $attendance->student->student_record->adm_no ?? 'N/A' }}</td>
                                        <td>
                                            @if($attendance->status == 'H')
                                                <span class="badge badge-success">Hadir (H)</span>
                                            @elseif($attendance->status == 'S')
                                                <span class="badge badge-warning">Sakit (S)</span>
                                            @elseif($attendance->status == 'I')
                                                <span class="badge badge-info">Izin (I)</span>
                                            @elseif($attendance->status == 'A')
                                                <span class="badge badge-danger">Alpa (A)</span>
                                            @else
                                                {{ $attendance->status }}
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data absensi untuk kelas dan tanggal ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <a href="{{ route('absensi.edit', ['class_id' => $class->id, 'date' => $date]) }}" class="btn btn-primary">Edit Absensi</a>
                <a href="{{ route('absensi.recap') }}" class="btn btn-success">Rekap Absensi Periode</a>
                <a href="{{ route('absensi.rekap') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection