<?php

namespace App\Traits;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait AuthServiceTrait
{
    public function createUserToken(
        int $userId,
        string $token
    ): void
    {
        try {
            DB::beginTransaction();

            $this->userTokenRepository->create([
                'user_id' => $userId,
                'access_token' => $token
            ]);

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();

            Log::error($e->getTraceAsString());

            throw $e;
        }
    }
}
