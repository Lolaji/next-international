@extends('layouts.front')

@section('content')

    <!-- Page Header Section Starts Here -->
<section class="page-header">
    <div class="container">
        <div class="page-header-wrapper">
            <div class="page-header-content">
                <h2 class="title"><span class="text-generic-green">Search</span>Results</h2>
                <ul class="breadcrumb bg-none">
                    <li>
                        <a href="{{ url('') }}">Home</a>
                    </li>
                    <li>Search Results</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Page Header Section EndsHere -->

<!-- Blog Section Starts Here -->
<div class="blog-section-area padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article>
                    <div class="blog-wrapper">
                        @foreach ($posts as $post)
                            <div class="post-item style-two">
                                <div class="post-thumb">
                                    <a href="blog-details.html"><img src="{{ asset('storage/images/post/'.$post->header_image) }}" alt="{{ $post->title }}"></a>
                                </div>
                                <div class="post-content">
                                    <div class="post-header">
                                        <h4 class="title"><a href="{{ url('blog/'.Str::slug(ucwords($post->title))) }}">{{ $post->title }}</a></h4>
                                        <p>{{ $post->short_desc }}</p>
                                    </div>
                                    <div class="meta-post d-flex flex-wrap justify-content-between">
                                        <div class="meta-date">
                                            <a href="#"><i class="far fa-calendar-alt"></i> <span> {{ $post->created_at->format('F d, Y') }} </span></a>
                                        </div>
                                        <div class="meta-comment">
                                            <a href="#"><i class="far fa-comment"></i> <span>Comment</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- <div class="post-item blog-video style-two">
                            <div class="post-thumb">
                                <a href="blog-details.html"><img src="assets/images/blog/05.jpg" alt="blog"></a>
                                <div class="blog-video-icon-wrapper">
                                    <a href="https://www.youtube.com/embed/yfoY53QXEnI" data-rel="lightcase:myCollection"><img src="assets/images/blog/video-button.png" alt="blog-button"></a>
                                </div>
                            </div>
                            <div class="post-content">
                                <div class="post-header">
                                    <h4 class="title"><a href="blog-details.html">Sent to Prison by a Software Program’s Secret
                                            Algorithms</a></h4>
                                    <p>Euismod hendrerit, metus ac rem sagittis justo velit. Volutpat ut, est sed et
                                        tincidunqusum consectetuer blandit eros. Vestibulum diam nec. Ridiculus
                                        justo
                                        volutpat dictueget odiulus gravida arcu aliquam pede fringilla. Ante et
                                        vestibulum sed. Eros felis mollis pharetrsper id ac, mus et posuere proin
                                        mauris
                                        donec vivamus. Aliqueaquam, odio sodales dapibus
                                        over the wold choose </p>
                                </div>
                                <div class="meta-post d-flex flex-wrap justify-content-between">
                                    <div class="meta-date">
                                        <a href="#"><i class="far fa-calendar-alt"></i> <span>29 May 2019</span></a>
                                    </div>
                                    <div class="meta-comment">
                                        <a href="#"><i class="far fa-comment"></i> <span>Comment</span></a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- <div class="post-item blockquote-item style-two">
                            <blockquote class="blog-blockquote">
                                Lorem ipsum dolor sit amet, luctus odio odio magna pquatus. In pellentesque ipsum
                                nulla,
                                lectus at faucibus quis ac tortor. Cras cies, purus dolor
                                <span class="title">admo nuna</span>
                            </blockquote>
                        </div> -->
                    </div>

                    <div class="blog-pagination d-flex flex-wrap justify-content-flex-start">
                        <a href="#" class="pagination-item"><i class="fas fa-angle-left"></i></a>
                        <a href="#" class="pagination-item active">02</a>
                        <a href="#" class="pagination-item">03</a>
                        <a href="#" class="pagination-item">04</a>
                        <a href="#" class="pagination-item">05</a>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <a href="#" class="pagination-item">85</a>
                        <a href="#" class="pagination-item"><i class="fas fa-angle-right"></i></a>
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="sidebar">
                    {{-- Search Form --}}
                    <div class="widget widget-search">
                        <form class="widget-form" action="{{ url('search/') }}">
                            <input type="text" name="title" placeholder="Search in here">
                            <label for="w1"><i class="fas fa-search"></i></label>
                            <input type="submit" value="Search" id="w1">
                        </form>
                    </div>
                    {{-- Post categories --}}
                    <div class="widget widget-category">
                        <h5 class="widget-title">news categories</h5>
                        <ul>
                            @foreach ($categories as $category)
                                <li><a href="{{ url('search/?cat='.urlencode(strtolower($category->title))) }}">{{ $category->title }} <span>32</span></a></li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Post Tags --}}
                    <div class="widget widget-tags">
                        <h5 class="widget-title">tags</h5>
                        <div class="tag-item-wrapper">
                            @foreach ($tags as $tag)
                                <a href="{{ url('search?tag='.urlencode(strtolower($tag->title))) }}" class="tag-item">{{ $tag->title }}</a>
                            @endforeach
                        </div>
                    </div>

                    <!-- <div class="widget widget-banner">
                        <div class="widget-banner-thumb">
                            <img src="assets/images/blog/07.jpg" alt="blog-banner">
                        </div>
                        <div class="widget-banner-content">
                            <h4>add banner</h4>
                            <a href="#" class="custom-button">buy now</a>
                        </div>
                    </div> -->

                </aside>
            </div>
        </div>
    </div>
</div>
<!-- Blog Section Starts Here -->
    
@endsection