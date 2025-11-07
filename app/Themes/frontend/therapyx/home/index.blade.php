@extends('theme.frontend.therapy::layouts.app')

@section('title', 'Therapy - Physical Therapy Home')

@section('hero')
<!-- Carousel Start -->
<div class="header-carousel owl-carousel">
    <div class="header-carousel-item">
        <img src="{{ asset('themes/therapy/img/carousel-1.jpg') }}" class="img-fluid w-100" alt="Image">
        <div class="carousel-caption">
            <div class="carousel-caption-content p-3">
                <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Physiotherapy Center</h5>
                <h1 class="display-1 text-capitalize text-white mb-4">Best Solution For Painful Life</h1>
                <p class="mb-5 fs-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                </p>
                <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="{{ url('/appointment') }}">Book Appointment</a>
            </div>
        </div>
    </div>
    <div class="header-carousel-item">
        <img src="{{ asset('themes/therapy/img/carousel-2.jpg') }}" class="img-fluid w-100" alt="Image">
        <div class="carousel-caption">
            <div class="carousel-caption-content p-3">
                <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Physiotherapy Center</h5>
                <h1 class="display-1 text-capitalize text-white mb-4">Best Solution For Painful Life</h1>
                <p class="mb-5 fs-5 animated slideInDown">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                </p>
                <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="{{ url('/appointment') }}">Book Appointment</a>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->
@endsection

@section('content')

<!-- Services Start -->
<div class="container-fluid service py-5">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">What We Do</h4>
            </div>
            <h1 class="display-3 mb-4">Our Service Given Physio Therapy By Expert.</h1>
            <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam necessitatibus saepe in ab? Repellat!</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item rounded">
                   <div class="service-img rounded-top">
                        <img src="{{ asset('themes/therapy/img/service-1.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                   </div>
                    <div class="service-content rounded-bottom bg-light p-4">
                        <div class="service-content-inner">
                            <h5 class="mb-4">Message Therapy</h5>
                            <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus, dolor qui ullam</p>
                            <a href="{{ url('/services') }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item rounded">
                   <div class="service-img rounded-top">
                        <img src="{{ asset('themes/therapy/img/service-2.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                   </div>
                    <div class="service-content rounded-bottom bg-light p-4">
                        <div class="service-content-inner">
                            <h5 class="mb-4">Physiotherapy</h5>
                            <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus, dolor qui ullam</p>
                            <a href="{{ url('/services') }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item rounded">
                   <div class="service-img rounded-top">
                        <img src="{{ asset('themes/therapy/img/service-3.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                   </div>
                    <div class="service-content rounded-bottom bg-light p-4">
                        <div class="service-content-inner">
                            <h5 class="mb-4">Heat & Cold Therapy</h5>
                            <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus, dolor qui ullam</p>
                            <a href="{{ url('/services') }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item rounded">
                   <div class="service-img rounded-top">
                        <img src="{{ asset('themes/therapy/img/service-4.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                   </div>
                    <div class="service-content rounded-bottom bg-light p-4">
                        <div class="service-content-inner">
                            <h5 class="mb-4">Chiropatic Therapy</h5>
                            <p class="mb-4">Dolor, sit amet consectetur adipisicing elit. Soluta inventore cum accusamus, dolor qui ullam</p>
                            <a href="{{ url('/services') }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Services End -->

<!-- About Start -->
<div class="container-fluid about py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="about-img rounded">
                    <img src="{{ asset('themes/therapy/img/about-1.jpg') }}" class="img-fluid rounded w-100" alt="">
                </div>
            </div>
            <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.4s">
                <div class="section-title mb-4">
                    <h4 class="sub-title pe-3 mb-0">About Us</h4>
                    <h1 class="display-4 mb-4">Providing Quality Health Care Services</h1>
                    <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, exercitationem? Dolores eaque quas hic sapiente asperiores placeat cumque maiores explicabo esse dolore voluptatum fugiat nihil, fuga nisi. Laborum, repellendus cumque!</p>
                </div>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur doloremque eos iusto nobis impedit repellendus consequatur tenetur? Doloribus, itaque dignissimos.</p>
                <div class="row gy-3 gx-4 mb-4">
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.2s">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check text-primary me-3"></i>
                            <h6 class="mb-0">Quality Health Services</h6>
                        </div>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check text-primary me-3"></i>
                            <h6 class="mb-0">Expert Doctors</h6>
                        </div>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.6s">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check text-primary me-3"></i>
                            <h6 class="mb-0">Modern Equipment</h6>
                        </div>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.8s">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check text-primary me-3"></i>
                            <h6 class="mb-0">24/7 Support</h6>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/about') }}" class="btn btn-primary rounded-pill text-white py-3 px-5">Discover More</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Feature Start -->
<div class="container-fluid feature py-5">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">Why Choose Us</h4>
            </div>
            <h1 class="display-3 mb-4">Great Solution For Your Health</h1>
            <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam necessitatibus saepe in ab? Repellat!</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="{{ asset('themes/therapy/img/feature-1.jpg') }}" class="img-fluid w-100 rounded" alt="">
                                <div class="feature-icon p-3">
                                    <i class="fas fa-head-side-cough fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="feature-content p-4">
                                <h5 class="mb-4">Physiotherapy</h5>
                                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, nam.</p>
                                <a href="{{ url('/services') }}" class="btn btn-primary rounded-pill text-white py-2 px-4">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="{{ asset('themes/therapy/img/feature-2.jpg') }}" class="img-fluid w-100 rounded" alt="">
                                <div class="feature-icon p-3">
                                    <i class="fas fa-laptop-medical fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="feature-content p-4">
                                <h5 class="mb-4">Modern Technology</h5>
                                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, nam.</p>
                                <a href="{{ url('/services') }}" class="btn btn-primary rounded-pill text-white py-2 px-4">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="feature-item bg-primary rounded">
                    <div class="feature-img">
                        <img src="{{ asset('themes/therapy/img/feature-3.jpg') }}" class="img-fluid w-100 rounded" alt="">
                        <div class="feature-icon p-3">
                            <i class="fas fa-user-md fa-2x text-white"></i>
                        </div>
                    </div>
                    <div class="feature-content p-4">
                        <h5 class="text-white mb-4">Experience Physiotherapist</h5>
                        <p class="text-white mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, nam.</p>
                        <a href="{{ url('/team') }}" class="btn btn-light rounded-pill text-white py-2 px-4">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.5s">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="{{ asset('themes/therapy/img/feature-4.jpg') }}" class="img-fluid w-100 rounded" alt="">
                                <div class="feature-icon p-3">
                                    <i class="fas fa-stethoscope fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="feature-content p-4">
                                <h5 class="mb-4">Advanced Equipment</h5>
                                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, nam.</p>
                                <a href="{{ url('/services') }}" class="btn btn-primary rounded-pill text-white py-2 px-4">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="{{ asset('themes/therapy/img/feature-5.jpg') }}" class="img-fluid w-100 rounded" alt="">
                                <div class="feature-icon p-3">
                                    <i class="fas fa-ambulance fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="feature-content p-4">
                                <h5 class="mb-4">Emergency Services</h5>
                                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, nam.</p>
                                <a href="{{ url('/services') }}" class="btn btn-primary rounded-pill text-white py-2 px-4">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Feature End -->

<!-- Team Start -->
<div class="container-fluid team py-5">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">Our Team</h4>
            </div>
            <h1 class="display-3 mb-4">Meet Our Expert Doctors</h1>
            <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam necessitatibus saepe in ab? Repellat!</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item rounded">
                    <div class="team-img rounded-top">
                        <img src="{{ asset('themes/therapy/img/team-1.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                    </div>
                    <div class="team-text rounded-bottom bg-light p-4">
                        <h3 class="mb-2">Dr. John Smith</h3>
                        <p class="mb-3">Senior Physiotherapist</p>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-0"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                <div class="team-item rounded">
                    <div class="team-img rounded-top">
                        <img src="{{ asset('themes/therapy/img/team-2.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                    </div>
                    <div class="team-text rounded-bottom bg-light p-4">
                        <h3 class="mb-2">Dr. Emily Johnson</h3>
                        <p class="mb-3">Massage Therapist</p>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-0"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                <div class="team-item rounded">
                    <div class="team-img rounded-top">
                        <img src="{{ asset('themes/therapy/img/team-3.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                    </div>
                    <div class="team-text rounded-bottom bg-light p-4">
                        <h3 class="mb-2">Dr. Michael Brown</h3>
                        <p class="mb-3">Orthopedic Specialist</p>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-0"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                <div class="team-item rounded">
                    <div class="team-img rounded-top">
                        <img src="{{ asset('themes/therapy/img/team-4.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                    </div>
                    <div class="team-text rounded-bottom bg-light p-4">
                        <h3 class="mb-2">Dr. Sarah Davis</h3>
                        <p class="mb-3">Sports Medicine Expert</p>
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-light btn-square rounded-circle me-0"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Team End -->

<!-- Testimonial Start -->
<div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">Testimonials</h4>
            </div>
            <h1 class="display-3 mb-4">What Our Clients Say</h1>
            <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat deleniti amet at atque sequi quibusdam cumque itaque repudiandae temporibus, eius nam mollitia voluptas maxime veniam necessitatibus saepe in ab? Repellat!</p>
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.3s">
            <div class="testimonial-item">
                <div class="testimonial-img mb-3">
                    <img src="{{ asset('themes/therapy/img/testimonial-img.jpg') }}" class="img-fluid rounded w-100" alt="">
                </div>
                <div class="testimonial-content">
                    <div class="d-flex mb-3">
                        <h5 class="mb-0">John Doe</h5>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium quia eveniet quod cumque perspiciatis repellendus error magnam eligendi voluptatem. Reprehenderit!</p>
                </div>
            </div>
            <div class="testimonial-item">
                <div class="testimonial-img mb-3">
                    <img src="{{ asset('themes/therapy/img/testimonial-img.jpg') }}" class="img-fluid rounded w-100" alt="">
                </div>
                <div class="testimonial-content">
                    <div class="d-flex mb-3">
                        <h5 class="mb-0">Jane Smith</h5>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium quia eveniet quod cumque perspiciatis repellendus error magnam eligendi voluptatem. Reprehenderit!</p>
                </div>
            </div>
            <div class="testimonial-item">
                <div class="testimonial-img mb-3">
                    <img src="{{ asset('themes/therapy/img/testimonial-img.jpg') }}" class="img-fluid rounded w-100" alt="">
                </div>
                <div class="testimonial-content">
                    <div class="d-flex mb-3">
                        <h5 class="mb-0">Robert Johnson</h5>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium quia eveniet quod cumque perspiciatis repellendus error magnam eligendi voluptatem. Reprehenderit!</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial End -->

@endsection