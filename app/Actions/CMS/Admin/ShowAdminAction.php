<?php

namespace App\Actions\CMS\Admin;

use App\Contracts\Repositories\AdminRepositoryContract;
use App\Supports\Traits\HasTransformer;
use App\Transformers\AdminTransformer;

class ShowAdminAction
{
    use HasTransformer;

    protected AdminRepositoryContract $adminRepository;

    public function __construct(AdminRepositoryContract $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function __invoke(int $id): \Illuminate\Http\JsonResponse
    {
        $admin = $this->adminRepository->find($id);

        return $this->httpOK($admin, AdminTransformer::class);
    }
}
