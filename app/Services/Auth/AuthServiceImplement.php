<?php

namespace App\Services\Auth;

use App\Exceptions\IncorrectCredentialException;
use App\Http\Requests\LoginRequest;
use App\Repositories\User\UserRepository;
use App\Repositories\UserToken\UserTokenRepository;
use App\Traits\AuthServiceTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\ServiceApi;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
        $payload = [];
        $oldToken = request()->bearerToken();

        try {
            $payload = auth()->payload()->toArray();
            auth()->logout();

            try {
                DB::beginTransaction();

                $this->userTokenRepository->deleteByAccessToken($oldToken);

                DB::commit();
            } catch (QueryException $e) {
                DB::rollBack();

                Log::error($e->getTraceAsString());
            }

            return $payload;
        } catch (TokenBlacklistedException|TokenExpiredException $e) {
            Log::info($e->getTraceAsString());

            try {
                DB::beginTransaction();

                $checkToken = $this->userTokenRepository->firstByAccessToken($oldToken);

                if (! $checkToken)
                    return $payload;

                $this->userTokenRepository->deleteByAccessToken($oldToken);

                DB::commit();
            } catch (QueryException $e) {
                DB::rollBack();

                Log::error($e->getTraceAsString());
            }

            return $payload;
        } catch (JWTException|TokenInvalidException $e) {
            Log::info($e->getTraceAsString());

            return $payload;
        }
    }
}
