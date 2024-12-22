<?php

namespace App\Repositories\Employee;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Employee;

class EmployeeRepositoryImplement extends Eloquent implements EmployeeRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Employee|mixed $model;
    */
    protected Employee $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function paginateList(Request $request): array
    {
        return $this->employeeBuilder($request)
            ->paginate(10)
            ->toArray();
    }

    public function getList(Request $request): Collection
    {
        return $this->employeeBuilder($request)->get();
    }

    public function findById(int $id): Employee|Builder
    {
        return $this->model
            ->query()
            ->with('company')
            ->where('id', $id)
            ->firstOrFail();
    }

    public function employeeBuilder(Request $request): Builder
    {
        $sortColumn = 'name'; // Default sort by 'name'
        $sortOrder = 'desc';   // Default order is ascending

        if ($request->has('sort')) {
            $sortParts = explode(',', $request->get('sort'));

            if (count($sortParts) === 2) {
                $allowedColumns = ['name', 'address'];

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
