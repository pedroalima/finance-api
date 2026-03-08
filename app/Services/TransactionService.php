<?php

namespace App\Services;

use App\DTOs\Transaction\TransactionDTO;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Carbon\Carbon;

class TransactionService
{
    protected $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getAll($month = null, $year = null)
    {
        $transactions = $this->transactionRepository->getAll($month, $year);

        return $this->addRunningTotal($transactions);
    }

    public function findById($id)
    {
        return $this->transactionRepository->findById($id);
    }

    public function create(TransactionDTO $data)
    {
        if ($data->description == null || $data->description == '') {
            $data->description = 'Sem descrição';
        }

        if ($data->installment) {
            return $this->handleInstallments($data);
        }

        return $this->transactionRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->transactionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->transactionRepository->delete($id);
    }

    private function handleInstallments(TransactionDTO $data)
    {
        $installmentNumber = $data->installment_number;
        $installmentAmount = $data->amount / $installmentNumber;

        $initialDate = Carbon::parse($data->date);

        for ($i = 1; $i <= $installmentNumber; $i++) {

            $transactionDate = $initialDate->copy()->addMonths($i - 1);

            $installmentData = [
                'user_id' => $data->user_id,
                'amount' => $installmentAmount,
                'type_id' => $data->type_id,
                'date' => $transactionDate,
                'description' => "{$data->description} {$i}/{$installmentNumber}",
                'account_id' => $data->account_id,
                'category_id' => $data->category_id,
                'installment' => true,
                'installment_number' => $i,
            ];

            $this->transactionRepository->create(TransactionDTO::fromArray($installmentData));
        }

        return true;
    }

    private function addRunningTotal($transactions)
    {
        $runningTotal = 0;

        return $transactions->map(function ($transaction) use (&$runningTotal) {

            // Ajuste aqui de acordo com seus tipos (entrada/saída)
            if ($transaction->type_id == 1) {
                $runningTotal += $transaction->amount;
            } else {
                $runningTotal -= $transaction->amount;
            }

            $transaction->running_total = round($runningTotal, 2);

            return $transaction;
        });
    }
}
