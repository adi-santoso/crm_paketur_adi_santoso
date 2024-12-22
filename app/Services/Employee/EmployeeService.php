<?php

namespace App\Services\Employee;

use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface EmployeeService extends BaseService{

    public function paginateList(Request $request):array;

    public function show(int $id):array;

    public function create(mixed $data):array;

    public function update($id, EmployeeUpdateRequest|array $data):array;

    public function delete($id):void;
}
