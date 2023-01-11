<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    function __construct() {
        if (!is_admin()) return redirect('');
    }

    public function index(Request $request){
        $userModel = new User();
        $data = [
            'list' => $userModel->data('role', 'user')->get()
        ];
        return view('user/index', $data);
    }

    public function edit(Request $request, $user_id){
        $userModel = new User();
        $user = $userModel->data('id', $user_id)->first();
        if(!isset($user->id)){
            return redirect('admin/user')->with('status', show_alert('Data tidak ditemukan', 'danger'));
        }

        $data = [
            'user' => $user
        ];
        return view('user/edit', $data);
    }

    public function insert(Request $request){
        $request->validate([
            'fullname'      => 'required',
            'email'         => 'email',
            'phone'         => 'required',
            'password'      => 'required',
            'full_address'  => 'full_address'
        ]);

        $req = $request->only('phone', 'password', 'email', 'fullname', 'full_address');
        $userModel = new User();

        $isEmailExist = $userModel->data('email', $req['email'])->count() > 0 ? true : false;
        if($isEmailExist){
            return back()
                   ->withInput()
                   ->with('status', show_alert('Email sudah ada, silahkan coba yang lain', 'danger'));
        }

        $isPhoneExist = $userModel->data('phone', $req['phone'])->count() > 0 ? true : false;
        if($isPhoneExist){
            return back()
                   ->withInput()
                   ->with('status', show_alert('Nomor handphone sudah ada, silahkan coba yang lain', 'danger'));
        }

        $req['created_at'] = date('Y-m-d H:i:s');
        $req['role'] = 'user';
        $isRegistered = $userModel->create($req);
        if(!$isRegistered){
            return back()
                   ->withInput()
                   ->with('status', show_alert('Nomor handphone sudah ada, silahkan coba yang lain', 'danger'));
        }

        return redirect('admin/user')
               ->with('status', show_alert('Data berhasil dimasukkan', 'success'));
    }

    public function update(Request $request, $user_id){
        $request->validate([
            'fullname' => 'required',
            'email' => 'email',
            'phone' => 'required',
            'full_address' => 'required'
        ]);

        $req = $request->only('phone', 'password', 'email', 'fullname', 'full_address');
        $userModel = new User();
        $userData = $userModel->data('id', $user_id)->first();

        $exist = $userModel->data('email', $req['email'])->first();
        if(isset($exist->id)){
            if($exist->email != $userData->email){
                return back()
                   ->withInput()
                   ->with('status', show_alert('Email sudah ada, silahkan coba yang lain', 'danger'));
            }
        }

        $exist = $userModel->data('phone', $req['phone'])->first();
        if(isset($exist->id)){
            if($exist->email != $userData->email){
                return back()
                   ->withInput()
                   ->with('status', show_alert('Nomor handphone sudah ada, silahkan coba yang lain', 'danger'));
            }
        }

        $req['updated_at'] = date('Y-m-d H:i:s');
        if($req['password'] == ''){
            unset($req['password']);
        }
        $isUpdated = $userModel->updates($req, $userData->id);
        if(!$isUpdated){
            return back()
                   ->withInput()
                   ->with('status', show_alert('Gagal update profile, coba lagi nanti', 'danger'));
        }

        return redirect('/admin/user')->with('status', show_alert('Berhasil mengubah data', 'success'));
    }

    public function delete(Request $request, $user_id){
        $userModel = new User();
        $isExist = $userModel->data('id', $user_id)->count() > 0 ? true : false;

        if(!$isExist){
            return redirect('/admin/user')
                   ->with('status', show_alert('Data tidak ditemukan', 'danger'));
        }

        $isDeleted = $userModel->deletes($user_id);
        if(!$isDeleted){
            return redirect('/admin/user')
                   ->with('status', show_alert('Gagal menghapus data, coba lagi nanti', 'danger'));
        }

        return redirect('/admin/user')
                   ->with('status', show_alert('Berhasil menghapus data', 'success'));
    }
}
