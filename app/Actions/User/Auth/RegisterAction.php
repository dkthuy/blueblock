<?php

namespace App\Actions\User\Auth;


use App\Contracts\Repositories\UserRepositoryContract;
use App\Supports\Traits\HasTransformer;
use App\Transformers\API\User\UserTransformer;
use Illuminate\Http\JsonResponse;

class RegisterAction
{
    use HasTransformer;

    protected UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $newUser = $this->repository->register();
        return $this->httpOK($newUser, UserTransformer::class);
    }
}
