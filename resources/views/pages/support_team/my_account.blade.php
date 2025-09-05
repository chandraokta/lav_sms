@extends('layouts.master')

@section('page_title', 'Akun Saya')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h4 class="card-title mb-0"><i class="icon-user mr-2"></i> Akun Saya</h4>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs nav-tabs-highlight mb-4">
                        <li class="nav-item">
                            <a href="#change-pass" class="nav-link active rounded-pill mr-2" data-toggle="tab">
                                <i class="icon-lock mr-2"></i> Ubah Password
                            </a>
                        </li>
                        @if(Qs::userIsPTA())
                            <li class="nav-item">
                                <a href="#edit-profile" class="nav-link rounded-pill" data-toggle="tab">
                                    <i class="icon-pencil5 mr-2"></i> Kelola Profil
                                </a>
                            </li>
                        @endif
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="change-pass">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="alert alert-info border-0 alert-dismissible rounded-lg">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi Keamanan</h5>
                                        <p class="mb-0">Gunakan password yang kuat dan unik. Pastikan password terdiri dari minimal 8 karakter dengan kombinasi huruf, angka, dan simbol.</p>
                                    </div>

                                    <div class="card border-primary shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0"><i class="icon-lock mr-2"></i>Form Ubah Password</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{ route('my_account.change_pass') }}">
                                                @csrf @method('put')

                                                <div class="form-group">
                                                    <label for="current_password" class="font-weight-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                                                    <input id="current_password" name="current_password" required type="password" class="form-control" placeholder="Masukkan password saat ini">
                                                    <small class="form-text text-muted">Masukkan password Anda saat ini untuk verifikasi.</small>
                                                </div>

                                                <div class="form-group">
                                                    <label for="password" class="font-weight-semibold">Password Baru <span class="text-danger">*</span></label>
                                                    <input id="password" name="password" required type="password" class="form-control" placeholder="Masukkan password baru">
                                                    <small class="form-text text-muted">Password minimal 8 karakter.</small>
                                                </div>

                                                <div class="form-group">
                                                    <label for="password_confirmation" class="font-weight-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                                    <input id="password_confirmation" name="password_confirmation" required type="password" class="form-control" placeholder="Konfirmasi password baru">
                                                    <small class="form-text text-muted">Masukkan kembali password baru Anda.</small>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                                                        <i class="icon-lock mr-2"></i> Ubah Password
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(Qs::userIsPTA())
                            <div class="tab-pane fade" id="edit-profile">
                                <div class="row">
                                    <div class="col-lg-8 offset-lg-2">
                                        <div class="alert alert-warning border-0 alert-dismissible rounded-lg">
                                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                            <h5 class="alert-heading font-weight-bold"><i class="icon-warning mr-2"></i> Perhatian</h5>
                                            <p class="mb-0">Pastikan informasi profil Anda selalu diperbarui. Perubahan nama dan foto profil akan terlihat di seluruh sistem.</p>
                                        </div>

                                        <div class="card border-warning shadow-sm">
                                            <div class="card-header bg-warning text-white">
                                                <h5 class="card-title mb-0"><i class="icon-pencil5 mr-2"></i>Form Kelola Profil</h5>
                                            </div>
                                            <div class="card-body">
                                                <form enctype="multipart/form-data" method="post" action="{{ route('my_account.update') }}">
                                                    @csrf @method('put')

                                                    <div class="form-group">
                                                        <label for="name" class="font-weight-semibold">Nama Lengkap</label>
                                                        <input id="name" name="name" class="form-control" type="text" value="{{ $my->name }}" placeholder="Masukkan nama lengkap">
                                                        <small class="form-text text-muted">Nama lengkap Anda yang akan ditampilkan di sistem.</small>
                                                    </div>

                                                    @if($my->username)
                                                        <div class="form-group">
                                                            <label for="username" class="font-weight-semibold">Username</label>
                                                            <input disabled id="username" class="form-control" type="text" value="{{ $my->username }}" placeholder="Username">
                                                            <small class="form-text text-muted">Username tidak dapat diubah.</small>
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <label for="username" class="font-weight-semibold">Username</label>
                                                            <input id="username" name="username" type="text" class="form-control" placeholder="Masukkan username">
                                                            <small class="form-text text-muted">Username untuk login ke sistem.</small>
                                                        </div>
                                                    @endif

                                                    <div class="form-group">
                                                        <label for="email" class="font-weight-semibold">Email</label>
                                                        <input id="email" value="{{ $my->email }}" name="email" type="email" class="form-control" placeholder="Masukkan email">
                                                        <small class="form-text text-muted">Alamat email aktif Anda.</small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="phone" class="font-weight-semibold">Nomor Telepon</label>
                                                        <input id="phone" value="{{ $my->phone }}" name="phone" type="text" class="form-control" placeholder="Masukkan nomor telepon">
                                                        <small class="form-text text-muted">Nomor telepon yang dapat dihubungi.</small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="phone2" class="font-weight-semibold">Telepon Alternatif</label>
                                                        <input id="phone2" value="{{ $my->phone2 }}" name="phone2" type="text" class="form-control" placeholder="Masukkan telepon alternatif">
                                                        <small class="form-text text-muted">Nomor telepon alternatif (opsional).</small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="address" class="font-weight-semibold">Alamat</label>
                                                        <input id="address" value="{{ $my->address }}" name="address" type="text" class="form-control" placeholder="Masukkan alamat">
                                                        <small class="form-text text-muted">Alamat lengkap tempat tinggal Anda.</small>
                                                    </div>

                                                    <!-- Subjects Input for Teachers -->
                                                    @if(Qs::userIsTeacher())
                                                    <div class="form-group">
                                                        <label for="subjects" class="font-weight-semibold">Mata Pelajaran</label>
                                                        <div class="form-control-plaintext">
                                                            @foreach(Qs::findTeacherSubjects(Auth::user()->id) as $subject)
                                                                <span class="badge badge-primary mr-1">{{ $subject->name }} ({{ $subject->my_class->name ?? '' }})</span>
                                                            @endforeach
                                                        </div>
                                                        <small class="form-text text-muted">Mata pelajaran Anda dikelola oleh administrator. Hubungi administrator untuk menambah atau menghapus mata pelajaran.</small>
                                                    </div>
                                                    @endif

                                                    <div class="form-group">
                                                        <label for="photo" class="font-weight-semibold">Foto Profil</label>
                                                        <input accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
                                                        <small class="form-text text-muted">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</small>
                                                    </div>

                                                    <div class="text-center mt-4">
                                                        <button type="submit" class="btn btn-warning btn-lg rounded-pill px-4">
                                                            <i class="icon-pencil5 mr-2"></i> Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize form styled elements
    if ($('.form-input-styled').length > 0) {
        $('.form-input-styled').uniform();
    }
});
</script>
@endsection