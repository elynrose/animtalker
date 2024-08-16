<?php

namespace App\Http\Requests;

use App\Models\BodyType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBodyTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('body_type_edit');
    }

    public function rules()
    {
        return [
            'body' => [
                'string',
                'nullable',
            ],
        ];
    }
}
