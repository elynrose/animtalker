<?php

namespace App\Http\Requests;

use App\Models\AgeGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAgeGroupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('age_group_create');
    }

    public function rules()
    {
        return [
            'age' => [
                'string',
                'nullable',
            ],
        ];
    }
}
