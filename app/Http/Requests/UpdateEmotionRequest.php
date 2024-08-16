<?php

namespace App\Http\Requests;

use App\Models\Emotion;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmotionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('emotion_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
