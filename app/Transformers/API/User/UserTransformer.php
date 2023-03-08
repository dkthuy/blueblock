<?php

namespace App\Transformers\API\User;

use App\Contracts\Repositories\GiftRepositoryContract;
use App\Contracts\Repositories\QuestionRepositoryContract;
use App\Models\User;
use Flugg\Responder\Transformers\Transformer;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTransformer extends Transformer
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
     * @param  \App\Models\User $user
     * @return array
     */
    public function transform(User $user)
    {
        $questionRepository = app()->make(QuestionRepositoryContract::class);
        $giftRepository = app()->make(GiftRepositoryContract::class);

        return [
            'id' => $user->id,
            'questions' => $questionRepository->list(),
            'gifts' => $giftRepository->list(),
            'token' => JWTAuth::fromUser($user),
        ];
    }
}
