@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Tambah Contoh Plugin - Manajemen Contoh Plugin - ' . cms_name())
@section('page_title', 'Tambah Contoh Plugin Baru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Contoh Plugin Baru</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ in_array('panel.contohplugin.store', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.contohplugin.store') : url('/panel/contohplugin') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul">Judul *</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                           id="judul" name="judul" value="{{ old('judul') }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="gambar">Gambar</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror" 
                                                   id="gambar" name="gambar">
                                            <label class="custom-file-label" for="gambar">Pilih gambar...</label>
                                        </div>
                                    </div>
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Format: jpeg, png, jpg, gif. Ukuran maks: 2MB</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aktif">Status</label>
                                    <select class="form-control @error('aktif') is-invalid @enderror" 
                                            id="aktif" name="aktif" required>
                                        <option value="1" {{ old('aktif', 1) ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('aktif') === 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('aktif')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi *</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan Contoh Plugin</button>
                            <a href="{{ in_array('panel.contohplugin.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.contohplugin.index') : url('/panel/contohplugin') }}" class="btn btn-secondary">Batal</a>
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

@push('scripts')
<script>
$(document).ready(function() {
    // Update file label when file is selected
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });
});
</script>
@endpush