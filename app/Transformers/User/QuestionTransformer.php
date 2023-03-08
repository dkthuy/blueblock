<?php

namespace App\Transformers\User;

use App\Models\Question;
use Flugg\Responder\Transformers\Transformer;

class QuestionTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Models\Question $question
     * @return array
     */
    public function transform(Question $question)
    {
        return [
            'id' => $question->id,
            'type' => $question->type,
            'question' => $question->question,
            'answers' => $question->answers,
            'have_other_option' => $question->have_other_option,
            'other_option_name' => $question->other_option_name,
            'order' => $question->order,
            'is_required' => $question->is_required,
            'options' => $question->options,
            'created_at' => $question->created_at,
            'updated_at' => $question->updated_at,
        ];
    }
}
