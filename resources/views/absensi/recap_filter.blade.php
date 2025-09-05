@extends('layouts.master')
@section('page_title', 'Filter Rekap Absensi')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-calendar3 mr-2"></i> Filter Rekap Absensi</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="alert alert-info">
                <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi</h5>
                <p class="mb-0">Setelah memfilter data absensi, Anda dapat mengekspor hasilnya dalam format CSV untuk keperluan arsip atau analisis lebih lanjut.</p>
            </div>

            <form method="get" action="{{ route('absensi.recap') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="class_id" class="col-form-label font-weight-bold">Kelas:</label>
                                        <select required id="class_id" name="class_id" class="form-control select">
                                            <option value="">Pilih Kelas</option>
                                            @foreach($classes as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="period" class="col-form-label font-weight-bold">Periode:</label>
                                        <select required id="period" name="period" class="form-control select">
                                            <option value="">Pilih Periode</option>
                                            <option value="daily">Harian</option>
                                            <option value="weekly">Mingguan</option>
                                            <option value="monthly">Bulanan</option>
                                            <option value="custom">Kustom</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="date-range" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date" class="col-form-label font-weight-bold">Tanggal Mulai:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date" class="col-form-label font-weight-bold">Tanggal Akhir:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="single_date" class="col-form-label font-weight-bold">Tanggal (untuk harian):</label>
                                        <input type="date" id="single_date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-12">
                        <div class="text-right mt-1">
                            <a href="{{ route('absensi.rekap') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Lihat Rekap <i class="icon-search4 ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periodSelect = document.getElementById('period');
            const dateRange = document.getElementById('date-range');
            const singleDate = document.getElementById('single_date').closest('.row');
            
            periodSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    dateRange.style.display = 'flex';
                    singleDate.style.display = 'none';
                } else if (this.value === 'daily') {
                    dateRange.style.display = 'none';
                    singleDate.style.display = 'flex';
                } else {
                    dateRange.style.display = 'none';
                    singleDate.style.display = 'none';
                }
            });
        });
    </script>
@endsection