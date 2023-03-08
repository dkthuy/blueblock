<?php

namespace App\Http\Controllers\API\CMS;

use App\Actions\CMS\Auth\LoginAction;
use App\Actions\CMS\Auth\MeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CMS\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    /**
     * @param LoginRequest $request
     * @param LoginAction $action
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return ($action)($request->validated());
    }

    /**
     * @param MeAction $action
     * @return JsonResponse
     */
    public function me(MeAction $action): JsonResponse
    {
        return ($action)();
    }
}
