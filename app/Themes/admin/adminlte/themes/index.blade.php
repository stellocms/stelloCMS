@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Manajemen Tema - ' . cms_name())
@section('page_title', 'Manajemen Tema')

@section('content')
<div class="container-fluid">
    <!-- Admin Themes Row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tema Admin</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </div>
                    @endif
                    
                    <div class="row">
                        @foreach($adminThemes as $theme)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ ucfirst(str_replace(['-', '_'], ' ', $theme['name'])) }}</h3>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Tema admin untuk panel kontrol</p>
                                    @if($theme['active'])
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <form action="{{ route('themes.admin.switch') }}" method="POST" class="mt-2">
                                            @csrf
                                            <input type="hidden" name="theme" value="{{ $theme['name'] }}">
                                            <button type="submit" class="btn btn-primary btn-block">Gunakan</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Frontend Themes Row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tema Frontend</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($frontendThemes as $theme)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">{{ ucfirst(str_replace(['-', '_'], ' ', $theme['name'])) }}</h3>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Tema untuk tampilan pengunjung</p>
                                    @if($theme['active'])
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <form action="{{ route('themes.frontend.switch') }}" method="POST" class="mt-2">
                                            @csrf
                                            <input type="hidden" name="theme" value="{{ $theme['name'] }}">
                                            <button type="submit" class="btn btn-info btn-block">Gunakan</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection