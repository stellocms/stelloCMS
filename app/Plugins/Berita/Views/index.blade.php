@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Manajemen Berita - ' . cms_name())
@section('page_title', 'Manajemen Berita')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Berita</h3>
                    <div class="card-tools">
                        <a href="{{ in_array('panel.berita.create', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.berita.create') : url('/panel/berita/create') }}" class="btn btn-primary">Tambah Berita</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Ringkasan</th>
                                <th>Tanggal Publikasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($berita as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ Str::limit(strip_tags($item->isi), 100) }}</td>
                                <td>{{ $item->tanggal_publikasi->format('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $item->aktif ? 'badge-success' : 'badge-warning' }}">
                                        {{ $item->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ in_array('panel.berita.show', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.berita.show', $item->id) : url('/panel/berita/' . $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="{{ in_array('panel.berita.edit', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.berita.edit', $item->id) : url('/panel/berita/' . $item->id . '/edit') }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ in_array('panel.berita.destroy', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.berita.destroy', $item->id) : url('/panel/berita/' . $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada berita ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $berita->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection