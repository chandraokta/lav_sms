@extends('layouts.master')
@section('page_title', 'Daftar Siswa - ' . $class->name)
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-users mr-2"></i> Daftar Siswa - {{ $class->name }}</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <!-- Tombol Aksi -->
            <div class="mb-3">
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="icon-plus2 mr-2"></i> Tambah Siswa Baru
                </a>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    <i class="icon-pencil mr-2"></i> Kelola Siswa
                </a>
            </div>

            <table class="table table-bordered datatable-button-html5-columns">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($student->user->photo)
                                <img src="{{ $student->user->photo }}" alt="Foto" class="rounded-circle" width="40" height="40">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="icon-user text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $student->user->name }}</td>
                        <td>{{ $student->adm_no }}</td>
                        <td>{{ $student->user->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="icon-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mt-3">
                <a href="{{ route('teacher.students.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection