@extends('layouts.frontend')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12" style="background:url({{ asset('images/banner.png') }}); min-height:750px; background-size:cover;">
            <div class="container">
                BETA
            </div>
            <div class="container">
                <div class="row py-3">
                    <div class="col-md-12">
                        <h1 class="display-4">anim<strong>shorts</strong></h1>
                        <p class="lead">Animshorts lets you create a 3D animation video in less than 3 minutes.</p>
                        <p class="text-left mt-3"><a class="btn btn-lg btn-danger" href="/pricing">Get Started</a></p>
                    </div>
                </div>

                <div class="row justify-content-center py-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 embed-responsive embed-responsive-16by9 border-glow mb-5">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/69ce5zIZ9X0?si=MYxJur7Djje9KQmN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                            <div class="col-md-6">
                                <h3 class="display-5 mb-3">What is Animshorts</h3>
                                <p class="lead">With AnimShorts, creating eye-catching talking 3d animation heads for your social media posts is a breeze. Just input your text and watch as realistic and expressive characters come to life, ready to engage your audience with up to 255 characters of witty banter. Say goodbye to boring static images and hello to dynamic and engaging content that will make your posts stand out from the crowd. Try Generate Anim Shorts today and take your social media game to the next level!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12" style="background:url({{ asset('images/banner2.png') }}); min-height:750px; background-size:cover;">
            <div class="container">
                <div class="row mt-3 mb-3">
                    <div class="col-md-12 text-center">
                        <h2 class="display-4">How it works.</h2>
                        <p class="lead"><strong>In 3 simple steps:</strong> Generate Character + Add Voice = Final Output</p>
                        <p class="text-center"><a class="btn btn-lg btn-danger" href="/pricing">Get Started</a></p>
                    </div>
                </div>

                <div class="row justify-content-center py-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="embed-responsive embed-responsive-16by9 border-glow">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/8mCHApJbANA?si=xzRpLq8t3D6cSRwJ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-12" style="background:url({{ asset('images/banner2.png') }}); background-size:cover;">
            <h2 class="display-4 text-center">Create Stunning 3D Characters</h2>
            <p class="text-center lead">Choose from a wide range of characters traits and backgrounds to suit your needs.</p>

            <div class="container">
                <div class="row mt-3 mb-3">
                    <div class="col-md-3 mb-3"><img src="{{ asset('images/photo1.png') }}" alt="Character" class="img-fluid"></div>
                    <div class="col-md-3 mb-3"><img src="{{ asset('images/photo3.png') }}" alt="Character" class="img-fluid  border-glow"></div>
                    <div class="col-md-3 mb-3"><img src="{{ asset('images/photo4.png') }}" alt="Character" class="img-fluid"></div>
                    <div class="col-md-3 mb-3"><img src="{{ asset('images/photo5.png') }}" alt="Character" class="img-fluid"></div>
                </div>

                <div class="container py-5">
                    <div class="pricing-header">
                        <h1 class="display-4">Our Pricing Plan</h1>
                        <p class="lead">We currently only have one plan.</p>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                  

                     <!-- Basic Package -->
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">Starter Package</h3>
                    <div class="card-body">
                        <div class="card-price">{{ _('$10')}}<span class="text-muted"></span></div>
                        <ul class="list-unstyled text-center">
                            <li>3 credits per video</li>
                            <li>1 credit per character</li>
                        </ul>
                        @if(Auth::check())
                        <div class="mt-3 text-center">
                            <a href="https://buy.stripe.com/4gwaHYa690SF0a4bII" class="btn btn-custom">Buy Now</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="display-4 text-center mt-5">Get in touch</h2>
            <p class="text-center lead">Tell us how we can improve your experience with Animshorts. </p>
            <p class="text-center"><a href="mailto:hello@animshorts.com">hello@animshorts.com</a></p>
            <p class="small text-center">All Rights Reserved &copy; Animshorts 2024</p>
        </div>
    </div>
</div>

@endsection
