<?php

namespace App\Http\Requests;

use App\Models\HairStyle;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreHairStyleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hair_style_create');
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
