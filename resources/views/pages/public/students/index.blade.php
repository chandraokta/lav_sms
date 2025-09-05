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
                    @if($students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Bagian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $student->user->name ?? 'N/A' }}</td>
                                            <td>{{ $student->adm_no ?? 'N/A' }}</td>
                                            <td>{{ ($student->my_class ? $student->my_class->name : 'N/A') ?? 'N/A' }}</td>
                                            <td>{{ ($student->section ? $student->section->name : 'N/A') ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="icon-info22 mr-2"></i> Tidak ada data siswa yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection