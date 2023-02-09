<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_order extends CI_Controller { 

	function __construct(){ 
		parent:: __construct();
		$this->load->model('sec47logaccess/report_order_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){ 
			redirect(base_url());
		}
	}
  
	function index(){

		$this->data['jenisoption'] = $this->report_order_adm->get_jenis();
		//$this->data['divisioption'] = $this->report_order_adm->get_divisi();
		$this->data['data'] = $this->report_order_adm->get_order_all();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/order/index', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Laporan Penjualan');
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
		$jenis = $this->security->xss_clean($this->input->post('jenis_artikel'));
		$status = $this->security->xss_clean($this->input->post('status'));
		$bayar = $this->security->xss_clean($this->input->post('bayar'));

		// global information
		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2;
		$this->data['jenis'] = $jenis;
		$this->data['status'] = $status;

		//foreach($get_artikel as $h){
		//	$odvmaster		= $h->odvM;
		//	$retailmaster	= $h->retailM;
		//}
		//echo $odvmaster.
		
		if($jenis == "gabungan"){
			$this->data['standart'] 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
			$this->data['diskontinyu'] 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		}else if($jenis == "Standart"){
			$this->data['standart']		= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
			$this->data['diskontinyu']	= "";
		}else if($jenis == "Diskontinyu"){
			$this->data['standart']		= "";
			$this->data['diskontinyu']	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		}

		$this->load->view('manage/header');
		$this->load->view('manage/laporan/order/laporan_non_cetak', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Filter Laporan Order (non cetak) dari tanggal '.$tgl1.' - '.$tgl2.', jenis artikel '.$jenis.' dan  status order '.$status.'');
		}
	}

	function filter_detail(){
		
	}

	function filter_laporan_penjualan_pdf(){
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));
		$divisi = $this->security->xss_clean($this->input->post('divisi'));
		$jenis = $this->security->xss_clean($this->input->post('jenis_artikel'));
		$status = $this->security->xss_clean($this->input->post('status'));
		$bayar = $this->security->xss_clean($this->input->post('bayar'));

		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2;
		$this->data['jenis'] = $jenis;
		$this->data['status'] = $status;

		if($jenis == "gabungan"){
			$this->data['standart'] 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
			$this->data['diskontinyu'] 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		}else if($jenis == "Standart"){
			$this->data['standart']		= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
			$this->data['diskontinyu']	= "";
		}else if($jenis == "Diskontinyu"){
			$this->data['standart']		= "";
			$this->data['diskontinyu']	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		}

		//cetak laporan
		$this->load->library('dompdf_gen');
		//send data[''] to view
        $this->load->view('laporan_pdf/laporan_pdf', $this->data);
        $paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->set_base_path('qusour894/css');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        //$this->dompdf->set_base_path($css);
        $this->dompdf->stream("Laporan-penjualan.pdf", array('Attachment'=>0));
        exit(0);
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Order (pdf) dari tanggal '.$tgl1.' - '.$tgl2.', divisi '.$divisi.', jenis artikel '.$jenis.' dan  status order '.$status.'');
	}

	function filter_laporan_penjualan_excel(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));
		$jenis = $this->security->xss_clean($this->input->post('jenis_artikel'));
		$jenisx = $this->security->xss_clean($this->input->post('jenis_artikel'));
		$status = $this->security->xss_clean($this->input->post('status'));
		$bayar = $this->security->xss_clean($this->input->post('bayar'));

		if($jenis == "gabungan"){
			$standart 		= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
			$diskontinyu 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		}else if($jenis == "Standart"){
			$standart 		= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
			$diskontinyu 	= "";
		}else if($jenis == "Diskontinyu"){
			$standart 		= "";
			$diskontinyu 	= $this->report_order_adm->filter_laporan($tgl1, $tgl2, $status, $bayar);
		}

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
		if(empty($standart)){

		}else{
			// Create a first sheet, representing sales data
			$objPHPExcel->setActiveSheetIndex(0);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PENJUALAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('Standart');

		    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai E1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		    // buat informasi apa yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('A3','Tanggal');
		    $objPHPExcel->getActiveSheet()->setCellValue('A4','Jenis Artikel');
		    $objPHPExcel->getActiveSheet()->setCellValue('A5','Status');
		    // tampilkan hasil informasi yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('B3',"".$tgl11."-".$tgl22."");
		    $objPHPExcel->getActiveSheet()->setCellValue('B4',"".$jenisx."");
		    $objPHPExcel->getActiveSheet()->setCellValue('B5',$stat);
			//table header
			$heading = array("Gambar","Nama Project","Artikel","Status Barang","Retail","Sales Pairs","Retail + Sales Pairs","Bisnis","Divisi");
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
            $odvmaster    = $y->odvM;
            $retailmaster = $y->retailM;

            // mencari margin dari data diatas
            $margin = round(($retailmaster - $odvmaster) / $retailmaster * 100);

            // memberi status barang berdasarkan hasil margin
            if($margin >= 45){
              //mencari ODV bisnis barang standart
              $jenis = "Standart";
              $odv_bisnis = 55 * $retailmaster / 100;
              // hitung perolehan divisi dan bisnis
              $bisnis   = $y->harga_fix * 45 / 100;
              $divisi   = $y->harga_fix * 55 / 100;

              $totalterjual +=$y->total_terjual;
              $totalretail  +=($y->harga_fix*$y->total_terjual);
              $totalbisnis  +=($bisnis*$y->total_terjual);
              $totaldivisi  +=($divisi*$y->total_terjual); 
            }
            if($margin >= 45){
	             
	            //pemanggilan sesuaikan dengan nama kolom tabel
	            $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $y->gambar); //GAMBAR
	            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $y->nama_produk); // Nama
	            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $y->artikel); // artikel
	            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $jenis); // jenis
	            $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, round($y->harga_fix)); // harga retail
	            $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $y->total_terjual); // total terjual per artikel
	            $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, round($y->total_terjual*$y->harga_fix)); // retail * total terjual
	            $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, round($bisnis*$y->total_terjual)); // perolehan bisnis
	            $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, round($divisi*$y->total_terjual)); // perolehan divisi

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
	        }}
		    $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, "Total");
		    $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, round($totalterjual)); 
		    $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, round($totalretail)); 
		    $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, round($totalbisnis)); 
		    $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, round($totaldivisi)); 
		    // apply style
		    $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		    $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
	        // end lopping

	         // Set width kolom
		   	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20); 
		    
		    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		}

		if(empty($diskontinyu)){

		}else{
			// BUAT SHEET BARU
			$objPHPExcel->createSheet();
			// Create a second sheet, representing sales data
			if($standart == "" || $diskontinyu == ""){
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PENJUALAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
			}else{
				$objPHPExcel->setActiveSheetIndex(1);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', "LAPORAN PENJUALAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
			}
			// namai sheet 
			$objPHPExcel->getActiveSheet()->setTitle('Diskontinyu');

		    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai E1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		    // buat informasi apa yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('A3','Tanggal');
		    $objPHPExcel->getActiveSheet()->setCellValue('A4','Jenis Artikel');
		    $objPHPExcel->getActiveSheet()->setCellValue('A5','Status');
		    // tampilkan hasil informasi yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('B3',"".$tgl11."-".$tgl22."");
		    $objPHPExcel->getActiveSheet()->setCellValue('B4',"".$jenisx."");
		    $objPHPExcel->getActiveSheet()->setCellValue('B5',$stat);
			//table header
			$heading = array("Gambar","Nama Project","Artikel","Status Barang","Retail","Sales Pairs","Retail + Sales Pairs","Bisnis","Divisi");
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
            $odvmaster    = $y->odvM;
            $retailmaster = $y->retailM;

            // mencari margin dari data diatas
            $margin = round(($retailmaster - $odvmaster) / $retailmaster * 100);

            // memberi status barang berdasarkan hasil margin
            if($margin >= 0 && $margin < 45){
              //mencari ODV bisnis barang standart
              $jenis = "Diskontinyu";
              $odv_bisnis = ($retailmaster - $odvmaster) * 30 / 100 + $odvmaster;
              // hitung perolehan divisi dan bisnis
              $bisnis   = ($y->harga_fix - $odvmaster) * 70 / 100;
              $divisi   = ($y->harga_fix - $odvmaster) * 30 / 100 + $odvmaster;

              $totalterjual +=$y->total_terjual;
              $totalretail  +=($y->harga_fix*$y->total_terjual);
              $totalbisnis  +=($bisnis*$y->total_terjual);
              $totaldivisi  +=($divisi*$y->total_terjual); 
            }
            if($margin >= 0 && $margin < 45){
	             
	            //pemanggilan sesuaikan dengan nama kolom tabel
	            $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $y->gambar); //GAMBAR
	            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $y->nama_produk); // Nama
	            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $y->artikel); // artikel
	            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $jenis); // jenis
	            $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, round($y->harga_fix)); // harga retail
	            $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $y->total_terjual); // total terjual per artikel
	            $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, round($y->total_terjual*$y->harga_fix)); // retail * total terjual
	            $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, round($bisnis*$y->total_terjual)); // perolehan bisnis
	            $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, round($divisi*$y->total_terjual)); // perolehan divisi

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
	        }}
		    $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, "Total");
		    $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, round($totalterjual)); 
		    $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, round($totalretail)); 
		    $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, round($totalbisnis)); 
		    $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, round($totaldivisi)); 
		    // apply style
		    $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		    $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
	      	$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
	        // end lopping

	         // Set width kolom
		   	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20); 
		    
		    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		}

		// Redirect output to a client’s web browser (Excel5)
		$filename = urlencode("Laporan Penjualan_".$tgl11."-".$tgl22."_jenis_barang_".$jenis."_status_".$stat.".xls");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Order (Excel) dari tanggal '.$tgl1.' - '.$tgl2.' jenis artikel '.$jenis.' dan  status order '.$status.'');
	}
}