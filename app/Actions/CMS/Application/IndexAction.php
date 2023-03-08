<?php

namespace App\Actions\CMS\Application;

use App\Contracts\Repositories\ApplicationRepositoryContract;
use App\Supports\Traits\HasPerPageRequest;
use App\Supports\Traits\HasTransformer;
use App\Transformers\API\CMS\ApplicationTransformer;
use Illuminate\Http\JsonResponse;

class IndexAction
{
    use HasTransformer, HasPerPageRequest;

    protected ApplicationRepositoryContract $repository;

    public function __construct(ApplicationRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $data = $this->repository->paginateOrAll($this->getPerPage());

        return $this->httpOK($data, ApplicationTransformer::class);
    }
}
