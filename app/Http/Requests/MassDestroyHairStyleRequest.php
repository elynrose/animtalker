<?php

namespace App\Http\Requests;

use App\Models\HairStyle;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHairStyleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('hair_style_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:hair_styles,id',
        ];
    }
}
