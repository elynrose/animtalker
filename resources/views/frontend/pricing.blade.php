@extends('layouts.frontend')

@section('content')

</head>
<body>

    
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12" style="background:url({{ asset('images/banner.png') }}); min-height:750px; background-size:cover;">
        <div class="pricing-header">
            <h1 class="display-4">Our Pricing Plan</h1>
            <p class="lead">We currently have one plan.</p>
        </div>
        <div class="container">
        <div class="row  justify-content-center">
            <!-- Basic Package -->
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">Starter Package</h3>
                    <div class="card-body">
                        <div class="card-price">{{ _('$10')}}<span class="text-muted"></span></div>
                        <ul class="list-unstyled text-center">
                            <li>5 videos </li>
                            <li>2 credits per video</li>
                            <li>0.5 credit per character</li>
                        </ul>
                        @if(Auth::check())
                        <div class="mt-3 text-center">
                            <a href="https://buy.stripe.com/4gwaHYa690SF0a4bII" class="btn btn-custom">Buy Now</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Standard Package 
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Standard</div>
                    <div class="card-body">
                        <div class="card-price">$27.85<span class="text-muted">/mo</span></div>
                        <ul class="list-unstyled">
                            <li>50 videos per month</li>
                            <li>0.56 credits per video</li>
                            <li>18.75 total minutes</li>
                        </ul>
                        <div class="text-center">
                            <a href="#" class="btn btn-custom">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>-->

            <!-- Premium Package
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Premium</div>
                    <div class="card-body">
                        <div class="card-price">$44.55<span class="text-muted">/mo</span></div>
                        <ul class="list-unstyled">
                            <li>80 videos per month</li>
                            <li>0.56 credits per video</li>
                            <li>30 total minutes</li>
                        </ul>
                        <div class="text-center">
                            <a href="#" class="btn btn-custom">Get Started</a>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        </div>
    </div>
    </div>
    </div>



@endsection

@section('scripts')

@parent
    <!-- Bootstrap 4 JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
@endsection