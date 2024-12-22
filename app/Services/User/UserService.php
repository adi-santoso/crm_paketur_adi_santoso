<?php

namespace App\Services\User;

use LaravelEasyRepository\BaseService;

interface UserService extends BaseService{

    public function create(mixed $data): array;

    public function createManager(mixed $data): array;
}
