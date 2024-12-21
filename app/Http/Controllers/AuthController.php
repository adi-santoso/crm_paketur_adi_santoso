<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponseTrait;

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->middleware('throttle:5,1', ['only' => ['refresh']]);
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $login = $this->authService->login($request);

        return $this->success($login);
    }

    public function refresh(): JsonResponse
    {
        $refresh = $this->authService->refresh();

        return $this->success($refresh);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return $this->success();
    }
}
