@extends('layouts.master')
@section('page_title', 'Pilih Siswa untuk Input Nilai')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-books mr-2"></i> Pilih Siswa untuk Input Nilai</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
                <form method="post" action="{{ route('nilai.bulk_select') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-10">
                            <fieldset>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="my_class_id" class="col-form-label font-weight-bold">Kelas:</label>
                                            <select required onchange="getClassSections(this.value)" id="my_class_id" name="my_class_id" class="form-control select">
                                                <option value="">Pilih Kelas</option>
                                                @foreach($my_classes as $c)
                                                    <option {{ ($selected && $my_class_id == $c->id) ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="section_id" class="col-form-label font-weight-bold">Section:</label>
                                            <select required id="section_id" name="section_id" data-placeholder="Pilih Kelas Dulu" class="form-control select">
                                        @if($selected)
                                            @foreach($sections as $s)
                                                    <option {{ ($section_id == $s->id ? 'selected' : '') }} value="{{ $s->id }}">{{ $s->name }}</option>
                                            @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </fieldset>
                        </div>

                        <div class="col-md-2 mt-4">
                            <div class="text-right mt-1">
                                <button type="submit" class="btn btn-primary">Lihat Siswa <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </div>

                    </div>

                </form>
        </div>
    </div>
    @if($selected)
    <div class="card">
        <div class="card-body">
            <table class="table datatable-button-html5-columns">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img class="rounded-circle" style="height: 40px; width: 40px;" src="{{ $s->user->photo }}" alt="photo"></td>
                        <td>{{ $s->user->name }}</td>
                        <td>{{ $s->adm_no }}</td>
                        <form method="post" action="{{ route('nilai.selector') }}">
                    @csrf
                    <input type="hidden" name="exam_id" value="1">
                    <input type="hidden" name="my_class_id" value="{{ $my_class_id ?? '' }}">
                    <input type="hidden" name="section_id" value="{{ $section_id ?? '' }}">
                    <input type="hidden" name="subject_id" value="1">

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection
