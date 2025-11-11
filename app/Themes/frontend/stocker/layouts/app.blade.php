<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>@yield('title', 'Stocker - Stock Market Website')</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link rel="stylesheet" href="{{ asset('themes/stocker/lib/animate/animate.min.css') }}">
        <link href="{{ asset('themes/stocker/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('themes/stocker/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('themes/stocker/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ asset('themes/stocker/css/style.css') }}" rel="stylesheet">
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Topbar Start -->
        <div class="container-fluid topbar bg-light px-5 d-none d-lg-block">
            <div class="row gx-0 align-items-center">
                <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <a href="#" class="text-muted small me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Find A Location</a>
                        <a href="tel:+01234567890" class="text-muted small me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+01234567890</a>
                        <a href="mailto:example@gmail.com" class="text-muted small me-0"><i class="fas fa-envelope text-primary me-2"></i>Example@gmail.com</a>
                    </div>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <div class="d-inline-flex align-items-center" style="height: 45px;">
                        <a href="{{ url('/register') }}" class="small me-3 text-dark"><i class="fa fa-user text-primary me-2"></i>Register</a>
                        <a href="{{ url('/panel') }}" class="small me-3 text-dark"><i class="fa fa-sign-in-alt text-primary me-2"></i>Login</a>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-dark" data-bs-toggle="dropdown"><small><i class="fa fa-home text-primary me-2"></i> My Dashboard</small></a>
                            <div class="dropdown-menu rounded">
                                <a href="{{ url('/profile') }}" class="dropdown-item"><i class="fas fa-user-alt me-2"></i> My Profile</a>
                                <a href="{{ url('/messages') }}" class="dropdown-item"><i class="fas fa-comment-alt me-2"></i> Inbox</a>
                                <a href="{{ url('/notifications') }}" class="dropdown-item"><i class="fas fa-bell me-2"></i> Notifications</a>
                                <a href="{{ url('/settings') }}" class="dropdown-item"><i class="fas fa-cog me-2"></i> Account Settings</a>
                                <a href="{{ url('/logout') }}" class="dropdown-item"><i class="fas fa-power-off me-2"></i> Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->

        <!-- Navbar & Hero Start -->
        <div class="container-fluid position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="{{ url('/') }}" class="navbar-brand p-0">
                    <h1 class="text-primary"><i class="fas fa-search-dollar me-3"></i>{{ config('cms.name', 'Stocker') }}</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        @php
                            // Get active frontend header menus without parent (main menus)
                            $mainMenus = \App\Models\Menu::where('is_active', true)
                                         ->whereNull('parent_id')
                                         ->where('type', 'frontend')
                                         ->where('position', 'header')
                                         ->with('children')
                                         ->orderBy('order')
                                         ->get();
                        @endphp
                        
                        <a href="{{ url('/') }}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                        
                        @foreach($mainMenus as $menu)
                            @if(empty($menu->roles) || (auth()->check() && auth()->user()->role && in_array(auth()->user()->role->name, $menu->roles)))
                                @if($menu->route && Route::has($menu->route))
                                    <a href="{{ route($menu->route) }}" class="nav-item nav-link {{ request()->routeIs($menu->route) ? 'active' : '' }}">{{ $menu->title }}</a>
                                @elseif($menu->url)
                                    <a href="{{ $menu->url }}" class="nav-item nav-link">{{ $menu->title }}</a>
                                @else
                                    @if($menu->children->count() > 0)
                                        <div class="nav-item dropdown">
                                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ $menu->title }}</a>
                                            <div class="dropdown-menu m-0">
                                                @foreach($menu->children->sortBy('order') as $submenu)
                                                    @if(empty($submenu->roles) || (auth()->check() && auth()->user()->role && in_array(auth()->user()->role->name, $submenu->roles)))
                                                        @if($submenu->route && Route::has($submenu->route))
                                                            <a href="{{ route($submenu->route) }}" class="dropdown-item {{ request()->routeIs($submenu->route) ? 'active' : '' }}">{{ $submenu->title }}</a>
                                                        @elseif($submenu->url)
                                                            <a href="{{ $submenu->url }}" class="dropdown-item">{{ $submenu->title }}</a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ url('#') }}" class="nav-item nav-link">{{ $menu->title }}</a>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <a href="{{ url('') }}" class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0">Get Started</a>
                </div>
            </nav>

            <!-- Carousel Start -->
            <div class="header-carousel owl-carousel">
                @yield('carousel')
            </div>
            <!-- Carousel End -->
        </div>
        <!-- Navbar & Hero End -->

        <main>
            @yield('content')
        </main>

        <!-- Footer Start -->
        <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5 border-start-0 border-end-0" style="border: 1px solid; border-color: rgb(255, 255, 255, 0.08);">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="footer-item">
                            <a href="{{ url('/') }}" class="p-0">
                                <h4 class="text-white"><i class="fas fa-search-dollar me-3"></i>{{ config('cms.name', 'Stocker') }}</h4>
                                <!-- <img src="img/logo.png" alt="Logo"> -->
                            </a>
                            <p class="mb-4">Dolor amet sit justo amet elitr clita ipsum elitr est.Lorem ipsum dolor sit amet, consectetur adipiscing...</p>
                            <div class="d-flex">
                                <a href="#" class="bg-primary d-flex rounded align-items-center py-2 px-3 me-2">
                                    <i class="fas fa-apple-alt text-white"></i>
                                    <div class="ms-3">
                                        <small class="text-white">Download on the</small>
                                        <h6 class="text-white">App Store</h6>
                                    </div>
                                </a>
                                <a href="#" class="bg-dark d-flex rounded align-items-center py-2 px-3 ms-2">
                                    <i class="fas fa-play text-primary"></i>
                                    <div class="ms-3">
                                        <small class="text-white">Get it on</small>
                                        <h6 class="text-white">Google Play</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-2">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">Quick Links</h4>
                            @php
                                $footerMenus = \App\Models\Menu::where('is_active', true)
                                             ->whereNull('parent_id')
                                             ->where('type', 'frontend')
                                             ->where('position', 'footer')
                                             ->orderBy('order')
                                             ->limit(6) // Limit to 6 main menu items
                                             ->get();
                            @endphp
                            
                            <a href="{{ url('/') }}"><i class="fas fa-angle-right me-2"></i> Home</a>
                            
                            @foreach($footerMenus->sortBy('order') as $menu)
                                @if(empty($menu->roles) || (auth()->check() && auth()->user()->role && in_array(auth()->user()->role->name, $menu->roles)))
                                    @if($menu->route && Route::has($menu->route))
                                        <a href="{{ route($menu->route) }}"><i class="fas fa-angle-right me-2"></i> {{ $menu->title }}</a>
                                    @elseif($menu->url)
                                        <a href="{{ $menu->url }}"><i class="fas fa-angle-right me-2"></i> {{ $menu->title }}</a>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">Support</h4>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Privacy Policy</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Terms & Conditions</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Disclaimer</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Support</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> FAQ</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Help</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">Contact Info</h4>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                <p class="text-white mb-0">123 Street New York.USA</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-primary me-3"></i>
                                <p class="text-white mb-0">info@example.com</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa fa-phone-alt text-primary me-3"></i>
                                <p class="text-white mb-0">(+012) 3456 7890</p>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <i class="fab fa-firefox-browser text-primary me-3"></i>
                                <p class="text-white mb-0">Yoursite@ex.com</p>
                            </div>
                            <div class="d-flex">
                                <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i class="fab fa-facebook-f text-white"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i class="fab fa-twitter text-white"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i class="fab fa-instagram text-white"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-circle me-0" href="#"><i class="fab fa-linkedin-in text-white"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        
        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-md-0">
                        <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>{{ config('cms.name', 'Your Site Name') }}</a>, All right reserved. Version {{ config('app.version') }}</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end text-body">
                        <!--/*** This template is free as long as you keep the below author's credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author's credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom text-white" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a class="border-bottom text-white" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   


        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('themes/stocker/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('themes/stocker/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('themes/stocker/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('themes/stocker/lib/counterup/counterup.min.js') }}"></script>
        <script src="{{ asset('themes/stocker/lib/lightbox/js/lightbox.min.js') }}"></script>
        <script src="{{ asset('themes/stocker/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        

        <!-- Template Javascript -->
        <script src="{{ asset('themes/stocker/js/main.js') }}"></script>
    </body>

</html>