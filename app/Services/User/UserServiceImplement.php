<?php

namespace App\Services\User;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;

class UserServiceImplement extends ServiceApi implements UserService{

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

    public function __construct(UserRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function create(mixed $data): array
    {
        try {
            DB::beginTransaction();

            $user = $this->mainRepository->create($data);

            DB::commit();

            return ['user' => $user->fresh()->toArray()];
        } catch (QueryException $e){
            DB::rollBack();

            Log::error($e->getTraceAsString());

            throw $e;
        }
    }

    public function createManager(mixed $data): array
    {
        try {
            DB::beginTransaction();

            $user = $this->mainRepository->create($data);

            $user->assignRole('manager');

            DB::commit();

            return ['manager' => $user->fresh()->toArray()];
        } catch (QueryException $e){
            DB::rollBack();

            Log::error($e->getTraceAsString());

            throw $e;
        }
    }
}
