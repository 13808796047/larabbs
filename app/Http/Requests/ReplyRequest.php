<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'content' => 'requried|min:2',
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
