@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Edit Kategori - ' . cms_name())
@section('page_title', 'Edit Kategori')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Kategori</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ in_array('panel.kategori.update', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.kategori.update', $kategori->id) : url('/panel/kategori/' . $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi (opsional)</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="warna">Warna (opsional)</label>
                            <input type="color" class="form-control @error('warna') is-invalid @enderror" id="warna" name="warna" value="{{ old('warna', $kategori->warna) }}">
                            @error('warna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="ikon">Ikon Font Awesome (opsional)</label>
                            <input type="text" class="form-control @error('ikon') is-invalid @enderror" id="ikon" name="ikon" value="{{ old('ikon', $kategori->ikon) }}" placeholder="e.g. fas fa-tag, far fa-bookmark, etc.">
                            @error('ikon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="aktif" name="aktif" value="1" {{ old('aktif', $kategori->aktif) ? 'checked' : '' }}>
                                <label for="aktif">Aktifkan Kategori</label>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ in_array('panel.kategori.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.kategori.index') : url('/panel/kategori') }}" class="btn btn-default">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection