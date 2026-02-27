<?php

namespace App\Repositories\Contracts;

use App\Models\Contract;

class EloquentContractRepository implements ContractRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function findById(int $id): ?Contract
    {
        return Contract::find($id);
    }

    public function create(array $data): Contract
    {
        return Contract::create($data);
    }
}
