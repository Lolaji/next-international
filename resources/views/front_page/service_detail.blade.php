@extends('layouts.front')

@section('content')

@include('front_page.parts.page_header')

<!-- Service Section Starts Here -->
<div class="service-details padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article>
                    <div class="tour-details-item">
                        <div class="tour-details-thumb">
                            <img src="{{ asset('storage/images/service/'.$service['header_image']) }}" alt="{{ $service['title'] }}">
                        </div>
                        <h3 class="title">
                            {{ $service['title'] }} 

                            @if (Auth::check() && Auth::user()->is_admin)
                                <sup>
                                    <a href="/backoffice/service/update/{{ $service['id'] }}" style="font-size: 15px"><span class="badge badge-success"><i class="fa fa-pencil-alt"></i> edit</span></a>
                                </sup>
                            @endif
                        </h3>
                        
                        @php
                            echo $service['content']
                        @endphp
                        
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <aside>
                    <div class="widget widget-tour">
                        <h5 class="widget-title">Other Services</h5>
                        <ul>
                            @foreach ($other_services as $serv)
                                <li> <a href="{{ url('services/'.Str::slug(strtolower($serv['title']))) }}">{{ $serv['title'] }}</a></li>
                            @endforeach
                            
                        </ul>
                    </div>
                    
                    {{-- <div class="widget widget-download">
                        <h5 class="widget-title">Download File</h5>
                        <ul>
                            <li> <a href="#">Download PDF</a></li>
                            <li> <a href="#">Download Doc</a></li>
                            <li> <a href="#">Download Text</a></li>
                        </ul>
                    </div> --}}
                    
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- Service Section Ends Here -->

@endsection