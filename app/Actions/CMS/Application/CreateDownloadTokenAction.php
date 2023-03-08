<?php

namespace App\Actions\CMS\Application;

use App\Contracts\Repositories\ApplicationRepositoryContract;
use App\Supports\Traits\HasTransformer;
use App\Transformers\API\CMS\ApplicationTransformer;
use Illuminate\Http\JsonResponse;

class CreateDownloadTokenAction
{
    use HasTransformer;

    public function __invoke() {
        $token = auth()->user()->createToken('token', ['server:download']);
        return $this->responseToken($token);
    }

    protected function responseToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'bearer'
        ]);
    }
}
