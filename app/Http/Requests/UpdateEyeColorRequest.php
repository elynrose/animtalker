<?php

namespace App\Http\Requests;

use App\Models\EyeColor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEyeColorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('eye_color_edit');
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
