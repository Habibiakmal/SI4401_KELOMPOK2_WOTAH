<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Transaction extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'transaction';

    public function data($key = '', $value = ''){
        $tb = DB::table($this->table)
              ->selectRaw($this->table.".*,user.fullname, user.email, user.phone, user.full_address")
              ->join('user', 'user.id', '=', $this->table.'.user_id')
              ->orderBy($this->table.".id", 'desc');

        if($key != ''){
            if(is_array($key)){
                foreach ($key as $k => $v) {
                    $tb->where($k, $v);
                }

            }else{
                $tb->where($key, $value);
            }
        }

        return $tb;
    }

    public function getBillByTransactionID($transaction_id){
        return DB::table('bill')->where('transaction_id', $transaction_id)->first();
    }

    public function getBillByUser($user_id, $month, $year){
        $tb = DB::table('bill');
        
        $tb->selectRaw('bill.*, transaction.status AS status')
           ->where('user_id', $user_id)
           ->join('transaction', 'transaction.id', '=', 'bill.transaction_id')
           ->where('month', $month)
           ->where('year', $year);

        return $tb->first();
    }

    public function create($data){
        return DB::table($this->table)->insert($data);
    }

    public function createBill($data){
        return DB::table('bill')->insert($data);
    }

    public function dataBill($key = '', $value = ''){
        $tb = DB::table('bill')->orderBy("bill.id", 'desc');

        if($key != ''){
            if(is_array($key)){
                foreach ($key as $k => $v) {
                    $tb->where($k, $v);
                }

            }else{
                $tb->where($key, $value);
            }
        }

        return $tb;
    }

    public function updates($data, $id){
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    public function deletes($id){
        return DB::table($this->table)->where('id', $id)->delete();
    }
}
