<?php

namespace App\Actions\CMS\Auth;

use App\Contracts\Actions\LoginActionContract;
use App\Enums\CMS\AdminStatusEnum;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class LoginAction implements LoginActionContract
{
    /**
     * @throws AuthenticationException
     */
    public function __invoke(array $data): JsonResponse
    {
        $data['status'] = AdminStatusEnum::ACTIVE;
        if (!($token = auth('api-admin')->attempt($data))) {
            throw new AuthenticationException();
        }
        // Store new token into admin database
        auth('api-admin')->user()
            ->update(['remember_token' => $token]);

        return $this->responseToken($token);
    }

    /**
     * Get the token array structure
     *
     * @param $token
     * @return JsonResponse
     */
    protected function responseToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api-admin')->factory()->getTTL() * 60
        ]);
    }
}
