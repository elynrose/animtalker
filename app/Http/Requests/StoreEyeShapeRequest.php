<?php

namespace App\Http\Requests;

use App\Models\EyeShape;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEyeShapeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('eye_shape_create');
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
