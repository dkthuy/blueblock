<?php

namespace App\Actions\User\Form;

use App\Contracts\Repositories\GiftRepositoryContract;
use App\Contracts\Repositories\QuestionRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Supports\Traits\HasTransformer;
use App\Transformers\API\User\FormDataTransformer;
use Illuminate\Http\JsonResponse;

class GetFormDataAction
{
    use HasTransformer;

    protected QuestionRepositoryContract $questionRepository;

    protected UserRepositoryContract $userRepositoryContract;

    protected GiftRepositoryContract $giftRepositoryContract;

    public function __construct(
        QuestionRepositoryContract $questionRepository,
        UserRepositoryContract     $userRepositoryContract,
        GiftRepositoryContract     $giftRepositoryContract
    )
    {
        $this->questionRepository = $questionRepository;
        $this->userRepositoryContract = $userRepositoryContract;
        $this->giftRepositoryContract = $giftRepositoryContract;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $questions = $this->questionRepository->list();
        $gifts = $this->giftRepositoryContract->list();

        // get user data
        $userId = auth('api')->user()->id;
        $user = $this->userRepositoryContract->find($userId);

        return $this->httpOK([
            'gifts' => $gifts,
            'questions' => $questions,
            'user_data' => optional($user)->user_data,
        ], FormDataTransformer::class);
    }
}
