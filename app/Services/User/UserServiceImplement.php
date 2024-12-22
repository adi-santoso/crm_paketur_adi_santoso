<?php

namespace App\Services\User;

use App\Http\Requests\ManagerUpdateRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\ServiceApi;

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

    public function managerPaginateList(Request $request): array
    {
        $managers = $this->mainRepository->managerPaginateList($request);

        if(!$managers['data'])
            abort('404');

        $response = [];
        foreach ($managers['data'] as $manager){
            $response['managers'][] = [
                'id' => $manager['id'],
                'name' => $manager['name'],
                'email' => $manager['email'],
            ];
        }

        $response['total'] = $managers['total'];
        $response['links'] = [
            'first' => $managers['first_page_url'],
            'prev' => $managers['prev_page_url'],
            'next' => $managers['next_page_url']
        ];

        return $response;
    }

    public function show(int $id): array
    {
        $manager =$this->mainRepository->findOrFail($id);

        return ['manager' => $manager];
    }

    public function updateManager($id, array|ManagerUpdateRequest $data): array
    {
        try{
            DB::beginTransaction();

            if($id!=Auth::id())
                abort(403);

            $user = $this->mainRepository->findOrFail($id);

            $this->mainRepository->update($id, $data->validated());

            DB::commit();

            return ['company' => $user->refresh()->toArray()];
        } catch (QueryException $e){
            DB::rollBack();

            Log::error($e->getTraceAsString());

            throw $e;
        }
    }
}
