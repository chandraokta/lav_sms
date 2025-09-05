@extends('layouts.master')

@section('page_title', 'Admin Dashboard')

@section('content')
<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Admin Dashboard</h6>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h4>Selamat Datang, {{ Auth::user()->name }}!</h4>
                    <p>Anda login sebagai Administrator. Anda memiliki akses penuh ke semua fitur sistem.</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="icon-users icon-2x text-primary"></i>
                        <h5 class="card-title">Pengguna</h5>
                        <p class="card-text">Kelola pengguna sistem</p>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Kelola Pengguna</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="icon-books icon-2x text-success"></i>
                        <h5 class="card-title">Mata Pelajaran</h5>
                        <p class="card-text">Kelola mata pelajaran</p>
                        <a href="{{ route('subjects.index') }}" class="btn btn-success">Kelola Mata Pelajaran</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="icon-users icon-2x text-info"></i>
                        <h5 class="card-title">Siswa</h5>
                        <p class="card-text">Kelola data siswa</p>
                        <a href="{{ route('students.index') }}" class="btn btn-info">Kelola Siswa</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="icon-file-text2 icon-2x text-warning"></i>
                        <h5 class="card-title">Ujian</h5>
                        <p class="card-text">Kelola jenis ujian</p>
                        <a href="{{ route('exams.index') }}" class="btn btn-warning">Kelola Ujian</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection