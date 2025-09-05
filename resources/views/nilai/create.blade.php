@extends('layouts.master')
@section('page_title', 'Input Nilai Siswa')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-books mr-2"></i> Input Nilai Siswa</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('nilai.selector') }}">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exam_id" class="col-form-label font-weight-bold">Ujian:</label>
                                        <select required id="exam_id" name="exam_id" class="form-control select">
                                            <option value="">Pilih Ujian</option>
                                            @foreach($exams as $ex)
                                                <option value="{{ $ex->id }}">{{ $ex->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="my_class_id" class="col-form-label font-weight-bold">Kelas:</label>
                                        <select required onchange="getClassSections(this.value)" id="my_class_id" name="my_class_id" class="form-control select">
                                            <option value="">Pilih Kelas</option>
                                            @foreach($my_classes as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="section_id" class="col-form-label font-weight-bold">Section:</label>
                                        <select required id="section_id" name="section_id" data-placeholder="Pilih Kelas Dulu" class="form-control select">
                                            <option value="">Pilih Section</option>
                                            @if(isset($sections))
                                                @foreach($sections as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="subject_id" class="col-form-label font-weight-bold">Mata Pelajaran:</label>
                                        <select required id="subject_id" name="subject_id" class="form-control select">
                                            <option value="">Pilih Mata Pelajaran</option>
                                            @foreach($subjects as $sub)
                                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-2 mt-4">
                        <div class="text-right mt-1">
                            <button type="submit" class="btn btn-primary">Input Nilai <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection