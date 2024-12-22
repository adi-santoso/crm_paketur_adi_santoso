<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LaravelEasyRepository\Repository;
use Illuminate\Database\Eloquent\Builder;

interface EmployeeRepository extends Repository{

    public function paginateList(Request $request): array;

    public function getList(Request $request): Collection;

    public function findById(int $id): Employee|Builder;
}
