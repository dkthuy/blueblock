<?php

namespace App\Services\Question;

use App\Models\Question;

abstract class QuestionFactory implements \App\Contracts\Services\Question\QuestionFactory
{
    protected Question $question;
    public function __construct(Question $question)
    {
        $this->question = $question;
    }
}
