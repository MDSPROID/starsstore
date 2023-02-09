<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_pengiriman extends CI_Controller { 
 
	function __construct(){ 
		parent:: __construct(); 
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/laporan_pengiriman_adm'); 
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');  
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		} 
	} 
 
	function index(){ 
		$this->data['get_list'] 	= $this->laporan_pengiriman_adm->get_order_all();
		$this->data['store_list'] 	= $this->laporan_pengiriman_adm->get_toko();
		$this->data['market']		= $this->laporan_pengiriman_adm->get_marketplace();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/pengiriman/index', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Laporan Pengiriman');
	} 

	function load_all_serverside(){ 
		$list_data = $this->laporan_pengiriman_adm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach($list_data as $x){
			$no++;
			$row = array();

			$idxx = $this->encrypt->encode($x->no_order_ex); 
	        $idp = base64_encode($idxx);

			if($x->tarif == "gratis" || $x->tarif == "" || $x->tarif == 0){
            	$tarifclick = "".$x->tarif."<br><label style ='font-size:10px;' class='label label-primary'>Gratis Ongkir</label>";
          	}else{
            	$tarifclick = "Rp. ".number_format($x->tarif,0,".",".")."";
          	}

          	if($x->actual_tarif == ""){
              $tarifactual = "Rp. 0";
            }else{
              $tarifactual = "Rp. ".number_format($x->actual_tarif,0,".",".");
            }

            if($x->actual_tarif == ""){
              $selisih = "Rp. 0";
            }else{
              $selisih = "Rp. ".number_format($x->tarif - $x->actual_tarif,0,".",".")."";
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
	        
            $opsipencil = "<a target='_new' href='".base_url('trueaccon2194/laporan_pengiriman/edit_actual/'.$idp.'')."' class='btn btn-warning edit'><i class='glyphicon glyphicon-pencil'></i></a>";            
            $opsiprint = "<a href='".base_url('trueaccon2194/laporan_pengiriman/cetak_laporan/'.$idp.'')."' class='btn btn-default hapus'><i class='glyphicon glyphicon-print'></i></a>";

            if(empty($x->bayar) || $x->bayar == "belum"){
              $opsibayar = "<a href='".base_url('trueaccon2194/laporan_pengiriman/sudah_bayar/'.$idp.'')."' class='btn btn-success hapus'><i class='fa fa-money'></i></a>";
            }else{
              $opsibayar = "<a href='".base_url('trueaccon2194/laporan_pengiriman/batal_bayar/'.$idp.'')."' class='btn btn-danger hapus'><i class='fa fa-money'></i></a>";
            }

            if($x->dibayar == "belum" || $x->dibayar == ""){
            	$statusbayar = "<div style='margin-top:10px;'><label class='label label-danger'>Belum dibayar</label></div>";
          	}else{
            	$statusbayar = "<div style='margin-top:10px;'><label class='label label-success'>Sudah dibayar</label></div>";
          	}

          	//if($x->buy_in == ""){
            	$sender = "<br><i style='font-size:10px;'><b>Dikirim Oleh : <br>".$x->nama_toko." [".$x->kode_edp."]</b></i>";
            //}else{
            //   	$buy = "<br><i style='font-size:10px;'><b>Dikirim Oleh : <br>".$x->nama_toko."</b></i>";
            //}

            if(empty($x->tanggal_dikirim) || $x->tanggal_dikirim == "0000-00-00 00:00:00"){
            	$tanggal_dikirim = "-";
            }else{
            	$tanggal_dikirim = $x->tanggal_dikirim;
            }

            $srtby = $this->input->post('sortby');
            if($srtby == "tgl_order"){
            	$tgl = $x->tanggal_order;
            }else if($srtby == "tgl_selesai"){
            	$tgl = $x->tanggal_order_finish;
            }

            if($x->ongkir_ditanggung == "dari_penjualan"){
            	$ongkir_ditanggung = "Dipotong Langsung dari Penjualan oleh marketplace";
            }else{
            	$ongkir_ditanggung = $x->ongkir_ditanggung;
            }

          	// ROW START
          	$row[] = "<input type='checkbox' class='form-control' name='checklist[]' value='".$x->no_order_cus."'/>";
          	$row[] = date('d/m/Y', strtotime($x->tanggal_order));
          	//$row[] = date('d F Y', strtotime($tanggal_dikirim));//
          	$row[] = "<span style='font-size: 12px;font-weight:bold;'>".$x->invoice."<br>[ ".$x->buy_in." ]<br><br>Resi : ".$x->no_resi."</span><br>".$sender;
          	$row[] = "<span style='font-size: 12px;'>".word_limiter($x->alamat,5)."</span>";
          	$row[] = "<center><span style='font-size: 12px;'>".$x->layanan."</span></center>";
          	//$row[] = "<center>".$x->dibayar_oleh."</center>";
          	$row[] = "<span style='font-size: 12px;font-weight:bold;'><center>".$tarifclick."</center></span>";
          	$row[] = "<span style='font-size: 12px;font-weight:bold;'><center>".$tarifactual."</center></span>";
          	$row[] = "<span style='font-size: 12px;font-weight:bold;'><center>".$selisih."</center></span>";
          	$row[] = $ongkir_ditanggung;
          	$row[] = $status.$statusbayar;
          	$row[] = $opsipencil.$opsiprint;//.$opsibayar;

          	// ROW end(array)
        $data[] = $row;
    	}
 
    	$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->laporan_pengiriman_adm->count_all(),
            "recordsFiltered" => $this->laporan_pengiriman_adm->count_filtered(),
            "data" => $data,
        );
		echo json_encode($output);
	}

	function input_actual_tarif(){
		$this->data['get_list'] = $this->laporan_pengiriman_adm->get_order_all_yang_belum_diinput_tarifnya_doang();
		$this->data['market'] = $this->laporan_pengiriman_adm->get_marketplace();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/pengiriman/add', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Input actual tarif pengiriman');
	}

	function edit_actual($id){ 
		$a = base64_decode($id);
		$inv = $this->encrypt->decode($a);

		$this->data['g'] = $this->laporan_pengiriman_adm->get_data_for_edit($inv);
		$this->data['market'] = $this->laporan_pengiriman_adm->get_marketplace();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/pengiriman/edit', $this->data);	
		$this->load->view('manage/footer');
	}
 
	function proses_input_actual(){
		$data_filtering = $this->security->xss_clean($this->input->post());
        $data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
		if($this->input->post()){
        	$inv = $this->input->post('invoice'); 
        	$r = $this->laporan_pengiriman_adm->get_data_for_notif($inv);
			$id_user = $this->data['id'];

			$this->laporan_pengiriman_adm->add($id_user,$inv, $data); 
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Tarif Actual Invoice '.$r['invoice'].'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Tarif Actual invoice '.$r['invoice'].' ditambahkan!');
			redirect('trueaccon2194/laporan_pengiriman');
        
		}else{
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah Tarif Actual pada invoice '.$r['invoice'].'');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
			redirect('trueaccon2194/laporan_pengiriman/input_actual_tarif');
		}
	}

	function proses_input_actual_massal(){
		$data_filtering = $this->security->xss_clean($this->input->post());
        $data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
		if($this->input->post()){
			$id_user = $this->data['id'];

			$market_filtering = $this->security->xss_clean($this->input->post('market'));
        	$market = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$market_filtering);

        	$tgl1_filtering = $this->security->xss_clean($this->input->post('tgl1'));
        	$tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1_filtering);

        	$tgl2_filtering = $this->security->xss_clean($this->input->post('tgl2'));
        	$tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2_filtering);

        	$tarif_filtering = $this->security->xss_clean($this->input->post('tarif'));
        	$tarif = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tarif_filtering);

        	$dibayar_filtering = $this->security->xss_clean($this->input->post('dibayar'));
        	$dibayar = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$dibayar_filtering);

        	$getdatainvoice = $this->laporan_pengiriman_adm->get_invoice($market,$tgl1,$tgl2);
        	foreach($getdatainvoice as $k){
        		if($tarif == ""){ // jika tarif kosong maka tidak diupdate tarifnya (dibiarkan)
        			$datainvoice = array(
	        			//'invoice'			=> $k->invoice,
	        			//'market'			=> $k->buy_in,
						'ongkir_ditanggung' => $dibayar,//$data['tanggung_ongkir'],
						//'actual_tarif'		=> $tarif,
						'dibayar_oleh'		=> "",//$data['dibayar'],
						'tgl_input_actual'	=> date("Y-m-d"),//$tgl,
						'bayar'				=> "",//$data['bayar'],
						'id_user_add'		=> $id_user,
					);
					//print_r($datainvoice);	
					$this->db->where('no_order_ex',$k->no_order_ex);
					$this->db->update('order_expedisi', $datainvoice);	
        		}else{
        			$datainvoice = array(
	        			//'invoice'			=> $k->invoice,
	        			//'market'			=> $k->buy_in,
						'ongkir_ditanggung' => $dibayar,//$data['tanggung_ongkir'],
						'actual_tarif'		=> $tarif,
						'dibayar_oleh'		=> "",//$data['dibayar'],
						'tgl_input_actual'	=> date("Y-m-d"),//$tgl,
						'bayar'				=> "",//$data['bayar'],
						'id_user_add'		=> $id_user,
					);
					//print_r($datainvoice);	
					$this->db->where('no_order_ex',$k->no_order_ex);
					$this->db->update('order_expedisi', $datainvoice);	
        		}
        	}
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Tarif Actual Masal Marketplace '.$market.' Tanggal '.date('d/m/Y', strtotime($tgl1)).' - '.date('d/m/Y', strtotime($tgl2)).' ');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Tarif Actual invoice Marketplace '.$market.' Tanggal '.date('d/m/Y', strtotime($tgl1)).' - '.date('d/m/Y', strtotime($tgl2)).' telah ditambahkan!');
			redirect('trueaccon2194/laporan_pengiriman');
        
		}else{
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah Tarif Actual pada invoice '.$r['invoice'].'');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
			redirect('trueaccon2194/laporan_pengiriman/input_actual_tarif');
		}
	}

	function update_input_actual(){
		$a = base64_decode($this->input->post('idinv'));
		$inv = $this->encrypt->decode($a);

		$data_filtering = $this->security->xss_clean($this->input->post());
        $data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
		if($this->input->post()){
        	$r = $this->laporan_pengiriman_adm->get_data_for_notif($inv);
			$id_user = $this->data['id'];

			$this->laporan_pengiriman_adm->update($id_user,$inv, $data); 
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Tarif Actual Invoice '.$r['invoice'].'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Tarif Actual invoice '.$r['invoice'].' diupdate!');
			redirect('trueaccon2194/laporan_pengiriman');
        
		}else{
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah Tarif Actual pada invoice '.$r['invoice'].'');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
			redirect('trueaccon2194/laporan_pengiriman/input_actual_tarif');
		}
	}

	function cetak_laporan($id){
		$a = base64_decode($id);
		$inv = $this->encrypt->decode($a);
		$data['g'] = $this->laporan_pengiriman_adm->get_data_for_edit($inv);
		$g = $this->laporan_pengiriman_adm->get_data_for_edit($inv);
		//cetak laporan
		$this->load->library('dompdf_gen');
		//send data[''] to view
        $this->load->view('laporan_pdf/laporan_pengiriman', $data); 
        $paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->set_base_path('qusour894/css');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        //$this->dompdf->set_base_path($css);
        $this->dompdf->stream("Laporan-pengiriman.pdf", array('Attachment'=>0));
        exit(0);
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan pengiriman invoice '.$g['invoice'].'');
	}

	function laporan_pengiriman_by_filter(){
		// if button action
		if($this->input->post('laporan') == "excel"){
			$this->filter_laporan_penjualan_excel();
		}else if($this->input->post('laporan') == "cetak"){
			$this->filter_laporan_pengiriman_pdf();
		}else if($this->input->post('laporan') == "filter"){

			$tgl1 		= $this->security->xss_clean($this->input->post('tgl1'));
			$tgl2 		= $this->security->xss_clean($this->input->post('tgl2'));
			$market 	= $this->security->xss_clean($this->input->post('marketplace'));
			$status1 	= $this->security->xss_clean($this->input->post('status'));
			$bayar1 	= $this->security->xss_clean($this->input->post('bayar'));
			$ditanggung1 = $this->security->xss_clean($this->input->post('dibayar'));
			$sortby 	= $this->security->xss_clean($this->input->post('sortby'));

			$this->data['tgl1'] = $tgl1;
			$this->data['tgl2'] = $tgl2; 

			$list_market = $this->laporan_pengiriman_adm->get_marketplace();
	        foreach($list_market as $hx){
	        	// load data marketplace
	        	$mrx[] = $hx->val_market;
	        }

	        if($market == "semua"){
        		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
        		$market_title = "Semua Marketplace";
	        }else{
	        	$market = $market;
	        	$market_title = $market;
	        }
	        $this->data['market'] = $market_title;
 
			if($status1 == "semua"){
				$status = array('2hd8jPl613!2_^5','*^56t38H53gbb^%$0-_-','Uywy%u3bShi)payDhal','ScUuses8625(62427^#&9531(73','batal');
				$this->data['status'] = "Semua Status Invoice";
			}else{
				$status = $status1;
				if($status1 == "2hd8jPl613!2_^5"){
		            $this->data['status'] = "Menunggu Pembayaran";
		        }else if($status1 == "*^56t38H53gbb^%$0-_-"){
		            $this->data['status'] = "Pembayaran Diterima";
		       	}else if($status1 == "Uywy%u3bShi)payDhal"){
		            $this->data['status'] = "Dalam Pengiriman";
		        }else if($status1 == "ScUuses8625(62427^#&9531(73"){
		            $this->data['status'] = "Diterima";
		        }else if($status1 == "batal"){
		        	$this->data['status'] = "Batal";
		        }
			}

			if($bayar1 == "semua"){
				$bayar = array('sudah','belum');
				$this->data['bayar'] = "Semua Pembayaran"; 
			}else{
				$bayar = $bayar1;
				$this->data['bayar'] = $bayar; 
			}

			if($ditanggung1 == "semua"){
				$ditanggung = array('gratis','kantor','toko','dari_penjualan');
				$this->data['ditanggung'] = "Gratis Ongkir, Kantor, Toko, Dari Pemotongan Penjualan";
				$ditanggung_title = "Gratis Ongkir, Kantor, Toko, Dari Pemotongan Penjualan";
			}else{
				$ditanggung = $ditanggung1;
				$this->data['ditanggung'] = $ditanggung; 
				$ditanggung_title = $ditanggung1;
			}

			if($sortby == "tgl_order"){
				$this->data['get_list'] = $this->laporan_pengiriman_adm->get_data_for_range_by_tgl_order($tgl1, $tgl2, $status, $bayar,$market,$ditanggung);
	        	$this->data['sort_by'] = "tgl_order";
	        }else{
	        	$this->data['get_list'] = $this->laporan_pengiriman_adm->get_data_for_range_by_tgl_order_finish($tgl1, $tgl2, $status, $bayar,$market,$ditanggung);
	        	$this->data['sort_by'] = "tgl_selesai_order";
	        }

	        //print_r($this->data['get_list']);

			//$this->load->view('manage/header'); 
			$this->load->view('manage/laporan/pengiriman/laporan_non_cetak', $this->data);	
			//$this->load->view('manage/footer');
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Filter Laporan Pengiriman dari tanggal '.$tgl1.' - '.$tgl2.', market '.$market_title.', status order '.$status1.', status bayar '.$bayar1.', ongkir ditanggung '.$ditanggung_title.' dan sortby '.$sortby.' ');
		}
	}

	function filter_laporan_pengiriman_pdf(){

		$tgl1 		= $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 		= $this->security->xss_clean($this->input->post('tgl2'));
		$market 	= $this->security->xss_clean($this->input->post('marketplace'));
		$status1 	= $this->security->xss_clean($this->input->post('status'));
		$bayar1 	= $this->security->xss_clean($this->input->post('bayar'));
		$ditanggung1 = $this->security->xss_clean($this->input->post('dibayar'));
		$sortby 	= $this->security->xss_clean($this->input->post('sortby'));

		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2; 

		$list_market = $this->laporan_pengiriman_adm->get_marketplace();
        foreach($list_market as $hx){
        	// load data marketplace
        	$mrx[] = $hx->val_market;
        }

        if($market == "semua"){
    		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
    		$market_title = "Semua Marketplace";
        }else{
        	$market = $market;
        	$market_title = $market;
        }
        $this->data['market'] = $market_title;

		if($status1 == "semua"){
			$status = array('2hd8jPl613!2_^5','*^56t38H53gbb^%$0-_-','Uywy%u3bShi)payDhal','ScUuses8625(62427^#&9531(73','batal');
			$this->data['status'] = "Semua Status Invoice";
		}else{
			$status = $status1;
			if($status1 == "2hd8jPl613!2_^5"){
	            $this->data['status'] = "Menunggu Pembayaran";
	        }else if($status1 == "*^56t38H53gbb^%$0-_-"){
	            $this->data['status'] = "Pembayaran Diterima";
	       	}else if($status1 == "Uywy%u3bShi)payDhal"){
	            $this->data['status'] = "Dalam Pengiriman";
	        }else if($status1 == "ScUuses8625(62427^#&9531(73"){
	            $this->data['status'] = "Diterima";
	        }else if($status1 == "batal"){
	        	$this->data['status'] = "Batal";
	        }
		}

		if($bayar1 == "semua"){
			$bayar = array('sudah','belum');
			$this->data['bayar'] = "Semua Pembayaran"; 
		}else{
			$bayar = $bayar1;
			$this->data['bayar'] = $bayar; 
		}

		if($ditanggung1 == "semua"){
			$ditanggung = array('gratis','kantor','toko','dari_penjualan');
			$this->data['ditanggung'] = "Gratis Ongkir, Kantor, Toko, Dari Pemotongan Penjualan";
			$ditanggung_title = "Gratis Ongkir, Kantor, Toko, Dari Pemotongan Penjualan";
		}else{
			$ditanggung = $ditanggung1;
			$this->data['ditanggung'] = $ditanggung; 
			$ditanggung_title = $ditanggung1;
		}

		if($sortby == "tgl_order"){
			$this->data['get_list'] = $this->laporan_pengiriman_adm->get_data_for_range_by_tgl_order($tgl1, $tgl2, $status, $bayar,$market,$ditanggung);
        	$this->data['sort_by'] = "tgl_order";
        }else{
        	$this->data['get_list'] = $this->laporan_pengiriman_adm->get_data_for_range_by_tgl_order_finish($tgl1, $tgl2, $status, $bayar,$market,$ditanggung);
        	$this->data['sort_by'] = "tgl_selesai_order";
        }

		//cetak laporan
		$this->load->library('Dompdf_gen');
        $this->load->view('laporan_pdf/laporan_pengiriman_filter', $this->data);
        $paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("Laporan_pengiriman_pdf_tanggal_".$tgl1."-".$tgl2.".pdf", array('Attachment'=>0));
        exit(0);
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Pengiriman (pdf) dari tanggal '.$tgl1.' - '.$tgl2.', market '.$market_title.', status order '.$status1.', status bayar '.$bayar1.', ongkir ditanggung '.$ditanggung_title.' dan sortby '.$sortby.' ');
	}

	function filter_laporan_penjualan_excel(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		$tgl1 		= $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 		= $this->security->xss_clean($this->input->post('tgl2'));
		$market 	= $this->security->xss_clean($this->input->post('marketplace'));
		$status1 	= $this->security->xss_clean($this->input->post('status'));
		$bayar1 	= $this->security->xss_clean($this->input->post('bayar'));
		$ditanggung1 = $this->security->xss_clean($this->input->post('dibayar'));
		$sortby 	= $this->security->xss_clean($this->input->post('sortby'));

		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2; 

		$list_market = $this->laporan_pengiriman_adm->get_marketplace();
        foreach($list_market as $hx){
        	// load data marketplace
        	$mrx[] = $hx->val_market;
        }

        if($market == "semua"){
    		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
    		$market_title = "Semua Marketplace";
        }else{
        	$market = $market;
        	$market_title = $market;
        }

		if($status1 == "semua"){
			$status = array('2hd8jPl613!2_^5','*^56t38H53gbb^%$0-_-','Uywy%u3bShi)payDhal','ScUuses8625(62427^#&9531(73','batal');
			$stat = "Semua Status Invoice";
		}else{
			$status = $status1;
			if($status1 == "2hd8jPl613!2_^5"){
	            $stat = "Menunggu Pembayaran";
	        }else if($status1 == "*^56t38H53gbb^%$0-_-"){
	            $stat = "Pembayaran Diterima";
	       	}else if($status1 == "Uywy%u3bShi)payDhal"){
	            $stat = "Dalam Pengiriman";
	        }else if($status1 == "ScUuses8625(62427^#&9531(73"){
	            $stat = "Diterima";
	        }else if($status1 == "batal"){
	        	$stat = "Batal";
	        }
		}

		if($bayar1 == "semua"){
			$bayar = array('sudah','belum');
			$byr = "Semua Pembayaran"; 
		}else{
			$bayar = $bayar1;
			$byr = $bayar; 
		}

		if($ditanggung1 == "semua"){
			$ditanggung = array('gratis','kantor','toko','dari_penjualan');
			$ditanggung_title = "Semua";
		}else{
			$ditanggung = $ditanggung1;
			$ditanggung_title = $ditanggung1;
		}

		if($sortby == "tgl_order"){
			$pengiriman = $this->laporan_pengiriman_adm->get_data_for_range_by_tgl_order($tgl1, $tgl2, $status, $bayar,$market,$ditanggung);
        	$sort_by = "tgl_order";
        }else{
        	$pengiriman = $this->laporan_pengiriman_adm->get_data_for_range_by_tgl_order_finish($tgl1, $tgl2, $status, $bayar,$market,$ditanggung);
        	$sort_by = "tgl_selesai_order";
        }

	    // ubah format tanggal
	    $originalDate1 = $tgl1;
		$tgl11 = date("d/m/Y", strtotime($originalDate1));
		$originalDate2 = $tgl2;
		$tgl22 = date("d/m/Y", strtotime($originalDate2));

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

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PENGIRIMAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Laporan Pengiriman');

	    $objPHPExcel->getActiveSheet()->mergeCells('A1:N1'); // Set Merge Cell pada kolom A1 sampai I1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
	    // buat informasi apa yang ditarik
	    $objPHPExcel->getActiveSheet()->setCellValue('A3','Tanggal');
	    $objPHPExcel->getActiveSheet()->setCellValue('A4','Marketplace');
	    $objPHPExcel->getActiveSheet()->setCellValue('A5','Status Pesanan');
	    $objPHPExcel->getActiveSheet()->setCellValue('A6','Status Bayar');
	    $objPHPExcel->getActiveSheet()->setCellValue('A7','Ongkir Ditanggung');
	    $objPHPExcel->getActiveSheet()->setCellValue('A8','Sort By');
	    // tampilkan hasil informasi yang ditarik
	    $objPHPExcel->getActiveSheet()->setCellValue('B3',"".$tgl11." - ".$tgl22."");
	    $objPHPExcel->getActiveSheet()->setCellValue('B4',$market_title);
	    $objPHPExcel->getActiveSheet()->setCellValue('B5',$stat);
	    $objPHPExcel->getActiveSheet()->setCellValue('B6',$byr);
	    $objPHPExcel->getActiveSheet()->setCellValue('B7',$ditanggung_title);
	    $objPHPExcel->getActiveSheet()->setCellValue('B8',$sort_by);
		//table header
		$heading = array("Tanggal Invoice","Invoice","Marketplace","Nomor Resi","Kode EDP Toko","Toko Pengirim","Alamat Customer","Expedisi","Tarif (Click)","Tarif (Actual)","Selisih Tarif (Click & Actual)","Dibayar Oleh","Status Order");
        //loop heading
        $rowNumberH = 9;
	    $colH = 'A';
	    foreach($heading as $h){
	        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
	        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
	        $colH++;    
	    }
	    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $tc = 0;
      	$tr = 0;
      	$yy = 0; 
        // lopping

        // mulai isi data pada baris ke 9
        $baris = 10;
        foreach ($pengiriman as $frow){

	        if($frow->actual_tarif != ""){
	        	$yy += $frow->actual_tarif - $frow->tarif;
	        }

	        //if($frow->tarif == "gratis" || $frow->tarif == "" || $frow->tarif == 0){
            //  $trx = "Gratis Ongkir";
            //}else{
              $trx = $frow->tarif;
            //}

            if($frow->actual_tarif == ""){
            	$trh = "Belum Diinput";
	        }else{
	          	$trh = $frow->actual_tarif;
	        }

	        if($frow->actual_tarif == ""){
	        	$tyh = "Belum Diinput";
          	}else{
            	$tyh = $frow->actual_tarif - $frow->tarif;
          	}

          	if($frow->status == "2hd8jPl613!2_^5"){
		     	$stat1 = "Menunggu Pembayaran";
		    }else if($frow->status == "*^56t38H53gbb^%$0-_-"){
		        $stat1 = "Pembayaran Diterima";
		    }else if($frow->status == "Uywy%u3bShi)payDhal"){
		        $stat1 = "Dalam Pengiriman";
		    }else if($frow->status == "ScUuses8625(62427^#&9531(73"){
		        $stat1 = "Diterima";
		    }else if($frow->status == "batal"){
		        $stat1 = "Dibatalkan";
		    }

		    if($frow->ongkir_ditanggung == "gratis"){
	            $ditanggungx = "Gratis Ongkir";
	        }else if($frow->ongkir_ditanggung == "kantor"){
	            $ditanggungx = "Kantor";
	        }else if($frow->ongkir_ditanggung == "toko"){
	            $ditanggungx = "Toko";
	        }else{
	            $ditanggungx = "Dipotong Langsung dari Penjualan oleh marketplace";
	        }

	        $tarif = $frow->tarif;
	        $act   = $frow->actual_tarif;
	        $tc +=($tarif);
	        $tr +=($act);

	        if($sort_by == "tgl_order"){
	           $tglxx = date("d/m/Y", strtotime($frow->tanggal_order));
	        }else{
	           $tglxx = date("d/m/Y", strtotime($frow->tanggal_order_finish));
	        }
             
            //pemanggilan sesuaikan dengan nama kolom tabel
        	$objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $tglxx); //TGL INVOICE
            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $frow->invoice); //INVOICE
            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $frow->buy_in); // buy in
            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $frow->no_resi); //no resi
            $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $frow->kode_edp); //kode edp
            $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $frow->nama_toko); //NAMA TOKO
            $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, $frow->alamat); //ALAMAT
            $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, $frow->layanan); // EXPEDISI
            //$objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $frow->dibayar_oleh); // ETD
            $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, $trx); // TARIF
            $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, round($trh)); // ACTUAL TARIF
            $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, round($tyh)); // SELISIH TARIF

            $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, $ditanggungx); // STATUS
            $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, $stat1); // STATUS

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
        }
	    $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, "Total");
	    $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, round($tc)); 	
	    $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, round($tr)); 
	    $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, round($yy)); 
	    $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, ""); 
	    $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, ""); 	

	    // apply style
	    $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
	    $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
        // end lopping

         // Set width kolom
	   	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	    
	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		// Redirect output to a client’s web browser (Excel5)
		$filename = urlencode("Laporan_Pengiriman_".$tgl11."-".$tgl22."_marketplace_".$market_title."_Status_Pesanan_".$stat."_Status_Bayar_".$byr."_Ongkir_Ditanggung_".$ditanggung_title."_Sort_By_".$sort_by.".xls");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Pengiriman (Excel) dari tanggal '.$tgl1.' - '.$tgl2.', marketplace '.$market_title.', status order '.$status1.', status bayar '.$bayar1.', Ongkir Ditanggung '.$ditanggung_title.' dan Sort By '.$sort_by.'');
	}

	function sudah_bayar($id){ // bayar
		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);
		$this->laporan_pengiriman_adm->bayar($idp);
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Mengubah status bayar pada Laporan Pengiriman no. transaksi ('.$idp.')');
		redirect($this->agent->referrer());
	}

	function batal_bayar($id){ // belum bayar
		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);
		$this->laporan_pengiriman_adm->belum_bayar($idp);
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Mengubah status belum bayar pada Laporan pengiriman no. transaksi ('.$idp.')');
		redirect($this->agent->referrer());
	}

	function getongkirlabel(){
		$inv1 = $this->security->xss_clean($this->input->post('inv'));
		$getpricelabel = $this->laporan_pengiriman_adm->get_price_label($inv1);
		echo "Tarif Label : Rp. ".number_format($getpricelabel['tarif'],0,".",".")."<br><br>";
	}
}