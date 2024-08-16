<?php

namespace App\Http\Requests;

use App\Models\HairColor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHairColorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('hair_color_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:hair_colors,id',
        ];
    }
}
