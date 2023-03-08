<?php

namespace App\Http\Controllers\API;

use App\Actions\User\Question\IndexAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(IndexAction $action): \Illuminate\Http\JsonResponse
    {
        return ($action)();
    }
}
