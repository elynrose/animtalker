<?php

namespace App\Http\Requests;

use App\Models\MouthShape;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMouthShapeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mouth_shape_edit');
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
