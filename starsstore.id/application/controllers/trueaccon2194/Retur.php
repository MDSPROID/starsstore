<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur extends CI_Controller {  
 
	function __construct(){ 
		parent::__construct();
		$this->load->model(array('sec47logaccess/retur_adm', 'sec47logaccess/onlinestore_adm'));
		$this->load->library(array('email','encrypt'));
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		} 
	}

	function index(){ // get data produk in list data
		$success = array( 'error' => '', 'success' => '');
		$list_data['get_list'] = $this->retur_adm->get_list_retur();
		$list_data['get_marketplace'] = $this->onlinestore_adm->get_marketplace();
		$data = array_merge($success, $list_data);
		$this->load->view('manage/header');
		$this->load->view('manage/sales/retur/index', $data);
		$this->load->view('manage/footer');
		log_helper('retur', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Retur');	
	}

	function load_all_serverside(){
		$list_data = $this->retur_adm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach($list_data as $x){
			$no++;
			$row = array();

          	if($x->buy_in == ""){
            	$buy = "<img src='".base_url('assets/images/logostsrs1.png')."' style='width:50px;height:auto;'>";
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
               	$buy = $x->buy_in;
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

	        $idxx = $this->encrypt->encode($x->id_retur_info); 
	        $idp = base64_encode($idxx);

	        $opsi = "
		        <ul class='list-inline opsi' style='margin-bottom: 0;'>
		            <li>
		              <a target='_new' title='Cetak' class='btn btn-default' href='".base_url('trueaccon2194/retur/cetak_laporan_retur/'.$idp.'')."' class='edit'><i class='glyphicon glyphicon-print'></i></a>
		            </li>
		            <li>
		              <a target='_new' title='Edit Invoice' href='".base_url('trueaccon2194/retur/edit_data/'.$idp.'')."' class='btn btn-warning'><i class='glyphicon glyphicon-pencil'></i></a> 
		            </li>
		            <li>
		              <a title='Delete Invoice' href='".base_url('trueaccon2194/retur/hapus/'.$idp.'')."' class='btn btn-danger'><i class='glyphicon glyphicon-trash'></i></a> 
		            </li>
		        </ul>
	        ";

		    if($x->id_invoice_pengganti == 0){
		    	$invoicepengganti = " - ";
		    }else{
		    	$invoicepengganti = $x->id_invoice_pengganti;
		    }

		    if($x->solusi == 1){
		    	$solusi = "Batal retur";
		    }else if($x->solusi == 2){
		    	$solusi = "Penggantian Barang Secara Online";
		    }else if($x->solusi == 3){
		    	$solusi = "Penggantian Barang ditoko";
		    }else if($x->solusi == 4){
		    	$solusi = "Penggantian Uang (Refund)";
		    }

          	// ROW START
          	$row[] = "<input type='checkbox' class='form-control' name='checklist[]' value='".$x->no_order_cus."'/>";
          	$row[] = date('d F Y', strtotime($x->date_filter));
          	$row[] = $x->id_retur_info;
          	$row[] = "Invoice Retur :<br><i><b>".$x->id_invoice_real."</i></b><br><br>Invoice Pengganti :<br><i><b>".$invoicepengganti."</i></b>";
          	$row[] = $x->alasan;
          	$row[] = $solusi;
          	$row[] = $x->keterangan_solusi;
          	$row[] = $opsi;

          	// ROW end(array)
        	$data[] = $row;
    	}

    	$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->retur_adm->count_all(),
            "recordsFiltered" => $this->retur_adm->count_filtered(),
            "data" => $data,
        );
		echo json_encode($output);
	}

	function tambah_retur(){ //load semua data yang ditampilkan pada form tambah produk
		// generate SKU Produk
	    $length =5; 
	    $koderetur = "";
	    srand((double)microtime()*1000000);
	    $data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
	    $data .= "1234567890";
	    for($i = 0; $i < $length; $i++){
	      $koderetur .= substr($data, (rand()%(strlen($data))), 1);
	      $this->data['kode_retur'] = "STRX".$koderetur;
	    }
		$this->data['solusi'] = $this->retur_adm->get_solusi();
		$this->load->view('manage/header');
		$this->load->view('manage/sales/retur/add', $this->data);
		$this->load->view('manage/footer');
	}

	function proses_tambah_retur(){ // proses tambah data produk
        if($this->input->post()){
        	$id_retur = $this->input->post('kode_retur');
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
 
			$id_user = $this->data['id'];

			$this->retur_adm->add($id_user, $data); 
			log_helper('retur', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Retur Baru dengan kode retur '.$id_retur.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> ID Retur '.$id_retur.' ditambahkan!');
			redirect('trueaccon2194/retur');
        
		}else{
			log_helper('retur', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah Voucher');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
		}
	}

	function edit_data($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		$this->data['g'] = $this->retur_adm->get_data_all($idx);
		$this->data['solusi'] = $this->retur_adm->get_solusi();
		$this->data['produk_retur'] = $this->retur_adm->get_produk_retur_detail($idx);
		
		$this->load->view('manage/header');
		$this->load->view('manage/sales/retur/edit', $this->data);
		$this->load->view('manage/footer');
	}

	function cetak_laporan_retur($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		$this->data['detail'] = $this->retur_adm->get_data_retur($idx);
		$this->data['produk'] = $this->retur_adm->get_data_produk_retur($idx);
		
		//cetak laporan
		$this->load->library('dompdf_gen');
		//send $this->data[''] to view
        $this->load->view('laporan_pdf/laporan_retur', $this->data);
        $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->set_base_path($css);
        $this->dompdf->stream("Laporan-retur-".$idx.".pdf", array('Attachment'=>0));
        exit(0);
		
	}

	function update_retur(){ // proses tambah data produk
		$id_retur = $this->input->post('kode_retur');		
		//$idf = base64_decode($id_retur); 
		//$idx = $this->encrypt->decode($idf);
		$id_user = $this->data['id'];
        if($this->input->post()){

				$data_filtering = $this->security->xss_clean($this->input->post());
        		$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

				$this->retur_adm->update_retur($id_user,$id_retur,$data); 
				
				// email ke customer tentang retur
				//$config = Array(
				//	'mailtype'  => 'html', 
				//);
				//$email_customer = $data['mail'];
				//$sub = "Retur #$idx";
				//$isi = array(
				//	'nama'		=> $data['customer'],
				//	'isi_pesan'	=> $data['keterangan'],
				//	);
				//$this->email->initialize($config);
		      	//$this->email->from('support@starsallthebest.com'); // change it to yours
		      	//$this->email->to($email_customer);// change it to yours
		      	//$this->email->subject($sub);
		      	//$body = $this->load->view('em_info_notification_group/f_cus_mail_retur',$isi,TRUE);
		      	//$this->email->message($body);
		      	//$this->email->send();

		      	log_helper('retur', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Kode Retur'.$id_retur.'');
				$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Kode Retur '.$id_retur.' telah diupdate!');
				redirect('trueaccon2194/retur');
			}else{
				log_helper('retur', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Mengupdate ID Retur ('.$id_retur.')');
				$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi internet anda');
			}
	}

	function hapus($id){
		$idf = base64_decode($id); 
		$idx = $this->encrypt->decode($idf);
		$this->retur_adm->hapus_data($idx);
		$this->retur_adm->hapus_produk_retur($idx);
		log_helper('retur', ''.$this->data['username'].' ('.$this->data['id'].') Hapus Nomor Retur ('.$idx.')');
		$this->session->set_flashdata('error', 'Nomor Retur '.$idx.' dihapus!');
		redirect('trueaccon2194/retur');
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$cek = $this->input->post('checklist');
			$this->retur_adm->remove_dipilih($cek);
			print_r($cek);
			log_helper("produk", "Menghapus Produk yang dipilih");
			//redirect('trueaccon2194/produk');
	}
	
}