<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Online_store extends CI_Controller { 

	function __construct(){
		parent:: __construct(); 
		$this->load->library('encrypt');
		$this->load->model(array('sec47logaccess/onlinestore_adm','sec47logaccess/rpp_rpk_adm'));
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}    
 
	function index(){
		$this->data['get_akun'] = $this->onlinestore_adm->get_akun_all();
		$this->data['market'] = $this->onlinestore_adm->get_marketplace();
 
		$this->load->view('manage/header');
		$this->load->view('manage/online_store/index', $this->data);	
		$this->load->view('manage/footer');
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Online Store');
	}

	function uploadlabelpengiriman(){
		//$idk = $this->input->post('identitas'); 

		$config['upload_path']   = FCPATH.'/assets/images/labelpengiriman/';
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['encrypt_name']  = TRUE;
        $config['overwrite']     = FALSE;
        $this->upload->initialize($config);
 
        if($this->upload->do_upload('filelist')){
        	$inv  = $this->input->post('identitas');
        	$token  = $this->input->post('token');
        	$nama 	= base_url('assets/images/labelpengiriman/'.$this->upload->data('file_name').'');
        	$this->db->where('invoice', $inv);
        	$this->db->update('order_customer',array('tokenlabel'=>$token, 'labelpengiriman'=>$nama));      
        	log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Upload Label pengiriman dari marketplace '.$nama.' untuk invoice '.$inv.' ');  	
        }
	}

	function hapuslabelpengiriman(){
		$token = $this->input->post('token');
		// get src
		//$src = $this->produk_adm->get_src($token);
		$foto = $this->db->get_where('order_customer',array('tokenlabel'=>$token));

		//print_r($foto->num_rows());
		if($foto->num_rows()>0){
			$hasil 		= $foto->row();
			$nama_foto	= $hasil->labelpengiriman;

			$srcx = str_replace(''.base_url('assets/images/labelpengiriman/').'','', $nama_foto);
			$file = FCPATH.'assets/images/labelpengiriman/'.$srcx.'';
			//if(file_exists($file = FCPATH.'/assets/images/konfirmasi_pesanan/'.$nama_foto)){
				unlink($file);
				//print_r($file);
			//}
			echo $srcx;
			$this->db->where('tokenlabel',$token);
			$this->db->update('order_customer',array('tokenlabel'=>'', 'labelpengiriman'=> ''));
		}
		echo json_encode(array("status" => TRUE));
	}

	function load_all_serverside(){
		$list_data = $this->onlinestore_adm->get_datatables();
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
            	$buy = "<img src='".base_url('assets/images/logostsrs1.png')."' <i style='color:red'>".$x->nama_toko."</i>".$x->nama_toko."</i>";
            }else if($x->buy_in == "shopee"){
               	$buy = "<img src='".base_url('assets/images/marketplace/shopee_logo.png')."' style='width:25px;height:auto;'><br><i style='font-size:10px;'>Dikirim Oleh : <br><i style='color:red'>".$x->nama_toko."</i></i>";
            }else if($x->buy_in == "tokopedia"){
               	$buy = "<img src='".base_url('assets/images/marketplace/tokopedia_logo.png')."' style='width:25px;height:auto;'><br><i style='font-size:10px;'>Dikirim Oleh : <br><i style='color:red'>".$x->nama_toko."</i></i>";
            }else if($x->buy_in == "bukalapak"){
               	$buy = "<img src='".base_url('assets/images/marketplace/bukalapak_logo.png')."' style='width:25px;height:auto;'><br><i style='font-size:10px;'>Dikirim Oleh : <br><i style='color:red'>".$x->nama_toko."</i></i>";
            }else if($x->buy_in == "lazada"){
               	$buy = "<img src='".base_url('assets/images/marketplace/lazada_logo.png')."' style='width:25px;height:auto;'><br><i style='font-size:10px;'>Dikirim Oleh : <br><i style='color:red'>".$x->nama_toko."</i></i>";
            }else if($x->buy_in == "instagram"){
               	$buy = "<img src='".base_url('assets/images/ic_email/icon-instagram.png')."' style='width:25px;height:auto;'><br><i style='font-size:10px;'>Dikirim Oleh : <br><i style='color:red'>".$x->nama_toko."</i></i>";
            }else if($x->buy_in == "whatsapp_marketing"){ 
            	$buy = "<img src='".base_url('assets/images/ic_email/whatsapp.png')."' style='width:25px;height:auto;'><br><i style='font-size:10px;'>Dikirim Oleh : <br><i style='color:red'>".$x->nama_toko."</i></i>";
            }else if($x->buy_in == "zilinggo"){
            	$buy = "<img src='".base_url('assets/images/marketplace/zilinggo.png')."' style='width:25px;height:auto;'><br><i style='font-size:10px;'>Dikirim Oleh : <br><i style='color:red'>".$x->nama_toko."</i></i>";
            }else if($x->buy_in == "blibli"){
            	$buy = "<img src='".base_url('assets/images/marketplace/blibli.png')."' style='width:50px;height:auto;'><br><i style='font-size:10px;'>Dikirim Oleh : <br><i style='color:red'>".$x->nama_toko."</i></i>";
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
	            "<select name='stat_change' class='form-control stat_change' onchange='selectStatusmarket(this);' style='margin-bottom:10px'>
	              <option selected value='".$idp.",menunggu'>Menunggu Pembayaran</option>
	              <option value='".$idp.",dibayar'>Pembayaran Diterima</option>
	              <option value='".$idp.",pengiriman'>Dalam Pengiriman</option>
	              <option value='".$idp.",diterima'>Diterima</option>
	              <option value='".$idp.",dibatalkan'>Dibatalkan</option>
	            </select>";
	        }else if($x->status == "*^56t38H53gbb^%$0-_-"){
	        	$storder =
	        	"<select name='stat_change' class='form-control stat_change' onchange='selectStatusmarket(this);' style='margin-bottom:10px'>
	              <option value='".$idp.",menunggu'>Menunggu Pembayaran</option>
	              <option selected value='".$idp.",dibayar'>Pembayaran Diterima</option>
	              <option value='".$idp.",pengiriman'>Dalam Pengiriman</option>
	              <option value='".$idp.",diterima'>Diterima</option>
	              <option value='".$idp.",dibatalkan'>Dibatalkan</option>
	            </select>";
	        }else if($x->status == "Uywy%u3bShi)payDhal"){
	        	$storder =
	        	"<select name='stat_change' class='form-control stat_change' onchange='selectStatusmarket(this);' style='margin-bottom:10px'>
	              <option value='".$idp.",menunggu'>Menunggu Pembayaran</option>
	              <option value='".$idp.",dibayar'>Pembayaran Diterima</option>
	              <option selected value='".$idp.",pengiriman'>Dalam Pengiriman</option>
	              <option value='".$idp.",diterima'>Diterima</option>
	              <option value='".$idp.",dibatalkan'>Dibatalkan</option>
	            </select>";
	        }else if($x->status == "ScUuses8625(62427^#&9531(73"){
	        	$storder = 
	        	"<select name='stat_change' class='form-control stat_change' onchange='selectStatusmarket(this);' style='margin-bottom:10px'>
	              <option value='".$idp.",menunggu'>Menunggu Pembayaran</option>
	              <option value='".$idp.",dibayar'>Pembayaran Diterima</option>
	              <option value='".$idp.",pengiriman'>Dalam Pengiriman</option>
	              <option selected value='".$idp.",diterima'>Diterima</option>
	              <option value='".$idp.",dibatalkan'>Dibatalkan</option>
	            </select>";
	        }else if($x->status == "batal"){
	        	$storder =
	        	"<select name='stat_change' class='form-control stat_change' onchange='selectStatusmarket(this);' style='margin-bottom:10px'>
	              <option value='".$idp.",menunggu'>Menunggu Pembayaran</option>
	              <option value='".$idp.",dibayar'>Pembayaran Diterima</option>
	              <option value='".$idp.",pengiriman'>Dalam Pengiriman</option>
	              <option value='".$idp.",diterima'>Diterima</option>
	              <option selected value='".$idp.",dibatalkan'>Dibatalkan</option>
	            </select>";
	        }

	        if($x->dibayar == "belum" || $x->dibayar == ""){
            	$st_bayar = "<a title='Ubah Status Bayar' href='javascript:void(0)' class='btn btn-success' data-id='".$idp."' data-name='".$idp."' onclick='bayar_order_marketplace(this)'><i class='fa fa-money'></i></a>";
          	}else if($x->dibayar == "bayar"){
            	$st_bayar = "<a title='Ubah Status Belum Bayar' href='javascript:void(0)' class='btn btn-danger' data-id='".$idp."' data-name='".$idp."' onclick='cancel_bayar_order_marketplace(this)'><i class='fa fa-money'></i></a>";
          	}

	        $opsi = "
		        <ul class='list-inline opsi' style='margin-bottom: 0;'>
		            <li>
		              <a title='Detail Invoice' class='btn btn-default' href='".base_url('trueaccon2194/online_store/detail/'.$idp.'')."' class='edit'><i class='glyphicon glyphicon-eye-open'></i></a>
		            </li>
		            <li>
		              <a title='Edit Invoice' href='".base_url('trueaccon2194/online_store/edit/'.$idp.'')."' class='btn btn-warning'><i class='glyphicon glyphicon-pencil'></i></a> 
		            </li>
		            <li>
		              <a title='Hapus Invoice' href='javascript:void(0)' class='btn btn-danger hapus' data-id='".$idp."' data-name='".$x->invoice."' onclick='hapus_order_marketplace(this)'><i class='glyphicon glyphicon-trash'></i></a> 
		            </li>
		            <li>
		              ".$st_bayar."
		            </li>
		        </ul>
	        ";

	        if($x->tanggal_order_finish == "" || $x->tanggal_order_finish == "0000-00-00"){
	        	$tgl_order_finish = "-";
	        }else{
	        	$tgl_order_finish = date('d F Y', strtotime($x->tanggal_order_finish));
	        }

	        if($x->invoice == $x->id_pesanan){
            	$status_bukti = "<div style='margin-top:10px;'><label class='label label-success'>Bukti : Ada</label></div>";
            }else{
            	$status_bukti = "<div style='margin-top:10px;'><label class='label label-danger'>Bukti : Belum</label></div>";
            }

            $idinvoice = $x->invoice;
		    $get_inv = $this->onlinestore_adm->get_inv_inout($idinvoice);
		    $invxx = $get_inv['id_inout'];

          	// ROW START
          	$row[] = "<input type='checkbox' class='form-control' name='checkorder[]' value='".$x->no_order_cus."'/>";
          	$row[] = $x->invoice."<br><span style='font-size: 12px;'>No resi : <i style='color:red'>".$x->no_resi."</i></span><br><span style='font-size: 12px;'>No. Pemindahan POS : <i style='color:red'>".$invxx."</i></span>";
          	$row[] = "<center><a href='javscript:void(0);' onclick='uploadlabel(".$x->id.");'>".$buy."</a></center>";
          	$row[] = date('d F Y', strtotime($x->tanggal_order));
          	$row[] = $tgl_order_finish;
          	$row[] = $x->nama_lengkap;
          	$row[] = "Rp. ".number_format($x->total_belanja,0,".",".");
          	//$row[] = $x->jenis_pembayaran;
          	$row[] = $status."<br>".$stat_bayar;
          	$row[] = $storder."<br>".$opsi;

          	// ROW end(array)
        $data[] = $row;
    	}

    	$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onlinestore_adm->count_all(),
            "recordsFiltered" => $this->onlinestore_adm->count_filtered(),
            "data" => $data,
        );
		echo json_encode($output);
	}

	function tambah_akun(){
		$target = $this->input->post('nama_akun');
		if($this->input->post()){
			$data_filtering = $this->security->xss_clean($this->input->post());
			$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
			$this->onlinestore_adm->add($data);
			log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Tambah Akun ('.$target.')');
		}else{
			log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Tambah Akun ('.$target.')');
		}
		redirect(base_url('trueaccon2194/online_store'));
	}

	function tambah_market(){
		$target = $this->input->post('marketplace');
		if($this->input->post()){
			$data_filtering = $this->security->xss_clean($this->input->post());
			$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
			$id = $this->data['id'];
			$this->onlinestore_adm->add_market($data, $id);
			log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Marketplace ('.$target.')');
		}else{
			log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Gagal menambah marketplace ('.$target.')');
		}
		redirect(base_url('trueaccon2194/online_store'));
	}

	function hapus_market($id){
		$id = $this->input->get('id');
		$target = $this->input->get('name');

		$this->onlinestore_adm->hapus_market($id);
		echo json_encode(array("status" => TRUE));
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus order marketplace no. transaksi ('.$target.')');
	}

	function edit_akun($id){ 
		$update = $this->onlinestore_adm->get_data_akun($id);
		$this->data['updatedata'] = $update;
		$this->load->view('manage/header');
		$this->load->view('manage/online_store/edit_akun',$this->data);
		$this->load->view('manage/footer');
	}

	function update_akun(){
		$id = $this->input->post('dti');
		$target = $this->input->post('nama');
		$p1 = $this->security->xss_clean($this->input->post('pass1'));
		$p2 = $this->security->xss_clean($this->input->post('pass2'));

		if($p1 != $p2){
			$this->session->set_flashdata('error', 'Password tidak sama, silahkan ulangi kembali.');
			redirect($this->agent->referrer());
		}else{
			if($this->input->post()){
					$data_filtering = $this->security->xss_clean($this->input->post());
	        		$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
					$this->onlinestore_adm->update_akun($data,$id);
					log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Update akun ('.$target.')');
					$this->session->set_flashdata('success', 'Akun '.$target.' telah diubah.');
					redirect('trueaccon2194/online_store');
			}
		}
	}

	function hapus(){ // hapus 
		$id = $this->input->get('id');
		$target = $this->input->get('name');

		$this->onlinestore_adm->hapus($id);
		echo json_encode(array("status" => TRUE));
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus order marketplace no. transaksi ('.$target.')');
	}

	function bayar(){ // bayar
		$id = $this->input->get('id');
		$target = $this->input->get('name');
		$this->onlinestore_adm->bayar($id);
		echo json_encode(array("status" => TRUE));
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Mengubah status bayar pada order marketplace no. transaksi ('.$target.')');
	}

	function belum_bayar(){ // bayar
		$id = $this->input->get('id');
		$target = $this->input->get('name');
		$this->onlinestore_adm->belum_bayar($id);
		echo json_encode(array("status" => TRUE));
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Mengubah status belum bayar pada order marketplace no. transaksi ('.$target.')');
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
		$this->merk_adm->remove_selected();
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Hapus Merk');
		redirect('trueaccon2194/merk');
	}

	function detail($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$data['detailorder'] = $this->onlinestore_adm->checkingInv($id);
		$data['produk'] = $this->onlinestore_adm->checkingdataorder($id);
		$data['tokopengirim']	= $this->onlinestore_adm->get_data_tokopengirim($id);

		$this->load->view('manage/header');
		$this->load->view('manage/online_store/detail',$data);
		$this->load->view('manage/footer');
	}

	function cetak_invoice($id){
		//$this->load->library('dompdf_gen');
		$ins = base64_decode($id);
		$b = $this->encrypt->decode($ins);

		//get data invoice
		$gdata = $this->onlinestore_adm->checkingInv($id);
		foreach($gdata as $y){
			$inv = $y->invoice;
			$by = $y->buy_in;
		}
		//get order berdasarkan invoice
		$data['qrinvoice'] = $inv;
		$data['detailorder'] = $gdata;
		$data['produk'] = $this->onlinestore_adm->checkingdataorder($id);
		$data['title'] = 'Cetak Invoice '.$inv.''; //judul title
 		//send data[''] to view
        $this->load->view('laporan_pdf/lap_inv_order_marketplace_backend_default(1)', $data);
        //$paper_size  = 'A4'; //paper size
        //$orientation = 'potrait'; //tipe format kertas
        //$html = $this->output->get_output();
 
        //$this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        //$this->dompdf->set_base_path('qusour894/css');
        //$this->dompdf->load_html($html);
        //$this->dompdf->render();
        
       // $this->dompdf->set_base_path($css);
        //$this->dompdf->stream("Laporan_penjualan_marketplace_".$inv.".pdf", array('Attachment'=>0));
        //exit(0);
	}

	function cetak_stiker($id){
		$this->load->library('dompdf_gen');
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

	function input_manual_order(){
		$this->load->model('sec47logaccess/produk_adm');
		$this->data['get_sizex'] = $this->produk_adm->get_size();
		$this->data['get_colorx'] = $this->produk_adm->get_color();
		$this->data['market'] = $this->onlinestore_adm->get_marketplace();

		$this->load->view('manage/header');
		$this->load->view('manage/online_store/input_manual', $this->data);	
		$this->load->view('manage/footer');
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Input Manual Order');
	}

	function edit($id){
		$this->load->model('sec47logaccess/produk_adm');
		$this->data['d'] 				= $this->onlinestore_adm->detail($id);
		$this->data['produk'] 			= $this->onlinestore_adm->detail_produk($id);
		$this->data['market'] 			= $this->onlinestore_adm->get_marketplace();
		$this->data['get_data_sizex_all'] 	= $this->produk_adm->get_data_size_all();
		$this->data['get_data_colorx_all'] 	= $this->produk_adm->get_data_color_all();
		$this->data['get_sizex'] 		= $this->produk_adm->get_size();
		$this->data['get_colorx'] 		= $this->produk_adm->get_color();
		$this->load->view('manage/header');
		$this->load->view('manage/online_store/edit', $this->data);	
		$this->load->view('manage/footer');
	}
 
	function list_order_marketplace(){
		$this->data['get_ol'] = $this->onlinestore_adm->get_marketplace();
		$this->data['store_list'] = $this->onlinestore_adm->get_toko();
		$this->load->view('manage/header');
		$this->load->view('manage/online_store/list_order', $this->data);	
		$this->load->view('manage/footer');
		log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Daftar Order Market place');
	}

	function tambah_manual_order(){
		$invoice = $this->security->xss_clean($this->input->post('invoice'));
		$inv = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$invoice);

		if($this->input->post()){
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
  
			$id_user = $this->data['id'];

			$countArt = array_filter($_POST['artikel']);
			$c = count($countArt);
			for($i=0;$i<$c;$i++){

				$sz = $_POST['size'][$i];
				$sizexx = explode(',',$sz);
				$idsizex 	= $sizexx[0];
				$sizex 		= $sizexx[1];

				//print_r($idsize);

				//mencari ID dari variable artikel
				$dataPro = array(
					'artikel' => $_POST['artikel'][$i],
				);
				$h = $this->onlinestore_adm->get_id_from_art($dataPro);	
				foreach($h as $e){
					$data_w = array(
						'id_produk_optional' => $e->id_produk,
						'id_opsi_get_size' 	 => $idsizex,
					);

					// pada pengurangan manual order acuan hanya ID dan SIZE (WARNA tidak karena beda warna pasti beda artikel)
		            $get_data_pro_id = $this->onlinestore_adm->get_id_data($data_w);
		            
		            foreach($get_data_pro_id as $gy){
		            	//kurangi stok berdasarkan 1 warna dan size, meski size berbeda, dan id produk sama dapat dibedakan dan dikurangi karena memakai where yang tepat ().
		            	$data_stok_pro = array(
			                'id_produk_optional'=> $gy->id_produk_optional,
			                'id_opsi_get_size' 	=> $gy->id_opsi_get_size,
			                'stok'  			=> $gy->stok - $_POST['qty'][$i],
		            	);

		            		$id_pr 		= $gy->id_produk_optional;
			                $idsize 	= $gy->id_opsi_get_size;
		            	// mulai pengurangan stok disini
		            	$this->onlinestore_adm->kurangi_stok($data_stok_pro, $id_pr, $idsize);
		            }
				}
			}
	            
			$this->onlinestore_adm->addmanualorder($id_user, $data); 
			log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Manual Order '.$inv.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> No. Transaksi '.$inv.' ditambahkan!');
			redirect('trueaccon2194/online_store/list_order_marketplace/');
		}else{
			log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah manual order ');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
		}
	}

	function update_manual_order(){
		$invoice1 = $this->security->xss_clean($this->input->post('invoice1'));
		$invoice = str_replace("/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$invoice1);

		if($this->input->post()){
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
 
			$id_user = $this->data['id'];

			$countArt = array_filter($_POST['artikel']);
			$c = count($countArt);
			for($i=0;$i<$c;$i++){

				$sz = $_POST['size'][$i];
				$sizexx = explode(',',$sz);
				$idsizex 	= $sizexx[0];
				$sizex 		= $sizexx[1];

				//print_r($idsize);

				//mencari ID dari variable artikel
				$dataPro = array(
					'artikel' => $_POST['artikel'][$i],
				);
				//$h = $this->onlinestore_adm->get_id_from_art($dataPro);	
				//foreach($h as $e){
				//	$data_w = array(
				//		'id_produk_optional' => $e->id_produk,
				//		'id_opsi_get_size' 	 => $idsizex,
				//	);
				//}

				// pada pengurangan manual order acuan hanya ID dan SIZE (WARNA tidak karena beda warna pasti beda artikel)
	            //$get_data_pro_id = $this->onlinestore_adm->get_id_data($data_w);
	            
	            //foreach($get_data_pro_id as $gy){
	            	//kurangi stok berdasarkan 1 warna dan size, meski size berbeda, dan id produk sama dapat dibedakan dan dikurangi karena memakai where yang tepat ().
	            //	$data_stok_pro = array(
		        //        'id_produk_optional'=> $gy->id_produk_optional,
		        //        'id_opsi_get_size' 	=> $gy->id_opsi_get_size,
		        //        'stok'  			=> $gy->stok - $_POST['qty'][$i],
	            //	);

	            //		$id_pr 		= $gy->id_produk_optional;
		        //        $idsize 	= $gy->id_opsi_get_size;
	            	// mulai pengurangan stok disini
	            	//$this->onlinestore_adm->kurangi_stok($data_stok_pro, $id_pr, $idsize);
	            //}
			}

			$inv = $data['invoice'];

			$this->onlinestore_adm->updatemanualorder($id_user, $data, $invoice); 
			//log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Manual Order No. Transaksi '.$inv.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> No. Transaksi '.$inv.' telah diubah!');

			if($data['ecommerce'] == "E-commerce"){
				redirect('trueaccon2194/order/');
			}else{
				redirect('trueaccon2194/online_store/list_order_marketplace/');
			}
			
		}else{
			log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Mengedit manual order ');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
		}
	}

	function ambil_data_order($id){
		$a = $this->encrypt->encode($id); 
	    $b = base64_encode($a);	
	    $get = $this->onlinestore_adm->get_data_order($b);
	    $get['label'] = "Label Pengiriman :<br><a target='_new' style='font-size: 10px;' href='".$get['labelpengiriman']."'>Download Label Pengiriman</a>";
	    //$sess_data['sku_produk'] = $get['sku_produk'];
	    //$this->session->set_userdata($sess_data);
	    echo json_encode($get);
	}

	function update_status_order_massal(){
		$idorder 	= $this->security->xss_clean($this->input->post('checkorder'));
        $tgl_selesai 	= $this->security->xss_clean($this->input->post('tgl_selesai'));
        $status 	= $this->security->xss_clean($this->input->post('status'));
        $dibayar 	= $this->security->xss_clean($this->input->post('dibayar'));

        $checkbox = $idorder;         
        for($i=0;$i<count($checkbox);$i++){
	        $check_id = $checkbox[$i];
	        $data_update = array(
	        	'no_order_cus'					=> $idorder[$i],
	        	'status'						=> $status,
	        	'dibayar'						=> $dibayar,
	        	'tanggal_order_finish'			=> $tgl_selesai,
	        	'tanggal_waktu_order_finish'	=> $tgl_selesai,
	        );
	        $this->db->where('no_order_cus',$idorder[$i]);
	        $this->db->update('order_customer',$data_update);
	    }
	}
	function laporan_ist_toko(){
		$tgl1_filtering = $this->security->xss_clean($this->input->post('tgl1'));
        $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1_filtering);

        $this->data['tgl1'] = $tgl1;

        $tgl2_filtering = $this->security->xss_clean($this->input->post('tgl2'));
        $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2_filtering);

        $this->data['tgl2'] = $tgl2;

        $market_filtering = $this->security->xss_clean($this->input->post('buy_in'));
        $market1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$market_filtering);

        $status_filtering = $this->security->xss_clean($this->input->post('dibayar'));
        $status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$status_filtering);

        $status22_filtering = $this->security->xss_clean($this->input->post('status'));
        $status22 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$status22_filtering);
 
        $sortby2_filtering = $this->security->xss_clean($this->input->post('sortby'));
        $sortby = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$sortby2_filtering);

        $sender_filtering = $this->security->xss_clean($this->input->post('sender'));
        $sender = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$sender_filtering);

        $list_market = $this->onlinestore_adm->get_marketplace();
        foreach($list_market as $hx){
        	// load data marketplace
        	$mrx[] = $hx->val_market;
        }

        if($market1 == ""){
    		$market = $mrx; //array('E-commerce','tokopedia','bukalapak','shopee','lazada','blanja','jd_id','blibli','zalora');
    		$market_title = "Semua Marketplace";
        }else{
        	$market = $market1;
        	$market_title = $market1;
        }
        $this->data['market'] = $market_title;

        if($status22 == "all"){

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

         if($status == ""){
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

        if($sender == ""){
        	$this->data['nama_toko'] = "";
        	$this->data['sender'] = "Semua Toko";
        	$senderx = "";
        }else{
        	$this->data['nama_toko'] = $this->onlinestore_adm->get_nama_toko($sender);
        	$this->data['sender'] = $sender;
        	$senderx = $sender;
        }

        // inialisasi laporan 
        $this->data['inialisasi'] = "online_store";

        //echo $tgl1." - ".$tgl2." - ".$sortby." - ".$sender."<br>";
        //print_r($market)."<br>";
        //print_r($status1)."<br>";
        //print_r($status2)."<br>";

    	// Komisi Toko berdasarkan toko (data penjualan by toko untuk dijadikan laporan IST toko)
    	if($sortby == "tgl_order"){
        	$this->data['getStore'] = $this->onlinestore_adm->get_store_for_comission_tgl_order_persender($tgl1, $tgl2, $status1, $status2, $market, $senderx);
        	$this->data['terjual_by'] = "tgl_order";
        }else{
        	$this->data['getStore'] = $this->onlinestore_adm->get_store_for_comission_persender($tgl1, $tgl2, $status1, $status2, $market, $senderx);
        	$this->data['terjual_by'] = "tgl_selesai_order";
        }
		$this->load->view('manage/online_store/laporan_ist_toko_online_store', $this->data);


	}
}