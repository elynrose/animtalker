<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Clip;

class HomeController
{
    public function index()
    {
        $clips = Clip::with(['character', 'media'])
        ->where('status', 'completed')
        ->where('saved', 1)
        ->whereHas('character', function ($query) {
        $query->where('user_id', '!==', auth()->user()->id);
        })
        ->orderBy('id', 'desc')->get();

        return view('frontend.home', compact('clips'));
    }



    public function pricing()
    {
        return view('frontend.pricing');
    }
}
