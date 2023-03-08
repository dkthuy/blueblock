<?php

namespace App\Services\Question\Factories;

use App\Enums\RegexValidationEnum;
use App\Models\Question;
use App\Services\Question\QuestionFactory;

class InputQuestionFactory extends QuestionFactory
{
    public function rules(): array
    {
        return [
            'answers'      => [$this->question->is_required ? 'required' : 'nullable', 'array'],
            'answers.*'    => [$this->question->is_required ? 'required' : 'nullable', 'string'],
        ];
    }
}
