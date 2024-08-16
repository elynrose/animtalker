<?php

namespace App\Http\Requests;

use App\Models\EyeColor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEyeColorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('eye_color_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:eye_colors,id',
        ];
    }
}
