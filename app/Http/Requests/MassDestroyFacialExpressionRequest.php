<?php

namespace App\Http\Requests;

use App\Models\FacialExpression;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFacialExpressionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('facial_expression_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:facial_expressions,id',
        ];
    }
}
