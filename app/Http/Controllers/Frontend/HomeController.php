<?php

namespace App\Http\Controllers\Frontend;

class HomeController
{
    public function index()
    {
        return view('frontend.s');
    }



    public function pricing()
    {
        return view('frontend.pricing');
    }
}
