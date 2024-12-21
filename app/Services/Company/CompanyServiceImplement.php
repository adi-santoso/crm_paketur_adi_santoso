<?php

namespace App\Services\Company;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Company\CompanyRepository;

class CompanyServiceImplement extends ServiceApi implements CompanyService{

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
     protected CompanyRepository $mainRepository;

    public function __construct(CompanyRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
