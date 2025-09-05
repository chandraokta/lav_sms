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
                    <div class="alert alert-info text-center">
                        <i class="icon-info22 mr-2"></i> Database connection is not available. Please make sure MySQL is running.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection