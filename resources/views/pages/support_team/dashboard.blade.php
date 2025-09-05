@extends('layouts.master')

@section('page_title', 'Dasbor Saya')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h4 class="card-title mb-0"><i class="icon-home4 mr-2"></i> Dasbor Saya</h4>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(Qs::userIsTeamSA())
                        <div class="row">
                            <div class="col-sm-6 col-xl-3">
                                <div class="card card-body bg-blue-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $users->where('user_type', 'student')->count() }}</h3>
                                            <span class="text-uppercase font-size-xs font-weight-bold">Total Siswa</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-users4 icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card card-body bg-danger-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $users->where('user_type', 'teacher')->count() }}</h3>
                                            <span class="text-uppercase font-size-xs">Total Guru</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-user-tie icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card card-body bg-success-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $users->where('user_type', 'parent')->count() }}</h3>
                                            <span class="text-uppercase font-size-xs">Total Orang Tua</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-users icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card card-body bg-indigo-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $users->where('user_type', 'admin')->count() + $users->where('user_type', 'super_admin')->count() }}</h3>
                                            <span class="text-uppercase font-size-xs">Total Admin</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-user-plus icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-xl-3">
                                <div class="card card-body bg-pink-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $my_classes->count() }}</h3>
                                            <span class="text-uppercase font-size-xs font-weight-bold">Total Kelas</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-chalkboard icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card card-body bg-purple-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $subjects->count() }}</h3>
                                            <span class="text-uppercase font-size-xs">Total Mata Pelajaran</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-books icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card card-body bg-teal-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $exams->count() }}</h3>
                                            <span class="text-uppercase font-size-xs">Total Ujian</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-books icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card card-body bg-orange-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $sections->count() }}</h3>
                                            <span class="text-uppercase font-size-xs">Total Bagian</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-chalkboard-teacher icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Qs::userIsTeacher())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                    <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Selamat Datang, {{ Auth::user()->name }}!</h5>
                                    <p class="mb-0">Anda login sebagai guru. Gunakan menu di sidebar untuk mengelola data absensi, nilai, dan laporan siswa.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-xl-4">
                                <div class="card card-body bg-blue-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $subjects_count }}</h3>
                                            <span class="text-uppercase font-size-xs font-weight-bold">Mata Pelajaran</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-books icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-4">
                                <div class="card card-body bg-success-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $classes_count }}</h3>
                                            <span class="text-uppercase font-size-xs">Kelas yang Diajar</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-chalkboard icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-4">
                                <div class="card card-body bg-purple-400 has-bg-image rounded-lg shadow-sm">
                                    <div class="media">
                                        <div class="media-body">
                                            <h3 class="mb-0 font-weight-bold">{{ $students_count }}</h3>
                                            <span class="text-uppercase font-size-xs">Total Siswa</span>
                                        </div>

                                        <div class="ml-3 align-self-center">
                                            <i class="icon-users4 icon-3x opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Qs::userIsStudent())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                    <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Selamat Datang, {{ Auth::user()->name }}!</h5>
                                    <p class="mb-0">Anda login sebagai siswa. Gunakan menu di sidebar untuk melihat nilai dan absensi Anda.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Qs::userIsParent())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                    <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Selamat Datang, {{ Auth::user()->name }}!</h5>
                                    <p class="mb-0">Anda login sebagai orang tua. Gunakan menu di sidebar untuk melihat informasi anak Anda.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection