<?php

namespace App\Http\Requests;

use App\Models\Posture;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePostureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('posture_edit');
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
