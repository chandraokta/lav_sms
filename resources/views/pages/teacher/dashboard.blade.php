@extends('layouts.master')
@section('page_title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title"><i class="icon-home4 mr-2"></i> Dashboard</h5>
                    {!! Qs::getPanelOptions() !!}
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5 class="alert-heading">Selamat Datang, {{ Auth::user()->name }}!</h5>
                                <p>Aplikasi ini adalah alat bantu pribadi untuk mencatat kehadiran dan nilai siswa secara cepat dan teratur.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="icon-database text-primary" style="font-size: 3rem;"></i>
                                    <h5 class="card-title mt-3">Data Dasar</h5>
                                    <p class="card-text">Kelola data kelas, siswa, mata pelajaran</p>
                                    <a href="{{ route('classes.index') }}" class="btn btn-primary">Mulai</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="icon-calendar3 text-primary" style="font-size: 3rem;"></i>
                                    <h5 class="card-title mt-3">Absensi</h5>
                                    <p class="card-text">Input dan rekap kehadiran siswa</p>
                                    <a href="{{ route('absensi.create') }}" class="btn btn-primary">Mulai</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="icon-books text-success" style="font-size: 3rem;"></i>
                                    <h5 class="card-title mt-3">Nilai</h5>
                                    <p class="card-text">Input dan rekap nilai akademik siswa</p>
                                    <a href="{{ route('nilai.create') }}" class="btn btn-success">Mulai</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="icon-file-text2 text-info" style="font-size: 3rem;"></i>
                                    <h5 class="card-title mt-3">Laporan</h5>
                                    <p class="card-text">Rekap laporan dan cetak rapor</p>
                                    <a href="{{ route('laporan.rekap') }}" class="btn btn-info">Mulai</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="icon-database text-warning" style="font-size: 3rem;"></i>
                                    <h5 class="card-title mt-3">Backup Data</h5>
                                    <p class="card-text">Backup data aplikasi secara lokal</p>
                                    <a href="{{ route('backup.index') }}" class="btn btn-warning">Mulai</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="icon-user text-secondary" style="font-size: 3rem;"></i>
                                    <h5 class="card-title mt-3">Akun Saya</h5>
                                    <p class="card-text">Kelola profil dan password Anda</p>
                                    <a href="{{ route('my_account') }}" class="btn btn-secondary">Mulai</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection