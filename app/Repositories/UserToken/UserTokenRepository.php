<?php

namespace App\Repositories\UserToken;

use App\Models\UserToken;
use Illuminate\Support\Collection;
use LaravelEasyRepository\Repository;

interface UserTokenRepository extends Repository{

    public function deleteByAccessToken(?string $accessToken): void;

    public function firstByAccessToken(?string $accessToken): ?UserToken;

    public function getAccessTokenByUserIds(array $userIds): Collection;

    public function deleteByUserIds(array $userIds): void;
}
