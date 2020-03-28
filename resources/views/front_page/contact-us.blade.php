@extends('layouts.front')

@section('content')

<!-- Page Header Section Starts Here -->
<section class="page-header">
    <div class="container">
        <div class="page-header-wrapper">
            <div class="page-header-content">
                <h2 class="title"><span class="text-generic-green">CONTACT</span>US</h2>
                <ul class="breadcrumb bg-none">
                    <li>
                        <a href="{{ url('') }}">Home</a>
                    </li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Page Header Section EndsHere -->

<!-- Contact Section Starts Here -->
<section class="contact-section padding-top padding-botom">
    <div class="container">
        <div class="col-md-8 offset-2">
            <contact-form :form-config="{is_title: true}" class="mb-3"></contact-form>
        </div>
    </div>
</section>
<!-- Contact Section Ends Here -->

@endsection