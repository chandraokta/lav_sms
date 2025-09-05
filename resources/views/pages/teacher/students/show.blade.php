@extends('layouts.master')
@section('page_title', 'Detail Siswa - ' . $student->user->name)
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-user mr-2"></i> Detail Siswa - {{ $student->user->name }}</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        @if($student->user->photo)
                            <img src="{{ $student->user->photo }}" alt="Foto Siswa" class="img-fluid rounded" style="max-width: 200px;">
                        @else
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 200px; height: 200px; margin: 0 auto;">
                                <i class="icon-user text-white" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <h4>{{ $student->user->name }}</h4>
                    <p class="text-muted">{{ $student->adm_no }}</p>
                </div>
                
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">NIS</th>
                                <td>{{ $student->adm_no }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $student->user->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $student->user->gender == 'M' ? 'Laki-laki' : ($student->user->gender == 'F' ? 'Perempuan' : '-') }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $student->user->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>{{ $student->user->dob ? date('d M Y', strtotime($student->user->dob)) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>{{ $student->user->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>{{ $student->my_class->name ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-right mt-3">
                <a href="{{ route('teacher.students.list', $student->my_class->id) }}" class="btn btn-secondary">
                    <i class="icon-arrow-left mr-2"></i> Kembali ke Daftar Siswa
                </a>
                <a href="{{ route('teacher.students.index') }}" class="btn btn-primary">
                    <i class="icon-home4 mr-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
@endsection