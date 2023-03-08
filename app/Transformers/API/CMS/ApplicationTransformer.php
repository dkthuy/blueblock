<?php

namespace App\Transformers\API\CMS;

use App\Models\Application;
use Flugg\Responder\Transformers\Transformer;

class ApplicationTransformer extends Transformer
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
     * @param Application $application
     * @return array
     */
    public function transform(Application $application)
    {
        return [
            'id' => $application->id,
            'apply_date' => $application->apply_date,
            'full_name' => $application->first_name . ' ' . $application->last_name,
            'furigana_full_name' => $application->furigana_first_name . ' ' . $application->furigana_last_name,
            'gender' => $application->gender,
            'age' => $application->age,
            'post_code' => $application->post_code,
            'prefecture' => $application->prefecture,
            'city' => $application->city,
            'additional_address' => $application->additional_address,
            'telephone' => $application->telephone,
            'gift_id' => $application->gift_id,
            'gift_name' => $application->gift_name,
            'qanda' => $application->qanda,
            'apply_id' => $application->apply_id,
            'created_at' => $application->created_at,
            'updated_at' => $application->updated_at,
        ];
    }
}
