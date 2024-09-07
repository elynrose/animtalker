<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Credit extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'credits';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'points',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function deductCredits($type){
        if($type == 'video'){
             $credits = env('VIDEO_GEN_CREDITS');
        } elseif($type == 'audio'){
             $credits = env('AUDIO_GEN_CREDITS');
        } elseif($type == 'character'){ 
             $credits = env('CHARACTER_GEN_CREDITS');
        }elseif($type == 'prompt'){
             $credits = env('PROMPT_GEN_CREDITS');
        }else{
             $credits = 0;
        }
       

        //Deduct Credits
        $credit = Credit::where('email', Auth::user()->email)->first();

        if (!$credit) {
             $credit = new Credit();
             $credit->email = Auth::user()->email;
             $credit->points = 0;
             $credit->save();
         }
         
        $credit->points = $credit->points - $credits;
        $credit->save();
    }
}
