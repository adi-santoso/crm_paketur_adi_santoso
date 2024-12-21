<?php

namespace App\Repositories\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LaravelEasyRepository\Repository;

interface CompanyRepository extends Repository{

    public function paginateList(Request $request): array;

    public function getList(Request $request): Collection;
}
