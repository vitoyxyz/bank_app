<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class CustomerController extends Controller
{
    private $customer_table = 'users';
    private $balance_table = 'balances';
    private $branch_table = 'branches';
    private $users_branches_table = 'users_branches';
    private $transaction_table = 'users_transaction_history';


    public function show_all()
    {


        $users = DB::table($this->customer_table)
            ->join('balances', 'users.id', '=', 'balances.user_id')
            ->select('users.*', 'balances.balance')
            ->get();
        $branches = DB::table($this->branch_table)->get();
        return view(
            'customer.customers',
            [
                'users' => $users,
                'branches' => $branches
            ]
        );
    }
    public function show($id)
    {
        // user balance, name, general info, and other users

        $user = DB::table($this->customer_table)
            ->join('balances', 'users.id', '=', 'balances.user_id')
            ->where('users.id', '=', $id)
            ->select('users.*', 'balances.balance')
            ->get();

        $other_users = DB::table($this->customer_table)
            ->where('users.id', '<>', $id)
            ->select('name', 'id', 'email')
            ->get();
        $transactions['send'] = DB::table($this->transaction_table)
            ->join('users', "{$this->transaction_table}.send_to_user", '=', 'users.id')
            ->where('send_from_user', '=', $id)
            ->get();

        $transactions['received'] = DB::table($this->transaction_table)
            ->join('users', "{$this->transaction_table}.send_from_user", '=', 'users.id')
            ->where('send_to_user', '=', $id)
            ->get();
        return view(
            'customer.customer',
            [
                'user' => $user,
                'other_users' => $other_users,
                'transactions' => $transactions
            ]
        );
    }

    public function create()
    {
        return view('customer.create', ['branches' =>  DB::table($this->branch_table)->get()]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|unique:users,email',
            'balance' => 'required|numeric|min:0',
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

        return redirect('/customers');
    }
    public function transfer_money(Request $request)
    {
        // check the amount of the user sending if he has enough money
        // transfer money by user ID

        $validated = $request->validate([
            'from_user' => 'required',
            'to_user' => 'required',
            'amount' => 'required|min:1',
        ]);
        $current_user_balance = DB::table($this->balance_table)
            ->select('balance')
            ->where('user_id', '=', $validated['from_user'])
            ->get();
        if ($validated['amount'] <= $current_user_balance) {

            DB::table($this->balance_table)
                ->where('user_id', $validated['to_user'])
                ->increment('balance', $validated['amount']);

            DB::table($this->balance_table)
                ->where('user_id', $validated['from_user'])
                ->decrement('balance', $validated['amount']);
            DB::table($this->transaction_table)
                ->insert([
                    'send_from_user' => $validated['from_user'],
                    'send_to_user' => $validated['to_user'],
                    'amount' => $validated['amount'],
                ]);
            return redirect()->back();
        } else {
            return redirect()->back()->with('errors', 'Not enough money!');
        }
    }
}
