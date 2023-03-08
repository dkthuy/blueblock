<?php

namespace App\Transformers\API\User;

use Flugg\Responder\Transformers\Transformer;

class FormDataTransformer extends Transformer
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
     * @return array
     */
    public function transform($formData)
    {
        return [
            'gifts' => $formData['gifts'],
            'questions' => $formData['questions'],
            'user_data' => $formData['user_data'],
        ];
    }
}
