<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Service extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'service';

    public function data($key = '', $value = ''){
        $tb = DB::table($this->table)->orderBy($this->table.".id", 'DESC');

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

    public function create($data){
        return DB::table($this->table)->insert($data);
    }

    public function updates($data, $id){
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    public function deletes($id){
        return DB::table($this->table)->where('id', $id)->delete();
    }
}
