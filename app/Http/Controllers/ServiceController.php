<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    function __construct() {
        if (!is_admin()) return redirect('');
    }

    public function index(Request $request){
        $serviceModel = new Service();
        $data = [
            'list' => $serviceModel->data()->get()
        ];
        return view('service/index', $data);
    }

    public function insert(Request $request){
        $request->validate([
            'service_name' => 'required',
        ]);

        $req = $request->only('service_name');
        $serviceModel = new Service();

        $isServiceExist = $serviceModel->data('service_name', $req['service_name'])->count() > 0 ? true : false;
        if($isServiceExist){
            return back()
                   ->withInput()
                   ->with('status', show_alert('Servis sudah ada, silahkan coba yang lain', 'danger'));
        }

        $req['created_at'] = date('Y-m-d H:i:s');
        $isCreated = $serviceModel->create($req);
        if(!$isCreated){
            return back()
                   ->withInput()
                   ->with('status', show_alert('Gagal menambahkan data, silahkan coba yang lain', 'danger'));
        }

        return redirect('admin/service')
               ->with('status', show_alert('Data berhasil dimasukkan', 'success'));
    }

    public function edit(Request $request, $user_id){
        $serviceModel = new Service();
        $service = $serviceModel->data('id', $user_id)->first();
        if(!isset($service->id)){
            return redirect('admin/service')->with('status', show_alert('Data tidak ditemukan', 'danger'));
        }

        $data = [
            'service' => $service
        ];
        return view('service/edit', $data);
    }

    public function update(Request $request, $service_id){
        $request->validate([
            'service_name' => 'required',
        ]);

        $req = $request->only('service_name');
        $serviceModel = new Service();
        $serviceData = $serviceModel->data('id', $service_id)->first();

        $exist = $serviceModel->data('service_name', $req['service_name'])->first();
        if(isset($exist->id)){
            if($exist->service_name != $serviceData->service_name){
                return back()
                   ->withInput()
                   ->with('status', show_alert('Servis sudah ada, silahkan coba yang lain', 'danger'));
            }
        }

        $req['updated_at'] = date('Y-m-d H:i:s');
        $isUpdated = $serviceModel->updates($req, $serviceData->id);
        if(!$isUpdated){
            return back()
                   ->withInput()
                   ->with('status', show_alert('Gagal update servis, coba lagi nanti', 'danger'));
        }

        return redirect('/admin/service')->with('status', show_alert('Berhasil mengubah data', 'success'));
    }

    public function delete(Request $request, $service_id){
        $serviceModel = new Service();
        $isExist = $serviceModel->data('id', $service_id)->count() > 0 ? true : false;

        if(!$isExist){
            return redirect('/admin/service')
                   ->with('status', show_alert('Data tidak ditemukan', 'danger'));
        }

        $isDeleted = $serviceModel->deletes($service_id);
        if(!$isDeleted){
            return redirect('/admin/service')
                   ->with('status', show_alert('Gagal menghapus data, coba lagi nanti', 'danger'));
        }

        return redirect('/admin/service')
                   ->with('status', show_alert('Berhasil menghapus data', 'success'));
    }
}
