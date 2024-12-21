<?php

namespace App\Services\Company;

use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
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
    public function paginateList(Request $request): array
    {
        $companies = $this->mainRepository->paginateList($request);

        if(!$companies['data'])
            abort('404');

        $response = [];
        foreach ($companies['data'] as $company){
            $response['companies'][] = [
              'id' => $company['id'],
              'name' => $company['name'],
              'email' => $company['email'],
              'phone' => $company['phone'],
            ];
        }

        $response['total'] = $companies['total'];
        $response['links'] = [
            'first' => $companies['first_page_url'],
            'prev' => $companies['prev_page_url'],
            'next' => $companies['next_page_url']
        ];
        return $response;
    }

    public function show(int $id): array
    {
        $company =$this->mainRepository->findOrFail($id);

        return ['company' => $company];
    }

    public function create(mixed $data): array
    {
        try{
            DB::beginTransaction();

            $company = $this->mainRepository->create($data->validated());

            DB::commit();

            return ['company' => $company->fresh()->toArray()];
        } catch (QueryException $e){
            DB::rollBack();

            Log::error($e->getTraceAsString());

            throw $e;
        }
    }

    public function update($id, CompanyUpdateRequest|array $data):array{

        try{
            DB::beginTransaction();

            $company = $this->mainRepository->findOrFail($id);

            $this->mainRepository->update($id, $data->validated());

            DB::commit();

            return ['company' => $company->refresh()->toArray()];
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
