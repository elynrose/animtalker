@extends('layouts.frontend')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12" style="background:url({{ asset('images/banner.png') }}); min-height:750px; background-size:cover;">
        <div class="container">
        <div class="row py-5">
            <div class="col-md-6">
                <h1>AnimShorts</h1>
                <h4>Generate Short Animations in less than 5 minutes.</h4>
                <img src="{{ asset('images/Characters.png') }}" class="img-fluid" alt="Hero Image">
            </div>
            <div class="col-md-6"></div>
         </div>

         <div class="row justify-content-center">
            <div class="col-md-12">
                <h2>How it works</h2>
                <div class="row">
                    <div class="col-md-3 shadow">
                        <h4>Step 1</h4>
                        <p>Generate a character</p>
                        <img src="{{ asset('images/step-1.png') }}" class="img-fluid" alt="Step 1">
                    </div>
                    <div class="col-md-3 shadow">
                        <h4>Step 2</h4>
                        <p>Choose a background</p>
                        <img src="{{ asset('images/step-2.png') }}" class="img-fluid" alt="Step 2">
                    </div>
                    <div class="col-md-6">
                        <h4>Step 3</h4>
                        <p>Choose a voice</p>
                       <video src="{{ asset('images/video.mp4') }}" class="img-fluid" controls></video>
                    </div>
                </div>
            </div>
         </div>
        </div>
        </div>
    </div>
</div>
@endsection