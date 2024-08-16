<?php

namespace App\Http\Requests;

use App\Models\DressColor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDressColorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('dress_color_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:dress_colors,id',
        ];
    }
}
