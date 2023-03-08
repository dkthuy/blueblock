<?php

namespace App\Http\Requests\API\User\Form;

use App\Contracts\Services\Question\QuestionBuilder;
use App\Enums\AgeEnum;
use App\Enums\RegexValidationEnum;
use App\Http\Requests\API\BaseRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\Rule;

class SubmitRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function rules(): array
    {
        // TODO: length limit between half width and full width
        $regexFullWidthJapanese = 'regex:/^[ａ-ｚＡ-Ｚ一-龠々-〇ぁ-んァ-ヶ０-９ー・]+$/u';
        $regexAddress = 'regex:/^[a-zA-Z0-9ａ-ｚＡ-Ｚ一-龠々-〇ぁ-んァ-ヶー０-９－−・　 ‐-]+$/u';

        $defaultValidations = [
            'first_name' => ['required', 'max:20', $regexFullWidthJapanese],
            'last_name' => ['required', 'max:20', $regexFullWidthJapanese],
            'furigana_first_name' => ['required', 'max:20', 'regex:' . RegexValidationEnum::KATAKANA_WORD_FULL_WIDTH],
            'furigana_last_name' => ['required', 'max:20', 'regex:' . RegexValidationEnum::KATAKANA_WORD_FULL_WIDTH],
            'gender' => ['nullable', 'regex:' . RegexValidationEnum::EXCEPT_CODE_CHARACTERS_REGEX],
            'age' => ['nullable', 'regex:' . RegexValidationEnum::EXCEPT_CODE_CHARACTERS_REGEX, Rule::in(AgeEnum::asArray())],
            'post_code' => ['required', 'size:7', 'regex:' . RegexValidationEnum::HALF_WIDTH_NUMBER_REGEX],
            'prefecture' => 'required|string',
            'city' => ['required', 'string', 'max:60', $regexAddress],
            'additional_address' => ['required', 'string', 'max:60', $regexAddress],
            'room_building_number' => ['nullable', 'string', 'max:60', $regexAddress],
            'telephone' => ['required', 'max:11', 'regex:' . RegexValidationEnum::HALF_WIDTH_NUMBER_REGEX],
            'user_data' => 'nullable|string',
            'gift_id' => 'required|exists:gifts,id',
        ];
        $questionBuilder = app()->make(QuestionBuilder::class);
        $questionRules = $questionBuilder->buildRuleBaseOnRequestData($this->all());
        return ($defaultValidations + $questionRules);
    }

    public function messages(): array
    {
        return [
            'first_name.regex' => '入力内容に誤りがあります。',
            'last_name.regex' => '入力内容に誤りがあります。',
            'furigana_first_name.regex' => '入力内容に誤りがあります。',
            'furigana_last_name.regex' => '入力内容に誤りがあります。',
            'post_code.regex' => '半角数字7桁（ハイフンなし）でご入力ください。',
            'post_code.size' => ':size文字以内でご入力ください。',
            'prefecture.required' => '都道府県を選択してください。',
            'telephone.regex' => '半角数字11桁以内（ハイフンなし）でご入力ください。',
            'city.regex' => '入力内容に誤りがあります。',
            'additional_address.regex' => '入力内容に誤りがあります。',
            'gift_id.required' => 'いずれかを選択してください。'
        ];
    }
}
