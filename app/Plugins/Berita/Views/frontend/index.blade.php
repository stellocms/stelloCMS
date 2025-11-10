@extends('theme.frontend.' . config('themes.frontend') . '::layouts.app')

@section('title', 'Berita - ' . cms_name())
@section('description', 'Halaman publik untuk berita dan informasi')

@section('content')
<style>
.navbar-light .navbar-nav .nav-link, .sticky-top.navbar-light .navbar-nav .nav-link {
        padding: 10px 0;
        margin-left: 0;
        color: var(--bs-dark);
    }
</style>
<br>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Berita Terkini</h1>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Berita</h5>

                    @if($berita && $berita->count() > 0)
                        <div class="row">
                            @foreach($berita as $item)
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
                                                {!! Str::limit(strip_tags($item->isi), 100) !!}
                                            </p>
                                            <p class="text-muted">
                                                <small>Dipublikasikan: {{ $item->tanggal_publikasi ? $item->tanggal_publikasi->format('d M Y') : '-' }}</small>
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ in_array('berita.show', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('berita.show', $item->id) : url('/berita/' . $item->id) }}"
                                               class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $berita->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>Belum ada berita saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection