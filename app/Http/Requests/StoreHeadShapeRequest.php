<?php

namespace App\Http\Requests;

use App\Models\HeadShape;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreHeadShapeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('head_shape_create');
    }

    public function rules()
    {
        return [
            'shape' => [
                'string',
                'nullable',
            ],
        ];
    }
}
