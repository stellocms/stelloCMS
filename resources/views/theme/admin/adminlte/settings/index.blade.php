@extends('theme.admin.adminlte::layouts.app')

@section('title', 'Manajemen Pengaturan - ' . cms_name())
@section('page_title', 'Manajemen Pengaturan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengaturan</h3>
                    <div class="card-tools">
                        <a href="{{ route('setting.create') }}" class="btn btn-primary">Tambah Pengaturan</a>
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
                                <th>Nama Pengaturan</th>
                                <th>Nilai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($settings as $setting)
                            <tr>
                                <td>{{ $setting->id }}</td>
                                <td>{{ $setting->pengaturan }}</td>
                                <td>{{ Str::limit(strip_tags($setting->nilai), 100) }}</td>
                                <td>
                                    <span class="badge {{ $setting->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $setting->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('setting.edit', $setting->id) }}" class="btn btn-xs btn-primary">Edit</a>
                                    <form action="{{ route('setting.destroy', $setting->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Yakin ingin menghapus pengaturan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada pengaturan ditemukan</td>
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
@endsection