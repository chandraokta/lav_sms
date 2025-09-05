@extends('layouts.master')
@section('page_title', 'Admit Student')
@section('content')
        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h6 class="card-title">Please fill The form Below To Admit A New Student</h6>

                {!! Qs::getPanelOptions() !!}
            </div>

            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="nav-item">
                    <a href="#manual-entry" class="nav-link active rounded-pill mr-1" data-toggle="tab">
                        <i class="icon-pencil5 mr-2"></i> Manual Entry
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#excel-import" class="nav-link rounded-pill" data-toggle="tab">
                        <i class="icon-file-excel mr-2"></i> Import from Excel
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-4">
                <div class="tab-pane fade show active" id="manual-entry">
                    <form id="ajax-reg" method="post" enctype="multipart/form-data" class="wizard-form steps-validation" action="{{ route('students.store') }}" data-fouc>
                       @csrf
                <h6>Student Data</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name: <span class="text-danger">*</span></label>
                                <input value="{{ old('name') }}" required type="text" name="name" placeholder="Full Name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class: <span class="text-danger">*</span></label>
                                <select onchange="getClassSections(this.value)" data-placeholder="Choose..." required name="my_class_id" id="my_class_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($my_classes as $c)
                                        <option {{ (old('my_class_id') == $c->id ? 'selected' : '') }} value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Section: <span class="text-danger">*</span></label>
                                <select data-placeholder="Select Class First" required name="section_id" id="section_id" class="select-search form-control">
                                    <option {{ (old('section_id')) ? 'selected' : '' }} value="{{ old('section_id') }}">{{ (old('section_id')) ? 'Selected' : '' }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
        </div>

        <div class="tab-pane fade" id="excel-import">
            @include('pages.support_team.students.import', ['classes' => $my_classes])
        </div>
    </div>
@endsection
