<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accounts')->insert([
            ['name' => 'Carteira'],
            ['name' => 'Conta Corrente'],
            ['name' => 'Cartão de Crédito'],
        ]);
    }
}
