@extends('layouts.back')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="contacts-tab" data-toggle="pill" href="#contacts" role="tab" aria-controls="contacts" aria-selected="true">Contacts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="subscribers-tab" data-toggle="pill" href="#subscribers" role="tab" aria-controls="subscribers" aria-selected="false">Subscribers</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="contacts" role="tabpanel" aria-labelledby="contacts">
                        <contact-manager :initial-contacts="{{ $contacts }}"></contact-manager>
                    </div>
                    <div class="tab-pane fade" id="subscribers" role="tabpanel" aria-labelledby="subscribers">
                        <subscriber-manager :initial-subscribers="{{ $subscribers }}"></subscriber-manager>
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