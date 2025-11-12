@if($randomNews && $randomNews->count() > 0)
<div class="widget widget-random-news">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Berita Acak</h4>
        </div>
        <div class="card-body p-0">
            @foreach($randomNews as $news)
            <div class="p-2">
                @if($news->gambar)
                <div class="text-center mb-2">
                    <a href="{{ route('panel.berita.show', $news->id) }}">
                        <img src="{{ asset('storage/' . $news->gambar) }}" alt="{{ $news->judul }}" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                    </a>
                </div>
                @endif
                <a href="{{ route('panel.berita.show', $news->id) }}" class="d-block text-decoration-none">
                    <h6 class="mb-1">{{ Str::limit(strip_tags($news->judul), 60) }}</h6>
                    <small class="text-muted">{{ $news->tanggal_publikasi->format('d M Y') }}</small>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <h5><i class="icon fas fa-info"></i> Informasi!</h5>
    <p>Tidak ada berita dengan gambar tersedia.</p>
</div>
@endif