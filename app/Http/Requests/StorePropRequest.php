<?php

namespace App\Http\Requests;

use App\Models\Prop;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePropRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('prop_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
