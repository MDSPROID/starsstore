<?php
class Laporan_pengiriman_adm extends CI_model{ 
 
	var $table = 'order_expedisi';  	
    var $column_order = array(null); //set column field database for datatable orderable
    var $column_search = array('a.buy_in','b.provinsi','b.kota','b.layanan','b.ongkir_ditanggung','a.invoice','a.sender','c.nama_toko'); //set column field database for datatable searchable 
    var $order = array('b.id' => 'desc'); // default order 

    private function _get_datatables_query()
    {     
 
    	$ignore = array('batal');  
		$this->db->select('a.*,b.*,c.nama_toko,c.kode_edp');         
		$this->db->from('order_customer a');
		$this->db->join('order_expedisi b', 'b.no_order_ex=a.no_order_cus','left');
		$this->db->join('toko c','c.kode_edp=a.sender','left');
		//$this->db->where('b.tanggal_order_finish > DATE_SUB(NOW(), INTERVAL 4 WEEK)');
		//$this->db->where_not_in('a.status', $ignore);
		$this->db->where_not_in('b.actual_tarif','');
		$this->db->order_by('a.id desc');

		// custom filter

       $market = $this->input->post('marketplace');
        if($this->input->post('marketplace')){
			if($market != "semua"){
				$this->db->where_in('a.buy_in', $market);  
			}else{
				// ALL //
			}
		}

		$stat = $this->input->post('status');
        if($this->input->post('status'))
        {    
        	if($stat == "semua"){
            	
            }else{
            	$this->db->where('a.status', $stat); 
            }
        }

        $dibayar = $this->input->post('dibayar');
        if($this->input->post('dibayar'))
        {    
        	if($dibayar == "semua"){
            	
            }else{
            	$this->db->where('a.dibayar', $dibayar); 
            }
        }

        $ditanggung = $this->input->post('ditanggung');
        if($this->input->post('ditanggung'))
        {    
        	if($ditanggung == "semua"){
            	
            }else{
            	$this->db->where('b.ongkir_ditanggung', $ditanggung); 
            }
        }

        if($this->input->post('sortby'))
        {	
        	$tgl1 = $this->input->post('tgl1');
		    $tgl2 = $this->input->post('tgl2');
        	if($tgl1 == "" || $tgl2 == ""){

        	}else{
	            $srtby = $this->input->post('sortby');
	            if($srtby == "tgl_order"){
			        $this->db->where('a.tanggal_order >=', $tgl1);
			        $this->db->where('a.tanggal_order <=', $tgl2);
	                $this->db->order_by('a.tanggal_order asc');
	            }else{
	            	$this->db->where('a.tanggal_order_finish >=', $tgl1);
			        $this->db->where('a.tanggal_order_finish <=', $tgl2);
	                $this->db->order_by('a.tanggal_order_finish asc');
	            }
	        }
        }
 
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
         
        //if(isset($_POST['order'])) // here order processing
        //{
        //    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        //} 
        //else if(isset($this->order))
        //{
        //    $order = $this->order;
        //    $this->db->order_by(key($order), $order[key($order)]);
        //}

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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_toko(){
    	$this->db->select('*');
		$this->db->from('toko');
		$this->db->where('toko_aktif','on');
		$this->db->order_by('nama_toko','asc');
		$r = $this->db->get(); 
		return $r->result(); 	
    }

	function get_order_all(){
		$ignore = array('batal');  
		$this->db->select('*');
		$this->db->from('order_expedisi a');
		$this->db->join('order_customer b','b.no_order_cus=a.no_order_ex','left');
		$this->db->join('order_product c','no_order_pro=a.no_order_ex','left');	
		//s$this->db->where('b.tanggal_order_finish > DATE_SUB(NOW(), INTERVAL 4 WEEK)');	
		$this->db->where_not_in('b.status', $ignore);
		$this->db->where_not_in('a.actual_tarif','');
		$this->db->order_by('b.id desc');
		$r = $this->db->get(); 
		return $r->result();
	}

	function get_order_all_yang_belum_diinput_tarifnya_doang(){
		$ignore = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73',);
		$this->db->select('*');
		$this->db->from('order_expedisi a');
		$this->db->join('order_customer b','b.no_order_cus=a.no_order_ex','left');
		$this->db->where('a.actual_tarif','');
		$this->db->where_in('b.status', $ignore);
		$this->db->order_by('b.id asc');
		$r = $this->db->get();  
		return $r->result();
	}

	function get_data_for_notif($inv){ 
		$this->db->select('*');
		$this->db->from('order_customer');
		$this->db->where('no_order_cus', $inv);
		$r = $this->db->get();
		return $r->row_array();
	}

	function get_data_for_edit($inv){
		$this->db->select('*');
		$this->db->from('order_expedisi a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_ex','left');
		$this->db->where('a.no_order_ex', $inv);
		$r = $this->db->get();
		return $r->row_array();
	}

	function get_data_for_range_by_tgl_order($tgl1, $tgl2, $status, $bayar, $market,$ditanggung){
		$this->db->select('a.*,b.*,c.kode_edp,c.nama_toko');
		$this->db->from('order_expedisi a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_ex','left');
		//$this->db->join('order_product c','no_order_pro=a.no_order_ex','left');
		$this->db->join('toko c','c.kode_edp=b.sender','left');
		$this->db->where('b.tanggal_order >= "'.$tgl1.'"');
		$this->db->where('b.tanggal_order <= "'.$tgl2.'"');
		$this->db->where_in('b.status',$status);
		$this->db->where_in('b.dibayar',$bayar);
		$this->db->where_in('b.buy_in',$market);
		$this->db->where_in('a.ongkir_ditanggung',$ditanggung);
		$this->db->order_by('b.tanggal_order asc');
		$r = $this->db->get();
		return $r->result();	
	} 

	function get_data_for_range_by_tgl_order_finish($tgl1, $tgl2, $status, $bayar, $market,$ditanggung){

		$this->db->select('a.*,b.*,c.kode_edp,c.nama_toko');
		$this->db->from('order_expedisi a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_ex','left');
		//$this->db->join('order_product c','no_order_pro=a.no_order_ex','left');
		$this->db->join('toko c','c.kode_edp=b.sender','left');
		$this->db->where('b.tanggal_order_finish >= "'.$tgl1.'"');
		$this->db->where('b.tanggal_order_finish <= "'.$tgl2.'"');
		$this->db->where_in('b.status',$status);
		$this->db->where_in('b.dibayar',$bayar);
		$this->db->where_in('b.buy_in',$market);
		$this->db->where_in('a.ongkir_ditanggung',$ditanggung);
		$this->db->order_by('b.tanggal_order_finish asc');
		$r = $this->db->get();
		return $r->result();	
	}

	function add($id_user,$inv,$data){

		$data_ex = array(
			'ongkir_ditanggung' => $data['dibayar'],//$data['tanggung_ongkir'],
			'actual_tarif'		=> $data['tarif'],
			'dibayar_oleh'		=> "",//$data['dibayar'],
			'tgl_input_actual'	=> date("Y-m-d"),//$data['tgl'],
			'bayar'				=> "",//$data['bayar'],
			'id_user_add'		=> $id_user,
		);
		//print_r($data_ex);	
		$this->db->where('no_order_ex',$inv);
		$this->db->update('order_expedisi', $data_ex);		
	}	

	function update($id_user,$inv, $data){
		$data_ex = array(
			'ongkir_ditanggung' => $data['dibayar'],//$data['tanggung_ongkir'],
			'actual_tarif'		=> $data['tarif'],
			'dibayar_oleh'		=> "",//$data['dibayar'],
			'tgl_input_actual'	=> $data['tgl'],
			'bayar'				=> $data['bayar'],
			'id_user_add'		=> $id_user,
		);
		//print_r($data_ex);	
		$this->db->where('no_order_ex',$inv);
		$this->db->update('order_expedisi', $data_ex);		
	}

	function filter_laporan_branded($tgl1, $tgl2, $divisi, $jenis, $status){
		$this->db->select('a.*, b.*, c.artikel, c.divisi as div, c.jenis as jenn, c.odv as odvret, c.retail as ret');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro');
		$this->db->join('master_barang c', 'c.artikel=a.artikel');
		$this->db->where('b.tanggal_order >=', $tgl1);
		$this->db->where('b.tanggal_order <=', $tgl2);
		$this->db->where('b.status', $status);
		$this->db->where('c.divisi', $divisi);
		$this->db->where('c.jenis', '3');
		$r = $this->db->get();
		return $r->result();
	}

	function filter_laporan_own($tgl1, $tgl2, $divisi, $jenis, $status){
		$this->db->select('a.*, b.*, c.artikel, c.divisi as div, c.jenis as jenn, c.odv as odvret, c.retail as ret');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro');
		$this->db->join('master_barang c', 'c.artikel=a.artikel');
		$this->db->where('b.tanggal_order >=', $tgl1);
		$this->db->where('b.tanggal_order <=', $tgl2);
		$this->db->where('b.status', $status);
		$this->db->where('c.divisi', $divisi);
		$this->db->where('c.jenis', '1');
		$r = $this->db->get();
		return $r->result();
	}

	function filter_laporan_konsi($tgl1, $tgl2, $divisi, $jenis, $status){
		$this->db->select('a.*, b.*, c.artikel, c.divisi as div, c.jenis as jenn, c.odv as odvret, c.retail as ret');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro');
		$this->db->join('master_barang c', 'c.artikel=a.artikel');
		$this->db->where('b.tanggal_order >=', $tgl1);
		$this->db->where('b.tanggal_order <=', $tgl2);
		$this->db->where('b.status', $status);
		$this->db->where('c.divisi', $divisi);
		$this->db->where('c.jenis', '2');
		$r = $this->db->get();
		return $r->result();
	}

	function filter_laporan_dropship($tgl1, $tgl2, $divisi, $jenis, $status){
		$this->db->select('a.*, b.*, c.artikel, c.divisi as div, c.jenis as jenn, c.odv as odvret, c.retail as ret');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro');
		$this->db->join('master_barang c', 'c.artikel=a.artikel');
		$this->db->where('b.tanggal_order >=', $tgl1);
		$this->db->where('b.tanggal_order <=', $tgl2);
		$this->db->where('b.status', $status);
		$this->db->where('c.divisi', $divisi);
		$this->db->where('c.jenis', '4');
		$r = $this->db->get();
		return $r->result();
	}

	function bayar($idp){
		$data = array(
			'bayar' => 'sudah',
		);
		$this->db->where('no_order_ex', $idp);
		$this->db->update('order_expedisi', $data);
	}

	function belum_bayar($idp){
		$data = array(
			'bayar' => '',
		);
		$this->db->where('no_order_ex', $idp);
		$this->db->update('order_expedisi', $data);
	}

	function get_marketplace(){ 
		$this->db->select('*');
		$this->db->from('online_store_list');
		$this->db->order_by('id','asc');
		$r = $this->db->get();
		return $r->result(); 	
	}

	function get_invoice($market,$tgl1,$tgl2){
		$this->db->select('*');
		$this->db->from('order_customer a');
		$this->db->join('order_expedisi b','b.no_order_ex=a.no_order_cus','left');
		$this->db->where('a.buy_in',$market);
		$this->db->where('a.tanggal_order >=',$tgl1);
		$this->db->where('a.tanggal_order <=',$tgl2);
		$r = $this->db->get();
		return $r->result(); 		
	}

	function get_price_label($inv1){
		$this->db->select('*');
		$this->db->from('order_expedisi a');
		$this->db->where('a.no_order_ex',$inv1);
		$r = $this->db->get();
		return $r->row_array(); 			
	}
}
?>