@extends('layouts.master')
@section('page_title', 'Laporan Akademik')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title font-weight-bold text-primary"><i class="icon-file-text2 mr-2"></i>Laporan Akademik</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="alert alert-info border-0 alert-dismissible rounded-lg">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi Laporan</h5>
            <p class="mb-0">Gunakan halaman ini untuk mengakses berbagai laporan akademik siswa. Pilih kelas untuk melihat laporan nilai dan prestasi siswa.</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-primary border-2 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0"><i class="icon-search mr-2"></i>Laporan Nilai Siswa</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('laporan.student') }}">
                            @csrf
                            <div class="form-group">
                                <label for="class_id" class="font-weight-semibold">Pilih Kelas <span class="text-danger">*</span></label>
                                <select required class="form-control select form-control-lg rounded-pill" name="class_id" id="class_id">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">
                                    <i class="icon-file-text2 mr-2"></i>Lihat Laporan Nilai
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-success border-2 rounded-lg">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0"><i class="icon-calendar3 mr-2"></i>Laporan Kehadiran</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('laporan.attendance') }}">
                            @csrf
                            <div class="form-group">
                                <label for="attendance_class_id" class="font-weight-semibold">Pilih Kelas <span class="text-danger">*</span></label>
                                <select required class="form-control select form-control-lg rounded-pill" name="class_id" id="attendance_class_id">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="month" class="font-weight-semibold">Bulan <span class="text-danger">*</span></label>
                                    <select required class="form-control select rounded-pill" name="month" id="month">
                                        <option value="">-- Pilih Bulan --</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="year" class="font-weight-semibold">Tahun <span class="text-danger">*</span></label>
                                    <select required class="form-control select rounded-pill" name="year" id="year">
                                        <option value="">-- Pilih Tahun --</option>
                                        @for($i = date('Y') - 1; $i <= date('Y') + 1; $i++)
                                            <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill">
                                    <i class="icon-calendar3 mr-2"></i>Lihat Laporan Kehadiran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card border-warning border-2 rounded-lg">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0"><i class="icon-warning mr-2"></i>Petunjuk Penggunaan</h5>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>Pilih kelas yang ingin Anda lihat laporannya</li>
                            <li>Untuk laporan nilai, klik tombol "Lihat Laporan Nilai"</li>
                            <li>Untuk laporan kehadiran, pilih bulan dan tahun, lalu klik "Lihat Laporan Kehadiran"</li>
                            <li>Gunakan tombol cetak untuk mencetak laporan atau tombol download untuk menyimpan dalam format CSV</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection