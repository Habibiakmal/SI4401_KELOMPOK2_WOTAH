<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function __construct() {
        if (!is_admin()) return redirect('');
    }

    public function index(){
        return view('dashboard');
    }

    public function detail($clinicID){
        if(!is_login()){
            return redirect('');
        }
        
        $data = [
            'meta' => [
                'page_title' => 'Detail Klinik'
            ],
            'header' => [
                'breadcrumb' => [
                    ['title'=> 'Klinik', 'url'=> '/clinic'],
                    ['title'=> 'Daftar', 'url'=> '/clinic'],
                    ['title'=> 'Harapan Bunda'],
                ],
                'content_title' => 'Detail Klinik'
            ],
            'component' => COMPONENTS['master_data']['clinic'],
            'param' => [
                'clinicID' => $clinicID
            ]
        ];

        return view('master_data/clinic/detail', $data);
    }
}
