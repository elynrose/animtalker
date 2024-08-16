<?php

namespace App\Http\Requests;

use App\Models\NoseShape;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateNoseShapeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('nose_shape_edit');
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
