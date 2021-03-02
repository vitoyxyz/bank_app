<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{

    private  $branches_table = 'branches';
    private  $users_branches_table = 'users_branches';


    public function show_all()
    {

        // $branches = DB::table($this->branches_table)
        //     ->get();

        return view('branch.branches', [
            // 'branches' => $branches,
            'branches' => $this->highest_branch_balance(),
            'over_50' => $this->highest_branch_balance(50000)

        ]);
    }


    public function show($id)
    {
        // user balance, name, general info, and other users
        $users = DB::table($this->users_branches_table)
            ->join('users', 'users.id', '=', 'users_branches.user_id')
            ->where('users_branches.branch_id', '=', $id)
            ->get();
        $branch = DB::table($this->branches_table)
            ->where('id', '=', $id)
            ->get();

        return view(
            'branch.branch',
            [
                'users' => $users,
                'branch' => $branch
            ]
        );
    }



    public function create()
    {
        return view('branch.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:branches|max:50',
            'location' => 'required|unique:branches|max:50',
        ]);



        DB::table($this->branches_table)->insert([
            $validated
        ]);

        return redirect('/branches');
    }

    private function highest_branch_balance($where = null)
    {
        if ($where !== null) {
            $data = DB::table('branches')
                ->leftJoin('users_branches', 'branches.id', '=', 'users_branches.branch_id')
                ->leftJoin('balances', 'balances.user_id', '=', 'users_branches.user_id')
                ->select('name', 'location', 'branches.id',  DB::raw('MAX(balance) as highest_balance'))
                ->where('balance', '>=', $where)
                ->groupBy('branches.name', 'branches.location', 'branches.id')
                ->get();
            return $data;
        }

        $data = DB::table('branches')
            ->leftJoin('users_branches', 'branches.id', '=', 'users_branches.branch_id')
            ->leftJoin('balances', 'balances.user_id', '=', 'users_branches.user_id')
            ->select('name', 'location', 'branches.id',  DB::raw('MAX(balance) as highest_balance'))
            ->groupBy('branches.name', 'branches.location', 'branches.id')
            ->get();

        return  $data;
    }
}
