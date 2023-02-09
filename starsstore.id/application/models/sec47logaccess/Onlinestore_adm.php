<?php
class Onlinestore_adm extends CI_model{ 

	var $table = 'order_customer';  	
    var $column_order = array(null, 'a.nama_lengkap'); //set column field database for datatable orderable
    var $column_search = array('a.invoice','a.buy_in','a.total_belanja','a.sender','a.nama_lengkap','no_resi'); //set column field database for datatable searchable 
    var $order = array('a.tanggal_order' => 'desc'); // default order 

    private function _get_datatables_query()  
    {   
  
    	$ignore = array('','E-commerce');  
		$this->db->select('*');        
        $this->db->from('order_customer a');
        $this->db->join('bukti_pembayaran b','b.id_pesanan=a.invoice','left');
        $this->db->join('toko c','c.kode_edp=a.sender','left');
        $this->db->order_by('a.id desc');

		//add custom filter here
		$tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        $sortby = $this->input->post('sortby');
        if($sortby == "tgl_order"){
	        if($this->input->post('tgl1')) 
	        {      
	            $this->db->where('a.tanggal_order >=', $tgl1);
	            $this->db->where('a.tanggal_order <=', $tgl2);
	        } 
	     }else{
	     	if($this->input->post('tgl1')) 
	        {      
	            $this->db->where('a.tanggal_order_finish >=', $tgl1);
	            $this->db->where('a.tanggal_order_finish <=', $tgl2);
	        } 
	     }

		$stat = $this->input->post('status');
        if($this->input->post('status'))
        {	
        	$semua = array('2hd8jPl613!2_^5','*^56t38H53gbb^%$0-_-','Uywy%u3bShi)payDhal','ScUuses8625(62427^#&9531(73','batal');
        	if($stat == "all"){
            	$this->db->where_in('a.status', $semua); 
            }else{
            	$this->db->where('a.status', $stat);
            }
        } 
 
        if($this->input->post('buy_in'))
        {
        	$srtby = $this->input->post('buy_in');
        	if(!empty($srtby)){
        		$this->db->where('a.buy_in',$srtby);	
        	}
        }

        if($this->input->post('dibayar'))
        {	
        	$db = $this->input->post('dibayar');	
        	if(!empty($db)){
        		$this->db->where('a.dibayar',$db);
        	}
        }

        if($this->input->post('sender'))
        {
        	$sender = $this->input->post('sender');	
        	if(!empty($sender)){
        		$this->db->where('a.sender',$sender);
        		//$this->db->where("(a.sender LIKE '%".$sender."%')");
        	}
        }


		$this->db->where_not_in('a.buy_in', $ignore);
 
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

    function get_inv_inout($idinvoice){
		$this->db->select('*');
		$this->db->where('inv', $idinvoice);
		$get = $this->db->get('inout_inv');
		return $get->row_array();
	}

    function get_akun_except_ecom(){
		$ignore = array('E-commerce');  
		$this->db->select('*');
		$this->db->from('online_store_list');
		$this->db->where_not_in('val_market',$ignore);
		$r = $this->db->get();
		return $r->result(); 
	}

	function get_toko(){
		$this->db->select('*');
		$this->db->from('toko');
		$this->db->where('toko_aktif','on');
		$this->db->order_by('nama_toko','asc');
		$r = $this->db->get();
		return $r->result(); 	
	}

	function get_akun_all(){
		$this->db->select('*');
		$this->db->from('online_store');
		$r = $this->db->get();
		return $r->result(); 
	}

	function get_data_tokopengirim($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
        $this->db->select('*');
        $this->db->from('order_customer a');
        $this->db->join('toko b','b.nama_toko=a.sender','left');
        $this->db->where('a.invoice', $b);
        return $this->db->get();
	} 

	function get_marketplace(){ 
		$this->db->select('*');
		$this->db->from('online_store_list');
		$this->db->order_by('id','asc');
		$r = $this->db->get();
		return $r->result(); 	
	}
 
	function get_list_order(){
		$ignore = array('','E-commerce');  
		$this->db->select('*');
		$this->db->from('order_customer a');
		$this->db->where_not_in('a.buy_in',$ignore);
		$this->db->order_by('a.id desc');
		$r = $this->db->get();
		return $r->result();
	}

	function detail_order($inv){
		$ignore = array('');
		$this->db->select('*');
		$this->db->from('order_customer a');
		$this->db->join('order_product b','b.no_order_pro=a.no_order_cus','right');
		$this->db->join('order_expedisi c','c.no_order_ex=a.no_order_cus','right');
		$this->db->join('order_with_voucher d','d.no_order_vou=a.no_order_cus','right');
		$this->db->where_not_in('a.buy_in',$ignore);
		$this->db->order_by('a.id asc');
		$r = $this->db->get();
		return $r->result();
	}

	function checkingInv($id){
	 	$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
        $this->db->select('a.*,b.*,d.*,f.nama_toko,f.kode_edp');
        $this->db->from('order_customer a');
        $this->db->join('order_expedisi b', 'a.no_order_cus=b.no_order_ex', 'left');
        $this->db->join('order_with_voucher d', 'a.no_order_cus=d.no_order_vou', 'left');
        $this->db->join('toko f','f.kode_edp=a.sender','left');
        $this->db->where('a.no_order_cus', $b);
        $this->db->group_by('f.nama_toko');
        $q = $this->db->get();
        return $q->result();
    }

    function checkingInv2($id){
	 	$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
        $this->db->select('*');
        $this->db->from('order_customer a');
        $this->db->join('order_expedisi b', 'b.no_order_ex=a.no_order_cus', 'left');
        $this->db->join('order_with_voucher d', 'd.no_order_vou=a.no_order_cus', 'left');
        $this->db->where('a.invoice', $b);
        $this->db->group_by('d.no_order_vou');
        $q = $this->db->get();
        return $q->result();
    } 

    function checkingdataorder2($id){
    	$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
        $this->db->select('g.*,h.no_order_pro,h.artikel,h.ukuran,h.warna,h.qty,h.harga_fix,h.harga_before,i.nama_produk,i.gambar,j.art_id as artikel');
        $this->db->from('order_customer g');
        $this->db->join('order_product h', 'h.no_order_pro=g.no_order_cus', 'left');
        $this->db->join('produk i','i.artikel=h.artikel','left');
        $this->db->join('brgcp j','j.art_id=h.artikel','left'); // tambahan jika ada artikel diluar number of line e-commerce supaya artikel dapat muncul di invoice
        $this->db->where('g.invoice', $b);
        $q = $this->db->get();
        return $q->result();   
    }

    function checkingdataorder($id){
    	$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
        $this->db->select('g.*,h.no_order_pro,h.artikel,h.ukuran,h.warna,h.qty,h.harga_fix,h.harga_before,i.nama_produk,i.gambar,j.art_id as artikel');
        $this->db->from('order_customer g');
        $this->db->join('order_product h', 'h.no_order_pro=g.no_order_cus', 'left');
        $this->db->join('produk i','i.artikel=h.artikel','left');
        $this->db->join('brgcp j','j.art_id=h.artikel','left'); // tambahan jika ada artikel diluar number of line e-commerce supaya artikel dapat muncul di invoice
        $this->db->where('g.no_order_cus', $b);
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

    function selectInfbnk($idbnk){
        $this->db->select('*');
        $this->db->where('code_network', $idbnk);
        return $this->db->get('daftar_rekening_pusat'); 
    }

	function load_bank_data(){
        $this->db->select('*');
        $this->db->where('aktife_stat_bank', 'on');
        return $this->db->get('daftar_rekening_pusat');
    }

	function get_data_akun($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$this->db->select('*');
		$this->db->from('online_store');
		$this->db->where('id_akun', $b);
		$query = $this->db->get();
      	return $query->row_array();
	}
	
	function update_akun($data,$id){
		$data1 = array(
			'nama_akun' => $data['nama'],
			'email'		=> $data['email'],
			'password'	=> $data['pass2']
		);
		$this->db->where('id_akun', $id);
		$this->db->update('online_store', $data1);
	}

	function add($data){
		$data = array(
      		'nama_akun' 	=> $data['nama_akun'],
	      	'email'			=> $data['email'],
    		'password'		=> $data['password'],
    		);
    	$this->db->insert('online_store', $data);
	}

	function add_market($data, $id){
		$data = array(
      		'market' 		=> $data['marketplace'],
	      	'val_market'	=> strtolower(str_replace(' ','_', $data['marketplace'])),
    		'id_add'		=> $id,
    		'date_add'		=> date('Y-m-d H:i:s'),
    		);
    	$this->db->insert('online_store_list', $data);	
	}

	function remove_selected() { //untuk menhapus yang dipilih di menu pilihan hapus
		$action = $this->input->post('action');
		if ($action == "delete") {
			$delete = $this->input->post('msg');
			for ($i=0; $i < count($delete) ; $i++) { 
				$this->db->where('merk_id', $delete[$i]);
				$this->db->delete('merk');
			}
		}elseif($action == "all"){
			$this->db->query("DELETE FROM merk");
		}
	}

	function bayar($id){
		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);
		$data = array(
			'dibayar' => 'bayar',
		);
		$this->db->where('no_order_cus', $idp);
		$this->db->update('order_customer', $data);
	}

	function belum_bayar($id){
		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);
		$data = array(
			'dibayar' => '',
		);
		$this->db->where('no_order_cus', $idp);
		$this->db->update('order_customer', $data);
	}

	function hapus($id){
		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);
		$this->db->delete('order_customer', array('no_order_cus' => $idp));
		$this->db->delete('order_expedisi', array('no_order_ex' => $idp));
		$this->db->delete('order_product', array('no_order_pro' => $idp));
		$this->db->delete('order_with_voucher', array('no_order_vou' => $idp));
	} 

	function hapus_market($id){
		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);
		$this->db->delete('online_store_list', array('id' => $idp));
	}

	function detail($id){
		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);
		$this->db->select('a.*,b.*,c.*,f.nama_toko,f.kode_edp');
		$this->db->from('order_customer a');
		$this->db->join('order_expedisi b','b.no_order_ex=a.no_order_cus','left');
		$this->db->join('order_with_voucher c','c.no_order_vou=a.no_order_cus','left');
		$this->db->join('toko f','f.kode_edp=a.sender','left');
		$this->db->where('a.no_order_cus',$idp);
		$this->db->group_by('f.nama_toko');
		$r = $this->db->get();
		return $r->row_array();
	}

	function detail_produk($id){
		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);
		$this->db->select('*');
		$this->db->from('order_product');
		$this->db->where('no_order_pro',$idp);
		$r = $this->db->get();
		return $r->result();
	}

	function addmanualorder($id_user, $data){
		$old_date = $data['tgl_order'];
		$new_date = date("Y-m-d", strtotime($old_date));
	    // note
	    if($data['note'] == ""){
	     	$note = "-";
	    }else{
	     	$note = $data['note'];
	    }
	    // total order
	    $totalorderx = 0;
	    $countx = count($_POST['artikel']);
	    for($i=0; $i<$countx; $i++){
			$totalorder = array(
				'total' => $data['harga_fix'][$i]*$data['qty'][$i],
				);
	      	$totalorderx += $totalorder['total'];
		}

		// pengiriman
		if($data['tarif'] == "" || $data['tarif'] == 0){ 
	  		$tarifx = "0";
	  	}else if($data['tarif'] > 0){
	  		$tarifx =  $data['tarif'];
	  	}

	  	$tgl_selesai = date('y-m-d', strtotime($data['tgl_selesai']));
		$data_cs = array(
			'nama_lengkap' 		=> $data['nama'],
			'no_telp' 			=> $data['telp'],
			'email'				=> $data['email'],
			'buy_in'		  	=> $data['ecommerce'],
			'no_order_cus'		=> str_replace(' ', '', strtoupper($data['invoice'])),
			'invoice'			=> str_replace(' ', '', strtoupper($data['invoice'])),
			'catatan_pembelian' => $note,			
			'subtotal' 			=> $totalorderx,
			'total_belanja'		=> $totalorderx + $tarifx,
			//'total_berat'		=> $sum,
			'tanggal_waktu_order'=> $data['tgl_order'],
			'tanggal_order' 	=> $new_date,
			//'tanggal_jatuh_tempo'=> $data['exporder'],
			'jenis_pembayaran'	=> $data['metode_bayar'],
			//'bank_pembayaran'	=> $bnk,
			'status'			=> $data['status'],
			'dibayar'			=> $data['dibayar'],
			'tanggal_order_finish' => $tgl_selesai,
			'tanggal_waktu_order_finish' => $data['tgl_selesai'],
			'no_resi'			=> $data['resi'],
			'sender'			=> $data['sender'],
			'komisi_toko'		=> $data['komisi'],
			'ip'				=> $this->input->ip_address(),
			'browser'			=> $this->agent->browser(),
			'platform'			=> $this->agent->platform(),
		);
		$this->db->insert('order_customer', $data_cs);

		// produk
		$r = array_filter($_POST['size']);
		if(!empty($_POST['size'])){
			$count = count($r);
			$inv = str_replace(' ', '', strtoupper($data['invoice']));
		      for($i=0; $i<$count; $i++){

		      	$sz = $_POST['size'][$i];
				$sizexx = explode(',',$sz);
				$idsizex 	= $sizexx[0];
				$sizex 		= $sizexx[1];

				$data_produk = array(
					'no_order_pro' 		=> $inv,
					'artikel'			=> str_replace(' ', '', strtoupper($data['artikel'][$i])),
					'ukuran'	  		=> $sizex,
					'warna' 			=> $data['color'][$i],
					'qty'	  			=> $data['qty'][$i],
					'harga_fix'			=> $data['harga_fix'][$i],
					'harga_before'		=> $data['harga_before'][$i],
					//'vat_per_item'		=> $data['vat'][$i],
					//'berat'	  			=> '0.5',
				);
			$this->db->insert('order_product', $data_produk);
			  }
		}

	  	// pengiriman
	  	$invx = str_replace(' ', '', strtoupper($data['invoice']));
	  	$data_ex = array(
				'no_order_ex'		=> $invx,
				'alamat' 			=> $data['alamat'],
				'layanan'			=> strtoupper($data['layanan']),
				'tarif'				=> $data['tarif'],
			);
		$this->db->insert('order_expedisi', $data_ex);

		// voucher dan kupon
		if($data['vouandcou'] != ""){
		$invv = str_replace(' ', '', strtoupper($data['invoice']));
		$v = strtoupper($data['vouandcou']);
		  $data_v = array(
			'no_order_vou'		=> $invv,
			'voucher' 			=> $v,
			);
		$this->db->insert('order_with_voucher', $data_v);
		}
	}

	function updatemanualorder($id_user, $data, $invoice){
		// decrypt
	    //$a = base64_decode($this->input->post('payment'));
		//$b = $this->encrypt->decode($a);
		//if($b == "bt"){
		//	$a = base64_decode($this->input->post('bnk'));
		//	$bnk = $this->encrypt->decode($a);
		//}else if($b == "cc"){
		//	$bnk = "";
		//}
		// total berat
		//$sum = 0;
		//$berat_default = "0.5";
		//$count = count($_POST['artikel']);
	    //  for($i=0; $i<$count; $i++){
	    //  	$total = array(
		//		'total_berat' => $data['qty'][$i],
		//		);
	    //  	$sum += $total['total_berat'];
	    //  }

	    $old_date = $data['tgl_order'];
		$new_date = date("Y-m-d", strtotime($old_date));
	    // note
	    if($data['note'] == ""){
	     	$note = "-";
	    }else{
	     	$note = $data['note'];
	    }
	    // total order
	    $totalorderx = 0;
	    $countx = count($_POST['artikel']);
	    for($i=0; $i<$countx; $i++){
			$totalorder = array(
				'total' => $data['harga_fix'][$i]*$data['qty'][$i],//-($data['vat'][$i]+$data['b_market'][$i]),
				);
	      	$totalorderx += $totalorder['total'];
		}

		// pengiriman
		if($data['tarif'] == "" || $data['tarif'] == 0){
	  		$tarifx = "0";
	  	}else if($data['tarif'] > 0){
	  		$tarifx =  $data['tarif'];
	  	}

	  	$tgl_selesai = date('y-m-d', strtotime($data['tgl_selesai']));

		$data_cs = array(
			'nama_lengkap' 		=> $data['nama'],
			'no_telp' 			=> $data['telp'],
			'email'				=> $data['email'],
			'buy_in'		  	=> $data['ecommerce'],
			//'no_order_cus'		=> strtoupper($data['invoice']), // TIDAK PERLU DIEDIT KARENA DIJADIKAN ID EDIT, DELETE
			'invoice'			=> strtoupper($data['invoice']),
			'catatan_pembelian' => $note,			
			'subtotal' 			=> $totalorderx,
			'total_belanja'		=> $totalorderx + $tarifx,
			//'total_berat'		=> $sum,
			'tanggal_waktu_order'=> $data['tgl_order'],
			'tanggal_order' 	=> $new_date,
			//'tanggal_jatuh_tempo'=> $data['exporder'],
			'jenis_pembayaran'	=> $data['metode_bayar'],
			//'bank_pembayaran'	=> $bnk,
			'status'			=> $data['status'],
			'dibayar'			=> $data['dibayar'],
			'tanggal_order_finish' => $tgl_selesai,
			'tanggal_waktu_order_finish' => $data['tgl_selesai'], 
			'no_resi'			=> $data['resi'],
			'sender'			=> $data['sender'],
			'komisi_toko'		=> $data['komisi'],
			'ip'				=> $this->input->ip_address(),
			'browser'			=> $this->agent->browser(),
			'platform'			=> $this->agent->platform(),
		);
		if($data['ecommerce'] == "E-commerce"){
			$this->db->where('invoice', $invoice);
		}else{
			$this->db->where('no_order_cus', $invoice);
		}
		$this->db->update('order_customer', $data_cs);

		// produk
		$this->db->delete('order_product',array('no_order_pro' => $invoice));

		$r = array_filter($_POST['size']);
		if(!empty($_POST['size'])){
			$count = count($r);
			//$inv = strtoupper($data['invoice1']);
		    for($i=0; $i<$count; $i++){

			    //$sz = $_POST['size'][$i]; tidak dipakai
				//$sizexx = explode(',',$sz);
				//$idsizex 	= $sizexx[0];
				//$sizex 		= $sizexx[1];

				$data_produk = array(
					'no_order_pro' 		=> $invoice,
					'artikel'			=> $data['artikel'][$i],
					'ukuran'	  		=> $data['size'][$i],	
					'warna' 			=> $data['color'][$i],
					'qty'	  			=> $data['qty'][$i],
					'harga_fix'			=> $data['harga_fix'][$i],
					'harga_before'		=> $data['harga_before'][$i],
					//'vat_per_item'		=> $data['vat'][$i],
					//'biaya_marketplace' => $data['b_market'][$i],
					//'berat'	  			=> '0.5',
				);

			$this->db->insert('order_product', $data_produk);
			  }
		}

		  // pengiriman
		  $invx = strtoupper($data['invoice']);
		  $data_ex = array(
				//'no_order_ex'		=> $invx,
				'alamat' 			=> $data['alamat'],
				'layanan'			=> strtoupper($data['layanan']),
				'tarif'				=> $data['tarif'],
			);
		$this->db->where('no_order_ex', $invoice);
		$this->db->update('order_expedisi', $data_ex);

		// voucher dan kupon
		//if($data['vouandcou'] != ""){

			$invv = strtoupper($data['invoice']);
			$v = strtoupper($data['vouandcou']);
			  $data_v = array(
				//'no_order_vou'		=> $invoice,
				'voucher' 			=> $v,
				);
			$this->db->where('no_order_vou', $invoice);
			$this->db->update('order_with_voucher', $data_v);

		//}else if($data['vouandcou'] == ""){

		//	$invv = strtoupper($data['invoice']);
		//	$v = strtoupper($data['vouandcou']);
		//	  $data_v = array(
		//		'no_order_vou'		=> $invoice,
		//		'voucher' 			=> $v,
		//		);
			//$this->db->where('no_order_vou', $invoice);
		//	$this->db->insert('order_with_voucher', $data_v);

		//}
	}

	function get_id_from_art($dataPro){
		$this->db->select('id_produk');
		$this->db->from('produk');
		$this->db->where($dataPro);
		$r = $this->db->get();
		return $r->result();
	}

	function get_id_data($data_w){
        $this->db->select('*');
        $this->db->where($data_w);
        $this->db->where('stok > 0');
        $this->db->from('produk_get_color');
        $r = $this->db->get();
        return $r->result();
    }

    function kurangi_stok($data_stok_pro,$id_pr, $idsize){
        $data = array(
            'id_produk_optional' => $id_pr,
            'id_opsi_get_size' => $idsize,
            );
        $this->db->where($data);
        $this->db->where('stok > 0');
        $this->db->update('produk_get_color',$data_stok_pro);
    }

    function get_data_order($b){
        $a = base64_decode($b);
        $id = $this->encrypt->decode($a);
        $this->db->select('invoice, tokenlabel, labelpengiriman');
        $this->db->from('order_customer');
        $this->db->where('id', $id);
        $t = $this->db->get();
        return $t->row_array();
    }

    function get_store_for_comission_persender($tgl1, $tgl2, $status1, $status2, $market, $senderx){

    	$this->db->select('a.*,b.*,c.no_order_ex,c.tarif,c.ongkir_ditanggung,c.actual_tarif,d.nama_toko,d.kode_edp');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		$this->db->join('toko d','d.kode_edp=b.sender','left');

		$this->db->where('b.sender',$senderx);

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

		$this->db->where_in('b.buy_in', $market);

		$this->db->where_in('b.status', $status2);

		$this->db->where_in('b.dibayar',$status1);

		$this->db->order_by('b.buy_in asc');

		$r = $this->db->get();

		return $r->result();

	}

	function get_store_for_comission_tgl_order_persender($tgl1, $tgl2, $status1, $status2, $market, $senderx){

		$this->db->select('a.*,b.*,c.no_order_ex,c.tarif,c.ongkir_ditanggung,c.actual_tarif,d.nama_toko,d.kode_edp');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		$this->db->join('toko d','d.kode_edp=b.sender','left');

		$this->db->where('b.sender',$senderx);

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

		$this->db->where_in('b.buy_in', $market);

		$this->db->where_in('b.status',$status2);

		$this->db->where_in('b.dibayar',$status1);

		$this->db->order_by('b.buy_in asc');

		$r = $this->db->get();

		return $r->result();

	}

	function get_nama_toko($sender){
		$this->db->select('nama_toko');
		$this->db->from('toko');
		$this->db->where('kode_edp', $sender);
		$r = $this->db->get();
		return $r->row_array();
	}
}
?>