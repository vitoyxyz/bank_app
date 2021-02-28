<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{

    private  $table = 'branches';


    public function show()
    {

        $branches = DB::table($this->table)
            ->get();
        return view('branches', ['branches' => $branches]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
        ]);


        $validated['user_id'] = null;


        DB::table($this->table)->insert([
            $validated
        ]);
    }
}
