<?php

namespace App\Http\Requests;

use App\Models\HairColor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreHairColorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hair_color_create');
    }

    public function rules()
    {
        return [
            'color' => [
                'string',
                'nullable',
            ],
        ];
    }
}
