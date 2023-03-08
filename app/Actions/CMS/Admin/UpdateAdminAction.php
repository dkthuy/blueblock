<?php

namespace App\Actions\CMS\Admin;

use App\Contracts\Repositories\AdminRepositoryContract;
use App\Models\Admin;
use App\Supports\Traits\HasTransformer;
use App\Transformers\AdminTransformer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateAdminAction
{
    use HasTransformer;

    protected AdminRepositoryContract $adminRepository;

    public function __construct(AdminRepositoryContract $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function __invoke(int $id, array $data): JsonResponse
    {
        $currentUser = auth()->user();
        // prevent admin from changing role by themselves
        if ($currentUser !== null && $currentUser->id === $id && !empty($data['role'])) {
            throw new BadRequestHttpException;
        }

        /**
         * @var Admin $admin
         */
        $admin = $this->adminRepository->find($id);

        if (!empty($data['role']) && !$admin->hasRole($data['role'])) {
            $admin->syncRoles($data['role']);
        }

        $admin->update($data);
        $admin->save();

        return $this->httpOK($admin->refresh(), AdminTransformer::class);
    }
}
