@extends('layouts.front')

@section('content')

<!-- Sub-page Header Section EndsHere -->
<section class="page-header">
    <div class="container">
        <div class="page-header-wrapper">
            <div class="page-header-content">
                <h2 class="title"><span class="text-generic-green">ABOUT</span>US</h2>
                <ul class="breadcrumb bg-none">
                    <li>
                        <a href="{{ url('') }}">Home</a>
                    </li>
                    <li>
                        About
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- End of Sub-page Header Section EndsHere -->

<!-- About Us Section Starts Here -->
<section class="about-us padding-bottom padding-top">
    <div class="container">
        <div class="about-us-top">
            <div class="row mb-40-none">
                <div class="col-lg-6">
                    <div class="about-us-thumb">
                        <img src="{{asset('images/what-we-believe.jpg')}}" alt="about">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-us-content">
                        <h2 class="title">WHAT<span class="text-generic-green">WE</span>BELIEVE</h2>
                        <p>At Next, we believe collaboration and partnership with our clients is critical in order to be successful. 
                            Building successful teams and strategies means getting to know the culture and values of the organization 
                            and understanding the needs and wishes of every party involved. Since every organization has a different DNA, 
                            we know that a customized approach to any of our service offerings is necessary to facilitate long lasting business relationships.</p>
                            
                    </div>
                </div>
            </div>
        </div>

        <div class="about-us-bottom padding-top">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-us-content">
                        <h2 class="title"><span class="text-generic-green">PRO</span>ACTIVE</h2>
                        <p>It stands to reason that our proactive dedicated approach allows us to be successful in meeting our clients' needs. 
                            We take our time to know your industry, the protocols, and where to find the best people. We work closely with you to develop a 
                            sound understanding of both your current situation and ideal scenario. Whether that is to help you meet the challenging demands 
                            of defining and implementing a successful recruiting process and strategy, training your current team to be more effective or 
                            recruiting specialized talent for your organization. It's about taking the next step from vendor to partner, from competitor 
                            to collaborator and from filling a vacancy to being part of the team.</p>

                        <h5 class="sub-title">OUR<span class="text-generic-green">PROCESS</span></h5>
                        <ul class="col-md-12 process">
                            <li>strategy</li>
                            <li>Sourcing</li>
                            <li>Screening</li>
                            <li>Selection</li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-us-wrapper">
                        <div class="about-wrapper-thumb">
                            <img src="assets/images/about/04.jpg" alt="about">
                        </div>
                        <div class="about-wrapper-thumb">
                            <img src="assets/images/about/05.jpg" alt="about">
                        </div>
                        <div class="about-wrapper-thumb">
                            <img src="assets/images/about/06.jpg" alt="about">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Us Section Ends Here -->

<!-- Business Statistics Section Starts Here -->
<section class="statistics-section padding-bottom padding-top bg-light">
    <div class="container">
        <div class="row flex-wrap-reverse">
            <div class="col-lg-6">
                <div class="statistics-thumb">
                    <img src="{{asset('images/founder.jpg')}}" alt="business">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="statistics-content text-center">
                    <h2 class="statistics-title">OUR<span class="text-generic-green">FOUNDER</span></h2>
                    <span class="shape">
                        <span class="shape-inner"></span>
                    </span>
                    <p>Born and raised in the Netherlands, Will finished a Marketing Management Degree and started working in the 
                        Recruitment / Search industry in 1999. After several years with two of the largest global staffing providers 
                        in a variety of roles in the Netherlands and Canada, Will got sick which turned out to be a blessing in 
                        disguise as he decided to open Next International Inc.</p>
                    <p>Over the years, Will has successfully connected many professionals with hiring leaders across a variety of industries. 
                        He has held several progressive Leadership roles, trained numerous individuals on recruitment best practices, advised 
                        many organizations on recruitment processes and is a big advocate for creating collaboration in a fairly competitive industry 
                        by organizing Recruiter Only Meetups.</p>
                        <p>What sets Will apart from his industry peers is his dedicated proactice approach, ability to think outside the box and refreshing 
                            direct communication style which will help you stay focused!</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Business Statistics Section Ends Here -->

<!-- call in contact area Starts Here -->
<div class="call-in-contact-area">
    <div class="container">
        <div class="mb-30-none">
            <h2 class="title text-center">SHARED RISKS - SHARED REWARDS</h2>
        </div>
    </div>
</div>
<!-- call in contact area Ends Here -->

<!-- Faq Section Starts Here -->
<section class="faq-section padding-bottom padding-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-2">
                <h2 class="faq-title">CONTACT<span class="text-generic-green">US</span>NOW</h2>
                <span class="shape">
                    <span class="shape-inner"></span>
                </span>
                <contact-form :form-config="{buttonClass: 'generic-green-btn'}"></contact-form>
            </div>
        </div>
    </div>
</section>
<!-- Faq Section Ends Here -->

@endsection