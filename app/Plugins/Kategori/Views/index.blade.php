@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Daftar Kategori - ' . cms_name())
@section('page_title', 'Daftar Kategori')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kategori Berita</h3>
                    <div class="card-tools">
                        <a href="{{ in_array('panel.kategori.create', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.kategori.create') : url('/panel/kategori/create') }}" class="btn btn-primary">Tambah Kategori</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Warna</th>
                                <th>Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategori as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nama_kategori }}</td>
                                <td>{{ Str::limit(strip_tags($item->deskripsi), 50) }}</td>
                                <td>
                                    <span class="badge" style="background-color: {{ $item->warna }};">{{ $item->warna }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $item->aktif ? 'badge-success' : 'badge-warning' }}">
                                        {{ $item->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ in_array('panel.kategori.show', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.kategori.show', $item->id) : url('/panel/kategori/' . $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="{{ in_array('panel.kategori.edit', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.kategori.edit', $item->id) : url('/panel/kategori/' . $item->id . '/edit') }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ in_array('panel.kategori.destroy', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('panel.kategori.destroy', $item->id) : url('/panel/kategori/' . $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada kategori ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $kategori->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection