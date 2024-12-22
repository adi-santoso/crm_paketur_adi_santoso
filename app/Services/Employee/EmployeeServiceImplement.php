<?php

namespace App\Services\Employee;

use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Employee\EmployeeRepository;

class EmployeeServiceImplement extends ServiceApi implements EmployeeService{

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
     protected EmployeeRepository $mainRepository;

    public function __construct(EmployeeRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function paginateList(Request $request): array
    {
        $employees = $this->mainRepository->paginateList($request);

        if(!$employees['data'])
            abort('404');

        $response = [];
        foreach ($employees['data'] as $employee){
            $response['employees'][] = [
                'id' => $employee['id'],
                'name' => $employee['name'],
                'phone' => $employee['phone'],
                'address' => $employee['address'],
            ];
        }

        $response['total'] = $employees['total'];
        $response['links'] = [
            'first' => $employees['first_page_url'],
            'prev' => $employees['prev_page_url'],
            'next' => $employees['next_page_url']
        ];

        return $response;
    }

    public function show(int $id): array
    {
        $employee =$this->mainRepository->findById($id);

        return ['employee' => $employee];
    }

    public function create(mixed $data): array
    {
        try{
            DB::beginTransaction();

            $employee = $this->mainRepository->create($data->validated());

            DB::commit();

            return [
                'employee' => $employee->fresh()->toArray()
            ];
        } catch (QueryException $e){
            DB::rollBack();

            Log::error($e->getTraceAsString());

            throw $e;
        }
    }

    public function update($id, EmployeeUpdateRequest|array $data):array{

        try{
            DB::beginTransaction();

            $employee = $this->mainRepository->findOrFail($id);

            $this->mainRepository->update($id, $data->validated());

            DB::commit();

            return ['employee' => $employee->refresh()->toArray()];
        } catch (QueryException $e){
            DB::rollBack();

            Log::error($e->getTraceAsString());

            throw $e;
        }
    }

    public function delete($id):void{

        try {
            DB::beginTransaction();

            $this->mainRepository->delete($id);

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();

            Log::error($e->getTraceAsString());

            throw $e;
        }
    }
}
