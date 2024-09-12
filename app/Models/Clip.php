<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Clip extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'clips';

    protected $appends = [
        'audio_file',
        'music_layer',
        'video',
    ];

    public const PRIVACY_RADIO = [
        '0' => 'Private',
        '1' => 'Public',
    ];
    
    public const ASPECTRATIO = [
        '16:9' => 'Landscape',
        '9:16' => 'Portrait',
    ];


    public const VOICE = [
        'alloy' => 'Alloy - Male',
        'echo' => 'Steve - Male',
        'fable' => 'Maxim - Male',
        'onyx' => 'Michael - Male',
        'nova' => 'Sarah - Female',
        'shimmer' => 'Zack - Unisex',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        '1' => 'New',
        '2' => 'Processing',
        '3' => 'Completed',
    ];

    public const ART = [
        "Fresco"=> "Fresco",
        "Impressionism"=> "Impressionism",
        "Pop Art"=> "Pop Art",
        "Realism"=> "Realism",
        "Surrealism"=> "Surrealism",
        "Abstract"=> "Abstract",
        "Cubism"=> "Cubism",
        "Expressionism"=> "Expressionism",
        "Minimalism"=> "Minimalism",
        "Modern"=> "Modern",
        "Postmodern"=> "Postmodern",
        "Renaissance"=> "Renaissance",
        "Romanticism"=> "Romanticism",
        "Symbolism"=> "Symbolism",
        "Baroque"=> "Baroque",
        "Gothic"=> "Gothic",
        "Rococo"=> "Rococo",
        "Neoclassicism"=> "Neoclassicism",
        "Pre-Raphaelite"=> "Pre-Raphaelite",
        "Victorian"=> "Victorian",
        "Art Nouveau"=> "Art Nouveau",
        "Art Deco"=> "Art Deco",
        "Arts and Crafts"=> "Arts and Crafts",
        "Bauhaus"=> "Bauhaus",
        "De Stijl"=> "De Stijl",
        "Futurism"=> "Futurism",
        "Constructivism"=> "Constructivism",
        "Dada"=> "Dada",
        "Surrealism"=> "Surrealism",
        "Abstract Expressionism"=> "Abstract Expressionism",
        "Color Field"=> "Color Field",        

    ];

    protected $fillable = [
        'character_id',
        'script',
        'i_own_music',
        'status',
        'cost',
        'voice',
        'video_path',
        'duration',
        'video_id',
        'audio_path',
        'privacy',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id');
    }

    public function getAudioFileAttribute()
    {
        return $this->getMedia('audio_file')->last();
    }

    public function getMusicLayerAttribute()
    {
        return $this->getMedia('music_layer')->last();
    }

    public function getVideoAttribute()
    {
        return $this->getMedia('video')->last();
    }
}
