<?php

namespace App\Http\Controllers;

use App\ApiResponseTrait;
use App\DTOs\Transaction\TransactionDTO;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use ApiResponseTrait;
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $month = $request->query('month');
        $year = $request->query('year');

        $allTransactions = $this->transactionService->getAll($month, $year);

        return $this->successResponse($allTransactions);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) : JsonResponse
    {
        $transaction = $this->transactionService->findById($id);

        if (!$transaction) {
            return $this->errorResponse(null, 'Transação não encontrada.', 404);
        }

        return $this->successResponse($transaction);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request) : JsonResponse
    {
        $transactionDTO = TransactionDTO::fromRequest($request);

        if (!$transactionDTO) {
            return $this->errorResponse(null, 'Erro ao criar transação.', 500);
        }

        $this->transactionService->create($transactionDTO);

        return $this->successResponse($transactionDTO->toArray(), 'Transação criada com sucesso.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'amount' => 'sometimes|numeric',
            'type_id' => 'sometimes|exists:transaction_types,id',
            'date' => 'sometimes|date',
            'description' => 'sometimes|string',
            'account_id' => 'sometimes|exists:accounts,id',
            'category_id' => 'sometimes|exists:categories,id',
            'installment' => 'sometimes|boolean',
            'installment_number' => 'sometimes|integer',
        ]);

        $updatedTransaction = $this->transactionService->update($id, $data);

        if (!$updatedTransaction) {
            return $this->errorResponse(null, 'Transação nao encontrada.', 404);
        }

        return $this->successResponse($updatedTransaction, 'Transação atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletedTransaction = $this->transactionService->delete($id);

        if (!$deletedTransaction) {
            return $this->errorResponse(null, 'Transação nao encontrada.', 404);
        }

        return $this->successResponse([], 'Transação deletada com sucesso.');
    }
}
