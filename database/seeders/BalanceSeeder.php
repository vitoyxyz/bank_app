<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 4; $i++) {
            DB::table('balances')->insert([
                'id' => $i,
                'balance' => 50000,
                'user_id' => $i
            ]);
        }
    }
}
