<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersBranches extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 4; $i++) {
            DB::table('users_branches')->insert([
                'user_id' => $i,
                'branch_id' => $i,
            ]);
        }
    }
}
