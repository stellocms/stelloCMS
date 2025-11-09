@extends('theme.frontend.' . config('themes.frontend') . '::layouts.app')

@section('title', 'Contoh Plugin - ' . cms_name())
@section('description', 'Halaman publik untuk plugin Contoh Plugin')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Contoh Plugin</h1>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Item dari Contoh Plugin</h5>
                    
                    @if($contohPlugins && $contohPlugins->count() > 0)
                        <div class="row">
                            @foreach($contohPlugins as $item)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        @if($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $item->judul }}"
                                                 style="height: 200px; object-fit: cover;">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->judul }}</h5>
                                            <p class="card-text">
                                                {!! Str::limit(strip_tags($item->deskripsi), 100) !!}
                                            </p>
                                            <p class="text-muted">
                                                <small>Dipublikasikan: {{ $item->tanggal_dibuat ? $item->tanggal_dibuat->format('d M Y') : '-' }}</small>
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('contohplugin.frontpage.show', $item->slug) }}" 
                                               class="btn btn-primary btn-sm">Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $contohPlugins->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>Belum ada data dalam Contoh Plugin.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection