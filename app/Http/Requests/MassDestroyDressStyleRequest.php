<?php

namespace App\Http\Requests;

use App\Models\DressStyle;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDressStyleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('dress_style_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:dress_styles,id',
        ];
    }
}
