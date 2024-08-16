<?php

namespace App\Http\Requests;

use App\Models\AgeGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAgeGroupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('age_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:age_groups,id',
        ];
    }
}
