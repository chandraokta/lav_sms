@extends('layouts.master')

@section('page_title', 'Teacher Dashboard')

@section('content')
<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Teacher Dashboard</h6>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h4>Selamat Datang, {{ Auth::user()->name }}!</h4>
                    <p>Anda login sebagai Guru. Anda dapat mengelola kelas, siswa, mata pelajaran, dan nilai.</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="icon-books icon-2x text-primary"></i>
                        <h5 class="card-title">Mata Pelajaran</h5>
                        <p class="card-text">Kelola mata pelajaran yang Anda ajarkan</p>
                        <a href="{{ route('subjects.index') }}" class="btn btn-primary">Lihat Mata Pelajaran</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="icon-users icon-2x text-success"></i>
                        <h5 class="card-title">Siswa</h5>
                        <p class="card-text">Kelola data siswa dalam kelas Anda</p>
                        <a href="{{ route('students.index') }}" class="btn btn-success">Lihat Siswa</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="icon-pencil icon-2x text-info"></i>
                        <h5 class="card-title">Nilai</h5>
                        <p class="card-text">Input dan kelola nilai siswa</p>
                        <a href="{{ route('nilai.rekap') }}" class="btn btn-info">Kelola Nilai</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection