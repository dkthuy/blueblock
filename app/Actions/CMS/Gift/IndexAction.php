<?php

namespace App\Actions\CMS\Gift;

use App\Contracts\Repositories\GiftRepositoryContract;
use App\Supports\Traits\HasTransformer;
use App\Transformers\API\CMS\GiftTransformer;
use Illuminate\Http\JsonResponse;

class IndexAction
{
    use HasTransformer;

    protected GiftRepositoryContract $giftRepository;

    public function __construct(GiftRepositoryContract $giftRepository)
    {
        $this->giftRepository = $giftRepository;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $gifts = $this->giftRepository->all();

        return $this->httpOK($gifts, GiftTransformer::class);
    }
}
