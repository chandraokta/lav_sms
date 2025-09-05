<div class="sidebar sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigasi
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="{{ route('my_account') }}">
                            @if(Auth::user()->photo && Auth::user()->photo != Qs::getDefaultUserImage())
                                <img src="{{ Auth::user()->photo }}" width="38" height="38" class="rounded-circle" alt="photo">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="icon-user text-white"></i>
                                </div>
                            @endif
                        </a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-user font-size-sm"></i> &nbsp;{{ ucwords(str_replace('_', ' ', Auth::user()->user_type)) }}
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <a href="{{ route('my_account') }}" class="text-white"><i class="icon-cog3"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ (Route::is('dashboard')) ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>{{ __('menu.dashboard') }}</span>
                    </a>
                </li>

                <!-- Absensi -->
                <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['absensi.create', 'absensi.index']) ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="icon-calendar3"></i> <span>Absensi</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Absensi">
                        <li class="nav-item"><a href="{{ route('absensi.create') }}" class="nav-link {{ Route::is('absensi.create') ? 'active' : '' }}">Input Absensi</a></li>
                        <li class="nav-item"><a href="{{ route('absensi.rekap') }}" class="nav-link {{ Route::is('absensi.rekap') ? 'active' : '' }}">Rekap Absensi</a></li>
                    </ul>
                </li>

                <!-- Nilai -->
                <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['nilai.create', 'nilai.rekap', 'nilai.manage']) ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="icon-books"></i> <span>Nilai</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Nilai">
                        <li class="nav-item"><a href="{{ route('nilai.create') }}" class="nav-link {{ Route::is('nilai.create') ? 'active' : '' }}">Input Nilai</a></li>
                        <li class="nav-item"><a href="{{ route('nilai.rekap') }}" class="nav-link {{ Route::is('nilai.rekap') ? 'active' : '' }}">Rekap Nilai</a></li>
                    </ul>
                </li>

                <!-- Laporan -->
                <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['laporan.rekap']) ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="icon-file-text2"></i> <span>Laporan</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Laporan">
                        <li class="nav-item"><a href="{{ route('laporan.rekap') }}" class="nav-link {{ Route::is('laporan.rekap') ? 'active' : '' }}">Rekap Laporan</a></li>
                    </ul>
                </li>

                <!-- Backup Data -->
                <li class="nav-item">
                    <a href="{{ route('backup.index') }}" class="nav-link {{ Route::is('backup.index') ? 'active' : '' }}"><i class="icon-database"></i> <span>Backup Data</span></a>
                </li>

                <!-- Basic Data Management (only for teacher) -->
                @if(Qs::userIsTeacher())
                <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['classes.index', 'students.index', 'subjects.index', 'sessions.index']) ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="icon-database"></i> <span>Data Dasar</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Data Dasar">
                        <li class="nav-item"><a href="{{ route('classes.index') }}" class="nav-link {{ Route::is('classes.index') ? 'active' : '' }}">Kelas</a></li>
                        <li class="nav-item"><a href="{{ route('students.index') }}" class="nav-link {{ Route::is('students.index') ? 'active' : '' }}">Siswa</a></li>
                        <li class="nav-item"><a href="{{ route('subjects.index') }}" class="nav-link {{ Route::is('subjects.index') ? 'active' : '' }}">Mata Pelajaran</a></li>
                        <li class="nav-item"><a href="{{ route('sessions.index') }}" class="nav-link {{ Route::is('sessions.index') ? 'active' : '' }}">Tahun Ajaran</a></li>
                    </ul>
                </li>
                @endif

                <!-- Exams Management (for teachers and admins) -->
                @if(Qs::userIsTeamSAT())
                <li class="nav-item">
                    <a href="{{ route('exams.index') }}" class="nav-link {{ Route::is('exams.index') || Route::is('exams.edit') ? 'active' : '' }}"><i class="icon-books"></i> <span>Ujian</span></a>
                </li>
                @endif

                {{--Manage Account--}}
                <li class="nav-item">
                    <a href="{{ route('my_account') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['my_account']) ? 'active' : '' }}"><i class="icon-user"></i> <span>{{ __('menu.my_account') }}</span></a>
                </li>

                </ul>
            </div>
        </div>
</div>
