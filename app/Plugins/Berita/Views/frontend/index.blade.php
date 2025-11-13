@extends('theme.frontend.' . config('themes.frontend') . '::layouts.app')

@section('title', 'Berita - ' . cms_name())
@section('description', 'Halaman publik untuk berita dan informasi')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                    Berita Terkini
                </span>
            </h1>
            <p class="mt-4 text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Temukan informasi terbaru dan terkini dari berbagai bidang
            </p>
        </div>

        @if($berita && $berita->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($berita as $item)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 card-hover border border-gray-200 dark:border-gray-700">
                    <div class="relative">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}"
                                 class="w-full h-48 object-cover"
                                 alt="{{ $item->judul }}">
                        @else
                            <div class="bg-gradient-to-r from-blue-400 to-indigo-600 w-full h-48 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                            Berita
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $item->tanggal_publikasi ? $item->tanggal_publikasi->format('d M Y') : '-' }}</span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                            {{ $item->judul }}
                        </h3>
                        
                        <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                            {!! Str::limit(strip_tags($item->isi), 120) !!}
                        </p>
                        
                        <div class="flex justify-between items-center">
                            <a href="{{ in_array('berita.show', array_keys(app('router')->getRoutes()->getRoutesByName())) ? route('berita.show', $item->slug) : url('/berita/' . $item->slug) }}"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Baca Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                            
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>{{ $item->viewer ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $berita->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 dark:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-2xl font-medium text-gray-900 dark:text-white">Belum ada berita</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Berita akan segera ditambahkan. Silakan kunjungi kembali nanti.
                </p>
            </div>
        @endif
    </div>
</div>

<style>
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection