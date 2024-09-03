<?php

namespace App\Http\Controllers\Frontend;

class HomeController
{
    public function index()
    {
        return view('frontend.home');
    }



    public function pricing()
    {
        return view('frontend.pricing');
    }
}
