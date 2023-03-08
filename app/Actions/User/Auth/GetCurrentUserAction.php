<?php

namespace App\Actions\User\Auth;

use App\Supports\Traits\HasTransformer;
use Illuminate\Http\JsonResponse;

class GetCurrentUserAction
{
    use HasTransformer;

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->httpNoContent();
    }
}
