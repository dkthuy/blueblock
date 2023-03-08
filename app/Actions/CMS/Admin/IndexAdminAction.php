<?php

namespace App\Actions\CMS\Admin;

use App\Contracts\Repositories\AdminRepositoryContract;
use App\Supports\Traits\HasPerPageRequest;
use App\Supports\Traits\HasTransformer;
use App\Transformers\AdminTransformer;
use Illuminate\Http\JsonResponse;

class IndexAdminAction
{
    use HasTransformer, HasPerPageRequest;

    protected AdminRepositoryContract $adminRepository;

    public function __construct(AdminRepositoryContract $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function __invoke(): JsonResponse
    {
        $admins = $this->adminRepository->paginateOrAll($this->getPerPage());

        return $this->httpOK($admins, AdminTransformer::class);
    }
}
