<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', cms_name())</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Forms Plugin -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            plugins: [
                // Tidak perlu require('@tailwindcss/forms') karena tidak digunakan di CDN
            ],
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif']
                    },
                    colors: {
                        primary: {"50": "#eff6ff", "100": "#dbeafe", "200": "#bfdbfe", "300": "#93c5fd", "400": "#60a5fa", "500": "#3b82f6", "600": "#2563eb", "700": "#1d4ed8", "800": "#1e40af", "900": "#1e3a8a", "950": "#172554"}
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Gradient backgrounds */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-bg-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .gradient-bg-button {
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
        }

        /* Card styling */
        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* Button styling */
        .btn-gradient {
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
            display: inline-block;
            text-decoration: none;
        }

        .btn-gradient:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
    
    <!-- Meta Tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', cms_description())">
    <meta name="author" content="{{ cms_name() }}">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                        {{ cms_name() }}
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    @if(isset($headerMenus))
                        @foreach($headerMenus as $menu)
                            <a href="{{ isset($menu->route) && Route::has($menu->route) ? route($menu->route) : ($menu->url ?? '#') }}"
                               class="text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                @if($menu->icon)
                                    <i class="{{ $menu->icon }} mr-1"></i>
                                @endif
                                {{ $menu->title }}
                            </a>
                        @endforeach
                    @endif
                </nav>
                
                <!-- Dark Mode Toggle -->
                <div class="flex items-center">
                    <button @click="darkMode = !darkMode"
                            class="p-2 rounded-full text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 mr-2">
                        <span x-show="!darkMode">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0Z" />
                            </svg>
                        </span>
                        <span x-show="darkMode" style="display:none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998Z" />
                            </svg>
                        </span>
                    </button>
                    
                    <!-- Mobile menu button -->
                    <button @click="$dispatch('toggle-mobile-menu')"
                            class="md:hidden p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div x-data="{ mobileMenuOpen: false }" 
             @toggle-mobile-menu.window="mobileMenuOpen = !mobileMenuOpen"
             x-show="mobileMenuOpen" 
             class="md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                @if(isset($headerMenus))
                    @foreach($headerMenus as $menu)
                        <a href="{{ isset($menu->route) && Route::has($menu->route) ? route($menu->route) : ($menu->url ?? '#') }}"
                           class="text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                            @if($menu->icon)
                                <i class="{{ $menu->icon }} mr-2"></i>
                            @endif
                            {{ $menu->title }}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Site Info -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ cms_name() }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ cms_description() }}
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.129 22 16.99 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465 1.067-.048 1.407-.06 4.123-.06h.08c2.597 0 2.917.011 3.96.058 1.067.048 1.37.059 4.041.059h.63c2.643 0 2.987-.011 3.96-.058 1.064-.049 1.791-.218 2.427-.465a4.902 4.902 0 011.772-1.153 4.902 4.902 0 011.153-1.772c.247-.636.416-1.363.465-2.427.047-1.024.06-1.379.06-4.123v-.08c0-2.643-.013-2.987-.06-3.96-.049-1.064-.218-1.791-.465-2.427a4.902 4.902 0 01-1.153-1.772 4.902 4.902 0 01-1.772-1.153c-.636-.247-1.363-.416-2.427-.465-1.067-.048-1.407-.06-4.123-.06h-.08c-2.597 0-2.917.011-3.96.058-1.067.048-1.37.059-4.041.059h-.63c-2.643 0-2.987.011-3.96.058-1.064.049-1.791.218-2.427.465a4.902 4.902 0 01-1.772 1.153 4.902 4.902 0 01-1.153 1.772c-.247.636-.416 1.363-.465 2.427-.047 1.024-.06 1.379-.06 4.123v.08c0 2.643.013 2.987.06 3.96.049 1.064.218 1.791.465 2.427a4.902 4.902 0 011.153 1.772 4.902 4.902 0 011.772 1.153c.636.247 1.363.416 2.427.465 1.067.048 1.407.06 4.123.06h.08c2.643 0 2.987-.011 3.96-.058 1.064-.049 1.791-.218 2.427-.465a4.902 4.902 0 011.772-1.153 4.902 4.902 0 011.153-1.772c.247-.636.416-1.363.465-2.427C18.343 2.129 22 6.99 22 12z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.013 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.597 0-2.917-.011-3.96-.058-1.054-.048-1.37-.059-4.041-.059h-.63c-2.643 0-2.987.011-3.96.058-1.064.049-1.791.218-2.427.465a4.902 4.902 0 01-1.772 1.153 4.902 4.902 0 01-1.772-1.153c-.636-.247-1.363-.416-2.427-.465-1.067-.048-1.407-.06-4.123-.06h-.08c-2.597 0-2.917.011-3.96.058-1.067.048-1.37.059-4.041.059h-.63c-2.643 0-2.987-.011-3.96-.058-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-4.123v-.08c0-2.643.013-2.987.06-3.96.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465 1.067-.048 1.407-.06 4.123-.06h.08c2.597 0 2.917.011 3.96.058 1.067.048 1.37.059 4.041.059h.63c2.643 0 2.987-.011 3.96-.058 1.064-.049 1.791-.218 2.427-.465a4.902 4.902 0 011.772-1.153 4.902 4.902 0 011.153-1.772c.247-.636.416-1.363.465-2.427.048-1.067.06-1.407.06-4.123v-.08c0-2.643-.013-2.987-.06-3.96-.049-1.064-.218-1.791-.465-2.427a4.902 4.902 0 01-1.153-1.772 4.902 4.902 0 01-1.772-1.153c-.636-.247-1.363-.416-2.427-.465-1.067-.048-1.407-.06-4.123-.06h-.08z" clip-rule="evenodd" />
                                <path d="M8 11a3 3 0 100-6 3 3 0 000 6zm0 0v-3.05A3.05 3.05 0 004.95 5H2v13a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2H2v1.05A3.05 3.05 0 004.95 8H8z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8 md:flex md:items-center md:justify-between">
                <p class="mt-8 text-center text-base text-gray-500 dark:text-gray-400 md:mt-0">
                    &copy; {{ date('Y') }} {{ cms_name() }}. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>