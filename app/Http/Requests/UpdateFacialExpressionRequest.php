<?php

namespace App\Http\Requests;

use App\Models\FacialExpression;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFacialExpressionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('facial_expression_edit');
    }

    public function rules()
    {
        return [
            'expression' => [
                'string',
                'nullable',
            ],
        ];
    }
}
