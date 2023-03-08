<?php

namespace App\Http\Requests\API\CMS\Admin;

use App\Enums\CMS\AdminStatusEnum;
use App\Enums\CMS\RoleEnum;
use App\Enums\RegexValidationEnum;
use App\Http\Requests\API\BaseRequest;
use Illuminate\Validation\Rule;

class StoreAdminRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'login_id' => [
                'required',
                'max:100',
                'unique:admins,login_id',
                'regex:' . RegexValidationEnum::HALF_WIDTH_WORD_NUMBER_REGEX,
            ],
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:' . RegexValidationEnum::EXCEPT_CODE_CHARACTERS_REGEX,
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'max:100',
                'regex:' . RegexValidationEnum::PASSWORD2_REGEX,
            ],
            'role' => [
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
            'login_id' => 'ログインID',
            'name'     => '表示名',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード確認',
            'role'     => '権限',
            'status'   => 'ステータス',
        ];
    }

    public function messages(): array
    {
        return [
            'login_id.unique' => ':attributeは既に存在しました。',
            'login.regex'     => '半角英数字のみ有効です。',
            'password.regex'  => '大文字・小文字・記号を含む英数字のみ有効です。',
            'password_confirmation.regex'  => '大文字・小文字・記号を含む英数字のみ有効です。',
        ];
    }
}
