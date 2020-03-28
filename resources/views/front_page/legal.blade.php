@extends('layouts.front')

@section('content')

<!-- Page Header Section Starts Here -->
<section class="page-header">
    <div class="container">
        <div class="page-header-wrapper">
            <div class="page-header-content">
                <h2 class="title text-generic-dark_blue">@php
                    echo $header_title
                @endphp</h2>
                <ul class="breadcrumb bg-none">
                    <li><a href="index.php">Home</a></li>
                    <li>{{ $page_title }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Page Header Section EndsHere -->

<!-- Privacy policy Section Starts Here -->
<div class="details-blog-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <article class="details-blog-wrapper">
                    <div class="post-item style-two style-three">

                        <div class="post-content">
                            <div class="meta-post d-flex flex-wrap border-bottom mb-5">
                                <div class="meta-date">
                                    <p class="font-weight-bold">Last Updated : <span class="font-weight-light">11 August, 2019</span></p>
                                </div>
                            </div>

                            <div class="entry-content">
                                @php
                                    echo $content
                                @endphp
                            </div>

                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
<!-- Privacy policy Section Starts Here -->

@endsection