@extends('theme.frontend.standard::layouts.app')

@section('title', 'Beranda - ' . cms_name())

@section('content')
<!-- Hero Section -->
<section class="relative py-20 md:py-32 overflow-hidden">
    <div class="absolute inset-0 gradient-bg opacity-10"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 mb-12 lg:mb-0">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Platform CMS <span class="text-indigo-600">Modern</span> dan Mudah Digunakan
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-lg">
                    Buat dan kelola website Anda dengan antarmuka yang intuitif dan fleksibilitas yang tinggi melalui sistem stelloCMS kami.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('panel.dashboard') }}" class="btn-gradient text-white font-semibold py-3 px-8 rounded-lg text-center">
                        Dashboard
                    </a>
                    <a href="#" class="bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 font-semibold py-3 px-8 rounded-lg border border-indigo-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300 text-center">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2 flex justify-center">
                <div class="relative">
                    <div class="absolute -top-6 -left-6 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    <div class="absolute -bottom-8 -right-8 w-64 h-64 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-4 max-w-md">
                        <div class="bg-gray-200 dark:bg-gray-700 border-2 border-dashed rounded-xl w-full h-64 md:h-80" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Fitur Unggulan</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Sistem stelloCMS menawarkan berbagai fitur yang memudahkan Anda dalam mengelola konten website
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 hover-lift card-hover">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Manajemen Konten</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Buat dan kelola berbagai jenis konten dengan antarmuka yang mudah digunakan dan editor yang canggih.
                </p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 hover-lift card-hover">
                <div class="w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900/50 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Pengaturan Fleksibel</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Atur pengaturan sistem, tema, dan plugin sesuai kebutuhan organisasi Anda secara real-time.
                </p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 hover-lift card-hover">
                <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Keamanan Terjamin</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Sistem keamanan terbaru untuk melindungi data dan akses ke sistem Anda dengan role-based access control.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Widgets Section -->
@if(isset($homeWidgets) && $homeWidgets->count() > 0)
<section class="py-20 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Konten Tambahan</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Widget dinamis yang menampilkan informasi terbaru dari sistem Anda
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($homeWidgets as $widget)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 card-hover hover:shadow-lg transition-all">
                <div class="flex items-start mb-4">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold">{{ $widget->name }}</h3>
                </div>
                
                @if($widget->type === 'html')
                    <div class="text-gray-700 dark:text-gray-300">{!! $widget->content !!}</div>
                @elseif($widget->type === 'text')
                    <div class="text-gray-700 dark:text-gray-300">{{ $widget->content }}</div>
                @elseif($widget->type === 'plugin' && $widget->plugin_name)
                    @php
                        $pluginClass = "App\\Plugins\\" . $widget->plugin_name . "\\Controllers\\" . $widget->plugin_name . "Controller";
                        if (class_exists($pluginClass)) {
                            $controller = new $pluginClass();
                            if (method_exists($controller, 'getWidgetContent')) {
                                echo $controller->getWidgetContent();
                            } elseif (method_exists($controller, 'get' . $widget->plugin_name . 'Widget')) {
                                $method = 'get' . $widget->plugin_name . 'Widget';
                                echo $controller->$method();
                            }
                        }
                    @endphp
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 gradient-bg">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Memulai?</h2>
        <p class="text-xl text-indigo-100 max-w-2xl mx-auto mb-8">
            Bangun website Anda dengan platform yang handal dan mudah digunakan
        </p>
        <a href="{{ route('panel.dashboard') }}" class="inline-block bg-white text-indigo-600 font-bold py-3 px-8 rounded-lg hover:bg-gray-100 transition-colors duration-300">
            Akses Dashboard
        </a>
    </div>
</section>

<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .hover-lift {
        transition: transform 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-3px);
    }
</style>
@endsection