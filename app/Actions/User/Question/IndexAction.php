<?php

namespace App\Actions\User\Question;

use App\Contracts\Repositories\QuestionRepositoryContract;
use App\Supports\Traits\HasTransformer;
use App\Transformers\User\QuestionTransformer;
use Illuminate\Http\JsonResponse;

class IndexAction
{
    use HasTransformer;

    /**
     * @var QuestionRepositoryContract
     */
    protected QuestionRepositoryContract $repository;

    /**
     * @param QuestionRepositoryContract $repository
     */
    public function __construct(QuestionRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $questions = $this->repository->list();
        return $this->httpOK($questions, QuestionTransformer::class);
    }
}
