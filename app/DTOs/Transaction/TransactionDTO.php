<?php

namespace App\DTOs\Transaction;

class TransactionDTO
{
    public function __construct(
        public ?int $user_id,
        public ?float $amount,
        public ?int $type_id,
        public ?string $date,
        public ?string $description,
        public ?int $account_id,
        public ?int $category_id,
        public ?bool $installment,
        public ?int $installment_number,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            user_id: $request->user_id,
            amount: $request->amount,
            type_id: $request->type_id,
            date: $request->date,
            description: $request->description,
            account_id: $request->account_id,
            category_id: $request->category_id,
            installment: $request->installment,
            installment_number: $request->installment_number,
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'type_id' => $this->type_id,
            'date' => $this->date,
            'description' => $this->description,
            'account_id' => $this->account_id,
            'category_id' => $this->category_id,
            'installment' => $this->installment,
            'installment_number' => $this->installment_number,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            amount: $data['amount'],
            type_id: $data['type_id'],
            date: $data['date'],
            description: $data['description'],
            account_id: $data['account_id'],
            category_id: $data['category_id'],
            installment: $data['installment'],
            installment_number: $data['installment_number'],
        );
    }
}
