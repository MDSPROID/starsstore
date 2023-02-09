<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_voucher extends CI_Controller { 

	function __construct(){
		parent:: __construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/laporan_voucher_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	} 	
 
	function index(){
		$this->data['get_list'] = $this->laporan_voucher_adm->get_voucher();
		$this->load->view('manage/header');
		$this->load->view('manage/laporan/voucher/index', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Laporan Voucher');
	} 

	function cetak_laporan_voucher($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$this->data['detail'] = $this->laporan_voucher_adm->get_data_retur($b);
		$this->data['produk'] = $this->laporan_voucher_adm->get_data_produk_retur($b);
		//cetak laporan
		$this->load->library('dompdf_gen');
		//send data[''] to view
        $this->load->view('laporan_pdf/laporan_retur', $this->data);
        $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->set_base_path('qusour894/css');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        //$this->dompdf->set_base_path($css);
        $this->dompdf->stream("Laporan_voucher.pdf", array('Attachment'=>0));
        exit(0);
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Retur, ID Retur '.$b.'');
	}

	function voucher_report_group(){
		// if button action
		if($this->input->post('laporan') == "excel"){
			$this->filter_laporan_retur_excel();
		}else if($this->input->post('laporan') == "cetak"){
			$this->filter_laporan_retur_pdf();
		}else if($this->input->post('laporan') == "filter"){

		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));

		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2;
		
		$this->data['get_list'] = $this->laporan_voucher_adm->filter_laporan($tgl1, $tgl2);

		$this->load->view('manage/header');
		$this->load->view('manage/laporan/voucher/laporan_non_cetak', $this->data);	
		$this->load->view('manage/footer');
		log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Filter Laporan voucher (non cetak) dari tanggal '.$tgl1.' - '.$tgl2.'');
		}
	}

	function filter_laporan_retur_pdf(){
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));

		$this->data['tgl1'] = $tgl1;
		$this->data['tgl2'] = $tgl2;
		// if divisi gabungan
		
		$this->data['get_list'] = $this->laporan_voucher_adm->filter_laporan($tgl1, $tgl2);

		//cetak laporan
		$this->load->library('dompdf_gen');
		//send data[''] to view
        $this->load->view('laporan_pdf/laporan_voucher_filter', $this->data);
        $paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->set_base_path('qusour894/css');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        //$this->dompdf->set_base_path($css);
        $this->dompdf->stream("Laporan_voucher_pdf.pdf", array('Attachment'=>0));
        exit(0);
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan Voucher (pdf) dari tanggal '.$tgl1.' - '.$tgl2.'');
	}

	function filter_laporan_retur_excel(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));

		$laporan = $this->laporan_voucher_adm->laporan_voucher_adm->filter_laporan($tgl1, $tgl2);

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
		if(empty($laporan)){

		}else{
			// Create a first sheet, representing sales data
			$objPHPExcel->setActiveSheetIndex(0);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PENGGUNAAN VOUCHER"); // Set kolom A1 dengan tulisan "DATA SISWA"
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('Laporan Penggunaan Voucher');

		    $objPHPExcel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
		    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		    // buat informasi apa yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('A3','Tanggal');
		    // tampilkan hasil informasi yang ditarik
		    $objPHPExcel->getActiveSheet()->setCellValue('B3',"".$tgl11." - ".$tgl22."");
			//table header
			$heading = array("Tanggal Digunakan","Voucher / Kupon","Invoice","Email Customer","Customer","Status");
	        //loop heading
	        $rowNumberH = 5;
		    $colH = 'A';
		    foreach($heading as $h){
		        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
		        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
		        $colH++;    
		    }
		    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
	        
	        // lopping
	        // mulai isi data pada baris ke 9
	        $baris = 6;
	        foreach ($laporan as $frow){

	        if($frow->date_use_voucher == "0000-00-00 00:00:00"){ 
	        }else{ 
	        	$t = date('d F Y H:i:s', strtotime($frow->date_use_voucher));
	        }

	        if($frow->status == "2hd8jPl613!2_^5"){
	           $st = "Menunggu Pembayaran";
	         }else if($frow->status == "*^56t38H53gbb^%$0-_-"){
	           $st = "Pembayaran Diterima";
	        }else if($frow->status == "Uywy%u3bShi)payDhal"){
	           $st = "Dalam Pengiriman";
	        }else if($frow->status == "ScUuses8625(62427^#&9531(73"){
	           $st = "Diterima";
	        }else if($frow->status == "batal"){
	           $st = "Dibatalkan";
	        }
	             
	            //pemanggilan sesuaikan dengan nama kolom tabel
	            $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $t); //TANGGAL DIGUNAKAN
	            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, strtoupper($frow->vou)); //NO. RETUR
	            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $frow->invoice); //INVOICE
	            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $frow->email); // EMAIL
	            $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $frow->nama_lengkap); // NAMA CUSTOMER
	            $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $st); // STATUS

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
		    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30); 
		    
		    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		}

		// Redirect output to a client’s web browser (Excel5)
		$filename = urlencode("Laporan Voucher ".$tgl11."-".$tgl22.".xls");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Laporan voucher (Excel) dari tanggal '.$tgl1.' - '.$tgl2.'');
	}
}