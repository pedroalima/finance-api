<?php

namespace App\Repositories;

use App\DTOs\Transaction\TransactionDTO;
use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function getAll(?int $month = null, ?int $year = null)
    {
        $query = Transaction::query()->orderBy('date')->orderBy('id');

        if ($month && $year) {
            $query->whereMonth('date', $month)
                  ->whereYear('date', $year);
        }

        return $query->get();
    }

    public function findById(int $id)
    {
        return Transaction::find($id);
    }

    public function create(TransactionDTO $data)
    {
        return Transaction::create($data->toArray());
    }

    public function update(int $id, array $data)
    {
        $transaction = Transaction::find($id);

        if (! $transaction) {
            return null;
        }

        $transaction->update($data);

        return $transaction;
    }

    public function delete(int $id)
    {
        $transaction = Transaction::find($id);

        if (! $transaction) {
            return false;
        }

        return $transaction->delete();
    }
}
