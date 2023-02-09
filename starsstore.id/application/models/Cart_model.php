<?php
class cart_model extends CI_Model
 {
    function get_produk_random(){
        $this->db->select('a.id_produk AS id_produknya, a.nama_produk, a.slug, a.merk, a.harga_retail, a.harga_odv, a.harga_net, a.diskon, a.diskon_rupiah, a.gambar,a.rating_produk, a.status, b.*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b', 'b.id_produk_optional=a.id_produk', 'left');
        $this->db->where_in('a.status','on');
        $this->db->order_by('rand()');
        $this->db->group_by('a.id_produk');
        $this->db->limit(10);
        $q = $this->db->get();
        return $q->result();
    }  

    function getdata($art){
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->join('produk_get_color b','b.id_produk_optional=a.id_produk','left');
        $this->db->where('a.artikel',$art);
        $q = $this->db->get();
        return $q->row_array();  
    }

    function get_all_coupon(){
        $this->db->select('*');
        $this->db->from('voucher_and_coupon a');
        $this->db->where('a.aktif','on');
        $this->db->where('a.valid_until >= NOW()');
        $q = $this->db->get();
        return $q->result();  
    }

    function cekKota($destination){
        $this->db->select('*');
        $this->db->from('kota_free_ongkir');
        $this->db->where('id_kota',$destination);
        $q = $this->db->get();
        return $q->num_rows();  
    }

    function get_ex(){
        $this->db->select('*');
        $this->db->from('expedisi_master');
        $q = $this->db->get();
        return $q->result();     
    }

    function cek_stok_produk($id, $idc,$ids){
        $this->db->select('*');
        $this->db->from('produk_get_color');
        $this->db->where('id_produk_optional', $id);
        $this->db->where('id_opsi_get_color', $idc);
        $this->db->where('id_opsi_get_size', $ids);
        $get = $this->db->get();
        return $get->result();
    }

     function cek_voucher($voucher){
        $this->db->select('*');
        $this->db->from('voucher_and_coupon');
        $this->db->where('voucher_and_coupons', $voucher);
        $this->db->where('aktif', 'on');
        $get = $this->db->get();
        return $get->result();
    }

    function cek_pengguna($id_customer, $voucher){
        $this->db->select('*');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('voucher', $voucher);
        return $this->db->get('voucher_use');
    }

    function cek_validasi_voucher($voucher){
        $this->db->select('*');
        $this->db->where('voucher_and_coupons',$voucher);
        $this->db->where('aktif', 'on');
        return $this->db->get('voucher_and_coupon');
    } 

    function ambil_quantity_voucher($voucher){
        $this->db->select('qty');
        $this->db->from('voucher_and_coupon');
        $this->db->where('voucher_and_coupons', $voucher);
        $get = $this->db->get();
        return $get->result();
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

    function kurangi_quantity_voucher($voucher, $qty_total){
        $data=array(
            'qty'                   => $qty_total - 1,
            'last_use_customer'     => date("Y-m-d H:i:s"),
            );
        $this->db->where('voucher_and_coupons', $voucher);
        $this->db->update('voucher_and_coupon', $data);
    }

    function get_voucher($voucher){
        $this->db->select('*');
        $this->db->where('voucher_and_coupons', $voucher);
        return $this->db->get('voucher_and_coupon');
    }
}              
 ?>