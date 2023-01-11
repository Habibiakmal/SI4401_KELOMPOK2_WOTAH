<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class BillController extends Controller
{
    public function index(Request $request){
        if(!is_login()){
            redirect('login');
        }

        $userData = $request->session()->get('user');
        $year = $request->query('year') ?? date('Y');
        $transactionModel = new Transaction();

        for ($i=1; $i <= 12 ; $i++) { 
            $bill[] = [
                'month' => $i,
                'year'  => $year,
                'bill'  => $transactionModel->getBillByUser($userData->id, $i, $year)
            ];
        }

        $data = [
            'list' => $bill,
            'year' => $year
        ];

        return view('bill/index', $data);
    }

    public function adminGetListBill(Request $request){
        if(!is_admin()){
            redirect('login');
        }

        $transactionModel = new Transaction();
        $userModel = new User();
        $year = $request->query('year') ?? date('Y');

        $bill = [];
        if($request->query('user_id')){
            $user_id = $request->query('user_id');
            $isExist = $userModel->data('id', $user_id)->count() > 0 ? true : false;
            if(!$isExist){
                return redirect('admin/bill')->with('status', show_alert('Data user tidak ditemukan', 'danger'));
            }

            for ($i=1; $i <= 12 ; $i++) { 
                $bill[] = [
                    'month' => $i,
                    'year'  => $year,
                    'bill'  => $transactionModel->getBillByUser($user_id, $i, $year)
                ];
            }
        }

        $data = [
            'user' => $userModel->data('role', 'user')->get(),
            'list' => $bill
        ];

        return view('bill/admin_list', $data);
    }

    //proses input data bill
    public function adminCreateBill(Request $request, $user_id, $year, $month){
        if(!is_admin()){
            redirect('login');
        }

        $transactionModel = new Transaction();
        $bill = $transactionModel->getBillByUser($user_id, $month, $year);
        if(isset($bill->id)){
            return redirect('admin/bill?user_id='.$user_id.'&year='.$year)
                   ->with('status', show_alert('Tagihan sudah pernah digenerate', 'danger'));
        }

        $userModel = new User();
        $data = [
            'user' => $userModel->data('id', $user_id)->first(),
            'user_id' => $user_id,
            'year' => $year,
            'month' => $month
        ];
        return view('bill/admin_create_bill', $data);
    }

    //Proses penginputan data ke database
    public function adminInsertBill(Request $request, $user_id, $year, $month){
        if(!is_admin()){
            redirect('login');
        }

        $request->validate([
            'usage' => 'required|numeric',
            'amount_per_usage' => 'required|numeric',
            'maintenance_price' => 'required|numeric',
        ]);

        $req = $request->only('usage', 'amount_per_usage', 'maintenance_price');

        $transactionModel = new Transaction();
        $bill = $transactionModel->getBillByUser($user_id, $month, $year);
        if(isset($bill->id)){
            return redirect('admin/bill?user_id='.$user_id.'&year='.$year)
                   ->with('status', show_alert('Tagihan sudah pernah digenerate', 'danger'));
        }

        $baseAmount = ($req['usage'] * $req['amount_per_usage']) + $req['maintenance_price'];
        $ppn = 0.1 * $baseAmount;
        $totalAmount = $baseAmount + $ppn;
        $now = date('Y-m-d H:i:s');

        $transaction = [
            'amount'            => $totalAmount,
            'transaction_code'  => generateRandomString(),
            'user_id'           => $user_id,
            'type'              => 'bill',
            'status'            => 'waiting_payment',
            'created_at'        => $now
        ];
        $transactionModel->create($transaction);

        $transactionData = $transactionModel->data($transaction)->first();
        $transactionModel->createBill([
            'transaction_id' => $transactionData->id,
            'month' => $month,
            'year'  => $year,
            'usage' => $req['usage'],
            'amount_per_usage' => $req['amount_per_usage'],
            'maintenance_price' => $req['maintenance_price'],
            'ppn_price' => $ppn,
            'total_amount' => $totalAmount,
            'created_at' => $now
        ]);

        return redirect('admin/bill?user_id='.$user_id.'&year='.$year)
                   ->with('status', show_alert('Tagihan berhasil dibuat', 'success'));
    }
}
