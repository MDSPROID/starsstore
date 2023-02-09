<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info_type_user_log extends CI_Controller {

	protected $key = 'MSY374BDND9NSFSV21N336DMVC06862N';
	protected $iv =  'MBX5294N4MXB27452NG102ND63BN5241';
 
	function __construct(){
		parent::__construct();
		$this->load->library('user_agent','encryption');
		$this->load->model('sec47logaccess/model_admst');		
	}

	function index(){ 

		if($this->session->userdata('log_access') != "TRUE_OK_1"){ 
			redirect(base_url());
		}else{
		       
			// traffic
			$data['android'] = 0;//$this->model_admst->android();
			$data['ios'] = 0;//$this->model_admst->ios();
			$data['win10'] = 0;//$this->model_admst->win10();
			$data['other'] = 0;//$this->model_admst->other();
			$data['bdm'] = $this->model_admst->list_bdm();
			$data['toko_stars'] = $this->model_admst->c_all_toko_on();
			$data['penjualan_by_sosmed_dan_mp'] = $this->model_admst->penj_by_sosmed_dan_mp();
			$data['penjualan_by_sosmed_dan_mp_price_calc'] = $this->model_admst->penj_by_sosmed_dan_mp_price_calc();
			$data['penjualan_by_sosmed_dan_mp_all'] = $this->model_admst->penj_by_sosmed_dan_mp_all();
			$data['penjualan_by_sosmed_dan_mp_all_price_calc'] = $this->model_admst->penj_by_sosmed_dan_mp_all_price_calc();
			//bmkg 
			//$bmkg = $this->weathers_currency->databmkg();
			//if($bmkg === "" || $bmkg === null){
			//	$bmkgx = "<p class='text-center'>Gagal memuat data cuaca bmkg<br><b>refresh halaman (F5)</b></p>";
			//}else{
			//	$bmkgx = $this->weathers_currency->databmkg();
			//}
			//gempa
			//$gempa = $this->weathers_currency->gempa();
			//if($gempa === "" || $gempa === null){
			//	$gempax = "<p class='text-center'>Gagal memuat data gempa bmkg<br><b>refresh halaman (F5)</b></p>";
			//}else{
			//	$gempax = $this->weathers_currency->gempa();
			//}
			//$data['bmkg'] = $bmkgx;
			//$data['gempa'] = $gempax;
			// report
			$this->load->model('sec47logaccess/setting_adm'); 
			$get_month_number = date('m');
			$get_years = date('Y');

			$data['month'] = $this->setting_adm->get_report_by_this_month($get_month_number,$get_years);
			$data['week'] = $this->setting_adm->get_report_by_this_week();
			$data['today'] = $this->setting_adm->get_report_by_this_today_dan_kemarin();
			$data['detail'] = $this->setting_adm->get_report_detail_by_this_today_dan_kemarin();
			// end report
			$data['count_user'] 		= $this->model_admst->c_user();
			$data['count_product_view'] = $this->model_admst->c_product_view();
			$data['total_order'] 		= $this->model_admst->c_product_order();
			$data['total_pesanan']		= $this->model_admst->c_product_total_order();
			$data['mail_send'] 			= $this->model_admst->c_mail_send();
			$data['produk_paling_laris'] = $this->model_admst->produk_laris();
			$data['penjualan'] 			= $this->model_admst->penjualan_by_month();
			//$data['progress_order']		= $this->model_admst->progress_order();
			$this->load->view('manage/header');
			$this->load->view('manage/home',$data);
			$this->load->view('manage/footer');
		}
		log_helper("dashboard", "akses halaman dashboard");
	}

	function load_store(){
		$list_data = $this->model_admst->get_datatables();
		//$dx = json_encode($list_data, true);
		$data = array();
		$no = $_POST['start'];
		foreach($list_data as $x){
			$no++;
			$row = array();

    		// STATUS LABEL
	      	if($x->toko_aktif == "on"){
	        	$stx = "<label style='font-size:10px;' class='label label-success'>ON</label>";
	      	}else{
		        $stx = "<label style='font-size:10px;display: inline-block;' class='label label-danger'>OFF</label>";
	      	}
	      	// END STATUS LABEL

	      	if($x->wa_toko == "-" || $x->wa_toko == ""){
				$wa_toko = "-";
			}else{
				$x1 = substr($x->wa_toko,0,1);
				$x2 = str_replace("0", "62",$x1);
				$x3 = substr($x->wa_toko, 1);
				$wa_toko = $x2.$x3; 
			}

	      	$area = "<label style='font-size:10px;display: inline-block;' class='label label-default'>".$x->area."</label>";
	      	$nama_bdm = "<label style='font-size:10px;display: inline-block;' class='label label-default'>BDM : <a target='_new' href='tel:".$x->telp."'>".$x->nama_bdm." <i class='glyphicon glyphicon-phone'></i></a></label>";
	      	$wa = "<label style='font-size:10px;margin-right:5px;display: inline-block;' class='label label-primary'>WA : <a style='color:white;' target='_new' href='https://wa.me/".$wa_toko."'>".$x->wa_toko."</a></label>";
	      	$telp_toko = "<label style='font-size:10px;display: inline-block;' class='label label-primary'>Telp : <a target='_new' style='color:white;' href='tel:".$x->spv_nomor."'>".$x->spv_nomor."</a></label>";
	      	$lat = "<label style='font-size:10px;margin-right:5px;display: inline-block;' class='label label-primary'>Lat : ".$x->latitude."</label>";
	      	$lon = "<label style='font-size:10px;margin-right:5px;display: inline-block;' class='label label-primary'>Lon : ".$x->longitude."</label>";

      		$id = $x->id_toko; 
      		$idx = base64_encode($id);
			$row[] = "".$x->nama_toko."<br><span style='font-size:10px;'>".$x->alamat."</span><br><br>".$wa." ".$telp_toko." ".$lat." ".$lon." <br>".$stx." ".$area." ".$nama_bdm."";
			//$row[] = "<a href='".base_url('trueaccon2194/produk/edit_data/'.$idx.'')."'>".$x->nama_toko."</a>";

			if($x->toko_aktif == "on"){
	          $status = "<a style='padding:3px 8px;' href='javascript:void(0);' onclick='off_toko(this);' data-id='".$x->id_toko."' data-name='".$x->nama_toko."' class='btn btn-danger edit'>OFF</a>";
	        }else{
	          $status = "<a style='padding:3px 8px;' href='javascript:void(0);' onclick='on_toko(this);' data-id='".$x->id_toko."' data-name='".$x->nama_toko."' class='btn btn-success edit'>ON</a>";
	        }          
	        
	        // edit
	        $edit = "<a target='_new' href='".base_url('trueaccon2194/info_type_user_log/edit_toko/'.$x->id_toko.'')."' class='pull-right btn btn-warning edit'><i class='glyphicon glyphicon-pencil'></i></a>";
	        // remove
	        $remove = "<a href='javascript:void(0)'' class='pull-right btn btn-danger hapus' data-id='".$x->id_toko."' data-name='".$x->nama_toko."' onclick='hapus_toko(this);'><i class='glyphicon glyphicon-remove'></i></a>";
	        
	        $row[] = '<div class="text-center">'.$edit.'<br>'.$remove.'<br>'.$status.'</div>';

			$data[] = $row;
		}

		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_admst->count_all(),
            "recordsFiltered" => $this->model_admst->count_filtered(),
            "data" => $data,
        );
		echo json_encode($output);
	}

	function tambah_toko(){
		$nama1 = $this->security->xss_clean($this->input->post('nama'));
		$nama2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nama1);
		$nama3 = strip_tags($nama2);
		$nama = htmlentities($nama3);	 

		$alamat1 = $this->security->xss_clean($this->input->post('alamat'));
		$alamat2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$alamat1);
		$alamat3 = strip_tags($alamat2);
		$alamat = htmlentities($alamat3);	 

		$bdm1 = $this->security->xss_clean($this->input->post('bdm'));
		$bdm2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$bdm1);
		$bdm3 = strip_tags($bdm2);
		$bdm = htmlentities($bdm3);	 

		$sms1 = $this->security->xss_clean($this->input->post('sms'));
		$sms2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$sms1);
		$sms3 = strip_tags($sms2);
		$sms = htmlentities($sms3);	 

		$edp1 = $this->security->xss_clean($this->input->post('edp'));
		$edp2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$edp1);
		$edp3 = strip_tags($edp2);
		$edp = htmlentities($edp3);	 

		$spv1 = $this->security->xss_clean($this->input->post('spv'));
		$spv2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$spv1);
		$spv3 = strip_tags($spv2);
		$spv = htmlentities($spv3);	 

		$ass1 = $this->security->xss_clean($this->input->post('ass'));
		$ass2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$ass1);
		$ass3 = strip_tags($ass2);
		$ass = htmlentities($ass3);	 

		$wa1 = $this->security->xss_clean($this->input->post('wa'));
		$wa2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$wa1);
		$wa3 = strip_tags($wa2);
		$wa = htmlentities($wa3);	 

		$no_spv1 = $this->security->xss_clean($this->input->post('no_spv'));
		$no_spv2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$no_spv1);
		$no_spv3 = strip_tags($no_spv2);
		$no_spv = htmlentities($no_spv3);	 

		$no_ass1 = $this->security->xss_clean($this->input->post('no_ass'));
		$no_ass2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$no_ass1);
		$no_ass3 = strip_tags($no_ass2);
		$no_ass = htmlentities($no_ass3);	 

		$lat1 = $this->security->xss_clean($this->input->post('lat'));
		$lat2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$lat1);
		$lat3 = strip_tags($lat2);
		$lat = htmlentities($lat3);	 

		$lon1 = $this->security->xss_clean($this->input->post('lon'));
		$lon2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$lon1);
		$lon3 = strip_tags($lon2);
		$lon = htmlentities($lon3);	 

		$data_toko = array(
			'id_bdm'	=> $bdm,
			'nama_toko'	=> $nama,
			'alamat'	=> $alamat,
			'kode_sms'	=> $sms,
			'kode_edp'	=> $edp,
			'spv'		=> $spv,
			'ass'		=> $ass,
			'wa_toko'	=> $wa,
			'spv_nomor'	=> $no_spv,
			'ass_nomor'	=> $no_ass,
			'latitude'	=> $lat,
			'longitude'	=> $lon,
			'toko_aktif'=> 'on',
		);

		$this->model_admst->simpanToko($data_toko);
		log_helper("login","Tambah toko ".$nama."");
		echo true;
	}

	function tambah_bdm(){
		$nama1 = $this->security->xss_clean($this->input->post('nama'));
		$nama2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nama1);
		$nama3 = strip_tags($nama2); 
		$nama = htmlentities($nama3);	 

		$alamat1 = $this->security->xss_clean($this->input->post('area'));
		$alamat2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$alamat1);
		$alamat3 = strip_tags($alamat2);
		$alamat = htmlentities($alamat3);	 

		$bdm1 = $this->security->xss_clean($this->input->post('telp'));
		$bdm2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$bdm1);
		$bdm3 = strip_tags($bdm2);
		$bdm = htmlentities($bdm3);	 

		$data_bdm = array(
			'area'		=> $alamat,
			'nama_bdm'	=> strtoupper($nama),
			'telp'		=> $bdm,
			'status_bdm'=> 'on',
		);

		$this->model_admst->simpanBDM($data_bdm);
		log_helper("login","Tambah BDM ".$nama."");
		echo true;
	}

	function update_bdm(){
		$id1 = $this->security->xss_clean($this->input->post('id'));
		$id2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$id1);
		$id3 = strip_tags($id2);
		$id = htmlentities($id3);	 

		$nama1 = $this->security->xss_clean($this->input->post('nama'));
		$nama2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nama1);
		$nama3 = strip_tags($nama2);
		$nama = htmlentities($nama3);	 

		$alamat1 = $this->security->xss_clean($this->input->post('area'));
		$alamat2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$alamat1);
		$alamat3 = strip_tags($alamat2);
		$alamat = htmlentities($alamat3);	 

		$bdm1 = $this->security->xss_clean($this->input->post('telp'));
		$bdm2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$bdm1);
		$bdm3 = strip_tags($bdm2);
		$bdm = htmlentities($bdm3);	 

		$data_bdm = array(
			'area'		=> $alamat,
			'nama_bdm'	=> strtoupper($nama),
			'telp'		=> $bdm,
			'status_bdm'=> 'on',
		);

		$this->model_admst->updateBDM($data_bdm, $id);
		echo "280";
		log_helper("login", "".$sess_data['username']." Update BDM ".$nama."");
	}

	function hapus_bdm(){
		$id = $this->input->get('id');
		$name = $this->input->get('name');
		$this->model_admst->hapus_bdm($id);
		log_helper("login", "".$sess_data['username']." Hapus BDM ".$name."");
	}

	function on_toko(){
		$id = $this->input->get('id');
		$name = $this->input->get('name');
		$this->model_admst->on_toko($id);
		log_helper("login", "".$sess_data['username']." mengaktifkan toko ".$name."");
	}

	function off_toko(){
		$id = $this->input->get('id');
		$name = $this->input->get('name');
		$this->model_admst->off_toko($id);
		log_helper("login", "".$sess_data['username']." menonaktifkan toko ".$name."");
	}

	function hapus_toko(){
		$id = $this->input->get('id');
		$name = $this->input->get('name');
		$this->model_admst->hapus_toko($id);
		log_helper("login", "".$sess_data['username']." Hapus toko ".$name."");
	}

	function ambil_data_bdm($id){
		$get = $this->model_admst->get_data_bdm($id);
		echo json_encode($get);
	}

	function edit_toko($id){
		$data['r'] = $this->model_admst->get_toko($id);
		$data['bdm'] = $this->model_admst->list_bdm();
		$this->load->view('manage/header');
		$this->load->view('manage/edit_toko',$data);
		$this->load->view('manage/footer');
	}

	function update_toko(){
		$nama1 = $this->security->xss_clean($this->input->post('nama'));
		$nama2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nama1);
		$nama3 = strip_tags($nama2);
		$nama = htmlentities($nama3);	 

		$alamat1 = $this->security->xss_clean($this->input->post('alamat'));
		$alamat2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$alamat1);
		$alamat3 = strip_tags($alamat2);
		$alamat = htmlentities($alamat3);	 

		$bdm1 = $this->security->xss_clean($this->input->post('bdm'));
		$bdm2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$bdm1);
		$bdm3 = strip_tags($bdm2);
		$bdm = htmlentities($bdm3);	 

		$sms1 = $this->security->xss_clean($this->input->post('sms'));
		$sms2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$sms1);
		$sms3 = strip_tags($sms2);
		$sms = htmlentities($sms3);	 

		$edp1 = $this->security->xss_clean($this->input->post('edp'));
		$edp2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$edp1);
		$edp3 = strip_tags($edp2);
		$edp = htmlentities($edp3);	 

		$spv1 = $this->security->xss_clean($this->input->post('spv'));
		$spv2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$spv1);
		$spv3 = strip_tags($spv2);
		$spv = htmlentities($spv3);	 

		$ass1 = $this->security->xss_clean($this->input->post('ass'));
		$ass2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$ass1);
		$ass3 = strip_tags($ass2);
		$ass = htmlentities($ass3);	 

		$wa1 = $this->security->xss_clean($this->input->post('wa'));
		$wa2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$wa1);
		$wa3 = strip_tags($wa2);
		$wa = htmlentities($wa3);	 

		$no_spv1 = $this->security->xss_clean($this->input->post('no_spv'));
		$no_spv2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$no_spv1);
		$no_spv3 = strip_tags($no_spv2);
		$no_spv = htmlentities($no_spv3);	 

		$no_ass1 = $this->security->xss_clean($this->input->post('no_ass'));
		$no_ass2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$no_ass1);
		$no_ass3 = strip_tags($no_ass2);
		$no_ass = htmlentities($no_ass3);	 

		$lat1 = $this->security->xss_clean($this->input->post('lat'));
		$lat2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$lat1);
		$lat3 = strip_tags($lat2);
		$lat = htmlentities($lat3);	 

		$lon1 = $this->security->xss_clean($this->input->post('lon'));
		$lon2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$lon1);
		$lon3 = strip_tags($lon2);
		$lon = htmlentities($lon3);	 

		$id = $this->security->xss_clean($this->input->post('id'));

		$data_toko = array(
			'id_bdm'	=> $bdm,
			'nama_toko'	=> $nama,
			'alamat'	=> $alamat,
			'kode_sms'	=> $sms,
			'kode_edp'	=> $edp,
			'spv'		=> $spv,
			'ass'		=> $ass,
			'wa_toko'	=> $wa,
			'spv_nomor'	=> $no_spv,
			'ass_nomor'	=> $no_ass,
			'latitude'	=> $lat,
			'longitude'	=> $lon,
		);

		$this->model_admst->updateToko($data_toko,$id);
		log_helper("login", "".$sess_data['username']." Update toko ".$nama."");
		$this->session->set_flashdata('success','Data toko telah diupdate');
		redirect($this->agent->referrer());
	}

	function lock(){
		if($this->session->userdata('lock_screen') != "accesslocktrue"){
			redirect(base_url('st67pri21'));
		}else{
			redirect(base_url('lock_screen'));
		}
	}

	function lock_account(){
		$this->session->unset_userdata('log_access');
		$sess_data['lock_screen'] = "accesslocktrue";
		$sess_data['redirect_back'] = $this->agent->referrer();
		$users = base64_encode($this->session->userdata('username'));
		$user = $this->encryption->encrypt($users);
		$sess_data['usergaet'] = $user;
		$this->session->set_userdata($sess_data);
	 	$this->load->view('manage/lock-screen');
	 }

	 function unlock_lock_screen(){
	 	$pass1 = $this->security->xss_clean($this->input->post('password'));
		$pass2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$pass1);
		$pass3 = strip_tags($pass2);
		$pass = htmlentities($pass3);	 

		$user1 = $this->input->post('inialisasi_config');
		$user2 = $this->encryption->decrypt($user1);
		$user = base64_decode($user2);

		//panggil protected function
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
		$iv_size = mcrypt_enc_get_iv_size($cipher);

		// Encrypt
		if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
		{
			$encrypt_default_rand = mcrypt_generic($cipher, $pass);
			mcrypt_generic_deinit($cipher);
		}

		$res = $this->model_admst->valid_log($user, bin2hex($encrypt_default_rand));
		if($res->num_rows() > 0){
			$this->session->unset_userdata('lock_screen');
			$sess_data['log_access']    = "TRUE_OK_1";
			$this->session->set_userdata($sess_data);
			redirect($this->session->userdata('redirect_back'));
			$this->session->unset_userdata('redirect_back');
		}else{
			$this->session->set_flashdata('error','Password salah, silahkan ulangi lagi.');
			redirect(base_url('lock_screen_default'));
		}
	 }

	function log_admin(){
		$user1 = $this->security->xss_clean($this->input->post('em'));
		$user2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$user1);
		$user3 = strip_tags($user2);
		$user = htmlentities($user3);

		$pass1 = $this->security->xss_clean($this->input->post('ps'));
		$pass2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$pass1);
		$pass3 = strip_tags($pass2);
		$pass = htmlentities($pass3);	 

		$ver1 = $this->security->xss_clean($this->input->post('in'));
		$ver2 = base64_decode($ver1);
// 		$verify = $this->encryption->decrypt($ver2);

// 		if($verify == "I.}[|-sgf(62Jfw"){

			//panggil protected function
			$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
			$iv_size = mcrypt_enc_get_iv_size($cipher);

			// Encrypt
			if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
			{
				$encrypt_default_rand = mcrypt_generic($cipher, $pass);
				mcrypt_generic_deinit($cipher);
			}
		 	
			$cek = $this->model_admst->valid_log($user, bin2hex($encrypt_default_rand));
			if($cek->num_rows() > 0){

				foreach($cek->result() as $data){
					$id_use						= $data->id;
					$sess_data['id']            = $data->id;
					$sess_data['username']    	= $data->username;
					$sess_data['last_login']    = $data->last_login;
					$sess_data['log_access']    = "TRUE_OK_1";
				}
				$h = $this->model_admst->cek_permision($id_use);
				foreach($h->result_array() as $a){
			        if($a['permision'] == "ymarket"){
		   				$ymarket = 'checked';
			   		}else{
			   		
			   		}
			   		if($a['permision'] == "ymail"){
		   				$ymail = 'checked';
			   		}else{
					  			
			   		}
			   		if($a['permision'] == 'yinbox'){
						$yinbox = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ywrite'){
						$ywrite = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ycustomer'){
						$ycustomer = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ydatacustomer'){
						$ydatacustomer = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ypointcustomer'){
							$ypointcustomer = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ysales'){
							$ysales = 'checked';
					}else{
							
					}			
					if($a['permision'] == 'ybestseller'){
							$ybestseller = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yorder'){
							$yorder = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yretur'){
							$yretur = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ylaporan'){
							$ylaporan = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yorderlap'){
							$yorderlap = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yrpp'){
							$yrpp = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yinout'){
							$yinout = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yutang'){
							$yutang = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ypengiriman'){
							$ypengiriman = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yreturlap'){
							$yreturlap = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yvoucherlap'){
							$yvoucherlap = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ypromosi'){
							$ypromosi = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yvouandcou'){
							$yvouandcou = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ypromoslideutama'){
							$ypromoslideutama = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ybannerslider'){
							$ybannerslider = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ygallery'){
							$ygallery = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ysistem'){
							$ysistem = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ysetting'){
							$ysetting = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yuser'){
							$yuser = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yuseractivity'){
							$yuseractivity = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ybackuprestore'){
							$ybackuprestore = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yproduk'){
							$yproduk = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ydafpro'){
							$ydafpro = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ymaster'){
							$ymaster = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ykatparkat'){
							$ykatparkat = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ykatdiv'){
							$ykatdiv = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yopsipro'){
							$yopsipro = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ymerk'){
							$ymerk = 'checked';
					}else{
							
					}
					if($a['permision'] == 'ystok'){
							$ystok = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yrevpro'){
							$yrevpro = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yprobeli'){
							$yprobeli = 'checked';
					}else{
							
					}
					if($a['permision'] == 'yproview'){
							$yproview = 'checked';
					}else{
							
					}
	    		}

		    	$sess_data['ymarket1'] = isset($ymarket)&&$ymarket?'checked':'';
		    	$sess_data['ymail1'] = isset($ymail)&&$ymail?'checked':'';
		    	$sess_data['yinbox1'] = isset($yinbox)&&$yinbox?'checked':'';
		    	$sess_data['ywrite1'] = isset($ywrite)&&$ywrite?'checked':'';
		    	$sess_data['ycustomer1'] = isset($ycustomer)&&$ycustomer?'checked':'';
		    	$sess_data['ydatacustomer1'] = isset($ydatacustomer)&&$ydatacustomer?'checked':'';
		    	$sess_data['ypointcustomer1'] = isset($ypointcustomer)&&$ypointcustomer?'checked':'';
		    	$sess_data['ysales1'] = isset($ysales)&&$ysales?'checked':'';
		    	$sess_data['ybestseller1'] = isset($ybestseller)&&$ybestseller?'checked':'';
		    	$sess_data['yorder1'] = isset($yorder)&&$yorder?'checked':'';
		    	$sess_data['yretur1'] = isset($yretur)&&$yretur?'checked':'';
		    	$sess_data['ylaporan1'] = isset($ylaporan)&&$ylaporan?'checked':'';
		    	$sess_data['yorderlap1'] = isset($yorderlap)&&$yorderlap?'checked':'';
		    	$sess_data['yrpp1'] = isset($yrpp)&&$yrpp?'checked':'';
		    	$sess_data['yinout1'] = isset($yinout)&&$yinout?'checked':'';
		    	$sess_data['yutang1'] = isset($yutang)&&$yutang?'checked':'';
		    	$sess_data['ypengiriman1'] = isset($ypengiriman)&&$ypengiriman?'checked':'';
		    	$sess_data['yreturlap1'] = isset($yreturlap)&&$yreturlap?'checked':'';
		    	$sess_data['yvoucherlap1'] = isset($yvoucherlap)&&$yvoucherlap?'checked':'';
		    	$sess_data['ypromosi1'] = isset($ypromosi)&&$ypromosi?'checked':'';
		    	$sess_data['yvouandcou1'] = isset($yvouandcou)&&$yvouandcou?'checked':'';
		    	$sess_data['ypromoslideutama1'] = isset($ypromoslideutama)&&$ypromoslideutama?'checked':'';
		    	$sess_data['ybannerslider1'] = isset($ybannerslider)&&$ybannerslider?'checked':'';
		    	$sess_data['ygallery1'] = isset($ygallery)&&$ygallery?'checked':'';
		    	$sess_data['ysistem1'] = isset($ysistem)&&$ysistem?'checked':'';
		    	$sess_data['ysetting1'] = isset($ysetting)&&$ysetting?'checked':'';
		    	$sess_data['yuser1'] = isset($yuser)&&$yuser?'checked':'';
		    	$sess_data['yuseractivity1'] = isset($yuseractivity)&&$yuseractivity?'checked':'';
		    	$sess_data['ybackuprestore1'] = isset($ybackuprestore)&&$ybackuprestore?'checked':'';
		    	$sess_data['yproduk1'] = isset($yproduk)&&$yproduk?'checked':'';
		    	$sess_data['ydafpro1'] = isset($ydafpro)&&$ydafpro?'checked':'';
		    	$sess_data['ymaster1'] = isset($ymaster)&&$ymaster?'checked':'';
		    	$sess_data['ykatparkat1'] = isset($ykatparkat)&&$ykatparkat?'checked':'';
		    	$sess_data['ykatdiv1'] = isset($ykatdiv)&&$ykatdiv?'checked':'';
		    	$sess_data['yopsipro1'] = isset($yopsipro)&&$yopsipro?'checked':'';
		    	$sess_data['ymerk1'] = isset($ymerk)&&$ymerk?'checked':'';
		    	$sess_data['ystok1'] = isset($ystok)&&$ystok?'checked':'';
		    	$sess_data['yrevpro1'] = isset($yrevpro)&&$yrevpro?'checked':'';
		    	$sess_data['yprobeli1'] = isset($yprobeli)&&$yprobeli?'checked':'';
		    	$sess_data['yproview1'] = isset($yproview)&&$yproview?'checked':'';
	    	
				$this->session->set_userdata($sess_data);
				$this->model_admst->updateLastlogin($data->id);
				log_helper("login", "".$sess_data['username']." akses login administrator");

				//$this->session->set_flashdata('success','Sedang Mengarahkan...');
				//redirect(base_url('trueaccon2194/info_type_user_log'));
				//$this->output->set_content_type('application/json');
				//$this->output->set_output(json_encode(array('stat_mark_validate_init'=> TRUE)));
				echo true;
				
			}else{
				//$this->session->set_flashdata('error','Username / Password Salah');
				//redirect($this->agent->referrer());
				echo false;
			}
// 		}else{
// 			echo false;
// 		}
	 }

	 function logout_system(){
	 	$this->session->sess_destroy();
	 	$target = $this->session->userdata('username');
	 	log_helper("logout", " User ".$target." Keluar dari halaman Administrator");
	 	redirect(base_url());
	 }

}