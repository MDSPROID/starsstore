<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inout extends CI_Controller { 
 
	function __construct(){ 
		parent::__construct();
		$this->load->model(array('sec47logaccess/inout_adm','sec47logaccess/onlinestore_adm'));
		$this->data['id'] = $this->session->userdata('id'); 
		$this->load->library(array('upload','encrypt'));
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		} 
	}

	function index(){ // get data
		$success = array( 'error' => '', 'success' => '');
		$list_data['get_list'] = $this->inout_adm->get_list();
		$list_data['market'] = $this->onlinestore_adm->get_marketplace();
		$data = array_merge($success, $list_data);
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/inout/index', $data);
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Barang Masuk & Keluar');
	}

	function load_produk_serverside(){
    $list_data = $this->produk_adm->get_datatables();//get_list_produk();
    //$dx = json_encode($list_data, true);
    $data = array();
    $no = $_POST['start'];
    foreach($list_data as $x){
      $no++;
      $row = array();

      // ID & SKU
      $idp = $x->id_produk;
      $skup = $x->sku_produk;

      // HARGA
      if($x->harga_dicoret == 0 || empty($x->harga_dicoret)){ 
        $harga = "Rp. ".number_format($x->harga_fix,0,".",".")."";
      }else{
        $harga = "<s style='color:#989898 ;'>Rp. ".number_format($x->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($x->harga_fix,0,".",".")."</span> <label class='label-diskon' style='margin-left:5px;'>".round(($x->harga_dicoret - $x->harga_fix) / $x->harga_dicoret * 100)." %</label>";
      }
      // END HARGA

      // STATUS LABEL
      if($x->status == "on"){
        $stx = "<label style='top:7px;position:relative;' class='label label-success'>Aktif</label>";
      }else{
        $stx = "<label style='top:7px;position:relative;' class='label label-danger'>Tidak aktif</label>";
      }
      // END STATUS LABEL

      // stok global (baru)
      if($x->stok_global == ""){
        $stok_global = 0;
      }else{
        $stok_global = $x->stok_global;
      }

      // jumlah gambar tambahan *NEW

      $getGB = $this->produk_adm->get_gbdata($skup);
      //if($getGB['totalgambar'] > 0){
      $jumlahgambar = $getGB['totalgambar'];
      //}else{
      //  $jumlahgambar = 0;
      //}

      // warna
      $idprodukforcolor = $x->id_produk;
      $warna =  $this->produk_adm->get_color_list($idprodukforcolor);

      // last check stok // NEW
      if($x->last_check_stok == "0000-00-00" ){
        $last_check_stok =  " - ";
      }else{
        $last_check_stok = date("d/m/y",strtotime($x->last_check_stok));
      }

      $id = $this->encrypt->encode($x->id_produk);  
      $idx = base64_encode($id);
      $row[] = date('d/m/y', strtotime($x->tgl_dibuat));
      $row[] = "<img src='".$x->gambar."' height='70' onError='this.onerror=null;this.src='".base_url('assets/images/produk/default.jpg')."'><br>".$stx."<br> <label style='top:18px;position:relative;' class='label label-primary'>".$x->kategori." - ".$x->parent_kategori."</label><br><br>Total Gambar : ".$jumlahgambar;
      $row[] = "<a target='_new' href='".base_url('trueaccon2194/produk/edit_data/'.$idx.'')."'>".$x->nama_produk."</a>";
      $row[] = "<center><a href='javscript:void(0);' onclick='uploadanyimage(".$x->id_produk.");'>".$x->artikel."<br><img src='".$x->logo."' height='50' onError='this.onerror=null;this.src='".base_url('assets/images/produk/default.jpg')."'><br><br><label class='label label-default' style='font-size:12px;'><b>Warna : ".$warna['opsi_color']."</b></label></center>";
      $row[] = $stok_global." Psg<br><span style='font-size:12px;'>Last Cek :<br>".$last_check_stok."</span>";
      $row[] = $harga;

      if($x->status == "on"){
            $status = "<a style='padding:3px 8px;' href='".base_url('trueaccon2194/produk/off/'.$x->id_produk.'')."' class='btn btn-danger edit'>OFF</a>";
          }else{
            $status = "<a style='padding:3px 8px;' href='".base_url('trueaccon2194/produk/on/'.$x->id_produk.'')."' class='btn btn-success edit'>ON</a>";
          }          
          
          $id = $this->encrypt->encode($x->id_produk); 
          $idx = base64_encode($id);
          // edit
          $edit = "<a target='_new' href='".base_url('trueaccon2194/produk/edit_data/'.$idx.'')."' class='btn btn-warning edit'><i class='glyphicon glyphicon-pencil'></i></a>";
          // remove
          $remove = "<a href='javascript:void(0)'' class='btn btn-danger hapus' data-id='".$idx."' data-name='".$x->nama_produk."' onclick='pindahkan_tong(this);'><i class='glyphicon glyphicon-remove'></i></a>";
          $duplikat = "<a href='".base_url('trueaccon2194/produk/duplikat_data/'.$idx.'')."' class='btn btn-primary'><i class='glyphicon glyphicon-copy'></i></a>";
          
          $row[] = $status.''.$edit.''.$remove.''.$duplikat;

      $data[] = $row;
    }

    $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->produk_adm->count_all(),
            "recordsFiltered" => $this->produk_adm->count_filtered(),
            "data" => $data,
        );
    echo json_encode($output);
  }

	function export_shop_list(){
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
		$toko = $this->inout_adm->count_toko_aktif();
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "SHOP LIST AKTIF ".$toko['jumlahtoko'].""); // Set kolom A1 dengan tulisan "DATA SISWA"
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('SHOP LIST TOKO AKTIF');

	    $objPHPExcel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		//table header
		$heading = array("Kode EDP","Nama Toko","Alamat","Area","BDM","Nomor Telepon SPV","Nomor Telepon BDM");
        //loop heading
        $rowNumberH = 3;
	    $colH = 'A';
	    foreach($heading as $h){
	        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
	        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
	        $colH++;    
	    }
	    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
       	$shoplist = $this->inout_adm->getstore();
        // lopping
        // mulai isi data pada baris ke 9
        $baris = 4;
        foreach($shoplist as $y){
            //pemanggilan sesuaikan dengan nama kolom tabel
            $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $y->kode_edp); //KODE EDP
            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $y->nama_toko); // Nama toko
            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $y->alamat); // alamat
            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $y->area); // area
            $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $y->nama_bdm); // nama bdm
            $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $y->spv_nomor); // nomor spv
            $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, $y->telp); // nomor bdm

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	      	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
            $baris++;
        }
        // end lopping
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);  
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);  
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);  
	    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);  
	    
	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		// Redirect output to a client’s web browser (Excel5)
		$filename = urlencode("Shop_List.xls");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');		
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak excel shop list');
	}

	function input(){ 
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/inout/add');
		$this->load->view('manage/footer');
	}

	function preview_produk($id){ // get preview data
		$data = $this->inout_adm->get_list_produk_for_preview($id);
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Preview ID Produk ('.$id.')');
		echo json_encode($data);
	}

	function tambah_inout(){ // proses tambah data produk
		//if($this->input->post('jenis') == ""){
		//	$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
	 	//	redirect($this->agent->referrer());
	 	//}

 		//$id_inv = $this->security->xss_clean($this->input->post('inv_pesanan'));
 		//$tr = $this->inout_adm->cek_tanggal_selesai_order($id_inv);
 		//foreach($tr as $e){
 		//	$tgl_selesai = $e->tanggal_order_finish;

 		//	if($tgl_selesai == "" || $tgl_selesai == "0000-00-00" || $tgl_selesai == "1970-01-01"){
 		//		$input_tgl_selesai = "";
	 	//	}else{
	 	//		$input_tgl_selesai = $tgl_selesai;
	 	//	}

 		if($this->input->post()){
        	$inv = $this->input->post('inv');
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

        	// pecah nomor pesanan ke tabel inout_inv
        	$pecahinv = explode(',', $data['inv_pesanan']);
			$invpx = count($pecahinv);
			foreach($pecahinv as $gx){
				$id_pesanan  = 	$gx;
				// cek pesanan di tabel inout_inv
	    		$r = $this->inout_adm->cek_inv_inout($id_pesanan);
	    		if($r->num_rows() > 0 ){
	    			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah laporan barang mausk / keluar karena ada yang sudah pernah di input nomor invoice pesanannya.');
					$this->session->set_flashdata('error', 'Nomor pesanan ada yang sudah di input sebelumnya. silahkan cek ulang.');		
					//redirect('trueaccon2194/inout');
	    		}else{
	    			$id_user = $this->data['id'];

					//foreach($pecahinv as $gx){
						$datainout = array(
							'id_inout'  => $data['inv'],
							'inv'		=> $gx,
						);
						$this->inout_adm->insert_inv_inout($datainout);
					//}

					log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Menambah laporan barang masuk/ keluar dengan no. invoice '.$inv.'');
					$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Laporan '.$inv.' ditambahkan!');
	    		}
			}
			$this->inout_adm->add($id_user, $data); 
			redirect('trueaccon2194/inout');
    
		}else{
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah laporan barang mausk / keluar');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
		}

 		//}
       
	}

	function cekInvInout(){
		$data_filtering = $this->security->xss_clean($this->input->get('pesanan'));
    	$x = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

		$pecahinv = explode(',', $x);
		$invpx = count($pecahinv);
		foreach($pecahinv as $gx){
			$id_pesanan  = 	$gx;
			// cek pesanan di tabel inout_inv
    		$r = $this->inout_adm->cek_inv_inout($id_pesanan);
    		if($r->num_rows() > 0 ){
    			$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('status' => 'already', 'idpesanan'=> $id_pesanan)));
    		}
		}
	}

	function cekInvInout_already(){
		$data_filtering = $this->security->xss_clean($this->input->get('inv'));
    	$id_pesanan = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

		$r = $this->inout_adm->cek_inv_inout_already($id_pesanan);
		if($r->num_rows() > 0 ){
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('status' => 'already', 'idpesanan'=> $id_pesanan)));
		}
	}

	function edit($id){
		$this->data['g']	= $this->inout_adm->get_data($id);
		$this->data['datainv']	= $this->inout_adm->get_data_inv($id);

		$this->load->view('manage/header');
		$this->load->view('manage/laporan/inout/edit', $this->data);
		$this->load->view('manage/footer');
	}

	function update_inout(){ // proses tambah data produk
		$id = $this->input->post('idinout');
		$inv = $this->input->post('inv');

		if($this->input->post()){

			$data_filtering = $this->security->xss_clean($this->input->post());
    		$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

			$id_user = $this->data['id'];

			// update tanggal selesai order pada tabel inout dari order_customer
			//$id_inv = $this->input->post('inv_pesanan');
	 		//$tr = $this->inout_adm->cek_tanggal_selesai_order($id_inv);

	 		//foreach($tr as $e){
	 		//	$tgl_selesai = $e->tanggal_order_finish;
	 			
	 		//	if($id_inv == ""){
		 	//		echo "invoice koksog";
		 	//	}

	 		//	if($tgl_selesai == "" || $tgl_selesai == "0000-00-00" || $tgl_selesai == "1970-01-01"){
	 		//		$input_tgl_selesai = "0000-00-00";
		 	//	}else{
		 	//		$input_tgl_selesai = $tgl_selesai;
		 	//	}
		 	//	
		 		//$this->inout_adm->update($id,$id_user,$data,$id_inv1,$input_tgl_selesai); 
			//}

			// pecah nomor pesanan ke tabel inout_inv
        	$pecahinv = explode(',', $data['inv_pesanan']);
			$invpx = count($pecahinv);
			foreach($pecahinv as $gx){
				$id_pesanan  = 	$gx;
				// cek pesanan di tabel inout_inv
	    		//$r = $this->inout_adm->cek_inv_inout($id_pesanan);
	    		//if($r->num_rows() > 0 ){
	    		//	log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah laporan barang mausk / keluar karena ada yang sudah pernah di input nomor invoice pesanannya.');
				//	$this->session->set_flashdata('error', 'Nomor pesanan ada yang sudah di input sebelumnya. silahkan cek ulang.');		
					//redirect('trueaccon2194/inout');
	    		//}else{
	    			$id_user = $this->data['id'];

	    			$this->db->delete('inout_inv', array('inv' => $gx));
					//foreach($pecahinv as $gx){
						$datainout = array(
							'id_inout'  => $data['inv'],
							'inv'		=> $gx,
						);
						$this->inout_adm->insert_inv_inout($datainout);
					//}

					log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Laporan barang masuk / keluar no. invoice ('.$inv.')');
					$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Laporan '.$inv.' telah diubah!');
	    		//}
			}
			$this->inout_adm->update($id,$id_user,$data); 
			redirect('trueaccon2194/inout');
		}else{
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Mengubah laporan barang masuk / keluar no. invoice('.$inv.')');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi internet anda');
		}
		
	}

	function hapus($id){
		$idf = base64_decode($id);
		$idx = $this->encrypt->decode($idf);
		$data = $this->inout_adm->get_data_before_delete($idx);
		foreach($data as $r){
			$inv = $r->invoice;
		}
		$this->inout_adm->hapus($idx);
		$this->inout_adm->hapus_inout_inv($inv);
		$this->session->set_flashdata('error', 'Laporan Invoice '.$inv.' dihapus!');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Laporan barang masuk & keluar no. invoice ('.$inv.')');
		redirect(base_url('trueaccon2194/inout'));
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$cek = $this->input->post('checklist');
			$this->inout_adm->remove_dipilih($cek);
			print_r($cek);
			log_helper("laporan", "Menghapus Produk yang dipilih");
			//redirect('trueaccon2194/produk');
	}

	function laporan_inout(){
		// if button action
		if($this->input->post('laporan') == "excel"){
			$this->filter_laporan_inout_excel();
		}else if($this->input->post('laporan') == "cetak"){
			$this->filter_laporan_inout_pdf();
		}else if($this->input->post('laporan') == "filter"){

		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));	
		//$market = $this->security->xss_clean($this->input->post('marketplace'));	

		$this->data['get_list'] = $this->inout_adm->get_laporan_by_tgl($tgl1, $tgl2);

		// global information
		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2;

		$this->load->view('manage/header');
		$this->load->view('manage/laporan/inout/laporan_non_cetak', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Filter Laporan Barang masuk & keluar (non cetak) dari tanggal '.$tgl1.' - '.$tgl2.'');
		}
	}

	function filter_laporan_inout_pdf(){
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));	
		//$market = $this->security->xss_clean($this->input->post('marketplace'));	

		$this->data['get_list'] = $this->inout_adm->get_laporan_by_tgl($tgl1, $tgl2);

		// global information
		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2;

		//cetak laporan
		$this->load->library('dompdf_gen');
		//send data[''] to view
		$this->load->view('laporan_pdf/laporan_pdf_inout', $this->data);	
        $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        //$this->dompdf->set_base_path($css);
        $this->dompdf->stream("Laporan-barang-masuk-dan-keluar-".$tgl1."-".$tgl2.".pdf", array('Attachment'=>0));
        exit(0);
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Barang masuk & keluar (pdf) dari tanggal '.$tgl1.' - '.$tgl2.'');
	}

	function filter_laporan_inout_excel(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));	
		//$market = $this->security->xss_clean($this->input->post('marketplace'));	

		$get_list = $this->inout_adm->get_laporan_by_tgl($tgl1, $tgl2);

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

	    foreach($get_list as $data){
    	if($data->jenis == "masuk"){
    	// Create a first sheet, representing sales data
		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "PERTELAAN BARANG MASUK & KELUAR"); // Set kolom A1 dengan tulisan "DATA SISWA"
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Barang Masuk');

	    $objPHPExcel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
	    // buat informasi apa yang ditarik
	    $objPHPExcel->getActiveSheet()->setCellValue('A3','ALAMAT :');
	    $objPHPExcel->getActiveSheet()->setCellValue('A4','EDP CODE :');
	    $objPHPExcel->getActiveSheet()->setCellValue('F3','PERIODE :');
	    $objPHPExcel->getActiveSheet()->setCellValue('F4','MINGGU :');
	    // tampilkan hasil informasi yang ditarik
	    $objPHPExcel->getActiveSheet()->setCellValue('B3',"Toko E-commerce");
	    $objPHPExcel->getActiveSheet()->setCellValue('B4',"100-01");
	    $objPHPExcel->getActiveSheet()->setCellValue('G3',''.date('d F Y', strtotime($tgl1)).' - '.date('d F Y', strtotime($tgl2)).'');
	    $objPHPExcel->getActiveSheet()->setCellValue('G4','.............................');
		//table header
		$objPHPExcel->getActiveSheet()->setCellValue('A6','BARANG MASUK');
		$objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE); // Set bold kolom A1
		$heading = array("TANGGAL","NO. INV","PASANG","RUPIAH","DARI","KETERANGAN", "NO. PESANAN");
        //loop heading
        $rowNumberH = 8;
	    $colH = 'A';
	    foreach($heading as $h){
	        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
	        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
	        $colH++;    
	    }
	    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
	    $tc = 0;
        $tr = 0;
        // lopping
        // mulai isi data pada baris ke 8
        $baris = 9;
        foreach($get_list as $data){
    	if($data->jenis == "masuk"){
    	$tc +=($data->pasang);
        $tr +=($data->rupiah);

        $idinvoice = $data->invoice;
	    $get_inv = $this->inout_adm->get_list_inv($idinvoice);
	    $invxx = array();
	    foreach($get_inv as $k){
	        $invxx[] = $k->inv;
	    }
	    $invx = implode(', ',$invxx);

        //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("A".$baris,  date('d/m/y',strtotime($data->tanggal))); //TANGGAL
        $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $data->invoice); //INVOICE
        $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $data->pasang); //PASANG
        $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $data->rupiah); // RUPIAH
        $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $data->source); // SUMBER
        $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $data->keterangan); // KET
        $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, $invx); // INVOICE
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
      	$baris++;
      	}}
      	$objPHPExcel->getActiveSheet()->setCellValue("A".$baris,"TOTAL");
      	$objPHPExcel->getActiveSheet()->setCellValue("B".$baris, "");
	    $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $tc); 
	    $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $tr); 
	    $objPHPExcel->getActiveSheet()->setCellValue("E".$baris,"");
	    $objPHPExcel->getActiveSheet()->setCellValue("F".$baris,"");
	    $objPHPExcel->getActiveSheet()->setCellValue("G".$baris,"");
	    // apply style
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	    $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
        // end lopping
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);  
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);  
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);  
	    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);  
	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		}}

		foreach($get_list as $data){
    	if($data->jenis == "keluar"){
		// BUAT SHEET BARU
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex(1);
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', "PERTELAAN BARANG MASUK & KELUAR"); // Set kolom A1

		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Barang Keluar');

	    $objPHPExcel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
	    // buat informasi apa yang ditarik
	    $objPHPExcel->getActiveSheet()->setCellValue('A3','ALAMAT :');
	    $objPHPExcel->getActiveSheet()->setCellValue('A4','EDP CODE :');
	    $objPHPExcel->getActiveSheet()->setCellValue('E3','PERIODE :');
	    $objPHPExcel->getActiveSheet()->setCellValue('E4','MINGGU :');
	    // tampilkan hasil informasi yang ditarik
	    $objPHPExcel->getActiveSheet()->setCellValue('B3',"Toko E-commerce");
	    $objPHPExcel->getActiveSheet()->setCellValue('B4',"100-01");
	    $objPHPExcel->getActiveSheet()->setCellValue('F3',''.date('F Y', strtotime($tgl2)).'');
	    $objPHPExcel->getActiveSheet()->setCellValue('F4','.............................');
		//table header
		$objPHPExcel->getActiveSheet()->setCellValue('A6','BARANG KELUAR');
		$objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE); // Set bold kolom A1
		$heading = array("TANGGAL","NO. INV","PASANG","RUPIAH","KE","KETERANGAN");
        //loop heading
        $rowNumberH = 7;
	    $colH = 'A';
	    foreach($heading as $h){
	        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
	        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
	        $colH++;    
	    }
	    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
	    $tc = 0;
        $tr = 0;
        // lopping
        // mulai isi data pada baris ke 8
        $baris = 8;
        foreach($get_list as $data){
    	if($data->jenis == "keluar"){
    	$tc +=($data->pasang);
        $tr +=($data->rupiah);

        //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("A".$baris,  date('d/m/y',strtotime($data->tanggal))); //TANGGAL
        $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $data->invoice); //INVOICE
        $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $data->pasang); //PASANG
        $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $data->rupiah); // RUPIAH
        $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $data->source); // SUMBER
        $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $data->keterangan); // KET
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
      	$baris++;
      	}}
      	$objPHPExcel->getActiveSheet()->setCellValue("A".$baris,"TOTAL");
      	$objPHPExcel->getActiveSheet()->setCellValue("B".$baris, "");
	    $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $tc); 
	    $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $tr); 
	    $objPHPExcel->getActiveSheet()->setCellValue("E".$baris,"");
	    $objPHPExcel->getActiveSheet()->setCellValue("F".$baris,"");
	    // apply style
	    $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	    $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
        // end lopping
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40); 
	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		}}

		// Redirect output to a client’s web browser (Excel5)
		$filename = urlencode("Laporan barang masuk & keluar ".$tgl1."-".$tgl2.".xls");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Barang masuk & keluar (Excel) dari tanggal '.$tgl1.' - '.$tgl2.'');
	}

	function upload_dmk_by_excel(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

	    $config['upload_path'] = realpath('data_excel_for_update_product');
	    $config['allowed_types'] = 'xlsx|xls|csv';
	    $config['max_size'] = '10000';
	    //$config['encrypt_name'] = true;
	    //$config['file_name'] = $this->fileupload;
	    $this->upload->initialize($config);

	    if(!$this->upload->do_upload('fileupload')) { //upload gagal
	      $this->session->set_flashdata('error', $this->upload->display_errors());
	      redirect($this->agent->referrer());
	    }else{ // BERHASIL
	      //$this->upload->do_upload('uploadprodukbyexcel'); // upload
	      $file    = $this->upload->data();  //DIUPLOAD DULU KE DIREKTORI 
	      $fupload = $file['file_name'];

	      $excelreader  = new PHPExcel_Reader_Excel5();
	      $loadexcel    = $excelreader->load('data_excel_for_update_product/'.$fupload.''); // Load file yang telah diupload ke folder data_excel_for_update_product
	      $sheet        = $loadexcel->getActiveSheet()->toArray(null,true,true,true);
	      $data_dmk = array();
	      $numrow = 1;

	      	foreach($sheet as $row){
	        	if($numrow > 1){
		            
			        // cek double data
			        $tanggal 	= $row['A'];
			        $kode_edp 	= $row['B'];
			        $artikel 	= $row['C'];
			        $size 		= $row['F'];
			        $qty 		= $row['G'];
			        $cekD = $this->inout_adm->doubleData($tanggal,$kode_edp,$artikel,$size,$qty);
			        if($cekD->num_rows() == 0){ //jika data tidak double maka input
		              	//echo "data tidak ditemukan";
		              	$data_dmk = array(
			                'tanggal'           => $row['A'],
			                'kode_edp'			=> $row['B'],
			                'artikel'	      	=> $row['C'], 
			                'nama_project'      => $row['D'],
			                'harga'             => $row['E'],
			                'size'		        => $row['F'],
			                'qty'	            => $row['G'],
			                'date_export'		=> date("Y-m-d H:i:s"),
			            );
			            $this->db->insert('dmk', $data_dmk);
			            //print_r($data_dmk);
			        }
	        	}
	        	$numrow++;
	    	}
	    	//echo "ini nama file ".$fupload."";
	    	unlink(realpath('data_excel_for_update_product/'.$fupload.''));
	      	$this->session->set_flashdata('success', 'Upload DMK Berhasil, silahkan cek data.');
	      	redirect($this->agent->referrer());
		}
	}
	
}