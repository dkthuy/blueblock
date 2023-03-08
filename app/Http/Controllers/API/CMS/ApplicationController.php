<?php

namespace App\Http\Controllers\API\CMS;

use App\Actions\CMS\Application\CreateDownloadTokenAction;
use App\Actions\CMS\Application\DownloadAction;
use App\Actions\CMS\Application\IndexAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CMS\Application\DownloadRequest;
use App\Http\Requests\API\CMS\Application\IndexRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationController extends Controller
{
    /**
     * @param IndexRequest $request
     * @param IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexRequest $request, IndexAction $action): JsonResponse
    {
        return ($action)($request->validated());
    }

    /**
     * @param DownloadRequest $request
     * @param DownloadAction $action
     * @return StreamedResponse
     */
    public function download(DownloadRequest $request, DownloadAction $action): StreamedResponse
    {
        return ($action)($request->validated());
    }

    /**
     * @param CreateDownloadTokenAction $action
     * @return JsonResponse
     */
    public function createToken(CreateDownloadTokenAction $action): JsonResponse
    {
        return ($action)();
    }
}
