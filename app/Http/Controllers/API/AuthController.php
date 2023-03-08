<?php

namespace App\Http\Controllers\API;

use App\Actions\User\Auth\GetCurrentUserAction;
use App\Actions\User\Auth\RefreshAction;
use App\Actions\User\Auth\RegisterAction;
use App\Http\Requests\API\User\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthController
{
    public function register(RegisterRequest $request, RegisterAction $action): JsonResponse
    {
        return ($action)();
    }

    public function me(GetCurrentUserAction $action): JsonResponse
    {
        return ($action)();
    }

    public function refresh(RefreshAction $action): JsonResponse
    {
        return ($action)();
    }
}
