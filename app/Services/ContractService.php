<?php

namespace App\Services;

use App\DTOS\CreateContractDTO;
use App\Models\Contract;
use App\Repositories\Contracts\ContractRepositoryInterface;

class ContractService
{
    public function __construct(
        private ContractRepositoryInterface $contractRepo,

    ) {}
    public function createContract(CreateContractDTO $dto): Contract
    {
        return $this->contractRepo->create([
            'tenant_id' => $dto->tenant_id,
            'rent_amount' => $dto->rent_amount,
            'unit_name' => $dto->unit_name,
            'customer_name' => $dto->customer_name,
            'start_date' => $dto->start_date,
            'end_date' => $dto->end_date,
        ]);
    }
}
