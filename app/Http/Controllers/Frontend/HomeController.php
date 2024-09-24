<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Clip;

class HomeController
{
    public function index()
    {
        $clips = Clip::with(['character', 'media'])
        ->where('status', 'completed')
        ->where('privacy', 0)  
        ->where('saved', 1)
        ->whereHas('character', function ($query) {
        $query->where('user_id', '!=', auth()->user()->id);
        })
        ->orderBy('id', 'desc')->paginate(9);

        return view('frontend.home', compact('clips'));
    }



    public function pricing()
    {
        return view('frontend.pricing');
    }
}
