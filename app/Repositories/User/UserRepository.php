<?php

namespace App\Repositories\User;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LaravelEasyRepository\Repository;

interface UserRepository extends Repository{
    public function managerPaginateList(Request $request): array;

    public function getList(Request $request): Collection;
}
