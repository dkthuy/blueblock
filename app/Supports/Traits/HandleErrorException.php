<?php

namespace App\Supports\Traits;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

trait HandleErrorException
{
    /**
     * @param \Illuminate\Validation\ValidationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderApiResponse(ValidationException $exception): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => trans('api.msg_err_400'),
            'errors' => $this->convertApiErrors($exception->errors()),
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param $errors
     * @return array
     */
    private function convertApiErrors($errors): array
    {
        $result = [];
        foreach ($errors as $k => $error) {
            $result[] = [
                'field' => $k,
                'message' => $error,
            ];
        }

        return $result;
    }

    /**
     * @param NotFoundHttpException $exception
     * @return JsonResponse
     */
    public function renderApiNotFoundResponse(NotFoundHttpException $exception): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_NOT_FOUND,
            'message' => trans('api.msg_err_404'),
            'errors' => $exception->getMessage(),
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * @param \Tymon\JWTAuth\Exceptions\TokenExpiredException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderExpiredException(TokenExpiredException $exception): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_REQUEST_TIMEOUT,
            'message' => trans('api.msg_err_408'),
            'errors' => trans('auth.expired'),
        ], Response::HTTP_REQUEST_TIMEOUT);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderNotLoginException(): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_NOT_FOUND,
            'message' => trans('auth.failed'),
            'errors' => trans('api.msg_err_404'),
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * @param \Symfony\Component\HttpKernel\Exception\BadRequestHttpException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderApiBadRequestResponse(BadRequestHttpException $exception): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => trans('api.msg_err_400'),
            'errors' => $exception->getMessage(),
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Response server error exception
     *
     * @param $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderServerErrorException($exception): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => trans('api.msg_err_500'),
            'errors' => $exception->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Response unauthenticated
     *
     * @param $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderUnauthenticatedException($exception): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' =>  trans('api.msg_err_401'),
            'errors' => $exception->getMessage(),
        ], Response::HTTP_UNAUTHORIZED);
    }
}
