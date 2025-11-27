<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

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
        // Se for uma transação com parcelamento, criar transações para cada parcela nos meses seguintes
        if ($data['installment']) {
            $installmentNumber = $data['installment_number'];
            $installmentAmount = $data['amount'] / $installmentNumber;

            for ($i = 0; $i <= $installmentNumber; $i++) {
                $installmentData = [
                    'user_id' => $data['user_id'],
                    'amount' => $installmentAmount,
                    'type_id' => $data['type_id'],
                    'date' => now()->addMonths($i),
                    'description' => $data['description'],
                    'account_id' => $data['account_id'],
                    'category_id' => $data['category_id'],
                    'installment' => true,
                    'installment_number' => $i,
                ];

                Transaction::create($installmentData);
            }

            return null;
        }

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
