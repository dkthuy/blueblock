<?php

namespace App\Supports\Traits;

use Flugg\Responder\Http\MakesResponses;
use Flugg\Responder\Http\Responses\SuccessResponseBuilder;
use Flugg\Responder\Serializers\SuccessSerializer;
use Flugg\Responder\Transformers\Transformer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HasTransformer
{
    use MakesResponses;

    /**
     * @var mixed
     */
    protected $serializer = SuccessSerializer::class;

    /**
     * Build a HTTP_OK response.
     *
     * @param null        $data
     * @param null        $transformer
     * @param string|null $resourceKey
     *
     * @return JsonResponse
     */
    public function httpOK($data = null, $transformer = null, string $resourceKey = null): JsonResponse
    {
        return $this->success($data, $transformer, $resourceKey)
                    ->serializer($this->getSerializer())
                    ->respond(Response::HTTP_OK);
    }

    protected function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @param mixed $serializer
     *
     * @return $this
     */
    protected function setSerializer($serializer)
    {
        $this->serializer = $serializer;

        return $this;
    }

    /**
     * Build a HTTP_CREATED response.
     *
     * @param mixed                            $data
     * @param callable|string|Transformer|null $transformer
     * @param string|null                      $resourceKey
     * @param bool                             $returnCode
     *
     * @return JsonResponse
     */
    public function httpCreated($data = null, $transformer = null, string $resourceKey = null, $returnCode = false): JsonResponse
    {
        $respond = $this->success($data, $transformer, $resourceKey)
                        ->serializer($this->getSerializer())
                        ->respond(Response::HTTP_CREATED);

        if ($returnCode) {
            $respondData = [
                'code' => Response::HTTP_CREATED,
                'data' => $respond->getData()->data,
            ];
            $respond->setData($respondData);
        }

        return $respond;
    }

    /**
     * Build a HTTP_NO_CONTENT response.
     *
     * @return SuccessResponseBuilder|JsonResponse
     */
    public function httpNoContent()
    {
        return $this->success()
                    ->serializer($this->getSerializer())
                    ->respond(Response::HTTP_NO_CONTENT);
    }

    /**
     * @param array $errors
     * @param null  $code
     * @param null  $message
     *
     * @return JsonResponse
     */
    public function httpBadRequest(array $errors = [], $code = null, $message = null)
    {
        $errors['code'] = Response::HTTP_BAD_REQUEST;

        return $this->error($code, $message)
                    ->data($errors)
                    ->respond(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Build a HTTP_NOT_FOUND response
     *
     * @param array       $errors
     * @param null        $errorCode
     * @param string|null $message
     *
     * @return JsonResponse
     */
    public function httpNotFound(array $errors = [], $errorCode = null, string $message = null): JsonResponse
    {
        return $this->error($errorCode, $message)
                    ->data($errors)
                    ->respond(Response::HTTP_NOT_FOUND);
    }

    /**
     * Build a custom response
     *
     * @param     $data
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    public function httpResponse($data, int $statusCode = JsonResponse::HTTP_OK): JsonResponse
    {
        return response()->json($data)->setStatusCode($statusCode);
    }

    /**
     * @return JsonResponse
     */
    public function httpForbidden()
    {
        $errors['code'] = Response::HTTP_FORBIDDEN;

        return $this->error(null, 'This action is forbidden!')
                    ->data($errors)
                    ->respond(Response::HTTP_FORBIDDEN);
    }
}
