<?php

namespace App\Http\Requests;

use App\Models\HeadShape;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHeadShapeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('head_shape_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:head_shapes,id',
        ];
    }
}
