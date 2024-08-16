<?php

namespace App\Http\Requests;

use App\Models\NoseShape;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyNoseShapeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('nose_shape_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:nose_shapes,id',
        ];
    }
}
