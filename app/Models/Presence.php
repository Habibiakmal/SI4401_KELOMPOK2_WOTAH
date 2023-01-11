<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Presence extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'presence';

    public function getFullPresence($month, $year, $employee_id = ''){
        $db = DB::table($this->table)
            ->whereMonth('date', $month)->whereYear('date', $year)
            ->selectRaw($this->table.'.*, name, employee_code')
            ->join('user', 'user.id', '=', $this->table.'.user_id')
            ->orderBy($this->table.".date", 'desc');

        if ($employee_id != '') $db->where('employee_id', $employee_id);

        return $db->get();
    }

    public function data($key = '', $value = ''){
        $tb = DB::table($this->table);

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
