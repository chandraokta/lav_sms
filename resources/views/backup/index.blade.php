@extends('layouts.master')
@section('page_title', 'Backup Database')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title font-weight-bold text-primary"><i class="icon-database mr-2"></i>Backup Database</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="alert alert-info border-0 alert-dismissible rounded-lg">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            <h5 class="alert-heading font-weight-bold"><i class="icon-info22 mr-2"></i> Informasi Penting</h5>
            <p class="mb-0">Backup database secara rutin sangat penting untuk melindungi data sekolah Anda. Gunakan alat ini untuk membuat, mengunduh, mengelola, dan mengimpor backup database.</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-primary border-2 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0"><i class="icon-plus2 mr-2"></i>Buat Backup Baru</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('backup.store') }}">
                            @csrf
                            <div class="text-center">
                                <p class="mb-3">Klik tombol di bawah ini untuk membuat backup database baru.</p>
                                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">
                                    <i class="icon-database mr-2"></i>Buat Backup
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-success border-2 rounded-lg">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0"><i class="icon-upload mr-2"></i>Impor Backup</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('backup.import') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="backup_file">Pilih File Backup (.sql):</label>
                                <input type="file" class="form-control-file" id="backup_file" name="backup_file" accept=".sql" required>
                            </div>
                            <div class="text-center">
                                <p class="mb-3">Pilih file backup untuk diimpor ke dalam database.</p>
                                <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill" onclick="return confirm('Apakah Anda yakin ingin mengimpor backup ini? Ini akan menimpa data yang ada.')">
                                    <i class="icon-upload mr-2"></i>Impor Backup
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card border-success border-2 rounded-lg">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0"><i class="icon-list mr-2"></i>Available Backups</h5>
                    </div>
                    <div class="card-body">
                        @if(count($backups) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover datatable-button-html5-columns">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Filename</th>
                                            <th>Size</th>
                                            <th>Date Created</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($backups as $index => $backup)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $backup['name'] }}</td>
                                                <td>{{ number_format($backup['size'] / 1024, 2) }} KB</td>
                                                <td>{{ date('d M Y H:i:s', $backup['modified']) }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="{{ route('backup.download', $backup['name']) }}" 
                                                           class="btn btn-success btn-sm rounded-pill mr-1" 
                                                           title="Download Backup">
                                                            <i class="icon-download"></i>
                                                        </a>
                                                        <a href="{{ route('backup.destroy', $backup['name']) }}" 
                                                           class="btn btn-danger btn-sm rounded-pill" 
                                                           title="Delete Backup"
                                                           onclick="return confirm('Are you sure you want to delete this backup? This action cannot be undone.')">
                                                            <i class="icon-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="icon-database icon-2x text-muted mb-3"></i>
                                <h5>No backups found</h5>
                                <p class="text-muted">Create your first backup using the button above.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card border-warning border-2 rounded-lg">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0"><i class="icon-warning mr-2"></i>Backup Best Practices</h5>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Create backups regularly (daily or weekly)</li>
                            <li>Store backups in a secure location</li>
                            <li>Test backup restoration periodically</li>
                            <li>Keep multiple versions of backups</li>
                            <li>Delete old backups to save storage space</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection