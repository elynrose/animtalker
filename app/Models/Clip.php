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

    public const VOICE = [
        'alloy' => 'Alloy',
        'echo' => 'Echo',
        'fable' => 'Fable',
        'onyx' => 'Onyx',
        'nova' => 'Nova',
        'shimmer' => 'Shimmer',
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

    protected $fillable = [
        'character_id',
        'script',
        'i_own_music',
        'status',
        'cost',
        'voice',
        'video_path',
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
