@extends('layouts.frontend')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12" style="background:url({{ asset('images/banner.png') }}); min-height:750px; background-size:cover;">
        <div class="container">
        <div class="row py-3">
            <div class="col-md-6">
                <h1>AnimShorts</h1>
                <h4>3D Animations in less than 3 minutes.</h4>
                <p><strong>In 3 simple steps:</strong> Generate Character + Add Voice = Final Output</p>
                <p class="text-left py-5"><a class="btn btn-lg btn-danger" href="/register">Get Started</a></p>

            </div>
            <div class="col-md-6"></div>
         </div>

         <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 embed-responsive-item">
                       <video src="{{ asset('images/video.mp4') }}" class="img-fluid" controls></video>
                    </div>
                    <div class="col-md-6">
                    <h3 class="mb-3">What is Animshorts</h3>
                        <p>With AnimShorts, creating eye-catching talking 3d animation heads for your social media posts is a breeze. Just input your text and watch as realistic and expressive characters come to life, ready to engage your audience with up to 255 characters of witty banter. Say goodbye to boring static images and hello to dynamic and engaging content that will make your posts stand out from the crowd. Try Generate Anim Shorts today and take your social media game to the next level!</p>
                        <p class="text-left mt-3"><a class="btn btn-lg btn-success" href="/register">Let's go</a></p>

                    </div>
                </div>
            </div>
         </div>
        </div>

        </div>
    </div>
</div>
@endsection