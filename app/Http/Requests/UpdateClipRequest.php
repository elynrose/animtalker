<?php

namespace App\Http\Requests;

use App\Models\Clip;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateClipRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('clip_edit');
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
            'video_path' => [
                'string',
                'nullable',
            ],
            'saved' => [
                'integer',
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
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
