<?php

namespace App\Repositories\Contracts;

use App\DTOs\Transaction\TransactionDTO;

interface TransactionRepositoryInterface
{
    public function getAll(?int $month = null, ?int $year = null);

    public function findById(int $id);

    public function create(TransactionDTO $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
