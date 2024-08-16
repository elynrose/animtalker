<?php

namespace App\Http\Requests;

use App\Models\HairLength;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHairLengthRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hair_length_edit');
    }

    public function rules()
    {
        return [
            'lenght' => [
                'string',
                'nullable',
            ],
        ];
    }
}
