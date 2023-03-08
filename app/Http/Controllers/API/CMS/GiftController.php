<?php

namespace App\Http\Controllers\API\CMS;

use App\Actions\CMS\Gift\IndexAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GiftController extends Controller
{
    /**
     * @param IndexAction $action
     * @return JsonResponse
     */
    public function index(IndexAction $action): JsonResponse
    {
        return ($action)();
    }
}
