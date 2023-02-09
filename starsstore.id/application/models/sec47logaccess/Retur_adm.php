<?php
class Retur_adm extends CI_Model{ 
	 
	var $table = 'order_informasi_retur';
	var $column_order = array(null, 'a.id_retur_info'); //set column field database for datatable orderable
    var $column_search = array('a.id_retur_info','a.id_invoice_real','a.id_invoicepro','a.alasan','c.nama_lengkap','c.buy_in'); //set column field database for datatable searchable 
    var $order = array('a.date_filter' => 'desc'); // default order 

    private function _get_datatables_query() 
    {       	
		$this->db->select('*');        
        $this->db->from('order_informasi_retur a');
        $this->db->join('order_produk_retur b','b.id_retur_produk=a.id_retur_info','left');
        $this->db->join('order_customer c','c.invoice=a.id_invoice_real','left');
        $this->db->order_by('a.date_filter desc');

		//add custom filter here
		$tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        if($this->input->post('tgl1'))
        {      
            $this->db->where('c.date_filter >=', $tgl1);
            $this->db->where('c.date_filter <=', $tgl2);
        } 

        if($this->input->post('buy_in'))
        {
        	$srtby = $this->input->post('buy_in');
        	if(!empty($srtby)){
        		$this->db->where('c.buy_in',$srtby);	
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
        
        $this->db->group_by('a.id_retur_info');
        //if(isset($_POST['order'])) // here order processing
        //{
        //    $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        //} 
        //else if(isset($this->order))
        //{
        //    $order = $this->order;
        //    $this->db->order_by(key($order), $order[key($order)]);
        //}
        //$this->db->group_by('c.nama_toko');

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
 
	function get_list_retur(){ 
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('customer b','b.id=a.id_customer_retur','left');
		$this->db->join('order_customer c','c.no_order_cus=a.id_invoice_real','left');
		$this->db->join('solusi_retur d','d.id_solusi=a.solusi','left');
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_all($idx){ 
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('customer b','b.id=a.id_customer_retur','left');
		$this->db->join('order_customer c','c.no_order_cus=a.id_invoice_real','left');
		//$this->db->join('order_product d','d.no_order_pro=c.no_order_cus','left');
		$this->db->where('a.id_retur_info', $idx);
		$q = $this->db->get();
		return $q->row_array();
	}

	function get_produk_retur_detail($idx){ 
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('order_produk_retur b','b.id_retur_produk=a.id_retur_info','left');
		$this->db->where('a.id_retur_info', $idx);
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_retur($idx){
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('customer b','b.id=a.id_customer_retur','left');
		$this->db->join('order_customer c','c.no_order_cus=a.id_invoice_real','left');
		$this->db->join('solusi_retur e','e.id_solusi=a.solusi','left');
		$this->db->where('a.id_retur_info', $idx);
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_produk_retur($idx){
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('order_produk_retur b','b.id_retur_produk=a.id_retur_info','left');
		$this->db->where('a.id_retur_info', $idx);
		//$this->db->group_by('b.id_retur_produk');
		$q = $this->db->get();
		return $q->result();
	}

	function get_solusi(){
		$this->db->select('*');
		$this->db->from('solusi_retur');
		$q = $this->db->get();
		return $q->result_array();
	}

	function off($idx){
		$off_data = array(
			'aktif' => '',
			);
		$this->db->where('id', $idx);
		$off = $this->db->update($this->table, $off_data);
	}

	function hapus_data($idx){
		$this->db->where('id_retur_info', $idx);
		$off = $this->db->delete($this->table);
	}

	function hapus_produk_retur($idx){
		$this->db->where('id_retur_produk', $idx);
		$off = $this->db->delete('order_produk_retur');
	}

	function on($idx){
		$on_data = array(
			'aktif' => 'on',
			);
		$this->db->where('id', $idx);
		$off = $this->db->update($this->table, $on_data);
	}

	function add($id_user, $data){

		//if($data['solusi'] == "1"){
		//	$solusi = "JGErnoahs3721";
		//}else if($data['solusi'] == "2"){
		//	$solusi = "Kgh3YTsuccess";
		//}else if($data['solusi'] == "3"){
		//	$solusi = "Kgh3YTsuccess";
		//}else if($data['solusi'] == "4"){
		//	$solusi = "Kgh3YTsuccess";
		//}

		if($data['invoicepengganti'] != ""){
			$invoicepengganti = str_replace(' ', '', $data['invoicepengganti']);
		}else{
			$invoicepengganti = 0;
		}
		$data_retur = array(
			//'solusi' 		=> $data['solusi'],
			'id_retur_info'	=> $data['kode_retur'],
			'date_create'	=> $data['tglretur'],
			'date_filter'	=> date("Y-m-d", strtotime($data['tglretur'])),
			'id_invoice_real' => str_replace(' ', '', $data['invoiceretur']),
			'id_invoice_pengganti'	=> $invoicepengganti,
			'alasan'		=> $data['alasan'],
			'keterangan_solusi' => $data['keterangan'],
			'solusi'		=> $data['solusi'],
			'user_add'		=> $id_user,
			//'date_end'		=> date('Y-m-d H:i:s'),
		);
		$this->db->insert($this->table, $data_retur);	

		// produk retur 
        $xxx = array_filter($_POST['produk1']);
        if(!empty($_POST['produk1'])){
            $count = count($xxx);
            for($i=0; $i<$count; $i++){
                    $data_add = array(
                        'id_retur_produk'   => $data['kode_retur'],
                        'id_invoicepro'		=> $data['invoiceretur'],
                        'id_produk_from_order_produk' => str_replace(' ', '', strtoupper($data['produk1'][$i])),
                    );
                    $this->db->insert('order_produk_retur', $data_add);
            }
        }	

       	// produk pengganti retur 
        $xx = array_filter($_POST['produk2']);
        if(!empty($_POST['produk2'])){
            $countx = count($xx);
            for($ix=0; $ix<$countx; $ix++){
                    $data_addx = array(
                        'id_retur_produk'   => $data['kode_retur'],
                        'id_invoicepro'		=> $invoicepengganti,
                        'id_produk_from_order_produk' => str_replace(' ', '', strtoupper($data['produk2'][$ix])),
                    );
                    $this->db->insert('order_produk_retur', $data_addx);
            }
        }	
	}	

	function update_retur($id_user,$id_retur,$data){

		//if($data['solusi'] == "1"){
		//	$solusi = "JGErnoahs3721";
		//}else if($data['solusi'] == "2"){
		//	$solusi = "Kgh3YTsuccess";
		//}else if($data['solusi'] == "3"){
		//	$solusi = "Kgh3YTsuccess";
		//}else if($data['solusi'] == "4"){
		//	$solusi = "Kgh3YTsuccess";
		//}
		if($data['invoicepengganti'] != ""){
			$invoicepengganti = str_replace(' ', '', $data['invoicepengganti']);
		}else{
			$invoicepengganti = 0;
		}

		$data_retur = array(
			//'solusi' 		=> $data['solusi'],
			'id_retur_info'	=> $data['kode_retur'],
			'date_create'	=> $data['tglretur'],
			'date_filter'	=> date("Y-m-d", strtotime($data['tglretur'])),
			'id_invoice_real' => str_replace(' ', '', $data['invoiceretur']),
			'id_invoice_pengganti'	=> $invoicepengganti,
			'alasan'		=> $data['alasan'],
			'keterangan_solusi' => $data['keterangan'],
			'solusi'		=> $data['solusi'],
			'user_edit'		=> $id_user,
			//'date_end'		=> date('Y-m-d H:i:s'),
		);
		$this->db->where('id_retur_info',$id_retur);
		$this->db->update($this->table, $data_retur);	

		// hapus produk yang terkait dengan ID Retur
		$this->db->where('id_retur_produk', $id_retur);
		$this->db->delete('order_produk_retur');

		// produk retur 
        $xxx = array_filter($_POST['produk1']);
        if(!empty($_POST['produk1'])){
            $count = count($xxx);
            for($i=0; $i<$count; $i++){
                    $data_add = array(
                        'id_retur_produk'   => $data['kode_retur'],
                        'id_invoicepro'		=> $data['invoiceretur'],
                        'id_produk_from_order_produk' => str_replace(' ', '', strtoupper($data['produk1'][$i])),
                    );
					$this->db->insert('order_produk_retur', $data_add);	
            }
        }	

       	// produk pengganti retur 
        $xx = array_filter($_POST['produk2']);
        if(!empty($_POST['produk2'])){
            $countx = count($xx);
            for($ix=0; $ix<$countx; $ix++){
                    $data_addx = array(
                        'id_retur_produk'   => $data['kode_retur'],
                        'id_invoicepro'		=> $invoicepengganti,
                        'id_produk_from_order_produk' => str_replace(' ', '', strtoupper($data['produk2'][$ix])),
                    );
                    $this->db->insert('order_produk_retur', $data_addx);	
            }
        }		
	}	

	function remove_dipilih($cek) { //untuk menghapus yang dipilih di menu pilihan hapus
		$cek = array();
		foreach($cek as $cek_id){
			$query = $this->db->get_where('produk_image',array('id_produk'=>$cek_id));
			$data = $query->result_array();
    		foreach ($data as $resultnya) 
    		{
	        	unlink('assets/img/produk/'.$resultnya['gambar']);
    		}
		}
		$action = $this->input->post('action');
		if ($action == "delete") {
			$delete = $cek;

			print_r($delete);
			//for ($i=0; $i < count($delete) ; $i++) { 
				
			//	$query = $this->db->get_where('produk_image',array('id_produk'=>$delete[$i]));
			//	$data = $query->result_array();
    		//	foreach ($data as $resultnya) 
    		//	{
	        //		unlink('assets/img/produk/'.$resultnya['gambar']);
    		//	}
				//$this->db->delete('produk', array('id_produk' => $delete[$i]));
				//$this->db->delete('produk_image', array('id_produk' => $delete[$i]));
		}elseif($action == "all"){
			//$this->db->delete('produk');
			//$this->db->delete('produk_image');
		}
	}
}
?>