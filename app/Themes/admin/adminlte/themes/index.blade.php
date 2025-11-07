@extends('theme.admin.adminlte::layouts.app')

@section('page_title', 'Manajemen Tema')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Tema</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#uploadThemeModal">
                            <i class="fas fa-upload"></i> Upload Tema
                        </button>
                        <a href="{{ route('themes.scan.get') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-sync"></i> Scan Tema
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <h4>Tema Frontend</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Versi</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($frontendThemes as $theme)
                            <tr>
                                <td>{{ $theme->name }}</td>
                                <td>{{ $theme->version ?? 'N/A' }}</td>
                                <td>{{ $theme->description ?? 'No description' }}</td>
                                <td>
                                    @if($theme->is_default)
                                        <span class="badge badge-primary">Default</span>
                                    @elseif($theme->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($theme->is_installed)
                                        @if(!$theme->is_default)
                                            <form method="POST" action="{{ route('themes.set_default', ['type' => 'frontend', 'name' => $theme->name]) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Yakin ingin menjadikan tema ini sebagai default?')">Jadikan Default</button>
                                            </form>
                                        @endif
                                        @if($theme->is_active)
                                            <form method="POST" action="{{ route('themes.deactivate', ['type' => 'frontend', 'name' => $theme->name]) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Yakin ingin menonaktifkan tema ini?')">Nonaktifkan</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('themes.activate', ['type' => 'frontend', 'name' => $theme->name]) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Yakin ingin mengaktifkan tema ini?')">Aktifkan</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('themes.uninstall', ['type' => 'frontend', 'name' => $theme->name]) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus tema ini?')">Uninstall</button>
                                        </form>
                                    @else
                                        <a href="{{ route('themes.install', ['type' => 'frontend', 'name' => $theme->name]) }}" class="btn btn-sm btn-outline-info">Install</a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada tema frontend ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <h4 class="mt-4">Tema Admin</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Versi</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($adminThemes as $theme)
                            <tr>
                                <td>{{ $theme->name }}</td>
                                <td>{{ $theme->version ?? 'N/A' }}</td>
                                <td>{{ $theme->description ?? 'No description' }}</td>
                                <td>
                                    @if($theme->is_default)
                                        <span class="badge badge-primary">Default</span>
                                    @elseif($theme->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($theme->is_installed)
                                        @if(!$theme->is_default)
                                            <form method="POST" action="{{ route('themes.set_default', ['type' => 'admin', 'name' => $theme->name]) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Yakin ingin menjadikan tema ini sebagai default?')">Jadikan Default</button>
                                            </form>
                                        @endif
                                        @if($theme->is_active)
                                            <form method="POST" action="{{ route('themes.deactivate', ['type' => 'admin', 'name' => $theme->name]) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Yakin ingin menonaktifkan tema ini?')">Nonaktifkan</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('themes.activate', ['type' => 'admin', 'name' => $theme->name]) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Yakin ingin mengaktifkan tema ini?')">Aktifkan</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('themes.uninstall', ['type' => 'admin', 'name' => $theme->name]) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus tema ini?')">Uninstall</button>
                                        </form>
                                    @else
                                        <a href="{{ route('themes.install', ['type' => 'admin', 'name' => $theme->name]) }}" class="btn btn-sm btn-outline-info">Install</a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada tema admin ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<!-- Upload Theme Modal -->
<div class="modal fade" id="uploadThemeModal" tabindex="-1" role="dialog" aria-labelledby="uploadThemeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('themes.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadThemeModalLabel">Upload Tema Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="theme_file">Pilih File ZIP Tema</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="theme_file" name="theme_file" accept=".zip" required>
                                <label class="custom-file-label" for="theme_file">Pilih file...</label>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            File harus berupa ZIP yang berisi struktur tema yang benar.<br>
                            Format: nama_tema.zip/nama_tema/{files}<br>
                            Contoh: therapy.zip/therapy/{files}
                        </small>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="extract_public" name="extract_public" checked>
                            <label class="form-check-label" for="extract_public">Ekstrak file public juga (CSS, JS, gambar)</label>
                        </div>
                        <small class="form-text text-muted">
                            Centang ini jika tema Anda memiliki file aset (CSS, JS, gambar) yang perlu diekstrak ke public/themes/
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload Tema
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update file label saat memilih file -->
<script>
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>
@endsection