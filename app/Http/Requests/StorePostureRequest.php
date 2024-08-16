<?php

namespace App\Http\Requests;

use App\Models\Posture;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePostureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('posture_create');
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
