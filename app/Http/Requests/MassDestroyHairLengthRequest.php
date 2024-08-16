<?php

namespace App\Http\Requests;

use App\Models\HairLength;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHairLengthRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('hair_length_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:hair_lengths,id',
        ];
    }
}
