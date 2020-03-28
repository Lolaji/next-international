@extends('layouts.back')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="categories-tab" data-toggle="pill" href="#categories" role="tab" aria-controls="categories" aria-selected="true">Categories</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tags-tab" data-toggle="pill" href="#tags" role="tab" aria-controls="tags" aria-selected="false">Tags</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="categories" role="tabpanel" aria-labelledby="categories">
                            <category-manager></category-manager>
                        </div>
                        <div class="tab-pane fade" id="tags" role="tabpanel" aria-labelledby="tags">
                            <tag-manager></tag-manager>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    
@endsection