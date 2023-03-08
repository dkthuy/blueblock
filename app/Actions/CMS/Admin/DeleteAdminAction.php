<?php

namespace App\Actions\CMS\Admin;

use App\Contracts\Repositories\AdminRepositoryContract;
use App\Supports\Traits\HasTransformer;
use App\Transformers\AdminTransformer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DeleteAdminAction
{
    use HasTransformer;

    protected AdminRepositoryContract $adminRepository;

    public function __construct(AdminRepositoryContract $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function __invoke(int $id)
    {
        $currentUser = auth()->user();
        $userWillBeDeleted = $this->adminRepository->find($id);
        if (($currentUser !== null
                && $id == $currentUser->id)
            || $userWillBeDeleted->id === 1
        ) {
            throw new BadRequestHttpException;
        }
        if ($this->adminRepository->delete($id)) {
            return $this->httpNoContent();
        }
        throw new BadRequestHttpException;
    }
}
