<?php

namespace App\Http\Requests;

use App\Models\Clip;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreClipRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('clip_create');
    }

    public function rules()
    {
        return [
            'character_id' => [
                'required',
                'integer',
            ],
            'image_path' => [
                'string',
                'nullable',
            ],
            'custom_prompt' => [
                'string',
                'nullable',
            ],
            'script' => [
                'required',
            ],
            'voice' => [
                'required',
            ],
            'audio_path' => [
                'string',
                'nullable',
            ],
            'saved' => [
                'integer',
                'nullable',
            ],
            'video_path' => [
                'string',
                'nullable',
            ],
            'duration' => [
                'string',
                'nullable',
            ],
            'minutes' => [
                'integer',
                'nullable',
            ],
            'seconds' => [
                'integer',
                'nullable',
            ],
            'video_id' => [
                'string',
                'nullable',
            ],
            'cost' => [
                'nullable',
                'integer',
            ],
        ];
    }
}
