<?php if( ! defined('BASEPATH')) exit ('No direct script access allowed');

class User_preference extends CI_Controller {

	protected $key = 'MSY374BDND9NSFSV21N336DMVC06862N';
	protected $iv =  'MBX5294N4MXB27452NG102ND63BN5241';

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/user_preference_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){
		$data = array('error' => '', 'success' => '', 'error1' => '', 'success1' => '', 'error2' => '', 'success2' => '');
		$data['get_list'] = $this->user_preference_adm->get_user();
		log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Manajemen User');
		$this->load->view('manage/header');
		$this->load->view('manage/system/user/index', $data);
		$this->load->view('manage/footer');
	}

	function edit($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);

		$data['g'] = $this->user_preference_adm->cek_data($b);
		$h = $this->user_preference_adm->cek_permision($b);
		//pecah data
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
    	// condition untuk view
    	$data['ymarket1'] = isset($ymarket)&&$ymarket?'checked':'';
    	$data['ymail1'] = isset($ymail)&&$ymail?'checked':'';
    	$data['yinbox1'] = isset($yinbox)&&$yinbox?'checked':'';
    	$data['ywrite1'] = isset($ywrite)&&$ywrite?'checked':'';
    	$data['ycustomer1'] = isset($ycustomer)&&$ycustomer?'checked':'';
    	$data['ydatacustomer1'] = isset($ydatacustomer)&&$ydatacustomer?'checked':'';
    	$data['ypointcustomer1'] = isset($ypointcustomer)&&$ypointcustomer?'checked':'';
    	$data['ysales1'] = isset($ysales)&&$ysales?'checked':'';
    	$data['ybestseller1'] = isset($ybestseller)&&$ybestseller?'checked':'';
    	$data['yorder1'] = isset($yorder)&&$yorder?'checked':'';
    	$data['yretur1'] = isset($yretur)&&$yretur?'checked':'';
    	$data['ylaporan1'] = isset($ylaporan)&&$ylaporan?'checked':'';
    	$data['yorderlap1'] = isset($yorderlap)&&$yorderlap?'checked':'';
    	$data['yrpp1'] = isset($yrpp)&&$yrpp?'checked':'';
    	$data['yinout1'] = isset($yinout)&&$yinout?'checked':'';
    	$data['yutang1'] = isset($yutang)&&$yutang?'checked':'';
    	$data['ypengiriman1'] = isset($ypengiriman)&&$ypengiriman?'checked':'';
    	$data['yreturlap1'] = isset($yreturlap)&&$yreturlap?'checked':'';
    	$data['yvoucherlap1'] = isset($yvoucherlap)&&$yvoucherlap?'checked':'';
    	$data['ypromosi1'] = isset($ypromosi)&&$ypromosi?'checked':'';
    	$data['yvouandcou1'] = isset($yvouandcou)&&$yvouandcou?'checked':'';
    	$data['ypromoslideutama1'] = isset($ypromoslideutama)&&$ypromoslideutama?'checked':'';
    	$data['ybannerslider1'] = isset($ybannerslider)&&$ybannerslider?'checked':'';
    	$data['ygallery1'] = isset($ygallery)&&$ygallery?'checked':'';
    	$data['ysistem1'] = isset($ysistem)&&$ysistem?'checked':'';
    	$data['ysetting1'] = isset($ysetting)&&$ysetting?'checked':'';
    	$data['yuser1'] = isset($yuser)&&$yuser?'checked':'';
    	$data['yuseractivity1'] = isset($yuseractivity)&&$yuseractivity?'checked':'';
    	$data['ybackuprestore1'] = isset($ybackuprestore)&&$ybackuprestore?'checked':'';
    	$data['yproduk1'] = isset($yproduk)&&$yproduk?'checked':'';
    	$data['ydafpro1'] = isset($ydafpro)&&$ydafpro?'checked':'';
    	$data['ymaster1'] = isset($ymaster)&&$ymaster?'checked':'';
    	$data['ykatparkat1'] = isset($ykatparkat)&&$ykatparkat?'checked':'';
    	$data['ykatdiv1'] = isset($ykatdiv)&&$ykatdiv?'checked':'';
    	$data['yopsipro1'] = isset($yopsipro)&&$yopsipro?'checked':'';
    	$data['ymerk1'] = isset($ymerk)&&$ymerk?'checked':'';
    	$data['ystok1'] = isset($ystok)&&$ystok?'checked':'';
    	$data['yrevpro1'] = isset($yrevpro)&&$yrevpro?'checked':'';
    	$data['yprobeli1'] = isset($yprobeli)&&$yprobeli?'checked':'';
    	$data['yproview1'] = isset($yproview)&&$yproview?'checked':'';
    	
		$this->load->view('manage/header');
		$this->load->view('manage/system/user/edit', $data);
		$this->load->view('manage/footer');
	}

	function hapus($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$cek = $this->user_preference_adm->get_data($b);
		foreach($cek as $r){
			$id = $r->id;
			$nama = $r->nama_depan;
			$gb = $r->gb_user;
		}
		unlink('qusour894/img/user/'.$gb);
		$this->user_preference_adm->hapus($b);
		$this->session->set_flashdata('success', 'User '.$nama.' dihapus.');
		log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus user '.$nama.' ('.$b.')');
		redirect('trueaccon2194/user_preference');
	}

	function on($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$cek = $this->user_preference_adm->get_data($b);
		foreach($cek as $r){
			$id = $r->id;
			$nama = $r->nama_depan;
		}
		$this->user_preference_adm->on($b);
		$this->session->set_flashdata('success', 'User '.$nama.' diaktifkan.');
		log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Mengaktifkan user '.$nama.' ('.$b.')');
		redirect(base_url('trueaccon2194/user_preference'));
	}

	function off($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$cek = $this->user_preference_adm->get_data($b);
		foreach($cek as $r){
			$id = $r->id;
			$nama = $r->nama_depan;
		}
		$this->user_preference_adm->off($b);
		$this->session->set_flashdata('success', 'User '.$nama.' dinonaktifkan.');
		log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Menonaktifkan user '.$nama.' ('.$b.')');
		redirect(base_url('trueaccon2194/user_preference'));
	}

	function tambah_user(){
		$this->load->view('manage/header');
		$this->load->view('manage/system/user/add');
		$this->load->view('manage/footer');
	}

	function tracking_user($id){
		$a = base64_decode($id);
		$idx = $this->encrypt->decode($a);
		$cek = $this->user_preference_adm->get_data($idx);
		foreach($cek as $r){
			$id = $r->id;
			$nama = $r->nama_depan;
		}
		$data['get_list'] = $this->user_preference_adm->get_data_record($idx);

		log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Melihat Daftar Aktifitas User '.$nama.' ('.$idx.')');
		$this->load->view('manage/header');
		$this->load->view('manage/system/user/record', $data);
		$this->load->view('manage/footer');
	}

	function cek_u(){
		$userr = $this->input->get('user');
		$g = $this->user_preference_adm->cek_user($userr);

		if($g->num_rows() > 0){
			echo "already";
		}else{
			echo "available";
		}
	}

	function add_user(){

			$ava_filtering 	= $this->security->xss_clean($this->input->post('avatar'));
    		$ava = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$ava_filtering);

			$nama_filtering 	= $this->security->xss_clean($this->input->post('nama'));
    		$nama = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$nama_filtering);

    		$jenis_akses_filtering 	= $this->security->xss_clean($this->input->post('j_akses'));
    		$jenis_akses = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$jenis_akses_filtering);

			$email_filtering 	= $this->security->xss_clean($this->input->post('email'));
    		$email = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$email_filtering);

			$user_filtering 	= $this->security->xss_clean($this->input->post('user'));
    		$user = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$user_filtering);

			$pass1_filtering 	= $this->security->xss_clean($this->input->post('pass1'));
    		$pass1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$pass1_filtering);

			$pass2_filtering 	= $this->security->xss_clean($this->input->post('pass2'));
    		$pass2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$pass2_filtering);	

    		if($jenis_akses == "Administrator"){
				$ak = "G7)*#_fsRe";
			}elseif($jenis_akses == "Finance"){
				$ak = "FnC%4%7d8B";
			}elseif($jenis_akses == "Sales"){
				$ak = "S_lf63*%@)";
			}elseif($jenis_akses == "Support"){
				$ak = "pG5Y$7(#1@";
			}elseif($jenis_akses == "Writer"){
				$ak = "WrTd3*6)^@";
			}

			$id_user = $this->data['id'];

			$config['upload_path']          = 'qusour894/img/user';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 300;
			$config['overwrite']            = TRUE;

			$this->load->library('upload', $config);
			if ($pass1 != $pass2){
				log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah User ('.$nama.')');
				$this->session->set_flashdata('error', 'Isi Form dengan lengkap.');
				redirect('trueaccon2194/user_preference/tambah_user');
			}else{				

				$this->load->library('upload', $config);
				$this->upload->do_upload('avatar');
				$a = $_FILES['avatar']['name'];
				$this->upload->data();
				// link avatar
				//$av = "".base_url('qusour894/img/user/')."".$a."";
				
				//panggil protected function
				$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
				$iv_size = mcrypt_enc_get_iv_size($cipher);
				// Encrypt
				if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
				{
					$encrypt_default_rand = mcrypt_generic($cipher, $pass2);
					mcrypt_generic_deinit($cipher);
				}

				$data = array(
					'username'	=> $user,
					'password'	=> bin2hex($encrypt_default_rand),
					'nama_depan' => $nama,
					'email' 	=> $email,
					'gb_user'	=> $a,
					'status' 	=> 'AEngOn73#43',
					'level' 	=> 'admjosslog21',
					'akses' 	=> $ak,
					'created' 	=> date('Y-m-d H:i:s'),
					'user_create' => $id_user,
				);
				
				$this->user_preference_adm->insert_user($data);
				log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Menambah User ('.$nama.')');
				$this->session->set_flashdata('success', 'User '.$nama.' Ditambah.');
				redirect('trueaccon2194/user_preference');
			}
	}

	function update_user(){
			$a = base64_decode($this->security->xss_clean($this->input->post('is')));
			$idx = $this->encrypt->decode($a);

			$gb_filtering 	= $this->security->xss_clean($this->input->post('gb'));
    		$gb = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$gb_filtering);

			$ava_filtering 	= $this->security->xss_clean($this->input->post('avatar'));
    		$ava = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$ava_filtering);
    		$ava1 = $_FILES['avatar']['name'];

			$nama_filtering 	= $this->security->xss_clean($this->input->post('nama'));
    		$nama = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$nama_filtering);

			$email_filtering 	= $this->security->xss_clean($this->input->post('email'));
    		$email = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$email_filtering);

			$jenis_akses_filtering 	= $this->security->xss_clean($this->input->post('jenis_akses'));
    		$jenis_akses = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$jenis_akses_filtering);

			$user_filtering 	= $this->security->xss_clean($this->input->post('user'));
    		$user = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$user_filtering);

			$pass1_filtering 	= $this->security->xss_clean($this->input->post('pass1'));
    		$pass1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$pass1_filtering);

			$pass2_filtering 	= $this->security->xss_clean($this->input->post('pass2'));
    		$pass2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$pass2_filtering);	


			$id_user = $this->data['id'];

			$config['upload_path']          = 'qusour894/img/user';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 300;
			$config['overwrite']            = TRUE;
			$this->load->library('upload', $config);
				
			if($jenis_akses == "Administrator"){
				$ak = "G7)*#_fsRe";
			}elseif($jenis_akses == "Finance"){
				$ak = "FnC%4%7d8B";
			}elseif($jenis_akses == "Sales"){
				$ak = "S_lf63*%@)";
			}elseif($jenis_akses == "Support"){
				$ak = "pG5Y$7(#1@";
			}elseif($jenis_akses == "Writer"){
				$ak = "WrTd3*6)^@";
			}

			if($pass1 == "" && $pass2 == "" && $ava1 == ""){
				//echo "password kosong update ava tidak";
				$data = array(
					'username'		=> $user,
					'nama_depan' 	=> $nama,
					'email' 		=> $email,
					'akses' 		=> $ak,
					'modifikasi' 	=> date('Y-m-d H:i:s'),
					'user_modif' 	=> $id_user,
				);
				
				$this->user_preference_adm->update_user($idx, $data);
				log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate User ('.$nama.')');
				$this->session->set_flashdata('success', 'User '.$nama.' Diupdate.');
				//redirect('trueaccon2194/user_preference');
				$this-> logout_system_for_change_data($nama);

			}else if($pass1 != "" && $pass2 != "" && $ava1 != ""){
				//echo "update password dan ava";
				//panggil protected function
				$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
				$iv_size = mcrypt_enc_get_iv_size($cipher);
				// Encrypt
				if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
				{
					$encrypt_default_rand = mcrypt_generic($cipher, $pass2);
					mcrypt_generic_deinit($cipher);
				}

				// link avatar
				//$av = "".base_url('qusour894/img/user/')."".$ava1."";
				// hapus gambar sebelumnya
				unlink('qusour894/img/user/'.$gb);
				//upload gambar
				$this->upload->do_upload('avatar');
				$this->upload->data();

				$data = array(
					'username'		=> $user,
					'password'		=> bin2hex($encrypt_default_rand),
					'nama_depan' 	=> $nama,
					'email' 		=> $email,
					'gb_user'		=> $ava1,
					'akses' 		=> $ak,
					'modifikasi' 	=> date('Y-m-d H:i:s'),
					'user_modif' 	=> $id_user,
				);
				
				$this->user_preference_adm->update_user($idx, $data);
				log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate password dan avatar user ('.$nama.')');
				$this->session->set_flashdata('success', 'User '.$nama.' Diupdate.');
				//redirect('trueaccon2194/user_preference');
				$this-> logout_system_for_change_data($nama);
			}else if($ava1 != ""){
				//echo "update ava";
				// link avatar
				$av = "".base_url('qusour894/img/user/')."".$ava1."";
				// hapus gambar sebelumnya
				unlink('qusour894/img/user/'.$gb);
				//upload gambar
				$this->upload->do_upload('avatar');
				$this->upload->data();

				$data = array(
					'username'		=> $user,
					'nama_depan' 	=> $nama,
					'email' 		=> $email,
					'gb_user'		=> $ava1,
					'akses' 		=> $ak,
					'modifikasi' 	=> date('Y-m-d H:i:s'),
					'user_modif' 	=> $id_user,
				);
				
				$this->user_preference_adm->update_user($idx, $data);
				log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Avatar User ('.$nama.')');
				$this->session->set_flashdata('success', 'Avatar Diupdate.');
				//redirect('trueaccon2194/user_preference');
				$this-> logout_system_for_change_data($nama);
			}else if($pass1 != "" && $pass2 != ""){
				//echo "password diisi";
				//panggil protected function
				$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
				$iv_size = mcrypt_enc_get_iv_size($cipher);
				// Encrypt
				if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
				{
					$encrypt_default_rand = mcrypt_generic($cipher, $pass2);
					mcrypt_generic_deinit($cipher);
				}

				$data = array(
					'username'		=> $user,
					'password'		=> bin2hex($encrypt_default_rand),
					'nama_depan' 	=> $nama,
					'email' 		=> $email,
					'akses' 		=> $ak,
					'modifikasi' 	=> date('Y-m-d H:i:s'),
					'user_modif' 	=> $id_user,
				);
				
				$this->user_preference_adm->update_user($idx, $data);
				log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate password user ('.$nama.')');
				$this->session->set_flashdata('success', 'Password Diupdate.');
				$this-> logout_system_for_change_data($nama);
				//redirect('trueaccon2194/user_preference');
			}
			
	}

	function logout_system_for_change_data($nama){
	 	$this->session->sess_destroy();
	 	$this->session->set_flashdata('error', 'Untuk otorisasi, silahkan login kembali');
	 	log_helper("logout", " User ".$nama." Keluar dari halaman Administrator karena mengupdate data user");
	 	redirect(base_url('st67pri21'));
	 }

	function progres_kinerja(){
		$ids_log = $this->data['id'];
		$this->data['get_list'] = $this->user_preference_adm->get_data_kinerja_user($ids_log);
		$this->load->view('manage/header');
		$this->load->view('manage/system/user/list_kinerja', $this->data);
		$this->load->view('manage/footer');
	}

	function input_kinerja(){
		$this->load->view('manage/header');
		$this->load->view('manage/system/user/input_kinerja');
		$this->load->view('manage/footer');
	}

	function upload_dokument_kinerja(){
		$config['upload_path']   = FCPATH.'/qusour894/images/kinerja/';
        $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|xlsx';
        $this->load->library('upload',$config);
 
        if($this->upload->do_upload('filelist')){
        	$token  = $this->input->post('token');
        	$id 	= $this->data['id'];
        	$nama 	= $this->upload->data('file_name');
        	$this->db->insert('user_kinerja_attach',array('id_user_attach'=>$id, 'token'=>$token, 'file'=>$nama, 'tanggal_attach'=>date('Y-m-d')));
        }
	}

	function hapus_dokumen(){
		$id = $this->input->get('token');
		$src = $this->input->get('src');
		$file=FCPATH.'/qusour894/images/kinerja/'.$src;
		unlink($file);
		$this->user_preference_adm->delete_kinerja_select($id);
		echo json_encode(array("status" => TRUE));
	}

	//Untuk menghapus foto
	function removeDocumentkinerja(){

		//Ambil token foto
		$token=$this->input->post('token');

		
		$foto=$this->db->get_where('user_kinerja_attach',array('token'=>$token));

		//print_r($foto->num_rows());
		if($foto->num_rows()>0){
			$hasil=$foto->row();
			$nama_file=$hasil->file;
			if(file_exists($file=FCPATH.'/qusour894/images/kinerja/'.$nama_file)){
				unlink($file);
			}
			$this->db->delete('user_kinerja_attach',array('token'=>$token));
		}
		echo "{}";
	}

	function simpan_kinerja(){
		$ids_log = $this->data['id'];

		$desc_filtering = $this->security->xss_clean($this->input->post('description'));
    	$desc = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$desc_filtering);	

    	$data = array(
    		'id_user_kinerja' 	=> $ids_log,
    		'deskripsi'			=> $desc,
    		'tanggal'			=> date('Y-m-d'),
    	);
    	$this->user_preference_adm->add_kinerja($data);	
    	redirect(base_url('trueaccon2194/user_preference/progres_kinerja'));
	}

	function edit_kinerja($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);

		$this->data['g'] = $this->user_preference_adm->get_data_edit_kinerja($b);
		$r = $this->user_preference_adm->get_data_edit_kinerja($b);
		$tgl = $r['tanggal'];
		$id = $this->data['id'];
		
		$this->data['attach'] = $this->user_preference_adm->get_data_attach_edit_kinerja($id,$tgl);
		$this->load->view('manage/header');
		$this->load->view('manage/system/user/edit_kinerja', $this->data);
		$this->load->view('manage/footer');
	}

	function update_kinerja(){
		$id_filtering = $this->security->xss_clean($this->input->post('cla'));
    	$id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);	

    	$a = base64_decode($id);
		$b = $this->encrypt->decode($a);

		$desc_filtering = $this->security->xss_clean($this->input->post('description'));
    	$desc = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$desc_filtering);	

    	$data = array(
    		'deskripsi'			=> $desc,
    	);
    	$this->user_preference_adm->update_kinerja($data, $b);	
    	redirect(base_url('trueaccon2194/user_preference/progres_kinerja'));
	}

	function hapus_kinerja($b){
		$a = base64_decode($b);
		$id = $this->encrypt->decode($a);
		$cek_tgl_lampiran = $this->user_preference_adm->cek_post_kinerja($id);
		foreach($cek_tgl_lampiran as $r){
			$id_user = $r->id_user_kinerja;
			$tgl = $r->tanggal;

			// cek lampiran kinerja dan hapus 
			$lampiran = $this->user_preference_adm->cek_lampiran($id_user, $tgl);
			foreach($lampiran as $y){
				$filelist = FCPATH.'/qusour894/images/kinerja/'.$y->file;
				unlink($filelist);
			}
			// hapus data
			$this->user_preference_adm->hapus_lampiran($id_user, $tgl);
		}
		$this->user_preference_adm->hapus_kinerja($id);	
    	redirect(base_url('trueaccon2194/user_preference/progres_kinerja'));
	}

}