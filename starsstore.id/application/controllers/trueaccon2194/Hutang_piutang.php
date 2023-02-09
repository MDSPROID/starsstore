<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hutang_piutang extends CI_Controller { 

	function __construct(){ 
		parent:: __construct();
		$this->load->model('sec47logaccess/hutang_piutang_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}
 
	function index(){

		$this->data['get_list'] = $this->hutang_piutang_adm->get_order_all();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/hutang_piutang/index', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Laporan Hutang & Piutang');
	} 

	function input_actual_tarif(){
		$this->data['get_list'] = $this->hutang_piutang_adm->get_order_all_yang_belum_diinput_tarifnya_doang();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/hutang_piutang/add', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Input actual tarif pengiriman');
	}

	function edit_actual($id){
		$a = base64_decode($id);
		$inv = $this->encrypt->decode($a);

		$this->data['g'] = $this->hutang_piutang_adm->get_data_for_edit($inv);
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/hutang_piutang/edit', $this->data);	
		$this->load->view('manage/footer');
	}

	function proses_input_actual(){
		$data_filtering = $this->security->xss_clean($this->input->post());
        $data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
		if($this->input->post()){
        	$inv = $this->input->post('invoice'); 
        	$r = $this->hutang_piutang_adm->get_data_for_notif($inv);
			$id_user = $this->data['id'];

			$this->hutang_piutang_adm->add($id_user,$inv, $data); 
			log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Tarif Actual Invoice '.$r['invoice'].'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Tarif Actual invoice '.$r['invoice'].' ditambahkan!');
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
        	$r = $this->hutang_piutang_adm->get_data_for_notif($inv);
			$id_user = $this->data['id'];

			$this->hutang_piutang_adm->update($id_user,$inv, $data); 
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
		$data['g'] = $this->hutang_piutang_adm->get_data_for_edit($inv);

		$g = $this->hutang_piutang_adm->get_data_for_edit($inv);
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

	function laporan_pengiriman_non_cetak(){
		// if button action
		if($this->input->post('laporan') == "excel"){
			$this->filter_laporan_penjualan_excel();
		}else if($this->input->post('laporan') == "cetak"){
			$this->filter_laporan_pengiriman_pdf();
		}else if($this->input->post('laporan') == "filter"){

		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));
		$status = $this->security->xss_clean($this->input->post('status'));

		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2;
		$this->data['status'] = $status;
	
		$this->data['get_list'] = $this->hutang_piutang_adm->get_data_for_range($tgl1, $tgl2, $status);

		$this->load->view('manage/header');
		$this->load->view('manage/laporan/hutang_piutang/laporan_non_cetak', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Filter Laporan Pengiriman (non cetak) dari tanggal '.$tgl1.' - '.$tgl2.', status order '.$status.'');
		}
	}

	function filter_laporan_pengiriman_pdf(){
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));
		$status = $this->security->xss_clean($this->input->post('status'));

		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2;
		$this->data['status'] = $status;
		
		$this->data['pengiriman'] = $this->hutang_piutang_adm->get_data_for_range($tgl1, $tgl2, $status);

		//cetak laporan
		$this->load->library('dompdf_gen');
		//send data[''] to view
        $this->load->view('laporan_pdf/laporan_pengiriman_filter', $this->data);
        $paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->set_base_path('qusour894/css');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        //$this->dompdf->set_base_path($css);
        $this->dompdf->stream("Laporan-pengiriman_pdf.pdf", array('Attachment'=>0));
        exit(0);
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Pengiriman (pdf) dari tanggal '.$tgl1.' - '.$tgl2.', status order '.$status.'');
	}

	function filter_laporan_penjualan_excel(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));
		$status = $this->security->xss_clean($this->input->post('status'));

		
		$pengiriman = $this->hutang_piutang_adm->get_data_for_range($tgl1, $tgl2, $status);

		if($status == "2hd8jPl613!2_^5"){
	     	$stat = "Menunggu Pembayaran";
	    }else if($status == "*^56t38H53gbb^%$0-_-"){
	        $stat = "Pembayaran Diterima";
	    }else if($status == "Uywy%u3bShi)payDhal"){
	        $stat = "Dalam Pengiriman";
	    }else if($status == "ScUuses8625(62427^#&9531(73"){
	        $stat = "Diterima";
	    }else if($status == "ErNondyj3723815##629)&5+02"){
	        $stat = "Dibatalkan";
	    }

	    // ubah format tanggal
	    $originalDate1 = $tgl1;
		$tgl11 = date("d-m-Y", strtotime($originalDate1));
		$originalDate2 = $tgl2;
		$tgl22 = date("d-m-Y", strtotime($originalDate2));

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
		if(empty($pengiriman)){

		}else{
			
			// Create a first sheet, representing sales data
			$objPHPExcel->setActiveSheetIndex(0);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PENGIRIMAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('Laporan Pengiriman');

		    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai I1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		    // buat informasi apa yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('A3','Tanggal');
		    $objPHPExcel->getActiveSheet()->setCellValue('A4','Status');
		    // tampilkan hasil informasi yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('B3',"".$tgl11."-".$tgl22."");
		    $objPHPExcel->getActiveSheet()->setCellValue('B4',$stat);
			//table header
			$heading = array("Invoice","Kota ","Provinsi","Layanan","ETD","Tarif (Click)","Tarif (Actual)","Selisih Tarif (Click & Actual)","Status Order");
	        //loop heading
	        $rowNumberH = 6;
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
	        $baris = 7;
	        foreach ($pengiriman as $frow){

	        if(empty($frow->actual_tarif)){

	        }else{
	          $yy += $frow->tarif - $frow->actual_tarif;
	        }

	        if($frow->tarif == "gratis"){
              $trx = "Gratis Ongkir";
            }else{
              $trx = round($frow->tarif);
            }

            if(empty($frow->actual_tarif)){
            	$trh = "";
	        }else{
	          	$trh = $frow->actual_tarif;
	        }

	        if(empty($frow->actual_tarif)){
	        	$tyh = "";
          	}else{
            	$tyh = $frow->tarif - $frow->actual_tarif;
          	}

	        $tarif = $frow->tarif;
	        $act   = $frow->actual_tarif;
	        $tc +=($tarif);
	        $tr +=($act);
	             
	            //pemanggilan sesuaikan dengan nama kolom tabel
	            $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $frow->invoice); //INVOICE
	            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $frow->kota); //KOTA
	            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $frow->provinsi); //PROVINSI
	            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $frow->layanan); // LAYANAN
	            $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $frow->etd); // ETD
	            $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $trx); // TARIF
	            $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, round($trh)); // ACTUAL TARIF
	            $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, round($tyh)); // SELISIH TARIF
	            $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, $stat); // STATUS

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
	            $baris++;
	        }
		    $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, "Total");
		    $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, round($tc)); 
		    $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, round($tr)); 
		    $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, round($yy)); 
		    $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, ""); 

		    // apply style
		    $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		    $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
	        // end lopping

	         // Set width kolom
		   	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30); 
		    
		    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		}

		// Redirect output to a client’s web browser (Excel5)
		$filename = urlencode("Laporan Pengiriman ".$tgl11."-".$tgl22." status ".$stat.".xls");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Order (Excel) dari tanggal '.$tgl1.' - '.$tgl2.', status order '.$status.'');
	}
}