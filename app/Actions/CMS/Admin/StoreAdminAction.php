<?php

namespace App\Actions\CMS\Admin;

use App\Contracts\Repositories\AdminRepositoryContract;
use App\Models\Admin;
use App\Supports\Traits\HasTransformer;
use App\Transformers\AdminTransformer;
use Illuminate\Http\JsonResponse;

class StoreAdminAction
{
    use HasTransformer;

    protected AdminRepositoryContract $adminRepository;

    public function __construct(AdminRepositoryContract $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function __invoke(array $data): JsonResponse
    {
        /**
         * @var Admin $admin
         */
        $admin = $this->adminRepository->create($data);

        $admin->assignRole($data['role']);

        return $this->httpOK($admin, AdminTransformer::class);
    }
}
