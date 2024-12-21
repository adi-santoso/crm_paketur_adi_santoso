<?php

namespace App\Repositories\Company;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Company;

class CompanyRepositoryImplement extends Eloquent implements CompanyRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected Company $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
