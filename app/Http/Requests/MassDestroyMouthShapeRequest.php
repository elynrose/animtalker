<?php

namespace App\Http\Requests;

use App\Models\MouthShape;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMouthShapeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('mouth_shape_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:mouth_shapes,id',
        ];
    }
}
