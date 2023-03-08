<?php

namespace App\Http\Controllers\API\CMS;

use App\Actions\CMS\Admin\DeleteAdminAction;
use App\Actions\CMS\Admin\IndexAdminAction;
use App\Actions\CMS\Admin\ShowAdminAction;
use App\Actions\CMS\Admin\StoreAdminAction;
use App\Actions\CMS\Admin\UpdateAdminAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CMS\Admin\StoreAdminRequest;
use App\Http\Requests\API\CMS\Admin\UpdateAdminRequest;
use Flugg\Responder\Http\Responses\SuccessResponseBuilder;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(IndexAdminAction $action)
    {
        return ($action)();
    }

    /**
     * @param StoreAdminRequest $request
     * @param StoreAdminAction $action
     * @return JsonResponse
     */
    public function store(StoreAdminRequest $request, StoreAdminAction $action): JsonResponse
    {
        return ($action)($request->validated());
    }

    /**
     * @param int $admin
     * @param ShowAdminAction $action
     * @return JsonResponse
     */
    public function show(int $admin, ShowAdminAction $action): JsonResponse
    {
        return ($action)($admin);
    }

    /**
     * @param int $admin
     * @param UpdateAdminRequest $request
     * @param UpdateAdminAction $action
     * @return JsonResponse
     */
    public function update(int $admin, UpdateAdminRequest $request, UpdateAdminAction $action): JsonResponse
    {
        return ($action)($admin, $request->validated());
    }

    /**
     * @param int $admin
     * @param DeleteAdminAction $action
     * @return SuccessResponseBuilder|JsonResponse
     */
    public function destroy(int $admin, DeleteAdminAction $action)
    {
        return ($action)($admin);
    }
}
