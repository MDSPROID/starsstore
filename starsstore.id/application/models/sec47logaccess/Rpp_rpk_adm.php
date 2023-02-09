<?php

class Rpp_rpk_adm extends CI_Model{ 

	var $table = 'order_customer';  	
    var $column_order = array(null, 'a.nama_lengkap'); //set column field database for datatable orderable
    var $column_search = array('a.invoice','a.buy_in','a.sender'); //set column field database for datatable searchable 
    var $order = array('a.tanggal_order' => 'desc'); // default order 

    private function _get_datatables_query_biaya()  
    {   
  
		$this->db->select('*');        
        $this->db->from('order_customer a');
        $this->db->join('order_biaya b','b.no_order_biaya=a.no_order_cus','left');
        $this->db->order_by('a.tanggal_order desc');
 
		//add custom filter here
		$tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        if($this->input->post('tgl1'))
        {      
            $this->db->where('a.tanggal_order >=', $tgl1);
            $this->db->where('a.tanggal_order <=', $tgl2);
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

        if($this->input->post('marketplace'))
        {
        	$srtby = $this->input->post('marketplace');
        	if($srtby == "semua"){
        		
        	}else{
        		$this->db->where('a.buy_in',$srtby);	
        	}
        }

        if($this->input->post('dibayar'))
        {	
        	$db = $this->input->post('dibayar');	
        	if($db == "semua"){
        		
        	}else{
        		$this->db->where('a.dibayar',$db);
        	}
        }

 


		//$this->db->where_not_in('b.no_order_biaya', '');
 
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
 
    function get_datatables_biaya()
    {
        $this->_get_datatables_query_biaya();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_biaya()
    {
        $this->_get_datatables_query_biaya();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_biaya()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

	function get_list_rpp(){  
 
		$this->db->select('*'); 

		$this->db->from('rpp_title a');

		$this->db->join('penjualan_by_closing b','b.id_rpp_closing=a.id_rpp','left');

		$this->db->order_by('a.tgl_dibuat desc'); 

		$q = $this->db->get(); 
 
		return $q->result();

	} 



	function insert_data_closing($data_closing){

		$this->db->insert('penjualan_by_closing', $data_closing);

	} 



	function set_tanggal_closing(){

		$this->db->select('konten'); 

		$this->db->from('setting');

		$this->db->where('nama','tgl_closing');

		$q = $this->db->get(); 

		return $q->row_array();

	}



	function get_laporan_by_tgl($tgl1, $tgl2, $kodeEdptoko){

		$this->db->select('*');

		$this->db->from('dmk');

		$this->db->where('tanggal >=', $tgl1);
		$this->db->where('tanggal <=', $tgl2);
		$this->db->where('kode_edp', $kodeEdptoko);

		//$this->db->where('market', $market);

		$r = $this->db->get();

		return $r->result();

	}



	function get_list_inv($idinvoice){

		$this->db->select('*');

		$this->db->where('id_inout', $idinvoice);

		$get = $this->db->get('inout_inv');

		return $get->result();

	}



	function get_marketplace(){ 

		$this->db->select('*');

		$this->db->from('online_store_list');

		$this->db->order_by('id','asc');

		$r = $this->db->get();

		return $r->result(); 	

	}



	function cek_penjualan_fix1($pr){

		$this->db->select('*'); 

		$this->db->from('penjualan_fix a');

		$this->db->where('periode',$pr);

		return $this->db->get(); 

	}



	function cek_penjualan_fix($periode){

		$this->db->select('*'); 

		$this->db->from('penjualan_fix a');

		$this->db->where('periode',$periode);

		$q = $this->db->get(); 

		return $q->row_array();

	}



	function list_closing(){

		$this->db->select('*'); 

		$this->db->from('penjualan_by_closing');

		$this->db->order_by('idclosing desc'); 

		$q = $this->db->get(); 

		return $q->result();	

	}



	function cek_closing_biaya($bulancls){ 

		$this->db->select('*'); 

		$this->db->from('penjualan_by_closing a');

		$this->db->join('rpp_isi b', 'b.id_rpp_default=a.id_rpp_closing','left');

		$this->db->where('a.bulan', $bulancls);	

		$this->db->where('b.rincian', 'total_biaya_rutin_dan_non_rutin');

		return $this->db->get();

	}



	function cek_closing_transfer($bulancls){ 

		$this->db->select('*'); 

		$this->db->from('penjualan_by_closing a');

		$this->db->join('rpp_isi b', 'b.id_rpp_default=a.id_rpp_closing','left');

		$this->db->where('a.bulan', $bulancls);	

		$this->db->where('b.rincian', 'total_setoran_bank');

		return $this->db->get();

	}



	function cek_penjualan_fix_ambil_rupiah(){

		$this->db->select('*');   

		$this->db->from('penjualan_fix');

		$this->db->order_by('id_penjualan_fix desc');

		$this->db->limit(1);

		$q = $this->db->get(); 

		return $q->row_array();	

	}

 

	function get_result_bulan_closing(){

		$this->db->select('*'); 

		$this->db->from('penjualan_by_closing a');

		$this->db->order_by('a.idclosing desc'); 

		$q = $this->db->get(); 

		return $q->result();

	}



	function group_store_komisi($tgl1, $tgl2, $status1, $status2, $market){



		$this->db->select('sender');

		$this->db->from('order_product a'); 

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

		$this->db->where_in('b.status', $status2);

		$this->db->where_in('b.dibayar', $status1);

		$this->db->where_in('b.buy_in', $market);



		$this->db->group_by('b.sender');

		$x = $this->db->get();

		return $x->result();	

	}



	function stok_penjualan_bulan_lalu1($tgl1, $tgl2, $market, $status1, $status2){ // UNTUK RPP RPK MANUAL

		$this->db->select('*');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		//$this->db->where('b.tanggal_order BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where_in('b.status', $status2);

		$this->db->where_in('b.dibayar', $status1);

		$this->db->where_in('b.buy_in', $market);

		//$this->db->group_by('a.id_produk');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function stok_penjualan_bulan_lalu2($tgl1, $tgl2, $market){ // UNTUK RPP RPK MANUAL

		$this->db->select('*');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		//$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where('b.status', 'ScUuses8625(62427^#&9531(73');

		$this->db->where('b.dibayar','bayar');

		$this->db->where_in('b.buy_in', $market);

		//$this->db->group_by('a.id_produk');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function stok_penjualan_by_tgl_order($tgl1, $tgl2, $status1, $status2, $market){ // UNTUK RPP RPK MANUAL

		$this->db->select('a.*,b.*,c.artikel,c.nama_produk,d.milik as divisi, e.merk, f.retprc');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');
		$this->db->join('produk c','c.artikel=a.artikel','left');
		$this->db->join('produk_milik d','d.id_milik=c.id_kategori_divisi','left');
		$this->db->join('merk e','e.merk_id=c.merk','left');
		$this->db->join('brgcp f','f.art_id=a.artikel');
		//$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where_in('b.status', $status2);

		$this->db->where_in('b.dibayar',$status1);

		$this->db->where_in('b.buy_in', $market);

		//$this->db->group_by('a.id_produk');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function stok_penjualan_by_tgl_selesai_order($tgl1, $tgl2, $status1, $status2, $market){ // UNTUK RPP RPK MANUAL

		$this->db->select('a.*,b.*,c.nama_produk,d.merk,e.nama_toko, f.retprc');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		// join tambahan //

		$this->db->join('produk c','c.artikel=a.artikel','left');

		$this->db->join('merk d','d.merk_id=c.merk','left');

		$this->db->join('toko e','e.kode_edp=b.sender','left');

		$this->db->join('brgcp f','f.art_id=a.artikel');

		// end join tambahan //

		//$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where_in('b.status', $status2);

		$this->db->where_in('b.dibayar',$status1);

		$this->db->where_in('b.buy_in', $market);

		//$this->db->group_by('a.id_produk');

		$this->db->order_by('b.tanggal_order_finish asc');

		$r = $this->db->get();

		return $r->result();

	}



	function stok_penjualan_bulan_lalu($tgl1, $tgl2, $market){ // UNTUK RPP RPK MANUAL

		$this->db->select('*');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		//$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where('b.status', 'ScUuses8625(62427^#&9531(73');

		$this->db->where('b.dibayar','bayar');

		$this->db->where_in('b.buy_in', $market);

		//$this->db->group_by('a.id_produk');

		$r = $this->db->get();

		return $r->result();

	}



	function stok_penjualan_bulan_lalu_by_otomatis($tgl1, $tgl2){ // UNTUK RPP RPK OTOMATIS

		$this->db->select('SUM(a.qty) AS total_psg_penj, a.harga_fix, SUM(a.qty * a.harga_fix) total_rupiah_penj, b.tanggal_order');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		//$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where('b.status', 'ScUuses8625(62427^#&9531(73');

		$this->db->where('b.dibayar','bayar');

		$this->db->group_by('b.tanggal_order');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function discount($tgl1, $tgl2){

		$this->db->select('SUM(a.harga_before - a.harga_fix) total_discount, b.tanggal_order');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		//$this->db->where('b.tanggal_order BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where('b.status', 'ScUuses8625(62427^#&9531(73');

		$this->db->where('b.dibayar','bayar');

		$this->db->group_by('b.tanggal_order');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function stok_bln_lalu(){

		$this->db->select('*');

		$this->db->from('stok_perbulan');

		$this->db->limit(1);

		$this->db->order_by('id',"DESC");

		$r =$this->db->get();

		return $r->result();

	}



	function barang_masuk_keluar($tgl1, $tgl2, $market){

		$this->db->select('*');

		$this->db->from('inout');

		//$this->db->where('tanggal BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('tanggal >=', $tgl1);

		$this->db->where('tanggal <=', $tgl2);

		//$this->db->where_in('market', $market);

		$r = $this->db->get();

		return $r->result();

	}



	function list_pendingan(){

		$ignore2 = array('bayar');

		$ignore = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73',);

		//COUNT(b.invoice) as inv, SUM(a.qty) as qt

		$this->db->select('*');

		$this->db->from('order_customer a');

		$this->db->join('order_product b', 'b.no_order_pro=a.no_order_cus','left');

		//$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		//$this->db->where('b.tanggal_order >=', $tgl1);

		//$this->db->where('b.tanggal_order <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where_in('a.status', $ignore);

		$this->db->where_not_in('a.dibayar',$ignore2);

		//$this->db->where_in('b.buy_in', $market);

		//$this->db->group_by('a.id_produk');

		$this->db->order_by('a.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function pendingan(){

		$ignore2 = array('bayar');

		$ignore = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73');

		//COUNT(b.invoice) as inv, SUM(a.qty) as qt

		$this->db->select('b.invoice, COUNT(b.invoice) as inv, SUM(a.qty) as qt');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		//$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		//$this->db->where('b.tanggal_order >=', $tgl1);

		//$this->db->where('b.tanggal_order <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where_in('b.status', $ignore);

		$this->db->where_not_in('b.dibayar',$ignore2);

		//$this->db->where_in('b.buy_in', $market);

		//$this->db->group_by('a.id_produk');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function penjualan_dibulan_yang_sama($tgl1, $tgl2, $market){

		$ignore = array('ScUuses8625(62427^#&9531(73');

		$this->db->select('*');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		////$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

		////MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where('b.status', 'ScUuses8625(62427^#&9531(73');

		$this->db->where('b.dibayar','bayar');

		$this->db->where_in('b.buy_in', $market);

		////$this->db->group_by('a.id_produk');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function penjualan_pending_bulan_lalu($market){

		$this->db->select('*');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->where("tanggal_order_finish BETWEEN DATE_SUB(NOW(), INTERVAL 6 MONTH) AND NOW()");

		$this->db->where('b.status', 'ScUuses8625(62427^#&9531(73');

		$this->db->where('b.dibayar','bayar');

		$this->db->where_in('b.buy_in', $market);

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function pendingan_dibulan_yang_sama($tgl1, $tgl2, $market){

		$ignore2 = array('bayar');

		$ignore3 = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73');

		$this->db->select('*');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

		$this->db->where_in('b.buy_in', $market);

		$this->db->where_not_in('b.dibayar',$ignore2);

		$this->db->where_in('b.status',$ignore3);

		////$this->db->group_by('a.id_produk');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function pendingan_dibulan_lalu_maks_1_tahun_cek($tgl1, $tgl2, $market){

		$ignore2 = array('bayar');

		$ignore3 = array('ScUuses8625(62427^#&9531(73','batal'); //'2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 

		$this->db->select('a.*,b.*,c.nama_produk,d.merk,e.nama_toko,f.retprc,g.milik as divisi');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		// join tambahan //

		$this->db->join('produk c','c.artikel=a.artikel','left');

		$this->db->join('merk d','d.merk_id=c.merk','left');

		$this->db->join('toko e','e.kode_edp=b.sender','left');

		$this->db->join('brgcp f','f.art_id=a.artikel','left');

		$this->db->join('produk_milik g','g.id_milik=c.id_kategori_divisi','left');


		// end join tambahan // 

		$this->db->where("b.tanggal_order BETWEEN DATE_SUB(NOW(), INTERVAL 12 MONTH) AND NOW()");

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

		$this->db->where_in('b.buy_in', $market);

		$this->db->where_not_in('b.dibayar',$ignore2);

		$this->db->where_not_in('b.status',$ignore3);

		////$this->db->group_by('a.id_produk');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function pendingan_bulan_ini($tgl1, $tgl2, $market){

		$ignore = array('ScUuses8625(62427^#&9531(73');

		$ignore2 = array('bayar');

		$this->db->select('*');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		//$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		//$this->db->where_not_in('b.status', $ignore);

		//$this->db->where_not_in('b.dibayar',$ignore2);

		$this->db->where_in('b.buy_in', $market);

		//$this->db->group_by('a.id_produk');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();



		//$ignore = array('ScUuses8625(62427^#&9531(73');

		//$this->db->select('*');

		//$this->db->from('order_customer b');

		////$this->db->join(' b', 'b.no_order_cus=a.no_order_pro','left');

		////$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		//$this->db->where('b.tanggal_order >=', $tgl1);

		//$this->db->where('b.tanggal_order <=', $tgl2);

		////MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		////$this->db->where_not_in('b.status', $ignore);

		////$this->db->where('b.dibayar','bayar');

		//$this->db->where_in('b.buy_in', $market);

		////$this->db->group_by('a.id_produk');

		//$this->db->order_by('b.tanggal_order asc');

		//$r = $this->db->get();

		//return $r->result();

	}



	function biaya_marketplace($tgl1, $tgl2){

		$this->db->select('*');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		//$this->db->where('b.tanggal_order_finish BETWEEN "'.$tgl1.'" AND "'.$tgl2.'"');

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

//		MONTH(tanggal_order) = MONTH(DATE_ADD(Now(), INTERVAL -1 MONTH))

		$this->db->where('b.status', 'ScUuses8625(62427^#&9531(73');

		$this->db->where('b.dibayar','bayar');

		$this->db->group_by('b.tanggal_order');

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}



	function get_pesanan_ontime($idrpp){

		$this->db->select('*');

		$this->db->from('pesanan_ontime a');

		$this->db->join('order_customer b','b.invoice=a.inv_ontime','left');

		$this->db->where('a.id_rpp',$idrpp);

		$r = $this->db->get();

		return $r->result();

	}



	function get_pesanan_pndblnlalu($idrpp){

		$this->db->select('*');

		$this->db->from('pesanan_pending_bln_lalu a');

		$this->db->join('order_customer b','b.invoice=a.inv_pending_bln_lalu','left');

		$this->db->where('a.id_rpp',$idrpp);

		$r = $this->db->get();

		return $r->result();	

	}



	function get_pesanan_pndblnini($idrpp){

		$this->db->select('*');

		$this->db->from('pesanan_pending_bln_ini a');

		$this->db->join('order_customer b','b.invoice=a.inv_pending_bln_ini','left');

		$this->db->where('a.id_rpp',$idrpp);

		$r = $this->db->get();

		return $r->result();	

	}

 

	function add($id_user, $last_insert_id, $data, $tgl1, $tgl2){

		//$data_rpp = array(

		//	'jenis_market'	=> $data['market'],

		//	'tanggal' 		=> $data['tgl_tarik'], 

		//	'dibuat' 		=> $id_user,

		//	'tgl_dibuat'	=> date('y-m-d H:i:s'),

		//);

		//$this->db->insert('rpp_title', $data_rpp);



		//$last_insert_id = $this->db->insert_id();



// DATA RPP PER FORM

		$spbl = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'			=> 'sisa_persediaan_bulan_lalu',

			'pairs'				=> $data['sisa_persediaan_bulan_lalu'],

			'turn_over'			=> $data['turn_over_sisa_persediaan_bulan_lalu'],

		);

		$this->db->insert('rpp_isi', $spbl);



		$trm = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'			=> 'total_psg_masuk',

			'pairs'				=> $data['total_psg_masuk'],

			'turn_over'			=> $data['total_rupiah_masuk'],

		);

		$this->db->insert('rpp_isi', $trm);



		$bsl_dsl_dsk = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'			=> 'balance_selisih_lebih',

			'pairs'				=> $data['balance_selisih_lebih'],

			'turn_over'			=> $data['turnover_balance_selisih_lebih'],

		);

		$this->db->insert('rpp_isi', $bsl_dsl_dsk);



// JUMLAH PAIRS DAN TURN OVER SEBELAH KIRI



		$jml_pairs_turn_kiri = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'			=> 'jumlah_pairs_dan_turn_over_kiri',

			'pairs'				=> $data['sisa_persediaan_bulan_lalu'] + $data['total_psg_masuk'] + $data['balance_selisih_lebih'],

			'turn_over'			=> $data['turn_over_sisa_persediaan_bulan_lalu'] + $data['total_rupiah_masuk'] + $data['turnover_balance_selisih_lebih'],

		);

		$this->db->insert('rpp_isi', $jml_pairs_turn_kiri);



		$pssbi = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'			=> 'penjualan_psg_bulan_ini',

			'pairs'				=> $data['penjualan_psg_bulan_ini'],

			'turn_over'			=> $data['penjualan_rupiah_bulan_ini'],

		);

		$this->db->insert('rpp_isi', $pssbi);



		$tpk = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'			=> 'total_psg_keluar',

			'pairs'				=> $data['total_psg_keluar'],

			'turn_over'			=> $data['total_rupiah_keluar'],

		);

		$this->db->insert('rpp_isi', $tpk);



		$bsk = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'			=> 'balance_selisih_kurang',

			'pairs'				=> $data['balance_selisih_kurang'],

			'turn_over'			=> $data['turnover_balance_selisih_kurang'],

		);

		$this->db->insert('rpp_isi', $bsk);



		// DIGANTI DI KOLOM ONGKOS DAN ADMINISTRASI (RPK) // aktfikan kembali



		$dscnt = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'			=> 'spesial_diskon',

			'pairs'				=> "",

			'turn_over'			=> $data['spesial_diskon'],

		);

		$this->db->insert('rpp_isi', $dscnt);



// SISA PERSEDIAAN BULAN INI



		$spbi = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'			=> 'sisa_persediaan_bulan_ini',

			'pairs'				=> $data['sisa_persediaan_bulan_lalu'] + $data['total_psg_masuk'] + $data['balance_selisih_lebih'] - $data['penjualan_psg_bulan_ini'] - $data['total_psg_keluar'] - $data['balance_selisih_kurang'],



			'turn_over'			=> $data['turn_over_sisa_persediaan_bulan_lalu'] + $data['total_rupiah_masuk'] + $data['turnover_balance_selisih_lebih'] - $data['penjualan_rupiah_bulan_ini'] - $data['total_rupiah_keluar'] - $data['turnover_balance_selisih_kurang'] - $data['spesial_diskon'],

		);

		$this->db->insert('rpp_isi', $spbi);	



// INPUT KE TABLE STOK_PERBULAN

		$data_stok_perbulan = array(

			'id_rpp'	=> $last_insert_id,

			'tanggal'	=> date('Y-m-d'),

			'stok'		=> $data['sisa_persediaan_bulan_lalu'] + $data['total_psg_masuk'] + $data['balance_selisih_lebih'] - $data['penjualan_psg_bulan_ini'] - $data['total_psg_keluar'] - $data['balance_selisih_kurang'],

			'rp_stok'	=> $data['turn_over_sisa_persediaan_bulan_lalu'] + $data['total_rupiah_masuk'] + $data['turnover_balance_selisih_lebih'] - $data['penjualan_rupiah_bulan_ini'] - $data['total_rupiah_keluar'] - $data['turnover_balance_selisih_kurang'] - $data['spesial_diskon'],

		);	

		$this->db->insert('stok_perbulan', $data_stok_perbulan);



// JUMLAH PAIRS DAN TURN OVER SEBELAH KANAN

		$spbix = $data['sisa_persediaan_bulan_lalu'] + $data['total_psg_masuk'] + $data['balance_selisih_lebih'] - $data['penjualan_psg_bulan_ini'] - $data['total_psg_keluar'] - $data['balance_selisih_kurang'];



		$spbiturn_over = $data['turn_over_sisa_persediaan_bulan_lalu'] + $data['total_rupiah_masuk'] + $data['turnover_balance_selisih_lebih'] - $data['penjualan_rupiah_bulan_ini'] - $data['total_rupiah_keluar'] - $data['turnover_balance_selisih_kurang'];



		$jml_pairs_turn_kanan = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'			=> 'jumlah_pairs_dan_turn_over_kanan',

			'pairs'				=> $data['penjualan_psg_bulan_ini'] + $data['total_psg_keluar'] + $data['balance_selisih_kurang'] + $spbix,

			'turn_over'			=> $data['penjualan_rupiah_bulan_ini'] + $data['total_rupiah_keluar'] + $data['turnover_balance_selisih_kurang']  + $spbiturn_over, // + $data['spesial_diskon']

		);

		$this->db->insert('rpp_isi', $jml_pairs_turn_kanan);



// DATA RPK PER FORM (KIRI)

		$total_rupiah_penjualan_bulan_ini = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'total_rupiah_penjualan_bulan_ini',

			'pairs'				=> '',

			'turn_over'			=> $data['total_rupiah'],

		);

		$this->db->insert('rpp_isi', $total_rupiah_penjualan_bulan_ini);



		$selisih_kurang_dsl_dsk = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'selisih_kurang_dsl_dsk',

			'pairs'				=> '',

			'turn_over'			=> $data['selisih_kurang_dsl_dsk'],

		);

		$this->db->insert('rpp_isi', $selisih_kurang_dsl_dsk);



		$selisih_kurang_penjualan_bulan_lalu = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'selisih_kurang_penjualan_bulan_lalu',

			'pairs'				=> '',

			'turn_over'			=> $data['selisih_kurang_penjualan_bulan_lalu'],

		);

		$this->db->insert('rpp_isi', $selisih_kurang_penjualan_bulan_lalu);



// ADDING FORM KIRI

		if($data['add_turn_kiri'] > 0){

			$ad_turn_kiri = $data['add_turn_kiri'];

		}else{

			$ad_turn_kiri = '';

		}

		$add_turn_kiri = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'add_turn_kiri',

			'pairs'				=> '',

			'turn_over'			=> $ad_turn_kiri,

		);

		$this->db->insert('rpp_isi', $add_turn_kiri);



// TOTAL TURN OVER RPK KIRI



		$total_turn_over_rpk_kiri = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'total_turn_over_rpk_kiri',

			'pairs'				=> '',

			'turn_over'			=> $data['total_rupiah'] + $data['selisih_kurang_dsl_dsk'] + $data['selisih_kurang_penjualan_bulan_lalu'] + $ad_turn_kiri,

		);

		$this->db->insert('rpp_isi', $total_turn_over_rpk_kiri);

// DATA RPK PER FORM (KANAN)

		$selisih_lebih_penjualan_bulan_lalu = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'selisih_lebih_penjualan_bulan_lalu',

			'pairs'				=> '',

			'turn_over'			=> $data['selisih_lebih_penjualan_bulan_lalu'],

		);

		$this->db->insert('rpp_isi', $selisih_lebih_penjualan_bulan_lalu);



		$biaya_promosi = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'biaya_promosi',

			'pairs'				=> '',

			'turn_over'			=> $data['biaya_promosi'],

		);

		$this->db->insert('rpp_isi', $biaya_promosi);



		$biaya_internet = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'biaya_internet',

			'pairs'				=> '',

			'turn_over'			=> $data['biaya_internet'],

		);

		$this->db->insert('rpp_isi', $biaya_internet);



		$biaya_pengiriman_pesanan = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'biaya_pengiriman_pesanan',

			'pairs'				=> '',

			'turn_over'			=> $data['biaya_pengiriman_pesanan'],

		);

		$this->db->insert('rpp_isi', $biaya_pengiriman_pesanan);



		$biaya_fotocopy_dokumen = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'biaya_fotocopy_dokumen',

			'pairs'				=> '',

			'turn_over'			=> $data['biaya_fotocopy_dokumen'],

		);

		$this->db->insert('rpp_isi', $biaya_fotocopy_dokumen);



		$biaya_perjalanan_dinas = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'biaya_perjalanan_dinas',

			'pairs'				=> '',

			'turn_over'			=> $data['biaya_perjalanan_dinas'],

		);

		$this->db->insert('rpp_isi', $biaya_perjalanan_dinas);



		$pembayaran_gaji_dan_komisi_supervisor = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'pembayaran_gaji_dan_komisi_supervisor',

			'pairs'				=> '',

			'turn_over'			=> $data['pembayaran_gaji_dan_komisi_supervisor'],

		);

		$this->db->insert('rpp_isi', $pembayaran_gaji_dan_komisi_supervisor);



		$pembayaran_komisi_pramuniaga = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'pembayaran_komisi_pramuniaga',

			'pairs'				=> '',

			'turn_over'			=> $data['pembayaran_komisi_pramuniaga'],

		);

		$this->db->insert('rpp_isi', $pembayaran_komisi_pramuniaga);



		$ongkos_dan_administrasi_bank = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'ongkos_dan_administrasi_bank',

			'pairs'				=> '',

			'turn_over'			=> $data['ongkos_dan_administrasi_bank'],

		);

		$this->db->insert('rpp_isi', $ongkos_dan_administrasi_bank);



		$ongkos_angkut = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'ongkos_angkut',

			'pairs'				=> '',

			'turn_over'			=> $data['ongkos_angkut'],

		);

		$this->db->insert('rpp_isi', $ongkos_angkut);



		// SPESIAL DISKON SUDAH DITAMBAHKAN DI MENU RPP TINGGAL NGELOAD //



		$pembayaran_pajak = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'pembayaran_pajak',

			'pairs'				=> '',

			'turn_over'			=> $data['pembayaran_pajak'],

		);

		$this->db->insert('rpp_isi', $pembayaran_pajak);

// SUB TOTAL BIAYA RUTIN

		$sub_total_biaya_rutin = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'sub_total_biaya_rutin',

			'pairs'				=> '',

			'turn_over'			=> $data['selisih_lebih_penjualan_bulan_lalu'] + $data['biaya_promosi'] + $data['biaya_internet'] + $data['biaya_pengiriman_pesanan'] + $data['biaya_fotocopy_dokumen'] + $data['biaya_perjalanan_dinas'] + $data['pembayaran_gaji_dan_komisi_supervisor'] + $data['pembayaran_komisi_pramuniaga'] + $data['ongkos_dan_administrasi_bank'] + $data['ongkos_angkut'] + $data['pembayaran_pajak'], //+ $data['spesial_diskon']

		);

		$this->db->insert('rpp_isi', $sub_total_biaya_rutin);

		// PERIODE CLOSING
		$totalbiaya = $data['selisih_lebih_penjualan_bulan_lalu'] + $data['biaya_promosi'] + $data['biaya_internet'] + $data['biaya_pengiriman_pesanan'] + $data['biaya_fotocopy_dokumen'] + $data['biaya_perjalanan_dinas'] + $data['pembayaran_gaji_dan_komisi_supervisor'] + $data['pembayaran_komisi_pramuniaga'] + $data['ongkos_dan_administrasi_bank'] + $data['ongkos_angkut'] + $data['pembayaran_pajak']; //+ $data['spesial_diskon']
		$pr = date('d F Y', strtotime($tgl1))." - ".date('d F Y', strtotime($tgl2));
		$this->db->insert('penjualan_fix',array('penjualan_fix'=>$data['total_setoran_bank'], 'biaya_marketplace'=> $totalbiaya, 'tgl_input'=>date('Y-m-d H:i:s'), 'periode' => $pr));



		$biaya_maintenance = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'biaya_maintenance',

			'pairs'				=> '',

			'turn_over'			=> $data['biaya_maintenance'],

		);

		$this->db->insert('rpp_isi', $biaya_maintenance);

// SUB TOTAL BIAYA NON RUTIN

		$sub_total_biaya_non_rutin = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'sub_total_biaya_non_rutin',

			'pairs'				=> '',

			'turn_over'			=> $data['biaya_maintenance'],

		);

		$this->db->insert('rpp_isi', $sub_total_biaya_non_rutin);

// TOTAL BIAYA RUTIN + TOTAL BIAYA NON RUTIN

		$total_biaya_rutin_dan_non_rutin = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'total_biaya_rutin_dan_non_rutin',

			'pairs'				=> '',

			'turn_over'			=> $data['selisih_lebih_penjualan_bulan_lalu'] + $data['biaya_promosi'] + $data['biaya_internet'] + $data['biaya_pengiriman_pesanan'] + $data['biaya_fotocopy_dokumen'] + $data['biaya_perjalanan_dinas'] + $data['pembayaran_gaji_dan_komisi_supervisor'] + $data['pembayaran_komisi_pramuniaga'] + $data['ongkos_dan_administrasi_bank'] + $data['ongkos_angkut'] + $data['pembayaran_pajak'] + $data['biaya_maintenance'], //+ $data['spesial_diskon']

		);

		$this->db->insert('rpp_isi', $total_biaya_rutin_dan_non_rutin);

// TOTAL SETORAN BANK

		$total_setoran_bank = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'total_setoran_bank',

			'pairs'				=> '',

			'turn_over'			=> $data['total_setoran_bank'],

		);

		$this->db->insert('rpp_isi', $total_setoran_bank);

// TOTAL KARTU KREDIT SESUAI BUKTI

		$total_kartu_kredit = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'total_kartu_kredit',

			'pairs'				=> '',

			'turn_over'			=> $data['total_kartu_kredit'],

		);

		$this->db->insert('rpp_isi', $total_kartu_kredit);

// ADDING FORM KANAN

		if($data['add_turn_kanan'] > 0){

			$ad_turn_kanan = $data['add_turn_kanan'];

		}else{

			$ad_turn_kanan = '';

		}

		$add_turn_kanan = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'add_turn_kanan',

			'pairs'				=> '',

			'turn_over'			=> $ad_turn_kanan,

		);

		$this->db->insert('rpp_isi', $add_turn_kanan);



// TOTAL TURN OVER RPK KANAN



		$total_turn_over_rpk_kanan = array(

			'id_rpp_default' 	=> $last_insert_id,

			'rincian'		 	=> 'total_turn_over_rpk_kanan',

			'pairs'				=> '',

			'turn_over'			=> $data['selisih_lebih_penjualan_bulan_lalu'] + $data['biaya_promosi'] + $data['biaya_internet'] + $data['biaya_pengiriman_pesanan'] + $data['biaya_fotocopy_dokumen'] + $data['biaya_perjalanan_dinas'] + $data['pembayaran_gaji_dan_komisi_supervisor'] + $data['pembayaran_komisi_pramuniaga'] + $data['ongkos_dan_administrasi_bank'] + $data['ongkos_angkut'] + $data['pembayaran_pajak'] + $data['biaya_maintenance'] + $data['total_setoran_bank'] + $data['total_kartu_kredit'] + $ad_turn_kanan, //+ $data['spesial_diskon']

		);

		$this->db->insert('rpp_isi', $total_turn_over_rpk_kanan);

	}	



	function get_data_rpp($id){

		$idf = base64_decode($id);

		$idp = $this->encrypt->decode($idf);

		$this->db->select('*');

		$this->db->from('rpp_title a');

		$this->db->join('penjualan_by_closing c','c.id_rpp_closing=a.id_rpp','left');

		$this->db->join('rpp_isi b', 'b.id_rpp_default=a.id_rpp', 'left');

		$this->db->where('id_rpp', $idp);

		$r = $this->db->get();

		return $r->result();

	}



	function hapus($id){

		$idf = base64_decode($id);

		$idp = $this->encrypt->decode($idf);

		//$query = $this->db->get_where('produk',array('id_produk'=>$idp));

		$this->db->delete('rpp_title', array('id_rpp' => $idp));

    	$this->db->delete('rpp_isi', array('id_rpp_default' => $idp));

    	$this->db->delete('penjualan_by_closing', array('id_rpp_closing'=>$idp));

    	$this->db->delete('pesanan_pending_bln_ini', array('id_rpp'=>$idp));

    	$this->db->delete('pesanan_pending_bln_lalu', array('id_rpp'=>$idp));

    	$this->db->delete('pesanan_ontime', array('id_rpp'=>$idp));

    	$this->db->delete('stok_perbulan', array('id_rpp'=>$idp));

	}



	function hapus_penj_by_closing($id){

		$idf = base64_decode($id);

		$idp = $this->encrypt->decode($idf);

		$this->db->where('id_rpp_closing',$idp);

		$this->db->delete('penjualan_by_closing');

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



	function tahunan_filter_comparison($tahun1){

		$this->db->select('*');

		$this->db->from('penjualan_by_closing a');

		$this->db->like('a.bulan',$tahun1);

		$r = $this->db->get();

		return $r->result();

	}



	function tahunan_filter_comparison2($tahun2){

		$this->db->select('*');

		$this->db->from('penjualan_by_closing a');

		$this->db->like('a.bulan',$tahun2);

		$r = $this->db->get();

		return $r->result();

	}



	function bulanan_filter_comparison($bulan1){

		$this->db->select('*');

		$this->db->from('penjualan_by_closing a');

		$this->db->where('a.id_rpp_closing',$bulan1);

		$r = $this->db->get();

		return $r->result();

	}



	function bulanan_filter_comparison2($bulan2){

		$this->db->select('*');

		$this->db->from('penjualan_by_closing a');

		$this->db->where('a.id_rpp_closing',$bulan2);

		$r = $this->db->get();

		return $r->result();

	}



	function get_store_for_comission($tgl1, $tgl2, $status1, $status2, $market){

		$this->db->select('a.invoice,a.sender,b.nama_toko,b.kode_edp');

		$this->db->from('order_customer a');

		$this->db->join('toko b','b.kode_edp=a.sender','left join');

		$this->db->where('a.tanggal_order_finish >=', $tgl1);

		$this->db->where('a.tanggal_order_finish <=', $tgl2);

		$this->db->where_in('a.status', $status2);

		$this->db->where_in('a.dibayar',$status1);

		$this->db->where_in('a.buy_in', $market);

		$this->db->order_by('a.tanggal_order_finish asc');

		$this->db->group_by('b.kode_edp');

		$r = $this->db->get();

		return $r->result();

	}

	function get_store_for_comission_tgl_order($tgl1, $tgl2, $status1, $status2, $market){

		$this->db->select('a.sender,b.nama_toko,b.kode_edp');

		$this->db->from('order_customer a');

		$this->db->join('toko b','b.kode_edp=a.sender','left join');

		$this->db->where('a.tanggal_order >=', $tgl1);

		$this->db->where('a.tanggal_order <=', $tgl2);

		$this->db->where_in('a.status', $status2);

		$this->db->where_in('a.dibayar',$status1);

		$this->db->where_in('a.buy_in', $market);

		$this->db->order_by('a.tanggal_order asc');

		$this->db->group_by('b.kode_edp');

		$r = $this->db->get();

		return $r->result();

	}

	function get_order_for_comission_by_tgl_order($storeEdp,$tgl1,$tgl2,$status1x,$status2x,$marketx){

		$this->db->select('a.*,b.*,c.no_order_ex,c.tarif,c.ongkir_ditanggung,c.actual_tarif,d.nama_toko,d.kode_edp,f.retprc');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		$this->db->join('toko d','d.kode_edp=b.sender','left');

		$this->db->join('brgcp f','f.art_id=a.artikel');

		$this->db->where('b.sender',$storeEdp);

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

		$this->db->where_in('b.status',$status2x);

		$this->db->where_in('b.dibayar',$status1x);

		$this->db->where_in('b.buy_in', $marketx);

		$this->db->order_by('b.buy_in asc');

		$r = $this->db->get();

		return $r->result();

	}

	function get_order_for_comission_by_tgl_selesai_order($storeEdp,$tgl1,$tgl2,$status1x,$status2x,$marketx){

		$this->db->select('a.*,b.*,c.no_order_ex,c.tarif,c.ongkir_ditanggung,c.actual_tarif,d.nama_toko,d.kode_edp,f.retprc');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		$this->db->join('toko d','d.kode_edp=b.sender','left');

		$this->db->join('brgcp f','f.art_id=a.artikel');

		$this->db->where('b.sender',$storeEdp);

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

		$this->db->where_in('b.status',$status2x);

		$this->db->where_in('b.dibayar',$status1x);

		$this->db->where_in('b.buy_in', $marketx);

		$this->db->order_by('b.buy_in asc');

		$r = $this->db->get();

		return $r->result();

	}

	function get_order_for_comission_by_tgl_orderx($tgl1,$tgl2,$status1,$status2,$market){

		$this->db->select('a.*,b.*,c.no_order_ex,c.tarif,c.ongkir_ditanggung,c.actual_tarif,d.nama_toko,d.kode_edp, e.nama_produk,f.milik as divisi, g.merk,h.retprc');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		$this->db->join('toko d','d.kode_edp=b.sender','left');

		// tambahan join

		$this->db->join('produk e','e.artikel=a.artikel','left');

		$this->db->join('produk_milik f','f.id_milik=e.id_kategori_divisi','left');

		$this->db->join('merk g','g.merk_id=e.merk','left');

		$this->db->join('brgcp h','h.art_id=a.artikel');

		//$this->db->where('b.sender',$storeEdp);

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

		$this->db->where_in('b.status',$status2);

		$this->db->where_in('b.dibayar',$status1);

		$this->db->where_in('b.buy_in', $market);

		$this->db->order_by('b.tanggal_order asc');

		$r = $this->db->get();

		return $r->result();

	}

	function get_order_for_comission_by_tgl_selesai_orderx($tgl1,$tgl2,$status1,$status2,$market){

		$this->db->select('a.*,b.*,c.no_order_ex,c.tarif,c.ongkir_ditanggung,c.actual_tarif,d.nama_toko,d.kode_edp, e.nama_produk,f.milik as divisi, g.merk,h.retprc');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		$this->db->join('toko d','d.kode_edp=b.sender','left');

		// tambahan join

		$this->db->join('produk e','e.artikel=a.artikel','left');

		$this->db->join('produk_milik f','f.id_milik=e.id_kategori_divisi','left');

		$this->db->join('merk g','g.merk_id=e.merk','left');

		$this->db->join('brgcp h','h.art_id=a.artikel');

		//$this->db->where('b.sender',$storeEdp);

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

		$this->db->where_in('b.status',$status2);

		$this->db->where_in('b.dibayar',$status1);

		$this->db->where_in('b.buy_in', $market);

		$this->db->order_by('b.tanggal_order_finish asc');

		$r = $this->db->get();

		return $r->result();

	}



	function get_order_for_comission($storeEdp,$tgl1,$tgl2,$status1x,$status2x,$marketx){

		$this->db->select('a.*,b.*,c.no_order_ex,c.tarif,c.ongkir_ditanggung,c.actual_tarif,d.nama_toko,d.kode_edp');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		$this->db->join('toko d','d.kode_edp=b.sender','left');

		$this->db->where('b.sender',$storeEdp);

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

		$this->db->where_in('b.status', $status2x);

		$this->db->where_in('b.dibayar',$status1x);

		$this->db->where_in('b.buy_in', $marketx);

		$this->db->order_by('b.buy_in asc');

		$r = $this->db->get();

		return $r->result();

	}

	function get_order_for_comission_by_tgl_order_online($storeEdp,$tgl1,$tgl2,$marketx){

		$this->db->select('a.*,b.*,c.no_order_ex,c.tarif,c.ongkir_ditanggung,c.actual_tarif,d.nama_toko,d.kode_edp');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		$this->db->join('toko d','d.kode_edp=b.sender','left');

		$this->db->where('b.sender',$storeEdp);

		$this->db->where('b.tanggal_order >=', $tgl1);

		$this->db->where('b.tanggal_order <=', $tgl2);

		$this->db->where_in('b.buy_in', $marketx);

		$this->db->where('b.status','ScUuses8625(62427^#&9531(73');

		$this->db->where_in('b.dibayar','bayar');

		$this->db->order_by('b.buy_in asc');

		$r = $this->db->get();

		return $r->result();

	}

	function get_order_for_comission_online($storeEdp,$tgl1,$tgl2,$marketx){

		$this->db->select('a.*,b.*,c.no_order_ex,c.tarif,c.ongkir_ditanggung,c.actual_tarif,d.nama_toko,d.kode_edp');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		$this->db->join('toko d','d.kode_edp=b.sender','left');

		$this->db->where('b.sender',$storeEdp);

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

		$this->db->where_in('b.buy_in', $marketx);

		$this->db->where('b.status','ScUuses8625(62427^#&9531(73');

		$this->db->where_in('b.dibayar','bayar');

		$this->db->order_by('b.buy_in asc');

		$r = $this->db->get();

		return $r->result();

	}

	function get_order_for_actual_ongkir_for_rpk($tgl1,$tgl2){

		$this->db->select('*');

		$this->db->from('order_expedisi a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_ex','left');

		//$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		//$this->db->join('toko d','d.kode_edp=b.sender','left');

		//$this->db->where('b.sender',$storeEdp);

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

		$this->db->where('b.status','ScUuses8625(62427^#&9531(73');

		$this->db->where_in('b.dibayar','bayar');

		$this->db->order_by('b.tanggal_order_finish asc');

		$r = $this->db->get();

		return $r->result();	

	}



	function get_order_for_actual_ongkir($storeEdp,$tgl1,$tgl2){

		$this->db->select('*');

		$this->db->from('order_expedisi a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_ex','left');

		//$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		//$this->db->join('toko d','d.kode_edp=b.sender','left');

		$this->db->where('b.sender',$storeEdp);

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

		$this->db->where('b.status','ScUuses8625(62427^#&9531(73');

		$this->db->where_in('b.dibayar','bayar');

		$this->db->order_by('b.tanggal_order_finish asc');

		$r = $this->db->get();

		return $r->result();	

	}

	function get_order_for_comission_rpp($storeEdp,$tgl1,$tgl2){

		$this->db->select('a.*,b.*,c.no_order_ex,c.tarif,c.ongkir_ditanggung,c.actual_tarif,d.nama_toko,d.kode_edp');

		$this->db->from('order_product a');

		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');

		$this->db->join('order_expedisi c', 'c.no_order_ex=b.no_order_cus','left');

		$this->db->join('toko d','d.kode_edp=b.sender','left');

		$this->db->where('b.sender',$storeEdp);

		$this->db->where('b.tanggal_order_finish >=', $tgl1);

		$this->db->where('b.tanggal_order_finish <=', $tgl2);

		$this->db->where('b.status','ScUuses8625(62427^#&9531(73');

		$this->db->where_in('b.dibayar','bayar');

		//$this->db->where_in('b.buy_in', $marketx);

		$this->db->order_by('b.buy_in asc');

		$r = $this->db->get();

		return $r->result();

	}

	function produk_bestseller_bulan_ini($tgl1, $tgl2, $status1, $status2, $market){ 
		//$ignore = array('');
		$this->db->select('SUM(a.qty) AS total, a.artikel,b.nama_produk,b.artikel,b.gambar, c.invoice, c.status');
		$this->db->from('order_product a');
		$this->db->join('produk b','b.artikel=a.artikel','left');
		$this->db->join('order_customer c','c.no_order_cus=a.no_order_pro','left');
		$this->db->where('c.tanggal_order_finish >=', $tgl1);
		$this->db->where('c.tanggal_order_finish <=', $tgl2);
		$this->db->where_in('c.status', $status2);
		$this->db->where_in('c.dibayar',$status1);
		$this->db->where_in('c.buy_in', $market);
		$this->db->order_by('total desc');
		$this->db->group_by('b.id_produk');
		//$this->db->limit(20);
		$q = $this->db->get();
		return $q->result();		
	}

	function penj_by_sosmed_dan_mp($tgl1, $tgl2, $status1x, $status2x, $marketx){
		//$tahun_ini = date('Y');
		$this->db->select('COALESCE(SUM(a.qty),0) as jual_pasang,c.buy_in');
		//$this->db->select('SUM(a.qty) as jual_pasang c.buy_in');
		$this->db->from('order_product a'); 
		$this->db->join('produk b','b.artikel=a.artikel','left');
		$this->db->join('order_customer c', 'c.no_order_cus=a.no_order_pro','left');
		$this->db->where('c.tanggal_order_finish >=', $tgl1);
		$this->db->where('c.tanggal_order_finish <=', $tgl2);
		$this->db->where_in('c.status', $status2x);
		$this->db->where_in('c.dibayar',$status1x);
		$this->db->where_in('c.buy_in', $marketx);
		$this->db->order_by('jual_pasang desc');
		//$this->db->group_by('b.id_produk');
		//$this->db->where('YEAR(order_customer.tanggal_order)',$tahun_ini);
		//$this->db->where('status','ScUuses8625(62427^#&9531(73');
		//$this->db->group_by('YEAR(order_customer.tanggal_order),order_customer.buy_in');
		$x = $this->db->get();
		return $x->result();	
	}

	function getDivisi(){
		$this->db->select('*');
		$this->db->from('produk_milik');  
		$this->db->where('aktif', 'on');
		$x = $this->db->get();
		return $x->result();	
	}

	function produk_terjual_bydivisi_bulan_ini($tgl1, $tgl2, $status1x, $status2x, $milik){
		$this->db->select('COALESCE(SUM(a.qty),0) as total');
		//$this->db->select('SUM(a.qty) as jual_pasang c.buy_in');
		$this->db->from('order_product a'); 
		$this->db->join('produk b','b.artikel=a.artikel','left');
		$this->db->join('order_customer d','d.no_order_cus=a.no_order_pro','left');
		$this->db->join('produk_milik c', 'c.id_milik=b.id_kategori_divisi','left');
		$this->db->where('d.tanggal_order_finish >=', $tgl1);
		$this->db->where('d.tanggal_order_finish <=', $tgl2);
		$this->db->where_in('d.status', $status2x);
		$this->db->where_in('d.dibayar',$status1x);
		$this->db->where('b.id_kategori_divisi', $milik);
		//$this->db->order_by('jual_pasang desc');
		$x = $this->db->get();
		return $x->result();	
	}

	function get_data_retur($tgl1, $tgl2){
		$this->db->select('a.*,c.nama_lengkap, c.invoice, c.status, e.*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('customer b','b.id=a.id_customer_retur','left');
		$this->db->join('order_customer c','c.no_order_cus=a.id_invoice_real','left');
		$this->db->join('solusi_retur e','e.id_solusi=a.solusi','left');
		$this->db->where('a.date_filter >=', $tgl1);
		$this->db->where('a.date_filter <=', $tgl2);
		$q = $this->db->get();
		return $q->result();
	}

	function get_data_produk_retur($tgl1, $tgl2){
		$this->db->select('*');
		$this->db->from('order_informasi_retur a');
		$this->db->join('order_produk_retur b','b.id_retur_produk=a.id_retur_info','left');
		$this->db->where('a.date_filter >=', $tgl1);
		$this->db->where('a.date_filter <=', $tgl2);
		//$this->db->group_by('b.id_retur_produk');
		$q = $this->db->get();
		return $q->result();
	}

	function list_biaya(){
		$this->db->select('*');
		$this->db->from('order_biaya a');
		$this->db->join('order_customer b','b.no_order_cus=a.no_order_biaya','left');
		$this->db->where_not_in('no_order_biaya', '');
		//$this->db->group_by('b.id_retur_produk');
		$q = $this->db->get();
		return $q->result();	
	}

	function get_data_biaya($no_order){
		$this->db->select('*'); 
		$this->db->from('order_biaya a');
		$this->db->where('no_order_biaya', $no_order);
		$q = $this->db->get();
		return $q->row_array();		
	}

	function get_data_laporan_pengiriman($tgl1, $tgl2, $status1, $status2, $market, $ditanggung){

		$this->db->select('a.*,b.*,c.kode_edp,c.nama_toko');
		$this->db->from('order_expedisi a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_ex','left');
		//$this->db->join('order_product c','no_order_pro=a.no_order_ex','left');
		$this->db->join('toko c','c.kode_edp=b.sender','left');
		$this->db->where('b.tanggal_order_finish >= "'.$tgl1.'"');
		$this->db->where('b.tanggal_order_finish <= "'.$tgl2.'"');
		$this->db->where_in('b.status',$status2);
		$this->db->where_in('b.dibayar',$status1);
		$this->db->where_in('b.buy_in',$market);
		$this->db->where_in('a.ongkir_ditanggung',$ditanggung);
		$this->db->order_by('b.tanggal_order_finish asc');
		$r = $this->db->get();
		return $r->result();	
	}

	function getdbsalesdate($market,$tgl1,$tgl2){
		$this->db->select('*');
		$this->db->from('order_customer a');
		//$this->db->join('order_produk b', 'b.no_order_pro=a.no_order_cus','left');
		$this->db->where('a.tanggal_order_finish >=', $tgl1);
		$this->db->where('a.tanggal_order_finish <=', $tgl2);
		$this->db->where('a.status', 'ScUuses8625(62427^#&9531(73');
		$this->db->where('a.dibayar','bayar');
		$this->db->where_in('a.buy_in', $market);
		//$this->db->group_by('a.id_produk');
		$this->db->order_by('a.tanggal_order asc');
		$r = $this->db->get();

		return $r->result();
	}

	function cekDataganda($idSales,$market){
		//if($market == "E-commerce" || $market == "instagram"){
			$dbecommerce = $this->load->database('ecommerce', TRUE);
			$dbecommerce->select('Sls_id');
			$dbecommerce->from('sls');
			$dbecommerce->where('Sls_id', $idSales);
			return $dbecommerce->get();
		//}else if($market == "shopee"){
		//	$dbshopee = $this->load->database('shopee', TRUE);
		//	$dbshopee->select('Sls_id');
		//	$dbshopee->from('sls');
		//	$dbshopee->where('Sls_id', $idSales);
		//	return $dbshopee->get();
		//}else if($market == "tokopedia"){
		//	$dbtokopedia = $this->load->database('tokopedia', TRUE);
		//	$dbtokopedia->select('Sls_id');
		//	$dbtokopedia->from('sls');
		//	$dbtokopedia->where('Sls_id', $idSales);
		//	return $dbtokopedia->get();
		//}else if($market == "lazada"){
		//	$dblazada = $this->load->database('lazada', TRUE);
		//	$dblazada->select('Sls_id');
		//	$dblazada->from('sls');
		//	$dblazada->where('Sls_id', $idSales);
		//	return $dblazada->get();
		//}else if($market == "blibli"){
		//	$dbblibli = $this->load->database('blibli', TRUE);
		//	$dbblibli->select('Sls_id');
		//	$dbblibli->from('sls');
		//	$dbblibli->where('Sls_id', $idSales);
		//	return $dbblibli->get();
		//}else if($market == "bukalapak"){
		//	$dbbukalapak = $this->load->database('bukalapak', TRUE);
		//	$dbbukalapak->select('Sls_id');
		//	$dbbukalapak->from('sls');
		//	$dbbukalapak->where('Sls_id', $idSales);
		//	return $dbbukalapak->get();
		//}
	}

	function cekDataganda2($idSales,$art,$pasang,$ukuran,$market){
		//if($market == "E-commerce" || $market == "instagram"){
			$dbecommerce = $this->load->database('ecommerce', TRUE);
			$dbecommerce->select('*');
			$dbecommerce->from('slsdet');
			$dbecommerce->where('Sls_id', $idSales);
			$dbecommerce->where('Art_id', $art);
			$dbecommerce->where('Psg', $pasang);
			$dbecommerce->where('Uk', $ukuran);
			return $dbecommerce->get();
		//}else if($market == "shopee"){
		//	$dbshopee = $this->load->database('shopee', TRUE);
		//	$dbshopee->select('*');
		//	$dbshopee->from('slsdet');
		//	$dbshopee->where('Sls_id', $idSales);
		//	$dbshopee->where('Art_id', $art);
		//	$dbshopee->where('Psg', $pasang);
		//	$dbshopee->where('Uk', $ukuran);
		//	return $dbshopee->get();
		//}else if($market == "tokopedia"){
		//	$dbtokopedia = $this->load->database('tokopedia', TRUE);
		//	$dbtokopedia->select('*');
		//	$dbtokopedia->from('slsdet');
		//	$dbtokopedia->where('Sls_id', $idSales);
		//	$dbtokopedia->where('Art_id', $art);
		//	$dbtokopedia->where('Psg', $pasang);
		//	$dbtokopedia->where('Uk', $ukuran);
		//	return $dbtokopedia->get();
		//}else if($market == "lazada"){
		//	$dblazada = $this->load->database('lazada', TRUE);
		//	$dblazada->select('*');
		//	$dblazada->from('slsdet');
		//	$dblazada->where('Sls_id', $idSales);
		//	$dblazada->where('Art_id', $art);
		//	$dblazada->where('Psg', $pasang);
		//	$dblazada->where('Uk', $ukuran);
		//	return $dblazada->get();
		//}else if($market == "blibli"){
		//	$dbblibli = $this->load->database('blibli', TRUE);
		//	$dbblibli->select('*');
		//	$dbblibli->from('slsdet');
		//	$dbblibli->where('Sls_id', $idSales);
		//	$dbblibli->where('Art_id', $art);
		//	$dbblibli->where('Psg', $pasang);
		//	$dbblibli->where('Uk', $ukuran);
		//	return $dbblibli->get();
		//}else if($market == "bukalapak"){
		//	$dbbukalapak = $this->load->database('bukalapak', TRUE);
		//	$dbbukalapak->select('*');
		//	$dbbukalapak->from('slsdet');
		//	$dbbukalapak->where('Sls_id', $idSales);
		//	$dbbukalapak->where('Art_id', $art);
		//	$dbbukalapak->where('Psg', $pasang);
		//	$dbbukalapak->where('Uk', $ukuran);
		//	return $dbbukalapak->get();
		//}
	}

	function getdbsalesproduk($no_order_cus){
		$this->db->select('a.*,b.*,c.retprc');
		$this->db->from('order_product a');
		$this->db->join('order_customer b', 'b.no_order_cus=a.no_order_pro','left');
		$this->db->join('brgcp c','c.art_id=a.artikel','left');
		$this->db->where('b.no_order_cus', $no_order_cus);
		//$this->db->group_by('a.id_produk');
		$this->db->order_by('b.tanggal_order asc');
		$r = $this->db->get();
		return $r->result();
	}

	function sendSales($dataSales,$market){
		//if($market == "E-commerce" || $market == "instagram"){
			$dbecommerce = $this->load->database('ecommerce', TRUE);
			$dbecommerce->insert('sls',$dataSales);
		//}else if($market == "shopee"){
		//	$dbshopee = $this->load->database('shopee', TRUE);
		//	$dbshopee->insert('sls',$dataSales);
		//}else if($market == "tokopedia"){
		//	$dbtokopedia = $this->load->database('tokopedia', TRUE);
		//	$dbtokopedia->insert('sls',$dataSales);
		//}else if($market == "lazada"){
		//	$dblazada = $this->load->database('lazada', TRUE);
		//	$dblazada->insert('sls',$dataSales);
		//}else if($market == "blibli"){
		//	$dbblibli = $this->load->database('blibli', TRUE);
		//	$dbblibli->insert('sls',$dataSales);
		//}else if($market == "bukalapak"){
		//	$dbbukalapak = $this->load->database('bukalapak', TRUE);
		//	$dbbukalapak->insert('sls',$dataSales);
		//}
	}

	function sendSalesproduk($dataProduk,$market){
		//if($market == "E-commerce" || $market == "instagram"){
			$dbecommerce = $this->load->database('ecommerce', TRUE);
			$dbecommerce->insert('slsdet',$dataProduk);
		//}else if($market == "shopee"){
		//	$dbshopee = $this->load->database('shopee', TRUE);
		//	$dbshopee->insert('slsdet',$dataProduk);
		//}else if($market == "tokopedia"){
		//	$dbtokopedia = $this->load->database('tokopedia', TRUE);
		//	$dbtokopedia->insert('slsdet',$dataProduk);
		//}else if($market == "lazada"){
		//	$dblazada = $this->load->database('lazada', TRUE);
		//	$dblazada->insert('slsdet',$dataProduk);
		//}else if($market == "blibli"){
		//	$dbblibli = $this->load->database('blibli', TRUE);
		//	$dbblibli->insert('slsdet',$dataProduk);
		//}else if($market == "bukalapak"){
		//	$dbbukalapak = $this->load->database('bukalapak', TRUE);
		//	$dbbukalapak->insert('slsdet',$dataProduk);
		//}
	}

}

?>