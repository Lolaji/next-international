@extends('layouts.back')

@section('content')

<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalServices }}</h3>

                <p>Total Services</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('backoffice/services') }}" class="small-box-footer">View all <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalPosts }}</h3>

                    <p>Total Post</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ url('backoffice/posts') }}" class="small-box-footer">View all <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalSubscribers }}</h3>

                <p>Total Subscribers</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ url('backoffice/contacts_subscribers') }}" class="small-box-footer">View all <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalContacts }}</h3>

                <p>Total Contacts</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ url('backoffice/contacts_subscribers') }}" class="small-box-footer">View all <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Latest Contacts</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Date</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach ($latestContacts as $contact)
                            <tr>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->address }}</td>
                                <td>{{ $contact->created_at }}</td>
                            </tr>
                          @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <a href="{{ url('backoffice/contacts_subscribers') }}" class="btn btn-sm btn-secondary float-right">View All</a>
                </div>
                <!-- /.card-footer -->
              </div>

        </section>
        <!-- /.Left col -->
        
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

            <!-- PRODUCT LIST -->
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Recent Posts</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach ($recentPost as $post)
                            <li class="item">
                                <div class="product-img">
                                    <img src="{{ asset('storage/images/post/'.$post->header_image) }}" alt="{{ $post->title }}" class="img-size-50">
                                </div>
                                <div class="product-info">
                                    <a target="__blank" href="{{ url('blog/'.Str::slug(strtolower($post->title))) }}" class="product-title">
                                        <span class="badge badge-success float-right">{{ $post->category }}</span>
                                        {{ $post->title }}
                                    </a>
                                    <span class="product-description">
                                        {{ $post->short_desc }}
                                    </span>
                                    <span><a href="{{ url('backoffice/post/update/'.$post->id) }}" class="btn btn-xs btn-dark">Edit</a></span>
                                </div>
                            </li>
                            <!-- /.item -->
                        @endforeach
                  </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                  <a href="{{ url('backoffice/posts') }}" class="uppercase">View All</a>
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
</div><!-- /.container-fluid -->

@endsection