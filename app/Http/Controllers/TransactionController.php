<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\User;

class TransactionController extends Controller
{
    public function index(Request $request){
        if(!is_login()){
            return redirect('login');
        }

        $userData = $request->session()->get('user');
        $status = $request->query('status') ?? 'all';
        if($status != 'all'){
            $find['status'] = $status;
        }
        $find['user_id'] = $userData->id;

        $transactionModel = new Transaction();
        $serviceModel = new Service();
        $data = [
            'status' => $status,
            'list'   => $transactionModel->data($find)->get(),
            'service' => $serviceModel->data()->get()
        ];

        return view('transaction/index', $data);
    }

    public function detail(Request $request, $transaction_id){
        if(!is_login()){
            return redirect('login');
        }

        $userData = $request->session()->get('user');
        $find = [
            'user_id' => $userData->id,
            'transaction.id' => $transaction_id
        ];
        $transactionModel = new Transaction();
        $transaction = $transactionModel->data($find)->first();
        if(!isset($transaction->id)){
            return redirect('dashboard/transaction')->with('status', show_alert('Data tidak ditemukan', 'danger'));
        }

        $data = [
            'transaction' => $transaction,
            'bill'        => $transactionModel->getBillByTransactionID($transaction_id)
        ];
        return view('transaction/detail', $data);
    }

    public function uploadPayment(Request $request, $transaction_id){
        if(!is_login()){
            return redirect('login');
        }

        $userData = $request->session()->get('user');
        $find = [
            'user_id' => $userData->id,
            'transaction.id' => $transaction_id
        ];
        $transactionModel = new Transaction();
        $transaction = $transactionModel->data($find)->first();
        if(!isset($transaction->id)){
            return redirect('dashboard/transaction')->with('status', show_alert('Data tidak ditemukan', 'danger'));
        }

        $file       = $request->file('payment_proof');
        $filename   = $transaction_id."-".date('YmdHi').".".$file->getClientOriginalExtension();
        $file->move(public_path('/assets/payment'), $filename);
        
        $payment = [
            'payment_proof'     => $filename,
            'payment_proof_at'  => date('Y-m-d H:i:s'),
            'status'            => 'verify'
        ];
        $transactionModel->updates($payment, $transaction_id);

        return redirect('dashboard/transaction/'.$transaction_id)->with('status', show_alert('Bukti pembayaran berhasil dikirim', 'success'));
    }

    public function orderService(Request $request){
        if(!is_login()){
            return redirect('login');
        }

        $req = $request->only('service_id', 'issue_description');
        $userData = $request->session()->get('user');
        
        $serviceModel = new Service();
        $service = $serviceModel->data('id', $req['service_id'])->first();
        if(!isset($service->id)){
            return redirect('dashboard/transaction')->with('status', show_alert('Data layanan tidak ditemukan', 'danger'));
        }

        $transactionModel = new Transaction();
        $transaction = [
            'transaction_code'      => generateRandomString(),
            'service_used_by_user'  => $service->service_name,
            'issue_description'     => $req['issue_description'],
            'user_id'               => $userData->id,
            'type'                  => 'service',
            'status'                => 'pending',
            'created_at'            => date('Y-m-d H:i:s')
        ];

        $isCreated = $transactionModel->create($transaction);
        if(!$isCreated){
            return redirect('dashboard/transaction')->with('status', show_alert('Data tidak ditemukan', 'danger'));
        }

        return redirect('dashboard/transaction')
               ->with('status', show_alert('Pemesanan layanan berhasil, harap tunggu teknisi kami tiba ke alamat anda', 'success'));
    }

    public function adminGetListTransaction(Request $request){
        if(!is_admin()){
            return redirect('login');
        }

        $find = [];
        if(in_array($request->query('status'), ['pending', 'completed', 'waiting_payment', 'verify'])){
            $find['status'] = $request->query('status');
        }

        $transactionModel = new Transaction();
        $data = [
            'list' => $transactionModel->data($find)->get()
        ];
        return view('transaction/admin_list_transaction', $data);
    }

    public function adminDetailTransaction(Request $request, $transaction_id){
        if(!is_admin()){
            return redirect('login');
        }

        $transactionModel = new Transaction();
        $transaction = $transactionModel->data('transaction.id', $transaction_id)->first();
        if(!isset($transaction->id)){
            return redirect('admin/transaction')->with('status', show_alert('Data tidak ditemukan', 'danger'));
        }

        $userModel = new User();

        $data = [
            'transaction' => $transaction,
            'bill'        => $transactionModel->dataBill('transaction_id', $transaction->id)->first(),
            'user'        => $userModel->data('id', $transaction->user_id)->first()
        ];
        return view('transaction/admin_detail_transaction', $data);
    }

    public function adminConfirmPayment(Request $request, $transaction_id){
        if(!is_admin()){
            return redirect('login');
        }

        $transactionModel = new Transaction();
        $transaction = $transactionModel->data('transaction.id', $transaction_id)->first();
        if(!isset($transaction->id)){
            return redirect('admin/transaction')->with('status', show_alert('Data tidak ditemukan', 'danger'));
        }

        $transactionModel->updates([
            'status' => 'completed',
            'verified_at' => date('Y-m-d H:i:s')
        ], $transaction_id);

        return redirect('admin/transaction/'.$transaction_id)->with('status', show_alert('Behasil melakukan verifikasi pembayaran', 'success'));
    }

    public function adminSubmitService(Request $request, $transaction_id){
        if(!is_admin()){
            return redirect('login');
        }

        $request->validate([
            'technition_note' => 'required',
            'amount' => 'required'
        ]);

        $req = $request->only('technition_note', 'amount');

        $transactionModel = new Transaction();
        $transaction = $transactionModel->data('transaction.id', $transaction_id)->first();
        if(!isset($transaction->id)){
            return redirect('admin/transaction')->with('status', show_alert('Data tidak ditemukan', 'danger'));
        }

        $transactionModel->updates([
            'status' => 'waiting_payment',
            'amount' => $req['amount'],
            'technition_note' => $req['technition_note'],
            'submit_service_at' => date('Y-m-d H:i:s')
        ], $transaction_id);

        return redirect('admin/transaction/'.$transaction_id)->with('status', show_alert('Behasil melakukan submit servis', 'success'));
    }
}
