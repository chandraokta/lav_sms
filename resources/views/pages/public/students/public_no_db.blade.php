@extends('layouts.app')

@section('title', 'Semua Siswa')
@section('page_title', 'Daftar Semua Siswa')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title"><i class="icon-users mr-2"></i> Daftar Semua Siswa</h5>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning text-center">
                        <i class="icon-info22 mr-2"></i> 
                        <h4>Koneksi Database Tidak Tersedia</h4>
                        <p>Saat ini tidak dapat menampilkan data siswa karena koneksi database tidak tersedia.</p>
                        <p>Silakan pastikan layanan MySQL sudah dijalankan di XAMPP Control Panel Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection