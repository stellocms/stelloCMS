@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Detail Contoh Plugin - ' . cms_name())
@section('page_title', 'Detail Contoh Plugin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail: {{ $contohPlugin->judul }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('contohplugin.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ID</label>
                                <p>{{ $contohPlugin->id }}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Judul</label>
                                <p>{{ $contohPlugin->judul }}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Tanggal Dibuat</label>
                                <p>{{ $contohPlugin->tanggal_dibuat ? $contohPlugin->tanggal_dibuat->format('d M Y H:i') : '-' }}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Status</label>
                                <p>
                                    <span class="badge {{ $contohPlugin->aktif ? 'badge-success' : 'badge-warning' }}">
                                        {{ $contohPlugin->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gambar</label>
                                @if($contohPlugin->gambar)
                                    <div>
                                        <img src="{{ asset('storage/' . $contohPlugin->gambar) }}" alt="Gambar" class="img-fluid" style="max-height: 200px;">
                                    </div>
                                @else
                                    <p>Tidak ada gambar</p>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <div class="card">
                                    <div class="card-body">
                                        {!! $contohPlugin->deskripsi !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('contohplugin.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                    <a href="{{ route('contohplugin.edit', $contohPlugin->id) }}" class="btn btn-primary">Edit</a>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection