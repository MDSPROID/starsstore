<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller { 
  
	function __construct(){ 
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/email_adm'); 
		$this->load->library('email');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		} 
	} 

	function index(){ // get data email in list data
		$list_data['get_list'] = $this->email_adm->get_list_mail();
		$data = array_merge($list_data);
		log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Email');
		$this->load->view('manage/header');
		$this->load->view('manage/email/index', $data);
		$this->load->view('manage/footer');
	}

	function load_data_kontak(){
		$list_data = $this->email_adm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach($list_data as $x){
			$no++;
			$row = array();

        	if($x->C == "0"){
	            $status = "<label class='label label-primary'>Semua</label>";
	        }else if($x->C == "1"){
	            $status = "<label class='label label-default'>Generate WA Blaz</label>";
	       	}else if($x->C == "2"){
	            $status = "<label class='label label-warning'>Toko</label>";
	        }else if($x->C == "3"){
	            $status = "<label class='label label-success'>Kantor</label>";
	        }else if($x->C == "4"){
	        	$status = "<label class='label label-danger'>Direktur</label>";
	        }else if($x->C == "5"){
	        	$status = "<label class='label label-danger' style='background-color:purple;'>Div. Promosi</label>";
	        }else if($x->C == ""){
	        	$status = "";
	        }

	        $opsi = "
		        <ul class='list-inline opsi' style='margin-bottom: 0;'>
		            <li>
		              <a title='kategori generate WA blaz' data-id='".$x->id."' data-kategori='1' class='btn btn-default' href='javascript:void(0);' onclick='ubahkategori(this);' class='edit'><i class='glyphicon glyphicon-edit'></i> WA Blaz</a>
		            </li>
		            <li>
		              <a title='kategori Toko' data-id='".$x->id."' data-kategori='2' class='btn btn-default' href='javascript:void(0);' onclick='ubahkategori(this);'><i class='glyphicon glyphicon-edit'></i> Toko</a> 
		            </li>
		            <li>
		              <a title='kategori kantor' data-id='".$x->id."' data-kategori='3' class='btn btn-default' href='javascript:void(0);' onclick='ubahkategori(this);'><i class='glyphicon glyphicon-edit'></i> Kantor</a> 
		            </li>
		            <li>
		              <a title='kategori div. promosi' data-id='".$x->id."' data-kategori='4' class='btn btn-default' href='javascript:void(0);' onclick='ubahkategori(this);'><i class='glyphicon glyphicon-edit'></i> Direktur</a> 
		            </li>
		            <li>
		              <a title='kategori div. promosi' data-id='".$x->id."' data-kategori='5' class='btn btn-default' href='javascript:void(0);' onclick='ubahkategori(this);'><i class='glyphicon glyphicon-edit'></i> Div. Promosi</a> 
		            </li>
		            <li>
		              <a title='Edit' href='javascript:void(0)' class='btn btn-warning dit' onclick='edit_kontak(".$x->id.")'><i class='glyphicon glyphicon-pencil'></i></a> 
		            </li>
		            <li>
		              <a title='Hapus' href='javascript:void(0)' class='btn btn-danger hapus' data-id='".$x->id."' data-name='".$x->A."' onclick='hapus_kontak(this)'><i class='glyphicon glyphicon-trash'></i></a> 
		            </li>
		        </ul>
	        ";

          	// ROW START
          	$row[] = "<input type='checkbox' class='form-control' name='checklist[]' value='".$x->id."'/>";
          	$row[] = $x->A;
          	$row[] = $x->B;
          	$row[] = $status;
          	$row[] = $opsi;

          	// ROW end(array)
        $data[] = $row;
    	}

    	$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->email_adm->count_all(),
            "recordsFiltered" => $this->email_adm->count_filtered(),
            "data" => $data,
        );
		echo json_encode($output);
	}

	function ambil_data_kontak($id){
		$get = $this->email_adm->get_data_kontak($id);
		echo json_encode($get);
	}

	function fixed_number(){
		// hapus duplikat, fungsi sudah ada di aplikasi dekstop WABLAZ
		//$this->email_adm->hapus_duplikat();
		// get data all kontak 
		$data = $this->email_adm->ambil_kontak();

		//$data = array('711411316','60126244407','6282146394114','0761-855703 (hunting','6285731509595 ext.');//array('+6285767678647','(0852) 7327336','0218563051104 (hunting','danny','+62 274 563754 ext. 21','1800-22-5587');
		foreach($data as $t){

			// identifikasi semua data dengan menghilangkan semua karakter huruf dan simbol menjadi angka semua
			$nm_identify = preg_replace('/[^0-9]/','',$t->B);
		    if(ctype_digit($nm_identify)){ // jika angka maka proses
		        
		        //hilangkan karakter lain yang gabung dengan angka ex: 08978342 ext.21
		    	$c_karakter = Strlen($nm_identify);
				if($c_karakter <= 5){ // jika ada nomor hanya 5 angka atau kurang dari 5 angka maka hapus
					// hapus data
					$this->db->delete('master_telp_blaz',array('id'=>$t->id));
				}else if($nm_identify == ""){ // jika kolom nomor kosong maka hapus
					// hapus data
					$this->db->delete('master_telp_blaz',array('id'=>$t->id));
				}else{ // rapikan format telpon menjad +62
					// rapikan spasi number
					$r1 = str_replace(' ', '', $t->B); //$t->B;
					// hilangkan tanda -
					$r2 = str_replace('-','',$r1);
					//replace 0 angka awal jadi +62
					$r3 = substr($r2,0,1);
					$r3x = substr($r2,0,2);
					// jika angka depan == 0 || 62 || lainnya
					if($r3 == "("){
						$r4 = str_replace("(", "",$r2);
						$r4x = str_replace(")", "",$r4);
						$r5 = "+62";
						$r5x = preg_replace('/[^0-9]/','',substr($r4x, 1));
						$r6 = $r5.$r5x;
						//if($r5x == 0){
						//	$r6 = $r5x;
						//}else{
						//	$r6 = $r5x;
						//}			
					}else if($r3 == 0){
						$r4 = str_replace("0", "+62",$r3);
						$r5 = preg_replace('/[^0-9]/','',substr($r2, 1));
						$r6 = $r4.$r5; 
					}else if($r3 == 6){

						if($r3x == "62"){
							$r4 = str_replace("62", "+62",$r3x);
							$r5 = preg_replace('/[^0-9]/','',substr($r2, 2));
							$r6 = $r4.$r5; 
						}else{
							$r4 = str_replace("6", "+62",$r3x);
							$r5 = preg_replace('/[^0-9]/','',substr($r2, 2));
							$r6 = $r4.$r5; 
						}
					}else{
						$r4 = "+62";
						$r5 = preg_replace('/[^0-9]/','',$t->B); //$t->B;
						$r6 = $r4.$r5; 
					}

					//echo $r6." ";
					//echo "asli : ".$t." sesudah : ".$r5.", modif : ".$r6."<br>";

					$r4x = substr($r6,0,4);
					//$nm = $t->B;
					//$cek = $this->email_adm->duplikate_checker($nm); // sudah ada di program wa blaz

					if($r4x == "+620" || $r4x == "+621" || $r4x == "+622" || $r4x == "+623" || $r4x == "+624" || $r4x == "+625" || $r4x == "+626" || $r4x == "+627" || $r4x == "+629"){
						// hapus nomor telpon kantor
						$this->db->delete('master_telp_blaz',array('id'=>$t->id));
					}else{
						//fixed it
						$data_update = array(
							'B' => $r6
						);
						$this->db->where('id',$t->id);
						$this->db->update('master_telp_blaz', $data_update);
					}
				}
		    	

		    }else{ // jika bukan angka / kosong {dihapus}
		        $this->db->delete('master_telp_blaz',array('id'=>$t->id));
		    }			

		}
		log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Fixed Nomor Blaz');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Nomor Berhasil di perbaiki dan nomor duplikat telah dihapus.');
		redirect('trueaccon2194/email');
	}

	function kontak_dihapuskan(){ // hapus kategori yang dipilih
		$name = $this->input->get('name');
		$id = $this->input->get('id');
		$this->email_adm->kontak_telah_dihapus($id);
		log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus kontak '.$name.'');
	}

	function proses_update_kontak(){
		
		$id_filtering 	= $this->security->xss_clean($this->input->post('id_kontak'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);

        $data1_filtering 	= $this->security->xss_clean($this->input->post('get_nama'));
        $nama = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data1_filtering);

        $data2_filtering 	= $this->security->xss_clean($this->input->post('get_kontak'));
        $nomor = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data2_filtering);

		$datax = array(
				'A'    => $nama,
				'B'	   => $nomor,
			);

		//$this->email_adm->update_kontak(array('id' => $id), $data);
		$this->db->where('id', $id);
		$this->db->update('master_telp_blaz', $datax);
		log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Update kontak '.$nama.' '.$nomor.'');
	}

	function proses_tambah_kontak(){

        $data1_filtering 	= $this->security->xss_clean($this->input->post('get_nama'));
        $nama = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data1_filtering);

        $kontak_filtering 	= $this->security->xss_clean($this->input->post('get_kontak'));
        $kontak = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$kontak_filtering);

        $data2_filtering 	= $this->security->xss_clean($this->input->post('kategori'));
        $kategori = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data2_filtering);

		$datax = array(
				'A'    => $nama,
				'B'	   => $kontak,
				'C'	   => $kategori,
			);

		$this->db->insert('master_telp_blaz', $datax);
		log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Tambah kontak '.$nama.' '.$kontak.'');
	}

	function export_kontak_excel(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$kat = $this->security->xss_clean($this->input->post('kategori1'));
		$laporan = $this->email_adm->ambil_kontak1($kat);

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

			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA KONTAK"); // Set kolom A1 dengan tulisan "DATA SISWA"
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('master_telp_blaz');

		    //$objPHPExcel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
		    //$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		    //$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
		    //$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		    // buat informasi apa yang ditarik
		    //$objPHPExcel->getActiveSheet()->setCellValue('A3','Tanggal');
		    // tampilkan hasil informasi yang ditarik
		    //$objPHPExcel->getActiveSheet()->setCellValue('B3',"".$tgl11." - ".$tgl22."");
			//table header
			//$heading = array("Tanggal Digunakan","Voucher / Kupon","Invoice","Email Customer","Customer","Status");
	        //loop heading
	        //$rowNumberH = 5;
		    //$colH = 'A';
		    //foreach($heading as $h){
		    //    $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
		    //    $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
		    //    $colH++;    
		    //}
		    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
	        
	        // lopping
	        // mulai isi data pada baris ke 9
	        $baris = 1;
	        foreach ($laporan as $t){

	        if($t->C == "0"){
	            $status = "Semua";
	        }else if($t->C == "1"){
	            $status = "Generate WA Blaz";
	       	}else if($t->C == "2"){
	            $status = "Toko";
	        }else if($t->C == "3"){
	            $status = "Kantor";
	        }else if($t->C == "4"){
	        	$status = "Direktur";
	        }else if($t->C == "5"){
	        	$status = "Div. Promosi";
	        }else if($t->C == ""){
	        	$status = "";
	        }
	             
	            //pemanggilan sesuaikan dengan nama kolom tabel
	            $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $t->A); //Nama
	            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $t->B); //Nomor
	            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $status); //status
	            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $t->C); //status

	            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		      	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
		      	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
	            $baris++;
	        }
	        // end lopping

	         // Set width kolom
		   	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);  
		    
		    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		// Redirect output to a client’s web browser (Excel5)
		$filename = urlencode("master_telp_blaz.xls");
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
        log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Data Kontak (Excel) Kategori '.$status.'');
	}

	function ubah_kategori(){
		$id = $this->input->get('id');
		$kat = $this->input->get('kat');
		$data_kat = array(
			'C' => $kat,
		);
		$this->db->where('id', $id);
		$this->db->update('master_telp_blaz', $data_kat);
		echo json_encode(array("status" => TRUE));
		log_helper('kategori', ''.$this->data['username'].' ('.$this->data['id'].') menghapus kategori '.$target.'');
	}

	function broadcast(){ // get data email in list data
		//$list_data['get_list'] = $this->email_adm->get_list_mail();
		log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Email broadcast');
		$this->load->view('manage/header');
		$this->load->view('manage/email/broadcast');
		$this->load->view('manage/footer');
	}

	function send_broadcast(){
		$from_filtering = $this->security->xss_clean($this->input->post('from'));
        $fromx = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$from_filtering);

        $csfrom_filtering = $this->security->xss_clean($this->input->post('fromcustom'));
        $csfrom = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$csfrom_filtering);

		$katmail_filtering = $this->security->xss_clean($this->input->post('kategori_email'));
        $katmail = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$katmail_filtering);

        $cskatmail_filtering = $this->security->xss_clean($this->input->post('katmailcustom'));
        $cskatmail = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$cskatmail_filtering);

        $judul_filtering = $this->security->xss_clean($this->input->post('judul'));
        $judul = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$judul_filtering);

		$pesan_filtering = $this->security->xss_clean($this->input->post('message'));
        $pesan = str_replace("<script></script><?php?>", "",$pesan_filtering);

        // BARU FROM BISA KUSTOM
        if($fromx == "custom"){
        	$from = $csfrom;
        }else{
        	$from = $fromx;
        }

        // ambil data email menurut yang dipilih
        if($katmail == "customer"){
        	// email customer (beda dengan newsletter)
        	$data2 = $this->email_adm->data_customer();
        	$data_email2 = array();
        	foreach($data2 as $h){
        		$data_email2[] = $h->email;
        	}
        	$data_customer = implode(',', $data_email2);
        	$data_email = $data_customer;
        }else if($katmail == "newsletter"){
        	// newsletter
        	$data1 = $this->email_adm->data_newsletter();
        	$data_email1 = array();
        	foreach($data1 as $h){
        		$data_email1[] = $h->email;
        	}
        	$data_newsletter = implode(',', $data_email1);
        	$data_email = $data_newsletter;

        }else if($katmail == "admin"){
        	// newsletter
        	$data = $this->email_adm->data_admin();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else if($katmail == "finance"){
        	// newsletter
        	$data = $this->email_adm->data_finance();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else if($katmail == "cc"){
        	// newsletter
        	$data = $this->email_adm->data_cc();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else if($katmail == "support"){
        	// newsletter
        	$data = $this->email_adm->data_support();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else if($katmail == "sales"){
        	// newsletter
        	$data = $this->email_adm->data_sales();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else if($katmail == "bcc"){
        	// newsletter
        	$data = $this->email_adm->data_bcc();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else{ // BARU, BISA KUSTOM
        	$data_email = $cskatmail;
        }

        // eksekusi by tombol
        if($this->input->post('mailto') == "simpan"){
        	$data_mail = array(
        		'judul'		=> $judul,
        		'to_type'	=> $katmail,
        		'from'		=> $from,
        		'to' 		=> $data_email,
        		'message'	=> $pesan,
        		'status'	=> 'konsep',
        		'date_created' => date('Y-m-d H:i:s'),
        		'user_add'	=> $this->data['id'],
        	);
			$this->email_adm->simpan_email_konsep($data_mail);
			log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Menyimpan Email '.$judul.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Email '.$judul.' Berhasil disimpan!');
			redirect('trueaccon2194/email');
		}else if($this->input->post('mailto') == "kirim"){
			// isi email
			$data_email_rev = array(
				'judul'	=> $judul,
				'isi' 	=> $pesan,
			);

			//ambil data email admun buat perwakilan / track record
			$get_adm = $this->email_adm->data_admin();
			foreach($get_adm->result() as $adm){
				$admin_email = $adm->em_acc;
			}

			$config = Array(
				'mailtype'  => 'html', 
			);

			if($katmail == "newsletter"){
				$this->email->initialize($config);
				$this->email->from($from); // change it to yours
		      	$this->email->to($admin_email);// change it to yours
		      	$this->email->bcc($data_email);
		      	$this->email->subject($judul);
		      	$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
		      	$this->email->message($body);
		      	$this->email->send();
		     }else if($katmail == "cc"){
				$this->email->initialize($config);
				$this->email->from($from); // change it to yours
		      	$this->email->to($admin_email);// change it to yours
		      	$this->email->cc($data_email);
		      	$this->email->subject($judul);
		      	$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
		      	$this->email->message($body);
		      	$this->email->send();
		     }else if($katmail == "bcc"){
		     	$this->email->initialize($config);
				$this->email->from($from); // change it to yours
		      	$this->email->to($admin_email);// change it to yours
		      	$this->email->bcc($data_email);
		      	$this->email->subject($judul);
		      	$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
		      	$this->email->message($body);
		      	$this->email->send();
		     }else{
		     	$this->email->initialize($config);
				$this->email->from($from); // change it to yours
		      	$this->email->to($data_email);// change it to yours
		      	$this->email->subject($judul);
		      	$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
		      	$this->email->message($body);
		      	$this->email->send();
		     }
		     // simpan data email
		     $data_mail = array(
		     	'judul'		=> $judul,
        		'to_type'	=> $katmail,
        		'from'		=> $from,
        		'to' 		=> $data_email,
        		'message'	=> $pesan,
        		'status'	=> 'terkirim',
        		'date_created' => date('Y-m-d H:i:s'),
        		'user_add'	=> $this->data['id'],
        	);
			$this->email_adm->simpan_email_konsep($data_mail);
			log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Mengirim Email '.$judul.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Email '.$judul.' Berhasil dikirim!');
			redirect('trueaccon2194/email');
		}
        
	}

	function edit_data($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		$this->data['g'] = $this->email_adm->get_data_email($idx);
		$this->load->view('manage/header');
		$this->load->view('manage/email/edit', $this->data);
		$this->load->view('manage/footer');
	}

	function update_email(){ // proses tambah data produk
		$id = $this->input->post('mail');
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);

        $cskatmail_filtering = $this->security->xss_clean($this->input->post('katmailcustom'));
        $cskatmail = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$cskatmail_filtering);

		$katmail_filtering = $this->security->xss_clean($this->input->post('kategori_email'));
        $katmail = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$katmail_filtering);

         // ambil data email menurut yang dipilih
        if($katmail == "customer"){
        	// email customer (beda dengan newsletter)
        	$data2 = $this->email_adm->data_customer();
        	$data_email2 = array();
        	foreach($data2 as $h){
        		$data_email2[] = $h->email;
        	}
        	$data_customer = implode(',', $data_email2);
        	$data_email = $data_customer;

        }else if($katmail == "newsletter"){
        	// newsletter
        	$data1 = $this->email_adm->data_newsletter();
        	$data_email1 = array();
        	foreach($data1 as $h){
        		$data_email1[] = $h->email;
        	}
        	$data_newsletter = implode(',', $data_email1);
        	$data_email = $data_newsletter;

        }else if($katmail == "admin"){
        	// newsletter
        	$data = $this->email_adm->data_admin();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else if($katmail == "finance"){
        	// newsletter
        	$data = $this->email_adm->data_finance();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else if($katmail == "cc"){
        	// newsletter
        	$data = $this->email_adm->data_cc();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else if($katmail == "support"){
        	// newsletter
        	$data = $this->email_adm->data_support();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else if($katmail == "sales"){
        	// newsletter
        	$data = $this->email_adm->data_sales();
        	foreach($data->result() as $h){
        		$data_email = $h->em_acc;
        	}
        }else if($katmail == "bcc"){
        	// newsletter
        	$data = $this->email_adm->data_bcc();
        	foreach($data->result() as $h){ 
        		$data_email = $h->em_acc;
        	}
        }else{
        	$data_email = $cskatmail;
        }

        if($this->input->post()){
			$data_filtering = $this->security->xss_clean($this->input->post());
    		$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

			$this->email_adm->update_email($idx,$data, $data_email); 
			log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit email');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Email telah diupdate.');
			redirect('trueaccon2194/email');
		}else{
			log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Gagal mengupdate email');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi internet anda');
			redirect('trueaccon2194/email');
		}
	}

	function send_again($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		// ubah status email menjadi terkirim
		$this->email_adm->ubah_status($idx);
		// ambil data email
		$get = $this->email_adm->get_data_email_for_send($idx);
		foreach($get as $g){
			$to 		= $g->to_type;
			$from 		= $g->from;
			$data_email = $g->to;
			$judul 		= $g->judul;
			$pesan 		= $g->message;
		}
		// isi email
		$data_email_rev = array(
			'nakap'	=> $judul,
			'isi' 	=> $pesan,
		);

		//ambil data email admun buat perwakilan / track record
		$get_adm = $this->email_adm->data_admin();
		foreach($get_adm->result() as $adm){
			$admin_email = $adm->em_acc;
		}

		$config = Array(
			'mailtype'  => 'html', 
		);

		if($to == "newsletter"){
			$this->email->initialize($config);
			$this->email->from($from); // change it to yours
	      	$this->email->to($admin_email);// change it to yours
	      	$this->email->bcc($data_email);
	      	$this->email->subject($judul);
	      	$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
	     }else if($to == "cc"){
			$this->email->initialize($config);
			$this->email->from($from); // change it to yours
	      	$this->email->to($admin_email);// change it to yours
	      	$this->email->cc($data_email);
	      	$this->email->subject($judul);
	      	$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
	     }else if($to == "bcc"){
	     	$this->email->initialize($config);
			$this->email->from($from); // change it to yours
	      	$this->email->to($admin_email);// change it to yours
	      	$this->email->bcc($data_email);
	      	$this->email->subject($judul);
	      	$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
	     }else{
	     	$this->email->initialize($config);
			$this->email->from($from); // change it to yours
	      	$this->email->to($data_email);// change it to yours
	      	$this->email->subject($judul);
	      	$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
	     }

	    log_helper('email', ''.$this->data['username'].' ('.$this->data['id'].') Mengirim ulang email');
		$this->session->set_flashdata('success', 'Email berhasil dikirim ulang');
		redirect('trueaccon2194/email');
	}

	function hapus($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		$this->email_adm->hapus_review($idx);
		$this->session->set_flashdata('error', 'ID Review Produk '.$idx.' dihapus!');
		redirect('trueaccon2194/review_produk');
		log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Review Produk ID ('.$idx.')');
	}

	function hapus_data_dipilih() {
		$check = $this->security->xss_clean($this->input->post('iddata'));
		print_r($check);
	}
	
}