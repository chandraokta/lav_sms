@extends('layouts.master')
@section('page_title', 'Input Absensi')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-calendar3 mr-2"></i> Input Absensi</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            @if(session('flash_info'))
                <div class="alert alert-info border-0 alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    <span class="font-weight-semibold">Info!</span> {{ session('flash_info') }}
                </div>
            @endif
            
            <form method="post" action="{{ route('absensi.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <fieldset>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="class_id" class="col-form-label font-weight-bold">Kelas:</label>
                                        <select required id="class_id" name="class_id" class="form-control select">
                                            <option value="">Pilih Kelas</option>
                                            @foreach($classes as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date" class="col-form-label font-weight-bold">Tanggal:</label>
                                        <input required type="date" id="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                            </div>

                        </fieldset>
                    </div>

                    <div class="col-md-2 mt-4">
                        <div class="text-right mt-1">
                            <button type="submit" class="btn btn-primary">Input Absensi <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
@endsection