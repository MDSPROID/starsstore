<?php

class Setting_adm extends CI_model{
 
	// for log_helper

	var $table = 'setting';

	function header(){
		$this->db->where(array('id' => '1', 'aktif' => 'on'));
		$this->db->from($this->table);
		$q = $this->db->get();
		return $q->result();
	}

	function footer(){
		$this->db->where(array('id' => '2','aktif' => 'on'));
		$this->db->from($this->table);
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_log_user($id){
		$this->db->where('id', $id);
		$this->db->from('user');
		$q = $this->db->get();
		return $q->result();
	}

	// end for log_helper

	// pencarian header admin
	function cariInv($search){
		$this->db->select('*');
		$this->db->from('order_customer');
		$this->db->like('invoice',$search);
		$this->db->order_by('tanggal_waktu_order desc');
		$t = $this->db->get();
		return $t->result();
	}

	function cariRetur($search){
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('order_customer b','b.no_order_cus=a.id_invoice_real','left');
		$this->db->like('a.id_retur_info',$search);
		$t = $this->db->get();
		return $t->result();
	}

	function cariKontak($search){
		$this->db->select('*');
		$this->db->from('kontak');
		$this->db->like('no_kontak',$search);
		$this->db->order_by('date_create desc');
		$t = $this->db->get();
		return $t->result();
	}

	function cariProduk($search){
		$this->db->select('*');
		$this->db->from('produk a');
		$this->db->join('produk_get_color b','b.id_produk_optional=a.id_produk','left');
		$this->db->where("(a.nama_produk LIKE '%".$search."%' OR a.artikel LIKE '%".$search."%')");
		$this->db->order_by('a.tgl_dibuat desc');
		$this->db->group_by('a.id_produk');
		$t = $this->db->get();
		return $t->result();
	}
	// end pencarian header admin

	// notifikasi 

	function get_data_kontak(){
		$this->db->select('id_kontak, COUNT(id_kontak) as kt');
		$this->db->from('kontak');
		$this->db->where('baca','belum');
		$t = $this->db->get();
		return $t->result();
	}

	function get_data_isi_kontak(){
		$this->db->select('*');
		$this->db->from('kontak');
		$this->db->order_by('date_create desc');
		$this->db->limit(3);
		$t = $this->db->get();
		return $t->result();	
	}

	function get_data_order(){
		$this->db->select('id, COUNT(id) as pesanan');
		$this->db->from('order_customer');
		$this->db->where('baca','belum');
		$t = $this->db->get();
		return $t->result();
	}

	function get_data_qna(){
		$this->db->select('COUNT(id_q_n_a) as cus');
		$this->db->from('produk_q_n_a');
		$this->db->where('nama_balas','');
		$t = $this->db->get();
		return $t->row_array();	
	}

	function get_data_new_customer(){
		$this->db->select('id, COUNT(id) as cus');
		$this->db->from('customer');
		$this->db->where('baca','belum');
		$t = $this->db->get();
		return $t->result();	
	}

	function get_stok_critical(){ // get critical stok
		$this->db->select('a.id_produk_optional, COUNT(a.id_produk_optional) as stok, b.*');
		$this->db->from('produk_get_color a');
		$this->db->join('produk b', 'b.id_produk=a.id_produk_optional');
		$this->db->where('b.status','on');
		$this->db->where("a.stok BETWEEN 1 AND 5");
		$query=$this->db->get();
		return $query->result();
	}

	function get_voucher_end(){
		$this->db->select('id, COUNT(id) as vou');
		$this->db->from('voucher_and_coupon');
		$this->db->where('valid_until < now()');
		$t = $this->db->get();
		return $t->result();
	}

	function get_voucher_stok_end(){
		$this->db->select('id, COUNT(id) as voustok');
		$this->db->from('voucher_and_coupon');
		$this->db->where('qty = 0');
		$t = $this->db->get();
		return $t->result();
	}

	function get_banner_end(){
		$this->db->select('id_banner, COUNT(id_banner) as banner');
		$this->db->from('banner');
		$this->db->where('tgl_akhir < now()');
		$t = $this->db->get();
		return $t->result();	
	}

	function get_blacklist(){
		$this->db->select('id, COUNT(id) as blacklist');
		$this->db->from('blacklist');
		$this->db->where('baca','belum');
		$t = $this->db->get();
		return $t->result();	
	}

	// notifikasi penjualan by mail

	function get_report_by_this_month($get_month_number, $get_years){
		$this->db->select_sum('qty');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');
		$this->db->where('MONTH(b.tanggal_order)',$get_month_number);
		$this->db->where('YEAR(b.tanggal_order)',$get_years);
		$this->db->where_not_in('b.status', 'batal');
		$r = $this->db->get();
		return $r->row()->qty;
	}

	function get_report_by_this_week(){ 
		$this->db->select_sum('qty');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');
		$this->db->where('b.tanggal_order > DATE_SUB(NOW(), INTERVAL 1 WEEK)');
		$this->db->where_not_in('b.status', 'batal');
		$r = $this->db->get();
		return $r->row()->qty;
	}

	function get_report_by_this_today_dan_kemarin(){
		$this->db->select_sum('qty');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');
		$this->db->where('b.tanggal_order > DATE_SUB(NOW(), INTERVAL 1 DAY)');
		$this->db->where_not_in('b.status', 'batal');
		$r = $this->db->get();
		return $r->row()->qty;
	}

	function get_report_detail_by_this_today_dan_kemarin(){
		$this->db->select('b.nama_produk,b.artikel,a.harga_before,a.harga_fix,b.gambar,c.buy_in');
		$this->db->from('order_product a');
		$this->db->join('produk b', 'b.artikel=a.artikel','left');
		$this->db->join('order_customer c', 'c.no_order_cus=a.no_order_pro','left');
		$this->db->where('c.tanggal_order > DATE_SUB(NOW(), INTERVAL 2 DAY)');
		$this->db->where_not_in('c.status', 'batal');
		$r = $this->db->get();
		return $r->result();
	}

	// notifikasi penjualan by mail

	// end notifikasi

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

	function get_data_rek($b){
		$this->db->select('*');
		$this->db->from('daftar_rekening_pusat');
		$this->db->where('id',$b);
		$r = $this->db->get();
		return $r->result();	
	}

	function get_data_cabang_toko(){
		$this->db->select('*');
		$this->db->from('other_store');
		$t = $this->db->get();
		return $t->result();
	}

	function get_daftar_rek(){
		$this->db->select('*');
		$this->db->from('daftar_rekening_pusat');
		$t = $this->db->get();
		return $t->result();
	}

	function get_setting(){
		$this->db->select('*');
		$this->db->from('setting');
		$t = $this->db->get();
		return $t->result_array();
	}

	function get_noteadmin(){
		$this->db->select('konten');
		$this->db->from('setting');
		$this->db->where('id',9);
		$t = $this->db->get();
		return $t->row_array();
	}

	function simpan_note($datanote){
		$this->db->where('id', 9);
		$this->db->update('setting', $datanote);
	}

	function get_setting_page_default(){
		$this->db->select('*');
		$this->db->from('halaman_dinamis');
		$t = $this->db->get();
		return $t->result();
	}

	function get_setting_email(){
		$this->db->select('*');
		$this->db->from('setting_email_account');
		$t = $this->db->get();
		return $t->result_array();
	}

	function get_other_store($b){
		$this->db->select('*'); 
		$this->db->from('other_store');
		$this->db->where('id', $b);
		$t = $this->db->get();
		return $t->row_array();
	}

	function liburkan($data){
		$this->db->where('id', 7);
		$this->db->update('setting', $data);
	}

	function company($data){
		$this->db->where('id', 10);
		$this->db->update('setting', $data);
	}

	function set_page_store($data){
		$this->db->where('id', 5);
		$this->db->update('setting', $data);
	}

	function setNot($data){
		$this->db->where('id', 8);
		$this->db->update('setting', $data);	
	}

	function add_other_store($data){
		$this->db->insert('other_store', $data);	
	}
	
	function update_toko($idx, $data){
		$this->db->where('id', $idx);
		$this->db->update('other_store', $data);
	}

	function add_rek($data){
		$this->db->insert('daftar_rekening_pusat', $data);
	}

	function get_rek($b){
		$this->db->select('*'); 
		$this->db->from('daftar_rekening_pusat');
		$this->db->where('id', $b);
		$t = $this->db->get();
		return $t->row_array();
	}

	function edit_rek($idx, $data){
		$this->db->where('id', $idx);
		$this->db->update('daftar_rekening_pusat', $data);
	}

	function hapus($b){
		$this->db->where('id', $b);
		$this->db->delete('daftar_rekening_pusat');
	}

	function update_admin($ad22, $data_email){
		$this->db->where('id_acc_em_user', $ad22);
		$this->db->update('setting_email_account', $data_email);
	}

	function update_finance($fn22, $data_email){
		$this->db->where('id_acc_em_user', $fn22);
		$this->db->update('setting_email_account', $data_email);
	}

	function update_support($sp22, $data_email){
		$this->db->where('id_acc_em_user', $sp22);
		$this->db->update('setting_email_account', $data_email);
	}

	function update_sales($sl22, $data_email){
		$this->db->where('id_acc_em_user', $sl22);
		$this->db->update('setting_email_account', $data_email);
	}

	function update_cc($cc22, $data_email){
		$this->db->where('id_acc_em_user', $cc22);
		$this->db->update('setting_email_account', $data_email);
	}

	function update_bcc($bcc22, $data_email){
		$this->db->where('id_acc_em_user', $bcc22);
		$this->db->update('setting_email_account', $data_email);
	}

	function update_logo_utama($ilogo, $data_sett){
		$this->db->where('id', $ilogo);
		$this->db->update('setting', $data_sett);
	}

	function update_footer($fo22, $data_sett){
		$this->db->where('id', $fo22);
		$this->db->update('setting', $data_sett);
	}

	function update_logo_carbel($icarbel, $data_sett){
		$this->db->where('id', $icarbel);
		$this->db->update('setting', $data_sett);
	}

	function update_desc($iddesc, $data_sett){
		$this->db->where('id', $iddesc);
		$this->db->update('setting', $data_sett);	
	}

	function get_desc_for_fotter(){
		$this->db->select('*');
		$this->db->from('setting');
		$this->db->where('id = 6');
		$r = $this->db->get();
		return $r->result();
	}

	function update_halaman($b1, $data_halaman){
		$this->db->where('id_page', $b1);
		$this->db->update('halaman_dinamis', $data_halaman);
	}

	function get_kategori_halaman(){
		$this->db->select('*'); 
		$this->db->from('halaman_kategori');
		$t = $this->db->get();
		return $t->result();
	}

	function tambah_halaman_baru($data_halaman){
		$this->db->insert('halaman_dinamis', $data_halaman);
	}

	function get_halaman_added(){
		$this->db->select('*'); 
		$this->db->from('halaman_kategori a');
		$this->db->join('halaman_dinamis b', 'b.id_kategori=a.id_kategori_halaman','left');
		$this->db->where('b.id_page > 12');
		$t = $this->db->get();
		return $t->result();
	}

	function get_data_halaman($b){
		$this->db->select('*'); 
		$this->db->from('halaman_kategori a');
		$this->db->join('halaman_dinamis b', 'b.id_kategori=a.id_kategori_halaman','left');
		$this->db->where('b.id_page', $b);
		$t = $this->db->get();
		return $t->row_array();
	}

	function update_halaman_baru($b1,$data_halaman){
		$this->db->where('id_page', $b1);
		$this->db->update('halaman_dinamis', $data_halaman);
	}

	function hapus_halaman_baru($b){
		$this->db->where('id_page', $b);
		$this->db->delete('halaman_dinamis');
	}

	function update_user($idx, $data){
		$this->db->where('id', $idx);
		$this->db->update('user', $data);
	}
}

?>