<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	protected $key = 'LAJ391BD01N10DN37403NC62NXKSST28';
	protected $iv =  '01M364BS721X365MXMGW036C5N24931N';

	function __construct(){
		parent::__construct();
		$this->load->library(array('form_validation','email','encrypt'));
		$this->load->model('users');
		$this->data['id'] = $this->session->userdata('id');
		$get_data_set = toko_libur();
		if($get_data_set['aktif'] == "on"){
			redirect(base_url('toko-libur'));
		}
	}

	function cek_expired_id_reset_csutomer(){
		$cek = $this->users->cek_exp();
		foreach($cek->result() as $r){
			$id = $r->id_cs;
			$now = date('Y-m-d H:i:s');
			$dateData = $r->date_expired;

			if($now > $dateData){
				$this->users->hapus($id);
			}else{
				
			}
		}
	}

	function lupa_pwd(){
		$this->load->view('theme/v1/lupa_password');
	}

	function reset(){
		$mail1 = $this->security->xss_clean($this->input->post('mail_reset'));
		$mail2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$mail1);
		$mail3 = strip_tags($mail2);
		$mail = htmlentities($mail3);

		$ins1 = base64_decode($this->security->xss_clean($this->input->post('sess_mail')));
		$ins = $this->encrypt->decode($ins1);

		if($ins != "lh743hG82#19"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses reset password saat memasukkan email";
			$this->users->savingHack($aktifitas);
		}else{

			$cek = $this->users->cek_valid_email($mail);
			if($cek->num_rows() > 0){
				foreach($cek->result() as $g){
					$id_cs1 = $this->encrypt->encode($g->id);
					$id_cs = base64_encode($id_cs1);
					$em_cus = $g->email;
					$id_reset = $g->id;
				}
				// cek jika customer sudah pernah melakukan reset password namun masa waktu session belum expired
				$cek2 = $this->users->cek_id_double($id_reset);
				if($cek2->num_rows() > 0){
					foreach($cek2->result() as $r){
						$date_ex = $r->date_expired;
						$now = date('Y-m-d H:i:s');
					}
					if($now > $date_ex){ // link expired
						// hapus id reset yang expired tapi sudah dihapus oleh cron job function cek_exp() di user
						// masukkan expired session reset ke database untuk dicek nantinya
						$this->users->insert_expired_reset_akun($id_reset);
						// kirim email
						$data_cs = "Klik link dibawah ini untuk mereset password akun anda. link ini akan expired 2 jam dimulai dari email ini dikirim.<br><br><a href='".base_url('reset_password/')."$id_cs'>$id_cs</a> <br><br> Salam Team.";
						$config = Array(
							'mailtype'  => 'html', 
						);
						
						$this->email->initialize($config);
				      	$this->email->from('noreply@starsstore.id'); // change it to yours
				      	$this->email->to($em_cus);// change it to yours
				      	$this->email->subject('Starsstore - Reset Password');
				      	$this->email->message($data_cs);
				      	$this->email->send();
				      	$this->session->set_flashdata('berhasil', 'Silahkan cek inbox email <b>'.$em_cus.'</b>, untuk reset password!');
						redirect('lupa-password');
					}else{
						$this->session->set_flashdata('error', 'Silahkan Cek Link reset di inbox <b>'.$em_cus.'</b>!');
						redirect('lupa-password');
					}

				}else{
					// masukkan expired session reset ke database untuk dicek nantinya
					$this->users->insert_expired_reset_akun($id_reset);
					// kirim email
					$data_cs = "Klik link dibawah ini untuk mereset password akun anda. link ini akan expired 2 jam dimulai dari email ini dikirim.<br><br><a href='".base_url('reset_password/')."$id_cs'>$id_cs</a> <br><br> Salam Team.";
					$config = Array(
						'mailtype'  => 'html', 
					);
					
					$this->email->initialize($config);
			      	$this->email->from('noreply@starsstore.id'); // change it to yours
			      	$this->email->to($em_cus);// change it to yours
			      	$this->email->subject('Starsstore - Reset Password');
			      	$this->email->message($data_cs);
			      	$this->email->send();
			      	$this->session->set_flashdata('berhasil', 'Silahkan cek inbox email <b>'.$em_cus.'</b>, untuk reset password!');
					redirect('lupa-password');
				}

			}else{
				$this->session->set_flashdata('error', 'Email <b>'.$em_cus.'</b> tidak terdaftar!');
				redirect('lupa-password');
			}
		}
	}

	function reset_joss($id){
		$id_decx1 = base64_decode($id);
		$id_decx = $this->encrypt->decode($id_decx1);
		$cek = $this->users->cek_valid_id($id_decx);
		if($cek->num_rows() > 0){
			foreach($cek->result() as $h){
				$date_id = $h->date_expired;
			}

			$now = date('Y-m-d H:i:s');
			if($now > $date_id){ // link expired 
				$this->session->set_flashdata('error', 'Link kadaluarsa, silahkan reset kembali!');
				redirect('lupa-password');
			}else{
				$this->load->view('reset_password');
			}
		}else{
			$this->session->set_flashdata('error', 'Link kadaluarsa, silahkan reset kembali!');
			redirect('lupa-password');
		}

	}

	function reset_user_form(){
		$p1 = $this->security->xss_clean($this->input->post('p_reset'));
		$p2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$p1);
		$p3 = strip_tags($p2);
		$pw1 = htmlentities($p3);

		$p11 = $this->security->xss_clean($this->input->post('p_r_eset'));
		$p22 = str_replace("/<\/?(p)[^>]*><script></script>", "",$p11);
		$p33 = strip_tags($p22);
		$pw2 = htmlentities($p33);

		$ur1 = $this->security->xss_clean($this->input->post('skiyo_drive'));
		$ur2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$ur1);
		$ur3 = strip_tags($ur2);
		$uri = htmlentities($ur3);		

		$id2 = base64_decode($uri);
		$id = $this->encrypt->decode($id2);

		$ins1 = base64_decode($this->security->xss_clean($this->input->post('sess_reset')));
		$ins = $this->encrypt->decode($ins1);

		if($ins != "U836#92(01#%"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses reset password saat memasukkan password baru";
			$this->users->savingHack($aktifitas);
		}else{
			$this->form_validation->set_rules('p_reset', 'Password', 'required');
        	$this->form_validation->set_rules('p_r_eset', 'Konfirmasi Password', 'required|matches[p_reset]');

        	if($this->form_validation->run() == FALSE){
        		$this->session->set_flashdata('error', 'Password tidak sama, atau cek form!');
        		redirect($this->agent->referrer());
        	}else{
        		$cek = $this->users->get_data_email_cs($id);
        		foreach($cek->result() as $i){
					$em_cus = $i->email;
				}
        		// kirim email penggantian password
				$data_cs = "Akun anda telah berganti password, silahkan login dengan password yang baru.<br><br> Salam Team.";
				$config = Array(
					'mailtype'  => 'html', 
				);
				
				$this->email->initialize($config);
		      	$this->email->from('noreply@starsstore.id'); // change it to yours
		      	$this->email->to($em_cus);// change it to yours
		      	$this->email->subject('Reset Password Berhasil');
		      	$this->email->message($data_cs);
		      	$this->email->send();

        		// hapus session id
        		$this->users->hapus_session_reset($id);
        		// change password
        		//panggil protected function
 				$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
				$iv_size = mcrypt_enc_get_iv_size($cipher);

				// Encrypt
				if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
				{
					$encrypt_default_rand = mcrypt_generic($cipher, $pw1);
					mcrypt_generic_deinit($cipher);
				}
        		$this->users->change_password_akun($id, bin2hex($encrypt_default_rand));
        		$this->session->set_flashdata('berhasil', 'Password telah diubah, silahkan login!');
        		redirect(base_url('login-pelanggan'));
        	}
		}
		
	}	

	function seller_preference(){
		$data['title'] = "<title>Jadi Seller</title>";
		$data['meta_desc'] = "<meta name='description' content='Jadi Seller' />";
		$data['meta_key'] = "<meta name='keywords' content='Jadi seller, jadi penjual, seller'/>";
		$this->load->view('theme/v1/header', $data);
		$this->load->view('theme/v1/jadi_seller');
		$this->load->view('theme/v1/footer');
	}

	function dashboar_seller(){
		$idcs = $this->data['id'];
		$data['title'] = "<title>Halaman Seller</title>";
		$data['meta_desc'] = "<meta name='description' content='halaman Seller' />";
		$data['meta_key'] = "<meta name='keywords' content='halaman seller, jadi penjual, seller'/>";
		$data['ins_seller'] = $this->users->get_data_seller($idcs);
		$this->load->view('theme/v1/header', $data);
		$this->load->view('theme/v1/dashboardSeller');
		$this->load->view('theme/v1/footer');
	}

	function pre_form_seller(){
		//cek seller sudah daftar
		$id = $this->data['id'];
		$cek = $this->users->cek_valid_seller($id);
		if($cek->num_rows() > 0){
			redirect(base_url());
		}else{
			$data['title'] = "<title>Form Pengajuan Seller</title>";
			$data['meta_desc'] = "<meta name='description' content='Form Pengajuan Seller' />";
			$data['meta_key'] = "<meta name='keywords' content='Form Pengajuan Seller'/>";
			$data['sk_seller'] = $this->users->sk();
			$this->load->view('theme/v1/header', $data);
			$this->load->view('theme/v1/ajukan_form_seller');
			$this->load->view('theme/v1/footer');

			// generate ID seller
			$length =5;
			$random= "";
			srand((double)microtime()*1000000);
			$data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
			$data .= "1234567890";
			for($i = 0; $i < $length; $i++){
				$random .= substr($data, (rand()%(strlen($data))), 1);
			}
			// Awalan ID
			$utama = "SL";
			$idSeller = $utama.$random;
			$id_seller['sellerID']    = $idSeller;
			$this->session->set_userdata($id_seller);
			// END generate ID seller
		}
	}

	// GANTI FUNGSI UNTUK KONFIRMASI PEMBAYARAN
	function upload_dokument_seller_auto(){
		$config['upload_path']   = FCPATH.'/assets/images/konfirmasi_pesanan/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg'; //|pdf|doc|docx
        $this->load->library('upload',$config);

        if($this->upload->do_upload('userfile')){
        	$token  = $this->input->post('token_foto');
        	$id 	= $this->session->userdata('sellerID');
        	$nama 	= $this->upload->data('file_name');
        	$this->db->insert('dokument_seller',array('id_dokument_seller'=>$id, 'dokument'=>$nama, 'token'=> $token));
        }
	}

	//Untuk menghapus foto
	function removeDocument(){

		//Ambil token foto
		$token=$this->input->post('token');

		
		$foto=$this->db->get_where('dokument_seller',array('token'=>$token));

		//print_r($foto->num_rows());
		if($foto->num_rows()>0){
			$hasil=$foto->row();
			$nama_foto=$hasil->dokument;
			if(file_exists($file=FCPATH.'/qusour894/images/dokument_seller/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('dokument_seller',array('token'=>$token));
		}
		echo "{}";
	}

	function Validasiformseller(){
		$jenis1 = $this->security->xss_clean($this->input->post('jt'));
		$jenis2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$jenis1);
		$jenis3 = strip_tags($jenis2);
		$jenis = htmlentities($jenis3);

		$lokasi1 = $this->security->xss_clean($this->input->post('ls'));
		$lokasi2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$lokasi1);
		$lokasi3 = strip_tags($lokasi2);
		$lokasi = htmlentities($lokasi3);

		$no1 = $this->security->xss_clean($this->input->post('ns'));
		$no2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$no1);
		$no3 = strip_tags($no2);
		$no = htmlentities($no3);

		$namestore1 = $this->security->xss_clean($this->input->post('nst'));
		$namestore2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$namestore1);
		$namestore3 = strip_tags($namestore2);
		$namestore = htmlentities($namestore3);

		$nameoffice1 = $this->security->xss_clean($this->input->post('nf'));
		$nameoffice2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nameoffice1);
		$nameoffice3 = strip_tags($nameoffice2);
		$nameoffice = htmlentities($nameoffice3);

		$noreg1 = $this->security->xss_clean($this->input->post('nr'));
		$noreg2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$noreg1);
		$noreg3 = strip_tags($noreg2);
		$noreg = htmlentities($noreg3);

		$alamat1 = $this->security->xss_clean($this->input->post('ads'));
		$alamat2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$alamat1);
		$alamat3 = strip_tags($alamat2);
		$alamat = htmlentities($alamat3);

		$alagudang1 = $this->security->xss_clean($this->input->post('adw'));
		$alagudang2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$alagudang1);
		$alagudang3 = strip_tags($alagudang2);
		$alagudang = htmlentities($alagudang3);

		$pro1 = $this->security->xss_clean($this->input->post('pr'));
		$pro2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$pro1);
		$pro3 = strip_tags($pro2);
		$pro = htmlentities($pro3);

		$cit1 = $this->security->xss_clean($this->input->post('ct'));
		$cit2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$cit1);
		$cit3 = strip_tags($cit2);
		$cit = htmlentities($cit3);

		$kc1 = $this->security->xss_clean($this->input->post('kc'));
		$kc2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$kc1);
		$kc3 = strip_tags($kc2);
		$kc = htmlentities($kc3);

		$kn1 = $this->security->xss_clean($this->input->post('kn'));
		$kn2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$kn1);
		$kn3 = strip_tags($kn2);
		$kn = htmlentities($kn3);

		$ins = base64_decode($this->input->post('vol'));
		$b = $this->encrypt->decode($ins);

		if($b != "3?2652427%474]^31&53"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses pendaftaran seller";
			$this->users->savingHack($aktifitas);
		}else{

			if($no == ""){
				echo "BlankForm2";
			}else if($namestore == "" ){
				echo "BlankForm3";
			}else if($nameoffice == ""){
				echo "BlankForm4";
			}else if($noreg == ""){
				echo "BlankForm5";
			}else if($alamat == ""){
				echo "BlankForm6";
			}else if($alagudang == ""){
				echo "BlankForm7";
			}else if($pro == ""){
				echo "BlankForm8";
			}else if($cit == ""){
				echo "BlankForm9";
			}else if($kc == ""){
				echo "BlankForm10";
			}

			$idS = $this->session->userdata('sellerID');
			$id = $this->session->userdata('id');

			// get data seller from akunnya 
			$dtg = $this->users->get_data_customer($id);
			foreach($dtg->result() as $f){
				$nama = $f->nama_lengkap;
			}

			$dataSeller = array(
				'id_seller' 			=> $idS,
				'id_customer_seller'	=> $id,
				'nama_seller'			=> $nama,
				'jenis_seller'			=> $jenis,
				'lokasi'				=> $lokasi,
				'no_telp'				=> $no,
				'nama_toko'				=> $namestore,
				'nama_kantor'			=> $nameoffice,
				'nomor_registrasi_usaha_or_ktp_seller'	=> $noreg,
				'alamat_usaha'			=> $alamat,
				'alamat_gudang'			=> $alagudang,
				'provinsi'				=> $pro,
				'kota'					=> $cit, 
				'kecamatan'				=> $kc,
				'you_know_info_from'	=> $kn,
				'status_seller'			=> "ditangguhkan",
				);

			$this->users->inDataSeller($dataSeller);	
			
			//tambahkan ID seller di table customer
			$this->users->addIDseller($id,$idS);

			echo "ScSell*35*527390&31Ik{]dgd";
		}
	}

	function form_seller_berhasil(){
		$data['title'] = "<title>Pengajuan Berhasil</title>";
		$data['meta_desc'] = "<meta name='description' content='pengajuan berhasil' />";
		$data['meta_key'] = "<meta name='keywords' content='pengajuan seller, seller, penjual, jualan online'/>";
		$this->load->view('theme/v1/header', $data);
		$this->load->view('theme/v1/berhasilSeller');
		$this->load->view('theme/v1/footer');
	}

	function log_page_default(){
		if($this->session->userdata('log_access') == "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Anda sudah login');
			redirect('customer');	
		}else{
			$data['title'] = "<title>Login Pelanggan</title>";
			$data['meta_desc'] = "<meta name='description' content='Login Pelanggan' />";
			$data['meta_key'] = "<meta name='keywords' content='login, pelanggan, customer page'/>";
			$this->load->view('theme/v1/log_page_for_customer', $data);
		}
	}

	function daftar(){
		$data['title'] = "<title>Login Pelanggan</title>";
		$data['meta_desc'] = "<meta name='description' content='Login Pelanggan' />";
		$data['meta_key'] = "<meta name='keywords' content='login, pelanggan, customer page'/>";
		$this->load->view('theme/v1/log_page_for_customer', $data);
	}

	function auth_log_key_basement(){
		$ins = base64_decode($this->input->post('gexf'));
		$b = $this->encrypt->decode($ins);

			if($b != "K935$2&#1I.}[st53|-sgfw3(62Jfw"){
				//SAVING DATA HACKER
				$aktifitas = "memecahkan kode enkripsi untuk akses login order";
				$this->users->savingHack($aktifitas);
				//redirect(base_url()); 
			}else{
				$this->form_validation->set_rules('em_ly', 'Email', 'required|xss_clean|valid_email');
				$this->form_validation->set_rules('pw_ly', 'Password', 'required|xss_clean');

				if($this->form_validation->run() != FALSE ){
					$email = strip_tags($this->security->xss_clean($this->input->post('em_ly')));
	 				$pass = strip_tags($this->security->xss_clean($this->input->post('pw_ly')));

	 				//panggil protected function
	 				$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
					$iv_size = mcrypt_enc_get_iv_size($cipher);
 
					// Encrypt
					if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
					{
    					$encrypt_default_rand = mcrypt_generic($cipher, $pass);
    					mcrypt_generic_deinit($cipher);
					}
 
					// Decrypt
					//if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
					//{
    				//	$decrypted = mdecrypt_generic($cipher, $encrypted);
    				//	mcrypt_generic_deinit($cipher);
    				//	//echo '<strong>After decryption:</strong> ' . $decrypted . '<br />';
					//}
	 				//end panggil protected function
	 				
					$cek = $this->users->validasi_data($email, bin2hex($encrypt_default_rand));
					if($cek->num_rows() > 0){
						foreach($cek->result() as $data){
							$sess_data['id']            = $data->id;
							$sess_data['last_login']    = $data->last_login;
							$sess_data['log_access']    = "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";

							$this->session->set_userdata($sess_data);
							$this->users->updateLastloginCustomer($data->id);
							$this->users->saving_ipdevicebrowser($data->id,$email);
						}
							echo "KnstwywH736*628$3129%34@724";
					}else if($cek->num_rows() == 0){
						echo "Mshhu^627*7396#2727$#HkedbFk";
					}
					
				}else{
					//SAVING DATA HACKER
					$aktifitas = "memecahkan kode untuk mengakali form validasi di login order";
					$this->users->savingHack($aktifitas);
				}
			}
	}
///////////// untuk daftar baru biasa /////////////////////////
	function daftar_user_baru(){
		$data['title'] = "<title>Mendaftar</title>";
		$data['meta_desc'] = "<meta name='description' content='Nikmati kemudahan bertransaksi barang favorit anda' />";
		$data['meta_key'] = "<meta name='keywords' content='mendaftar, kenyamanan belanja, kenyamanan bertransaksi, daftar baru, pelanggan baru'/>";
		$this->load->view('theme/v1/cus_head_reg_new_page_biasa', $data);
	}
////////// untuk daftar baru saat order //////////////////////
	function daftar_customer_baru(){
		if($this->session->userdata('log_access') == "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Anda sudah login');
			redirect('customer');	
		}else{
			$data['title'] = "<title>Mendaftar</title>";
			$data['meta_desc'] = "<meta name='description' content='Nikmati kemudahan bertransaksi barang favorit anda' />";
			$data['meta_key'] = "<meta name='keywords' content='mendaftar, kenyamanan belanja, kenyamanan bertransaksi, daftar baru, pelanggan baru'/>";
			$this->load->view('theme/v1/cus_head_reg_new_page', $data); 
		}
	}

	// DAFTAR
	function sign_up_for_new_register_csutomer(){

		$a = base64_decode($this->input->post('cosreg'));
		$b = $this->encrypt->decode($a);

		if($b != "Kjs$2%3^+54lNA)163*^$2$319"){
			echo "Jhsh82825(74(7242&8$#$%@_(&";
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses daftar customer baru";
			$this->users->savingHack($aktifitas);
		}else{		
			
			$nama1 = $this->security->xss_clean($this->input->post('na'));
			$nama2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nama1);
			$nama3 = strip_tags($nama2);
			$nama = htmlentities($nama3);

			$email1 = $this->security->xss_clean($this->input->post('em'));
			$email2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$email1);
			$email3 = strip_tags($email2);
			$email = htmlentities($email3);

			$pass1 = $this->security->xss_clean($this->input->post('pas'));
			$pass2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$pass1);
			$pass3 = strip_tags($pass2);
			$pass = htmlentities($pass3);

			$tel1 = $this->security->xss_clean($this->input->post('tel'));
			$tel2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$tel1);
			$tel3 = strip_tags($tel2);
			$tel = htmlentities($tel3);

			$gen1 = $this->security->xss_clean($this->input->post('gen'));
			$gen2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$gen1);
			$gen3 = strip_tags($gen2);
			$gen = htmlentities($gen3);

			//if email alredy 
			$alre_mail = $this->users->cek_email($email);
			if($alre_mail->num_rows() >= 1){
				echo "Khs8gueo28^bsjLGs^2#417(&$";
			}else{

				//panggil protected function
	 			$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
				$iv_size = mcrypt_enc_get_iv_size($cipher);
 
				// Encrypt PASSWORD
				if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
				{
    				$encrypt_default_rand = mcrypt_generic($cipher, $pass);
    				mcrypt_generic_deinit($cipher);
				}

				// Encrypt EMAIL
				if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
				{
    				$encrypt_email = mcrypt_generic($cipher, $email);
    				mcrypt_generic_deinit($cipher);
				}

				$data = array(
					'email'  		=> $email,
					'email_encrypt' => bin2hex($encrypt_email),
               		'password'     	=> bin2hex($encrypt_default_rand),
               		'nama_lengkap'	=> $nama,
               		'telp'			=> $tel,
               		'gender'		=> $gen,	
               		'status'    	=> 'a@kti76f0', //Kj(*62&*^#)_
               		'level'			=> 'regcusok4*##@!9))921',
               		'akses'			=> '9x4$58&(3*+',
               		'created'		=> date("Y-m-d H:i:s"),
               		'ip_register_first'	=> $this->input->ip_address(),
            	);
				$this->users->reg_new_data_customer($data);

				// Login otomatis
				$cek = $this->users->validasi_data($email, bin2hex($encrypt_default_rand));
				if($cek->num_rows() > 0){
					foreach($cek->result() as $data){
						$sess_data['id']            = $data->id;
						$sess_data['last_login']    = $data->last_login;
						$sess_data['log_access']    = "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";
						$this->session->set_userdata($sess_data);
						$this->users->updateLastloginCustomer($data->id);
						$this->users->saving_ipdevicebrowser($data->id,$email);
					}
				}

				// set cookie
				$key = random_string('alnum', 64);
                set_cookie('Bismillahirrohmanirrohim', $key, 3600*24*30); // set expired 30 hari kedepan
                
                // simpan cookie dan exp cookie di database
                $update_key = array(
                    'cookies' 		=> $key,
                    'exp_cookie' 	=> date('Y-m-d H:i:s', strtotime('30 days')), // exp cookie 1 bulan
                );
                $idM = $data->id;
                $this->users->update_cookie($update_key, $idM);

				//ambil nama toko dari database 
				$set_toko = $this->users->data_setting();
				foreach($set_toko->result() as $ui){
					if($ui->nama == "nama_toko"){
						$nama_toko = $ui->nama;
					}
				}

				//laporan ke admin
				$dataadm = $this->users->data_email_pusat();
				foreach($dataadm->result() as $yp){
					if($yp->status == "e_admin"){
						$admmail = $yp->em_acc;
					}
				}	

				$data_cs = array(
					'nakap' => $nama
				);

        		$config['mailtype'] 	= 'html'; // or html
				$this->load->library('parser');
        		$this->load->library('email', $config);
      			//$this->email->set_newline("\r\n");
      			//$this->email->set_header('MIME-Version', '1 .0; charset=utf-8');
				//$this->email->set_header('Content-type', 'text/html');
      			$this->email->from('noreply@domain.com');
      			$this->email->to($email);
      			$this->email->subject('Pendaftaran Berhasil');
      			$body = $this->parser->parse('em_info_notification_group/f_cus_mail_reg_first',$data_cs,TRUE);
      			$this->email->message($body);
      			$this->email->send();
      			// ke halaman verifikasi aktifkan akun
				//echo "Akch63%$#122%*)__16";
				// ke halaman customer (langsung aktif) perubahan tanggal 16 maret 2020
				echo "Jhsh82825(74(7242&8$#$%@_(&";
			}

		}
				
	} 
// aktifasi untuk menuju ke halaman customer (biasa) //
	function actfCount2(){
		$data['title'] = "<title>Verifikasi</title>";
		$data['meta_desc'] = "<meta name='description' content='verifikasi Pengguna Baru' />";
		$data['meta_key'] = "<meta name='keywords' content='verifikasi pengguna baru, mendaftar, kenyamanan belanja, kenyamanan bertransaksi, daftar baru, pelanggan baru'/>";
		$this->load->view('theme/v1/header', $data);
		$this->load->view('theme/v1/verify_account_default');
		$this->load->view('theme/v1/footer');
	}

// aktifasi untuk menuju ke halaman order ///
	function actfCount1(){
		$data['title'] = "<title>Verifikasi</title>";
		$data['meta_desc'] = "<meta name='description' content='verifikasi Pengguna Baru' />";
		$data['meta_key'] = "<meta name='keywords' content='verifikasi pengguna baru, mendaftar, kenyamanan belanja, kenyamanan bertransaksi, daftar baru, pelanggan baru'/>";
		//$this->load->view('theme/v1/header', $data);
		$this->load->view('theme/v1/verify_account', $data);
		//$this->load->view('theme/v1/footer');
	}
// untuk ke halaman customer //
	function artclassaccountsipppp($id_class_user){
		//get id user dan keluarkan datanya
		$a = base64_decode($id_class_user);
		$b = $this->encrypt->decode($a);
		$log_data = $this->users->cek_data_reg_newuser($b);
		foreach($log_data->result() as $dan){
			$email = $dan->email;
			$encrypt_default_rand = $dan->password;
		}

		//ubah status
		$data = array(
			'status' => 'a@kti76f0',
			);
		$this->users->ubah_stat_cus($b,$data);

		//Login otomatis
		$cek = $this->users->validasi_data($email,$encrypt_default_rand);

		if($cek->num_rows() > 0){
			foreach($cek->result() as $data){
				$sess_data['id']            = $data->id;
				$sess_data['last_login']    = $data->last_login;
				$sess_data['log_access']    = "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";

				$this->session->set_userdata($sess_data);
				$this->users->updateLastloginCustomer($b);
				$this->users->saving_ipdevicebrowser($b,$email);

				//unset session aktifasi ID
				$this->session->unset_userdata('id_user_cs');
			}
			redirect(base_url('customer'));
		}
	}


// untuk ke halaman order //
	function artclassaccountsip($id_class_user){
		//get id user dan keluarkan datanya
		$a = base64_decode($id_class_user);
		$b = $this->encrypt->decode($a);
		$log_data = $this->users->cek_data_reg_newuser($b);
		foreach($log_data->result() as $dan){
			$email = $dan->email;
			$encrypt_default_rand = $dan->password;
		}

		//ubah status
		$data = array(
			'status' => 'a@kti76f0',
			);
		$this->users->ubah_stat_cus($b,$data);

		//Login otomatis
		$cek = $this->users->validasi_data($email,$encrypt_default_rand);

		if($cek->num_rows() > 0){
			foreach($cek->result() as $data){
				$sess_data['id']            = $data->id;
				$sess_data['last_login']    = $data->last_login;
				$sess_data['log_access']    = "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";

				$this->session->set_userdata($sess_data);
				$this->users->updateLastloginCustomer($b);
				$this->users->saving_ipdevicebrowser($b,$email);

				//unset session aktifasi ID
				$this->session->unset_userdata('id_user_cs');
			}
			redirect(base_url('customer'));
		}
	}

	function edit_customer(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$id = $this->input->get('cst');
			$idf = $this->encrypt->decode($id);
			//print_r($idf);
			$datac['js'] = $this->users->get_edit_data_customer($idf);
			echo json_encode($datac);
		}
	}
 
	function logout_page(){ // GAK DIPAKAI
		$data['title'] = "<title>Anda Keluar dari akun</title>";
		$data['meta_desc'] = "<meta name='description' content='Keluar dari halaman akun' />";
		$data['meta_key'] = "<meta name='keywords' content='keluar dari halaman akun'/>";
		$this->load->view('theme/v1/header',$data);
		$this->load->view('theme/v1/halaman_logout');
		$this->load->view('theme/v1/footer');
	}

	function customer_logout(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$id_user = $this->data['id'];
			if(!$this->cart->contents()){
				//$this->facebook->destroy_session();
				delete_cookie('Bismillahirrohmanirrohim');
				$this->session->sess_destroy();
		        $this->session->unset_userdata('sess_data');
	        	redirect(base_url());
			}else{
				foreach($this->cart->contents() as $item){
					$id_produk = $item['id'];
					
					$data_wishlist[] = array(
	                	'id_customer' => $id_user,
	                	'id_produk'   => $item['id'],
	            	);
				}
				//saving produk in wishlist
				$this->users->saving_produk_to_wishlist($data_wishlist);
				//$this->facebook->destroy_session();
				delete_cookie('Bismillahirrohmanirrohim');
				$this->session->sess_destroy();
				$this->session->unset_userdata('sess_data');
	        	redirect(base_url());
			}
		}
     } 

    // LOGIN
	function log_cus_header(){
		$ins = base64_decode($this->input->post('in'));
		$b = $this->encrypt->decode($ins);

		if($b != "Ub$2652%^725**$3231&%461"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses login order";
			$this->users->savingHack($aktifitas);
			//redirect(base_url()); 
		}else{
				$email1 = $this->security->xss_clean($this->input->post('em'));
				$email2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$email1);
				$email3 = strip_tags($email2);
				$email = htmlentities($email3);
 				
 				$ps1 = $this->security->xss_clean($this->input->post('ps'));
				$ps2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$ps1);
				$ps3 = strip_tags($ps2);
				$ps = htmlentities($ps3);

				$this->form_validation->set_rules('em', 'Email', 'required|xss_clean|valid_email');
				if($this->form_validation->run() == FALSE ){
					echo "200";
				}else{

	 				//panggil protected function
	 				$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
					$iv_size = mcrypt_enc_get_iv_size($cipher);
 
					// Encrypt
					if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
					{
    					$encrypt_default_rand = mcrypt_generic($cipher, $ps);
    					mcrypt_generic_deinit($cipher);
					}
 
					// Decrypt
					//if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
					//{
    				//	$decrypted = mdecrypt_generic($cipher, $encrypted);
    				//	mcrypt_generic_deinit($cipher);
    				//	//echo '<strong>After decryption:</strong> ' . $decrypted . '<br />';
					//}
	 				//end panggil protected function
	 				
	 				//cek status user jika masih disable
	 				$cek_status = $this->users->checkingStatus($email);
	 				foreach($cek_status->result() as $st){
	 					$id_user = $st->id;
	 					$status_user = $st->status;
	 				}
	 				if($status_user == "Kj(*62&*^#)_"){

	 					$acc['id_user_cs']    = $id_user;
						$this->session->set_userdata($acc);
						echo "ActcivjsOauthLogseCre";

	 				}else if($status_user == "Nh3825(*hhb"){
	 					echo "Nu627542(*52h@$?'S[;K";
	 				}else{

						$cek = $this->users->validasi_data($email, bin2hex($encrypt_default_rand));
						if($cek->num_rows() >= 1){

							foreach($cek->result() as $data){

								// CEK MAIL ENCRYPT JIKA KOSONG MAKA BUATKAN
								if($data->email_encrypt == ""){ // jika mail encrypt kosong maka generatekan
									//panggil protected function
						 			$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
									$iv_size = mcrypt_enc_get_iv_size($cipher);
									// Encrypt EMAIL
									if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
									{
					    				$encrypt_email = mcrypt_generic($cipher, $email);
					    				mcrypt_generic_deinit($cipher);
									}
									$data_encrypt = array(
										'email_encrypt' => bin2hex($encrypt_email),
									);
									$this->db->where('id',$data->id);
									$this->db->update('customer', $data_encrypt);
								}
								// END CEK

								$sess_data['id']         = $data->id;
								$sess_data['mail_encrypt']  = $data->email_encrypt;
								$sess_data['last_login']    = $data->last_login;
								$sess_data['log_access']    = "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"; 
								$sess_data['provider']		= $data->provider_login;

								$this->session->set_userdata($sess_data);
								$this->users->updateLastloginCustomer($data->id);
								$this->users->saving_ipdevicebrowser($data->id,$email);
							}
								echo "+8(98*&2.,asdJT14(*621=_0";
						}else{
							echo ")72*h39Bvsk%52)&1->371)(63467";
						}
					}

				}
			}
	}

	function customer_page(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$id_clas_us = $this->data['id'];
			$data['title'] = "<title>Halaman Pelanggan</title>";
			$data['meta_desc'] = "<meta name='description' content='Halaman informasi pelanggan' />";
			$data['meta_key'] = "<meta name='keywords' content='Halaman informasi pelanggan'/>";
			$data['list_order'] = $this->users->listPesanan($id_clas_us);
			$data['wishlist'] = $this->users->wishlist($id_clas_us);
			$data['review'] = $this->users->review($id_clas_us);
			$this->load->view('theme/v1/header',$data);
			$this->load->view('theme/v1/customer_page');
			$this->load->view('theme/v1/footer');
		}
	}

	function daftarRet(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$id_clas_us = $this->data['id'];
			$data['title'] = "<title>Daftar Retur</title>";
			$data['meta_desc'] = "<meta name='description' content='retur produk' />";
			$data['meta_key'] = "<meta name='keywords' content='retur produk, retur'/>";
			$data['list_retur'] = $this->users->listretur($id_clas_us);
			$this->load->view('theme/v1/header',$data);
			$this->load->view('theme/v1/daftar_retur');
			$this->load->view('theme/v1/footer');
		}
	}

	function detailRet($idRet){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$ins = base64_decode($idRet);
			$b = $this->encrypt->decode($ins);
			$data['title'] = "<title>Detail Retur</title>";
			$data['meta_desc'] = "<meta name='description' content='Detail Retur' />";
			$data['meta_key'] = "<meta name='keywords' content='retur produk, retur'/>";
			$data['detail_retur'] = $this->users->detailretur($b);
			$data['detail_produk_ret'] = $this->users->detailprodukretur($b);
			$this->load->view('theme/v1/header',$data);
			$this->load->view('theme/v1/detail_retur');
			$this->load->view('theme/v1/footer');
		}
	}

	function favorit(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$id_clas_us = $this->data['id'];
			$data['title'] = "<title>Barang Favorit</title>";
			$data['meta_desc'] = "<meta name='description' content='Barang Favorit' />";
			$data['meta_key'] = "<meta name='keywords' content='Barang favorit'/>";
			$data['list_favorit'] = $this->users->listFav($id_clas_us);
			$this->load->view('theme/v1/header',$data);
			$this->load->view('theme/v1/favorit');
			$this->load->view('theme/v1/footer');
		}
	}
 
	function infoAcc(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$idcs = $this->data['id'];
			$gdt = $this->users->get_data_log_customer($idcs);
			foreach($gdt as $y){
				$gen = $y->gender;
			}

			if ($gen == "pria"){
				$pria = "checked";
				$wanita = "";
			}else if($gen == "wanita"){
				$pria = "";
				$wanita = "checked";
			}

			$data['title'] = "<title>Halaman Pelanggan</title>";
			$data['meta_desc'] = "<meta name='description' content='Halaman informasi pelanggan' />";
			$data['meta_key'] = "<meta name='keywords' content='Halaman informasi pelanggan'/>";
			$data['datacustomer'] = $gdt;
			$data['pr'] =  $pria;
			$data['wn'] =  $wanita;
			$this->load->view('theme/v1/header',$data);
			$this->load->view('theme/v1/info_acc');
			$this->load->view('theme/v1/footer');
		}
	}

	function ubah_info_user(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$id = $this->data['id'];
			$ins = base64_decode($this->input->post('GetchGinit'));
			$b = $this->encrypt->decode($ins);
			if($b != "K935$2&#1I.}[st53|-sgfw3(62Jfw"){
				//SAVING DATA HACKER
				$aktifitas = "memecahkan kode enkripsi untuk akses ubah informasi pelanggan";
				$this->users->savingHack($aktifitas);
				//redirect(base_url()); 
			}else{
				$av = $_FILES['avatar']['name'];
				$config['upload_path']          = 'qusour894/img/profile_image';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				$config['max_size']             = 300;
				$config['overwrite']            = FALSE;
				$this->load->library('upload', $config);

				$gb1 = $this->security->xss_clean($this->input->post('gb'));
				$gb2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$gb1);
				$gb3 = strip_tags($gb2);
				$gb = htmlentities($gb3);

				$email1 = $this->security->xss_clean($this->input->post('email_m'));
				$email2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$email1);
				$email3 = strip_tags($email2);
				$email = htmlentities($email3);

				$nama1 = $this->security->xss_clean($this->input->post('name_l'));
				$nama2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nama1);
				$nama3 = strip_tags($nama2);
				$nama = htmlentities($nama3); 

				$pass1 = $this->security->xss_clean($this->input->post('ps_d1'));
				$pass2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$pass1);
				$pass3 = strip_tags($pass2);
				$pass11 = htmlentities($pass3);

				$pass2 = $this->security->xss_clean($this->input->post('ps_d2'));
				$pass21 = str_replace("/<\/?(p)[^>]*><script></script>", "",$pass2);
				$pass31 = strip_tags($pass21);
				$pass22 = htmlentities($pass31);

				$tel1 = $this->security->xss_clean($this->input->post('no_l'));
				$tel2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$tel1);
				$tel3 = strip_tags($tel2);
				$tel = htmlentities($tel3);

				$gen1 = $this->security->xss_clean($this->input->post('gen'));
				$gen2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$gen1);
				$gen3 = strip_tags($gen2);
				$gen = htmlentities($gen3);
				
				if($pass11 != $pass22){
					//password tak sama
					//echo "JsgPasNoMa4chasj^2";
					$this->session->set_flashdata('error', 'Password tidak sama');
					redirect($this->agent->referrer());
				}else if(empty($pass11) && empty($pass22) && $av == ""){
					//saving data tanpa password tanpa gambar
					$data_user = array(
						'email' 		=> $email,
						'nama_lengkap' 	=> $nama,
						'telp' 			=> $tel,
						'gender' 		=> $gen,
						);
					$this->users->savingDatawithoutpassword($data_user, $id);
					//echo "Jsg&5#833ndsfa3*5";
					$this->session->set_flashdata('berhasil', 'Data telah diubah');
					redirect($this->agent->referrer());
				}else if(empty($pass11) && empty($pass22) && $av != ""){
					//saving data tanpa password tapi gambar profil diupload
					unlink('qusour894/img/profile_image/'.$gb);
					$this->upload->do_upload('avatar');
					$this->upload->data();
					if(!empty($this->session->userdata('provider'))){
						$prov = "";
						$this->session->unset_userdata(array('sess_data' => 'provider'));
					}else{
						$prov = "";
					}
					$data_user = array(
						'provider_login'=> $prov,
						'email' 		=> $email,
						'nama_lengkap' 	=> $nama,
						'telp' 			=> $tel,
						'gender' 		=> $gen,
						'gb_user'		=> $av,
						);
					$this->users->savingDatawithoutpassword($data_user, $id);
					//echo "Jsg&5#833ndsfa3*5";
					$this->session->set_flashdata('berhasil', 'Data telah diubah');
					redirect($this->agent->referrer());

				}else if(!empty($pass11) && !empty($pass22) && $av != ""){
					unlink('qusour894/img/profile_image/'.$gb);
					$this->upload->do_upload('avatar');
					$this->upload->data();
					if(!empty($this->session->userdata('provider'))){
						$prov = "";
						$this->session->unset_userdata(array('sess_data' => 'provider'));
					}else{
						$prov = "";
					}
					//panggil protected function
	 				$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
					$iv_size = mcrypt_enc_get_iv_size($cipher);
 
					// Encrypt
					if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
					{
    					$encrypt_password = mcrypt_generic($cipher, $pass11);
    					mcrypt_generic_deinit($cipher);
					}
					// saving data dengan password
					$data_user = array(
						'provider_login'=> $prov,
						'email' 		=> $email,
						'password'		=> bin2hex($encrypt_password),
						'nama_lengkap' 	=> $nama,
						'telp' 			=> $tel,
						'gender' 		=> $gen,
						'gb_user'		=> $av,
						);
					$this->users->savingDatawithpassword($data_user, $id);
					//echo "JPhddgPswChgaeU";\
					$this->session->set_flashdata('berhasil', 'Data telah diubah');
					redirect($this->agent->referrer());
				}else if(!empty($pass11) && !empty($pass22) && $av == ""){
					//panggil protected function
	 				$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
					$iv_size = mcrypt_enc_get_iv_size($cipher);
 
					// Encrypt
					if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
					{
    					$encrypt_password = mcrypt_generic($cipher, $pass11);
    					mcrypt_generic_deinit($cipher);
					}
					// saving data dengan password
					$data_user = array(
						'email' 		=> $email,
						'password'		=> bin2hex($encrypt_password),
						'nama_lengkap' 	=> $nama,
						'telp' 			=> $tel,
						'gender' 		=> $gen,
						);
					$this->users->savingDatawithpassword($data_user, $id);
					//echo "JPhddgPswChgaeU";\
					$this->session->set_flashdata('berhasil', 'Data telah diubah');
					redirect($this->agent->referrer());
				}
			}
		}
	}

	function detailIn($id){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$ins = base64_decode($id);
			$b = $this->encrypt->decode($ins);

			//get data invoice
			$gdata = $this->users->checkingInv($b);
			//get order berdasarkan invoice
			$gorder = $this->users->checkingdataorder($b);
			// get data bank from id network invoice
			$codeBank = $this->users->checkingdataBank($b);
			foreach($codeBank as $as){
				$idbnk = $as->bank_pembayaran;
			}
			// payment info toko
			$this->load->model('checkout_model');
			$bnkm =  $this->checkout_model->selectInfbnk($idbnk);

			$data['title'] = "<title>Detail Invoice</title>";
			$data['meta_desc'] = "<meta name='description' content='Detail order pesanan' />";
			$data['meta_key'] = "<meta name='keywords' content='detail pesanan'/>";
			$data['detail_inv'] = $gdata;
			$data['detail_order'] = $gorder;
			$data['bnkInfo'] = $bnkm;
			$data['code_net_bank'] = $codeBank;
			$data['idUriinv'] = $b;
			$this->load->view('theme/v1/header',$data);
			$this->load->view('theme/v1/detail_invoice');
			$this->load->view('theme/v1/footer');
		}
	}

	function cetakInv($id){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{

			//$this->load->library('dompdf_gen');
			$ins = base64_decode($id);
			$b = $this->encrypt->decode($ins);

			//get data invoice
			$gdata = $this->users->checkingInv($b);
			foreach($gdata as $y){
				$inv = $y->invoice;
			}
			//get order berdasarkan invoice
			$gorder = $this->users->checkingdataorder($b);
			
			// get data bank from id network invoice
			//$codeBank = $this->users->checkingdataBank($b);
			//foreach($codeBank as $as){
			//	$idbnk = $as->bank_pembayaran;
			//}

			// payment info toko
			//$this->load->model('checkout_model');
			//$bnkm =  $this->checkout_model->selectInfbnk($idbnk);
			$data['qrinvoice'] = $inv;
			$data['detail_inv'] = $gdata;
			$data['detail_order'] = $gorder;
			//$data['bnkInfo'] = $bnkm;
			//$data['code_net_bank'] = $codeBank;
			$data['title'] = 'Cetak Invoice '.$inv.''; //judul title\
			
	 		//send data[''] to view
	        $this->load->view('laporan_pdf/lap_inv_order_customer_default', $data);
	        //$paper_size  = 'A4'; //paper size
	        //$orientation = 'potrait'; //tipe format kertas
	        //$html = $this->output->get_output();
	 
	        //$this->dompdf->set_paper($paper_size, $orientation);
	        //Convert to PDF
	        //$this->dompdf->set_base_path('qusour894/css');
	        //$this->dompdf->load_html($html);
	        //$this->dompdf->render();
	        
	        //$this->dompdf->set_base_path($css);
	        //$this->dompdf->stream("Invoice-penjualan.pdf", array('Attachment'=>0));
	        //exit(0);
	    }
	}
 
	function ajukan_retur(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$ins = base64_decode($this->input->post('SukeyRet'));
			$b = $this->encrypt->decode($ins);

			if($b != "LjgteRet_insialIsg36$4"){
				//SAVING DATA HACKER
				$aktifitas = "memecahkan kode enkripsi untuk akses retur produk dari akun pelanggan";
				$this->users->savingHack($aktifitas);
				//redirect(base_url()); 
			}else{

				$inso = base64_decode($this->input->post('insInvRelog'));
				$idorder4 = $this->encrypt->decode($inso);
				$idorder1 = $this->security->xss_clean($idorder4);
				$idorder2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$idorder1);
				$idorder3 = strip_tags($idorder2);
				$idorder = htmlentities($idorder3);

				$produk = $this->security->xss_clean($this->input->post('pro_retur'));
				$email = $this->security->xss_clean($this->input->post('ml'));
				$mlx = base64_decode($email);
				$ml = $this->encrypt->decode($mlx);	

				$alasan1 = $this->security->xss_clean($this->input->post('rincianretur'));
				$alasan2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$alasan1);
				$alasan3 = strip_tags($alasan2);
				$alasan = htmlentities($alasan3);

				$this->form_validation->set_rules('pro_retur[]','Produk retur', 'required');
				$this->form_validation->set_rules('rincianretur','Alasan Retur', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('error', 'Isi form dengan lengkap');
					redirect($this->agent->referrer());
				}else{

					//insert data produk ke table retur	
					$id_pelanggan = $this->data['id'];

					//generate retur number
					$awal = "STR";
					$length =5;
					$random= "";
					srand((double)microtime()*1000000);
		 
					$data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
					$data .= "1234567890";
		 
					for($i = 0; $i < $length; $i++){
						$random .= substr($data, (rand()%(strlen($data))), 1);
					}

					$retNumber = $awal.$random.$id_pelanggan;						

					$count = count($produk);
			        for($i=0; $i<$count; $i++) {

			                $data_retur = array(
			                	'id_retur_produk'   			=> $retNumber,
			                	'id_invoicepro'   				=> $idorder,
			                    'id_produk_from_order_produk'	=> $produk[$i],
			                );
			            //print_r($data_retur);
			            $this->users->dataprodukretur($data_retur);
			        }

			        // EMAIL 
					$data_cs = "Terima kasih telah mengajukan retur. nomor retur anda ".$retNumber.". sedang kami cek terlebih dahulu. untuk status terbaru bisa anda cek di menu daftar retur.<br><br>Best Regards<br>Stars ";
					$config = Array(
						'mailtype'  => 'html', 
					);
					
					$this->email->initialize($config);
			      	$this->email->from('noreply@starsstore.id'); // change it to yours
			      	$this->email->to($ml);// change it to yours
			      	$this->email->subject('Starsstore - Retur #'.$retNumber.'');
			      	$this->email->message($data_cs);
			      	$this->email->send();

			        // insert data retur
			       $this->users->informasi_retur_pelanggan($id_pelanggan,$retNumber, $idorder, $alasan);
			       $this->session->set_flashdata('berhasil', 'Nomor retur anda #'.$retNumber.' silahkan cek dimenu <a href="../../retur" style="font-weight:bold;color:green;">daftar retur</a>');
			       redirect(base_url('customer/riwayat-pesanan'));
		    	}
			}
		}
	}

	function detailInAndRetur($idinvforretur){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$ins = base64_decode($idinvforretur);
			$b = $this->encrypt->decode($ins);	

			// cek apakah sudah pernah mengajukan retur sebelumnya
			$cekid = $this->users->cekidretur($b);

			if($cekid->num_rows() > 0){
				
				$this->session->set_flashdata('error', 'Nomor Invoice sudah pernah diajukan retur');
				redirect(base_url('customer/riwayat-pesanan'));

			}else{

				//get order berdasarkan invoice
				$gorder = $this->users->checkingdataorder($b);

				$data['title'] = "<title>Retur Produk</title>";
				$data['meta_desc'] = "<meta name='description' content='retur produk' />";
				$data['meta_key'] = "<meta name='keywords' content='retur produk'/>";
				$data['inv'] = $b;
				$data['detail_order'] = $gorder;
				$this->load->view('theme/v1/header',$data);
				$this->load->view('theme/v1/retur');
				$this->load->view('theme/v1/footer');

			}
		}
	}

	function riwayatOrder(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$id_clas_us = $this->data['id'];
			$data['title'] = "<title>Riwayat Pesanan</title>";
			$data['meta_desc'] = "<meta name='description' content='Riwayat pesanan' />";
			$data['meta_key'] = "<meta name='keywords' content='Riwayat pesanan'/>";
			$data['list_order'] = $this->users->listPesanan($id_clas_us);
			$this->load->view('theme/v1/header',$data);
			$this->load->view('theme/v1/riwayat_pesanan');
			$this->load->view('theme/v1/footer');
		}
	}

	function add_wishlist($id){

		$id_cus = $this->data['id'];
		$ins = base64_decode($id);
		$b = $this->encrypt->decode($ins);
		if(empty($id_cus)){
			$this->session->set_flashdata('error','Silahkan login terlebih dahulu');
			redirect(base_url('login-pelanggan'));
		}else{
			// cek double apa tidak
			$id_user = $this->data['id'];
			$cek_w = $this->users->cek_double($b, $id_user);
			if($cek_w->num_rows() > 0){
				$this->session->set_flashdata('berhasil','Produk sudah ada di <a style="color:green !Important;" href="'.base_url('customer/favorit').'"><b>wishlist</b></a> anda');
				redirect($this->agent->referrer());
			}else{
				$data_w = array(
					'id_customer'	=> $this->data['id'],
					'id_produk'		=> $b,
					);
				$this->users->add_to_wishlist($data_w);
				$this->session->set_flashdata('berhasil','Produk telah ditambahkan ke <a style="color:green !Important;" href="'.base_url('customer/favorit').'"><b>wishlist</b></a>');
				redirect($this->agent->referrer());
			}
		}
	}
	function hapus_w($id){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Silahkan Login Untuk Melanjutkan');
			redirect('login-pelanggan');	
		}else{
			$ins = base64_decode($id);
			$b = $this->encrypt->decode($ins);
			$idcs = $this->data['id'];
			$this->users->hapus_wishlist($b,$idcs);
			redirect(base_url('customer/favorit/'));
		}
	}

	function member(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
			$this->session->set_flashdata('error', 'Anda sudah login');
			redirect('login-pelanggan');	
		}else{
			$data['title'] = "<title>Riwayat Pesanan</title>";
			$data['meta_desc'] = "<meta name='description' content='Riwayat pesanan' />";
			$data['meta_key'] = "<meta name='keywords' content='Riwayat pesanan'/>";

			$iduser = $this->session->userdata('id');
			$d['r'] = $this->users->get_data_customer($iduser);
			if($d['r']['kode_member'] == ""){
				// jika kode member belum ada, generatekan 10 digit
				//generate code unique
				$length = 10;
				$uniqq	= "";
				srand((double)microtime()*1000000);
				$data2 	= "1234567890";
				for($i = 0; $i < $length; $i++){
					$uniqq .= substr($data2, (rand()%(strlen($data2))), 1);
				}
				$code_uk['unik'] = $uniqq;

				$kode_member = array(
					'kode_member' => $uniqq,
				);
				$this->db->where('id', $iduser);
				$this->db->update('customer',$kode_member);

				$d['kode'] = $uniqq;
			}else{
				$d['kode'] = $d['r']['kode_member'];
			}
			$this->load->view('theme/v1/header',$data);
			$this->load->view('theme/v1/member',$d);
			$this->load->view('theme/v1/footer');
		}
	}

	function barcode($kode){
		$this->load->library('zend');
		//load yang ada di folder Zend
		$this->zend->load('Zend/Barcode');
		//generate barcode
		Zend_Barcode::render('code39', 'image', array('text'=>$kode), array());
	}
}