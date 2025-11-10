@extends('theme.frontend.' . config('themes.frontend') . '::layouts.app')

@section('title', $berita->judul . ' - ' . cms_name())
@section('description', Str::limit(strip_tags($berita->isi), 160))

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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ in_array('home', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('home') : url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ in_array('berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('berita.index') : url('/berita') }}">Berita</a></li>
                    <li class="breadcrumb-item active">{{ $berita->judul }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <article>
                <h1>{{ $berita->judul }}</h1>

                <div class="meta mb-3">
                    <small class="text-muted">
                        Dipublikasikan: {{ $berita->tanggal_publikasi ? $berita->tanggal_publikasi->format('d M Y') : '-' }}
                        @if($berita->user)
                            oleh {{ $berita->user->name }}
                        @endif
                    </small>
                </div>

                @if($berita->gambar)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $berita->gambar) }}"
                             class="img-fluid"
                             alt="{{ $berita->judul }}">
                    </div>
                @endif

                <div class="content">
                    {!! $berita->isi !!}
                </div>
            </article>

            <div class="mt-4">
                <a href="{{ in_array('berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('berita.index') : url('/berita') }}" class="btn btn-secondary">
                    &laquo; Kembali ke Daftar Berita
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Info Berita</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Ini adalah halaman detail berita yang ditampilkan
                        di sisi frontend.
                    </p>

                    <h6>Status:</h6>
                    <span class="badge
                        {{ $berita->aktif ? 'badge-success' : 'badge-warning' }}">
                        {{ $berita->aktif ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection