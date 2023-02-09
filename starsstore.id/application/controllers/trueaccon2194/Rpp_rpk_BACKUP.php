<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rpp_rpk extends CI_Controller { 
 
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
		$data = array_merge($success, $list_data);

		$this->load->view('manage/header');
		$this->load->view('manage/laporan/rpp_rpk/index', $data);
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman RPP / RPK');
		
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
			
        }else{

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

				$this->data['total_qty']	  	+= $v->qty;
				$this->data['total_rupiah'] 	+= ($v->harga_fix*$v->qty);//-($biaya_lazada+$vat_lazada+$vat_pencairan);
				$this->data['total_rupiah_diskon'] 	+= $diskon;// + ($biaya_lazada+$vat_lazada+$vat_pencairan);
				
			}
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
			$this->rpp_rpk_adm->add($id_user, $last_insert_id, $data); 
			
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

		$this->data['get_data'] = $this->rpp_rpk_adm->get_data_rpp($id);

		$fr = $this->rpp_rpk_adm->get_data_rpp($id);
		foreach($fr as $g){
			$this->data['bln_closing'] = $g->bulan;
			$this->data['market'] = $g->jenis_market;

			//BUAT JUDUL
			$market1 = $g->jenis_market;
			$tgl_title = $g->tanggal;

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
        $paper_size  = 'legal'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->set_base_path('qusour894/css');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        //$this->dompdf->set_base_path($css);
        $this->dompdf->stream("RPP_RPK_".$market1."_".$tgl_title.".pdf", array('Attachment'=>0));
        exit(0);
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Mencetak RPP / RPK');
	}

	function hapus(){
		$id = $this->input->get('id');
		$tgl = $this->input->get('name');
		$this->rpp_rpk_adm->hapus($id);
		$this->rpp_rpk_adm->hapus_penj_by_closing($id);
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
	
}