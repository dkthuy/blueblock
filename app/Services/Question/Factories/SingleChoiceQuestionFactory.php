<?php

namespace App\Services\Question\Factories;

use App\Enums\RegexValidationEnum;
use App\Services\Question\QuestionFactory;

class SingleChoiceQuestionFactory extends QuestionFactory
{
    public function rules(): array
    {
        return [
            'answers' => [
                $this->question->is_required ? 'required_without:#this.other_answer' : 'nullable',
                'array',
            ],
            'answers.*' => [
                $this->question->is_required ? 'required' : 'nullable',
                'string',
            ],
            'other_answer' => [
                $this->question->is_required ? 'required_without:#this.answers' : 'nullable',
                'nullable',
                'string',
                'regex:' . RegexValidationEnum::EXCEPT_CODE_CHARACTERS_REGEX,
            ],
        ];
    }
}
