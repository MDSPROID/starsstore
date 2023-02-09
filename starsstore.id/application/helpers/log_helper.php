<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
// untuk aktif menu halaman customer
 function activate_menu($path, $className = 'aktif'){
    $CI         =& get_instance();
    $uri_string = $CI->uri->uri_string();

    // Home is usually at / && has 0 total segments
    if ($path === '/' && ($CI->uri->total_segments() === 0)) {
        $ret_val = 'aktif';
    } else {
        $ret_val = ($uri_string === $path) ? $className : '';
    }

    return $ret_val;
}  

function instagram_media(){
    $access_token = '1795454921.1677ed0.80a46416b7df48c49fddae973e4a13f1';
    $user_id = 'stars.allthebest';
    $json = file_get_contents("https://api.instagram.com/v1/users/self/media/recent/?access_token=" . $access_token . "&count=20");
    $a_json = json_decode($json, true);
    return $a_json;
}

// NOTIFIKASI ADMIN
 
function notif_kontak(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data_kontak = $CI->setting_adm->get_data_kontak();
    return $get_data_kontak;
}

function isi_notif_kontak(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data_kontak1 = $CI->setting_adm->get_data_isi_kontak();
    return $get_data_kontak1;
}

function notif_new_customer(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data_customer = $CI->setting_adm->get_data_new_customer();
    return $get_data_customer;
}

function notif_qna(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data_qna = $CI->setting_adm->get_data_qna();
    return $get_data_qna;
}

function notif_order(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data_order = $CI->setting_adm->get_data_order();
    return $get_data_order;
} 

function notif_stok(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data_stok = $CI->setting_adm->get_stok_critical();
    return $get_data_stok;
}

function notif_voucher_end(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data_voucher = $CI->setting_adm->get_voucher_end();
    return $get_data_voucher;
}

function notif_voucher_stok_end(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data_stok_end_voucher = $CI->setting_adm->get_voucher_stok_end();
    return $get_data_stok_end_voucher;   
}

function banner_end(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data_banner_end = $CI->setting_adm->get_banner_end();
    return $get_data_banner_end;   
}

function list_blacklist(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data_blacklist = $CI->setting_adm->get_blacklist();
    return $get_data_blacklist;   
}

// END NOTIFIKASI ADMIN

function getBankx(){
    $CI = & get_instance();
    $CI->load->model('checkout_model');
    $getBank = $CI->checkout_model->load_bank_data();
    return $getBank;      
}

function kursbca(){
    // Get cURL resource
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://www.klikbca.com',
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);
    // Close request to clear up some resources
    curl_close($curl);
    if($resp !== false){
        $pecah = explode('<table width="139" border="0" cellspacing="0" cellpadding="0">', $resp);
        $pecahLagi = explode('</table>', $pecah[2]);    
        //$result = $pecahLagi[1];
        $hasil =  "
        <table class='table-striped table-hover table-bordered text-center kursbca'>
            <tr>
                <td><b>Kurs</b></td>
                <td><b>Jual</b></td>
                <td><b>Beli</b></td>
            </tr>
        ".$pecahLagi[0]."
        </table>";

        return $hasil;
    }else{
        return "<p class='text-center'>Gagal memuat data kurs BCA.<br><b>refresh halaman (F5)</b></p>";
    }
}

function info_user_login(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $id = $CI->session->userdata('id');
    $get_data_login = $CI->setting_adm->get_data_log_user($id);
    return $get_data_login;
} 

function note_admin(){
    $CI = & get_instance(); 
    $CI->load->model('sec47logaccess/setting_adm');
    $id = $CI->session->userdata('id');
    $get_noteadmin = $CI->setting_adm->get_noteadmin($id);
    return $get_noteadmin;
} 

function info_customer_login(){
    $CI = & get_instance();
    $CI->load->model('users');
    $idcs = $CI->session->userdata('id');
    $get_data_login_cs = $CI->users->get_data_log_customer($idcs);
    return $get_data_login_cs;
}

function info_slide_promotion(){
    $CI = & get_instance();
    $CI->load->model('home');
    $get_data_promotion = $CI->home->get_data_slide_utama();
    return $get_data_promotion;
}

function seller(){
    $CI = & get_instance();
    $CI->load->model('users');
    $idcs = $CI->session->userdata('id');
    $get_data_login_seller = $CI->users->get_data_seller($idcs);
    return $get_data_login_seller;
}

function info_spesial_diskon(){
    $CI = & get_instance();
    $CI->load->model('users');
    $get_data_disc = $CI->users->get_spesial_diskon();
    return $get_data_disc;
}

function info_tips_belanja(){
    $CI = & get_instance();
    $CI->load->model('users');
    $get_tip = $CI->users->get_tips_belanja();
    return $get_tip;
}

// MODE TOKO LIBUR
function toko_libur(){
    $CI = & get_instance();
    $CI->load->model('preference');
    $get_data_libur= $CI->preference->toko_libur_set();
    return $get_data_libur;
}
// END MODE TOKO LIBUR

// MODE COMPANY PROFILE
function company_profile(){
    $CI = & get_instance();
    $CI->load->model('preference');
    $get_data_company = $CI->preference->toko_company_profile();
    return $get_data_company;
}
// END MODE TOKO LIBUR

// NOTIFIKASI CLOSING
function notif_closing(){
    $CI = & get_instance();
    $CI->load->model('preference');
    $get_notif_closing = $CI->preference->status_notifclosing();
    return $get_notif_closing;
}
// END NOTIFIKASI CLOSING

function for_header_front_end(){
    $CI = & get_instance();
    $CI->load->model('preference');
    $get_data_header_front_end= $CI->preference->front_end_header();
    return $get_data_header_front_end;
}

function for_header_front_end_kategori(){ 
    $CI = & get_instance();
    $CI->load->model('preference');
    $get_data_header_front_end= $CI->preference->front_end_header_kategori();
    return $get_data_header_front_end;
}

function for_header_front_end_merk(){
    $CI = & get_instance();
    $CI->load->model('preference');
    $get_data_header_front_merk= $CI->preference->front_end_header_merk();
    return $get_data_header_front_merk;   
}

function for_header_front_end_banner_nav(){
    $CI = & get_instance();
    $CI->load->model('preference');
    $get_data_header_front_banner_promo= $CI->preference->front_end_header_banner_nav();
    return $get_data_header_front_banner_promo;   
}

function for_header_front_end_banner_3_utama(){
    $CI = & get_instance();
    $CI->load->model('preference');
    $get_data_header_front_banner_promo= $CI->preference->front_end_header_banner_3_utama();
    return $get_data_header_front_banner_promo;   
}

function for_header_front_end_kategori_dekstop(){
    $CI = & get_instance();
    $CI->load->model('preference');
    $get_data_header_front_end= $CI->preference->front_end_header_kategori_desktop();
    return $get_data_header_front_end;
}

function for_footer_front_end(){
    $CI = & get_instance();
    $CI->load->model('preference');
    $get_data_footer_front_end = $CI->preference->front_end_footer();
    return $get_data_footer_front_end;
}

function for_header(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data = $CI->setting_adm->header();
    return $get_data;
}

function for_footer(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data = $CI->setting_adm->footer();
    return $get_data;
}

function for_footer_desc(){
    $CI = & get_instance();
    $CI->load->model('sec47logaccess/setting_adm');
    $get_data = $CI->setting_adm->get_desc_for_fotter();
    return $get_data;
}

function for_our_store(){ 
    $CI = & get_instance();
    $CI->load->model('home');
    $get_data = $CI->home->get_our_store();
    return $get_data;
}

function for_store_locator(){ 
    $CI = & get_instance();
    $CI->load->model('home');
    $get_data = $CI->home->get_store_locator();
    return $get_data;
}

function log_helper($tipe = "", $str = ""){
    $CI =& get_instance();
 
    if (strtolower($tipe) == "login"){
        $log_tipe   = 0;
    }
    elseif(strtolower($tipe) == "logout")
    {
        $log_tipe   = 1;
    }
    elseif(strtolower($tipe) == "dashboard"){
        $log_tipe   = 2;
    }
    elseif(strtolower($tipe) == "produk"){
        $log_tipe  = 3;
    }
    elseif(strtolower($tipe) == "kategori"){
        $log_tipe  = 4;
    }
    elseif(strtolower($tipe) == "merk"){
        $log_tipe  = 5;
    }
    elseif(strtolower($tipe) == "warna"){
        $log_tipe  = 6;
    }
    elseif(strtolower($tipe) == "ukuran"){
        $log_tipe  = 7;
    }
    elseif(strtolower($tipe) == "opsi"){
        $log_tipe  = 8;
    }
    elseif(strtolower($tipe) == "stok"){
        $log_tipe  = 9;
    }
    elseif(strtolower($tipe) == "review"){
        $log_tipe  = 10;
    }elseif(strtolower($tipe) == "bestseller"){ 
        $log_tipe  = 11;
    }elseif(strtolower($tipe) == "onlinestore"){ 
        $log_tipe  = 12;
    }elseif(strtolower($tipe) == "laporan"){ 
        $log_tipe  = 13;
    }elseif(strtolower($tipe) == "sistem"){ 
        $log_tipe  = 14;
    }elseif(strtolower($tipe) == "promosi"){ 
        $log_tipe  = 15;
    }elseif(strtolower($tipe) == "voucher"){ 
        $log_tipe  = 16;
    }elseif(strtolower($tipe) == "retur"){ 
        $log_tipe  = 17;
    }elseif(strtolower($tipe) == "customer"){ 
        $log_tipe  = 18;
    }elseif(strtolower($tipe) == "user"){ 
        $log_tipe  = 19;
    }elseif(strtolower($tipe) == "email"){ 
        $log_tipe  = 20;
    }elseif(strtolower($tipe) == "kontak"){ 
        $log_tipe  = 21;
    }elseif(strtolower($tipe) == "galeri"){ 
        $log_tipe  = 22;
    }elseif(strtolower($tipe) == "cekstokonline"){ 
        $log_tipe  = 23;
    }
    
    if(empty($CI->session->userdata('id'))){
        $id_pengguna = 0;
    }else{
        $id_pengguna = $CI->session->userdata('id');
    }
    // parameter
        $param['log_user']      = $id_pengguna;
        $param['log_tipe']      = $log_tipe;
        $param['log_desc']      = $str;
 
    //load model log
    $CI->load->model('log_activity');
    $CI->log_activity->save_log($param);
    $CI->log_activity->delete_old_log();
} 
function notifikasi_homepage(){ 
    $CI = & get_instance();
    $CI->load->model('home');
    $get_data = $CI->home->get_setting_notifhomepage();
    return $get_data;
}

function free_ongkir_all_city(){ 
    $CI = & get_instance(); 
    $CI->load->model('home');
    $get_data = $CI->home->get_setting_freeongkirallcity();
    return $get_data;
}

function list_city_freeongkir(){
    $CI = & get_instance(); 
    $CI->load->model('home');
    $get_data = $CI->home->list_city_freeongkir();
    return $get_data;   
}

function setting_cek_stok_produk(){
    $CI = & get_instance(); 
    $CI->load->model('home');
    $get_data = $CI->home->cek_status_sync_stok_produk();
    return $get_data;      
}
?>