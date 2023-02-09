<?php
class checkout_model extends CI_Model
 {

    function cek_stok_produk($id){
        $this->db->select('stok');
        $this->db->from('produk');
        $this->db->where('id_produk', $id);
        $get = $this->db->get();
        return $get->result(); 
    }

    function get_produk_for_fc($idProduk){
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->where('id_produk', $idProduk);
        $r = $this->db->get();
        return $r->result();
    }

    function cek_validasi_voucher($voucher){
        $this->db->select('*');
        $this->db->where('voucher_and_coupons',$voucher);
        $this->db->where('aktif', 'on');
        return $this->db->get('voucher_and_coupon');
    } 

    function cek_pengguna($id_customer, $voucher){
        $this->db->select('*');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('voucher', $voucher);
        return $this->db->get('voucher_use');
    }

    function get_voucher($voucher){
        $this->db->select('*');
        $this->db->where('voucher_and_coupons', $voucher);
        return $this->db->get('voucher_and_coupon');
    }

    function get_id_data($kat_id, $idc, $idsz){
        $data = array(
            'id_produk_optional' => $kat_id,
            'id_opsi_get_color' => $idc,
            'id_opsi_get_size' => $idsz,
            );
        $this->db->select('*');
        $this->db->where($data);
        $this->db->where('stok > 0');
        $this->db->from('produk_get_color');
        $r = $this->db->get();
        return $r->result();
    }

    function check_id_seller_to_db_produk(){
        foreach($this->cart->contents() as $item){
             $data = array(
                'id_produk' => $item['id'],
            );
            $this->db->select('*');
            $this->db->from('produk');
            //$this->db->join('seller', 'produk.idseller=seller.id_seller');
            $this->db->where($data);
            //$this->db->where('seller.status_seller', 'aktifSeller');
            $t = $this->db->get();
            return $t->result();
        }
    }

    function kurangi_stok($data_stok_pro,$id_pr, $idcolor, $idsize){
        $data = array(
            'id_produk_optional' => $id_pr,
            'id_opsi_get_color' => $idcolor,
            'id_opsi_get_size' => $idsize,
            );
        $this->db->where($data);
        $this->db->where('stok > 0');
        $this->db->update('produk_get_color',$data_stok_pro);
    }

    function kurangiStokproduk(){
        foreach($this->cart->contents() as $item){
            $data_stok_pro = array(
                'id_produk_optional' => $item['id'],
                'id_opsi_get_color' => $item['optidcolor'],
                'id_opsi_get_size' => $item['optidsize'],
                'stok'  => $item['stocksize'] - $item['qty'],
            );
            //kurangi stok berdasarkan 1 warna dan size, meski size berbeda, dan id produk sama dapat dibedakan dan dikurangi karena memakai where yang tepat.
            $this->db->where('id_produk_optional', $item['id']);
            $this->db->where('id_opsi_get_color', $item['optidcolor']);
            $this->db->where('id_opsi_get_size', $item['optidsize']);
            $this->db->where('stok', $item['stocksize']);
            $this->db->update('produk_get_color', $data_stok_pro);
        }
    }

//    function kurangiStokproduk(){
//        foreach($this->cart->contents() as $item){
//            $data_stok_pro = array(
//                array(
//                    'id_produk' => $item['id'],
//                    'stok'  => $item['stok'] - $item['qty'],
//                ),
//            );
//        $this->db->update_batch('produk_get_color', $data_stok_pro, 'id_produk');
//        }
//    }

    function keluarkan_dt_cs($id){
        $this->db->select('nama_lengkap, telp, email');
        $this->db->where('id', $id);
        return $this->db->get('customer');
    }

    function keluarkan_dt_adm(){
        $this->db->select('*');
        return $this->db->get('setting_email_account');
    }

    function get_data_order_cs($random){
        $this->db->select('*');
        $this->db->where('no_order_cus', $random);
        return $this->db->get('order_customer');
    }

    function get_data_produk_for_send_to_email($random){
        $this->db->select('*');
        $this->db->where('no_order_pro', $random);
        return $this->db->get('order_product');
    }

    function simpan_alamat_cs_checkout($data_alamat_cs){
        $this->db->insert('alamat_customer', $data_alamat_cs);
    }

    function load_bank_data(){
        $this->db->select('*');
        $this->db->from('daftar_rekening_pusat');
        $this->db->where('aktife_stat_bank', 'on');
        $y = $this->db->get();
        return $y->result();
    }

    function cekmailusevoucher($kupon,$email){
        $this->db->select('*');
        $this->db->from('voucher_use');
        $this->db->where('emailuse', $email);
        $this->db->where('voucher',$kupon);
        $y = $this->db->get();
        return $y->num_rows();
    }

    function selectInfbnk($bnk){
        $this->db->select('*');
        $this->db->where('code_network', $bnk);
        return $this->db->get('daftar_rekening_pusat');
    }

    function simpan_kode_dan_id_customer($id_customer, $voucher){
        $data=array(
            'id_customer' => $id_customer,
            'voucher'     => $voucher,
            'qty'         => "1",
            'date_use'    => date("Y-m-d H:i:s"),
            );
        $this->db->insert('voucher_use', $data);
    }

    function get_point_customer($id){
        $this->db->select('point_terkumpul');
        $this->db->where('id',$id);
        return $this->db->get('customer');
    }

    function upgradePoint($get_t_p_cs, $id){
        $this->db->where('id', $id);
        $this->db->update('customer', $get_t_p_cs);
    }

    function ambil_quantity_voucher($voucher){
        $this->db->select('qty');
        $this->db->from('voucher_and_coupon');
        $this->db->where('voucher_and_coupons', $voucher);
        $get = $this->db->get();
        return $get->row();
    }

     function kurangi_quantity_voucher($voucher, $qty_total){
        $data=array(
            'qty'                   => $qty_total - 1,
            'last_use_customer'     => date("Y-m-d H:i:s"),
            );
        $this->db->where('voucher_and_coupons', $voucher);
        $this->db->update('voucher_and_coupon', $data);
    }
    
    function insert_to_db($data_order){
        $this->db->insert_batch('order_product', $data_order);
    }

    function updateLastloginCustomer($id){
        $data = array(
            'last_login' => date('Y-m-d H:i:s')
            );
        $this->db->where('id', $id);
        $this->db->update('customer_user', $data);
    }

    function validasi_data($email,$pass1){
        $this->db->where('email', $email);
        $this->db->where('password', $pass1);
        $this->db->where('status', 'a@kti76f0');
        $this->db->where('level', 'regcusok4*##@!9))921');
        $this->db->where('akses', '9x4$58&(3*+');
        return $this->db->get('customer_user');
    }    

    function saving_order_data_customer($data_customer){
        $this->db->insert('order_customer', $data_customer);
    }

    function saving_order($data_order){
        $this->db->insert_batch('order_product', $data_order);
    }

    function savingCustomerwithvoucher($data_customer_with_voucher){
        $this->db->insert('order_with_voucher', $data_customer_with_voucher);
    }

    function savingvoucheruse($data_voucheruse){
        $this->db->insert('voucher_use', $data_voucheruse);   
    }

    function saving_expedition($data_expedisi){
        $this->db->insert('order_expedisi', $data_expedisi);
    }

     function validasi_data_login($email){
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('email', $email);        
        $this->db->where('status', 'a@kti76f0');
        $this->db->where('level', 'regcusok4*##@!9))921');
        $this->db->where('akses', '9x4$58&(3*+');
        return $this->db->get();
    }
}              
 ?>