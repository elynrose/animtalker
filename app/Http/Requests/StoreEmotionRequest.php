<?php

namespace App\Http\Requests;

use App\Models\Emotion;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmotionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('emotion_create');
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
