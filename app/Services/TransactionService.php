<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public function getAll($month = null, $year = null)
    {
        $query = Transaction::query();

        if ($month && $year) {
            $query->whereMonth('date', $month)->whereYear('date', $year);
        }

        return $query->get();
    }

    public function findById($id)
    {
        return Transaction::find($id);
    }

    public function create($data)
    {
        return Transaction::create($data);
    }

    public function update($id, $data)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return null;
        }

        $transaction->update($data);

        return $transaction;
    }

    public function delete($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return null;
        }

        return $transaction->delete();;
    }
}
