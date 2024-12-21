<?php

namespace App\Repositories\UserToken;

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

    // Write something awesome :)
}
