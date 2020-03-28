@extends('layouts.front')

@section('content')

@include('front_page.parts.page_header')

<!-- Blog Section Starts Here -->
<div class="details-blog-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="details-blog-wrapper">
                    <div class="post-item style-two style-three">
                        <div class="post-thumb">
                            <img src="{{asset('storage/images/post/'.$post->header_image)}}" alt="{{ $post->title }}">
                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h4 class="title">
                                    {{ $post->title }}

                                    @if (Auth::check() && Auth::user()->is_admin)
                                            <a href="/backoffice/post/update/{{ $post->id }}" style="font-size: 15px"><span class="badge badge-success"><i class="fa fa-pencil-alt"></i> edit</span></a>
                                    @endif
                                </h4>
                                @php
                                    echo $post->content
                                @endphp
                            </div>

                            {{-- <div class="entry-content">
                                <div class="content-content">
                                    <div class="entry-thumb">
                                        <img src="{{asset('assets/images/blog/05.jpg')}}" alt="blog">
                                    </div>
                                    <div class="entry-thumb">
                                        <img src="{{asset('assets/images/blog/06.jpg')}}" alt="blog">
                                    </div>
                                </div>
                                <h5 class="sub-title">Checking a Website’s Security</h5>
                                <p>metus ac rem sagittis justo velit. Volutpat ut, est sed et tincidunt neque,
                                    ipsum cstVulumn diam nec. Ridiculus justo volutpat dictum eget odio in.
                                    Ridiculus gravida arcu aliqupngilla. Ante et vestibulum sed. Eros felis
                                    mollis pharetra semper id ac, mus et posuere proin mauris donec vivamus.</p>
                                <blockquote class="style-two-blockquote">
                                    Dommodo tellus feugiat, at vestibulum aliquam rhoncus nenvivra nec dui ac.
                                    Lorem leo lorem, urna sed at est dui dolor vestil sed vitae ibduelit metus
                                    culpa arcu lorem nisl adipisicing.
                                </blockquote>
                                <p>Feugiat in suspendisse purus aliquam, magnis nisl lectus velit parturient
                                    vitae, suspesseng fusce in varius luctus, et vitae aenean. Hac metus dui
                                    facilisis, mauris aenean vestibulum tincidunt arcu mollis blandit, augue
                                    class cras. Sollicitudin odio ut metus lacus non, massa duis ante imperdiet
                                    diam curabitur. </p>
                            </div> --}}

                            <div class="meta-post d-flex flex-wrap justify-content-between">
                                <div class="meta-date">
                                    <a href="#"><i class="far fa-calendar-alt"></i> <span>{{ $post->created_at->format('F d, Y') }}</span></a>
                                </div>
                                <div class="meta-comment">
                                    <a href="#"><i class="fas fa-tag"></i><span> {{ ucwords(str_replace(';', ', ', $post->tags)) }} </span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Author Details --}}
                    <div class="author">
                        <div class="author-thumb">
                            <a href="#"><img src="{{ asset('storage/images/profile/'.$post->user->image) }}" alt="{{ $post->user->name }}"></a>
                        </div>
                        <div class="author-content">
                            <h6 class="title"><a href="#">{{ $post->user->name }}</a></h6>
                            <span>Author</span>
                            <p> {{ $post->user->bio }} </p>
                        </div>
                    </div>
                    {{-- Author Details --}}

                </article>
            </div>
            <div class="col-lg-4">
                <aside>
                    <div class="widget widget-search">
                        <form class="widget-form">
                            <input type="text" placeholder="Search in here">
                            <label for="w1"><i class="fas fa-search"></i></label>
                            <input type="submit" value="Search" id="w1">
                        </form>
                    </div>
                    {{-- Post Categories --}}
                    <div class="widget widget-category">
                        <h5 class="widget-title">News Categories</h5>
                        <ul>
                            @foreach ($categories as $category)
                                <li><a href="{{ url('search/?cat='.strtolower($category->title)) }}">{{ $category->title }} </a></li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- Post Categories --}}

                    {{-- Other related news --}}
                    @if (!empty($relatedPosts->items))
                        <div class="widget widget-post">
                            <h5 class="widget-title">other related news</h5>
                            <ul>
                                @foreach ($relatedPosts as $rPost)
                                    <li>
                                        <a href="#" class="post-title"> {{ $rPost->title }} </a>
                                        <div class="meta-post">
                                            <div class="meta-date">
                                                <a href="{{ url('blog/'.Str::slug(strtolower($rPost->title))) }}"><i class="far fa-calendar-alt"></i> <span> {{ $rPost->created_at->format('F d, Y')  }} </span></a>
                                            </div>
                                            {{-- <div class="meta-comment">
                                                <a href="#"><i class="far fa-comment"></i> <span>Comment</span></a>
                                            </div> --}}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Other related news --}}
                    
                    {{-- Tags --}}
                    <div class="widget widget-tags">
                        <h5 class="widget-title">tags</h5>
                        <div class="tag-item-wrapper">
                            @for ($i = 0; $i < count($tags); $i++)
                                <a href="{{ url('search/?tag='.strtolower($tags[$i])) }}" class="tag-item">{{ $tags[$i] }}</a>
                            @endfor
                        </div>
                    </div>
                    {{-- Tags --}}
                </aside>
            </div>
        </div>
    </div>
</div>
<!-- Blog Section Starts Here -->

@endsection