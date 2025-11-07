@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Edit Peran - Manajemen Peran - ' . cms_name())
@section('page_title', 'Edit Peran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Peran: {{ $role->name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Peran *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $role->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Gunakan huruf, angka, dan garis bawah saja</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description', $role->description) }}</textarea>
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
                                        <option value="read" {{ in_array('read', old('permissions', $role->permissions ?? [])) ? 'selected' : '' }}>Baca</option>
                                        <option value="create" {{ in_array('create', old('permissions', $role->permissions ?? [])) ? 'selected' : '' }}>Buat</option>
                                        <option value="update" {{ in_array('update', old('permissions', $role->permissions ?? [])) ? 'selected' : '' }}>Ubah</option>
                                        <option value="delete" {{ in_array('delete', old('permissions', $role->permissions ?? [])) ? 'selected' : '' }}>Hapus</option>
                                        <option value="manage_users" {{ in_array('manage_users', old('permissions', $role->permissions ?? [])) ? 'selected' : '' }}>Kelola Pengguna</option>
                                        <option value="manage_content" {{ in_array('manage_content', old('permissions', $role->permissions ?? [])) ? 'selected' : '' }}>Kelola Konten</option>
                                        <option value="manage_settings" {{ in_array('manage_settings', old('permissions', $role->permissions ?? [])) ? 'selected' : '' }}>Kelola Pengaturan</option>
                                        <option value="access_panel" {{ in_array('access_panel', old('permissions', $role->permissions ?? [])) ? 'selected' : '' }}>Akses Panel</option>
                                        <option value="manage_plugins" {{ in_array('manage_plugins', old('permissions', $role->permissions ?? [])) ? 'selected' : '' }}>Kelola Plugin</option>
                                        <option value="manage_themes" {{ in_array('manage_themes', old('permissions', $role->permissions ?? [])) ? 'selected' : '' }}>Kelola Tema</option>
                                    </select>
                                    @error('permissions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Pilih izin akses yang diperlukan (boleh lebih dari satu)</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Peran</button>
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