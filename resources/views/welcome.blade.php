@extends('layouts.frontend')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12" style="background:url({{ asset('images/banner.png') }}); min-height:750px; background-size:cover;">
        <div class="container">
        <div class="row py-3">
            <div class="col-md-12">
                <h1>AnimShorts</h1>
                <h4>3D Animations in less than 3 minutes.</h4>
                <H4><strong>In 3 simple steps:</strong> Generate Character + Add Voice = Final Output</H4>
                <p class="text-left py-5"><a class="btn btn-lg btn-danger" href="/register">Get Started</a></p>

            </div>
         </div>

         <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 embed-responsive-item">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/69ce5zIZ9X0?si=MYxJur7Djje9KQmN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="col-md-6">
                    <h3 class="mb-3">What is Animshorts</h3>
                        <p>With AnimShorts, creating eye-catching talking 3d animation heads for your social media posts is a breeze. Just input your text and watch as realistic and expressive characters come to life, ready to engage your audience with up to 255 characters of witty banter. Say goodbye to boring static images and hello to dynamic and engaging content that will make your posts stand out from the crowd. Try Generate Anim Shorts today and take your social media game to the next level!</p>

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
        <div class="row py-5">
                    <div class="col-md-12 text-center">
                <h4>3D Animations in less than 3 minutes.</h4>
                <p><strong>In 3 simple steps:</strong> Generate Character + Add Voice = Final Output</p>
                <p class="text-center"><a class="btn btn-lg btn-danger" href="/register">Get Started</a></p>

            </div>
         </div>

         <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/8mCHApJbANA?si=xzRpLq8t3D6cSRwJ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>                    </div>
                </div>
            </div>
         </div>
        </div>

        </div>
    </div>
</div>
@endsection