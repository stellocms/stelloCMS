@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Manajemen Plugin - ' . cms_name())
@section('page_title', 'Manajemen Plugin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Plugin</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#uploadPluginModal">
                            <i class="fas fa-upload"></i> Upload Plugin
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
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
                    
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plugins as $plugin)
                            <tr>
                                <td>
                                    <strong>
                                        @if(!empty($plugin['metadata']['name']))
                                            {{ $plugin['metadata']['name'] }}
                                        @else
                                            {{ $plugin['title'] ?? $plugin['name'] }}
                                        @endif
                                    </strong>
                                    @if(!empty($plugin['metadata']['version']))
                                        <br><small class="text-muted">v{{ $plugin['metadata']['version'] }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($plugin['metadata']['description']))
                                        {{ $plugin['metadata']['description'] }}
                                    @elseif(!empty($plugin['title']))
                                        {{ $plugin['title'] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($plugin['installed'])
                                        <span class="badge {{ $plugin['active'] ? 'badge-success' : 'badge-warning' }}">
                                            {{ $plugin['active'] ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">Belum terinstal</span>
                                    @endif
                                </td>
                                <td>
                                    @if($plugin['installed'])
                                        @if($plugin['active'])
                                            <form action="{{ route('plugins.deactivate', $plugin['name']) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" 
                                                        onclick="return confirm('Yakin ingin menonaktifkan plugin ini?')">Nonaktifkan</button>
                                            </form>
                                        @else
                                            <form action="{{ route('plugins.activate', $plugin['name']) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Aktifkan</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('plugins.uninstall', $plugin['name']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus plugin ini?')">Hapus</button>
                                        </form>
                                    @else
                                        <form action="{{ route('plugins.install', $plugin['name']) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Instal</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<!-- Upload Plugin Modal -->
<div class="modal fade" id="uploadPluginModal" tabindex="-1" role="dialog" aria-labelledby="uploadPluginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('plugins.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadPluginModalLabel">Upload Plugin Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="plugin_file">Pilih File ZIP Plugin</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="plugin_file" name="plugin_file" accept=".zip" required>
                                <label class="custom-file-label" for="plugin_file">Pilih file...</label>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            File harus berupa ZIP yang berisi struktur plugin yang benar.<br>
                            Format: nama_plugin.zip/nama_plugin/{files}<br>
                            Contoh: berita.zip/Berita/{files}
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload Plugin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update file label saat memilih file -->
<script>
document.querySelector('#plugin_file').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>
@endsection