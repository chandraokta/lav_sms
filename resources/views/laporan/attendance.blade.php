@extends('layouts.master')
@section('page_title', 'Laporan Kehadiran - ' . $class->name . ' - ' . $month . '/' . $year)
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title font-weight-bold text-primary"><i class="icon-calendar3 mr-2"></i>Laporan Kehadiran - {{ $class->name }} - {{ $month }}/{{ $year }}</h5>
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
                <form method="post" action="{{ route('laporan.attendance.download') }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="year" value="{{ $year }}">
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
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Tanggal</th>
                        @foreach($students as $student)
                            <th>{{ $student->user->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Generate all dates in the month
                        $start_date = "{$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
                        $end_date = date("Y-m-t", strtotime($start_date));
                        $current_date = $start_date;
                    @endphp
                    
                    @while ($current_date <= $end_date)
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($current_date)) }}</td>
                            @foreach($students as $student)
                                @php
                                    $attendance_record = $attendances->get($current_date)->firstWhere('student_id', $student->user_id);
                                    $status = $attendance_record ? $attendance_record->status : '-';
                                    
                                    // Define status labels
                                    $status_label = '';
                                    switch($status) {
                                        case 'H':
                                            $status_label = '<span class="badge badge-success">H</span>';
                                            break;
                                        case 'S':
                                            $status_label = '<span class="badge badge-warning">S</span>';
                                            break;
                                        case 'I':
                                            $status_label = '<span class="badge badge-info">I</span>';
                                            break;
                                        case 'A':
                                            $status_label = '<span class="badge badge-danger">A</span>';
                                            break;
                                        default:
                                            $status_label = '<span class="badge badge-secondary">-</span>';
                                    }
                                @endphp
                                <td class="text-center">{!! $status_label !!}</td>
                            @endforeach
                        </tr>
                        @php
                            $current_date = date("Y-m-d", strtotime("+1 day", strtotime($current_date)));
                        @endphp
                    @endwhile
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <h6>Keterangan:</h6>
            <ul>
                <li><span class="badge badge-success">H</span> = Hadir</li>
                <li><span class="badge badge-warning">S</span> = Sakit</li>
                <li><span class="badge badge-info">I</span> = Izin</li>
                <li><span class="badge badge-danger">A</span> = Alpa</li>
                <li><span class="badge badge-secondary">-</span> = Tidak ada data</li>
            </ul>
        </div>
    </div>
</div>

@endsection