@extends('theme.frontend.kind_heart::layouts.app')

@section('content')
<!-- Home page content for the Kind Heart Charity theme -->
<div class="preloader">
    <div class="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

<main>
    <!-- Hero section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="hero-block">
                        <h1 class="mb-5">SimPeDe - Sistem Pengelolaan Desa</h1>
                        <p class="mb-lg-4 mb-2">Platform terpadu untuk manajemen desa yang efektif dan transparan</p>
                        <a href="{{ url('/panel') }}" class="btn btn-primary">Masuk Panel</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features section -->
    <section class="features-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <h2 class="mb-5 text-center">Fitur Utama</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="feature-card">
                        <h4>Manajemen Warga</h4>
                        <p>Pencatatan data penduduk desa secara terstruktur dan akurat</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="feature-card">
                        <h4>Keuangan Desa</h4>
                        <p>Pengelolaan anggaran dan laporan keuangan desa secara transparan</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="feature-card">
                        <h4>Layanan Publik</h4>
                        <p>Pelayanan administrasi dan permohonan dokumen secara digital</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection