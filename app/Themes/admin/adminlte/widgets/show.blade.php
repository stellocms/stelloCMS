@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Detail Widget - ' . cms_name())
@section('page_title', 'Detail Widget')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Widget</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label>ID:</label>
                        <p class="form-control-plaintext">{{ $widget->id }}</p>
                    </div>

                    <div class="form-group">
                        <label>Nama:</label>
                        <p class="form-control-plaintext">{{ $widget->name }}</p>
                    </div>

                    <div class="form-group">
                        <label>Tipe:</label>
                        <p class="form-control-plaintext">
                            <span class="badge badge-{{ $widget->type === 'plugin' ? 'info' : ($widget->type === 'text' ? 'warning' : 'success') }}">
                                {{ ucfirst($widget->type) }}
                            </span>
                        </p>
                    </div>

                    <div class="form-group">
                        <label>Posisi:</label>
                        <p class="form-control-plaintext"><span class="badge badge-secondary">{{ $widget->position }}</span></p>
                    </div>

                    <div class="form-group">
                        <label>Status:</label>
                        <p class="form-control-plaintext">
                            <span class="badge {{ $widget->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                {{ $widget->status }}
                            </span>
                        </p>
                    </div>

                    <div class="form-group">
                        <label>Nama Plugin:</label>
                        <p class="form-control-plaintext">{{ $widget->plugin_name ?: '-' }}</p>
                    </div>

                    <div class="form-group">
                        <label>Urutan:</label>
                        <p class="form-control-plaintext">{{ $widget->order }}</p>
                    </div>

                    @if($widget->content)
                    <div class="form-group">
                        <label>Konten:</label>
                        <div class="form-control-plaintext" style="white-space: pre-wrap;">{{ $widget->content }}</div>
                    </div>
                    @endif

                    @if($widget->settings)
                    <div class="form-group">
                        <label>Pengaturan:</label>
                        <pre class="form-control-plaintext">{{ json_encode($widget->settings, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif

                    <div class="form-group">
                        <label>Dibuat pada:</label>
                        <p class="form-control-plaintext">{{ $widget->created_at->format('d-m-Y H:i:s') }}</p>
                    </div>

                    <div class="form-group">
                        <label>Diupdate pada:</label>
                        <p class="form-control-plaintext">{{ $widget->updated_at->format('d-m-Y H:i:s') }}</p>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('panel.widgets.edit', $widget->id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('panel.widgets.index') }}" class="btn btn-default">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection