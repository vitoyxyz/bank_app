<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{

    private  $table = 'branches';


    public function show()
    {
        dd(
            $this->highest_branch_balance()
        );
        $branches = DB::table($this->table)
            ->get();
        return view('branches', ['branches' => $branches]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
        ]);



        DB::table($this->table)->insert([
            $validated
        ]);

        return redirect()->back();
    }

    private function highest_branch_balance()
    {

        $highest = DB::table('users_branches')
            ->join('branches', 'branches.id', '=', 'users_branches.branch_id')
            ->join('balances', 'users_branches.user_id', '=', 'balances.user_id')
            ->select('name', DB::raw('MAX(balance) as highest_balance'))
            ->where('balance', '>', 50000)
            ->groupBy('branches.name')
            ->get();



        return ['highest_balance_branch' => $highest];
    }
}
