<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customer_table = 'users';
    private $balance_table = 'balances';
    private $branch_table = 'branches';
    private $users_branches_table = 'users_branches';



    public function show_all()
    {


        $users = DB::table($this->customer_table)
            ->join('balances', 'users.id', '=', 'balances.user_id')
            ->select('users.*', 'balances.balance')
            ->get();
        $branches = DB::table($this->branch_table)->get();
        return view(
            'customers',
            [
                'users' => $users,
                'branches' => $branches
            ]
        );
    }
    public function show($id)
    {
        // user balance, name, general info, and other users

        // $balance = DB::table($customer_table)
        $user = DB::table($this->customer_table)
            ->join('balances', 'users.id', '=', 'balances.user_id')
            ->where('users.id', '=', $id)
            ->select('users.*', 'balances.balance')
            ->get();

        $other_users = DB::table($this->customer_table)
            ->where('users.id', '<>', $id)
            ->select('name', 'id')
            ->get();

        return view(
            'customer',
            [
                'user' => $user,
                'other_users' => $other_users

            ]
        );
    }

    // Create User, and balance and add it to a branch

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|unique:users,email',
            'balance' => 'required|min:0',
            'branch' => 'required'
        ]);
        $balance = $validated['balance'];
        $branch = $validated['branch'];
        unset($validated['branch']);
        unset($validated['balance']);

        $user_id = DB::table($this->customer_table)
            ->insertGetId(
                $validated
            );

        DB::table($this->balance_table)
            ->insert([
                'balance' => $balance,
                'user_id' => $user_id,
            ]);

        DB::table($this->users_branches_table)
            ->insert([
                'user_id' => $user_id,
                'branch_id' => $branch
            ]);

        return redirect()->back();
    }
    public function transfer_money($from, $to, $amount)
    {
        // check the amount of the user sending if he has enough money
        // transfer money by user ID

    }
}
