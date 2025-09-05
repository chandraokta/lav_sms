@extends('layouts.master')
@section('page_title', 'Manage Exam Marks')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-books mr-2"></i> Manage Exam Marks</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi Penilaian</h5>
                <p class="mb-0">Masukkan jenis nilai secara manual untuk setiap siswa. Anda dapat menambahkan berbagai jenis penilaian seperti UH, PTS, Tugas, dll.</p>
            </div>

            <form method="post" action="{{ route('nilai.update', [$exam_id, $my_class_id, $section_id, $subject_id]) }}">
                @csrf @method('PUT')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Nilai</th>
                                <th>Deskripsi</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($marks->sortBy('user.name') as $mk)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mk->user->name }}</td>
                                    <td>
                                        <select name="jenis_nilai_{{ $mk->id }}" class="form-control select">
                                            <option value="">-- Pilih Jenis Nilai --</option>
                                            <option value="uh" {{ (old('jenis_nilai_'.$mk->id) == 'uh') ? 'selected' : '' }}>UH (Ulangan Harian)</option>
                                            <option value="pts" {{ (old('jenis_nilai_'.$mk->id) == 'pts') ? 'selected' : '' }}>PTS (Penilaian Tengah Semester)</option>
                                            <option value="pas" {{ (old('jenis_nilai_'.$mk->id) == 'pas') ? 'selected' : '' }}>PAS (Penilaian Akhir Semester)</option>
                                            <option value="tugas" {{ (old('jenis_nilai_'.$mk->id) == 'tugas') ? 'selected' : '' }}>Tugas Harian</option>
                                            <option value="presentasi" {{ (old('jenis_nilai_'.$mk->id) == 'presentasi') ? 'selected' : '' }}>Presentasi</option>
                                            <option value="praktikum" {{ (old('jenis_nilai_'.$mk->id) == 'praktikum') ? 'selected' : '' }}>Praktikum</option>
                                            <option value="proyek" {{ (old('jenis_nilai_'.$mk->id) == 'proyek') ? 'selected' : '' }}>Proyek</option>
                                            <option value="lainnya" {{ (old('jenis_nilai_'.$mk->id) == 'lainnya') ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="deskripsi_{{ $mk->id }}" 
                                               value="{{ old('deskripsi_'.$mk->id) }}" 
                                               class="form-control" placeholder="Deskripsi penilaian">
                                    </td>
                                    <td>
                                        <input type="number" name="nilai_{{ $mk->id }}" 
                                               value="{{ old('nilai_'.$mk->id, $mk->exm) }}" 
                                               class="form-control" min="0" max="100" placeholder="0-100">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">
                        <i class="icon-floppy-disk mr-2"></i> Simpan Nilai
                    </button>
                    <a href="{{ route('nilai.rekap') }}" class="btn btn-secondary btn-lg px-5 rounded-pill">
                        <i class="icon-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection