<?php

namespace App\Http\Requests;

use App\Models\BodyType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBodyTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('body_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:body_types,id',
        ];
    }
}
