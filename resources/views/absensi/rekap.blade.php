@extends('layouts.master')
@section('page_title', 'Rekap Absensi')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-calendar3 mr-2"></i> Rekap Absensi</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="alert alert-info">
                <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                <p class="mb-0">Anda dapat mengekspor data absensi dalam format CSV untuk keperluan arsip atau analisis lebih lanjut. Setiap laporan yang dihasilkan memiliki tombol "Export CSV" untuk mengunduh data.</p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="card-title mb-0">Rekap Harian</h6>
                        </div>
                        <div class="card-body">
                            <form method="get" action="{{ route('absensi.show') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="class_id_daily" class="col-form-label font-weight-bold">Kelas:</label>
                                    <select required id="class_id_daily" name="class_id" class="form-control select">
                                        <option value="">Pilih Kelas</option>
                                        @foreach($classes as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="date" class="col-form-label font-weight-bold">Tanggal:</label>
                                    <input required type="date" id="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Lihat Rekap <i class="icon-search4 ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="card-title mb-0">Rekap Berdasarkan Periode</h6>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('absensi.recap') }}" class="btn btn-success btn-block btn-lg">
                                <i class="icon-calendar3 mr-2"></i> Rekap Absensi Periode
                            </a>
                            
                            <div class="mt-3">
                                <p class="mb-1"><strong>Tipe Periode yang Tersedia:</strong></p>
                                <ul class="mb-0">
                                    <li>Harian - Rekap untuk satu tanggal tertentu</li>
                                    <li>Mingguan - Rekap untuk 7 hari terakhir</li>
                                    <li>Bulanan - Rekap untuk bulan ini</li>
                                    <li>Kustom - Rekap untuk rentang tanggal tertentu</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection