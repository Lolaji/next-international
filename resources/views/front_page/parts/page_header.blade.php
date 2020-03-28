<!-- Page Header Section Starts Here -->
<section class="page-header">
    <div class="container">
        <div class="page-header-wrapper">
            <div class="page-header-content">
                <!-- Page title -->
                @if (isset($subPage))
                    <h2 class="title text-generic-dark_blue">
                        @php
                            echo add_html_snipet(strtoupper($subPage), '<span class="text-generic-green">', '</span>', 'odd', '');
                        @endphp<span></h2>
                @else
                    <h2 class="title"><span class="text-generic-green">{{ $page_title }}</span></h2>
                @endif

                <!-- Breadcrumb -->
                <ul class="breadcrumb bg-none">
                    <li>
                        <a href="{{url('')}}">Home</a>
                    </li>
                    @if(isset($subPage))
                        <li><a href="{{url($page_name)}}">{{ $page_title }}</a></li>
                        <li>{{ $subPage }}</li>
                    @else
                        <li>{{ $page_title }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Page Header Section EndsHere -->