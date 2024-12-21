<?php

namespace App\Repositories\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Company;

class CompanyRepositoryImplement extends Eloquent implements CompanyRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Company|mixed $model;
    */
    protected Company $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function paginateList(Request $request): array
    {
        return $this->companyBuilder($request)
            ->paginate(10)
            ->toArray();
    }

    public function getList(Request $request): Collection
    {
        return $this->companyBuilder($request)->get();
    }

    public function companyBuilder(Request $request): Builder
    {
        $sortColumn = 'name'; // Default sort by 'name'
        $sortOrder = 'desc';   // Default order is ascending

        if ($request->has('sort')) {
            $sortParts = explode(',', $request->get('sort'));

            if (count($sortParts) === 2) {
                $allowedColumns = ['name', 'email'];

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
