@if($popularNews && $popularNews->count() > 0)
<div class="widget widget-popular-news">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Berita Populer</h4>
        </div>
        <div class="card-body p-0">
            <div class="list-unstyled mb-0">
                @foreach($popularNews as $index => $news)
                    <div class="border-bottom p-2 {{ $index == 0 ? 'bg-light' : '' }}">
                        <a href="{{ route('panel.berita.show', $news->id) }}" class="d-block text-decoration-none">
                            <small class="text-muted float-right">
                                <i class="fas fa-eye mr-1"></i> {{ number_format($news->viewer) }}
                            </small>
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
    <p>Belum ada berita populer.</p>
</div>
@endif