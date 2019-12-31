<?php

namespace App\Http\Requests\Api;


class ReplyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'con' => 'required|min:2'
        ];
    }
}
