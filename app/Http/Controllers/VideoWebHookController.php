<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\GenerateVideo;
use App\Models\Clip;

class VideoWebHookController extends Controller
{
    //use this to check the status of the video generation
    public function getVideoStatus(Request $request)
    {
        $videoId = $request->input('video_id');
        $response = Http::withToken(env('DID_API_KEY'))
            ->get('https://api.d-id.com/talks/' . $videoId);
       
            if ($response->successful()) {
            $status = $response->json()['status'];

            // Update the status in the database
            $clips = Clip::where('video_id', $videoId)->first();
            $clips->status = $status;
            $clips->video_path = $response->json()['result_url'];
            $clips->save();
            $clips->save();

            return response()->json(['status' => $status]);
        } else {
            return response()->json(['error' => 'Failed to get video status'], 500);
        }
    }
}