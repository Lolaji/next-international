@extends('layouts.back')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="faq-tab" data-toggle="pill" href="#faq" role="tab" aria-controls="faq" aria-selected="false">FAQs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="legal-tab" data-toggle="pill" href="#legal" role="tab" aria-controls="legal" aria-selected="false">Legal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="info-tab" data-toggle="pill" href="#info" role="tab" aria-controls="info" aria-selected="false">Other Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="faq" role="tabpanel" aria-labelledby="faq">
                        <faq-manager :initial-faqs="{{ $faqs }}"></faq-manager>
                    </div>

                    <div class="tab-pane fade pt-5 pb-5" id="legal" role="tabpanel" aria-labelledby="legal">
                        <legal-manager :initial-legal="{{ $site_info }}"></legal-manager>
                    </div>

                    {{-- Other Information --}}
                    <div class="tab-pane fade pt-5 pb-5" id="info" role="tabpanel" aria-labelledby="info">

                        <site-info :initial-site-info="{{ $site_info }}"></site-info>
                        
                    </div>
                    <div class="tab-pane fade pt-5 pb-5" id="settings" role="tabpanel" aria-labelledby="settings">

                        <site-setting
                            :maintenance-mode="{{ $maintenanceMode ?? 'null' }}"></site-setting>
                        
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