@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Detail Berita - ' . cms_name())
@section('page_title', 'Detail Berita')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Berita</h3>
                    <div class="card-tools">
                        <a href="{{ route('berita.edit', $berita->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('berita.destroy', $berita->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</button>
                        </form>
                        <a href="{{ route('berita.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <h4>{{ $berita->judul }}</h4>
                    <p class="text-muted">{{ $berita->tanggal_publikasi->format('d M Y') }}</p>
                    
                    @if($berita->gambar)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" class="img-fluid rounded">
                        </div>
                    @endif
                    
                    <div class="berita-content">
                        {!! $berita->isi !!}
                    </div>
                    
                    <div class="mt-4">
                        <span class="badge {{ $berita->aktif ? 'badge-success' : 'badge-warning' }}">
                            {{ $berita->aktif ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <small class="text-muted">Dipublikasikan oleh: {{ $berita->user->name ?? 'Admin' }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
.berita-content img {
    max-width: 100%;
    height: auto;
}
</style>
@endsection