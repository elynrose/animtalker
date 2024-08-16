<?php

namespace App\Http\Requests;

use App\Models\EyeShape;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEyeShapeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('eye_shape_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:eye_shapes,id',
        ];
    }
}
