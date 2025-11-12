@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Tambah Widget - ' . cms_name())
@section('page_title', 'Tambah Widget')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Widget Baru</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ route('panel.widgets.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Widget</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">Tipe Widget</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="plugin" {{ old('type') === 'plugin' ? 'selected' : '' }}>Plugin</option>
                                <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>Text</option>
                                <option value="html" {{ old('type') === 'html' ? 'selected' : '' }}>HTML</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="position">Posisi</label>
                            <select class="form-control @error('position') is-invalid @enderror" id="position" name="position" required>
                                <option value="">-- Pilih Posisi --</option>
                                <option value="header" {{ old('position') === 'header' ? 'selected' : '' }}>Header</option>
                                <option value="sidebar-left" {{ old('position') === 'sidebar-left' ? 'selected' : '' }}>Sidebar Kiri</option>
                                <option value="sidebar-right" {{ old('position') === 'sidebar-right' ? 'selected' : '' }}>Sidebar Kanan</option>
                                <option value="footer" {{ old('position') === 'footer' ? 'selected' : '' }}>Footer</option>
                                <option value="home" {{ old('position') === 'home' ? 'selected' : '' }}>Home</option>
                            </select>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="plugin_name_group" style="display: none;">
                            <label for="plugin_name">Nama Plugin (jika tipe plugin)</label>
                            <input type="text" class="form-control @error('plugin_name') is-invalid @enderror" id="plugin_name" name="plugin_name" value="{{ old('plugin_name') }}">
                            @error('plugin_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="content_group" style="display: none;">
                            <label for="content">Konten (jika tipe text atau html)</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="order">Urutan</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', 0) }}">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="settings">Pengaturan (JSON)</label>
                            <textarea class="form-control @error('settings') is-invalid @enderror" id="settings" name="settings" rows="3" placeholder='{"key": "value"}'>{{ old('settings') ? json_encode(old('settings')) : '' }}</textarea>
                            @error('settings')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('panel.widgets.index') }}" class="btn btn-default">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const pluginNameGroup = document.getElementById('plugin_name_group');
    const contentGroup = document.getElementById('content_group');

    function updateFieldsVisibility() {
        const selectedType = typeSelect.value;
        
        if (selectedType === 'plugin') {
            pluginNameGroup.style.display = 'block';
            contentGroup.style.display = 'none';
        } else if (selectedType === 'text' || selectedType === 'html') {
            pluginNameGroup.style.display = 'none';
            contentGroup.style.display = 'block';
        } else {
            pluginNameGroup.style.display = 'none';
            contentGroup.style.display = 'none';
        }
    }

    typeSelect.addEventListener('change', updateFieldsVisibility);
    updateFieldsVisibility(); // Initialize on page load
});
</script>
@endsection
@endsection