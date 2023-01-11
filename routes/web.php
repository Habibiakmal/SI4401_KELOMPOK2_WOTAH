<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;

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

Route::get('/', [AuthController::class, 'index']);
Route::get('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'register']);

Route::post('auth/do_login', [AuthController::class, 'doLogin']);
Route::post('auth/do_register', [AuthController::class, 'doRegister']);
Route::get('auth/do_logout', [AuthController::class, 'doLogout']);

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');


Route::prefix('dashboard')->name('dashboard')->group(function (){
    Route::get('', [AuthController::class, 'dashboard']);

    Route::prefix('transaction')->name('transaction')->group(function (){
        Route::get('', [TransactionController::class, 'index']);
        Route::post('order_service', [TransactionController::class, 'orderService']);

        Route::get('{transaction_id}', [TransactionController::class, 'detail']);
        Route::post('{transaction_id}/upload_payment', [TransactionController::class, 'uploadPayment']);
    });

    Route::prefix('bill')->name('bill')->group(function (){
        Route::get('', [BillController::class, 'index']);
        Route::get('{transaction_id}', [BillController::class, 'detail']);
    });

    Route::prefix('profile')->name('profile')->group(function (){
        Route::get('', [AuthController::class, 'profile']);
        Route::post('update_profile', [AuthController::class, 'updateProfile']);
    });
});

Route::prefix('admin')->name('admin')->group(function (){
    Route::get('', [AuthController::class, 'dashboard']);

    Route::prefix('transaction')->name('transaction')->group(function (){
        Route::get('', [TransactionController::class, 'adminGetListTransaction']);

        Route::get('{transaction_id}', [TransactionController::class, 'adminDetailTransaction']);
        Route::get('{transaction_id}/confirm_payment', [TransactionController::class, 'adminConfirmPayment']);
        Route::post('{transaction_id}/submit_service', [TransactionController::class, 'adminSubmitService']);
    });

    Route::prefix('user')->name('user')->group(function (){
        Route::get('', [UserController::class, 'index']);
        Route::get('edit/{user_id}', [UserController::class, 'edit']);

        Route::post('insert', [UserController::class, 'insert']);
        Route::post('update/{user_id}', [UserController::class, 'update']);
        Route::get('delete/{user_id}', [UserController::class, 'delete']);
    });

    Route::prefix('service')->name('service')->group(function (){
        Route::get('', [ServiceController::class, 'index']);
        Route::get('edit/{service_id}', [ServiceController::class, 'edit']);

        Route::post('insert', [ServiceController::class, 'insert']);
        Route::post('update/{service_id}', [ServiceController::class, 'update']);
        Route::get('delete/{service_id}', [ServiceController::class, 'delete']);
    });

    Route::prefix('bill')->name('bill')->group(function (){
        Route::get('', [BillController::class, 'adminGetListBill']);
        Route::get('create/{user_id}/{year}/{month}', [BillController::class, 'adminCreateBill']);
        Route::post('insert/{user_id}/{year}/{month}', [BillController::class, 'adminInsertBill']);
    });
});