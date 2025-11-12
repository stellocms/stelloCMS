@if($latestNews && $latestNews->count() > 0)
<div class="widget widget-latest-news">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Berita Terbaru</h4>
        </div>
        <div class="card-body p-0">
            <div class="list-unstyled mb-0">
                @foreach($latestNews as $index => $news)
                    <div class="border-bottom p-2 {{ $index == 0 ? 'bg-light' : '' }}">
                        <a href="{{ route('panel.berita.show', $news->id) }}" class="d-block text-decoration-none">
                            <small class="text-muted float-right">{{ $news->tanggal_publikasi->format('d M Y') }}</small>
                            <strong>{{ Str::limit(strip_tags($news->judul), 60) }}</strong>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <h5><i class="icon fas fa-info"></i> Informasi!</h5>
    <p>Belum ada berita yang diterbitkan.</p>
</div>
@endif