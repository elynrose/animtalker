<?php

namespace App\Http\Requests;

use App\Models\DressColor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDressColorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dress_color_edit');
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
