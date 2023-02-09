<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller { 
 
	function __construct(){
		parent:: __construct();
		$this->load->model(array('sec47logaccess/order_adm','sec47logaccess/onlinestore_adm'));
		$this->load->library(array('email','encrypt'));
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}
 
	function generate_new_invoice(){
		$length =5; 
		$random= "";
		srand((double)microtime()*1000000);
		$data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
		$data .= "1234567890";
		for($i = 0; $i < $length; $i++){
			$random .= substr($data, (rand()%(strlen($data))), 1);
		}
		// AWALAN INVOICE
		$utama = "STM";
		// ID CUSTOMER
		//$id = $this->data['id'];
		// TANGGAL
		$tgl_text = date('D');
		$tgl = date('d', strtotime($tgl_text));
		// BULAN
		$bln_text = date('M');
		$bln = date('m', strtotime($bln_text));
		// TAHUN
		$year  = date('y');	
		// RESULT INVOICE
		$invoice = $utama.$random.$tgl.$bln.$year;

		echo $invoice;
	}
 
	function cek_expired_order(){ 
		$cek = $this->order_adm->cek_exp();
		foreach($cek as $r){ 
			$id = $r->id;
			$now = date('Y-m-d H:i:s');
			$dateData = $r->tanggal_jatuh_tempo;

			if($now > $dateData){
				$this->order_adm->ganti_status_exp($id);
				$g = $this->order_adm->getMailcs($inv);
				foreach($g as $f){
					$email = $f->email;
					$inv = $f->invoice;
				}
				$config = Array(
					'mailtype'  => 'html', 
				);
				$data_order = array(
					'invoice' 	=> $inv,
					'status'	=> '<i style="color:red;">dibatalkan</i>',
					'content'	=> 'Pesanan anda kami batalkan karena tidak memenuhi syarat. atau kami tidak menerima pembayaran anda. jika anda telah mentransfer sejumlah uang. <a href="'.base_url('bantuan').'">Klik disini</a> untuk menghubungi kami.',
				);
				$judulEmail = "Order anda";
				$this->email->initialize($config);
		      	$this->email->from('noreply@starsstore.id'); // change it to yours
		      	$this->email->to($email);// change it to yours
		      	$this->email->subject('Order anda');
		      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
		      	$this->email->message($body);
		      	$this->email->send();
		      	log_helper('onlinestore', 'Sistem mengubah otomatis order no. invoice '.$inv.' menjadi batal');
			}else{
				//echo "GAK EXPIRED";
			}
		}
	}

	function index(){ 
		$this->data['market'] = $this->order_adm->get_marketplace();
		$this->data['store_list'] = $this->order_adm->get_toko();
		//$this->data['get_konfirmasi_pembayaran'] = $this->order_adm->get_konfirmasi_data();
		$this->load->view('manage/header');
		$this->load->view('manage/sales/order/index', $this->data);	
		$this->load->view('manage/footer');
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Order');
	}  

	function test_all_order(){
		$list_data = $this->order_adm->get_datatables_all();
		print_r($list_data);
	}

	function load_all_serverside(){
		$list_data = $this->order_adm->get_datatables();
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
            	$buy = "E-commerce<br><i style='font-size:10px;'>Dikirim Oleh : <br>".$x->nama_toko."</i>";
            }else{
               	$buy = $x->buy_in."<br><i style='font-size:10px;'>Dikirim Oleh : <br>".$x->nama_toko."</i>";
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
	        if($x->status == "2hd8jPl613!2_^5"){
	        	$storder =
	            "<select name='stat_change' class='form-control stat_change' onchange='selectStatus(this);' style='margin-bottom:10px'>
	              <option selected value='".$idp.",menunggu'>Menunggu Pembayaran</option>
	              <option value='".$idp.",dibayar'>Pembayaran Diterima</option>
	              <option value='".$idp.",pengiriman'>Dalam Pengiriman</option>
	              <option value='".$idp.",diterima'>Diterima</option>
	              <option value='".$idp.",dibatalkan'>Dibatalkan</option>
	            </select>";
	        }else if($x->status == "*^56t38H53gbb^%$0-_-"){
	        	$storder =
	        	"<select name='stat_change' class='form-control stat_change' onchange='selectStatus(this);' style='margin-bottom:10px'>
	              <option value='".$idp.",menunggu'>Menunggu Pembayaran</option>
	              <option selected value='".$idp.",dibayar'>Pembayaran Diterima</option>
	              <option value='".$idp.",pengiriman'>Dalam Pengiriman</option>
	              <option value='".$idp.",diterima'>Diterima</option>
	              <option value='".$idp.",dibatalkan'>Dibatalkan</option>
	            </select>";
	        }else if($x->status == "Uywy%u3bShi)payDhal"){
	        	$storder =
	        	"<select name='stat_change' class='form-control stat_change' onchange='selectStatus(this);' style='margin-bottom:10px'>
	              <option value='".$idp.",menunggu'>Menunggu Pembayaran</option>
	              <option value='".$idp.",dibayar'>Pembayaran Diterima</option>
	              <option selected value='".$idp.",pengiriman'>Dalam Pengiriman</option>
	              <option value='".$idp.",diterima'>Diterima</option>
	              <option value='".$idp.",dibatalkan'>Dibatalkan</option>
	            </select>";
	        }else if($x->status == "ScUuses8625(62427^#&9531(73"){
	        	$storder = 
	        	"<select name='stat_change' class='form-control stat_change' onchange='selectStatus(this);' style='margin-bottom:10px'>
	              <option value='".$idp.",menunggu'>Menunggu Pembayaran</option>
	              <option value='".$idp.",dibayar'>Pembayaran Diterima</option>
	              <option value='".$idp.",pengiriman'>Dalam Pengiriman</option>
	              <option selected value='".$idp.",diterima'>Diterima</option>
	              <option value='".$idp.",dibatalkan'>Dibatalkan</option>
	            </select>";
	        }else if($x->status == "batal"){
	        	$storder =
	        	"<select name='stat_change' class='form-control stat_change' onchange='selectStatus(this);' style='margin-bottom:10px'>
	              <option value='".$idp.",menunggu'>Menunggu Pembayaran</option>
	              <option value='".$idp.",dibayar'>Pembayaran Diterima</option>
	              <option value='".$idp.",pengiriman'>Dalam Pengiriman</option>
	              <option value='".$idp.",diterima'>Diterima</option>
	              <option selected value='".$idp.",dibatalkan'>Dibatalkan</option>
	            </select>";
	        }

	        $opsi = "
		        <ul class='list-inline opsi' style='margin-bottom: 0;'>
		            <li>
		              <a title='Detail Invoice' class='btn btn-default' href='".base_url('trueaccon2194/order/detail/'.$idp.'')."' class='edit'><i class='glyphicon glyphicon-eye-open'></i></a>
		            </li>
		            <li>
		              <a title='Edit Invoice' href='".base_url('trueaccon2194/online_store/edit/'.$idp.'')."' class='btn btn-warning'><i class='glyphicon glyphicon-pencil'></i></a> 
		            </li>
		            <li>
		              <a title='Hapus Invoice' href='javascript:void(0)' class='btn btn-danger hapus' data-id='".$idp."' data-name='".$x->invoice."' style='display:none;' onclick='hapus_order_marketplace(this)'><i class='glyphicon glyphicon-trash'></i></a> 
		            </li>
		        </ul>
	        ";

	        if($x->baca == "belum"){
              $sta21 = "<span style='color:green'>".$x->invoice."</span>";
            }else{
              $sta21 = "<span style='color:black'>".$x->invoice."</span>";
            }

            if($x->invoice == $x->id_pesanan){
            	$status_bukti = "<div style='margin-top:10px;'><label class='label label-success'>Bukti : Ada</label></div>";
            }else{
            	$status_bukti = "<div style='margin-top:10px;'><label class='label label-danger'>Bukti : Belum</label></div>";
            }

            $idinvoice = $x->invoice;
		    $get_invx = $this->order_adm->get_inv_inout($idinvoice); 
		    $invxx = $get_invx['id_inout'];

          	// ROW START
          	$row[] = "<input type='checkbox' class='form-control' name='checklist[]' value='".$x->no_order_cus."'/>";
          	$row[] = $sta21."</a><br><span style='font-size: 12px;'>No resi : <i style='color:red'>".$x->no_resi."</i></span><br><span style='font-size: 12px;'>No. Pemindahan POS : <i style='color:red'>".$invxx."</i></span>";
          	$row[] = $buy;
          	$row[] = date('d F Y H:i:s', strtotime($x->tanggal_waktu_order));
          	$row[] = date('d F Y H:i:s', strtotime($x->tanggal_jatuh_tempo));
          	$row[] = date('d F Y H:i:s', strtotime($x->tanggal_waktu_order_finish));
          	$row[] = $x->nama_lengkap;
          	$row[] = "Rp. ".number_format($x->total_belanja,0,".",".");
          	$row[] = $status."<br>".$stat_bayar."".$status_bukti;
          	$row[] = $storder."<br>".$opsi;

          	// ROW end(array)
        $data[] = $row;
    	}

    	$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->order_adm->count_all(),
            "recordsFiltered" => $this->order_adm->count_filtered(),
            "data" => $data,
        );
		echo json_encode($output);
	}
 
	function load_all_bukti_pembayaran(){
		$list_data = $this->order_adm->get_datatables_konfirmasi();
		$data = array();
		$no = $_POST['start'];
		foreach($list_data as $x){
			$no++; 
			$row = array();

			$id = $this->encrypt->encode($x->identity_pembayaran); 
			$idp = base64_encode($id);

	        $opsi = "
		        <ul class='list-inline opsi' style='margin-bottom: 0;'>
		            <li>
		              <a title='Detail Invoice' class='btn btn-default' href='".base_url('trueaccon2194/order/detail_konfirmasi/'.$idp.'')."' class='edit'><i class='glyphicon glyphicon-eye-open'></i></a>
		            </li>
		            <li>
		              <a title='Edit Invoice' href='".base_url('trueaccon2194/order/edit_konfirmasi/'.$idp.'')."' class='btn btn-warning'><i class='glyphicon glyphicon-pencil'></i></a> 
		            </li>
		            <li>
		              <a title='Edit Invoice' href='javascript:void(0)' href='".base_url('trueaccon2194/order/edit_konfirmasi/'.$idp.'')."' class='btn btn-danger hapus' data-id='".$idp."' data-name='".$x->id_pesanan."' onclick='hapus_konfirmasi(this);'><i class='glyphicon glyphicon-trash'></i></a> 
		            </li>
		        </ul>
	        ";
	        if($x->eml == ""){
	        	$m = $x->no_telp;
	        }else{
	        	$m = $x->eml;
	        }

          	// ROW START
          	$row[] = "<input type='checkbox' class='form-control' name='checklist[]' value='".$x->identity_pembayaran."'/>";
          	$row[] = $x->id_pesanan."</label><br><span style='font-size: 12px;'>[ ".$x->buy_in." ]</span>";
          	$row[] = date('d F Y', strtotime($x->tgl));
          	$row[] = $x->nama_lengkap;
          	$row[] = $m;
          	//$row[] = "-";
          	$row[] = "Rp. ".number_format($x->total_belanja,0,".",".")."<br><i style='color:red;font-size:10px;'>Mohon dicek total belanja dengan nominal yang ditransfer</i>";
          	$row[] = $opsi;

          	// ROW end(array)
        	$data[] = $row;
    	}

    	$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->order_adm->count_all_konfirmasi(),
            "recordsFiltered" => $this->order_adm->count_filtered_konfirmasi(),
            "data" => $data,
        );
		echo json_encode($output);
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
		$this->merk_adm->remove_selected();
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Hapus Merk');
		redirect('trueaccon2194/merk');
	}

	function sender(){
		$idorder = $this->security->xss_clean($this->input->post('iorder'));
		$sender = $this->security->xss_clean($this->input->post('sender'));
		$invx = base64_decode($idorder);
		$inv = $this->encrypt->decode($invx);

		$datasender = array(
			'sender' => $sender, 
		);

		$this->order_adm->update_sender($datasender, $inv);
		$this->session->set_flashdata('success','Toko pengirim telah diupdate');
		redirect($this->agent->referrer());
	}

	function searchstore(){
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(4);

		// cari di database
		$data = $this->order_adm->cariDatatoko($keyword);

		// format keluaran di dalam array
		if($data->num_rows() == 0){
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=> 'Tidak ada hasil',
				'nama_toko'	=> 'Tidak ada hasil', 
			);
		}
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=> $row->nama_toko,
				'kode_toko'=> $row->kode_edp,
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	function ubah_status_order($id){
		$rai = explode(',', $id);
		$invxx 	= $rai[0];
		$invx = base64_decode($invxx);
		$inv = $this->encrypt->decode($invx);
		$status = $rai[1];
		$this->order_adm->changeStat($inv,$status);
		// get email customer
		$g = $this->order_adm->getMailcs($inv);
		foreach($g as $f){
			$no_order1 = $this->encrypt->encode($f->no_order_cus);
			$no_order = base64_encode($no_order1);
			$noder = $f->no_order_cus;
			$email = $f->email;
			$inv = $f->invoice;
			$no_resi = $f->no_resi;
		}

		if($status == "pengiriman"){
			$data_order = array( 
				'invoice' 	=> $inv,
				'status'	=> $status,
				'content'	=> 'Pesanan anda telah kami kirim, berikut nomor resi pesanan anda '.$no_resi.'<br> terima kasih telah berbelanja.',
			);
		}else if($status == "dibayar"){
			$data_order = array(
				'invoice' 	=> $inv,
				'status'	=> $status,
				'content'	=> 'Pembayaran anda telah kami terima, pesanan anda akan segera kami proses.<br> terima kasih telah berbelanja.',
			);
		}else if($status == "diterima"){
			// update tanggal selesai order_produk
			//$this->order_adm->update_selesai2($inv);
			$data_order = array(
				'invoice' 	=> $inv,
				'status'	=> $status,
				'content'	=> 'Terima kasih telah berbelanja. Pesanan anda kami lacak sudah sampai pada penerima, silahkan isi review untuk produknya. <a href="'.base_url('review_order_produk/'.$no_order.'').'">klik disini</a>',
			);
		}else if($status == "batal"){
			$data_order = array(
				'invoice' 	=> $inv,
				'status'	=> $status,
				'content'	=> 'Pesanan anda kami batalkan karena tidak memenuhi syarat. atau kami tidak menerima pembayaran anda. jika anda telah mentransfer sejumlah uang. <a href="'.base_url('bantuan').'">Klik disini</a> untuk menghubungi kami.',
			);
		}

		$config = Array(
			'mailtype'  => 'html', 
		);

		$judulEmail = "Order anda";
		$this->email->initialize($config);
      	$this->email->from('noreply@starsstore.id'); // change it to yours
      	$this->email->to($email);// change it to yours
      	$this->email->subject('Order anda');
      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
      	$this->email->message($body);
      	$this->email->send();
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Mengubah status Order Invoice #'.$inv.' menjadi '.$status.'');
	}

	function ubah_status_order_market($id){
		$rai = explode(',', $id);
		$inv 	= $rai[0];
		$status = $rai[1];
		$this->order_adm->changeStat_market($inv,$status); 
		// get email customer
		$g = $this->order_adm->getMailcs($inv);
		foreach($g as $f){
			$no_order1 = $this->encrypt->encode($f->no_order_cus);
			$no_order = base64_encode($no_order1);
			$noder = $f->no_order_cus;
			$email = $f->email;
			$inv = $f->invoice;
			$no_resi = $f->no_resi;
		}
		$config = Array(
			'mailtype'  => 'html', 
		);

		if($status == "pengiriman"){
			$data_order = array(
				'invoice' 	=> $inv,
				'status'	=> $status,
				'content'	=> 'Pesanan anda telah kami kirim, berikut nomor resi pesanan anda '.$no_resi.'<br> terima kasih telah berbelanja.',
			);
		}else if($status == "dibayar"){
			$data_order = array(
				'invoice' 	=> $inv,
				'status'	=> $status,
				'content'	=> 'Pembayaran anda telah kami terima, pesanan anda akan segera kami proses.<br> terima kasih telah berbelanja.',
			);
		}else if($status == "diterima"){
			// update tanggal selesai order_produk
//			$this->order_adm->update_selesai($inv);
			$data_order = array(
				'invoice' 	=> $inv,
				'status'	=> $status,
				'content'	=> 'Terima kasih telah berbelanja. Pesanan anda kami lacak sudah sampai pada penerima, silahkan isi review untuk produknya. <a href="'.base_url('review_order_produk/'.$no_order.'').'">klik disini</a>',
			);
		}else if($status == "batal"){
			$data_order = array(
				'invoice' 	=> $inv,
				'status'	=> $status,
				'content'	=> 'Pesanan anda kami batalkan karena tidak memenuhi syarat. atau kami tidak menerima pembayaran anda. jika anda telah mentransfer sejumlah uang. <a href="'.base_url('bantuan').'">Klik disini</a> untuk menghubungi kami.',
			);
		}
		$judulEmail = "Order anda";
		$this->email->initialize($config);
      	$this->email->from('noreply@starsstore.id'); // change it to yours
      	$this->email->to($email);// change it to yours
      	$this->email->subject('Order anda');
      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
      	$this->email->message($body);
      	$this->email->send();
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Mengubah status Order marketplace Invoice #'.$inv.' menjadi '.$status.'');
	}

	function detail($id){
		$this->load->model('sec47logaccess/onlinestore_adm');

		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		// ubah status baca
		$data_baca = array(
			'baca' => 'sudah',
		);
		$this->order_adm->ubah_status_baca($b, $data_baca);
		$data['detailorder'] = $this->order_adm->checkingInv($id);
		$data['produk'] = $this->order_adm->checkingdataorder($id);
		$data['tokopengirim']	= $this->order_adm->get_data_tokopengirim($id);
		// get data bank from id network invoice
		$codeBank = $this->order_adm->checkingdataBank($b);
		foreach($codeBank as $as){
			$idbnk = $as->bank_pembayaran;
		}
		// payment info toko
		$this->load->model('checkout_model');
		$bnkm =  $this->order_adm->selectInfbnk($idbnk);

		$data['bnkInfo'] = $bnkm;
		$data['code_net_bank'] = $codeBank;
		$this->load->view('manage/header');
		$this->load->view('manage/sales/order/detail',$data);
		$this->load->view('manage/footer');
	}

	function detail_konfirmasi($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a); 
		
		$data['detailkonfirmasi'] = $this->order_adm->getkonfirmasi($b);
		$data['detailbukti'] = $this->order_adm->getkonfirmasi_bukti($b);

		$this->load->view('manage/header');
		$this->load->view('manage/sales/order/detail_konfirmasi',$data);
		$this->load->view('manage/footer');
	}

	function tambah_konfirmasi(){
		// generate SKU Produk
		$length =10; 
		$sku= "";
		srand((double)microtime()*1000000);
		$datax = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
		$datax .= "1234567890";
		for($i = 0; $i < $length; $i++){
			$sku .= substr($datax, (rand()%(strlen($datax))), 1);
			$data['identity'] = "BK_".$sku;
		}

		$data['bank']	= $this->order_adm->daftar_rekening_pusat(); 
		$this->load->view('manage/header');
		$this->load->view('manage/sales/order/tambah_konfirmasi',$data);
		$this->load->view('manage/footer');	
	}

	function proses_konfirmasi(){
		$vrnx1 = $this->security->xss_clean($this->input->post('kIns'));
		$vrnx2 = base64_decode($vrnx1);
		$vrnx = $this->encrypt->decode($vrnx2);

		$idx1 = $this->security->xss_clean($this->input->post('sku_m'));
		$idx2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$idx1);
		$idx3 = strip_tags($idx2);
		$idx = htmlentities($idx3);

		$id1 = $this->security->xss_clean($this->input->post('id_pesanan'));
		$id2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$id1);
		$id3 = strip_tags($id2);
		$id = htmlentities($id3);

		$nm1 = $this->security->xss_clean($this->input->post('nama'));
		$nm2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nm1);
		$nm3 = strip_tags($nm2);
		$nm = htmlentities($nm3);

		$em1 = $this->security->xss_clean($this->input->post('email'));
		$em2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$em1);
		$em3 = strip_tags($em2);
		$em = htmlentities($em3);

		$bnk1 = $this->security->xss_clean($this->input->post('bank'));
		$bnk2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$bnk1);
		$bnk3 = strip_tags($bnk2);
		$bnkx = htmlentities($bnk3);

		$bnkxx = explode('|', $bnkx);
		$namebank1 = base64_decode($bnkxx[0]);
		$nobank2 = base64_decode($bnkxx[1]);

		$bank_gabung = $namebank1." - ".$nobank2;

		$tgl1 = $this->security->xss_clean($this->input->post('tgl_transfer'));
		$tgl2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$tgl1);
		$tgl3 = strip_tags($tgl2);
		$tgl = htmlentities($tgl3);

		$nmn1 = $this->security->xss_clean($this->input->post('nominal'));
		$nmn2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nmn1);
		$nmn3 = strip_tags($nmn2);
		$nmn = htmlentities($nmn3);

		$note1 = $this->security->xss_clean($this->input->post('catatan'));
		$note2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$note1);
		$note3 = strip_tags($note2);
		$note = htmlentities($note3);		

		if($note == ""){	
			$notex = "-";
		}else{
			$notex = $note;
		}

		if($vrnx != "KntJs628%243@729&2!46"){

			$this->load->model('sec47logaccess/setting_adm');
			$aktifitas = "memecahkan kode enkripsi untuk input bukti pembayaran ".$id."";
			$this->setting_adm->savingHack($aktifitas);

		}else{ 

			// cek id pesanan
			$cek = $this->order_adm->cek_pesanan($id);
			if($cek->num_rows() == 0){ // jika tidak ketemu

				// hapus bukti transfer supaya tidak memenuhi database 

				$foto = $this->db->get_where('bukti_transfer',array('identity_bukti'=>$idx));

				//print_r($foto->num_rows());
				if($foto->num_rows()>0){
					$hasil 		= $foto->row();
					$nama_foto	= $hasil->gambar;

					$srcx = str_replace(''.base_url('assets/images/konfirmasi_pesanan/').'','', $nama_foto);
					$file = FCPATH.'assets/images/konfirmasi_pesanan/'.$srcx.'';
					//if(file_exists($file = FCPATH.'/assets/images/konfirmasi_pesanan/'.$nama_foto)){
						unlink($file);
						//print_r($file);
					//}
					$this->db->delete('bukti_transfer',array('identity_bukti'=>$idx));
				}

				$this->session->set_flashdata('error','Nomor pesanan tidak ditemukan');
				redirect($this->agent->referrer());

			}else{ // JIKA KETEMU MAKA DICEK LAGI

				$cek2 = $this->order_adm->cek_konfirm_already($id);
				if($cek2->num_rows() > 0){ // jika sudah pernah dikonfirmasi

					// hapus bukti transfer supaya tidak memenuhi database 

					$foto = $this->db->get_where('bukti_transfer',array('identity_bukti'=>$idx));

					//print_r($foto->num_rows());
					if($foto->num_rows()>0){
						$hasil 		= $foto->row();
						$nama_foto	= $hasil->gambar;

						$srcx = str_replace(''.base_url('assets/images/konfirmasi_pesanan/').'','', $nama_foto);
						$file = FCPATH.'assets/images/konfirmasi_pesanan/'.$srcx.'';
						//if(file_exists($file = FCPATH.'/assets/images/konfirmasi_pesanan/'.$nama_foto)){
							unlink($file);
							//print_r($file);
						//}
						$this->db->delete('bukti_transfer',array('identity_bukti'=>$idx));
					}
						
					$this->session->set_flashdata('error','Nomor pesanan sudah dikonfirmasi');
					redirect($this->agent->referrer());

				}else{

					// update status
					//$status = array(
					//	'status'	=> "*^56t38H53gbb^%$0-_-",
					//);
					//$this->order_adm->update_status_pesanan($status, $id);

					$this->form_validation->set_rules('id_pesanan', 'ID Pesanan', 'required|xss_clean');
					//$this->form_validation->set_rules('nama', 'Nama lengkap', 'required|xss_clean');
					//$this->form_validation->set_rules('bank', 'Bank', 'required|xss_clean');
					$this->form_validation->set_rules('tgl_transfer', 'Tanggal Transfer', 'required|xss_clean');
					$this->form_validation->set_rules('nominal', 'Nominal', 'required|xss_clean');

					if($this->form_validation->run() != FALSE ){	
						// simpan data
						$data_konfirmasi = array(
							'identity_pembayaran'	=> $idx,
							'id_pesanan'			=> $id,
							'nama'					=> "-",//$nm,
							'email'					=> "-",//$em,
							'bank'					=> "-",//$bank_gabung,
							'tgl'					=> $tgl,
							'nominal'				=> $nmn,
							'catatan'				=> $notex,
							'tgl_input_data'		=> date("Y-m-d H:i:s"),
						);
						$this->order_adm->simpan_bukti_pembayaran($data_konfirmasi);

						$this->session->set_flashdata('success','Data konfirmasi disimpan');
						redirect(base_url('trueaccon2194/order'));

					}else{

						$this->session->set_flashdata('error','Lengkapi form terlebih dahulu <br>*'.validation_errors().'');
						redirect($this->agent->referrer());
					}
				}
			}
		}
	}

	function searchidpesanan(){
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(4);

		// cari di database
		$data = $this->order_adm->cariDataidpesanan($keyword);

		// format keluaran di dalam array
		if($data->num_rows() == 0){
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'		=> 'Tidak ada hasil',
				'invoice'	=> 'Tidak ada hasil', 
			);
		}
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'		=> $row->invoice,
				'invoice'	=> $row->invoice,
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}


	function update_konfirmasi(){
		$vrnx1 = $this->security->xss_clean($this->input->post('kIns'));
		$vrnx2 = base64_decode($vrnx1);
		$vrnx = $this->encrypt->decode($vrnx2);

		$idx1 = $this->security->xss_clean($this->input->post('sku_m'));
		$idx2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$idx1);
		$idx3 = strip_tags($idx2);
		$idx = htmlentities($idx3);

		$id1 = $this->security->xss_clean($this->input->post('id_pesanan'));
		$id2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$id1);
		$id3 = strip_tags($id2);
		$id = htmlentities($id3);

		$nm1 = $this->security->xss_clean($this->input->post('nama'));
		$nm2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nm1);
		$nm3 = strip_tags($nm2);
		$nm = htmlentities($nm3);

		$em1 = $this->security->xss_clean($this->input->post('email'));
		$em2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$em1);
		$em3 = strip_tags($em2);
		$em = htmlentities($em3);

		$bnk1 = $this->security->xss_clean($this->input->post('bank'));
		$bnk2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$bnk1);
		$bnk3 = strip_tags($bnk2);
		$bnkx = htmlentities($bnk3);

		$bnkxx = explode('|', $bnkx);
		$namebank1 = base64_decode($bnkxx[0]);
		$nobank2 = base64_decode($bnkxx[1]);

		$bank_gabung = $namebank1." - ".$nobank2;

		$tgl1 = $this->security->xss_clean($this->input->post('tgl_transfer'));
		$tgl2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$tgl1);
		$tgl3 = strip_tags($tgl2);
		$tgl = htmlentities($tgl3);

		$nmn1 = $this->security->xss_clean($this->input->post('nominal'));
		$nmn2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nmn1);
		$nmn3 = strip_tags($nmn2);
		$nmn = htmlentities($nmn3);

		$note1 = $this->security->xss_clean($this->input->post('catatan'));
		$note2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$note1);
		$note3 = strip_tags($note2);
		$note = htmlentities($note3);		

		if($note == ""){	
			$notex = "-";
		}else{
			$notex = $note;
		}

		if($vrnx != "KntJs628%243@729&2!46"){

			$this->load->model('sec47logaccess/setting_adm');
			$aktifitas = "memecahkan kode enkripsi untuk input bukti pembayaran ".$id."";
			$this->setting_adm->savingHack($aktifitas);

		}else{ 

			// cek id pesanan
			$cek = $this->order_adm->cek_pesanan($id);
			if($cek->num_rows() == 0){ // jika tidak ketemu

				// hapus bukti transfer supaya tidak memenuhi database 

				$foto = $this->db->get_where('bukti_transfer',array('identity_bukti'=>$idx));

				//print_r($foto->num_rows());
				if($foto->num_rows()>0){
					$hasil 		= $foto->row();
					$nama_foto	= $hasil->gambar;

					$srcx = str_replace(''.base_url('assets/images/konfirmasi_pesanan/').'','', $nama_foto);
					$file = FCPATH.'assets/images/konfirmasi_pesanan/'.$srcx.'';
					//if(file_exists($file = FCPATH.'/assets/images/konfirmasi_pesanan/'.$nama_foto)){
						unlink($file);
						//print_r($file);
					//}
					$this->db->delete('bukti_transfer',array('identity_bukti'=>$idx));
				}

				$this->session->set_flashdata('error','Nomor pesanan tidak ditemukan');
				redirect($this->agent->referrer());

			}else{ // JIKA KETEMU MAKA DICEK LAGI

				// update status
				//$status = array(
				//	'status'	=> "*^56t38H53gbb^%$0-_-",
				//);
				//$this->order_adm->update_status_pesanan($status, $id);

				$this->form_validation->set_rules('id_pesanan', 'ID Pesanan', 'required|xss_clean');
				//$this->form_validation->set_rules('nama', 'Nama lengkap', 'required|xss_clean');
				//$this->form_validation->set_rules('bank', 'Bank', 'required|xss_clean');
				$this->form_validation->set_rules('tgl_transfer', 'Tanggal Transfer', 'required|xss_clean');
				$this->form_validation->set_rules('nominal', 'Nominal', 'required|xss_clean');

				if($this->form_validation->run() != FALSE ){	

					$data_konfirmasi = array(
						'identity_pembayaran'	=> $idx,
						'id_pesanan'			=> $id,
						'nama'					=> "-",//$nm,
						'email'					=> "-",//$em,
						'bank'					=> "-",//$bank_gabung,
						'tgl'					=> $tgl,
						'nominal'				=> $nmn,
						'catatan'				=> $notex,
						'tgl_input_data'		=> date("Y-m-d H:i:s"),
					);

					$this->order_adm->update_bukti_pembayaran($data_konfirmasi, $idx);

					$this->session->set_flashdata('success','Data konfirmasi diupdate');
					redirect(base_url('trueaccon2194/order'));

				}else{

					$this->session->set_flashdata('error','Lengkapi form terlebih dahulu <br>*'.validation_errors().'');
					redirect($this->agent->referrer());
				}

			}
		}

	}

	function edit_konfirmasi($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		
		$data['x'] = $this->order_adm->getkonfirmasidata($b);
		$data['gb_bukti'] = $this->order_adm->getkonfirmasibukti($b);
		$data['bank']	= $this->order_adm->daftar_rekening_pusat(); 
		$this->load->view('manage/header');
		$this->load->view('manage/sales/order/edit_konfirmasi',$data);
		$this->load->view('manage/footer');
	}

	function delete_select_image(){
		$token = $this->input->get('token');
		$src = $this->input->get('src');
		$srch = base_url("assets/images/konfirmasi_pesanan/");
		$r = str_replace($srch,"", $src);
		$file = FCPATH.'assets/images/konfirmasi_pesanan/'.$r.'';
		unlink($file);
		$this->db->delete('bukti_transfer',array('token'=>$token));
		echo json_encode(array("status" => TRUE));
	}

	function cetak_stiker($id){
		$this->load->library('dompdf_gen');
		$this->load->model('sec47logaccess/onlinestore_adm');
		$gdata = $this->onlinestore_adm->checkingInv($id);
		foreach($gdata as $y){
			$inv = $y->invoice;
			$by = $y->buy_in;
		}
		$data['detailorder'] = $gdata;
		$data['produk'] = $this->onlinestore_adm->checkingdataorder($id);
		$this->load->view('laporan_pdf/lap_inv_order_marketplace_label_pengiriman', $data);
		$paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->set_base_path('qusour894/css');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        
        //$this->dompdf->set_base_path($css);
        $this->dompdf->stream("Label_stiker_pengiriman_".$inv.".pdf", array('Attachment'=>0));
        exit(0);
	}

	function tambah_no_resi(){ // seng digawe
		$resi = $this->input->get('no');
		$email_ex = $this->input->get('email'); 
		$inv = $this->input->get('inv'); 
		
		$p = explode('|', $email_ex);
		$email = $p[0];
		$expedisi = $p[1];

		//$a = base64_decode($inv);
		//$b = $this->encrypt->decode($a);
		// input resi
		$this->order_adm->input_resi_update_status($resi, $inv);
		// update status jadi dalam pengiriman
		// $this->order_adm->update_status_pengiriman($inv); //SUDAH JADI SATU DENGAN input_resi_update_status();
		$config = Array(
			'mailtype'  => 'html', 
		);
		$data_order = array(
			'invoice' 	=> $inv,
			'status'	=> 'Dalam Pengiriman',
			'content'	=> '<p style="text-align:justify;">Pesanan anda dalam proses pengiriman, nomor resi untuk pesanan anda <b>'.$resi.'</b> menggunakan expedisi '.$expedisi.'. kami akan memberitahu anda jika pesanan anda telah sampai.</p>',
		);
		
		$this->email->initialize($config);
      	$this->email->from('noreply@starsstore.id'); // change it to yours
      	$this->email->to($email);// change it to yours
      	$this->email->subject('Order anda');
      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
      	$this->email->message($body);
      	$this->email->send();
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Menginputkan resi '.$resi.' untuk order #'.$inv.' dan mengirim email status pesanan ke '.$email.'');
	}

	function tambah_no_resi_with_notif_email(){ // gak digawe (gawe backupan)
		$resi = $this->input->get('no');
		$inv = $this->input->get('inv');
		$a = base64_decode($inv);
		$b = $this->encrypt->decode($a);
		// input resi
		$this->order_adm->input_resi($resi, $b);
		// update status jadi dalam pengiriman
		$this->order_adm->update_status_pengiriman($b);
		$config = Array(
			'mailtype'  => 'html', 
		);
		$data_order = array(
			'invoice' 	=> $b,
			'status'	=> 'Dalam Pengiriman',
			'content'	=> 'Pesanan dalam proses pengiriman, nomor resi untuk pesanan anda '.$resi.'. kami akan memberitahu anda jika pesanan anda telah sampai.',
		);
		
		$this->email->initialize($config);
      	$this->email->from('noreply@starsstore.id'); // change it to yours
      	$this->email->to($email);// change it to yours
      	$this->email->subject('Order anda');
      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
      	$this->email->message($body);
      	$this->email->send();
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Menginputkan resi '.$no.' untuk order #'.$b.'');
	}

	function cetak_invoice($id){
		$this->load->library('dompdf_gen');
		$ins = base64_decode($id);
		$b = $this->encrypt->decode($ins);

		//get data invoice
		$gdata = $this->order_adm->checkingInv($id);
		foreach($gdata as $y){
			$inv = $y->invoice;
		}
		//get order berdasarkan invoice
		$gorder = $this->order_adm->checkingdataorder($id);
		// get data bank from id network invoice
		$codeBank = $this->order_adm->checkingdataBank($b);
		foreach($codeBank as $as){
			$idbnk = $as->bank_pembayaran;
		}
		// payment info toko
		$bnkm =  $this->order_adm->selectInfbnk($idbnk);
		$data['qrinvoice'] = $inv;
		$data['detail_inv'] = $gdata;
		$data['detail_order'] = $gorder;
		$data['bnkInfo'] = $bnkm;
		$data['code_net_bank'] = $codeBank;
		$data['title'] = 'Cetak Invoice '.$inv.''; //judul title
 		
        $this->load->view('laporan_pdf/lap_inv_order_backend_default', $data);
        //$paper_size  = 'A4'; //paper size
        //$orientation = 'potrait'; //tipe format kertas
        //$html = $this->output->get_output();
 
        //$this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->load_html($html);
        //$this->dompdf->render();
        
        //$this->dompdf->set_base_path($css);
        //$this->dompdf->stream("laporan_order_".$inv.".pdf", array('Attachment'=>0));
        //exit(0);
	}

	function filter_laporan_penjualan(){
		$tgl1 = $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 = $this->security->xss_clean($this->input->post('tgl2'));
		$divisi = $this->security->xss_clean($this->input->post('divisi'));
		$jenis = $this->security->xss_clean($this->input->post('jenis_artikel'));
		$status = $this->security->xss_clean($this->input->post('status'));
		// filter
		$this->order_adm->filter_laporan($tgl1, $tgl2, $divisi, $jenis);

		//cetak laporan
		$this->load->library('dompdf_gen');
		//send data[''] to view
        $this->load->view('laporan_pdf/lap_inv_order_customer_default', $data);
        $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->set_base_path('qusour894/css');
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        
        //$this->dompdf->set_base_path($css);
        $this->dompdf->stream("Laporan_penjualan_".$tgl1."-".$tgl2."_jenis_artikel_".$jenis."_status_".$status.".pdf", array('Attachment'=>0));
        exit(0);
	}

	function laporan_konfirmasi_pembayaran(){
		$tgl1 		= $this->security->xss_clean($this->input->post('tgl1'));
		$tgl2 		= $this->security->xss_clean($this->input->post('tgl2'));
		$market1 	= $this->security->xss_clean($this->input->post('marketplace'));
		$status22 	= $this->security->xss_clean($this->input->post('status'));
		$status 	= $this->security->xss_clean($this->input->post('bayar'));
		$sortby 	= $this->security->xss_clean($this->input->post('sortby'));

		$data['tgl1'] = $tgl1;
		$data['tgl2'] = $tgl2;

		$list_market = $this->onlinestore_adm->get_marketplace();
        foreach($list_market as $hx){
        	// load data marketplace
        	$mrx[] = $hx->val_market;
        }

        if($market1 == "semua"){
    		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
    		$market_title = "Semua Marketplace";
        }else{
        	$market = $market1;
        	$market_title = $market1;
        }
        $data['market'] = $market_title;

        if($status22 == "semua"){

	    	$status2 = array('2hd8jPl613!2_^5', '*^56t38H53gbb^%$0-_-', 'Uywy%u3bShi)payDhal', 'ScUuses8625(62427^#&9531(73', 'batal');
	    	$data['status2'] = "Semua";

	    }else{
	    	$status2 = $status22;
	    	if($status2 == "2hd8jPl613!2_^5"){
	    		$data['status2'] = "Menunggu Pembayaran";
	    	}else if($status2 == "*^56t38H53gbb^%$0-_-"){
	    		$data['status2'] = "Pembayaran Diterima";
	    	}else if($status2 == "Uywy%u3bShi)payDhal"){
	    		$data['status2'] = "Dalam Pengiriman";
	    	}else if($status2 == "ScUuses8625(62427^#&9531(73"){
	    		$data['status2'] = "Diterima";
	    	}else if($status2 == "batal"){ 
	    		$data['status2'] = "Dibatalkan";
	    	}
	    }

	    if($status == "semua"){
	    	$data['status1'] = "Semua";
	    	$status1 = array('bayar', 'belum');
	    }else{
	    	$status1 = $status;
	    	if($status == "bayar"){
	        	$data['status1'] = $status;
	        }else if($status == "belum"){
	        	$data['status1'] = $status;
	        } 
	    }

	    $jumlahtransfer = 0;
	    if($sortby == "tgl_order"){
			$data['hasil'] = $this->order_adm->get_data_konfirm_by_order($tgl1, $tgl2, $status1, $status2, $market);
        	$data['sort_by'] = "tgl_order";

        	$jmlh = $this->order_adm->get_data_konfirm_by_order($tgl1, $tgl2, $status1, $status2, $market);
			foreach($jmlh as $h){
				$jumlahtransfer += $h->total_belanja;
			}
			$data['jumlahtransfer'] = $jumlahtransfer;

        }else{
        	$data['hasil'] = $this->order_adm->get_data_konfirm_by_order_finish($tgl1, $tgl2, $status1, $status2, $market);
        	$data['sort_by'] = "tgl_selesai_order";

        	$jmlh = $this->order_adm->get_data_konfirm_by_order_finish($tgl1, $tgl2, $status1, $status2, $market);
			foreach($jmlh as $h){
				$jumlahtransfer += $h->total_belanja;
			}
			$data['jumlahtransfer'] = $jumlahtransfer;
        }

		// filter
		//$data['hasil'] = $this->order_adm->get_data_konfirm_by_order($tgl1, $tgl2, $status1, $status2, $market);
		$this->load->view('manage/sales/order/cetak_laporan_konfirmasi_pembayaran', $data);
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Mencetak Laporan konfirmasi pembayaran  '.$tgl1.' - '.$tgl2.' Marketplace '.$market_title.' Status Bayar '.$status.' Status Pesanan '.$data['status2'].' ');
	}

	function hapus_konfirmasi(){ // hapus 
		$id = $this->input->get('id');
		$target = $this->input->get('name');

		$idf = base64_decode($id);
		$idp = $this->encrypt->decode($idf);
		// hapus bukti transfer supaya tidak memenuhi database 
		$foto = $this->db->get_where('bukti_transfer',array('identity_bukti'=>$idp));

		//print_r($foto->num_rows());
		if($foto->num_rows()>0){
			$hasil 		= $foto->row();
			$nama_foto	= $hasil->gambar;

			$srcx = str_replace(''.base_url('assets/images/konfirmasi_pesanan/').'','', $nama_foto);
			$file = FCPATH.'assets/images/konfirmasi_pesanan/'.$srcx.'';
			//if(file_exists($file = FCPATH.'/assets/images/konfirmasi_pesanan/'.$nama_foto)){
				unlink($file);
				//print_r($file);
			//}
			$this->db->delete('bukti_transfer',array('identity_bukti'=>$idp));
		}

		$this->order_adm->hapus_konfirmasi($id);
		echo json_encode(array("status" => TRUE));
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus konfirmasi pembayaran e no. transaksi ('.$target.')');
	}

}