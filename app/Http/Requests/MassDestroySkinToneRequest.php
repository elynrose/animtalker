<?php

namespace App\Http\Requests;

use App\Models\SkinTone;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySkinToneRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('skin_tone_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:skin_tones,id',
        ];
    }
}
