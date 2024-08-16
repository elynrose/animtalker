<?php

namespace App\Http\Requests;

use App\Models\HairLength;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreHairLengthRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hair_length_create');
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
