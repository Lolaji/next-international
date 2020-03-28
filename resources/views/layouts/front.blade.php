<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    @if (isset($description))
        <meta name="description" content="{{ $description }}">
    @endif
    
    @if (isset($keywords))
        <meta name="keywords" content="{{ $keywords }}">
    @endif

    @if (isset($author))
        <meta name="author" content="{{ $author }}">
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{asset('assets/images/logo/shotcut-icon.png')}}" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,600,600i,800,800i&display=swap" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css?family=Alegreya:400,400i,700,700i&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/lightcase.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/transition.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/color.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <title>
        <?php if(!empty($subPage)): ?>
            <?= $subPage.' > ' ?>
        <?php endif; ?>
        {{ $page_title. ' | Next International' }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-wrapper">
            <img src="{{asset('assets/css/ajax-loader.gif')}}" alt="preloader">
        </div>
    </div>
    <!-- Preloader -->
    <!-- Header Section Stars Here -->
    <a href="#" class="scrollToTop"><i class="fas fa-angle-up"></i></a>
    <!-- Fixed Sidebar Section Ends Here -->

    <!-- Header Section Stars Here -->
    <header>
        @if (Auth::check() && Auth::user()->is_admin)
            <div class="admin-nav p-3 bg-dark">
                <div class="container">
                    <div class="header-wrapper">
                        <a href="/backoffice/dashboard"> <i class="fas fa-arrow-left"></i> Go To Admin Panel</a>
                    </div>
                </div>
            </div>
        @endif

        <div class="header-top d-none d-xl-block">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo">
                        <a href="{{ url('') }}"><img src="{{asset('assets/images/logo/next-logo-2.png')}}" alt="Next International"></a>
                    </div>
                    <div class="header-info">
                        <div class="info-item">
                            <div class="info-thumb">
                                <i class="flaticon-placeholder"></i>
                            </div>
                            <div class="info-content">
                                <h6 class="title">location</h6>
                                <span>{{ $site_info['location'] }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-thumb">
                                <i class="flaticon-email"></i>
                            </div>
                            <div class="info-content">
                                <h6 class="title">email address</h6>
                                <span>{{ $site_info['contact_email_address'] }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-thumb">
                                <i class="flaticon-call"></i>
                            </div>
                            <div class="info-content">
                                <h6 class="title">Phone</h6>
                                <span>{{ $site_info['phone'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="header-bottom-wrapper">
                    <div class="logo d-xl-none">
                        <a href="index.html"><img src="{{asset('assets/images/logo/next-logo-2.png')}}" alt="Next International"></a>
                    </div>
                    <div class="header-bar d-xl-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <ul class="menu">
                        <li class="menu-item"><a href="{{url('')}}" alt="home" class="menu-item-link">Home</a></li>
                        <li class="menu-item"><a href="{{url('services')}}" alt="services" class="menu-item-link">Services</a></li>
                        <li class="menu-item"><a href="{{url('jobs')}}" alt="jobs" class="menu-item-link">Jobs</a></li>
                        <li class="menu-item"><a href="{{url('blog')}}" alt="blog" class="menu-item-link">Insights</a></li>
                        <li class="menu-item"><a href="{{url('about-us')}}" alt="about-us" class="menu-item-link">About</a></li>
                        <li class="menu-item"><a href="{{url('contact-us')}}" alt="contact-us" class="menu-item-link">Contact</a></li>


                        <li class="menu-item">
                            <a href="{{ url('contact-us') }}" alt="contact-us" class="header-button">Get Started</a>
                        </li>
                    </ul>
                    <div class="header-button-wrapper d-none d-xl-inline-flex">
                        <a class="header-button" alt="contact-us" href="{{ url('contact-us') }}">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section Ends Here -->


    <!-- Main Content -->
    <div id="app">
        @yield('content')
    </div>
    <!-- Main Content /-->

    <!-- Footer Section Starts Here -->
    <footer class="footer-section">
        <div class="footer-top">
            <div class="container">
                <div class="row mb-45-none">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-widget widget-about">
                            <h5 class="widget-title">Next International</h5>
                            <p>{{ $site_info['site_short_description'] }}</p>
                            <!-- Social media Icons -->
                            <div class="social-icons">
                                @if (!empty($site_info['facebook']))
                                    <a href="{{ $site_info['facebook'] }}" alt="facebook"><i class="fab fa-facebook-f"></i></a>
                                @endif

                                @if (!empty($site_info['linkedin']))
                                    <a href="{{ $site_info['linkedin'] }}" alt="linkedin"><i class="fab fa-linkedin-in"></i></a>
                                @endif

                                @if (!empty($site_info['twitter']))
                                    <a href="{{ $site_info['twitter'] }}" alt="twitter"><i class="fab fa-twitter"></i></a>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-widget widget-link">
                            <h5 class="widget-title">Useful Link</h5>
                            <ul>
                                <li><a href="{{ url('') }}">Home</a></li>
                                <li><a href="{{ url('services') }}">services</a></li>
                                <li><a href="{{ url('jobs') }}">Jobs</a></li>
                                <li><a href="{{ url('blog') }}">Insights</a></li>
                                <li><a href="{{ url('about') }}">About</a></li>
                                <li><a href="{{ url('contact') }}">Contact</a></li>
                                <li><a href="{{ url('legal/privacy') }}">Privacy</a></li>
                                <li><a href="{{ url('legal/terms-and-conditions') }}">Terms and Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget widget-post">
                            <h5 class="widget-title">Our Social Media Post</h5>
                            <ul>
                                <li>
                                    <a class="post-title" href="#">Ullamco est amet quis tullam cursus, metus.</a>
                                    <span>05 may 2017</span>
                                </li>
                                <li>
                                    <a class="post-title" href="#">Ullamco est amet quis tullam cursus, metus.</a>
                                    <span>05 may 2017</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget widget-form">
                            <h5 class="widget-title">Be The First To Know What's Next</h5>
                            <subscribe-form></subscribe-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom align-items-center d-flex">
            <div class="container">
                <p class="m-0">&copy; Copyright <a href="{{ url('') }}">Next International</a> - 2019. Developed by : <a href="https://fiverr.com/lolaji" target="_blank" class="text-generic-green">Lolaji</a></p>
            </div>
        </div>
    </footer>

    <!-- JavaScripts Refferencing -->
    <script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/js/modernizr-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('assets/js/swiper.min.js')}}"></script>
    <script src="{{asset('assets/js/waypoint.js')}}"></script>
    <script src="{{asset('assets/js/counterup.min.js')}}"></script>
    <script src="{{asset('assets/js/lightcase.js')}}"></script>
    <script src="{{asset('assets/js/wow.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>

    <script>
        // Skillbar
        $(document).ready(function() {
            var skillsDiv = $('.skillbar-wrapper');
            if (skillsDiv[0]) {
                $(window).on('scroll', function() {
                    var winT = $(window).scrollTop(),
                        winH = $(window).height(),
                        skillsT = skillsDiv.offset().top;
                    if (winT + winH > skillsT) {
                        $('.skillbar').each(function() {
                            $(this).find('.skillbar-bar').animate({
                                width: $(this).attr('data-percent')
                            }, 6000);
                        });
                    }
                });
            }
        })

    </script>

</body>

</html>