<?php

namespace App\Services\Auth;

use App\Http\Requests\LoginRequest;
use LaravelEasyRepository\BaseService;

interface AuthService extends BaseService{

    public function login(LoginRequest $request): array;

    public function refresh(): array;

    public function logout(): array;
}
