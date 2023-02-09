<?php
class Model_admst extends CI_Model{
	
	var $table = 'user';  

	var $tablestore = 'toko';
    var $column_order = array(null, 'a.id_toko','a.nama_toko'); //set column field database for datatable orderable
    var $column_search = array('a.nama_toko','a.alamat','a.kode_sms','a.kode_edp','a.spv','a.ass','a.wa_toko','a.spv_nomor','a.ass_nomor','a.latitude','a.longitude','a.toko_aktif','b.area','b.nama_bdm'); //set column field database for datatable searchable 
    var $order = array('a.id_toko' => 'desc'); // default order 

	function get_store(){
		$this->db->select('*');
		$this->db->from('toko a');
		$this->db->join('bdm b', 'b.id=a.id_bdm','left');
		$this->db->order_by('a.id_toko desc');
		$x = $this->db->get();
		return $x->result();
	}

	private function _get_datatables_query()
    {
        $this->db->from('toko a');
		$this->db->join('bdm b', 'b.id=a.id_bdm','left');
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->tablestore);
        return $this->db->count_all_results();
    }

    function list_bdm(){
    	$this->db->select('*');
		$this->db->from('bdm');
		$rt = $this->db->get();
		return $rt->result();
    }

    function simpanToko($data_toko){
    	$this->db->insert('toko', $data_toko);
    }

    function off_toko($id){
    	$data = array(
    		'toko_aktif' => '',
    	);
    	$this->db->where('id_toko', $id);
    	$this->db->update('toko', $data);
    }

    function on_toko($id){
    	$data = array(
    		'toko_aktif' => 'on',
    	);
    	$this->db->where('id_toko', $id);
    	$this->db->update('toko', $data);
    }

    function get_toko($id){
    	$this->db->select('*');
		$this->db->from('toko a');
		$this->db->join('bdm b', 'b.id=a.id_bdm', 'left');
		$this->db->where('id_toko',$id);
		$rt = $this->db->get();
		return $rt->row_array();
   	}

    function updateToko($data_toko,$id){
    	$this->db->where('id_toko', $id);
    	$this->db->update('toko', $data_toko);
    }

    function hapus_toko($id){
    	$this->db->where('id_toko', $id);
    	$this->db->delete('toko');
    }

    function simpanBDM($data_bdm){
    	$this->db->insert('bdm', $data_bdm);	
    }

    function updateBDM($data_bdm, $id){
    	$this->db->where('id', $id);
    	$this->db->update('bdm', $data_bdm);
    }

    function hapus_bdm($id){
    	$this->db->where('id', $id);
    	$this->db->delete('bdm');
    }

    function get_data_bdm($id){
    	$this->db->from('bdm');
		$this->db->where('id', $id);
		$t = $this->db->get();
		return $t->row();
    }

	function valid_log($user,$encrypt_default_rand){
		$this->db->where('username', $user);
		$this->db->where('password', $encrypt_default_rand);
		$this->db->where('status', 'AEngOn73#43');
		$this->db->where('level', 'admjosslog21');
		return $this->db->get('user');
	}

	function cek_permision($id_use){
		$this->db->select('*');
		$this->db->from('tipe_akses_user');
		$this->db->where('id_user_log_default',$id_use);
		return $this->db->get();
	}	

	function updateLastlogin($id){
		$data = array(
			'last_login' => date('Y-m-d H:i:s')
			);
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}
	
	function c_user(){
		$this->db->select('id');
		$this->db->from('customer');
		$r = $this->db->get();
		return $r->result();
	}

	function c_all_toko_on(){
		$this->db->select('*');
		$this->db->from('toko');
		$this->db->where('latitude is NOT NULL');
		$this->db->where('longitude is NOT NULL');
		//$this->db->where('toko_aktif','on');
		$r = $this->db->get();
		return $r->result();	
	}

	function c_product_view(){
		$this->db->select('*');
		$this->db->from('produk_viewed');
		$r = $this->db->get();
		return $r->result();
	}

	function c_product_order(){
		// total uang pada total pesanan dihalaman utama tidak sama dengan laporan order karena pada c_product_order menghitung belanjaan + ongkir sedangkan pada laporan order menghitung harga artikel * qty
		//$ignore = array('ErNondyj3723815##629)&5+02');
		$this->db->select_sum('total_belanja');
		//$this->db->where_not_in('status', $ignore);
		$this->db->from('order_customer');
		$r = $this->db->get();
		return $r->row()->total_belanja;
	}

	function c_product_total_order(){
		$this->db->select('COUNt(id) as idp'); // hitung semua order
		//$this->db->where_not_in('status', $ignore);
		$this->db->from('order_customer');
		$r = $this->db->get();
		return $r->row()->idp;
	}

	function c_mail_send(){
		$this->db->select('id');
		$this->db->from('email');
		$r = $this->db->get();
		return $r->result();
	}

	function progress_order(){
		$this->db->select('buy_in, invoice, nama_lengkap, tanggal_order, status');
		$this->db->from('order_customer');
		$this->db->order_by('tanggal_order desc');
		$r = $this->db->get();
		return $r->result();	
	}

	function ios(){
		$this->db->select('COUNT(platform) as ios');
		$this->db->from('produk_viewed');
		$this->db->where('platform', 'iOS');
		$r = $this->db->get();
		return $r->row()->ios;		
	}

	function android(){
		$this->db->select('COUNT(platform) as android');
		$this->db->from('produk_viewed');
		$this->db->where('platform', 'android');
		$r = $this->db->get();
		return $r->row()->android;		
	}

	function win10(){
		$this->db->select('COUNT(platform) as win10');
		$this->db->from('produk_viewed');
		$this->db->where('platform', 'Windows 10');
		$r = $this->db->get();
		return $r->row()->win10;		
	}

	function other(){
		$pl = array('windows 10','ios','android');
		$this->db->select('COUNT(platform) as other');
		$this->db->from('produk_viewed');
		$this->db->where_not_in('platform', $pl);
		$r = $this->db->get();
		return $r->row()->other;		
	}

	function produk_laris(){ 
		//$ignore = array('');
		$this->db->select('SUM(a.qty) AS total, a.artikel,b.id_produk,b.nama_produk,b.artikel,b.gambar, c.no_order_cus, c.status');
		$this->db->from('order_product a');
		$this->db->join('produk b','b.artikel=a.artikel','left');
		$this->db->join('order_customer c','c.no_order_cus=a.no_order_pro','left');
		//$this->db->where_not_in('id_produk',$ignore);
		$this->db->order_by('total desc');
		$this->db->group_by('b.id_produk');
		$this->db->limit(10);
		$q = $this->db->get();
		return $q->result();		
	}

	function penjualan_by_month(){
		$this->db->select('*');
		$this->db->from('penjualan_by_closing');
		$this->db->order_by('idclosing asc');
		$r = $this->db->get();
		return $r->result();
	}
}
?> 