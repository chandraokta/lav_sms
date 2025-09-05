@extends('layouts.master')
@section('page_title', 'Edit Absensi Siswa')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-user mr-2"></i> Edit Absensi Siswa</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('absensi.update', ['class_id' => $class_id, 'date' => $date]) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <input type="hidden" name="date" value="{{ $date }}">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Kelas: {{ $students->first()->my_class->name ?? 'N/A' }}</label><br>
                            <label class="col-form-label font-weight-bold">Tanggal: {{ $date }}</label>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>NIS</th>
                                        <th>Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $student->user->name }}</td>
                                            <td>{{ $student->adm_no }}</td>
                                            <td>
                                                @php
                                                    // Find existing attendance record for this student
                                                    $existingAttendance = $attendances->firstWhere('student_id', $student->user->id);
                                                    $selectedStatus = $existingAttendance ? $existingAttendance->status : 'H';
                                                @endphp
                                                <select name="students[{{ $student->user->id }}]" class="form-control select" required>
                                                    <option value="H" {{ $selectedStatus == 'H' ? 'selected' : '' }}>Hadir (H)</option>
                                                    <option value="S" {{ $selectedStatus == 'S' ? 'selected' : '' }}>Sakit (S)</option>
                                                    <option value="I" {{ $selectedStatus == 'I' ? 'selected' : '' }}>Izin (I)</option>
                                                    <option value="A" {{ $selectedStatus == 'A' ? 'selected' : '' }}>Alpa (A)</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('absensi.create') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update Absensi <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection