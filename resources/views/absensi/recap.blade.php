@extends('layouts.master')
@section('page_title', 'Rekap Absensi - ' . $class->name)
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-bold text-primary"><i class="icon-calendar3 mr-2"></i> Rekap Absensi - {{ $class->name }}</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="alert alert-info mb-3">
                <strong>Periode:</strong> 
                @if($period == 'daily')
                    {{ date('d F Y', strtotime($start_date)) }}
                @elseif($period == 'weekly')
                    {{ date('d F Y', strtotime($start_date)) }} - {{ date('d F Y', strtotime($end_date)) }}
                @elseif($period == 'monthly')
                    {{ date('F Y', strtotime($start_date)) }}
                @else
                    {{ date('d F Y', strtotime($start_date)) }} - {{ date('d F Y', strtotime($end_date)) }}
                @endif
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('absensi.rekap') }}" class="btn btn-secondary">
                        <i class="icon-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                <div>
                    <form method="post" action="{{ route('absensi.recap.export') }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $class->id }}">
                        <input type="hidden" name="period" value="{{ $period }}">
                        <input type="hidden" name="start_date" value="{{ $start_date }}">
                        <input type="hidden" name="end_date" value="{{ $end_date }}">
                        <button type="submit" class="btn btn-success">
                            <i class="icon-file-download mr-1"></i> Download CSV
                        </button>
                    </form>
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="icon-printer mr-1"></i> Cetak Laporan
                    </button>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info border-0 rounded-lg">
                        <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                        <ul class="mb-0">
                            <li>Gunakan tombol "Download CSV" untuk mengunduh laporan dalam format CSV</li>
                            <li>Gunakan tombol cetak untuk mencetak laporan</li>
                            <li>Anda dapat mengupdate data absensi langsung dari tabel di bawah</li>
                        </ul>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="nav-item">
                    <a href="#daily-view" class="nav-link active" data-toggle="tab">Tampilan Harian</a>
                </li>
                <li class="nav-item">
                    <a href="#summary-view" class="nav-link" data-toggle="tab">Ringkasan</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="daily-view">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatable-button-html5-columns">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    @foreach($students as $student)
                                        <th>{{ $student->user->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $date => $attendanceRecords)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($date)) }}</td>
                                        @foreach($students as $student)
                                            @php
                                                $attendance = $attendanceRecords->firstWhere('student_id', $student->user_id);
                                            @endphp
                                            <td>
                                                @if($attendance)
                                                    <select name="attendances[{{ $attendance->id }}]" class="form-control form-control-sm">
                                                        <option value="H" {{ $attendance->status == 'H' ? 'selected' : '' }}>H</option>
                                                        <option value="S" {{ $attendance->status == 'S' ? 'selected' : '' }}>S</option>
                                                        <option value="I" {{ $attendance->status == 'I' ? 'selected' : '' }}>I</option>
                                                        <option value="A" {{ $attendance->status == 'A' ? 'selected' : '' }}>A</option>
                                                    </select>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $students->count() + 1 }}" class="text-center">Tidak ada data absensi untuk periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($attendances->count() > 0)
                        <form method="post" action="{{ route('absensi.recap.update') }}">
                            @csrf
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary">Update Absensi <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    @endif
                </div>

                <div class="tab-pane fade" id="summary-view">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatable-button-html5-columns">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th>Hadir</th>
                                    <th>Sakit</th>
                                    <th>Izin</th>
                                    <th>Alpa</th>
                                    <th>Total Hari</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summary as $student_id => $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data['student']->user->name }}</td>
                                        <td>{{ $data['student']->adm_no }}</td>
                                        <td>{{ $data['present'] }}</td>
                                        <td>{{ $data['sick'] }}</td>
                                        <td>{{ $data['leave'] }}</td>
                                        <td>{{ $data['absent'] }}</td>
                                        <td>{{ $data['total_days'] }}</td>
                                        <td>{{ $data['percentage'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-right mt-3">
                <a href="{{ route('absensi.recap') }}" class="btn btn-secondary">
                    <i class="icon-filter mr-1"></i> Filter Ulang
                </a>
                <a href="{{ route('absensi.rekap') }}" class="btn btn-info">
                    <i class="icon-arrow-left mr-1"></i> Kembali ke Rekap
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
// Wait for the global DataTables initialization to complete
$(window).on('load', function() {
    setTimeout(function() {
        // Make sure the buttons are visible for any existing DataTables
        $('.dataTables_wrapper .dt-buttons').show();
        
        // If any tables with the class are not yet initialized as DataTables, initialize them
        $('.datatable-button-html5-columns').each(function() {
            var table = $(this);
            if (!table.hasClass('dataTable')) {
                try {
                    table.DataTable({
                        buttons: [
                            'copyHtml5',
                            'csvHtml5',
                            'excelHtml5',
                            'pdfHtml5',
                            'print'
                        ],
                        dom: 'Bfrtip',
                        responsive: true,
                        pageLength: 100
                    });
                } catch(e) {
                    console.log('Error initializing DataTable:', e);
                }
            }
        });
    }, 1000);
});
</script>
@endsection