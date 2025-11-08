@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Manajemen Contoh Plugin - ' . cms_name())
@section('page_title', 'Manajemen Contoh Plugin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Contoh Plugin</h3>
                    <div class="card-tools">
                        <a href="{{ route('contohplugin.create') }}" class="btn btn-primary">Tambah Contoh Plugin</a>
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
                    
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Deskripsi Singkat</th>
                                <th>Tanggal Dibuat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contohPlugins as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ Str::limit(strip_tags($item->deskripsi), 100) }}</td>
                                <td>{{ $item->tanggal_dibuat->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $item->aktif ? 'badge-success' : 'badge-warning' }}">
                                        {{ $item->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('contohplugin.show', $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="{{ route('contohplugin.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('contohplugin.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus contoh plugin ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada contoh plugin ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $contohPlugins->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection