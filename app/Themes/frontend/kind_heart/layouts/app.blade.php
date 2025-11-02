<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimPeDe - Sistem Pengelolaan Desa</title>
    <!-- Kind Heart Charity CSS files -->
    <link rel="stylesheet" href="{{ asset('themes/kind_heart/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/kind_heart/css/templatemo-kind-heart-charity.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Preloader -->
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span>SimPeDe</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/panel') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <h4 class="text-white mb-4">SimPeDe - Sistem Pengelolaan Desa</h4>
                    <p class="copyright-text">Copyright &copy; 2025 SimPeDe. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Kind Heart Charity JS files -->
    <script src="{{ asset('themes/kind_heart/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('themes/kind_heart/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('themes/kind_heart/js/templatemo-script.js') }}"></script>
</body>
</html>