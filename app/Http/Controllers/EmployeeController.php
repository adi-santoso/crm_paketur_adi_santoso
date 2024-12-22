<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Services\Employee\EmployeeService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use ApiResponseTrait;

    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('EmployeeController.read');

        $employee = $this->employeeService->paginateList($request);

        return $this->success($employee);
    }

    public function store(EmployeeStoreRequest $request)
    {
        $this->authorize('EmployeeController.create');
        $employee = $this->employeeService->create($request);

        return $this->createSuccess($employee);
    }

    public function show($id)
    {
        $this->authorize('EmployeeController.read');
        $employee = $this->employeeService->show($id);

        return $this->success($employee);
    }

    public function update(EmployeeUpdateRequest $request, $id)
    {
        $this->authorize('EmployeeController.update');
        $employee = $this->employeeService->update($id, $request);

        return $this->success($employee);
    }

    public function destroy($id)
    {
        $this->authorize('EmployeeController.delete');
        $this->employeeService->delete($id);

        return $this->success();
    }
}
