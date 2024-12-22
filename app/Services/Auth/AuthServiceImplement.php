<?php

namespace App\Services\Auth;

use App\Exceptions\IncorrectCredentialException;
use App\Http\Requests\LoginRequest;
use App\Repositories\User\UserRepository;
use App\Repositories\UserToken\UserTokenRepository;
use App\Traits\AuthServiceTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\ServiceApi;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthServiceImplement extends ServiceApi implements AuthService{

    use AuthServiceTrait;

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected string $title = "";
     /**
     * uncomment this to override the default message
     * protected string $create_message = "";
     * protected string $update_message = "";
     * protected string $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected UserRepository $mainRepository;
     protected UserTokenRepository $userTokenRepository;

    public function __construct(
        UserRepository $mainRepository,
        UserTokenRepository $userTokenRepository
    )
    {
      $this->mainRepository = $mainRepository;
      $this->userTokenRepository = $userTokenRepository;
    }

    // Define your custom methods :)

    /**
     * @throws Exception
     */
    public function login(LoginRequest $request): array
    {
        if (!$token = auth()->attempt($request->validated()))
            throw new IncorrectCredentialException();

        $user = auth()->user();
        $ttl = auth()->factory()->getTTL() * 60;

        $this->createUserToken($user->id, $token);

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => [
                    'id' => $user->roles[0]->id,
                    'name' => $user->roles[0]->name
                ],
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $ttl
        ];
    }

    public function refresh(): array
    {
        $oldToken = request()->bearerToken();

        try {
            $refresh = auth()->refresh();
            $ttl = auth()->factory()->getTTL() * 60;
            $user = auth()->setToken($refresh)->user();

            $this->createAndDeleteUserToken($user->id, $refresh, $oldToken);

            return [
                'access_token' => $refresh,
                'token_type' => 'Bearer',
                'expires_in' => $ttl
            ];
        } catch (TokenBlacklistedException|TokenExpiredException|TokenInvalidException|JWTException $e) {
            Log::info($e->getTraceAsString());

            throw new AuthenticationException();
        }
    }

    public function logout(): array
    {
        // TODO: Implement logout() method.
    }
}
