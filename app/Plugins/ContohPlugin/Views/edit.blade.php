@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Edit Contoh Plugin - Manajemen Contoh Plugin - ' . cms_name())
@section('page_title', 'Edit Contoh Plugin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Contoh Plugin: {{ $contohPlugin->judul }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ in_array('panel.contohplugin.update', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.contohplugin.update', $contohPlugin->id) : url('/panel/contohplugin/' . $contohPlugin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul">Judul *</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                           id="judul" name="judul" value="{{ old('judul', $contohPlugin->judul) }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="gambar">Gambar</label>
                                    @if($contohPlugin->gambar)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $contohPlugin->gambar) }}" 
                                                 alt="Current image" style="max-width: 200px; max-height: 200px;">
                                        </div>
                                    @endif
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror" 
                                                   id="gambar" name="gambar">
                                            <label class="custom-file-label" for="gambar">Pilih gambar baru...</label>
                                        </div>
                                    </div>
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Format: jpeg, png, jpg, gif. Ukuran maks: 2MB (kosongkan jika tidak ingin mengganti)</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aktif">Status</label>
                                    <select class="form-control @error('aktif') is-invalid @enderror" 
                                            id="aktif" name="aktif" required>
                                        <option value="1" {{ old('aktif', $contohPlugin->aktif) ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('aktif', $contohPlugin->aktif) === 0 ? 'selected' : '' }}>Tidak Aktif</option>
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
                                      id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $contohPlugin->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Contoh Plugin</button>
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