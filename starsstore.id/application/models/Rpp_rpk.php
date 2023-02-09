<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpp_rpk extends CI_Controller { 

	protected $key = 'MSY374BDND9NSFSV21N336DMVC06862N'; 
	protected $iv =  'MBX5294N4MXB27452NG102ND63BN5241';
 
	function __construct(){ 
		parent::__construct();
		$this->load->model(array('sec47logaccess/rpp_rpk_adm','sec47logaccess/onlinestore_adm')); 
		$this->data['id'] = $this->session->userdata('id');
		$this->load->library('upload');
		$this->data['username'] = $this->session->userdata('username'); 
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url()); 
		}   
	}  
 
	function index(){ // get data 
		// hitung pendingan 
		$list = $this->rpp_rpk_adm->pendingan();
		$total = 0;  
		$psg = 0;  
		foreach($list as $h){ 
				$total += $h->inv;
				$psg += $h->qt; 
		}
		$success = array( 'error' => '', 'success' => '');
		$list_data['market'] = $this->onlinestore_adm->get_marketplace();
		$list_data['get_list'] = $this->rpp_rpk_adm->get_list_rpp();
		$list_data['pendingan'] = $total;
		$list_data['pendingan_psg'] = $psg;
		$list_data['bulan'] = $this->rpp_rpk_adm->get_result_bulan_closing();
		// set tanggal closing untuk frontend
		$list_data['set'] = $this->rpp_rpk_adm->set_tanggal_closing();
		// set tanggal closing untuk backend
		$set = $this->rpp_rpk_adm->set_tanggal_closing();
		$tgl = explode('|', $set['konten']);
      	$tgl1 = $tgl[0];
      	$tgl2 = $tgl[1];

      	$periode = date('d F Y', strtotime($tgl1)).' - '.date('d F Y', strtotime($tgl2));
    	$cek = $this->rpp_rpk_adm->cek_penjualan_fix($periode);
    	$list_data['periode'] = $cek;

    	// $MARKET
    	$list_market = $this->rpp_rpk_adm->get_marketplace();
        foreach($list_market as $hx){
        	// load data marketplace
        	$mrx[] = $hx->val_market;
        }
        $market = $mrx;
        // $STATUS1
    	$status1 = array('bayar');
        // $STATUS2
        $status2 = array('ScUuses8625(62427^#&9531(73');
    	$terjual = $this->rpp_rpk_adm->stok_penjualan_by_tgl_selesai_order($tgl1, $tgl2, $status1, $status2, $market);
    	$total_komisi = 0;
        $total_harga_barangx = 0;
    	foreach($terjual as $dx){
    		$total_harga_barangx += ($dx->harga_fix*$dx->qty);
    		if($dx->komisi_toko == ""){
	        	$komisi1 = (($dx->harga_fix*3)/100) + (($dx->harga_fix*1)/100);
	        }else{
	        	$komisi1 = $dx->komisi_toko;
	        }
    		$total_komisi += round($komisi1);
    	}

    	$list_data['total_harga_barang'] = $total_harga_barangx;
    	$list_data['total_komisi'] = $total_komisi;
    	$list_data['list_closing'] = $this->rpp_rpk_adm->list_closing();

		$data = array_merge($success, $list_data);

		$this->load->view('manage/header');
		$this->load->view('manage/laporan/rpp_rpk/index', $data);
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman RPP / RPK');
		
	} 

	function closing(){
		$tgl1_filtering = $this->security->xss_clean($this->input->post('tgl1x'));
        $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1_filtering);

        $tgl2_filtering = $this->security->xss_clean($this->input->post('tgl2x'));
        $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2_filtering);

        $market1_filtering = $this->security->xss_clean($this->input->post('marketplace'));
        $market1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$market1_filtering);

		$id1_filtering = $this->security->xss_clean($this->input->post('laporan'));
        $id1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id1_filtering);

        if($id1 == "simpantanggal"){
        	
        	$simpantgl = array(
        		'konten'	=> $tgl1.'|'.$tgl2,
        	);
        	$this->db->where('nama','tgl_closing');
        	$this->db->update('setting', $simpantgl);

        	$this->session->set_flashdata('success', 'Set Tanggal Closing '.date('d F Y', strtotime($tgl1)).' - '.date('d F Y', strtotime($tgl2)).' Berhasil');
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Set Tanggal Closing '.date('d F Y', strtotime($tgl1)).' - '.date('d F Y', strtotime($tgl2)).' ');
			redirect($this->agent->referrer());

        }else if($id1 == "syncdatasales_ist_todbpos"){
        	$baseURL = base_url();
        	if($baseURL == "https://www.starsstore.id/"){
        		echo "AKSES DITOLAK";
        	}else{

        		//if($market1 != "semua"){
	        		$market = $market1;
	        		$market_title = $market1;

	        		$key = "XN1JKJ48N048CN8964CN78GSDF1";
	        		$url = "https://www.starsstore.id/sinkronDatastarsstoretopos/?api=".$key."&market=".$market."&tgl1=".$tgl1."&tgl2=".$tgl2."";
	        		$curl = curl_init();
			        $proxy = '192.168.0.219:80';

			        curl_setopt_array($curl, array(
			        CURLOPT_URL => "https://www.starsstore.id/sinkronDatastarsstoretopos/?api=".$key."&market=".$market."&tgl1=".$tgl1."&tgl2=".$tgl2."",
			        //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
			        CURLOPT_RETURNTRANSFER => true,
			        CURLOPT_ENCODING => "",
			        CURLOPT_MAXREDIRS => 10, 
			        CURLOPT_TIMEOUT => 30,
			        CURLOPT_SSL_VERIFYPEER => 0,
			        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			        CURLOPT_CUSTOMREQUEST => "GET",
			        CURLOPT_HTTPHEADER => array(
			          "content-type: application/x-www-form-urlencoded",
			        ),
			        ));

			        $response = curl_exec($curl);
			        $err = curl_error($curl);
			        curl_close($curl);


			        if($err){
			          $this->session->set_flashdata('error', 'Gagal mengirim data sales ke server POS '.$market.' #: '.$err.'');
			          log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal mengirim data sales ke server POS '.$market.' (local)');
			        }else{
			          $datax = json_decode($response, true);
			          for ($l=0; $l < count($datax['sales']); $l++){ 
			            $idSales = $datax['sales'][$l]['Sls_id'];
		        		$cekDb1 = $this->rpp_rpk_adm->cekDataganda($idSales,$market);
		        		if($cekDb1->num_rows() == 0){ // jika 0 maka insert
				            $dataSales = array(
				        		'Sls_id' 	=> $datax['sales'][$l]['Sls_id'],
				        		'tgl' 		=> $datax['sales'][$l]['tgl'],
				        		'us_id'		=> $datax['sales'][$l]['us_id'],
				        		'jns' 		=> $datax['sales'][$l]['jns'],
				        		'card' 		=> $datax['sales'][$l]['card'],
				        		'kasir'		=> $datax['sales'][$l]['kasir'],
				        	);
				            $this->rpp_rpk_adm->sendSales($dataSales,$market);
				            //print_r($dataSales)."<br><br>";
				        }

				        $art = $datax['sales'][$l]['Art_id'];
				        $pasang = $datax['sales'][$l]['Psg'];
				        $ukuran = $datax['sales'][$l]['Uk'];
				        $cekDb2 = $this->rpp_rpk_adm->cekDataganda2($idSales,$art,$pasang,$ukuran,$market);
				        if($cekDb2->num_rows() == 0){ // jika 0 maka insert
				        	$dataProduk = array(
				        		'Sls_id' 	=>  $datax['sales'][$l]['Sls_id'],
				        		'Art_id' 	=>  $datax['sales'][$l]['Art_id'],
				        		'RetPrc'	=>  $datax['sales'][$l]['RetPrc'],
				        		'Psg' 		=>  $datax['sales'][$l]['Psg'],
				        		'Uk' 		=>  $datax['sales'][$l]['Uk'],
				        		'ur'		=>  $datax['sales'][$l]['ur'],
				        		'ket'		=>  $datax['sales'][$l]['ket'],
				            );
				            $this->rpp_rpk_adm->sendSalesproduk($dataProduk,$market);
				            //print_r($dataProduk)."<br><br>";
				        }
			          }
			        }

			        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Berhasil mengirim data sales ke server POS '.$market.' (local) ');
			        $this->session->set_flashdata('success', 'Sinkron Data Semua Marketplace dari starsstore ke server POS '.$market.' (local) Berhasil '); // $market
					redirect($this->agent->referrer());

	        	//}else{
	        	//	$this->session->set_flashdata('error', 'Sinkron Data tidak bisa semua marketplace sekaligus, harus 1 marketplace.');
				//	redirect($this->agent->referrer());
	        	//}

        	}

        }else{	

        	$this->data['tgl1'] = $tgl1;
        	$this->data['tgl2'] = $tgl2;

// INIALISASAI $MARKET, $STATUS1, $STATUS2

        	// $MARKET DI BEDA2KAN
        	//$list_market = $this->rpp_rpk_adm->get_marketplace();
        	if($market1 != "semua"){
        		$market = $market1;
        		$market_title = $market1;
        	}else{
        		foreach($list_market as $hx){
		        	// load data marketplace
		        	$mrx[] = $hx->val_market;
		        }
	    		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
	    		$market_title = "Semua Marketplace";
        	}
	        $this->data['market'] = $market_title;
	        // $STATUS1
        	$this->data['status1'] = "Bayar";
        	$this->data['status1x'] = "bayar";
        	$status1 = array('bayar');
	        // $STATUS2
	        $status2 = array('ScUuses8625(62427^#&9531(73');
	        $this->data['status2'] = "Diterima";
	        $this->data['status2x'] = "ScUuses8625(62427^#&9531(73";

// PERTELAAN BARANG MASUK & KELUAR
	        // market bisa diganti dengan kode edp toko 
	        if($market == "E-commerce"){
	        	$kodeEdptoko = "10001";
	        }else if($market == "shopee"){
	        	$kodeEdptoko = "10006";
	        }else if($market == "tokopedia"){
	        	$kodeEdptoko = "10007";
	        }else if($market == "lazada"){
	        	$kodeEdptoko = "10008";
	        }else if($market == "blibli"){
	        	$kodeEdptoko = "10009";
	        }else if($market == "bukalapak"){
	        	$kodeEdptoko = "10010";
	        }
	        $this->data['closing_inout'] = $this->rpp_rpk_adm->get_laporan_by_tgl($tgl1, $tgl2, $kodeEdptoko);

// BARANG TERJUAL 

        	$this->data['terjual'] = $this->rpp_rpk_adm->stok_penjualan_by_tgl_selesai_order($tgl1, $tgl2, $status1, $status2, $market);
        	$this->data['terjual_by'] = "tgl_selesai_order";

        	// NEW GRAFIK PRODUK BEST SELLER DAN MARKETPLACE
        	$this->data['produk_best_seller_bulan_ini'] = $this->rpp_rpk_adm->produk_bestseller_bulan_ini($tgl1, $tgl2, $status1, $status2, $market);

			//TIDAK DIPAKAI KARENA SUDAH DIWAKILI PEND 12 BULAN // PENDINGAN PENJUALAN DARI BULAN INI UNTUK BULAN DEPAN(MERAH) 
			//$this->data['pendingan'] = $this->rpp_rpk_adm->pendingan_dibulan_yang_sama($tgl1, $tgl2, $market);
			//TIDAK DIPAKAI KARENA SUDAH DIWAKILI PEND 12 BULAN // PENDINGAN PENJUALAN DARI BULAN INI UNTUK BULAN DEPAN(MERAH) 
			$pnjsamex = $this->rpp_rpk_adm->pendingan_dibulan_yang_sama($tgl1, $tgl2, $market);
			$pnjpendingblnini = 0;
			foreach($pnjsamex as $pnjxx){
				$pnjpendingblnini += $pnjxx->qty;
			}
			$this->data['totalpendinganbulanini'] = $pnjpendingblnini;
			// PENDINGAN PENJUALAN DARI BULAN LALU (MAKS CEK 1 TAHUN KEBELAKANG) YANG MASIH BELUM SELESAI JUGA (MERAH)
			$this->data['pendingan_1_tahun_kebelakang'] = $this->rpp_rpk_adm->pendingan_dibulan_lalu_maks_1_tahun_cek($tgl1, $tgl2, $market);
			$pnjlast = $this->rpp_rpk_adm->pendingan_dibulan_lalu_maks_1_tahun_cek($tgl1, $tgl2, $market);
			$pnjpendingblnlalu = 0;
			foreach($pnjlast as $pnjx1){
				$pnjpendingblnlalu += $pnjx1->qty;
			}
			$this->data['totalpendinganbulanlalu'] = $pnjpendingblnlalu;
        	// cek dulu apakah sudah ada periode ini di database penjualan_fix, jika ada, keluarkan penjualan fix yang sudah dihitung dan juga biaya2 marketplace
        	$periode = "".date('d F Y', strtotime($tgl1)) ." - ". date('d F Y', strtotime($tgl2))."";
        	$cek = $this->rpp_rpk_adm->cek_penjualan_fix($periode);
        	$this->data['periode'] = $cek;
        	// groupkan toko yang mendapat komisi
        	$this->data['storegroupkomisi'] = $this->rpp_rpk_adm->group_store_komisi($tgl1, $tgl2, $status1, $status2, $market);

// RETUR 
        	$this->data['laporan_retur'] = $this->rpp_rpk_adm->get_data_retur($tgl1, $tgl2);
			$this->data['produk_retur'] = $this->rpp_rpk_adm->get_data_produk_retur($tgl1, $tgl2);
			$ditanggung = array('toko','dari_penjualan'); // filter dikunci untuk laporan pengiriman
			$this->data['laporan_pengiriman'] = $this->rpp_rpk_adm->get_data_laporan_pengiriman($tgl1, $tgl2, $status1, $status2, $market, $ditanggung);

// CETAK BUKTI BIAYA

        	// Inialisasi bulan dan tahun
        	$thn = date('Y', strtotime($tgl1));
        	$blnx = date('m', strtotime($tgl1));
        	if($blnx == 1){ $bln = "Januari"; }else if($blnx == 2){ $bln = "Februari"; }else if($blnx == 3){ $bln = "Maret"; }else if($blnx == 4){ $bln = "April"; }else if($blnx == 5){ $bln = "Mei"; }else if($blnx == 6){ $bln = "Juni"; }else if($blnx == 7){ $bln = "Juli"; }else if($blnx == 8){ $bln = "Agustus"; }else if($blnx == 9){ $bln = "September"; }else if($blnx == 10){ $bln = "Oktober"; }else if($blnx == 11){ $bln = "November"; }else if($blnx == 12){ $bln = "Desember"; 
        	}

        	$bulancls = $bln.' '.$thn;
        	$cek1x = $this->rpp_rpk_adm->cek_closing_biaya($bulancls);
        	
    		$tx = $cek1x->row_array();
    		$this->data['total_biaya'] = $tx['turn_over'];     

    		// Komisi Toko berdasarkan toko
    		$this->data['getStore'] = $this->rpp_rpk_adm->get_store_for_comission($tgl1, $tgl2, $status1, $status2, $market);

    		//$getOrder = $this->rpp_rpk_adm->get_order_for_comission($tgl1, $tgl2, $market);

// CETAK BUKTI TRANSER

        	$cek2x = $this->rpp_rpk_adm->cek_closing_transfer($bulancls);
    		$txx = $cek2x->row_array();
    		$this->data['total_transfer'] = $txx['turn_over'];     

// CETAK CLOSING

			//$this->load->library('dompdf_gen');
			// TAMPILKAN DISATU VIEW
			$this->load->view('manage/laporan/rpp_rpk/closing_all_laporan', $this->data);
	        //$paper_size  = 'A4'; //paper size
	        //$orientation = 'potrait'; //tipe format kertas
	        //$html = $this->output->get_output();
	        //$this->dompdf->set_paper($paper_size, $orientation);
	        //Convert to PDF
	        //$this->dompdf->load_html($html);
	        //$this->dompdf->render();
	        //$this->dompdf->stream("Closing ".date('d F Y', strtotime($tgl1))." - ".date('d F Y', strtotime($tgl2)).".pdf", array('Attachment'=>0));
	        //exit(0); 

        } 
	}

	function asjhf72mutation(){
		$id1_filtering = $this->security->xss_clean($this->input->post('id1'));
        $id1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id1_filtering);

        $id2_filtering = $this->security->xss_clean($this->input->post('id2'));
        $id2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id2_filtering);

        //panggil protected function
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
		$iv_size = mcrypt_enc_get_iv_size($cipher);
		// Encrypt ID1
		if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
		{
			$encrypt_id1 = mcrypt_generic($cipher, "achammad2102");
			mcrypt_generic_deinit($cipher);
		}

		// Encrypt ID2
		if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
		{
			$encrypt_id2 = mcrypt_generic($cipher, "danny2102");
			mcrypt_generic_deinit($cipher);
		}

		print_r(bin2hex($encrypt_id1).'|||'.bin2hex($encrypt_id2));

		// Decrypt ID
		if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
		{
			$decrypted = mdecrypt_generic($cipher, $encrypt_id2);
			mcrypt_generic_deinit($cipher);
		}

        if(bin2hex($encrypt_id1) == "767a2e5d459305c6aec15924c06fa0cf54b2e96f8094f7b2d719a7dee10851d5" && bin2hex($encrypt_id2) == "436374843a510177f5c241cf750011f51f31e060c77429d641d50267e6684d44"){
            $jDataOption['dOption']    		= "nHuisdru34urh8^^45623ifjdjxc2304-e2efhczGy";
            $jDataOption['generic_key_one']	= $encrypt_id1;
            $jDataOption['generic_key_two']	= $encrypt_id2;
            $this->session->set_userdata($jDataOption);

            $this->session->set_flashdata('success', 'Verifikasi berhasil');
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Verifikasi Mutasi Berhasil');
			redirect($this->agent->referrer());
        }else{
        	$this->session->set_flashdata('error', 'Verifikasi gagal');
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Verifikasi Mutasi');
			redirect($this->agent->referrer());
        }
	}

	function cekmutation(){

		 //panggil protected function
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
		$iv_size = mcrypt_enc_get_iv_size($cipher);

		// Decrypt ID1
		if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
		{
			$p1 = mdecrypt_generic($cipher, $this->session->userdata('generic_key_one'));
			mcrypt_generic_deinit($cipher);
		}

		// Decrypt ID2
		if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
		{
			$p2 = mdecrypt_generic($cipher, $this->session->userdata('generic_key_two'));
			mcrypt_generic_deinit($cipher);
		}

		$tgl1_filtering = $this->security->xss_clean($this->input->post('tgl1'));
        $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1_filtering);

        $tgl2_filtering = $this->security->xss_clean($this->input->post('tgl2'));
        $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2_filtering);      
        
        //$config = 	[
		//	            'credential' => 
		//	            [
		//	                'username' => $p1,
		//	                'password' => $p2
		//	            ],
		//	            'nomor_rekening' => '0423596591',
		//	            'range' => 
		//	            [
		//	            	'date_start'  	=> date('d-M-Y',strtotime($tgl1)),
		//	                'date_end' 		=> date('d-M-Y',strtotime($tgl2))
		//	            ],
	    //			];
	    //$this->load->library('Mtransc', $config);
	    
	    //$bni = $this->mtransc-($config);
		//var_dump($bni->toArray());		
	    $data['p1'] = $p1;
	    $data['p2'] = $p2;
		$data['tgl1'] = $tgl1;
		$data['tgl2'] = $tgl2;
		//$this->load->view('manage/header');
	    $this->load->view('manage/laporan/rpp_rpk/mutation',$data);
	    //$this->load->view('manage/footer');
	}

	function pesanan_pending(){
		$data['pendingan'] = $this->rpp_rpk_adm->list_pendingan();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/rpp_rpk/list_pendingan', $data);
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman RPP / RPK');
	}

	function off($id){ // off status produk
		$this->rpp_rpk_adm->off_produk($id);
		$this->session->set_flashdata('error', 'Produk dinonaktifkan!');
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menonaktifkan ID Produk ('.$id.')');
		redirect('trueaccon2194/produk');
	}

	function on($id){ // on status produk 
		$this->rpp_rpk_adm->on_produk($id);
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Mengaktifkan ID Produk ('.$id.')');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Produk diaktifkan!');
		redirect('trueaccon2194/produk');
	}

	function buat_rpp_rpk(){ //load semua data yang ditampilkan pada form tambah produk
		
		$btn_filtering = $this->security->xss_clean($this->input->post('laporan'));
        $btn = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$btn_filtering);

        //$this->data['spbl'] = $this->rpp_rpk_adm->stok_penjualan_bulan_lalu();
		$tgl1_filtering = $this->security->xss_clean($this->input->post('tgl1'));
        $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1_filtering);

        $this->data['tgl1'] = $tgl1;

        $tgl2_filtering = $this->security->xss_clean($this->input->post('tgl2'));
        $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2_filtering);

        $this->data['tgl2'] = $tgl2;

        $market_filtering = $this->security->xss_clean($this->input->post('marketplace'));
        $market1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$market_filtering);

        $status_filtering = $this->security->xss_clean($this->input->post('status_bayar'));
        $status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$status_filtering);

        $status22_filtering = $this->security->xss_clean($this->input->post('status_pesanan'));
        $status22 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$status22_filtering);
 
        $sortby2_filtering = $this->security->xss_clean($this->input->post('sortby'));
        $sortby = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$sortby2_filtering);

        $list_market = $this->onlinestore_adm->get_marketplace();
        foreach($list_market as $hx){
        	// load data marketplace
        	$mrx[] = $hx->val_market;
        }
       
       	if($btn == "detail_barang_terjual"){

       		// cek kolom required 
       		if($tgl1 == "" || $tgl2 == "" || $market1 == "" || $status == "" || $status22 == "" || $sortby == ""){
       			$this->session->set_flashdata('error', 'Isi kolom dengan lengkap!');
       			redirect($this->agent->referrer());
       		}
        	
        	if($market1 == "semua"){
        		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
        		$market_title = "Semua Marketplace";
	        }else{
	        	$market = $market1;
	        	$market_title = $market1;
	        }
	        $this->data['market'] = $market_title;

	        if($status22 == "semua"){

	        	$status2 = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73', 'batal');
	        	$this->data['status2'] = "Semua";

	        }else{
	        	$status2 = $status22;
	        	if($status2 == "2hd8jPl613!2_^5"){
	        		$this->data['status2'] = "Menunggu Pembayaran";
	        	}else if($status2 == "*^56t38H53gbb^%$0-_-"){
	        		$this->data['status2'] = "Pembayaran Diterima";
	        	}else if($status2 == "Uywy%u3bShi)payDhal"){
	        		$this->data['status2'] = "Dalam Pengiriman";
	        	}else if($status2 == "ScUuses8625(62427^#&9531(73"){
	        		$this->data['status2'] = "Diterima";
	        	}else if($status2 == "batal"){ 
	        		$this->data['status2'] = "Dibatalkan";
	        	}
	        }

	         if($status == "semua"){
	        	$this->data['status1'] = "Semua";
	        	$status1 = array('bayar', 'belum');
	        }else{
	        	$status1 = $status;
	        	if($status == "bayar"){
		        	$this->data['status1'] = $status;
		        }else if($status == "belum"){
		        	$this->data['status1'] = $status;
		        } 
	        }

	        if($sortby == "tgl_order"){
	        	$this->data['terjual'] = $this->rpp_rpk_adm->stok_penjualan_by_tgl_order($tgl1, $tgl2, $status1, $status2, $market);
	        	$this->data['terjual_by'] = "tgl_order";
	        }else{
	        	$this->data['terjual'] = $this->rpp_rpk_adm->stok_penjualan_by_tgl_selesai_order($tgl1, $tgl2, $status1, $status2, $market);
	        	$this->data['terjual_by'] = "tgl_selesai_order";
	        }

//TIDAK DIPAKAI KARENA SUDAH DIWAKILI PEND 12 BULAN // PENDINGAN PENJUALAN DARI BULAN INI UNTUK BULAN DEPAN(MERAH) 
			$this->data['pendingan'] = $this->rpp_rpk_adm->pendingan_dibulan_yang_sama($tgl1, $tgl2, $market);
			$pnjsamex = $this->rpp_rpk_adm->pendingan_dibulan_yang_sama($tgl1, $tgl2, $market);
			$pnjpendingblnini = 0;
			foreach($pnjsamex as $pnjxx){
				$pnjpendingblnini += $pnjxx->qty;
			}
			$this->data['totalpendinganbulanini'] = $pnjpendingblnini;

			// PENDINGAN PENJUALAN DARI BULAN LALU (MAKS CEK 1 TAHUN KEBELAKANG) YANG MASIH BELUM SELESAI JUGA (MERAH)
			$this->data['pendingan_1_tahun_kebelakang'] = $this->rpp_rpk_adm->pendingan_dibulan_lalu_maks_1_tahun_cek($tgl1, $tgl2, $market);
			$pnjlast = $this->rpp_rpk_adm->pendingan_dibulan_lalu_maks_1_tahun_cek($tgl1, $tgl2, $market);
			$pnjpendingblnlalu = 0;
			foreach($pnjlast as $pnjx1){
				$pnjpendingblnlalu += $pnjx1->qty;
			}
			$this->data['totalpendinganbulanlalu'] = $pnjpendingblnlalu;
        	
        	// cek dulu apakah sudah ada periode ini di database penjualan_fix, jika ada, keluarkan penjualan fix yang sudah dihitung dan juga biaya2 marketplace
        	$periode = "".date('d F Y', strtotime($tgl1)) ." - ". date('d F Y', strtotime($tgl2))."";
        	$cek = $this->rpp_rpk_adm->cek_penjualan_fix($periode);
        	$this->data['periode'] = $cek;

        	// groupkan toko yang mendapat komisi
        	$this->data['storegroupkomisi'] = $this->rpp_rpk_adm->group_store_komisi($tgl1, $tgl2, $status1, $status2, $market);

        	//cetak laporan
			//$this->load->library('dompdf_gen');
			$this->load->view('manage/laporan/rpp_rpk/barang_terjual', $this->data);
	        //$paper_size  = 'A4'; //paper size
	        //$orientation = 'landscape'; //tipe format kertas
	        //$html = $this->output->get_output();
	 
	        //$this->dompdf->set_paper($paper_size, $orientation);
	        //Convert to PDF
	        //$this->dompdf->load_html($html);
	        //$this->dompdf->render();
	        //$this->dompdf->stream("Laporan-penjualan.pdf", array('Attachment'=>0));
	        //exit(0);

        }else if($btn == "cetak_cover_biaya"){
        	
        	$periode = "".date('d F Y', strtotime($tgl1)) ." - ". date('d F Y', strtotime($tgl2))."";
        	$cek = $this->rpp_rpk_adm->cek_penjualan_fix($periode);
        	$this->data['periode'] = $cek;
        	$this->load->view('manage/laporan/rpp_rpk/cover_biaya', $this->data);

        }else if($btn == "cetak_ist_toko_daripenjualan"){
        	if($market1 == "semua"){
        		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
        		$market_title = "Semua Marketplace";
        		$this->data['market'] = $market_title;
        		$this->data['marketx'] = $market;
	        }else{
	        	$market = $market1;
	        	$market_title = $market1;
	        	$this->data['market'] = $market_title;
	        	$this->data['marketx'] = $market;
	        }

	        if($status22 == "semua"){

	        	$status2 = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73', 'batal');
	        	$this->data['status2'] = "Semua";
	        	$status2x = "Semua";
	        }else{
	        	$status2 = $status22;
	        	if($status2 == "2hd8jPl613!2_^5"){
	        		$this->data['status2'] = "Menunggu Pembayaran";
	        		$status2x = "Menunggu Pembayaran";
	        	}else if($status2 == "*^56t38H53gbb^%$0-_-"){
	        		$this->data['status2'] = "Pembayaran Diterima";
	        		$status2x = "Pembayaran Diterima";
	        	}else if($status2 == "Uywy%u3bShi)payDhal"){
	        		$this->data['status2'] = "Dalam Pengiriman";
	        		$status2x = "Dalam Pengiriman";
	        	}else if($status2 == "ScUuses8625(62427^#&9531(73"){
	        		$this->data['status2'] = "Diterima";
	        		$status2x = "Diterima";
	        	}else if($status2 == "batal"){ 
	        		$this->data['status2'] = "Dibatalkan";
	        		$status2x = "Dibatalkan";
	        	}
	        }

	         if($status == "semua"){
	        	$this->data['status1'] = "Semua";
	        	$status1 = array('bayar', 'belum');
	        }else{
	        	$status1 = $status;
	        	if($status == "bayar"){
		        	$this->data['status1'] = $status;
		        }else if($status == "belum"){
		        	$this->data['status1'] = $status;
		        } 
	        }

	        // kalau di rpp rpk global toko. kalau di menu list order marketplace bisa spesifik tokonya
	       	$this->data['sender'] = "Semua Toko"; 

        	// Komisi Toko berdasarkan toko (data penjualan by toko untuk dijadikan laporan IST toko)
        	
    		//$this->load->view('manage/laporan/rpp_rpk/laporan_ist_toko', $this->data);

    		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

			$objPHPExcel = new PHPExcel();
			// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		    $style_col = array(
		      'font' => array('bold' => true), // Set font nya jadi bold
		      'alignment' => array(
		        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		      ),
		      'borders' => array(
		        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		      )
		    );
		    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		    $style_row = array(
		      'alignment' => array(
		      	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		      ),
		      'borders' => array(
		        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		      )
		    );

	    	// Create a first sheet, representing sales data
			$objPHPExcel->setActiveSheetIndex(0);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN IST TOKO (E-COMMERCE)"); // Set kolom A1 dengan tulisan "DATA SISWA"
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('DAFTAR IST TOKO');

		    $objPHPExcel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai E1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
	    	
		    // buat informasi apa yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('A3','Tanggal');
		    $objPHPExcel->getActiveSheet()->setCellValue('A4','Marketplace');
		    $objPHPExcel->getActiveSheet()->setCellValue('A5','Status Pesanan');
		    $objPHPExcel->getActiveSheet()->setCellValue('A6','Status Bayar');
		    $objPHPExcel->getActiveSheet()->setCellValue('A7','Sort By');
		    // tampilkan hasil informasi yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('B3',"".date('d/m/Y',strtotime($tgl1))."-".date('d/m/Y',strtotime($tgl2))."");
		    $objPHPExcel->getActiveSheet()->setCellValue('B4',$market_title);
		    $objPHPExcel->getActiveSheet()->setCellValue('B5',$status2x);
		    $objPHPExcel->getActiveSheet()->setCellValue('B6',$status);
		    $objPHPExcel->getActiveSheet()->setCellValue('B7',$sortby);

			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
			$heading = array("No","Tanggal Order","Invoice","Marketplace","Kode EDP Marketplace","Nama Toko","Kode EDP toko","Artikel","Size","Pasang","Harga Barang","Harga Barang x Pasang");
	        //loop heading
	        $rowNumberH = 9;
		    $colH = 'A';
		    foreach($heading as $h){
		        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
		        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
		        $colH++;    
		    }

		    if($sortby == "tgl_order"){
	        	$terjual = $this->rpp_rpk_adm->get_order_for_comission_by_tgl_orderx($tgl1, $tgl2, $status1, $status2, $market);
	        }else{
	        	$terjual = $this->rpp_rpk_adm->get_order_for_comission_by_tgl_selesai_orderx($tgl1, $tgl2, $status1, $status2, $market);
	        }

			$no = 0;
		    $baris = 10;
		    foreach($terjual as $data){
		    	$no++;

		    	if($data->harga_before == "" || $data->harga_before == 0){
		        	$harga_before = "";//$data->harga_fix;
		        	$harga_net = $data->harga_fix;
		        	$diskon = 0;
		        	$diskonrupiah = 0;

		        }else{
		        	$harga_before = $data->harga_before;
		        	$harga_net = $data->harga_fix;
		        	$diskon = round(($data->harga_before - $data->harga_fix) / $data->harga_before * 100)*$data->qty;
		        	$diskonrupiah = ($data->harga_before-$data->harga_fix)*$data->qty;
		        }

		        // STATUS
		        if($data->status == "2hd8jPl613!2_^5"){
	        		$statusp = "Menunggu Pembayaran";
	        	}else if($data->status == "*^56t38H53gbb^%$0-_-"){
	        		$statusp = "Pembayaran Diterima";
	        	}else if($data->status == "Uywy%u3bShi)payDhal"){
	        		$statusp = "Dalam Pengiriman";
	        	}else if($data->status == "ScUuses8625(62427^#&9531(73"){
	        		$statusp = "Diterima";
	        	}else if($data->status == "batal"){ 
	        		$statusp = "Dibatalkan";
	        	}

		        if($sortby == "tgl_order"){
		        	$tgl_order = date('d/m/Y',strtotime($data->tanggal_order));
		        }else{
		        	$tgl_order = date('d/m/Y',strtotime($data->tanggal_order_finish));
		        }

		        if($data->buy_in == "E-commerce" || $data->buy_in == "instagram"){
		        	$kodeEdptoko = "10001";
		        }else if($data->buy_in == "shopee"){
		        	$kodeEdptoko = "10006";
		        }else if($data->buy_in == "tokopedia"){
		        	$kodeEdptoko = "10007";
		        }else if($data->buy_in == "lazada"){
		        	$kodeEdptoko = "10008";
		        }else if($data->buy_in == "blibli"){
		        	$kodeEdptoko = "10009";
		        }else if($data->buy_in == "bukalapak"){
		        	$kodeEdptoko = "10010";
		        }

		        $heading = array("No","Tanggal Order","Invoice","Marketplace","Kode EDP Marketplace","Nama Toko","Kode EDP toko","Artikel","Size","Pasang","Harga Barang","Harga Barang x Pasang");

		        //pemanggilan sesuaikan dengan nama kolom tabel
		        $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $no); // NAMA PRODUK
		        $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $tgl_order); // INVOICE
		        $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $data->invoice); // STATUS
		        $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $data->buy_in); // ARTIKEL
		        $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $kodeEdptoko); // HARGA RETAIL / SEBELUM DISKON
		        $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $data->nama_toko); // HARGA RETAIL / SEBELUM DISKON
		        $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, $data->sender); // HARGA RETAIL / SEBELUM DISKON
		        $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, strtoupper($data->artikel)); // buy_in
		        $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, $data->ukuran); // divisi
		        $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, $data->qty); // merk
		        $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, $harga_net); // qty
		        $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, $harga_net*$data->qty); // ODV
		        //$objPHPExcel->getActiveSheet()->setCellValue("K".$baris, round(($harga_net*5)/100)*$data->qty); // komisi 5% x qty 

		        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		      	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
		      	$baris++;
		        
		        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
	      	}

	      	// Redirect output to a client’s web browser (Excel5)
			$filename = urlencode("REPORT_IST_TOKO_".$market_title."_".date('d-F-Y',strtotime($tgl1))."_-_".date('d-F-Y',strtotime($tgl2)).".xls");
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
	        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan IST toko (Excel) Marketplace '.$market_title.' Tanggal '.date('d-F-Y',strtotime($tgl1)).'-'.date('d-F-Y',strtotime($tgl2)).' ');

        }else if($btn == "cetak_komisi_toko_daripenjualan"){

        	if($market1 == "semua"){
        		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
        		$market_title = "Semua Marketplace";
        		$this->data['market'] = $market_title;
        		$this->data['marketx'] = $market;
	        }else{
	        	$market = $market1;
	        	$market_title = $market1;
	        	$this->data['market'] = $market_title;
	        	$this->data['marketx'] = $market;
	        }

	        if($status22 == "semua"){

	        	$status2 = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73', 'batal');
	        	$this->data['status2'] = "Semua";
	        	$status2x = "Semua";
	        }else{
	        	$status2 = $status22;
	        	if($status2 == "2hd8jPl613!2_^5"){
	        		$this->data['status2'] = "Menunggu Pembayaran";
	        		$status2x = "Menunggu Pembayaran";
	        	}else if($status2 == "*^56t38H53gbb^%$0-_-"){
	        		$this->data['status2'] = "Pembayaran Diterima";
	        		$status2x = "Pembayaran Diterima";
	        	}else if($status2 == "Uywy%u3bShi)payDhal"){
	        		$this->data['status2'] = "Dalam Pengiriman";
	        		$status2x = "Dalam Pengiriman";
	        	}else if($status2 == "ScUuses8625(62427^#&9531(73"){
	        		$this->data['status2'] = "Diterima";
	        		$status2x = "Diterima";
	        	}else if($status2 == "batal"){ 
	        		$this->data['status2'] = "Dibatalkan";
	        		$status2x = "Dibatalkan";
	        	}
	        }

	         if($status == "semua"){
	        	$this->data['status1'] = "Semua";
	        	$status1 = array('bayar', 'belum');
	        }else{
	        	$status1 = $status;
	        	if($status == "bayar"){
		        	$this->data['status1'] = $status;
		        }else if($status == "belum"){
		        	$this->data['status1'] = $status;
		        } 
	        }

	        // kalau di rpp rpk global toko. kalau di menu list order marketplace bisa spesifik tokonya
	       	$this->data['sender'] = "Semua Toko"; 

        	// Komisi Toko berdasarkan toko (data penjualan by toko untuk dijadikan laporan IST toko)
        	
    		//$this->load->view('manage/laporan/rpp_rpk/laporan_ist_toko', $this->data);

    		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

			$objPHPExcel = new PHPExcel();
			// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		    $style_col = array(
		      'font' => array('bold' => true), // Set font nya jadi bold
		      'alignment' => array(
		        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		      ),
		      'borders' => array(
		        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		      )
		    );
		    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		    $style_row = array(
		      'alignment' => array(
		      	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		      ),
		      'borders' => array(
		        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		      )
		    );

	    	// Create a first sheet, representing sales data
			$objPHPExcel->setActiveSheetIndex(0);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN KOMISI TOKO (E-COMMERCE)"); // Set kolom A1 dengan tulisan "DATA SISWA"
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('DAFTAR KOMISI TOKO');

		    $objPHPExcel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai E1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
	    	
		    // buat informasi apa yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('A3','Tanggal');
		    $objPHPExcel->getActiveSheet()->setCellValue('A4','Marketplace');
		    $objPHPExcel->getActiveSheet()->setCellValue('A5','Status Pesanan');
		    $objPHPExcel->getActiveSheet()->setCellValue('A6','Status Bayar');
		    $objPHPExcel->getActiveSheet()->setCellValue('A7','Sort By');
		    // tampilkan hasil informasi yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('B3',"".date('d/m/Y',strtotime($tgl1))."-".date('d/m/Y',strtotime($tgl2))."");
		    $objPHPExcel->getActiveSheet()->setCellValue('B4',$market_title);
		    $objPHPExcel->getActiveSheet()->setCellValue('B5',$status2x);
		    $objPHPExcel->getActiveSheet()->setCellValue('B6',$status);
		    $objPHPExcel->getActiveSheet()->setCellValue('B7',$sortby);

			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
			$heading = array("No","Tanggal Order","Invoice","Marketplace","Kode EDP Marketplace","Nama Toko","Kode EDP toko","Artikel","Size","Pasang","Harga Barang","Harga Barang x Pasang","Komisi Toko (5% per artikel)");
	        //loop heading
	        $rowNumberH = 9;
		    $colH = 'A';
		    foreach($heading as $h){
		        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
		        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
		        $colH++;    
		    }

		    //if($sortby == "tgl_order"){
	        //	$terjual = $this->rpp_rpk_adm->get_order_for_comission_by_tgl_orderx($tgl1, $tgl2, $status1, $status2, $market);
	        //}else{
	        //	$terjual = $this->rpp_rpk_adm->get_order_for_comission_by_tgl_selesai_orderx($tgl1, $tgl2, $status1, $status2, $market);
	        //}

	        if($sortby == "tgl_order"){
	        	$terjual = $this->rpp_rpk_adm->stok_penjualan_by_tgl_order($tgl1, $tgl2, $status1, $status2, $market);
	        }else{
	        	$terjual = $this->rpp_rpk_adm->stok_penjualan_by_tgl_selesai_order($tgl1, $tgl2, $status1, $status2, $market);
	        }

			$no = 0;
		    $baris = 10;
		    foreach($terjual as $data){
		    	$no++;

		    	if($data->harga_before == "" || $data->harga_before == 0){
		        	$harga_before = "";//$data->harga_fix;
		        	$harga_net = $data->harga_fix;
		        	$diskon = 0;
		        	$diskonrupiah = 0;

		        }else{
		        	$harga_before = $data->harga_before;
		        	$harga_net = $data->harga_fix;
		        	$diskon = round(($data->harga_before - $data->harga_fix) / $data->harga_before * 100)*$data->qty;
		        	$diskonrupiah = ($data->harga_before-$data->harga_fix)*$data->qty;
		        }

		        // STATUS
		        if($data->status == "2hd8jPl613!2_^5"){
	        		$statusp = "Menunggu Pembayaran";
	        	}else if($data->status == "*^56t38H53gbb^%$0-_-"){
	        		$statusp = "Pembayaran Diterima";
	        	}else if($data->status == "Uywy%u3bShi)payDhal"){
	        		$statusp = "Dalam Pengiriman";
	        	}else if($data->status == "ScUuses8625(62427^#&9531(73"){
	        		$statusp = "Diterima";
	        	}else if($data->status == "batal"){ 
	        		$statusp = "Dibatalkan";
	        	}

	        	if($sortby == "tgl_order"){
		        	$tgl_order = date('d/m/Y',strtotime($data->tanggal_order));
		        }else{
		        	$tgl_order = date('d/m/Y',strtotime($data->tanggal_order_finish));
		        }

		        if($data->buy_in == "E-commerce" || $data->buy_in == "instagram"){
		        	$kodeEdptoko = "10001";
		        }else if($data->buy_in == "shopee"){
		        	$kodeEdptoko = "10006";
		        }else if($data->buy_in == "tokopedia"){
		        	$kodeEdptoko = "10007";
		        }else if($data->buy_in == "lazada"){
		        	$kodeEdptoko = "10008";
		        }else if($data->buy_in == "blibli"){
		        	$kodeEdptoko = "10009";
		        }else if($data->buy_in == "bukalapak"){
		        	$kodeEdptoko = "10010";
		        }

		        //pemanggilan sesuaikan dengan nama kolom tabel
		        $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $no); // NAMA PRODUK
		        $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $tgl_order); // INVOICE
		        $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $data->invoice); // STATUS
		        $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $data->buy_in); // ARTIKEL
		        $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $kodeEdptoko); // HARGA RETAIL / SEBELUM DISKON
		        $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $data->nama_toko); // HARGA RETAIL / SEBELUM DISKON
		        $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, $data->sender); // HARGA RETAIL / SEBELUM DISKON
		        $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, strtoupper($data->artikel)); // buy_in
		        $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, $data->ukuran); // divisi
		        $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, $data->qty); // merk
		        $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, $harga_net); // qty
		        $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, $harga_net*$data->qty); // ODV
		        $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, round(($harga_net*5)/100*$data->qty)); // komisi 5% x qty 

		        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		      	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
		      	$baris++;
		        
		        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
	      	}

	      	// Redirect output to a client’s web browser (Excel5)
			$filename = urlencode("REPORT_KOMISI_TOKO_".$market_title."_".date('d-F-Y',strtotime($tgl1))."_-_".date('d-F-Y',strtotime($tgl2)).".xls");
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
	        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Komisi toko (Excel) Marketplace '.$market_title.' Tanggal '.date('d-F-Y',strtotime($tgl1)).'-'.date('d-F-Y',strtotime($tgl2)).' ');

        }else if($btn == "export_excel_laporan"){

        	if($market1 == "semua"){
        		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
        		$market_title = "Semua Marketplace";
	        }else{
	        	$market = $market1;
	        	$market_title = $market1;
	        }

	        $this->data['market'] = $market_title;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        if($status22 == "semua"){

	        	$status2 = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73', 'batal');
	        	$this->data['status2'] = "Semua";
	        	$status2x = "Semua";
	        }else{
	        	$status2 = $status22;
	        	if($status2 == "2hd8jPl613!2_^5"){
	        		$this->data['status2'] = "Menunggu Pembayaran";
	        		$status2x = "Menunggu Pembayaran";
	        	}else if($status2 == "*^56t38H53gbb^%$0-_-"){
	        		$this->data['status2'] = "Pembayaran Diterima";
	        		$status2x = "Pembayaran Diterima";
	        	}else if($status2 == "Uywy%u3bShi)payDhal"){
	        		$this->data['status2'] = "Dalam Pengiriman";
	        		$status2x = "Dalam Pengiriman";
	        	}else if($status2 == "ScUuses8625(62427^#&9531(73"){
	        		$this->data['status2'] = "Diterima";
	        		$status2x = "Diterima";
	        	}else if($status2 == "batal"){ 
	        		$this->data['status2'] = "Dibatalkan";
	        		$status2x = "Dibatalkan";
	        	}
	        }

	         if($status == "semua"){
	        	$this->data['status1'] = "Semua";
	        	$status1 = array('bayar', 'belum');
	        }else{
	        	$status1 = $status;
	        	if($status == "bayar"){
		        	$this->data['status1'] = $status;
		        }else if($status == "belum"){
		        	$this->data['status1'] = $status;
		        } 
	        }

	        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

			$objPHPExcel = new PHPExcel();
			// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		    $style_col = array(
		      'font' => array('bold' => true), // Set font nya jadi bold
		      'alignment' => array(
		        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		      ),
		      'borders' => array(
		        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		      )
		    );
		    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		    $style_row = array(
		      'alignment' => array(
		      	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		      ),
		      'borders' => array(
		        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		      )
		    );

	    	// Create a first sheet, representing sales data
			$objPHPExcel->setActiveSheetIndex(0);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP PENJUALAN E-COMMERCE & MARKETPLACE"); // Set kolom A1 dengan tulisan "DATA SISWA"
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('REKAP PENJUALAN');

		    $objPHPExcel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai E1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
	    	
		    // buat informasi apa yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('A3','Tanggal');
		    $objPHPExcel->getActiveSheet()->setCellValue('A4','Marketplace');
		    $objPHPExcel->getActiveSheet()->setCellValue('A5','Status Pesanan');
		    $objPHPExcel->getActiveSheet()->setCellValue('A6','Status Bayar');
		    $objPHPExcel->getActiveSheet()->setCellValue('A7','Sort By');
		    // tampilkan hasil informasi yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('B3',"".date('d/m/Y',strtotime($tgl1))."-".date('d/m/Y',strtotime($tgl2))."");
		    $objPHPExcel->getActiveSheet()->setCellValue('B4',$market_title);
		    $objPHPExcel->getActiveSheet()->setCellValue('B5',$status2x);
		    $objPHPExcel->getActiveSheet()->setCellValue('B6',$status);
		    $objPHPExcel->getActiveSheet()->setCellValue('B7',$sortby);

	    	//table header
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
			$heading = array("No","Invoice","Status Pesanan","Artikel","Nama Project","Marketplace","Divisi","Merk","Psg","Odv","Harga Sebelum Diskon","Harga Setelah Diskon","Harga Fix X Psg","Disc %","Disc RP","Komisi Toko 5%");
	        //loop heading
	        $rowNumberH = 8;
		    $colH = 'A';
		    foreach($heading as $h){
		        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
		        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
		        $colH++;    
		    }

			if($sortby == "tgl_order"){
	        	$terjual = $this->rpp_rpk_adm->get_order_for_comission_by_tgl_orderx($tgl1, $tgl2, $status1, $status2, $market);
	        }else{
	        	$terjual = $this->rpp_rpk_adm->get_order_for_comission_by_tgl_selesai_orderx($tgl1, $tgl2, $status1, $status2, $market);
	        }

			$no = 0;
		    $baris = 9;
		    foreach($terjual as $data){
		    	$no++;

		    	if($data->harga_before == "" || $data->harga_before == 0){
		        	$harga_before = "";//$data->harga_fix;
		        	$harga_net = $data->harga_fix;
		        	$diskon = 0;
		        	$diskonrupiah = 0;

		        }else{
		        	$harga_before = $data->harga_before;
		        	$harga_net = $data->harga_fix;
		        	$diskon = round(($data->harga_before - $data->harga_fix) / $data->harga_before * 100)*$data->qty;
		        	$diskonrupiah = ($data->harga_before-$data->harga_fix)*$data->qty;
		        }

		        // STATUS
		        if($data->status == "2hd8jPl613!2_^5"){
	        		$statusp = "Menunggu Pembayaran";
	        	}else if($data->status == "*^56t38H53gbb^%$0-_-"){
	        		$statusp = "Pembayaran Diterima";
	        	}else if($data->status == "Uywy%u3bShi)payDhal"){
	        		$statusp = "Dalam Pengiriman";
	        	}else if($data->status == "ScUuses8625(62427^#&9531(73"){
	        		$statusp = "Diterima";
	        	}else if($data->status == "batal"){ 
	        		$statusp = "Dibatalkan";
	        	}


		        //pemanggilan sesuaikan dengan nama kolom tabel
		        $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $no); // NAMA PRODUK
		        $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $data->invoice); // INVOICE
		        $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $statusp); // STATUS
		        $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, strtoupper($data->artikel)); // ARTIKEL
		        $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $data->nama_produk); // HARGA RETAIL / SEBELUM DISKON
		        $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $data->buy_in); // buy_in
		        $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, strtoupper($data->divisi)); // divisi
		        $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, strtoupper($data->merk)); // merk
		        $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, $data->qty); // qty
		        $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, ""); // ODV
		        $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, $harga_before); // harga sebelum 
		        $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, $harga_net); // harga_net
		        $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, $harga_net*$data->qty); // harga_net X QTY
		        $objPHPExcel->getActiveSheet()->setCellValue("N".$baris, $diskon."%"); // DISKON
		        $objPHPExcel->getActiveSheet()->setCellValue("O".$baris, $diskonrupiah); // DISKON rupiah
		        $objPHPExcel->getActiveSheet()->setCellValue("P".$baris, round(($harga_net*5)/100*$data->qty)); // komisi 5% x qty //($harga_net*$data->qty)-$diskonrupiah); // DISKON

		        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		      	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
		      	$baris++;
		        
		        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true); 
			    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true); 
	      	}

	      	//$tgl1, $tgl2, $status1, $status2, $market);
	      	//echo $tgl1." ".$tgl2." ".$status1." ".$status2."

	      	// Redirect output to a client’s web browser (Excel5)
			$filename = urlencode("REPORT_PENJUALAN_".$market_title."_".date('d-F-Y',strtotime($tgl1))."-".date('d-F-Y',strtotime($tgl2)).".xls");
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
	        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Produk Terjual (Excel) Marketplace '.$market_title.' Tanggal '.date('d-F-Y',strtotime($tgl1)).'-'.date('d-F-Y',strtotime($tgl2)).' ');

        }else if($btn == "syncdbwithpos"){

// NEW SYNC STARSSTORE WITH DATABASE POS (ONLINE)        	

        	//if($market1 == "semua"){
        	//	$this->session->set_flashdata('error', 'Kirim Data Sales hanya bisa per marketplace');
      		//	redirect($this->agent->referrer());
	        //}else{
	        	$market = $market1; 
	        	$salesdate = $this->rpp_rpk_adm->getdbsalesdate($market,$tgl1,$tgl2);

		        foreach($salesdate as $d){

		        	// cek data ganda di database
		        	$idSales = $d->id;
		        	$cekDb = $this->rpp_rpk_adm->cekDataganda($idSales,$market);
		        	if($cekDb->num_rows() == 0){ // jika 0 maka insert
		        		$dataSales = array(
			        		'Sls_id' 	=> $d->id,
			        		'tgl' 		=> date("Y-m-d H:i:s", strtotime($d->tanggal_order_finish)),
			        		'us_id'		=> '01',
			        		'jns' 		=> 'S',
			        		'card' 		=> '',
			        		'kasir'		=> 0,
			        	);
			        	//print_r($dataSales)."<br><br>";
			        	$this->rpp_rpk_adm->sendSales($dataSales,$market);

			        	$no_order_cus = $d->no_order_cus;
			        	$salesproduk = $this->rpp_rpk_adm->getdbsalesproduk($no_order_cus);
			        	foreach($salesproduk as $p){
				        	$dataProduk = array(
				        		'Sls_id' 	=> $d->id,
				        		'Art_id' 	=> $p->artikel,
				        		'RetPrc'	=> $p->harga_fix,
				        		'Psg' 		=> $p->qty,
				        		'Uk' 		=> $p->ukuran,
				        		'ur'		=> 1,
				        		'ket'		=> 0,
				        	);
				        	//print_r($dataProduk);
				        	$this->rpp_rpk_adm->sendSalesproduk($dataProduk,$market);
				        }
		        	}
		        }
		        $this->session->set_flashdata('success', 'Data telah disinkron ke database POS Cloud (online)'); //$market
      			redirect($this->agent->referrer());
	        //}

        }else if($btn == "generate_rpp_rpk"){

        	if($market1 == "semua"){
        		$market = $mrx;//array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
        		$market_title = "Semua Marketplace";
	        }else{
	        	$market = $market1;
	        	$market_title = $market1;
	        }
	        
	        $this->data['market'] = $market_title;
	        $this->data['markett'] = $market1;
	        $this->data['tgl1'] = $tgl1;
	        $this->data['tgl2'] = $tgl2;

	        if($status == "semua"){
	        	$this->data['status1'] = "Semua";
	        	$status1 = array('bayar', 'belum');
	        }else{
	        	$this->data['status1'] = $status;
	        	$status1 = $status;
	        }

	        if($status22 == "semua"){
	        	$this->data['status2'] = "Semua";
	        	$status2 = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73', 'batal');
	        }else{
	        	$status2 = $status22;
	        	if($status2 = "2hd8jPl613!2_^5"){
	        		$this->data['status2'] = "Menunggu Pembayaran";
	        	}else if($status2 = "*^56t38H53gbb^%$0-_-"){
	        		$this->data['status2'] = "Pembayaran Diterima";
	        	}else if($status2 = "Uywy%u3bShi)payDhal"){
	        		$this->data['status2'] = "Dalam Pengiriman";
	        	}else if($status2 = "ScUuses8625(62427^#&9531(73"){
	        		$this->data['status2'] = "Diterima"; 
	        	}else if($status2 = "batal"){ 
	        		$this->data['status2'] = "Dibatalkan";
	        	}
	        }

	        // STOK BULAN LALU
	        $stk = $this->rpp_rpk_adm->stok_bln_lalu();
	        $this->data['stok_bln_lalu'] = 0;
	        $this->data['rupiah_stk_bln_lalu'] = 0;
	        foreach($stk as $t){
	        	$this->data['stok_bln_lalu'] 		= $t->stok;
	        	$this->data['rupiah_stk_bln_lalu']	= $t->rp_stok;
	        }

	        // penjualan by tanggal
			$qa = $this->rpp_rpk_adm->stok_penjualan_bulan_lalu($tgl1, $tgl2, $market);
			$this->data['total_qty']	= 0;
			$this->data['total_rupiah'] = 0;
			$this->data['total_rupiah_diskon'] = 0;
			$this->data['komisi_spv'] = 0;
			$this->data['komisi_pram'] = 0;
			foreach($qa as $v){
				//if($v->buy_in == "lazada"){
				//	$biaya_lazada = $v->qty * $v->harga_fix * 1.804 / 100; 
				//	$vat_lazada = $v->qty * $v->harga_fix * 0.164 / 100;
				//	$vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
				//}else{
				//	$biaya_lazada = 0;
				//	$vat_lazada = 0; 
				//	$vat_pencairan = 0;
				//}
				if($v->harga_before != "" || $v->harga_before > 0){
	            	$diskon = ($v->harga_before-$v->harga_fix) * $v->qty;
	            }else{ 
	               	$diskon = "0";
	            }

	            // harga acuan baru 
	            if($v->harga_before == 0 || $v->harga_before == ""){
	            	
	            	$hg_fix = $v->harga_fix;

	            }else if($v->harga_before != "" || $v->harga_before > 0 ){
 
	            	$hg_fix = $v->harga_before;

	            }

	            //**** BARU ****//
			

                if($v->komisi_toko == ""){
                    //$komisi1 = (($v->harga_fix*3)/100) + (($v->harga_fix*1)/100);
                    $_komisi_pramuniaga = round($v->harga_fix * 4 / 100);
                    $_komisi_spv = round($v->harga_fix * 1 / 100); 
               	}else{
                	//$komisi1 = round($v->komisi_toko);
                	$_komisi_pramuniaga = round($v->komisi_toko);
                	$_komisi_spv = round($v->komisi_toko);
                }

				$this->data['total_qty']	  		+= $v->qty;
				$this->data['total_rupiah'] 		+= ($hg_fix*$v->qty)-$diskon;//-$_komisi_spv-$_komisi_pramuniaga;//-($biaya_lazada+$vat_lazada+$vat_pencairan); // SEBELUM DIKURANGI DISKON
				$this->data['total_rupiah_diskon'] 	+= $diskon;// + ($biaya_lazada+$vat_lazada+$vat_pencairan);

				// KOMISI SPV //
	        	$this->data['komisi_spv'] += $_komisi_spv*$v->qty; 
				// KOMISI PRAMUNIAGA
				$this->data['komisi_pram'] += $_komisi_pramuniaga*$v->qty;
			}
			// ACUAN BARU TOTAL RUPIAH TOTAL BARANG SETELAH DISKON
        	//$cek_rp = $this->rpp_rpk_adm->cek_penjualan_fix_ambil_rupiah();
			//$this->data['total_rupiah'] = $cek_rp['penjualan_fix'];

			// BARANG MASUK & KELUAR by tanggal
			$xa = $this->rpp_rpk_adm->barang_masuk_keluar($tgl1, $tgl2, $market);
			$this->data['total_psg_masuk']	= 0;
			$this->data['total_rupiah_masuk'] = 0;
			$this->data['total_psg_keluar']	= 0;
			$this->data['total_rupiah_keluar'] = 0;
			foreach($xa as $g){
				if($g->jenis == "masuk"){
					$this->data['total_psg_masuk']	  	+= $g->pasang;
					$this->data['total_rupiah_masuk'] 	+= $g->rupiah;
				}else if($g->jenis == "keluar"){
					$this->data['total_psg_keluar']	  	+= $g->pasang;
					$this->data['total_rupiah_keluar'] 	+= $g->rupiah;
				}
			}

			// KALKULASI BIAYA PENGGANTIAN ONGKIR UNTUK TOKO
            $rekapExp   = $this->rpp_rpk_adm->get_order_for_actual_ongkir_for_rpk($tgl1,$tgl2);
            $ongkir_ditanggung = 0;
            $total_ongkir_ditanggung = 0;
	        foreach($rekapExp as $data6){
	          if($data6->ongkir_ditanggung == "toko" || $data6->ongkir_ditanggung == "dari_penjualan"){

	            // ACTUAL TARIF YANG DITANGGUNG TOKO
	            //if($data6->ongkir_ditanggung == "toko"){
	              if($data6->actual_tarif == ""){
	                $ongkir_ditanggungx = 0;
	              }else{
	                $ongkir_ditanggungx = $data6->actual_tarif;
	              }
	            //}else if($data6->ongkir_ditanggung == ""){
	            //  $ongkir_ditanggungx = 0;
	            //  $ket_onngkir = "Real Ongkir belum diinput";
	            //}else{
	            //  $ongkir_ditanggungx = 0;
	            //  $ket_onngkir = "";
	            //}

	            $total_ongkir_ditanggung += $ongkir_ditanggungx;
	            // END ACTUAL TARIF YANG DITANGGUNG TOKO
	        	}
	        }

	        $this->data['ongkir_ditanggung_toko'] = $total_ongkir_ditanggung;

			// cek dulu apakah sudah ada periode ini di database penjualan_fix, jika ada, keluarkan penjualan fix yang sudah dihitung dan juga biaya2 marketplace
        	$periode = "".date('d F Y', strtotime($tgl1)) ." - ". date('d F Y', strtotime($tgl2))."";
        	$cek = $this->rpp_rpk_adm->cek_penjualan_fix($periode);
        	$this->data['periode'] = $cek;

			// KALKULASI DISKON BARANG // (DAN BIAYA MARKETPLACE) SUDAH DIHAPUSKAN / DI TIADAKAN
			//$dsc = $this->rpp_rpk_adm->stok_penjualan_bulan_lalu2($tgl1, $tgl2, $market);
			//$biaya = 0;
			//$this->data['biaya_marketplace'] = 0;
			//$biaya_lazada = 0;
			//$vat_lazada = 0;
			//$vat_pencairan = 0;
			//foreach($dsc as $f){ 
				// BIAYA MARKETPLACE
			//	if($f->buy_in == "lazada"){
			//		$biaya_lazada = $f->qty * $f->harga_fix * 1.804 / 100; 
			//		$vat_lazada = $f->qty * $f->harga_fix * 0.164 / 100;
			//		$vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
			//	}else{
			//		$biaya_lazada = 0;
			//		$vat_lazada = 0; 
			//		$vat_pencairan = 0;
			//	}			
				//BIAYA MARKETPLACE
			//	$this->data['biaya_marketplace'] += ($biaya_lazada + $vat_lazada + $vat_pencairan); // FILTER BY LAZADA 
			//}

			// HITUNG PENDINGAN PASANG BULAN INI
			//$pnd = $this->rpp_rpk_adm->pendingan_bulan_ini($tgl1, $tgl2, $market);
			// YANG DIMAKSUD PENDINGAN BULAN INI ADALAH : TANGGAL ORDER BULAN INI TAPI STATUS BELUM DIBAYAR, MESKIPUN STATUS PESANAN SUDAH DITERIMA TAPI BELUM DIBAYAR MARKETPLACE ITU DINAMAKAN PESANAN PENDING
			//$pnd_psg_bln_ini = 0;
			//foreach($pnd as $h){
			//		$pnd_psg_bln_ini += $h->qty;
			//}

			//$this->data['pendingan'] = $pnd_psg_bln_ini;
			// mengambil invoice pending
			//$this->data['list_inv_pending'] = $this->rpp_rpk_adm->pendingan_bulan_ini($tgl1, $tgl2, $market);
 
			// KALKULASI SISA PERSEDIAAN BULAN INI
			$this->load->view('manage/header');
			$this->load->view('manage/laporan/rpp_rpk/create_rpp',$this->data);
			$this->load->view('manage/footer');

		}

	}

	function hapus_periode(){
		$data_filtering = $this->security->xss_clean($this->input->get('idpr'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
		$this->db->delete('penjualan_fix',array('id_penjualan_fix'=>$id));
	}

	function create(){ // proses tambah RPP / RPK
		
		 if($this->input->post()){

		 	$list_market = $this->onlinestore_adm->get_marketplace();
	        foreach($list_market as $hx){
	        	// load data marketplace
	        	$mrx[] = $hx->val_market;
	        }

        	$nama_produk = $this->input->post('nama');
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
	 
				$id_user = $this->data['id'];

	/////////////////////////////////////////////// MULAI HITUNG PEMECAHAN BAGIAN DARI SEMUA PESANAN YANG DI CLOSING ///////////////////////////////////////////////////////

				//$this->data['spbl'] = $this->rpp_rpk_adm->stok_penjualan_bulan_lalu();
				$bln1_filtering = $this->security->xss_clean($this->input->post('bln_closing'));
		        $bln_closing = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$bln1_filtering);

				$tgl1_filtering = $this->security->xss_clean($this->input->post('tgl1'));
		        $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1_filtering);

		        $this->data['tgl1'] = $tgl1;

		        $tgl2_filtering = $this->security->xss_clean($this->input->post('tgl2'));
		        $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2_filtering);

		        $this->data['tgl2'] = $tgl2;

		        $market_filtering = $this->security->xss_clean($this->input->post('marketplace'));
		        $market1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$market_filtering);

		        if($market1 == "semua"){
	        		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
	        		$market_title = "Semua Marketplace";
		        }else{
		        	$market = $market1;
		        	$market_title = $market1;
		        }

	///////////// MENGAPA RPP_TITLE DITARUH DISINI, KARENA DIGUNAKAN UNTUK MENGHITUNG PNJONTIME DSB /////////////////////

		        $tgl1xx = date('m', strtotime($tgl1)); 
				$tgl2xx = date('m', strtotime($tgl2)); 

		        // HITUNG PENJUALAN YANG TERJADI DIBULAN INI DAN DIBAYAR OLEH MARKETPLACE DIBULAN YANG SAMA (HIJAU)
				$pnjsame = $this->rpp_rpk_adm->penjualan_dibulan_yang_sama($tgl1, $tgl2, $market);
				$pnjontime = 0;
				foreach($pnjsame as $pnj){
					$bulan_order = date('m', strtotime($pnj->tanggal_order));
					$bulan_selesai_order = date('m', strtotime($pnj->tanggal_order_finish));
					// JIKA BULAN ORDER DAN BULAN SELESAI ORDER ADALAH SAMA, MAKA ITU ADALAH PENJUALAN DIBULAN YANG SAMA YANG SUDAH DIBAYAR (SELESAI)
					if($bulan_order == $bulan_selesai_order){
						$pnjontime += $pnj->qty;
					}
				}

				// HITUNG PENJUALAN BULAN LALU YANG TERPENDING (TIDAK MENUTUP KEMUNGKINAN BERBULAN BULAN DAN DITARIK DARI 6 BULAN KEBELAKANG DARI BULAN CLOSING). (KUNING)
				$pnjpendingbulanlalu = $this->rpp_rpk_adm->penjualan_pending_bulan_lalu($market);
				$pnjpendingblnlalu = 0;
				foreach($pnjpendingbulanlalu as $pnjx){
					// UBAH TANGGAL ORDER FINISH KE BULAN SAJA
					$bln_order = date('m', strtotime($pnjx->tanggal_order)); // MISAL BLN ORDER 05
					$bln_selesai = date('m', strtotime($pnjx->tanggal_order_finish)); // MISAL BULAN SELESAI BULAN 06 / 07
					if($bln_selesai == $tgl1xx || $bln_selesai == $tgl2xx){
						if($bln_order != $tgl1xx){
							$pnjpendingblnlalu += $pnjx->qty;
						}
					}
				}

				// HITUNG PENJUALAN YANG TERJADI DIBULAN INI TAPI BELUM TERSELESAIKAN (BELUM DIBAYAR BAYAR) HINGGA SAMPAI BULAN DEPAN AKHIRNYA TERMASUK PENDINGAN DARI BULAN INI (MERAH)
				$pnjsamex = $this->rpp_rpk_adm->pendingan_dibulan_yang_sama($tgl1, $tgl2, $market);
				$pnjpendingblnini = 0;
				foreach($pnjsamex as $pnjxx){
					$pnjpendingblnini += $pnjxx->qty;
				}

		        // judul RPP/RPK
				$data_rpp = array(
					'jenis_market'	=> $data['market'],
					'periode_closing'=> date('d F Y', strtotime($tgl1))." - ".date('d F Y', strtotime($tgl2)),
					'tanggal' 		=> $data['tgl_tarik'], 
					'dibuat' 		=> $id_user,
					'tgl_dibuat'	=> date('y-m-d H:i:s'),
					'pnjontime'		=> $pnjontime,
					'pnjpendingblnlalu' => $pnjpendingblnlalu,
					'pnjpendingblnini'	=> $pnjpendingblnini,
				);
				$this->db->insert('rpp_title', $data_rpp);

				$last_insert_id = $this->db->insert_id();
	 
				// penjualan by closing
				$data_closing = array(
					'id_rpp_closing'	=> $last_insert_id,
					'bulan'				=> $bln_closing,
					'pasang'			=> $data['penjualan_psg_bulan_ini'],
					'rupiah'			=> $data['penjualan_rupiah_bulan_ini'],
				);
				$this->rpp_rpk_adm->insert_data_closing($data_closing);

				// HITUNG PENJUALAN YANG TERJADI DIBULAN INI DAN DIBAYAR OLEH MARKETPLACE DIBULAN YANG SAMA (HIJAU)
				$pnjsame = $this->rpp_rpk_adm->penjualan_dibulan_yang_sama($tgl1, $tgl2, $market);
				foreach($pnjsame as $pnj){
					$bulan_order = date('m', strtotime($pnj->tanggal_order));
					$bulan_selesai_order = date('m', strtotime($pnj->tanggal_order_finish));
					// JIKA BULAN ORDER DAN BULAN SELESAI ORDER ADALAH SAMA, MAKA ITU ADALAH PENJUALAN DIBULAN YANG SAMA YANG SUDAH DIBAYAR (SELESAI)
					if($bulan_order == $bulan_selesai_order){
						$dataontime = array(
							'id_rpp' 		=> $last_insert_id,
							'inv_ontime'	=> $pnj->invoice,
							'qty_ontime' 	=> $pnj->qty,
						);
						$this->db->insert('pesanan_ontime', $dataontime);
					}
				}

				// HITUNG PENJUALAN BULAN LALU YANG TERPENDING (TIDAK MENUTUP KEMUNGKINAN BERBULAN BULAN DAN DITARIK DARI 6 BULAN KEBELAKANG DARI BULAN CLOSING). (KUNING)
				$pnjpendingbulanlalu = $this->rpp_rpk_adm->penjualan_pending_bulan_lalu($market);
				foreach($pnjpendingbulanlalu as $pnjx){
					// UBAH TANGGAL ORDER FINISH KE BULAN SAJA
					$bln_order = date('m', strtotime($pnjx->tanggal_order)); // MISAL BLN ORDER 05
					$bln_selesai = date('m', strtotime($pnjx->tanggal_order_finish)); // MISAL BULAN SELESAI BULAN 06 / 07
					if($bln_selesai == $tgl1xx || $bln_selesai == $tgl2xx){
						if($bln_order != $tgl1xx){
							$datapndblnlalu = array(
								'id_rpp' 				=> $last_insert_id,
								'inv_pending_bln_lalu'	=> $pnjx->invoice,
								'qty_pending_bln_lalu' 	=> $pnjx->qty,
							);
							$this->db->insert('pesanan_pending_bln_lalu', $datapndblnlalu);
						}
					}
			}

			// HITUNG PENJUALAN YANG TERJADI DIBULAN INI TAPI BELUM TERSELESAIKAN (BELUM DIBAYAR BAYAR) HINGGA SAMPAI BULAN DEPAN AKHIRNYA TERMASUK PENDINGAN DARI BULAN INI (MERAH)
			$pnjsamex = $this->rpp_rpk_adm->pendingan_dibulan_yang_sama($tgl1, $tgl2, $market);
			foreach($pnjsamex as $pnjxx){
				$datapndblnini = array(
					'id_rpp' 				=> $last_insert_id,
					'inv_pending_bln_ini'	=> $pnjxx->invoice,
					'qty_pending_bln_ini' 	=> $pnjxx->qty,
				);
				$this->db->insert('pesanan_pending_bln_ini', $datapndblnini);				
			}
			
/////////////////////////////////////// INSERT DATA RPP/ RPK /////////////////////////////////////////////////////////////////
			$this->rpp_rpk_adm->add($id_user, $last_insert_id, $data, $tgl1, $tgl2); 
			
			// BUAT RPP RPK OTOMATIS 
			//$this->rpp_rpk_otomatis();

			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Membuat Laporan RPP / RPK Bulan '.$bln_closing.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> RPP / RPK telah dibuat!');
			redirect('trueaccon2194/rpp_rpk');
        
		}else{
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal membuat RPP / RPK');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
			redirect('trueaccon2194/rpp_rpk');
		}

	}

	function rpp_rpk_otomatis(){
		//$this->data['spbl'] = $this->rpp_rpk_adm->stok_penjualan_bulan_lalu();
		$tgl1_filtering = $this->security->xss_clean($this->input->post('tgl1'));
        $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1_filtering);

        $this->data['tgl1'] = $tgl1;

        $tgl2_filtering = $this->security->xss_clean($this->input->post('tgl2'));
        $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2_filtering);

        $this->data['tgl2'] = $tgl2;

        // penjualan by tanggal
		$qa = $this->rpp_rpk_adm->stok_penjualan_bulan_lalu($tgl1, $tgl2);

        // BARANG MASUK & KELUAR by tanggal
        $this->data['inout'] = $this->rpp_rpk_adm->barang_masuk_keluar($tgl1, $tgl2);
		$xa = $this->rpp_rpk_adm->barang_masuk_keluar($tgl1, $tgl2);
		$this->data['total_psg_masuk']	= 0;
		$this->data['total_rupiah_masuk'] = 0;
		$this->data['total_psg_keluar']	= 0;
		$this->data['total_rupiah_keluar'] = 0;
		foreach($xa as $g){
			if($g->jenis == "masuk"){
				$this->data['total_psg_masuk']	  	+= $g->pasang;
				$this->data['total_rupiah_masuk'] 	+= $g->rupiah;
			}else if($g->jenis == "keluar"){
				$this->data['total_psg_keluar']	  	+= $g->pasang;
				$this->data['total_rupiah_keluar'] 	+= $g->rupiah;
			}
			
		}

		//cetak laporan
		//$this->load->library('dompdf_gen');
		//send data[''] to view
        $this->load->view('manage/laporan/rpp_rpk/cetak_rpp_otomatis', $this->data);
        //$paper_size  = 'F4'; //paper size
        //$orientation = 'potrait'; //tipe format kertas
        //$html = $this->output->get_output();
 
        //$this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->load_html($html);
        //$this->dompdf->render();
        //$this->dompdf->stream("RPP_RPK_".$tgl1." - ".$tgl2.".pdf", array('Attachment'=>0));
        //exit(0);
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Mencetak RPP / RPK otomatis (generate by sistem)');

	}

	function pesanan_ontime($id){
		$id1 = base64_decode($id);
		$idrpp = $this->encrypt->decode($id1);
		$data['caption'] = "Tepat Waktu";
		$data['getdata'] = $this->rpp_rpk_adm->get_pesanan_ontime($idrpp);
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/rpp_rpk/daftar_pesanan_dari_rpp',$data);
		$this->load->view('manage/footer');
	}

	function pesanan_pndblnlalu($id){
		$id1 = base64_decode($id);
		$idrpp = $this->encrypt->decode($id1);
		$data['caption'] = "Pending Bulan Lalu";
		$data['getdata'] = $this->rpp_rpk_adm->get_pesanan_pndblnlalu($idrpp);
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/rpp_rpk/daftar_pesanan_dari_rpp',$data);
		$this->load->view('manage/footer');
	}

	function pesanan_pndblnini($id){
		$id1 = base64_decode($id);
		$idrpp = $this->encrypt->decode($id1);
		$data['caption'] = "Pending Bulan Ini";
		$data['getdata'] = $this->rpp_rpk_adm->get_pesanan_pndblnini($idrpp);
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/rpp_rpk/daftar_pesanan_dari_rpp',$data);
		$this->load->view('manage/footer');
	}

	function update(){ // proses update
		 if($this->input->post()){

        	$idrpp = $this->input->post('idrpp');
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
 
			$id_user = $this->data['id'];

			$this->rpp_rpk_adm->update($id_user, $idrpp, $data); 
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Laporan RPP / RPK');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> RPP / RPK telah diubah!');
			redirect('trueaccon2194/rpp_rpk');
        
		}else{
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal mengupdate RPP / RPK');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
			redirect('trueaccon2194/rpp_rpk');
		}

	}
 
	function cetak_rpp_rpk($id){

		//$this->data['get_data'] = $this->rpp_rpk_adm->get_data_rpp($id);
		$cek_rp = $this->rpp_rpk_adm->cek_penjualan_fix_ambil_rupiah();
		//$this->data['periode_closing'] = $cek_rp['periode_closing'];

		$fr = $this->rpp_rpk_adm->get_data_rpp($id);
		foreach($fr as $g){
			$this->data['periode_closing'] = $g->periode_closing;
			$this->data['bln_closing'] = $g->bulan;
			$this->data['market'] = $g->jenis_market;

			//BUAT JUDUL
			$market1 = $g->jenis_market;
			$tgl_title = $g->tanggal;
			//$this->data['tanggal'] = $tgl_title;

			// RPP DATA PAIRS DENGAN TURN OVERNYA

			// PAIRS DAN TURN OVER KIRI
			if($g->rincian == "sisa_persediaan_bulan_lalu"){
				$this->data['sisa_persediaan_bulan_lalu'] = $g->pairs;
				$this->data['turn_over_sisa_persediaan_bulan_lalu'] = $g->turn_over;
			}
			if($g->rincian == "total_psg_masuk"){
				$this->data['total_psg_masuk'] = $g->pairs;
				$this->data['total_rupiah_masuk'] = $g->turn_over;
			}
			if($g->rincian == "balance_selisih_lebih"){
				$this->data['balance_selisih_lebih'] = $g->pairs;
				$this->data['turnover_balance_selisih_lebih'] = $g->turn_over;
			}
			if($g->rincian == "jumlah_pairs_dan_turn_over_kiri"){
				$this->data['sum_total_rpp_kiri'] = $g->pairs;
				$this->data['sum_total_rpp_rupiah_kiri'] = $g->turn_over;
			}

			// PAIRS DAN TURN OVER KANAN
			if($g->rincian == "penjualan_psg_bulan_ini"){
				$this->data['penjualan_psg_bulan_ini'] = $g->pairs;
				$this->data['penjualan_rupiah_bulan_ini'] = $g->turn_over;
			}
			if($g->rincian == "total_psg_keluar"){
				$this->data['total_psg_keluar'] = $g->pairs;
				$this->data['total_rupiah_keluar'] = $g->turn_over;
			}
			if($g->rincian == "balance_selisih_kurang"){
				$this->data['balance_selisih_kurang'] = $g->pairs;
				$this->data['turnover_balance_selisih_kurang'] = $g->turn_over;
			}

			// DIGANTI DI RPK (ONGKOS DAN ADMINISTRASI) // DIAKTIFKAN KEMBALI
			if($g->rincian == "spesial_diskon"){
				$this->data['sum_diskon_dan_biaya_marketplace'] = $g->turn_over;
			}

			if($g->rincian == "sisa_persediaan_bulan_ini"){
				$this->data['sum_sisa_persediaan_kanan'] = $g->pairs;
				$this->data['sum_rupiah_sisa_persediaan_kanan'] = $g->turn_over;
			}
			if($g->rincian == "jumlah_pairs_dan_turn_over_kanan"){ 
				$this->data['sum_rpp_kanan'] = $g->pairs;
				$this->data['sum_total_rupiah_kanan'] = $g->turn_over;
			}
			if($g->rincian == "total_rupiah_penjualan_bulan_ini"){
				$this->data['total_rupiah_penjualan_bulan_ini'] = $g->turn_over;
			}
			if($g->rincian == "selisih_kurang_dsl_dsk"){
				$this->data['selisih_kurang_dsl_dsk'] = $g->turn_over;
			}
			if($g->rincian == "selisih_kurang_penjualan_bulan_lalu"){
				$this->data['selisih_kurang_penjualan_bulan_lalu'] = $g->turn_over;
			}
			if($g->rincian == "add_turn_kiri"){
				$this->data['add_turn_kiri'] = $g->turn_over;
			}
			if($g->rincian == "total_turn_over_rpk_kiri"){
				$this->data['total_turn_over_rpk_kiri'] = $g->turn_over;
			}
			if($g->rincian == "selisih_lebih_penjualan_bulan_lalu"){
				$this->data['selisih_lebih_penjualan_bulan_lalu'] = $g->turn_over;
			}
			if($g->rincian == "biaya_promosi"){
				$this->data['biaya_promosi'] = $g->turn_over;
			}
			if($g->rincian == "biaya_internet"){
				$this->data['biaya_internet'] = $g->turn_over;
			}
			if($g->rincian == "biaya_pengiriman_pesanan"){
				$this->data['biaya_pengiriman_pesanan'] = $g->turn_over;
			}
			if($g->rincian == "biaya_fotocopy_dokumen"){
				$this->data['biaya_fotocopy_dokumen'] = $g->turn_over;
			}
			if($g->rincian == "biaya_perjalanan_dinas"){
				$this->data['biaya_perjalanan_dinas'] = $g->turn_over;
			}
			if($g->rincian == "ongkos_dan_administrasi_bank"){
				$this->data['ongkos_dan_administrasi_bank'] = $g->turn_over;
			}

			if($g->rincian == "pembayaran_gaji_dan_komisi_supervisor"){
				$this->data['pembayaran_gaji_dan_komisi_supervisor'] = $g->turn_over;
			}//else{
			//	$this->data['pembayaran_gaji_dan_komisi_supervisor'] = 0;
			//}

			if($g->rincian == "pembayaran_komisi_pramuniaga"){
				$this->data['pembayaran_komisi_pramuniaga'] = $g->turn_over;
			}//else{
			//	$this->data['pembayaran_komisi_pramuniaga'] = 0;
			//}
				
			if($g->rincian == "ongkos_angkut"){
				$this->data['ongkos_angkut'] = $g->turn_over;
			}
			if($g->rincian == "pembayaran_pajak"){
				$this->data['pembayaran_pajak'] = $g->turn_over;
			}
			if($g->rincian == "sub_total_biaya_rutin"){
				$this->data['sub_total_biaya_rutin'] = $g->turn_over;
			}
			if($g->rincian == "biaya_maintenance"){
				$this->data['biaya_maintenance'] = $g->turn_over;
			}
			if($g->rincian == "sub_total_biaya_non_rutin"){
				$this->data['sub_total_biaya_non_rutin'] = $g->turn_over;
			}
			if($g->rincian == "total_biaya_rutin_dan_non_rutin"){
				$this->data['total_biaya_rutin_dan_non_rutin'] = $g->turn_over;
			}
			if($g->rincian == "total_setoran_bank"){
				$this->data['total_setoran_bank'] = $g->turn_over;
			}
			if($g->rincian == "total_kartu_kredit"){
				$this->data['total_kartu_kredit'] = $g->turn_over;
			}
			if($g->rincian == "add_turn_kanan"){
				$this->data['add_turn_kanan'] = $g->turn_over;
			}
			if($g->rincian == "total_turn_over_rpk_kanan"){
				$this->data['total_turn_over_rpk_kanan'] = $g->turn_over;
			}			

		}

		//cetak laporan
		$this->load->library('dompdf_gen');
		//send data[''] to view
        $this->load->view('manage/laporan/rpp_rpk/cetak_rpp', $this->data);
        $paper_size  = 'legal'; //DEFAULT LEGAL INI DIGANTI A4 paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF 
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("RPP_RPK_".$market1."_".$tgl_title.".pdf", array('Attachment'=>0));
        exit(0);
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Mencetak RPP / RPK');

	}

	function hapus(){
		$id = $this->input->get('id');
		$tgl = $this->input->get('name');
		$this->rpp_rpk_adm->hapus($id);
		//$this->rpp_rpk_adm->hapus_penj_by_closing($id);
		$this->session->set_flashdata('error', 'Laporan RPP / RPK '.$tgl.' dihapus!');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Laporan RPP / RPK ('.$tgl.')');
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$cek = $this->input->post('checklist');
			$this->rpp_rpk_adm->remove_dipilih($cek);
			print_r($cek);
			log_helper("laporan", "Menghapus Produk yang dipilih");
			//redirect('trueaccon2194/produk');
	}

	function input_biaya(){
		$thbx = $this->security->xss_clean($this->input->get('thb'));
        $thb = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$thbx);

        $kmsx = $this->security->xss_clean($this->input->get('kms'));
        $kms = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$kmsx);

        $bpx = $this->security->xss_clean($this->input->get('bp'));
        $bp = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$bpx);

        $prx = $this->security->xss_clean($this->input->get('pr'));
        $pr = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$prx);

        /*** NEW ***/
        // dikurangi komisi (kms)
        $cek = $this->rpp_rpk_adm->cek_penjualan_fix1($pr);
        $total = $thb - $bp - $kms;
        if($cek->num_rows() == 0){
        	// simpan penjualan net
	        $this->db->insert('penjualan_fix',array('penjualan_fix'=>$total, 'biaya_marketplace'=> $bp, 'tgl_input'=>date('Y-m-d H:i:s'), 'periode' => $pr));
        }else{
        	// update penjualan net
        	$t = $cek->row_array();
        	$id = $t['id_penjualan_fix'];
        	$this->db->where('id_penjualan_fix', $id);
        	$this->db->update('penjualan_fix',array('penjualan_fix'=>$total, 'biaya_marketplace'=> $bp, 'tgl_input'=>date('Y-m-d H:i:s'), 'periode' => $pr));
        }
        
	}

	function sales_comparison(){
		$type1_filtering = $this->security->xss_clean($this->input->post('comptype'));
        $type = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$type1_filtering);

        $bln1_filtering = $this->security->xss_clean($this->input->post('bulan1'));
        $bulan1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$bln1_filtering);

        $bulan2_filtering = $this->security->xss_clean($this->input->post('bulan2'));
        $bulan2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$bulan2_filtering);

        $thn1_filtering = $this->security->xss_clean($this->input->post('tahun1'));
        $tahun1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$thn1_filtering);

        $thn2_filtering = $this->security->xss_clean($this->input->post('tahun2'));
        $tahun2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$thn2_filtering);

        if($type == "tahunan"){ 
        	// proses data
        	$res1 = $this->rpp_rpk_adm->tahunan_filter_comparison($tahun1);
        	$res2 = $this->rpp_rpk_adm->tahunan_filter_comparison2($tahun2);

        	// hasil 1
        	echo "
        	<div class='col-md-12 col-xs-12' id='printableArea'>
	        	<h3 style='margin-bottom:30px;' class='text-center'>SALES COMPARISON E-COMMERCE</h3>
	        	<div class='col-md-6 col-xs-6'>
	        		<h3 style='margin-bottom:30px;' class='text-center'>TAHUN ".$tahun1."</h3>
		        	<table id='table_produk' class='table table-striped table-hover table-bordered' cellspacing='0' width='100%' style='box-shadow:0px 0px 8px 0px #bababa;'>
		            <thead> 
		                <tr style='background-color:#34425a;color:white;'>
		                    <th style='text-align:center;'>Bulan</th>
		                    <th style='text-align:center;'>Pasang</th>
		                    <th style='text-align:center;'>Rupiah</th>
		                </tr>
		            </thead>
	        ";
	        	$totalPasang = 0;
	        	$totalRupiah = 0;
	        	foreach($res1 as $tx){
	        		$rupiah = $tx->rupiah;
	        		$totalPasang += $tx->pasang;
	        		$totalRupiah += $tx->rupiah;
	        		echo "
	        		<tbody>
	        			<tr>
	                  		<td style='text-align:center;'>".$tx->bulan."</td>
	                  		<td style='text-align:center;'>".$tx->pasang."</td>
	                  		<td style='text-align:center;'>".number_format(floatval($rupiah),0,".",".")."</td>
	                  	</tr>
	                <tbody>
	        		";
	        	}
        	echo "
        			<tfoot>
        				<tr style='background-color:#34425a;color:white;'>
        					<th style='text-align:center;'>Total </th>
        					<th style='text-align:center;'>".$totalPasang."</th>
        					<th style='text-align:center;'>".number_format($totalRupiah,0,".",".")."</th>
        				</tr>
        			</tfoot>
	        		</table>
	        	</div>
        	";

        	// hasil 2
        	echo "
	        	<div class='col-md-6 col-xs-6'>
	        		<h3 style='margin-bottom:30px;' class='text-center'>TAHUN ".$tahun2."</h3>
		        	<table id='table_produk' class='table table-striped table-hover table-bordered' cellspacing='0' width='100%' style='box-shadow:0px 0px 8px 0px #bababa;'>
		            <thead>
		                <tr style='background-color:#34425a;color:white;'>
		                    <th style='text-align:center;'>Bulan</th>
		                    <th style='text-align:center;'>Pasang</th>
		                    <th style='text-align:center;'>Rupiah</th>
		                </tr>
		            </thead>
		            <tbody>
	        ";
	        	$totalPasang1 = 0;
	        	$totalRupiah1 = 0;
	        	foreach($res2 as $txx){
	        		$rupiah1 = $txx->rupiah;
	        		$totalPasang1 += $txx->pasang;
	        		$totalRupiah1 += $txx->rupiah;
	        		echo "
	        			<tr>
	                  		<td style='text-align:center;'>".$txx->bulan."</td>
	                  		<td style='text-align:center;'>".$txx->pasang."</td>
	                  		<td style='text-align:center;'>".number_format(floatval($rupiah1),0,".",".")."</td>
	                  	</tr>
	        		";
	        	}
        	echo "
        			<tbody>
        			<tfoot>
        				<tr style='background-color:#34425a;color:white;'>
        					<th style='text-align:center;'>Total </th>
        					<th style='text-align:center;'>".$totalPasang1."</th>
        					<th style='text-align:center;'>".number_format($totalRupiah1,0,".",".")."</th>
        				</tr>
        			</tfoot>
	        		</table>
	        	</div>
	        </div>
        	";

        }else{
        	// proses data
        	$res1 = $this->rpp_rpk_adm->bulanan_filter_comparison($bulan1);
        	$res2 = $this->rpp_rpk_adm->bulanan_filter_comparison2($bulan2);

        	// hasil 1
        	echo "
        	<div class='col-md-12 col-xs-12' id='printableArea'>
	        	<h3 style='margin-bottom:30px;' class='text-center'>SALES COMPARISON E-COMMERCE</h3>
	        	<div class='col-md-6 col-xs-6'>
		        	<table id='table_produk' class='table table-striped table-hover table-bordered' cellspacing='0' width='100%' style='box-shadow:0px 0px 8px 0px #bababa;'>
		            <thead> 
		                <tr style='background-color:#34425a;color:white;'>
		                    <th style='text-align:center;'>Bulan</th>
		                    <th style='text-align:center;'>Pasang</th>
		                    <th style='text-align:center;'>Rupiah</th>
		                </tr>
		            </thead>
		            <tbody>
	        ";
	        	foreach($res1 as $tx){
	        		echo "
	        			<tr>
	                  		<td style='text-align:center;'>".$tx->bulan."</td>
	                  		<td style='text-align:center;'>".$tx->pasang."</td>
	                  		<td style='text-align:center;'>".number_format(floatval($tx->rupiah),0,".",".")."</td>
	                  	</tr>
	        		";
	        	}
        	echo "
        			<tbody>
	        		</table>
	        	</div>
        	";

        	// hasil 2
        	echo "
	        	<div class='col-md-6 col-xs-6'>
		        	<table id='table_produk' class='table table-striped table-hover table-bordered' cellspacing='0' width='100%' style='box-shadow:0px 0px 8px 0px #bababa;'>
		            <thead>
		                <tr style='background-color:#34425a;color:white;'>
		                    <th style='text-align:center;'>Bulan</th>
		                    <th style='text-align:center;'>Pasang</th>
		                    <th style='text-align:center;'>Rupiah</th>
		                </tr>
		            </thead>
		            <tbody>
	        ";
	        	foreach($res2 as $txx){
	        		echo "	        		
	        			<tr>
	                  		<td style='text-align:center;'>".$txx->bulan."</td>
	                  		<td style='text-align:center;'>".$txx->pasang."</td>
	                  		<td style='text-align:center;'>".number_format(floatval($txx->rupiah),0,".",".")."</td>
	                  	</tr>
	        		";
	        	}
        	echo "	
        			<tbody>
	        		</table>
	        	</div>
	        </div>
        	";
        }
        
	}

	function load_all_serverside_laporan_biaya(){
		$list_data = $this->rpp_rpk_adm->get_datatables_biaya();
		$data = array();
		$no = $_POST['start'];
		foreach($list_data as $x){
			$no++;
			$row = array();

			if($x->dibayar == "" || $x->dibayar == "belum"){
            	$stat_bayar = "<div style='margin-top:10px;'><label class='label label-danger'>Belum dibayar</label></div>";
          	}else{
            	$stat_bayar = "<div style='margin-top:10px;'><label class='label label-success'>Sudah dibayar</label></div>";
          	}          	

          	if($x->buy_in == ""){
            	$buy = "<img src='".base_url('assets/images/logostsrs1.png')."'>";
            }else if($x->buy_in == "shopee"){
               	$buy = "<img src='".base_url('assets/images/marketplace/shopee_logo.png')."' style='width:25px;height:auto;'>";
            }else if($x->buy_in == "tokopedia"){
               	$buy = "<img src='".base_url('assets/images/marketplace/tokopedia_logo.png')."' style='width:25px;height:auto;'>";
            }else if($x->buy_in == "bukalapak"){
               	$buy = "<img src='".base_url('assets/images/marketplace/bukalapak_logo.png')."' style='width:25px;height:auto;'>";
            }else if($x->buy_in == "lazada"){
               	$buy = "<img src='".base_url('assets/images/marketplace/lazada_logo.png')."' style='width:25px;height:auto;'>";
            }else if($x->buy_in == "instagram"){
               	$buy = "<img src='".base_url('assets/images/ic_email/icon-instagram.png')."' style='width:25px;height:auto;'>";
            }else if($x->buy_in == "whatsapp_marketing"){ 
            	$buy = "<img src='".base_url('assets/images/ic_email/whatsapp.png')."' style='width:25px;height:auto;'>";
            }else if($x->buy_in == "zilinggo"){
            	$buy = "<img src='".base_url('assets/images/marketplace/zilinggo.png')."' style='width:25px;height:auto;'>";
            }else if($x->buy_in == "blibli"){
            	$buy = "<img src='".base_url('assets/images/marketplace/blibli.png')."' style='width:50px;height:auto;'>";
            }else{
               	$buy = $x->buy_in."";
            }

        	if($x->status == "2hd8jPl613!2_^5"){
	            $status = "<label class='label label-warning'>Menunggu Pembayaran</label>";
	        }else if($x->status == "*^56t38H53gbb^%$0-_-"){
	            $status = "<label class='label label-primary'>Pembayaran Diterima</label>";
	       	}else if($x->status == "Uywy%u3bShi)payDhal"){
	            $status = "<label class='label label-primary'>Dalam Pengiriman</label>";
	        }else if($x->status == "ScUuses8625(62427^#&9531(73"){
	            $status = "<label class='label label-success'>Diterima</label>";
	        }else if($x->status == "batal"){
	        	$status = "<label class='label label-danger'>Dibatalkan</label>";
	        }

	        $idxx = $this->encrypt->encode($x->no_order_cus); 
	        $idp = base64_encode($idxx);

	        $opsi = "
		        <ul class='list-inline opsi' style='margin-bottom: 0;'>
		            <li>
		              <a title='Detail Invoice' class='btn btn-default' href='".base_url('trueaccon2194/rpp_rpk/detail_biaya/'.$idp.'')."' class='edit'><i class='glyphicon glyphicon-eye-open'></i></a>
		            </li>
		            <li>
		              <a title='Edit Invoice' href='".base_url('trueaccon2194/rpp_rpk/edit_biaya/'.$idp.'')."' class='btn btn-warning'><i class='glyphicon glyphicon-pencil'></i></a> 
		            </li>
		            <li>
		              <a title='Hapus Invoice' href='".base_url('trueaccon2194/rpp_rpk/hapus_biaya/'.$idp.'')."' class='btn btn-danger hapus'><i class='glyphicon glyphicon-trash'></i></a> 
		            </li>
		        </ul>
	        ";

	        if($x->keterangan == ""){
	        	$keterangan_biaya = "-";
	        }else{
	        	$keterangan_biaya = $x->keterangan;
	        }

	        if($x->biaya == ""){
	        	$biaya = "-";
	        }else{
	        	$biaya = "Rp. ".number_format($x->biaya,0,".",".");
	        }

          	// ROW START
          	$row[] = "<input type='checkbox' class='form-control' name='checkorder[]' value='".$x->no_order_cus."'/>";
          	$row[] = date('d F Y', strtotime($x->tanggal_order));
          	$row[] = "<center>".$x->invoice."</center>";
          	$row[] = "<center>".$buy."</center>";
          	$row[] = "<center>".$keterangan_biaya."</center>";
          	$row[] = "<center>".$biaya."</center>";
          	$row[] = $status."<br>".$stat_bayar;
          	$row[] = $opsi;

          	// ROW end(array)
        $data[] = $row;
    	}

    	$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->rpp_rpk_adm->count_all_biaya(),
            "recordsFiltered" => $this->rpp_rpk_adm->count_filtered_biaya(),
            "data" => $data,
        );
		echo json_encode($output);
	}

	function laporan_biaya(){
		$data['market'] = $this->onlinestore_adm->get_marketplace();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/rpp_rpk/laporan_biaya',$data);
		$this->load->view('manage/footer');
	}

	function input_biaya_by_excel(){
		$data['market'] = $this->onlinestore_adm->get_marketplace();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/rpp_rpk/input_biaya',$data);
		$this->load->view('manage/footer');	
	}

	function template_biaya_shopee(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

			$objPHPExcel = new PHPExcel();
			// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		    $style_col = array(
		      'font' => array('bold' => true), // Set font nya jadi bold
		      'alignment' => array(
		        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		      ),
		      'borders' => array(
		        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		      )
		    );
		    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		    $style_row = array(
		      'alignment' => array(
		      	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		      ),
		      'borders' => array(
		        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		      )
		    );

	    	// Create a first sheet, representing sales data
			$objPHPExcel->setActiveSheetIndex(0);

			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP PENJUALAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('TEMPLATE BIAYA SHOPEE');
	    	//table header
			$heading = array("No. Pesanan","Ongkir Dibayar Pembeli","Diskon Ongkir Ditanggung Jasa Kirim","Gratis Ongkir dari Shopee","Ongkir yang Diteruskan oleh Shopee ke Jasa Kirim","Biaya Administrasi (termasuk PPN 10%)","Biaya Layanan (termasuk PPN 10%)");
	        //loop heading
	        $rowNumberH = 1;
		    $colH = 'A';
		    foreach($heading as $h){
		        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
		        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
		        $colH++;    
		    }

		    // BUAT SHEET UNTUK MERK, DIVISI, KATEGORI, PARENT KATEGORI
		    $objPHPExcel->createSheet();
		    $objPHPExcel->setActiveSheetIndex(1);
		    //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', "PERTELAAN BARANG MASUK & KELUAR"); // Set kolom A1
		    // Rename sheet
		    $objPHPExcel->getActiveSheet()->setTitle('PETUNJUK PENGISIAN');
		    $objPHPExcel->getActiveSheet()->setCellValue("A1","Download Laporan di https://seller.shopee.co.id/portal/finance/income setelah itu tarik tanggal sesuai tanggal closing dan klik export lalu download excelnya dan pindahkan data ke template excel ini. (hilangkan tanda petik pada nomor invoice)"); 

	      	// Redirect output to a client’s web browser (Excel5)
			$filename = urlencode("Template_Biaya_Shopee.xls");
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
	        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Download template biaya shopee (Excel)');
	}

	function template_biaya_bukalapak(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

			$objPHPExcel = new PHPExcel();
			// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		    $style_col = array(
		      'font' => array('bold' => true), // Set font nya jadi bold
		      'alignment' => array(
		        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		      ),
		      'borders' => array(
		        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		      )
		    );
		    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		    $style_row = array(
		      'alignment' => array(
		      	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		      ),
		      'borders' => array(
		        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
		        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
		        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
		        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		      )
		    );

	    	// Create a first sheet, representing sales data
			$objPHPExcel->setActiveSheetIndex(0);

			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP PENJUALAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('TEMPLATE BIAYA BUKALAPAK');
	    	//table header
			$heading = array("No. Pesanan","Mutasi","Keterangan");
	        //loop heading
	        $rowNumberH = 1;
		    $colH = 'A';
		    foreach($heading as $h){
		        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
		        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
		        $colH++;    
		    }

		    // BUAT SHEET UNTUK MERK, DIVISI, KATEGORI, PARENT KATEGORI
		    $objPHPExcel->createSheet();
		    $objPHPExcel->setActiveSheetIndex(1);
		    //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', "PERTELAAN BARANG MASUK & KELUAR"); // Set kolom A1
		    // Rename sheet
		    $objPHPExcel->getActiveSheet()->setTitle('PETUNJUK PENGISIAN');
		    $objPHPExcel->getActiveSheet()->setCellValue("A1","Download Laporan di https://www.bukalapak.com/dompet"); 
		    $objPHPExcel->getActiveSheet()->setCellValue("A2","setelah itu tarik tanggal sesuai tanggal closing dan klik export lalu download excelnya dan pindahkan data ke template excel ini."); 
		    $objPHPExcel->getActiveSheet()->setCellValue("A3","(replace tanggal pesanan dengan nomor invoice) & hilangkan kolom jika ada keterangan 'pencairan dana .... / remit untuk transaksi ...' "); 

	      	// Redirect output to a client’s web browser (Excel5)
			$filename = urlencode("Template_Biaya_Bukalapak.xls");
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
	        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Download template biaya bukalapak (Excel)');
	}

	function proses_input_biaya_by_excel(){
	$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    $config['upload_path'] = realpath('data_excel_for_update_product');
    $config['allowed_types'] = 'xlsx|xls|csv';
    $config['max_size'] = '10000';
    $config['encrypt_name'] = true;
    $this->upload->initialize($config);

    if(!$this->upload->do_upload('uploadexcel')) { //upload gagal
      $this->session->set_flashdata('error', $this->upload->display_errors());
      redirect($this->agent->referrer());

    }else{ // BERHASIL

	  $market2_filtering = $this->security->xss_clean($this->input->post('market'));
      $market = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$market2_filtering);

      $excelreader  = new PHPExcel_Reader_Excel5();
      $loadexcel    = $excelreader->load('data_excel_for_update_product/'.$this->upload->data('file_name')); // Load file yang telah diupload ke folder data_excel_for_update_product
      $sheet        = $loadexcel->getActiveSheet()->toArray(null,true,true,true);
      $data_biaya1 = array();
      $data_biaya2 = array();
      $data_biaya3 = array();
      $data_biaya4 = array();
      $data_biaya5 = array();
      $data_biaya6 = array();
      $numrow = 1;
      $nobiaya = 0;
      if($market == "shopee"){ // perlakuan input biaya2 berbeda tiap marketplace
	   	foreach($sheet as $row){
	        if($numrow > 1){
	            array_push(
	              $data_biaya1, array(
	                'no_order_biaya'    => $row['A'],
	                'marketplace'       => $market,
	                'val_ket'			=> "biaya1",
	                'keterangan'        => "Ongkir Dibayar Pembeli",
	                'biaya'             => $row['B'],
	                'tgl_input'         => date("Y-m-d"),
	                'user'              => $this->data['id'],
	            ));

	            array_push(
	              $data_biaya2, array(
	                'no_order_biaya'    => $row['A'],
	                'marketplace'       => $market,
	                'val_ket'			=> "biaya2",
	                'keterangan'        => "Diskon Ongkir Ditanggung Jasa Kirim",
	                'biaya'             => $row['C'],
	                'tgl_input'         => date("Y-m-d"),
	                'user'              => $this->data['id'],
	            ));

	            array_push(
	              $data_biaya3, array(
	                'no_order_biaya'    => $row['A'],
	                'marketplace'       => $market,
	                'val_ket'			=> "biaya3",
	                'keterangan'        => "Gratis Ongkir dari Shopee",
	                'biaya'             => $row['D'],
	                'tgl_input'         => date("Y-m-d"),
	                'user'              => $this->data['id'],
	            ));

	            array_push(
	              $data_biaya4, array(
	                'no_order_biaya'    => $row['A'],
	                'marketplace'       => $market,
	                'val_ket'			=> "biaya4",
	                'keterangan'        => "Ongkir yang Diteruskan oleh Shopee ke Jasa Kirim",
	                'biaya'             => $row['E'],
	                'tgl_input'         => date("Y-m-d"),
	                'user'              => $this->data['id'],
	            ));

	            array_push(
	              $data_biaya5, array(
	                'no_order_biaya'    => $row['A'],
	                'marketplace'       => $market,
	                'val_ket'			=> "biaya5",
	                'keterangan'        => "Biaya Administrasi (termasuk PPN 10%)",
	                'biaya'             => $row['F'],
	                'tgl_input'         => date("Y-m-d"),
	                'user'              => $this->data['id'],
	            ));

	            array_push(
	              $data_biaya6, array(
	                'no_order_biaya'    => $row['A'],
	                'marketplace'       => $market,
	                'val_ket'			=> "biaya6",
	                'keterangan'        => "Biaya Layanan (termasuk PPN 10%)",
	                'biaya'             => $row['G'],
	                'tgl_input'         => date("Y-m-d"),
	                'user'              => $this->data['id'],
	            ));
	        }
	        $numrow++;
	    }
	      //print_r($data);
	      $this->db->insert_batch('order_biaya', $data_biaya1);
	      $this->db->insert_batch('order_biaya', $data_biaya2);
	      $this->db->insert_batch('order_biaya', $data_biaya3);
	      $this->db->insert_batch('order_biaya', $data_biaya4);
	      $this->db->insert_batch('order_biaya', $data_biaya5);
	      $this->db->insert_batch('order_biaya', $data_biaya6);

	      //delete file from server
	      unlink(realpath('data_excel_for_update_product/'.$this->upload->data('file_name')));

	  }else if($market == "bukalapak"){
	  	foreach($sheet as $row){
	        if($numrow > 1){

	        	$no_order = $row['A'];
	        	$cekDoubledata = $this->rpp_rpk_adm->get_data_biaya($no_order);
	        	//if($row['A'] != $cekDoubledata['no_order_biaya']){ // jika tidak ada maka INSERT
	        		//array_push(
		            $data_biaya1 = array(
		                'no_order_biaya'    => $row['A'],
		                'marketplace'       => $market,
		                'val_ket'			=> strtolower(str_replace(' ', '', $row['C'])),
		                'keterangan'        => $row['C'],
		                'biaya'             => $row['B'],
		                'tgl_input'         => date("Y-m-d"),
		                'user'              => $this->data['id'],
		            );
		            $this->db->insert('order_biaya', $data_biaya1);
		            //$this->db->update_batch('order_biaya', $data_biaya1,'no_order_biaya');
		            //echo "data double";
	        	//}//else{ // jika tidak ada maka INSERT
	        	//	array_push(
		        //      $data_biaya1, array(
		        //        'no_order_biaya'    => $row['A'],
		        //        'marketplace'       => $market,
		        //        'val_ket'			=> $numrow,
		        //        'keterangan'        => $row['C'],
		        //        'biaya'             => $row['B'],
		        //        'tgl_input'         => date("Y-m-d"),
		        //        'user'              => $this->data['id'],
		        //    ));
		        //    $this->db->insert_batch('order_biaya', $data_biaya1);
		            //echo "data tidak double";
	        	//}
	        }
	        //$nobiaya++;
	        $numrow++;
	    }
	      //delete file from server
	      unlink(realpath('data_excel_for_update_product/'.$this->upload->data('file_name')));
	  }
      
      $this->session->set_flashdata('success', 'Biaya untuk marketplace '.$market.' telah berhasil ditambahkan ');
      //redirect(base_url('trueaccon2194/rpp_rpk/laporan_biaya'));
    }
	}

	function laporan_pengiriman_by_filter(){
		$tgl1_filtering = $this->security->xss_clean($this->input->post('tgl1'));
        $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1_filtering);

        $this->data['tgl1'] = $tgl1;

        $tgl2_filtering = $this->security->xss_clean($this->input->post('tgl2'));
        $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2_filtering);

        $this->data['tgl2'] = $tgl2;

        $market_filtering = $this->security->xss_clean($this->input->post('marketplace'));
        $market1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$market_filtering);

        $status_filtering = $this->security->xss_clean($this->input->post('bayar'));
        $status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$status_filtering);

        $status22_filtering = $this->security->xss_clean($this->input->post('status'));
        $status22 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$status22_filtering);
 
        $sortby2_filtering = $this->security->xss_clean($this->input->post('sortby'));
        $sortby = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$sortby2_filtering);

        $list_market = $this->onlinestore_adm->get_marketplace();
        foreach($list_market as $hx){
        	// load data marketplace
        	$mrx[] = $hx->val_market;
        }

        if($market1 == ""){
    		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
    		$market_title = "Semua Marketplace";
        }else{
        	$market = $market1;
        	$market_title = $market1;
        }
        $this->data['market'] = $market_title;
        $this->data['marketx'] = $market;

        if($status22 == "all"){

        	$status2 = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73', 'batal');
        	$this->data['status2'] = "Semua";

        }else{
        	$status2 = $status22;
        	if($status2 == "2hd8jPl613!2_^5"){
        		$this->data['status2'] = "Menunggu Pembayaran";
        	}else if($status2 == "*^56t38H53gbb^%$0-_-"){
        		$this->data['status2'] = "Pembayaran Diterima";
        	}else if($status2 == "Uywy%u3bShi)payDhal"){
        		$this->data['status2'] = "Dalam Pengiriman";
        	}else if($status2 == "ScUuses8625(62427^#&9531(73"){
        		$this->data['status2'] = "Diterima";
        	}else if($status2 == "batal"){ 
        		$this->data['status2'] = "Dibatalkan";
        	}
        }

         if($status == ""){
        	$this->data['status1'] = "Semua";
        	$status1 = array('bayar', 'belum');
        }else{
        	$status1 = $status;
        	if($status == "bayar"){
	        	$this->data['status1'] = $status;
	        }else if($status == "belum"){
	        	$this->data['status1'] = $status;
	        } 
        }	

        if($sortby == "tgl_order"){
        	$this->data['getBiaya'] = $this->onlinestore_adm->get_biaya_tgl_order($tgl1, $tgl2, $status1, $status2, $market, $senderx);
        	$this->data['terjual_by'] = "tgl_order";
        }else{
        	$this->data['getBiaya'] = $this->onlinestore_adm->get_biaya_tgl_selesai($tgl1, $tgl2, $status1, $status2, $market, $senderx);
        	$this->data['terjual_by'] = "tgl_selesai_order";
        }
		$this->load->view('manage/rpp_rpk/laporan_biaya_marketplace', $this->data);


	}
	
}