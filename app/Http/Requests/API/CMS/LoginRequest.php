<?php

namespace App\Http\Requests\API\CMS;

use App\Enums\RegexValidationEnum;
use App\Http\Requests\API\BaseRequest;

class LoginRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'login_id' => [
                'required',
                'max:100',
                'regex:' . RegexValidationEnum::HALF_WIDTH_WORD_NUMBER_REGEX,
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:100',
            ],
        ];
    }
}
