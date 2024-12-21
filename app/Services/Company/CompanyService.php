<?php

namespace App\Services\Company;

use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface CompanyService extends BaseService{

    public function paginateList(Request $request):array;

    public function show(int $id):array;

    public function create(mixed $data):array;

    public function update($id, CompanyUpdateRequest|array $data):array;

    public function delete($id):void;
}
