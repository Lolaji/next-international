@extends('layouts.front')

@section('content')

<!-- Page Header Section Starts Here -->
<section class="page-header">
    <div class="container">
        <div class="page-header-wrapper">
            <div class="page-header-content">
                <h2 class="title"><span class="text-generic-green">OUR</span>SERVICES</h2> 
                <ul class="breadcrumb bg-none">
                    <li>
                        <a href="{{ url('') }}">Home</a>
                    </li>
                    <li>Services</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Page Header Section EndsHere -->

<!-- Service Section Starts Here -->
<section class="service-section padding-bottom padding-top border-bottom">
    <div class="container">
        <div class="row mb-30-none">
            <div class="wt-categoryexpl">

                @foreach ($services as $service)
                    <div class="col-12 col-sm-12 col-md-3 col-lg-4 float-left mb-4">
                        <div class="wt-categorycontent">
                            <figure><img src="{{ asset('storage/images/service/'.$service->overview_icon) }}" alt="{{ $service->title }}"></figure>
                            <div class="wt-cattitle">
                                <h3><a href="{{ url('services/'.strtolower(Str::slug($service->title))) }}" class="text-generic-green">{{ $service->title }}</a></h3>
                            </div>
                            <div class="wt-categoryslidup">
                                <p>{{ $service->short_desc }}</p>
                                <a href="{{ url('services/'.strtolower(Str::slug($service->title))) }}">Read More <i class="fa fa-arrow-right"></i></a>

                                @if (Auth::check() && Auth::user()->is_admin)
                                    | <a href="/backoffice/service/update/{{ $service->id }}"><span class="badge badge-success"><i class="fa fa-pencil-alt"></i> edit</span></a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>
        </div>
    </div>
</section>
<!-- Service Section Ends Here -->

{{-- <section class="call-in-contact-area padding-top padding-bottom">
    <div class="container">
        <div class="row mb-30-none text-center">
            <div class="col-lg-4 col-md-6">
                <div class="card" style="height: 420px;">
                    <div class="card-body">
                        <div class="about-info-item">
                            <h4 class="sub-title">You first, us next.</h4>
                            <p>At Next International, we believe the best way to attract top talent is not by flaunting our own competitive benefits,
                                but by promoting those of our clients. And we do so with the top professionals in the field through direct headhunting rather than
                                the exclusive use of job boards. We get their attention, present your opportunity, and begin the dialogue.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card" style="height: 420px;">
                    <div class="card-body">
                        <div class="about-info-item">
                            <h4 class="sub-title">Building a relationship</h4>
                            <p>Sourcing specialized talent may start out with the mechanics of matching position requirements with candidate experience,
                                but the right fit always comes down to synergy between the candidate and the team.
                                Our thorough understanding of our clients and candidates allows us to lay the groundwork for a successful, long-term relationship for both parties.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card" style="height: 420px;">
                    <div class="card-body">
                        <div class="about-info-item">
                            <h4 class="sub-title">Commitment</h4>
                            <p>We understand that the viability of our clients' programs fully depend on the fulfillment of key roles.
                                So when it comes to the launch of a large-scale project, we do not expect our clients to be satisfied
                                with recruiters too busy to provide updates and candidates who are just shopping around. At Next International,
                                we work with a select few clients who have our complete commitment and who, in turn, rely on us for the fulfillment of their critical needs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- Service Section Ends Here -->
<section class="faq-section padding-bottom padding-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0">

                <h2 class="faq-title">Frequently Asked Questions</h2>
                <span class="shape">
                    <span class="shape-inner"></span>
                </span>

                <accordion-list :initial-list="{{ $faqs }}" :list-type="'faq'"></accordion-list>
            </div>

            <div class="col-lg-6">
                <h2 class="faq-title">Contact Us Now</h2>
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