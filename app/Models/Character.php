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
        'scene_id',
        'gender_id',
        'age_group_id',
        'body_type_id',
        'hair_color_id',
        'hair_lenght_id',
        'hair_style_id',
        'head_shape_id',
        'nose_shape_id',
        'mouth_shape_id',
        'eye_shape_id',
        'eye_color_id',
        'skin_tone_id',
        'facial_expression_id',
        'emotion_id',
        'dress_style_id',
        'posture_id',
        'character_zoom_id',
        'caption',
        'custom_prompt',
        'avatar_url',
        'aspect_ratio',
        'art_style',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
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

    public function scene()
    {
        return $this->belongsTo(Background::class, 'scene_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class, 'age_group_id');
    }

    public function body_type()
    {
        return $this->belongsTo(BodyType::class, 'body_type_id');
    }

    public function hair_color()
    {
        return $this->belongsTo(HairColor::class, 'hair_color_id');
    }

    public function hair_lenght()
    {
        return $this->belongsTo(HairLength::class, 'hair_lenght_id');
    }

    public function hair_style()
    {
        return $this->belongsTo(HairStyle::class, 'hair_style_id');
    }

    public function head_shape()
    {
        return $this->belongsTo(HeadShape::class, 'head_shape_id');
    }

    public function nose_shape()
    {
        return $this->belongsTo(NoseShape::class, 'nose_shape_id');
    }

    public function mouth_shape()
    {
        return $this->belongsTo(MouthShape::class, 'mouth_shape_id');
    }

    public function eye_shape()
    {
        return $this->belongsTo(EyeShape::class, 'eye_shape_id');
    }

    public function eye_color()
    {
        return $this->belongsTo(EyeColor::class, 'eye_color_id');
    }

    public function skin_tone()
    {
        return $this->belongsTo(SkinTone::class, 'skin_tone_id');
    }

    public function facial_expression()
    {
        return $this->belongsTo(FacialExpression::class, 'facial_expression_id');
    }

    public function emotion()
    {
        return $this->belongsTo(Emotion::class, 'emotion_id');
    }

    public function dress_style()
    {
        return $this->belongsTo(DressStyle::class, 'dress_style_id');
    }

    public function dress_colors()
    {
        return $this->belongsToMany(DressColor::class);
    }

    public function props()
    {
        return $this->belongsToMany(Prop::class);
    }

    public function posture()
    {
        return $this->belongsTo(Posture::class, 'posture_id');
    }

    public function character_zoom()
    {
        return $this->belongsTo(Zoom::class, 'character_zoom_id');
    }

    public function getAvatarAttribute()
    {
        $file = $this->getMedia('avatar')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
