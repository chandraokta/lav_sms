@extends('layouts.master')
@section('page_title', 'Manajemen Siswa')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-users mr-2"></i> Manajemen Siswa</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <!-- Tombol Aksi -->
            <div class="mb-3">
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="icon-plus2 mr-2"></i> Tambah Siswa Baru
                </a>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    <i class="icon-cog mr-2"></i> Kelola Siswa
                </a>
            </div>

            <div class="row">
                @foreach($classes as $class)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $class->name }}</h5>
                            <a href="{{ route('teacher.students.list', $class->id) }}" class="btn btn-primary">Lihat Siswa</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection