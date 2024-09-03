@extends('layouts.frontend')

@section('content')



<style>
        .pricing-header {
            text-align: center;
            padding: 50px 0;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 24px;
            text-align: center;
            padding: 20px 0;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            padding: 30px;
        }
        .card-price {
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            text-align: center;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12" style="background:url({{ asset('images/banner.png') }}); min-height:750px; background-size:cover;">
        <div class="pricing-header">
            <h1 class="display-4">Our Pricing Plans</h1>
            <p class="lead">Choose the plan that best suits your needs</p>
        </div>
        <div class="container">
        <div class="row">
            <!-- Basic Package -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Basic</div>
                    <div class="card-body">
                        <div class="card-price">$11.15<span class="text-muted">/mo</span></div>
                        <ul class="list-unstyled">
                            <li>20 videos per month</li>
                            <li>0.56 credits per video</li>
                            <li>7.5 total minutes</li>
                        </ul>
                        <div class="text-center">
                            <a href="#" class="btn btn-custom">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Standard Package -->
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
            </div>

            <!-- Premium Package -->
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
                </div>
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