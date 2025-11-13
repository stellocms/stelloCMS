@if($randomNews && $randomNews->count() > 0)
<div class="widget widget-slider-news">
    <div class="card overflow-hidden rounded-xl shadow-md hover-lift">
        <div class="card-body p-0">
            <!-- Slider container -->
            <div class="relative overflow-hidden rounded-lg" style="height: 300px;">
                <!-- Slider images -->
                <div class="slider-container flex">
                    @foreach($randomNews as $index => $news)
                    <div class="slide w-full flex-shrink-0 relative" style="display: @if($index == 0) block @else none @endif;">
                        @if($news->gambar)
                            <img src="{{ asset('storage/' . $news->gambar) }}" 
                                 alt="{{ $news->judul }}" 
                                 class="w-full h-full object-cover"
                                 style="height: 300px;">
                        @else
                            <div class="bg-gray-200 w-full h-full flex items-center justify-center" style="height: 300px;">
                                <span class="text-gray-500">Tidak ada gambar</span>
                            </div>
                        @endif
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 text-white">
                            <a href="{{ route('panel.berita.show', $news->id) }}" class="text-decoration-none text-white">
                                <h5 class="font-bold text-lg mb-1">{{ Str::limit(strip_tags($news->judul), 60) }}</h5>
                                <small>{{ $news->tanggal_publikasi->format('d M Y') }}</small>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Slider indicators -->
                <div class="absolute bottom-3 left-0 right-0 flex justify-center space-x-2">
                    @foreach($randomNews as $index => $news)
                    <button class="indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors duration-200 @if($index == 0) bg-white @endif" 
                            data-slide="{{ $index }}"></button>
                    @endforeach
                </div>

                <!-- Slider navigation -->
                <button class="slider-nav prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white rounded-full w-8 h-8 flex items-center justify-center transition-colors duration-200 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button class="slider-nav next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white rounded-full w-8 h-8 flex items-center justify-center transition-colors duration-200 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <style>
        .widget-slider-news {
            width: 100%;
        }
        
        .slider-container {
            display: flex;
            height: 300px;
            transition: transform 0.5s ease-in-out;
        }
        
        .slide {
            width: 100%;
            height: 100%;
        }
        
        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .slide {
            display: none;
        }
        
        .slide.current {
            display: block;
        }
        
        .slider-nav {
            z-index: 10;
        }
        
        .slider-nav:hover {
            background-color: rgba(0,0,0,0.5);
        }
        
        .indicator.active {
            background-color: white;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let slides = document.querySelectorAll('.slide');
            let indicators = document.querySelectorAll('.indicator'); 
            let prevBtn = document.querySelector('.slider-nav.prev');
            let nextBtn = document.querySelector('.slider-nav.next');
            let currentIndex = 0;
            let autoSlideInterval;
            
            function goToSlide(index) {
                if (index < 0) index = slides.length - 1;
                if (index >= slides.length) index = 0;
                
                currentIndex = index;
                
                // Hide all slides and show current
                slides.forEach(slide => slide.style.display = 'none');
                slides[currentIndex].style.display = 'block';
                
                // Update active indicator
                indicators.forEach(indicator => indicator.classList.remove('bg-white'));
                indicators[currentIndex].classList.add('bg-white');
            }
            
            // Add click event to indicators
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    goToSlide(index);
                    resetAutoSlide();
                });
            });
            
            // Add click event to navigation buttons
            if(prevBtn) {
                prevBtn.addEventListener('click', function() {
                    goToSlide(currentIndex - 1);
                    resetAutoSlide();
                });
            }
            
            if(nextBtn) {
                nextBtn.addEventListener('click', function() {
                    goToSlide(currentIndex + 1);
                    resetAutoSlide();
                });
            }
            
            // Auto slide functionality
            function startAutoSlide() {
                if (slides.length > 1) {
                    autoSlideInterval = setInterval(function() {
                        goToSlide(currentIndex + 1);
                    }, 5000); // Change slide every 5 seconds
                }
            }
            
            function resetAutoSlide() {
                clearInterval(autoSlideInterval);
                startAutoSlide();
            }
            
            // Touch/swipe support for mobile
            let touchStartX = 0, touchEndX = 0;
            const slider = document.querySelector('.slider-container');
            
            function handleTouchStart(event) {
                touchStartX = event.touches[0].clientX;
            }
            
            function handleTouchMove(event) {
                touchEndX = event.touches[0].clientX;
            }
            
            function handleTouchEnd() {
                if (touchStartX - touchEndX > 50) { // Swipe left
                    goToSlide(currentIndex + 1);
                    resetAutoSlide();
                }
                if (touchEndX - touchStartX > 50) { // Swipe right
                    goToSlide(currentIndex - 1);
                    resetAutoSlide();
                }
            }
            
            if (slider) {
                slider.addEventListener('touchstart', handleTouchStart);
                slider.addEventListener('touchmove', handleTouchMove);
                slider.addEventListener('touchend', handleTouchEnd);
            }
            
            // Initialize slider
            goToSlide(0);
            startAutoSlide();
        });
    </script>
</div>
@else
<div class="alert alert-info">
    <p class="mb-0">Tidak ada berita dengan gambar untuk ditampilkan di slider.</p>
</div>
@endif