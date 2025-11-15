<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'type_id' => 1, // ou algo válido do seu sistema
            'date' => now(),
            'description' => $this->faker->sentence,
            'account_id' => 1,
            'category_id' => 1,
            'installment' => false,
            'installment_number' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
