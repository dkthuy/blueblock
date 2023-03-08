<?php

namespace App\Http\Requests\API\CMS\Admin;

use App\Enums\CMS\AdminStatusEnum;
use App\Enums\CMS\RoleEnum;
use App\Enums\RegexValidationEnum;
use App\Http\Requests\API\BaseRequest;
use App\Models\Admin;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateAdminRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        /**
         * @var Admin $currentAdmin
         */
        if (empty($this->admin)) {
            throw new NotFoundHttpException;
        }

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                'regex:' . RegexValidationEnum::EXCEPT_CODE_CHARACTERS_REGEX,
            ],
            'password' => [
                'sometimes',
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:' . RegexValidationEnum::PASSWORD_REGEX,
            ],
            'role' => [
                'sometimes',
                'required',
                'string',
                Rule::in(RoleEnum::asArray()),
            ],
            'status' => [
                'sometimes',
                'required',
                Rule::in(AdminStatusEnum::asArray()),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => '代理店コード',
            'name' => '代理店名',
        ];
    }

    public function messages(): array
    {
        return [
            'code.regex' => '半角英数字のみ有効です。',
            'password.min' => '大文字・小文字・記号・数字を含む8桁以上でご入力ください。',
            'password.regex' => '大文字・小文字・記号・数字を含む8桁以上でご入力ください。',
        ];
    }
}
