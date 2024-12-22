<?php

namespace App\Http\Controllers;

use App\Services\Employee\EmployeeService;
use App\Services\User\UserService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    use ApiResponseTrait;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
//        $this->authorize('ManagerController.read');

        $managers = $this->userService->managerPaginateList($request);

        return $this->success($managers);
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $manager = $this->userService->show($id);

        return $this->success($manager);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}