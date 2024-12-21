<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Services\Company\CompanyService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use ApiResponseTrait;

    protected CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(Request $request): JsonResponse
    {
//        $this->authorize('CompanyController.read');

        $companies = $this->companyService->paginateList($request);

        return $this->success($companies);
    }

    public function store(CompanyStoreRequest $request)
    {
        $company = $this->companyService->create($request);

        return $this->createSuccess($company);
    }

    public function show($id)
    {
        $company = $this->companyService->show($id);

        return $this->success($company);
    }

    public function update(CompanyUpdateRequest $request, $id)
    {
        $company = $this->companyService->update($id, $request);

        return $this->success($company);
    }

    public function destroy($id)
    {
        $this->companyService->delete($id);

        return $this->success();
    }
}
