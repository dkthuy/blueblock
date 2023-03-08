<?php

namespace App\Http\Controllers\API;

use App\Actions\User\Form\ConfirmAction;
use App\Actions\User\Form\GetFormDataAction;
use App\Actions\User\Form\SubmitAction;
use App\Http\Requests\API\User\Form\SubmitRequest;
use Illuminate\Http\JsonResponse;

class FormController
{
    public function confirm(SubmitRequest $request, ConfirmAction $action): JsonResponse
    {
        return ($action)($request->validated());
    }

    public function submit(SubmitRequest $request, SubmitAction $action): JsonResponse
    {
        return ($action)($request->validated());
    }

    public function getFormData(GetFormDataAction $action): JsonResponse
    {
        return ($action)();
    }
}
