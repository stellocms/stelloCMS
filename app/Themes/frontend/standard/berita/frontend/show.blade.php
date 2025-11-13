@extends('theme.frontend.' . config('themes.frontend') . '::layouts.app')

@section('title')
{{ $berita->judul . ' - ' . cms_name() }}
@endsection

@section('description')
{{ Str::limit(strip_tags($berita->isi), 160) }}
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ array_key_exists('home', app('router')->getRoutes()->getRoutesByName()) ? route('home') : url('/') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.292a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ array_key_exists('berita.index', app('router')->getRoutes()->getRoutesByName()) ? route('berita.index') : url('/berita') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Berita</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ Str::limit($berita->judul, 20) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3">
                <article class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    @if($berita->gambar)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $berita->gambar) }}"
                                 class="w-full h-80 object-cover"
                                 alt="{{ $berita->judul }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        </div>
                    @endif
                    
                    <div class="p-6 md:p-8">
                        <div class="flex flex-wrap items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <div class="flex items-center mr-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $berita->tanggal_publikasi ? $berita->tanggal_publikasi->format('d M Y') : '-' }}</span>
                            </div>
                            
                            <div class="flex items-center mr-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>{{ $berita->user->name ?? 'Admin' }}</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>{{ $berita->viewer ?? 0 }} dilihat</span>
                            </div>
                        </div>
                        
                        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-6">
                            {{ $berita->judul }}
                        </h1>
                        
                        <div class="prose prose-indigo dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 berita-content">
                            {!! $berita->isi !!}
                        </div>
                    </div>
                </article>

                <div class="mt-8 flex justify-center lg:justify-start">
                    <a href="{{ array_key_exists('berita.index', app('router')->getRoutes()->getRoutesByName()) ? route('berita.index') : url('/berita') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar Berita
                    </a>
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Info Berita
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Publikasi</h4>
                                <p class="text-gray-900 dark:text-white">{{ $berita->tanggal_publikasi->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Penulis</h4>
                                <p class="text-gray-900 dark:text-white">{{ $berita->user->name ?? 'Admin' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $berita->aktif ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                    {{ $berita->aktif ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Dilihat</h4>
                                <p class="text-gray-900 dark:text-white">{{ $berita->viewer ?? 0 }} kali</p>
                            </div>
                        </div>
                        
                        @if($berita->meta_keywords)
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Kata Kunci</h4>
                                <div class="mt-1 flex flex-wrap gap-1">
                                    @foreach(explode(',', $berita->meta_keywords) as $keyword)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Related News Section -->
                @php
                    $relatedNews = \App\Plugins\Berita\Models\Berita::where('aktif', true)
                        ->where('id', '!=', $berita->id)
                        ->orderBy('tanggal_publikasi', 'desc')
                        ->limit(3)
                        ->get();
                @endphp
                
                @if($relatedNews->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        Berita Terkait
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($relatedNews as $related)
                        <a href="{{ route('berita.show', $related->slug) }}" class="block group">
                            <div class="flex items-start">
                                @if($related->gambar)
                                    <img src="{{ asset('storage/' . $related->gambar) }}" 
                                         class="w-16 h-16 rounded-md object-cover mr-3 flex-shrink-0"
                                         alt="{{ $related->judul }}">
                                @else
                                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16 mr-3 flex-shrink-0" />
                                @endif
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 line-clamp-2">
                                        {{ $related->judul }}
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $related->tanggal_publikasi->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .berita-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 1rem 0;
    }
    
    .berita-content h1,
    .berita-content h2,
    .berita-content h3,
    .berita-content h4,
    .berita-content h5,
    .berita-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: bold;
    }
    
    .berita-content p {
        margin-bottom: 1rem;
        line-height: 1.7;
    }
    
    .berita-content ul,
    .berita-content ol {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }
    
    .berita-content li {
        margin-bottom: 0.5rem;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .prose {
        font-size: 1.125rem; /* 18px */
        line-height: 1.8;
    }
</style>
@endsection