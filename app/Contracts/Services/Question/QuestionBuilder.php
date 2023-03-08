<?php

namespace App\Contracts\Services\Question;

interface QuestionBuilder
{
    public function buildRuleBaseOnRequestData(array $requestData);
}
