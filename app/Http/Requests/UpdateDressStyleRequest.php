<?php

namespace App\Http\Requests;

use App\Models\DressStyle;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDressStyleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dress_style_edit');
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
