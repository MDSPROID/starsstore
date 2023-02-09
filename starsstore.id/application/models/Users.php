<?php
class Users extends CI_Model
 {
    function __construct() {
        $this->tableName = 'customer';
        $this->primaryKey = 'id';
    }

    function get_by_cookie($cookie)
    {
        $this->db->where('cookies', $cookie);
        return $this->db->get('customer');
    }

    function update_cookie($update_key, $idM){
        $this->db->where('id', $idM);
        $this->db->update('customer', $update_key);
    }

    function cek_valid_seller($id){
        $this->db->select('id_seller');
        $this->db->from('customer');
        $this->db->where('id', $id);
        return $this->db->get();
    }

    function get_cs($no){
        $this->db->select('id,nama_lengkap');
        $this->db->from('order_customer');
        $this->db->where('no_order_cus', $no);
        return $this->db->get();
    }

    function cek_review_order($no){
        $this->db->select('sudah_review');
        $this->db->from('order_customer');
        $this->db->where('no_order_cus',$no);
        return $this->db->get();
    }

    function get_id_produk($no){
        $this->db->select('*');
        $this->db->from('order_product');
        $this->db->where('no_order_pro', $no);
        return $this->db->get(); 
    }

    function get_rat_pro($idpr){
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->where('id_produk', $idpr);
        $t = $this->db->get(); 
        return $t->result();
    }

    function get_rating_produk($idh){
        $this->db->select('rating_produk,rating_produk_for_filter');
        $this->db->from('produk');
        $id = $_POST['rasuk'];
        for($i=0;$i<count($id);$i++){
            $this->db->where_in('id_produk', $idh['rasuk'][$i]);
        }
        return $this->db->get();
    }

    function add_review($data_rev){
        $this->db->insert_batch('produk_review',$data_rev);
    }

    function add_qna($data_qna){
        $this->db->insert('produk_q_n_a',$data_qna);   
    }

    function add_review_manual($data_rev){
        $this->db->insert('produk_review',$data_rev);
    }

    function update_produk_for_review($data_rev1){
        $this->db->update_batch('produk', $data_rev1,'id_produk');
    }

    function update_stat_rev($no, $sudah){
        $this->db->where('no_order_cus', $no);
        $this->db->update('order_customer', $sudah);
    }

    public function checkUsergoogle($data = array()){
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where(array('email'=>$data['email'], 'level'=> 'regcusok4*##@!9))921', 'akses'=> '9x4$58&(3*+'));
        $query2 = $this->db->get();
        $check = $query2->num_rows();
        
        if($check > 0){
            $result = $query2->row_array();
            $status_customer = $result['status'];
            // beri filter status jika akun telah ditemukan
           if($status_customer == "Nh3825(*hhb"){
                //jika status customer diblokir
                $userID = "blockingaccessreportacountcustomergoogle";
            }else{
                $data_update_cs = array(
                    'provider_login'    => $data['provider_login'],
                    'email'             => $data['email'],
                    'gb_user'           => $data['gb_user'],
                    'last_login'        => date("Y-m-d H:i:s"),
                    'ip_last_login'     => $this->input->ip_address(),
                    );
                $update = $this->db->update($this->tableName,$data_update_cs,array('id'=>$result['id']));
                // insert data tracking customer
                $data_track = array(
                    'id_user_track' => $result['id'],
                    'email'         => $result['email'],
                    'ip'            => $this->input->ip_address(),
                    'browser'       => $this->agent->browser(),
                    'platform'      => $this->agent->platform(),
                    'tanggal'       => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tracking_customer', $data_track);
                $userID = "okaccessallowedjosssgoogle";
            }
        }else{
            //jika tidak ditemukan maka insert sebagai customer baru dan status otomatis menjadi aktif. bukan verifikasi lagi. (customer loyal)
            $insert = $this->db->insert($this->tableName,$data);
            $userID = "cumabutuhloginotomatismarigoogle";
        }

        return $userID?$userID:false;
    }

    function checkUser($data = array()){
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where(array('email'=> $data['email'], 'level'=> 'regcusok4*##@!9))921', 'akses'=> '9x4$58&(3*+'));
        $prevQuery = $this->db->get();
        $prevCheck = $prevQuery->num_rows();        

       if($prevCheck > 0){
            // row_array hasil
            $prevResult = $prevQuery->row_array();
            $status_customer = $prevResult['status'];
            // beri filter status jika akun telah ditemukan
           if($status_customer == "Nh3825(*hhb"){
                //jika status customer diblokir
                $userID = "blockingaccessreportacountcustomer";
            }else{
                //jika user ditemukan langsung di update last loginnya
                 $data_update_cs_fb = array(
                    'provider_login'    => $data['provider_login'],
                    'email'             => $data['email'],
                    'gb_user'           => $data['gb_user'],
                    'last_login'        => date("Y-m-d H:i:s"),
                    'ip_last_login'     => $this->input->ip_address(),
                    );
                $update = $this->db->update($this->tableName,$data_update_cs_fb,array('id'=>$prevResult['id']));
                // insert data tracking customer
                $data_track = array(
                    'id_user_track' => $prevResult['id'],
                    'email'         => $prevResult['email'],
                    'ip'            => $this->input->ip_address(),
                    'browser'       => $this->agent->browser(),
                    'platform'      => $this->agent->platform(),
                    'tanggal'       => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tracking_customer', $data_track);
                $userID = "okaccessallowedjosss";
            }
        }else{
            //jika tidak ditemukan maka insert sebagai customer baru dan status otomatis menjadi aktif. bukan verifikasi lagi. (customer loyal)
            $insert = $this->db->insert($this->tableName,$data);
            $userID = "cumabutuhloginotomatismaringunu";
        }

        return $userID?$userID:FALSE;
    }

    function updateLastloginCustomer_fb($id, $img){
        $data = array(
            'gb_user'       => $img,
            'last_login'    => date('Y-m-d H:i:s'),
            'ip_last_login' => $this->input->ip_address(),
            );
        $this->db->where('id', $id);
        $this->db->update('customer', $data);
    }

     function saving_ipdevicebrowser_from_login_fb($id,$mailf){
        // insert data tracking customer
        $data_track = array(
            'id_user_track' => $id,
            'email'         => $mailf,
            'ip'            => $this->input->ip_address(),
            'browser'       => $this->agent->browser(),
            'platform'      => $this->agent->platform(),
            'tanggal'       => date('Y-m-d H:i:s'),
            );
        $this->db->insert('tracking_customer', $data_track);
        $userID = "okaccessallowedjosss";
    }

    function getMaillinsertantadi($mailf){
        $this->db->select('*');
        $this->db->where('email', $mailf);
        return $this->db->get('customer');
    }

    function get_data_customer($iduser){
        $this->db->select('*');
        $this->db->where('id', $iduser);
        $user = $this->db->get('customer');
        return $user->row_array();
    }

    function get_data_alamat_customer($iduser){
        $this->db->select('*');
        $this->db->where('id_cs_alamat', $iduser);
        return $this->db->get('alamat_customer');
    }

    function get_edit_data_customer($idf){
        $this->db->select('*');
        $this->db->where('id',$idf);
        $o = $this->db->get('customer');
        return $o->row();
    }

    function sk(){
        $this->db->select('*');
        $this->db->where('nama','s_k_seller');
        $o = $this->db->get('setting');
        return $o->result();   
    }

    function listretur($id_clas_us){
        $this->db->select('a.*, b.*');
        $this->db->from('order_informasi_retur a');
        $this->db->join('order_customer b', 'a.id_invoice_real=b.no_order_cus', 'left');
        $this->db->where('b.id_customer', $id_clas_us);
        $o = $this->db->get();
        return $o->result();
    }

    function detailretur($b){
        $this->db->select('a.*, b.*, c.*');
        $this->db->from('order_informasi_retur a');
        $this->db->join('customer b', 'a.id_customer_retur=b.id', 'left');
        $this->db->join('order_customer c', 'a.id_invoice_real=c.no_order_cus', 'left');
        $this->db->where('a.id_retur_info', $b);
        $o = $this->db->get();
        return $o->result();
    }

    function detailprodukretur($b){
        $this->db->select('*');
        $this->db->from('order_informasi_retur a');
        $this->db->join('order_produk_retur c', 'a.id_retur_info=c.id_retur_produk');
        $this->db->join('order_product d', 'c.id_produk_from_order_produk=d.idpr_order', 'left');
        $this->db->where('a.id_retur_info', $b);
        $o = $this->db->get();
        return $o->result();
    }

    function saving_produk_to_wishlist($data_wishlist){
       $this->db->insert_batch('wishlist', $data_wishlist);
    }

    function cek_double($b, $id_user){
        $this->db->select('*');
        $this->db->from('wishlist');
        $this->db->where('id_customer',$id_user);
        $this->db->where('id_produk', $b);
        return $this->db->get();
    }

    function add_to_wishlist($data_w){
        $this->db->insert('wishlist', $data_w);
    }

    function savingDatawithoutpassword($data_user, $id){
        $this->db->where('id', $id);
        $this->db->update('customer', $data_user);
    }

    function savingDatawithpassword($data_user, $id){
        $this->db->where('id', $id);
        $this->db->update('customer', $data_user);
    }

    function savingHack($aktifitas){
        $dataHack = array(
            'ip'        => $this->input->ip_address(),
            'browser'   => $this->agent->browser(),
            'platform'  => $this->agent->platform(),
            'aktifitas' => $aktifitas,
            'date_time' => date('Y-m-d H:i:s')
        );
        $this->db->insert('blacklist', $dataHack);
    }

    function reg_new_data_customer($data_user){
        $this->db->insert('customer',$data_user);
    }

    function updateLastloginCustomer($id){
        $data = array(
            'last_login' => date('Y-m-d H:i:s'),
            'ip_last_login' => $this->input->ip_address(),
            );
        $this->db->where('id', $id);
        $this->db->update('customer', $data);
    }

    function saving_ipdevicebrowser($id,$email){
         $data = array(
            'id_user_track' => $id,
            'email'         => $email,
            'ip'            => $this->input->ip_address(),
            'browser'       => $this->agent->browser(),
            'platform'      => $this->agent->platform(),
            'tanggal'       => date('Y-m-d H:i:s'),
            );
        $this->db->insert('tracking_customer', $data);
    }

    function gdata($email){
        $this->db->select('id');
        $this->db->where('email', $email);
        return $this->db->get('customer');
    }

    function get_data_log_customer($idcs){
        $this->db->where('id', $idcs);
        $this->db->from('customer');
        $q = $this->db->get();
        return $q->result();
    }

    function cek_data_reg_newuser($a){
        $this->db->select('email, password');
        $this->db->where('id', $a);
        return $this->db->get('customer');
    }

    function data_setting(){
        $this->db->select('*');
        return $this->db->get('setting');
    }

    function data_email_pusat(){
        $this->db->select('*');
        return $this->db->get('setting_email_account');
    }

    function cek_email($email){
        $this->db->select('email');
        $this->db->where('email', $email);
        return $this->db->get('customer');
    }

    function ubah_stat_cus($b,$data){
        $this->db->where('id', $b);
        $this->db->update('customer', $data);
    }

    function checkingStatus($email){
        $this->db->select('id,status');
        $this->db->from('customer');
        $this->db->where('email',$email);
        return $this->db->get();        
    }

    function validasi_data($email,$encrypt_default_rand){
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('email', $email);
        $this->db->where('password', $encrypt_default_rand);
        $this->db->where('status', 'a@kti76f0');
        $this->db->where('level', 'regcusok4*##@!9))921');
        $this->db->where('akses', '9x4$58&(3*+');
        return $this->db->get();
    }

    function listPesanan($id_clas_us){
        $this->db->select('*');
        $this->db->from('order_customer a');
        $this->db->join('order_produk_retur b', 'b.id_invoicepro=a.no_order_cus','left');
        $this->db->where('a.id_customer', $id_clas_us);
        $this->db->order_by('a.tanggal_waktu_order desc');
        $q = $this->db->get();
        return $q->result();
    }

    function cekidretur($b){
        $this->db->select('*');
        $this->db->from('order_produk_retur');
        $this->db->where('id_invoicepro', $b);
        return $this->db->get();    
    }

    function get_spesial_diskon(){
        $this->db->select('a.id_produk AS id_produknya, a.nama_produk, a.slug, a.gambar,a.rating_produk, a.status,b.*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b', 'b.id_produk_optional=a.id_produk', 'left');
        $this->db->where_in('a.status',array('on','soldout'));
        $this->db->group_by('a.id_produk');
        $this->db->limit(20);
        $q = $this->db->get();
        return $q->result();
    }

    function get_tips_belanja(){
        $this->db->select('*');
        $o = $this->db->get('setting');
        return $o->result();
    }

    function get_data_seller($idcs){
        $this->db->where('id_customer_seller', $idcs);
        $o = $this->db->get('seller');
        return $o->result();
    }

    function addIDseller($id, $idS){
        $this->db->where('id', $id);
        $this->db->update('customer',array('id_seller'=>$idS)); 
    }

    function wishlist($id_clas_us){
        $this->db->select('*');
        $this->db->where('id_customer', $id_clas_us);
        $o = $this->db->get('wishlist');
        return $o->result();
    }

    function review($id_clas_us){
        $this->db->select('a.id_produk, a.id_cs, a.nama_review, a.review, a.rating, a.tgl_review, a.status AS stat, b.id_produk, b.nama_produk');
        $this->db->from('produk_review a');
        $this->db->join('produk b', 'a.id_produk=b.id_produk', 'left');
        $this->db->where('a.id_cs', $id_clas_us);
        $o = $this->db->get();
        return $o->result();
    }

    function listFav($id_clas_us){
        $this->db->select('a.*, b.id_customer, b.id_produk AS idprw, c.*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color c','c.id_produk_optional=a.id_produk','left');
        $this->db->join('wishlist b', 'a.id_produk=b.id_produk', 'left');
        $this->db->where('b.id_customer', $id_clas_us);
        $this->db->group_by('a.id_produk');
        $o = $this->db->get();
        return $o->result();

    } 

    function checkingInv($b){
        $this->db->select('a.*, b.*, d.*'); //e.email, e.nama_lengkap,telp
        $this->db->from('order_customer a');
        $this->db->join('order_expedisi b', 'a.no_order_cus=b.no_order_ex', 'left');
        $this->db->join('order_with_voucher d', 'a.no_order_cus=d.no_order_vou', 'left');
        //$this->db->join('customer e', 'a.id_customer=e.id', 'left');
        $this->db->where('a.no_order_cus', $b);
        $q = $this->db->get();
        return $q->result();
    }

    function checkingdataorder($b){
        $this->db->select('a.*, c.*');
        $this->db->from('order_customer a');
        $this->db->join('order_product c', 'a.no_order_cus=c.no_order_pro', 'left');
        $this->db->where('a.no_order_cus', $b);
        $q = $this->db->get();
        return $q->result();   
    }

    function checkingdataBank($b){
        $this->db->select('a.*, b.*');
        $this->db->from('order_customer a');
        $this->db->join('daftar_rekening_pusat b', 'a.bank_pembayaran=b.code_network', 'left');
        $this->db->where('a.no_order_cus', $b);
        $q = $this->db->get();
        return $q->result();   
    }

    function dataprodukretur($data_retur){
        $this->db->insert('order_produk_retur', $data_retur);
    }

    function informasi_retur_pelanggan($id_pelanggan, $retNumber, $idorder, $alasan){
                $data_retur = array(
                    'id_retur_info'     => $retNumber,
                    'id_invoice_real'   => $idorder,
                    'id_customer_retur' => $id_pelanggan,
                    'alasan'            => $alasan,
                    'status_retur'      => "Ksgtvwt%t2ditangguhkan",
                    'date_create'       => date('Y-m-d H:i:s'),
                    'date_filter'       => date('Y-m-d'),
                );
        $this->db->insert('order_informasi_retur', $data_retur);
    }

    function inDataSeller($dataSeller){
        $this->db->insert('seller', $dataSeller);
    }

    function hapus_wishlist($b,$idcs){
        $this->db->where('id_customer', $idcs);
        $this->db->where('id_produk', $b);
        $this->db->delete('wishlist');
    }

    function cek_exp(){
        $this->db->select('*');
        return $this->db->get('reset_password_expired_id');
    }

    function hapus($id){
        $this->db->where('id_cs', $id);
        $this->db->delete('reset_password_expired_id');
    }

    function cek_valid_email($mail){
        $this->db->select('id,email');
        $this->db->where('email', $mail);
        return $this->db->get('customer');
    }

    function get_data_email_cs($id){
        $this->db->select('id,email');
        $this->db->where('id', $id);
        return $this->db->get('customer');
    }

    function cek_id_double($id_reset){
        $this->db->select('*');
        $this->db->where('id_cs', $id_reset);
        return $this->db->get('reset_password_expired_id');
    }

    function insert_expired_reset_akun($id_reset){
        $data = array(
            'id_cs'         => $id_reset,
            'date_expired'  => date('Y-m-d H:i:s', strtotime('2 hour')),
            );
        $this->db->insert('reset_password_expired_id', $data);
    }

    function cek_valid_id($id_decx){
        $this->db->select('date_expired');
        $this->db->where('id_cs', $id_decx);
        return $this->db->get('reset_password_expired_id');
    }

    function change_password_akun($id, $encrypt_default_rand){
        $data = array(
            'password' => $encrypt_default_rand,
            );
        $this->db->where('id', $id);
        $this->db->update('customer', $data);
    }

    function hapus_session_reset($id){
        $this->db->where('id_cs', $id);
        $this->db->delete('reset_password_expired_id');
    }
}              
 ?>