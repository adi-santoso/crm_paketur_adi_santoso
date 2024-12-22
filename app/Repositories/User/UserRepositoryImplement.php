<?php

namespace App\Repositories\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

class UserRepositoryImplement extends Eloquent implements UserRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property User|mixed $model;
    */
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function managerPaginateList(Request $request): array
    {
        return $this->userBuilder($request)
            ->withRole('manager')
            ->paginate(10)
            ->toArray();
    }

    public function getList(Request $request): Collection
    {
        // TODO: Implement getList() method.
    }

    public function userBuilder(Request $request): Builder
    {
        $sortColumn = 'name'; // Default sort by 'name'
        $sortOrder = 'desc';   // Default order is ascending

        if ($request->has('sort')) {
            $sortParts = explode(',', $request->get('sort'));

            if (count($sortParts) === 2) {
                $allowedColumns = ['name'];

                if (in_array($sortParts[0], $allowedColumns) && in_array(strtolower($sortParts[1]), ['asc', 'desc'])) {
                    $sortColumn = $sortParts[0];
                    $sortOrder = strtolower($sortParts[1]);
                }
//                else {
//                    return response()->json(['error' => 'Invalid sort parameter'], 400);
//                }
            }
//            else {
//                return response()->json(['error' => 'Invalid sort format'], 400);
//            }
        }


        return $this->model
            ->where(function ($query) use ($request) {
                $query->filterByIlikeName($request->get('search'));
            })
            ->orderBy($sortColumn, $sortOrder);
    }
}
