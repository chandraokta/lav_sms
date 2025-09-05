@extends('layouts.master')

@section('page_title', 'Kelola Pengguna')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white header-elements-inline">
                    <h4 class="card-title mb-0"><i class="icon-users mr-2"></i> Kelola Pengguna</h4>
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
                            <a href="#new-user" class="nav-link active rounded-pill mr-2" data-toggle="tab">
                                <i class="icon-user-plus mr-2"></i> Tambah Pengguna
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle rounded-pill" data-toggle="dropdown">
                                <i class="icon-list mr-2"></i> Kelola Pengguna
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach($user_types as $ut)
                                    <a href="#ut-{{ Qs::hash($ut->id) }}" class="dropdown-item" data-toggle="tab">{{ $ut->name }}s</a>
                                @endforeach
                            </div>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="new-user">
                            <form method="post" enctype="multipart/form-data" class="wizard-form steps-validation ajax-store" action="{{ route('users.store') }}" data-fouc>
                                @csrf
                                <h6>Data Pribadi</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap: <span class="text-danger">*</span></label>
                                                <input value="{{ old('name') }}" required type="text" name="name" placeholder="Nama Lengkap" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email: <span class="text-danger">*</span></label>
                                                <input value="{{ old('email') }}" required type="email" name="email" class="form-control" placeholder="Email Address">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Kelamin: <span class="text-danger">*</span></label>
                                                <select required data-placeholder="Pilih..." name="gender" class="form-control select">
                                                    <option value=""></option>
                                                    <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">Laki-laki</option>
                                                    <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Telepon:</label>
                                                <input value="{{ old('phone') }}" type="text" name="phone" class="form-control" placeholder="Telepon">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alamat:</label>
                                                <input value="{{ old('address') }}" type="text" name="address" class="form-control" placeholder="Alamat">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Foto:</label>
                                                <input accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <h6>Data Akun</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tipe Pengguna: <span class="text-danger">*</span></label>
                                                <select required name="user_type" class="form-control select">
                                                    <option value="">Pilih...</option>
                                                    @foreach($user_types as $ut)
                                                        <option {{ (old('user_type') == $ut->title) ? 'selected' : '' }} value="{{ $ut->title }}">{{ $ut->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Username:</label>
                                                <input value="{{ old('username') }}" type="text" name="username" class="form-control" placeholder="Username">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                                        <i class="icon-user-plus mr-2"></i> Tambah Pengguna
                                    </button>
                                </div>
                            </form>
                        </div>

                        @foreach($user_types as $ut)
                            <div class="tab-pane fade" id="ut-{{ Qs::hash($ut->id) }}">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white header-elements-inline">
                                        <h5 class="card-title mb-0"><i class="icon-users mr-2"></i> {{ $ut->name }}s</h5>
                                        <div class="header-elements">
                                            <div class="list-icons">
                                                <a class="list-icons-item text-white" data-action="collapse"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $users = $users->where('user_type', $ut->title);
                                        @endphp
                                        
                                        @if($users->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped datatable-button-html5-columns">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th class="text-center" width="5%">No</th>
                                                            <th>Nama Pengguna</th>
                                                            <th class="text-center">Email</th>
                                                            <th class="text-center">Telepon</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($users as $user)
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="mr-3">
                                                                            @if($user->photo && $user->photo != Qs::getDefaultUserImage())
                                                                                <img src="{{ $user->photo }}" class="rounded-circle" width="32" height="32" alt="photo">
                                                                            @else
                                                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                                    <i class="icon-user text-white"></i>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div>
                                                                            <span class="font-weight-semibold">{{ $user->name }}</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">{{ $user->email ?? 'N/A' }}</td>
                                                                <td class="text-center">{{ $user->phone ?? 'N/A' }}</td>
                                                                <td class="text-center">
                                                                    <div class="list-icons">
                                                                        <div class="dropdown">
                                                                            <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown">
                                                                                <i class="icon-menu9"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a href="{{ route('users.edit', Qs::hash($user->id)) }}" class="dropdown-item">
                                                                                    <i class="icon-pencil7"></i> Edit
                                                                                </a>
                                                                                <a href="{{ route('users.reset_pass', Qs::hash($user->id)) }}" class="dropdown-item">
                                                                                    <i class="icon-lock"></i> Reset Password
                                                                                </a>
                                                                                <a href="#" data-id="{{ Qs::hash($user->id) }}" data-name="{{ $user->name }}" data-toggle="modal" data-target="#delete-user-modal" class="dropdown-item delete-user">
                                                                                    <i class="icon-trash"></i> Hapus
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info text-center rounded-lg">
                                                <i class="icon-info22 mr-2"></i> 
                                                <strong>Informasi:</strong> Tidak ada {{ strtolower($ut->name) }} yang tersedia.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete-user-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="icon-trash mr-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pengguna <strong id="delete-user-name"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form method="post" id="delete-user-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTables for all user tables
    $('.datatable-button-html5-columns').each(function() {
        if (!$(this).hasClass('dataTable')) {
            $(this).DataTable({
                buttons: [
                    { extend: 'copyHtml5', className: 'btn btn-light' },
                    { extend: 'csvHtml5', className: 'btn btn-light' },
                    { extend: 'excelHtml5', className: 'btn btn-light' },
                    { extend: 'pdfHtml5', className: 'btn btn-light' },
                    { extend: 'print', className: 'btn btn-light' }
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"B>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                responsive: true,
                pageLength: 25,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
                }
            });
        }
    });
    
    // Set up delete modal
    $('.delete-user').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#delete-user-name').text(name);
        $('#delete-user-form').attr('action', '{{ route('users.destroy', '') }}/' + id);
    });
    
    // Initialize select2 for better dropdowns
    if ($('.select').length > 0) {
        $('.select').select2({
            minimumResultsForSearch: Infinity
        });
    }
    
    // Initialize form styled elements
    if ($('.form-input-styled').length > 0) {
        $('.form-input-styled').uniform();
    }
});
</script>
@endsection