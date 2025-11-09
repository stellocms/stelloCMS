@extends('theme.frontend.' . config('themes.frontend') . '::layouts.app')

@section('title', $contohPlugin->judul . ' - Contoh Plugin - ' . cms_name())
@section('description', Str::limit(strip_tags($contohPlugin->deskripsi), 160))

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('contohplugin.frontpage.index') }}">Contoh Plugin</a></li>
                    <li class="breadcrumb-item active">{{ $contohPlugin->judul }}</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <article>
                <h1>{{ $contohPlugin->judul }}</h1>
                
                <div class="meta mb-3">
                    <small class="text-muted">
                        Dipublikasikan: {{ $contohPlugin->tanggal_dibuat ? $contohPlugin->tanggal_dibuat->format('d M Y') : '-' }}
                    </small>
                </div>
                
                @if($contohPlugin->gambar)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $contohPlugin->gambar) }}" 
                             class="img-fluid" 
                             alt="{{ $contohPlugin->judul }}">
                    </div>
                @endif
                
                <div class="content">
                    {!! $contohPlugin->deskripsi !!}
                </div>
            </article>
            
            <div class="mt-4">
                <a href="{{ route('contohplugin.frontpage.index') }}" class="btn btn-secondary">
                    &laquo; Kembali ke Daftar
                </a>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Info Plugin</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Ini adalah halaman detail dari Contoh Plugin yang ditampilkan 
                        di sisi frontend.
                    </p>
                    
                    <h6>Status:</h6>
                    <span class="badge 
                        {{ $contohPlugin->aktif ? 'badge-success' : 'badge-warning' }}">
                        {{ $contohPlugin->aktif ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection