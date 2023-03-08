<?php

namespace App\Services\Question;

use App\Contracts\Repositories\QuestionRepositoryContract;
use App\Enums\QuestionTypeEnum;
use App\Models\Question;
use App\Services\Question\Factories\InputQuestionFactory;
use App\Services\Question\Factories\MultipleChoiceQuestionFactory;
use App\Services\Question\Factories\SingleChoiceQuestionFactory;
use App\Services\Question\Factories\UploadImageQuestionFactory;
use Illuminate\Support\Collection;

class QuestionBuilder implements \App\Contracts\Services\Question\QuestionBuilder
{
    public const RULE_KEY = 'qanda';
    private Collection $questions;
    private QuestionRepositoryContract $questionRepository;

    public function __construct(QuestionRepositoryContract $questionRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->questions = $this->getQuestionFromDatabase();
    }

    private function getQuestionFromDatabase(): Collection {
        return $this->questionRepository->all();
    }

    public function makeQuestionFactory(Question $question): \App\Contracts\Services\Question\QuestionFactory {
        switch ($question->type) {
            case QuestionTypeEnum::SINGLE_CHOICE:
                return new SingleChoiceQuestionFactory($question);
            case QuestionTypeEnum::MULTIPLE_CHOICE:
                return new MultipleChoiceQuestionFactory($question);
            case QuestionTypeEnum::INPUT:
            case QuestionTypeEnum::TEXTAREA:
                return new InputQuestionFactory($question);
            case QuestionTypeEnum::UPLOAD_IMAGES:
                return new UploadImageQuestionFactory($question);
            default:
                throw new \Exception('Missing or wrong question type!');
        }
    }

    public function buildRuleBaseOnRequestData(array $requestData): array {
        /**
         * @var Question $question
         */
        $newRules = [
            self::RULE_KEY => [
                'required',
                'array',
                'min:' . $this->questions->where('is_required', true)->count(),
            ],
        ];
        if (empty($requestData[self::RULE_KEY])) {
            return $newRules;
        }
        foreach ($requestData[self::RULE_KEY] as $index => $answerData) {
            $newRules[self::RULE_KEY . '.' . $index . '.question_id'] = [
                'required',
                'exists:questions,id'
            ];
            if (empty($answerData['question_id'])) {
                continue;
            }
            $question = $this->questions->where('id', $answerData['question_id'])->first();
            if (empty($question)) {
                throw new \Exception('Can not find the question!');
            }
            $questionFactory = $this->makeQuestionFactory($question);
            $rules = $questionFactory->rules();
            // format rules
            foreach ($rules as $key => $rule) {
                $newKey = self::RULE_KEY . '.' . $index . '.' . $key;
                $newRules[$newKey] = $this->formatRules($rule, $index);
            }
        }
        return $newRules;
    }
    private function formatRules($rules, int $index) {
        if (! is_array($rules)) {
            return $this->formatSingleRule($rules, $index);
        }
        foreach ($rules as &$rule) {
            $rule = $this->formatSingleRule($rule, $index);
        }
        return $rules;
    }

    private function formatSingleRule(string $rule, int $index): string {
        return str_replace('#this', self::RULE_KEY . '.' . $index, $rule);
    }
}
