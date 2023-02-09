<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_order extends CI_Controller { 

	function __construct(){ 
		parent:: __construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/report_order_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){ 
			redirect(base_url());
		}
	} 
  
	function index(){
		//$this->data['jenisoption'] = $this->report_order_adm->get_jenis();
		//$this->data['divisioption'] = $this->report_order_adm->get_divisi();
		$this->data['data'] = $this->report_order_adm->get_order_all();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/order/index', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Rasio Perolehan');
	} 

	function laporan_penjualan(){
		// if button action
		if($this->input->post('laporan') == "excel"){
			$this->filter_laporan_penjualan_excel();
		}else if($this->input->post('laporan') == "cetak"){
			$this->filter_laporan_penjualan_pdf();
		}else if($this->input->post('laporan' == "filter_detail")){
			$this->filter_detail();
		}else if($this->input->post('laporan') == "filter"){

		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));
		//$divisi = $this->security->xss_clean($this->input->post('divisi'));
		//$jenis = $this->security->xss_clean($this->input->post('jenis_artikel'));
		$status = $this->security->xss_clean($this->input->post('status'));
		$bayar = $this->security->xss_clean($this->input->post('bayar'));

		// global information
		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2;
		//$this->data['jenis'] = $jenis;
		$this->data['status'] = $status;
		$this->data['bayar'] = $bayar;

		//foreach($get_artikel as $h){
		//	$odvmaster		= $h->odvM;
		//	$retailmaster	= $h->retailM;
		//}
		//echo $odvmaster.
		
		//if($jenis == "gabungan"){
			$this->data['standart'] 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
			//$this->data['diskontinyu'] 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//}else if($jenis == "Standart"){
		//	$this->data['standart']		= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//	$this->data['diskontinyu']	= "";
		//}else if($jenis == "Diskontinyu"){
		//	$this->data['standart']		= "";
		//	$this->data['diskontinyu']	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//}

		$this->load->view('manage/header');
		$this->load->view('manage/laporan/order/laporan_non_cetak', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Filter Laporan Order (non cetak) dari tanggal '.$tgl1.' - '.$tgl2.', dan  status order '.$status.''); // jenis artikel '.$jenis.'
		}
	}

	function filter_laporan_penjualan_pdf(){
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));
		//$divisi = $this->security->xss_clean($this->input->post('divisi'));
		//$jenis = $this->security->xss_clean($this->input->post('jenis_artikel'));
		$status = $this->security->xss_clean($this->input->post('status'));
		$bayar = $this->security->xss_clean($this->input->post('bayar'));

		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2;
		//$this->data['jenis'] = $jenis; 
		$this->data['status'] = $status;
		$this->data['bayar'] = $bayar;

		//if($jenis == "gabungan"){
			$this->data['standart'] 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//	$this->data['diskontinyu'] 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//}else if($jenis == "Standart"){
		//	$this->data['standart']		= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//	$this->data['diskontinyu']	= "";
		//}else if($jenis == "Diskontinyu"){
		//	$this->data['standart']		= "";
		//	$this->data['diskontinyu']	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//}

		//cetak laporan
		//$this->load->library('dompdf_gen');
        $this->load->view('laporan_pdf/laporan_pdf', $this->data);
        //$paper_size  = 'A4'; //paper size
        //$orientation = 'landscape'; //tipe format kertas
        //$html = $this->output->get_output();
 
        //$this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->load_html($html);
        //$this->dompdf->render();
        //$this->dompdf->stream("Laporan-penjualan.pdf", array('Attachment'=>0));
        //exit(0);
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Order (pdf) dari tanggal '.$tgl1.' - '.$tgl2.', dan  status order '.$status.''); // divisi '.$divisi.', jenis artikel '.$jenis.' 
	}

	function filter_laporan_penjualan_excel(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));
		//$jenis = $this->security->xss_clean($this->input->post('jenis_artikel'));
		//$jenisx = $this->security->xss_clean($this->input->post('jenis_artikel'));
		$status = $this->security->xss_clean($this->input->post('status'));
		$bayar = $this->security->xss_clean($this->input->post('bayar'));

		//if($jenis == "gabungan"){
			$standart 		= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//	$diskontinyu 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//}else if($jenis == "Standart"){
		//	$standart 		= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//	$diskontinyu 	= "";
		//}else if($jenis == "Diskontinyu"){
		//	$standart 		= "";
		//	$diskontinyu 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		//}

		if($status == "2hd8jPl613!2_^5"){
	     	$stat = "Menunggu Pembayaran";
	    }else if($status == "*^56t38H53gbb^%$0-_-"){
	        $stat = "Pembayaran Diterima";
	    }else if($status == "Uywy%u3bShi)payDhal"){
	        $stat = "Dalam Pengiriman";
	    }else if($status == "ScUuses8625(62427^#&9531(73"){
	        $stat = "Diterima";
	    }else if($status == "batal"){
	        $stat = "Dibatalkan";
	    }else{
	    	$stat = "Semua";
	    }

	    // ubah format tanggal
	    $originalDate1 = $tgl1;
		$tgl11 = date("d F Y", strtotime($originalDate1));
		$originalDate2 = $tgl2;
		$tgl22 = date("d F Y", strtotime($originalDate2));

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

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "RASIO PEROLEHAN PENJUALAN E-COMMERCE"); // Set kolom A1 dengan tulisan "DATA SISWA"
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('RASIO PEROLEHAN');

		    $objPHPExcel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		    // buat informasi apa yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('A3','Tanggal');
		    $objPHPExcel->getActiveSheet()->setCellValue('A4','Status Pesanan');
		    $objPHPExcel->getActiveSheet()->setCellValue('A5','Status Bayar');
		    // tampilkan hasil informasi yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('B3',"".$tgl11." - ".$tgl22."");
		    $objPHPExcel->getActiveSheet()->setCellValue('B4',"".$stat."");
		    $objPHPExcel->getActiveSheet()->setCellValue('B5',$bayar);
			//table header
			$heading = array("Gambar","Nama Project","Artikel","Retail","Sales Pairs","Retail + Sales Pairs");
	        //loop heading
	        $rowNumberH = 8;
		    $colH = 'A';
		    foreach($heading as $h){
		        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
		        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
		        $colH++;    
		    }
		    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
	       	$totalterjual = 0;           
          	$totalretail = 0;
          	$totalbisnis = 0;
          	$totaldivisi= 0; 
          	$bisnis = 0;
          	$divisi = 0;
	        // lopping
	        // mulai isi data pada baris ke 9
	        $baris = 9;
	        foreach($standart as $y){
            //$odvmaster    = $y->odvM;
            //$retailmaster = $y->retailM;

             // jika ada pengurangan dari biaya marketplace
            if($y->buy_in == "lazada"){
              $biaya_lazada = $y->harga_fix * 1.804 / 100;
              $vat_lazada   = $y->harga_fix * 0.164 / 100;
              //$vat_pencairan = ($biaya_lazada - $vat_lazada) * 10 / 100;
            }else{
              $biaya_lazada = 0;
              $vat_lazada = 0;
              $vat_pencairan = 0;
            }
            $harga_jual =($y->harga_fix - $biaya_lazada - $vat_lazada) * $y->total_terjual;// - $vat_pencairan;

            // mencari margin dari data diatas
            //$margin = round(($retailmaster - $odvmaster) / $retailmaster * 100);

            // memberi status barang berdasarkan hasil margin
            //if($margin >= 45){
              //mencari ODV bisnis barang standart
              //$jenis = "Standart";
              //$odv_bisnis = 55 * $retailmaster / 100;
              // hitung perolehan divisi dan bisnis
              //$bisnis   = $harga_jual * 45 / 100;
              //$divisi   = $harga_jual * 55 / 100;

              $totalterjual +=$y->total_terjual;
              $totalretail  +=$harga_jual;
              //$totalbisnis  +=($bisnis*$y->total_terjual);
              //$totaldivisi  +=($divisi*$y->total_terjual); 
            //}
            //if($margin >= 45){
	             
	            //pemanggilan sesuaikan dengan nama kolom tabel
	            $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $y->gambar); //GAMBAR
	            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $y->nama_produk); // Nama
	            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $y->artikel); // artikel
	            //$objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $jenis); // jenis
	            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, round($harga_jual)); // harga retail
	            $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $y->total_terjual); // total terjual per artikel
	            $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, round($harga_jual)); // retail * total terjual
	            //$objPHPExcel->getActiveSheet()->setCellValue("H".$baris, round($bisnis*$y->total_terjual)); // perolehan bisnis
	            //$objPHPExcel->getActiveSheet()->setCellValue("I".$baris, round($divisi*$y->total_terjual)); // perolehan divisi

	            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		      	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
		      	//$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
		      	//$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
		      	//$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
	            $baris++;
	        //}}
	        }
		    $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, "Total");
		    $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, round($totalterjual)); 
		    $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, round($totalretail)); 
		    //$objPHPExcel->getActiveSheet()->setCellValue("H".$baris, round($totalbisnis)); 
		    //$objPHPExcel->getActiveSheet()->setCellValue("I".$baris, round($totaldivisi)); 
		    // apply style
		    $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
		    $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
	      	//$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
	      	//$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
	        // end lopping

	         // Set width kolom
		   	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30); 
		    //$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 
		    //$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20); 
		    
		    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		// Redirect output to a client’s web browser (Excel5)
		$filename = urlencode("Laporan Penjualan_".$tgl11."-".$tgl22."_status_".$stat.".xls");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Order (Excel) dari tanggal '.$tgl1.' - '.$tgl2.' dan  status order '.$status.'');
	}

	function download_form(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$tanggal_sekarang = date('Y-m-d H:i:s');
	    $list = $this->report_order_adm->list_aplication();

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

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "PENDAFTARAN ADMIN SUBPAGE FACEBOOK OFFICIAL STARS"); // Set kolom A1 dengan tulisan "DATA SISWA"
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Standart');

	    $objPHPExcel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
	    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
	    // buat informasi apa yang ditarik
	    $objPHPExcel->getActiveSheet()->setCellValue('A3','Update Data');
	    $objPHPExcel->getActiveSheet()->setCellValue('B3',''.date('d F Y', strtotime($tanggal_sekarang)).'');
		//table header
		$heading = array("Nama SPV / Pramuniaga Toko","Nama Facebook SPV / Pramuniaga","Kode EDP Toko","Alamat Toko","Nomor HP Toko","Instagram Toko");
        //loop heading
        $rowNumberH = 4;
	    $colH = 'A';
	    foreach($heading as $h){
	        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
	        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
	        $colH++;    
	    }
	    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        // lopping
        // mulai isi data pada baris ke 9
        $baris = 5;
        foreach($list as $y){	             
        //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $y->nama_spv); //Nama SPV / pramuniaga
        $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $y->nama_fb); // Nama FB
        $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $y->code_edp); // kode edp
        $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $y->alamat); // Alamat
        $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $y->hp); // HP toko
        $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $y->ig); // IG toko

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
      	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
        $baris++;
        }
        // end lopping

         // Set width kolom
	   	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
	    
	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

	    // Redirect output to a client’s web browser (Excel5)
	    $date = date('d F Y', strtotime($tanggal_sekarang));
		$filename = urlencode("Pendaftaran admin subpage facebook official stars ".$date.".xls");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Pendaftaran admin subpage facebook official stars (Excel) tanggal '.$date.'');
	}
}