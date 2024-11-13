<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Character extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'characters';

    protected $appends = [
        'avatar',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'custom_prompt',
        'voice',
        'script',
        'avatar_url',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'parent_id',
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

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 519, 519);
        $this->addMediaConversion('preview')->fit('crop', 1920, 1080);
    }

    public function getAvatarAttribute()
    {
        $file = $this->getMedia('avatar')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        } else {
            $file = new \stdClass();
            $file->url = null;
            $file->thumbnail = null;
            $file->preview = null;
        }

        return $file;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
