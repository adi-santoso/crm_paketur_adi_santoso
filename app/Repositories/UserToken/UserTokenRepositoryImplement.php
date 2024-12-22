<?php

namespace App\Repositories\UserToken;

use Illuminate\Support\Collection;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\UserToken;

class UserTokenRepositoryImplement extends Eloquent implements UserTokenRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property UserToken|mixed $model;
    */
    protected UserToken $model;

    public function __construct(UserToken $model)
    {
        $this->model = $model;
    }

    public function deleteByAccessToken(?string $accessToken): void
    {
        $this->model->where('access_token', $accessToken)->delete();
    }

    public function firstByAccessToken(?string $accessToken): ?UserToken
    {
        return $this->model->where('access_token', $accessToken)->first();
    }

    public function getAccessTokenByUserIds(array $userIds): Collection
    {
        return $this->model->whereIn('user_id', $userIds)->get();
    }

    public function deleteByUserIds(array $userIds): void
    {
        $this->model->whereIn('user_id', $userIds)->delete();
    }
}
