<?php

namespace App\Actions\CMS\Auth;

use App\Contracts\Repositories\AdminRepositoryContract;
use App\Supports\Traits\HasTransformer;
use App\Transformers\AdminTransformer;
use Illuminate\Http\JsonResponse;

class MeAction
{
    use HasTransformer;

    protected AdminRepositoryContract $adminRepository;

    public function __construct(AdminRepositoryContract $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $currentAdmin = auth()->user();

        return $this->httpOK($currentAdmin, AdminTransformer::class);
    }
}
