<?php

namespace App\Services\User;

use App\Http\Requests\ManagerUpdateRequest;
use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface UserService extends BaseService{

    public function managerPaginateList(Request $request):array;

    public function create(mixed $data): array;

    public function createManager(mixed $data): array;

    public function show(int $id):array;

    public function updateManager($id, ManagerUpdateRequest|array $data):array;
}
