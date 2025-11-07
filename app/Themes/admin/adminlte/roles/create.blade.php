@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Tambah Peran - Manajemen Peran - ' . cms_name())
@section('page_title', 'Tambah Peran Baru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Peran Baru</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Peran *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Gunakan huruf, angka, dan garis bawah saja</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="permissions">Izin Akses</label>
                                    <select multiple class="form-control @error('permissions') is-invalid @enderror" 
                                            id="permissions" name="permissions[]">
                                        <option value="read">Baca</option>
                                        <option value="create">Buat</option>
                                        <option value="update">Ubah</option>
                                        <option value="delete">Hapus</option>
                                        <option value="manage_users">Kelola Pengguna</option>
                                        <option value="manage_content">Kelola Konten</option>
                                        <option value="manage_settings">Kelola Pengaturan</option>
                                        <option value="access_panel">Akses Panel</option>
                                        <option value="manage_plugins">Kelola Plugin</option>
                                        <option value="manage_themes">Kelola Tema</option>
                                    </select>
                                    @error('permissions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Pilih izin akses yang diperlukan (boleh lebih dari satu)</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan Peran</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize select2 or similar for better UX if needed
    $('#permissions').select2({
        placeholder: "Pilih izin akses...",
        allowClear: true
    });
});
</script>
@endsection