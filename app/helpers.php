<?php

if(!function_exists('show_alert')){
    function show_alert($message, $status){
        return '<div class="alert alert-'.$status.' alert-dismissible fade show" role="alert">
                    '.$message.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

if(!function_exists('is_login')){
    function is_login(){
        if(Session::has('user')) return true;
        return false;
    }
}


if(!function_exists('is_admin')){
    function is_admin(){
        if(!is_login()) return false;
        if(Session::get('user')->role == 'admin') return true;

        return false;
    }
}

if(!function_exists('is_user')){
    function is_user(){
        if(!is_login()) return false;
        if(Session::get('user')->role == 'user') return true;

        return false;
    }
}

if(!function_exists('placeholder')){
    function placeholder($colSize = 12, $rowCount = 1){
        $p = '';
        for ($i=0; $i < $rowCount; $i++) {
            $p .= '<span class="placeholder rounded-border col-'.$colSize.'"></span>';
        }

        return '<p class="card-text placeholder-glow">'.$p.'</p>';
    }
}

if(!function_exists('placeholderCircle')){
    function placeholderCircle($size = 50){
        return '<p class="card-text placeholder-glow"><span class="placeholder rounded-circle" style="height:'.$size.'px;width:'.$size.'px"></span></p>';
    }
}

if(!function_exists('format_rp')){
    function format_rp($amount){
        return 'Rp '.number_format($amount, 0, 0, '.');
    }
}

if(!function_exists('formatRp')){
    function formatRp($amount){
        return 'Rp '.number_format($amount, 0, 0, '.');
    }
}

if(!function_exists('indonesianDate')){
    function indonesianDate($dateString, $withTime = false){
        $day = date('d', strtotime($dateString));
        $month = date('m', strtotime($dateString));
        $year = date('Y', strtotime($dateString));

        $time = '';
        if($withTime){
            $time = ' '.date('H:i', strtotime($dateString));
        }
        return $day." ".getMonthName($month)." ".$year.$time;
    }
}

if(!function_exists('getMonthName')){
    function getMonthName($month){
        $indonesia_month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return $indonesia_month[$month - 1] ?? '';
    }
}

if(!function_exists('transactionType')){
    function transactionType($type){
        $label = '';
        if($type == 'bill'){
            $label = 'Tagihan';
        }else if($type == 'service'){
            $label = 'Servis';
        }

        return $label;
    }
}

if(!function_exists('transactionStatus')){
    function transactionStatus($status){
        $label = '';
        $color = 'light';

        if($status == 'completed'){
            $label = "Selesai";
            $color = "success";
        }else if($status == 'waiting_payment'){
            $label = "Menunggu Pembyaran";
            $color = "primary";
        }else if($status == 'verify'){
            $label = "Verifikasi Pembayaran";
            $color = "warning";
        }else if($status = 'pending'){
            $label = "Pending";
            $color = "info";
        }

        return "<div class='badge bg-".$color."'>".$label."</div>";
    }
}

if(!function_exists('generateRandomString')){
    function generateRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

?>