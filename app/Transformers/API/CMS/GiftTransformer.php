<?php

namespace App\Transformers\API\CMS;

use App\Models\Gift;
use Flugg\Responder\Transformers\Transformer;

class GiftTransformer extends Transformer
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
     * @param Gift $gift
     * @return array
     */
    public function transform(Gift $gift)
    {
        return [
            'id' => $gift->id,
            'name' => $gift->name,
        ];
    }
}
