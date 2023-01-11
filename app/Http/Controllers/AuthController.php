<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function index() {
        if(is_login()){
            return redirect('dashboard');
        }
        return view('landing_page');
    }

    public function login(Request $request) {
        if(is_login()){
            $redirect = is_admin() ? 'admin' : 'dashboard';
            return redirect($redirect);
        }
        return view('auth/login');
    }

    public function register(Request $request){
        if(is_login()){
            $redirect = is_admin() ? 'admin' : 'dashboard';
            return redirect($redirect);
        }
        return view('auth/register');
    }

    public function profile() {
        if(!is_login()){
            $redirect = is_admin() ? 'admin' : 'dashboard';
            return redirect($redirect);
        }
        return view('auth/profile');
    }

    public function doLogin(Request $request){
        $request->validate([
            'email' => 'email|required',
            'password'   => 'required'
        ]);

        $req = $request->only('password', 'email');
        $userModel = new User();

        $isLogin = $userModel->data($req)->count() > 0 ? true : false;
        if(!$isLogin){
            return redirect('/login')
                   ->withInput()
                   ->with('status', show_alert('Email atau password salah', 'danger'));
        }

        $userData = $userModel->data($req)->first();
        Session::put('user', $userData);

        $redirect = is_admin() ? 'admin' : 'dashboard';
        return redirect($redirect);
    }

    public function doRegister(Request $request){
        $request->validate([
            'fullname' => 'required',
            'email' => 'email|required',
            'phone' => 'required',
            'password'   => 'required'
        ]);

        $req = $request->only('phone', 'password', 'email', 'fullname');
        $userModel = new User();

        $isEmailExist = $userModel->data('email', $req['email'])->count() > 0 ? true : false;
        if($isEmailExist){
            return back()
                   ->withInput()
                   ->with('status', show_alert('Email sudah terdaftar, silahkan coba yang lain', 'danger'));
        }

        $isPhoneExist = $userModel->data('phone', $req['phone'])->count() > 0 ? true : false;
        if($isPhoneExist){
            return back()
                   ->withInput()
                   ->with('status', show_alert('Nomor handphone sudah terdaftar, silahkan coba yang lain', 'danger'));
        }

        $req['created_at'] = date('Y-m-d H:i:s');
        $req['role'] = 'user';
        $isRegistered = $userModel->create($req);
        if(!$isRegistered){
            return back()
                   ->withInput()
                   ->with('status', show_alert('Registrasi gagal, silahkan coba yang lagi', 'danger'));
        }
        else{
        return redirect('/login')
               ->with('status', show_alert('Berhasil melakukan pendaftaran, silahkan login', 'success'));
        }
    }

    public function updateProfile(Request $request){
        $request->validate([
            'fullname' => 'required',
            'email' => 'email|required',
            'phone' => 'required',
            'full_address' => 'required'
        ]);

        $req = $request->only('phone', 'password', 'email', 'fullname', 'full_address');
        $userModel = new User();
        $userData = $request->session()->get('user');

        $exist = $userModel->data('email', $req['email'])->first();
        if(isset($exist->id)){
            if($exist->email != $userData->email){
                return back()
                   ->withInput()
                   ->with('status', show_alert('Email sudah terdaftar, silahkan coba yang lain', 'danger'));
            }
        }

        $exist = $userModel->data('phone', $req['phone'])->first();
        if(isset($exist->id)){
            if($exist->email != $userData->email){
                return back()
                   ->withInput()
                   ->with('status', show_alert('Nomor handphone sudah terdaftar, silahkan coba yang lain', 'danger'));
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

        $updatedUserData = $userModel->data('id', $userData->id)->first();
        $request->session()->put('user',$updatedUserData);

        return redirect('/dashboard/profile')
               ->with('status', show_alert('Berhasil mengubah profile', 'success'));
    }

    public function dashboard(){
        if(!is_login()){
            return redirect('');
        }

        $data['header'] = [
            'breadcrumb' => [
                ['title'=> 'Dashboard', 'url'=> '/dashboard'],
                ['title'=> 'Home'],
            ],
            'content_title' => 'Welcome To Dashboard'
        ];

        $data['meta'] = [
            'page_title' => 'Dashboard', 
        ];

        return view('dashboard', $data);
    }

    public function doLogout(){
        Session::flush();
        return redirect('');
    }
}
