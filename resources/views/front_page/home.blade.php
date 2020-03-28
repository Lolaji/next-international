@extends('layouts.front')

@section('content')

<!-- Banner Section Starts Here -->
<section class="banner-section bg_img" data-background="images/header-image.jpg">
    <div class="container p-0">
        <div class="banner-content-container">
            <div class="banner-content">
                <h3> <span>OUR</span>MISSION</h3>
                <h1 class="title">ELEVATING OUR CLIENT’S RECRUITMENT PROCESS
                    AND STRATEGY <br />
                    & <br />
                    CONNECTING GREAT TALENT WITH GREAT
                    COMPANIES
                </h1>
                {{-- <p>Clarify Strategy | Training | Executive Search</p> --}}
                <p>
                    {{ $banner_services }}
                </p>
                <div class="button-group">
                    <a href="{{ url('contact-us') }}" class="custom-button active">Let's Talk</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section EndsHere -->

<!-- About Section Starts Here -->
<section class="about-section padding-bottom padding-top">
    <div class="container">
        <div class="about-top">
            <div class="row flex-wrap-reverse">
                <div class="col-lg-6">
                    <div class="about-content">
                        <h2 class="title">WHO<span class="text-generic-green">WE</span>ARE</h2>
                        <span class="shape"><span class="shape-inner"></span></span>
                        <p>Next International is a high-touch, low profile, recruitment
                            consulting firm based in Calgary, Alberta with affiliate
                            relationships throughout North America.</p>
                        <p>Our company
                            is built on the belief that forming close relationships with
                            clients, a willingness to push boundaries when needed
                            and absolute discretion are the main ingredients for a
                            successful partnership.</p>
                        <a href="{{ url('about-us') }}" class="custom-button">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-thumb">
                        <div class="thumb-one">
                            <img src="{{ asset('images/who-we-are-425by426.jpg') }}" height="425" width="446" alt="about">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- About Section Ends Here -->

<!-- Our NiCHE Section Starts Here -->
<section class="overview-section">
    <div class="container-fluid p-0">
        <div class="row align-items-center">
            <div class="col-xl-6">
                <div class="overview-thumb">
                    <img src="{{asset('images/our-niche.jpg')}}" alt="overview">
                </div>
            </div>
            <div class="col-xl-6">
                <div class="overview-content">
                    <div class="overview-content-container">
                        <div class="section-header">
                            <h2 class="title"> <span class="text-generic-green">OUR</span>NICHE</h2>
                            <span class="shape">
                                <span class="shape-inner"></span>
                            </span>
                            <p>Primarily focused on serving small to medium businesses and start-ups, we don’t see our niche 
                                in terms of vertical expertise, though we have plenty. Our experience expands across a broad stripe 
                                of businesses, with an unparalleled ability to drill down and uncover an organization's DNA.</p>
                            <p>Leveraging this knowledge in our service offerings we are able to identify areas for improvement, 
                                provide custom developed training programs and identify high performance talent that fit both the profile 
                                for success AND corporate culture. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Overview Section Ends Here -->

<!-- Service Section Starts Here -->
<section class="service-section padding-bottom padding-top">
    <div class="container">
        <div class="section-header">
            <h2 class="title">
                <span class="text-generic-green">OUR</span>SERVICES
            </h2>
            <span class="shape"><span class="shape-inner"></span></span>
            <p>As most of our clients have different requirements, our process will be tailored to your specific needs. 
                However, to give you an understanding of what we offer, there are three main services we provide.</p>
        </div>
        <div class="row mb-30-none">
            <div class="wt-categoryexpl">
                @foreach ($services as $service)
                    <div class="col-12 col-sm-12 col-md-3 col-lg-4 float-left mb-4">
                        <div class="wt-categorycontent">
                            <figure><img src="{{ 'storage/images/service/'.$service->overview_icon }}" alt="image description"></figure>
                            <div class="wt-cattitle">
                                <h3><a href="{{ url('services/'.strtolower(Str::slug($service->title))) }}" class="text-generic-green">{{ $service->title }}</a></h3>
                            </div>
                            <div class="wt-categoryslidup">
                                <p>{{ $service->short_desc }}</p>
                                <a href="{{ url('services/'.strtolower(Str::slug($service->title))) }}">Read More <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Service Section Ends Here -->

<!-- Our difference Section Starts Here -->
<section class="video-section padding-bottom padding-top bg_img" data-background="images/our-different-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="video-thumb">
                    <img src="{{asset('images/our-difference.jpg')}}" alt="video">
                    {{-- <a class="video-button" href="https://www.youtube.com/embed/UB1O30fR-EE" data-rel="lightcase:myCollection">Watch The Video Info</a> --}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="video-content">
                    <h2 class="title"><span class="text-generic-green">OUR</span>DIFFERENCE</h2>
                    <span class="shape"><span class="shape-inner"></span></span>
                    <p>Challenging the validity of the contingent recruitment model that has been around 
                        for 30+ years, we threw it out and started over; creating a new business model 
                        laser-focused on the relationship: Next and client as trusted partners, sharing the risks and the rewards.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Our difference Section Ends Here -->

<!--  Blog Section Start Here -->
<section class="blog-section padding-bottom padding-top">
    <div class="container">
        <div class="section-header">
            <h2 class="title">LATEST<span class="text-generic-green">NEWS</span>UPDATE</h2>
            <span class="shape"><span class="shape-inner"></span></span>
        </div>
        <div class="row mb-30-none justify-content-center">

            @foreach ($latest_posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="post-item">
                        <div class="post-thumb">
                            <a href="{{ url('blog/'.Str::slug(strtolower($post->title))) }}"><img src="{{ asset('storage/images/post/'.$post->header_image) }}" alt="{{ $post->title }}"></a>
                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h4 class="title"><a href="{{ url('blog/'.Str::slug(strtolower($post->title))) }}">{{ $post->title }}</a>
                                </h4>
                                <p>{{ $post->short_desc }}</p>
                            </div>
                            <div class="meta-post d-flex flex-wrap justify-content-between">
                                <div class="meta-date">
                                    <a href="{{ url('blog/'.Str::slug(strtolower($post->title))) }}"><i class="far fa-calendar-alt"></i> <span>{{ $post->created_at->format('F d, Y') }}</span></a>
                                </div>
                                {{-- <div class="meta-comment">
                                    <a href="#"><i class="far fa-comment"></i> <span>Comment</span></a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>
</section>
<!--  Blog Section Ends Here -->

<!-- call in contact area Starts Here -->
<div class="call-in-contact-area">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-30-none">
            <h2 class="title">Ready to take it to the NEXT level</h2>
            <div class="button">
                <a href="contact-us" class="custom-button">Contact Us Now</a>
            </div>
        </div>
    </div>
</div>
<!-- call in contact area Ends Here -->

<!-- Subscription Section Starts Here -->
<section class="faq-section padding-bottom padding-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-md-3">
                <h2 class="faq-title text-center">BE THE FIRST TO KNOW WHAT’S NEXT <br> <small>Read Anywhere, Cancel Anytime.</small></h2>
                <div class="faq-form-wrapper">
                    <subscribe-form></subscribe-form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Faq Section Ends Here -->


@endsection