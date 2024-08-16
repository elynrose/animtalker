<?php

namespace App\Http\Requests;

use App\Models\SkinTone;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSkinToneRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('skin_tone_edit');
    }

    public function rules()
    {
        return [
            'tone' => [
                'string',
                'nullable',
            ],
        ];
    }
}
