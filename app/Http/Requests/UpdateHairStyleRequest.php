<?php

namespace App\Http\Requests;

use App\Models\HairStyle;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHairStyleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hair_style_edit');
    }

    public function rules()
    {
        return [
            'style' => [
                'string',
                'nullable',
            ],
        ];
    }
}
