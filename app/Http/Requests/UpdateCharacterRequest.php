<?php

namespace App\Http\Requests;

use App\Models\Character;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCharacterRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('character_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'is_realistic' => [
                'nullable',
            ],
            'scene_id' => [
                'nullable',
                'integer',
            ],
            'gender_id' => [
                'nullable',
                'integer',
            ],
            'age_group_id' => [
                'nullable',
                'integer',
            ],
            'dress_colors.*' => [
                'integer',
            ],
            'dress_colors' => [
                'array',
            ],
            'props.*' => [
                'integer',
            ],
            'props' => [
                'array',
            ],
            'caption' => [
                'string',
                'nullable',
            ],
            'avatar_url' => [
                'string',
                'nullable',
            ],
            'art_style' => [
                'string',
                'nullable',
            ],
            'aspect_ratio' => [
                'string',
                'nullable',
            ],
            'parent_id' => [
                'nullable',
                'integer',
            ],
            'custom_prompt' => [
                'string',
                'nullable',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'parent_id' => [
                'integer',
                'nullable',
            ],
        ];
    }
}
