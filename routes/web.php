<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/branches', [BranchController::class, 'show_all']);
Route::get('branch/create', [BranchController::class, 'create']);
Route::get('/branch/{id}', [BranchController::class, 'show']);
Route::post('branch/store', [BranchController::class, 'store']);


Route::get('/customers', [CustomerController::class, 'show_all']);
Route::get('/customer/create', [CustomerController::class, 'create']);
Route::get('/customer/{id}', [CustomerController::class, 'show']);
Route::post('/customer/store', [CustomerController::class, 'store']);
Route::post('/customer/transfer', [CustomerController::class, 'transfer_money']);
