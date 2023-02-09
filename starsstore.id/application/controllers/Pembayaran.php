<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

	protected $key = 'LAJ391BD01N10DN37403NC62NXKSST28';
	protected $iv =  '01M364BS721X365MXMGW036C5N24931N';

	function __construct(){
		parent::__construct();
		$this->load->library(array('form_validation','encrypt')); //'veritrans','midtrans'
		$this->load->model(array('checkout_model','users'));
		$this->load->library('email');
		$this->session->unset_userdata('check_success');
		//$params = array('server_key' => 'SB-Mid-server-6cQ7lEBgacSGPm0nu386y8oG', 'production' => false);
		//$this->veritrans->config($params);
		$this->load->helper('url');
		$this->data['mail_encrypt'] = $this->session->userdata('mail_encrypt');
		//generate code unique
		$length =2;
		$uniqq= "";
		srand((double)microtime()*1000000);
		$data2 = "1234567890";

		for($i = 0; $i < $length; $i++){
			$uniqq .= substr($data2, (rand()%(strlen($data2))), 1);
		}
		$code_uk['unik'] = $uniqq;
		$this->session->set_userdata($code_uk);

		$get_data_set = toko_libur();
		if($get_data_set['aktif'] == "on"){
			redirect(base_url('toko-libur'));
		}
		// cek cookie - GET
	    $cookie = get_cookie('Bismillahirrohmanirrohim');
	    if($cookie != ""){
	    	if($this->session->userdata('log_access') == ""){ //jika session login tidak ada maka dibuatkan login otomatis
	    		// cek cookie jika ada cookies dibrowser maka buatkan session user otomatis
		        $cek = $this->users->get_by_cookie($cookie);
		        foreach($cek->result() as $data){
		        	$email = $data->email;
		        	$sess_user['id']					= $data->id;
		            $sess_user['last_login']            = $data->last_login;
		            $sess_user['log_access'] 			= "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";
		            $this->session->set_userdata($sess_user);
		            $this->users->updateLastloginCustomer($data->id);
		            $this->users->saving_ipdevicebrowser($data->id, $email);
		        }
	    	}
	    }
	}

	function checkout($id){
		$id1 = base64_decode($id);
		$id2 = $this->encrypt->decode($id1);
		if($id2 != "*J72Hy390_2*"){
			$this->session->set_flashdata('error','URL tidak sah.');
			redirect(base_url('cart'));
		}else if(!$this->cart->contents()){
			$this->session->set_flashdata('error','Keranjang belanja masih kosong');
			redirect(base_url('cart'));
		}else{

			// calculate berat dan point produk 
			$sum = 0;
			$t_point = 0;
			foreach($this->cart->contents() as $items){
				$id 	= $items['id']; 
				$jml 	= $items['qty'];
				$berat  = $items['berat'];
				$point 	= $items['point'];

				$total = array(
					'total_beratnya' => $jml*$berat,
					'total_point'	=> $point*$jml, 
					);
				$sum += $total['total_beratnya'];
				$t_point += $total['total_point'];
			}
			$data_point['totalPoint'] = $t_point;
			$this->session->set_userdata($data_point); 

			//load daftar bank
			//$loadBank = $this->checkout_model->load_bank_data();

			//ambil data info customer
			$iduser = $this->session->userdata('id');
			//if(!empty($iduser)){
			//	$data['cs'] = $this->users->get_data_customer($iduser);
				//$data['address'] = $this->users->get_data_alamat_customer($iduser); // tidak dipakai
			//}else{
				$data['cs'] = $this->users->get_data_customer($iduser);
			//}
			
			$data['voucher'] = "";
			$data['loadBn'] = $this->checkout_model->load_bank_data();
			$data['total_berat'] = $sum;
			$data['title'] = "<title>Selesaikan Pesanan</title>";
			$data['meta_desc'] = "<meta name='description' content='payment checkout' />";
			$data['meta_key'] = "<meta name='keywords' content='payment checkout, pembayaran,'/>";
			$this->load->view('theme/v1/header',$data);
			$this->load->view('theme/v1/checkoutFull', $data);
			$this->load->view('theme/v1/footer');
		}
	}

	function getTotal(){
		$ongkir = $this->security->xss_clean($this->input->get('p'));
		$grandtotal = $this->security->xss_clean($this->input->get('g'));

		echo number_format($grandtotal+$ongkir,0,".",".");
	}

	function pilihKota($province){	
		$curl = curl_init();
		$proxy = '192.168.0.219:80';
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=$province",
		  //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 100,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "key: 8e7d9a6d463e525fc266871130a04f88"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  //echo $response;
			$data = json_decode($response, true);
		  //echo json_encode($k['rajaongkir']['results']);
		  echo "<option value=''>Pilih Kota</option>";  
		  for ($j=0; $j < count($data['rajaongkir']['results']); $j++){
		    //echo "<option value='".$data['rajaongkir']['results'][$j]['city_id']."|".$data['rajaongkir']['results'][$j]['city_name']."'>".$data['rajaongkir']['results'][$j]['city_name']."</option>";

		    echo "<option value='".$data['rajaongkir']['results'][$j]['city_id']."|".$data['rajaongkir']['results'][$j]['city_name']."'>".$data['rajaongkir']['results'][$j]['city_name']."</option>";
		  
		  }
		}
	}

	function login_order(){
		$ins = base64_decode($this->input->post('gexf'));
		$b = $this->encrypt->decode($ins);

			if($b != "W!83^72g*%@_02=nKg"){
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
							$sess_data['provider']		= $data->provider_login;

							$this->session->set_userdata($sess_data);
							$this->users->updateLastloginCustomer($data->id);
							$this->users->saving_ipdevicebrowser($data->id,$email);
						}
							echo "+8(98*&$2.,asdJT14(*621=_0";
					}else if($cek->num_rows() == 0){
						echo ")72*h39Bvsk%52)&1->371";
					}
					
				}else{
					echo ".Jgy&%761(825@1_+934<h;'";
					//SAVING DATA HACKER
					$aktifitas = "memecahkan kode untuk mengakali form validasi di login order";
					$this->users->savingHack($aktifitas);
				}
			}
	}

//FUNCTION CONFIM_ORDER HINGGA FUNCTION SUCCESS TERAKHIR DIBACKUP DI MODEL CHECKOUTXXX.PHP

	function confirm_order(){ //$initial

/////////////////////////////// FORM //////////////////////////////////////////////////////////////

		$ver1 = $this->security->xss_clean($this->input->post('ex__randVer'));
		$ver2 = base64_decode($ver1);
		$verify = $this->encrypt->decode($ver2);

		$nm1 = $this->security->xss_clean($this->input->post('nm_customer'));
		$nm2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nm1);
		$nm3 = strip_tags($nm2);
		$nama = htmlentities($nm3);

		$mail1 = $this->security->xss_clean($this->input->post('ml_customer'));
		$mail2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$mail1);
		$mail3 = strip_tags($mail2);
		$email = htmlentities($mail3);

		$tl1 = $this->security->xss_clean($this->input->post('tl_customer'));
		$tl2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$tl1);
		$tl3 = strip_tags($tl2);
		$telp = htmlentities($tl3);

		$prov1 = $this->security->xss_clean($this->input->post('propinsi_tujuan'));
		$prov2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$prov1);
		$prov3 = strip_tags($prov2);
		$provx = htmlentities($prov3);

		$provxx = explode('|', $provx);
		$prov = $provxx[1];

		$city1 = $this->security->xss_clean($this->input->post('kota'));
		$city2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$city1);
		$city3 = strip_tags($city2);
		$cityx = htmlentities($city3);

		$cityxx = explode('|', $cityx);
		$city = $cityxx[1];

		$address1 = $this->security->xss_clean($this->input->post('alamat'));
		$address2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$address1);
		$address3 = strip_tags($address2);
		$address = htmlentities($address3);

		$kdp1 = $this->security->xss_clean($this->input->post('kdp_customer'));
		$kdp2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$kdp1);
		$kdp3 = strip_tags($kdp2);
		$kdp = htmlentities($kdp3);

		$note1 = $this->security->xss_clean($this->input->post('note_order'));
		$note2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$note1);
		$note3 = strip_tags($note2);
		$note = htmlentities($note3);

//// NOTE ORDER ////
		if($note == ""){
   			$note_ol = "-";
   		}else{
   			$note_ol = $note;
   		}
//// END NOTE ORDER ////

//// BERAT ////
		$total_berat1 = $this->security->xss_clean($this->input->post('lock_w'));
		$total_berat2 = str_replace("/<\/?()[^>]*><script></script>", "",$total_berat1);
		$total_berat3 = strip_tags($total_berat2);
		$total_berat4 = htmlentities($total_berat3);
		$b1 = base64_decode($total_berat4);
		$total_berat = $this->encrypt->decode($b1);	

		//$exp1 = $this->security->xss_clean($this->input->post('courier'));
		//$exp2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$exp1);
		//$exp3 = strip_tags($exp2);
		//$expedisi = htmlentities($exp3);
		$expedisi = "JNE";
//// END BERAT ////

//// PAYMENT ////
		$pay1 = $this->security->xss_clean($this->input->post('payment'));
		$pay2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$pay1);
		$pay3 = strip_tags($pay2);
		$pay4 = htmlentities($pay3);

		$pay5 = base64_decode($pay4);
		$payment = $this->encrypt->decode($pay5);
//// END PAYMENT ////

/////////////////////////////////////////////// END FORM //////////////////////////////////////////////////////////////////

//////////////////////////////////////////// INIALISASI GLOBAL ////////////////////////////////////////////////////////////

		if($verify != "Verify_order_withSecuresystem"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses checkout order";
			$this->users->savingHack($aktifitas);
			redirect($this->agent->referrer()); 
		}else{

			$this->form_validation->set_rules('nm_customer', 'Nama Pelanggan', 'required|xss_clean');
			$this->form_validation->set_rules('ml_customer', 'Email', 'required|xss_clean');
			$this->form_validation->set_rules('tl_customer', 'Telepon', 'required|xss_clean');
			$this->form_validation->set_rules('alamat', 'Alamat Toko', 'required|xss_clean');
			$this->form_validation->set_rules('propinsi_tujuan', 'Provinsi', 'required|xss_clean');
			$this->form_validation->set_rules('kota', 'Kota', 'required|xss_clean'); 
			$this->form_validation->set_rules('alamat', 'Alamat', 'required|xss_clean');
			$this->form_validation->set_rules('payment', 'Metode Pembayaran', 'required|xss_clean');
			$this->form_validation->set_rules('checkshipping', 'Tarif', 'required|xss_clean');
			$this->form_validation->set_rules('aggre', 'Syarat dan ketentuan', 'required|xss_clean');

			// VALIDASI FORM IS EMPTY
			if($this->form_validation->run() == FALSE ){
				$this->session->set_flashdata('error', ''.validation_errors().'');
				redirect($this->agent->referrer());
			}else{

				//(UPDATE TERBARU, CENTANG BUAT AKUN SEKALIGUS DITIADAKAN. DAN LANGSUNG PENGECEKKAN JIKA EMAIL SUDAH TERDAFTAR MAKA OTOMATIS LOGIN, JIKA EMAIL BLM TERDAFTAR MAKA OTOMATIS DIBUATKAN AKUN)
				$idsescus = $this->session->userdata('log_access');
				if(empty($idsescus)){ // jika session login kosong maka cek email apa sudah jadi member apa belum

					// cek dulu apakah email yang didaftarkan sudah terdaftar disistem
					$mailCek = $this->users->cek_email($email);
					if($mailCek->num_rows() == 0){ // jika email tidak ditemukan maka daftarkan

						//panggil protected function
		 				$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
						$iv_size = mcrypt_enc_get_iv_size($cipher);

						// Encrypt
						if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
						{
							$encrypt_default_rand = mcrypt_generic($cipher, $telp);
							mcrypt_generic_deinit($cipher);
						}

						// Encrypt
						if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
						{
							$mail_encrypt = mcrypt_generic($cipher, $email);
							mcrypt_generic_deinit($cipher);
						}
						
						// data user
						$data_user = array(
							'email'			=> $email,
							'email_encrypt' => bin2hex($mail_encrypt),
							'password' 		=> bin2hex($encrypt_default_rand),
							'nama_lengkap'	=> $nama,
							'telp'			=> $telp,
							'status'		=> 'a@kti76f0',
							'level'			=> 'regcusok4*##@!9))921',
							'akses'			=> '9x4$58&(3*+', 
							'created'		=> date('Y-m-d H:i:s'),
							'ip_register_first'	=> $this->input->ip_address(),
							'baca'			=> 'belum',
						);
						$this->users->reg_new_data_customer($data_user); // SIMPAN USER

						$cek = $this->users->validasi_data($email, bin2hex($encrypt_default_rand));
						foreach($cek->result() as $s){
							$sess_data['id']				= $s->id;
							$sess_data['mail_encrypt']      = $s->email_encrypt;
							$sess_data['last_login']    	= $s->last_login;
							$sess_data['log_access']    	= "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";
							$this->session->set_userdata($sess_data);
							$this->users->updateLastloginCustomer($s->id);
							$this->users->saving_ipdevicebrowser($s->id,$email);
						}
						$id = $sess_data['id'];//$this->session->userdata('id_cs');

						// kirim email informasi akun ke customer
						$data_cs = array(
							'nakap' => $nama,
							'info'	=> "Akun anda :<br>Email : <b>".$email."</b><br>Password : <b>".$telp."</b><br> Silahkan ubah password anda demi keamanan. Nikmati kemudahan berbelanja dan banyak promo untuk anda."
						);

						$config = Array(
							'mailtype'  => 'html', 
						);

						$this->load->library('parser');
		        		$this->email->initialize($config);
		      			$this->email->from('noreply@starsstore.id');
		      			$this->email->to($email);
		      			$this->email->subject('Pendaftaran Berhasil');
		      			$body = $this->parser->parse('em_info_notification_group/f_cus_mail_reg_with_checkout',$data_cs,TRUE);
		      			$this->email->message($body);
		      			$this->email->send();

					}else{ // jika email sudah terdaftar LOGIN OTOMATIS

						$cek = $this->checkout_model->validasi_data_login($email);
						foreach($cek->result() as $data){
							$sess_data['id']        	 = $data->id;
							$sess_data['mail_encrypt']  = $data->email_encrypt;
							$sess_data['last_login']    = $data->last_login;
							$sess_data['log_access']    = "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"; 
							$sess_data['provider']		= $data->provider_login;
							$this->session->set_userdata($sess_data);
							$this->users->updateLastloginCustomer($data->id);
							$this->users->saving_ipdevicebrowser($data->id,$email);
						}
						$id = $sess_data['id'];//$this->session->userdata('id_cs');
					}

				}else if(!empty($idsescus)) { // jika session ada maka ambil ID
						$id = $this->session->userdata('id');
				}

				//// PROMO ONGKIR ATAU TIDAK ///////////////////////////////////////////////////////////////////////////////
				if($this->session->userdata("type") == "ongkir_apply"){
					// gratis ongkir bisanya pilih expedisi, tapi kalau pilih sub expedisi (REG, OKE, DLL) tidak diijinkan. karena ujung2nya REGULER yang dipakai xixixi
					$resex = "0";
					$layanan = strtoupper($expedisi);
					$etd 	= "3-4 Hari";
					$tarif 	= 0;
				}else{
					$resex1 = $this->security->xss_clean($this->input->post('checkshipping'));
					$resex2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$resex1);
					$resex3 = strip_tags($resex2);
					$resex = htmlentities($resex3);

					$exp = explode('|', $resex);
					$layanan = $exp[0];
					$etd 	 = $exp[1];
					$tarifxx = $exp[2];

					$tarifx = base64_decode($tarifxx);
					$tarif = $this->encrypt->decode($tarifx);
				}

				//// GENERATE INVOICE ///////////////////////////////////////////////////////////////////////////////////
				$length 	= 5;
				$randomx 	= "";
				srand((double)microtime()*1000000);
				$data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
				$data .= "1234567890";
				for($i = 0; $i < $length; $i++){
					$randomx .= substr($data, (rand()%(strlen($data))), 1);
				}
				// AWALAN INVOICE
				$utama = "ST";
				// ID CUSTOMER $id;

				// TANGGAL
				$tgl_text = date('D');
				$tgl = date('d', strtotime($tgl_text));
				// BULAN
				$bln_text = date('M');
				$bln = date('m', strtotime($bln_text));
				// TAHUN
				$year  = date('y');	
				// RESULT INVOICE
				$invoicex = $utama.$id.$randomx.$tgl.$bln.$year;

				//// GRAND TOTAL /////////////////////////////////////////////////////////////////////////////////////
				if($this->session->userdata('type') == "disc_apply"){
					// TOTAL - (TOTAL * DISKON / 100) + //KODE UNIK + PENGIRIMAN
					//$grandTotal = $this->cart->total() - ($this->cart->total() * $this->session->userdata('action') / 100) + $tarif; //+ $this->session->userdata('unik')
					$grandTotal = ($this->cart->total() - $this->session->userdata('action')) + $tarif; //+ $this->session->userdata('unik')
				}else if($this->session->userdata("type") == "ongkir_apply"){
					// TOTAL + //KODE UNIK 
					$grandTotal = $this->cart->total(); // + $this->session->userdata('unik');
				}else{
					// TOTAL + //KODE UNIK + PENGIRIMAN 
					$grandTotal = $this->cart->total() + $tarif;//+ $this->session->userdata('unik');
				}
				//// END GRAND TOTAL /////////////////////////////////////////////////////////////////////////////////

				$date_maju = date('Y-m-d H:i:s', strtotime('3 hours'));

				// FUNGSI INI ADALAH UNTUK MEMBEDAKAN VAR RANDOM INVOICE, KALAU BANK TRANSFER DAN KARTU KREDIT RANDOM INVOICENYA LANGSUNG GENERATE, TAPI JIKA MELALUI MULTIPLE CHANNEL RANDOM INVOICE DIDAPAT DARI SESSION (GENERATE DARI HALAMAN CHECKOUT)

// ATURAN BARU 14 MARET 2020 PAYMENT FUNCTION DIPECAH MENJADI 2 FUNCTION (1. PAYMENT STARS, 2. PAYMENT MIDTRANS)

				if($payment == "bank_t_ransfer"){ // BANK TRANSFER VIA PAYMENT STARS
					$random = $randomx;
					$method = "transfer";
					$invoice = $invoicex;
					$this->payment_with_stars($nama,$telp,$email,$random,$invoice,$id,$note_ol,$grandTotal,$total_berat,$date_maju,$address,$city,$prov,$layanan,$etd,$tarif,$kdp,$method);
				}else{ // MIDTRANS
					$random = $this->session->userdata('random');
					$method = "multiple_payment_channel";
					$invoice = $this->session->userdata('invoice');
					$this->payment_with_midtrans($nama,$telp,$email,$random,$invoice,$id,$note_ol,$grandTotal,$total_berat,$date_maju,$address,$city,$prov,$layanan,$etd,$tarif,$kdp,$method);
				}

////////////////////////////////////// END INIALISASI GLOBAL ////////////////////////////////////////////// 

			}
		}
	}

	function payment_with_stars($nama,$telp,$email,$random,$invoice,$id,$note_ol,$grandTotal,$total_berat,$date_maju,$address,$city,$prov,$layanan,$etd,$tarif,$kdp,$method){

		/// KURANGI STOK ///
		foreach($this->cart->contents() as $item) {
		 	$kat_id = $item['id'];
		 	$idc    = $item['optidcolor'];
		 	$idsz   = $item['optidsize'];

		    $get_data_pro_id = $this->checkout_model->get_id_data($kat_id, $idc, $idsz);
		    foreach($get_data_pro_id as $gy){
		    	//kurangi stok berdasarkan warna dan size, meski size / warna berbeda, dan id produk sama dapat dibedakan dan dikurangi karena memakai where yang tepat ().
		    	$data_stok_pro = array(
		            'id_produk_optional'=> $gy->id_produk_optional,
		            'id_opsi_get_color' => $gy->id_opsi_get_color,
		            'id_opsi_get_size' 	=> $gy->id_opsi_get_size,
		            'stok'  			=> $gy->stok - $item['qty'],
		    	);
		    		$id_pr 		= $gy->id_produk_optional;
		            $idcolor 	= $gy->id_opsi_get_color;
		            $idsize 	= $gy->id_opsi_get_size;
		    	// mulai pengurangan stok disini
		    	$this->checkout_model->kurangi_stok($data_stok_pro, $id_pr, $idcolor, $idsize);
		    }
		}
		//// END KURANGI STOK ///

		//// SIMPAN DATA PESANAN //////////////////////////////////////////////////////////////////////////
		$data_customer = array(
			'nama_lengkap'		=> $nama,
			'no_telp'			=> $telp,
			'email'				=> $email,
			'buy_in'			=> 'E-commerce',
			'no_order_cus'		=> $random,
			'invoice'			=> $invoice,
			'id_customer'		=> $id,
			'catatan_pembelian' => $note_ol,
			'kode_pembayaran'	=> 0,//$this->session->userdata('unik'), // tidak pakai kode unik
			'subtotal'			=> $this->cart->total(),
			'total_belanja'		=> $grandTotal, 
			'total_berat'		=> $total_berat/1000,
			'tanggal_waktu_order'=> date('Y-m-d H:i:s'),
			'tanggal_order'		=> date('Y-m-d'),
			'tanggal_jatuh_tempo'=> $date_maju,
			'jenis_pembayaran'	=> $method,
			//'bank_pembayaran'	=> $bnk,
			'status'			=> '2hd8jPl613!2_^5',
			'dibayar'			=> 'belum',
			'ip'				=> $this->input->ip_address(),
			'browser'			=> $this->agent->browser(),
			'platform'			=> $this->agent->platform(),
			'baca'				=> 'belum',
		);
		$this->checkout_model->saving_order_data_customer($data_customer);
		//print_r($data_customer).'<br><br>';

		//// SIMPAN DATA EXPEDISI ////////////////////////////////////////////////////////////////////
		$data_expedisi = array(
			'no_order_ex' => $random,
			'alamat'	=> $address.' '.$city.' '.$prov.' '.$kdp,
			'provinsi'  => $prov,
			'kota'		=> $city,
			'layanan' 	=> $layanan,
			'etd' 		=> $etd,
			'tarif'		=> $tarif,
		);
		$this->checkout_model->saving_expedition($data_expedisi);
		//print_r($data_expedisi).'<br><br>';

		//// JIKA PROMO TELAH DI APPPLY OLEH CUSTOMER, MAKA CEK & INPUT PROMONYA KE DATABASE /////////////./////////
		if($this->session->userdata("type") != ""){
			$kupon = $this->session->userdata('kupon');

			$cekuse = $this->checkout_model->cekmailusevoucher($kupon,$email);
			if($cekuse > 10){ 
				$this->session->set_flashdata('error', 'Anda telah menggunakan voucher ini sebelumnya');
				// UNSET VOUCHER
				$this->session->unset_userdata('kupon ');
				$this->session->unset_userdata('action');
				$this->session->unset_userdata('keterangan');
				$this->session->unset_userdata('type');
				$this->session->unset_userdata('valid');
				$this->session->unset_userdata('access');
				redirect($this->agent->referrer());

			}else{

				if($this->session->userdata("type") == "disc_apply"){
					//$action_voucherx = $this->session->userdata('action').'%';
					$action_voucherx = $this->session->userdata('action');
				}else{
					$action_voucherx = $this->session->userdata('action');
				}
				// saving customer order with voucher
				$data_customer_with_voucher = array( 
					'no_order_vou'	=> $random,
					'id_customer'	=> $id,
					'voucher'		=> $this->session->userdata('kupon'),
					'action_voucher'=> $this->session->userdata('action'),
					'date_filter'	=> date('Y-m-d'),
					'date_use_voucher'	=> date('Y-m-d H:i:s'),
				);
				$this->checkout_model->savingCustomerwithvoucher($data_customer_with_voucher);
				
				// ambil stok voucher
				$voucher = $this->session->userdata('kupon');
				$stokvc = $this->checkout_model->ambil_quantity_voucher($voucher);
				$qty_total = $stokvc->qty;
				// kurangi stok voucher
				$this->checkout_model->kurangi_quantity_voucher($voucher, $qty_total);

				// tambahkan ke voucher digunakan oleh email customer [table voucher_use]
				$data_voucheruse = array(
					'id_customer'	=> $id,
					'emailuse'		=> $email,
					'voucher'		=> $this->session->userdata('kupon'),
					'qty'			=> 1,
					'date_use'		=> date('Y-m-d H:i:s'),
				);
				$this->checkout_model->savingvoucheruse($data_voucheruse);						
			}
		}

		//// SAVING ORDER /////////////////////////////////////////////////////////////////////////////////
		foreach ($this->cart->contents() as $item){
			if($item['before'] == 0){
				$harga_before = "";
			}else{
				$harga_before = $item['before'];
			}
			$harga_after = $item['price'];
			
			foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
				if(empty($option_value)){
					$option_size = "";
					$option_color = "";
				}else{
					$option = $item['options'];
					$option_size = $option['Size'];
					$option_color =  $option['Warna'];
				}
			}

			$data_order[] = array(
	  			'no_order_pro' 	=> $random,
	  			'id_produk'		=> $item['id'],
	  			'nama_produk' 	=> $item['name'],
	  			//'kategori_divisi' => $item['gender'],
	  			'gambar'		=> $item['image'],
	  			'artikel'		=> $item['artikel'],
	  			'merk'			=> $item['merk'],
	  			'point'			=> $item['point'],
	  			'diskon'		=> $item['diskon'],
	  			'ukuran' 		=> $option_size,
	  			'warna'			=> $option_color,
	  			'qty' 			=> $item['qty'],
	  			'harga_fix'		=> $harga_after,
	  			'harga_before'  => $harga_before,    
	  			//'subtotal'		=> $item['subtotal'],
	  			'berat' 		=> $item['berat'],
			);
		} 
		$this->checkout_model->saving_order($data_order);
		//print_r($data_order).'<br><br>';

		// EMAIL KE CUSTOMER
		$this->mailTocustomer($email,$nama,$note_ol,$telp,$method,$invoice,$date_maju,$grandTotal);	

		// EMAIL KE ADMIN DAN AKAN DIAKHIR DI FUNCTION INI //
		$this->mailToadmin($email,$nama,$telp,$method,$invoice,$date_maju,$grandTotal);

		// END ORDER TRANSACTION //
	}

	function payment_with_midtrans($nama,$telp,$email,$random,$invoice,$id,$note_ol,$grandTotal,$total_berat,$date_maju,$address,$city,$prov,$layanan,$etd,$tarif,$kdp,$method){

		/// KURANGI STOK ///
		foreach($this->cart->contents() as $item) {
		 	$kat_id = $item['id'];
		 	$idc    = $item['optidcolor'];
		 	$idsz   = $item['optidsize'];

		    $get_data_pro_id = $this->checkout_model->get_id_data($kat_id, $idc, $idsz);
		    foreach($get_data_pro_id as $gy){
		    	//kurangi stok berdasarkan warna dan size, meski size / warna berbeda, dan id produk sama dapat dibedakan dan dikurangi karena memakai where yang tepat ().
		    	$data_stok_pro = array(
		            'id_produk_optional'=> $gy->id_produk_optional,
		            'id_opsi_get_color' => $gy->id_opsi_get_color,
		            'id_opsi_get_size' 	=> $gy->id_opsi_get_size,
		            'stok'  			=> $gy->stok - $item['qty'],
		    	);
		    		$id_pr 		= $gy->id_produk_optional;
		            $idcolor 	= $gy->id_opsi_get_color;
		            $idsize 	= $gy->id_opsi_get_size;
		    	// mulai pengurangan stok disini
		    	$this->checkout_model->kurangi_stok($data_stok_pro, $id_pr, $idcolor, $idsize);
		    }
		}
		//// END KURANGI STOK ///

		//// SIMPAN DATA PESANAN & KURANGI STOK  /////////////////////////////////////////////////////////

		$data_customer = array(
			'nama_lengkap'		=> $nama,
			'no_telp'			=> $telp,
			'email'				=> $email,
			'buy_in'			=> 'E-commerce',
			'no_order_cus'		=> $random,
			'invoice'			=> $invoice,
			'id_customer'		=> $id,
			'catatan_pembelian' => $note_ol,
			'kode_pembayaran'	=> 0,//$this->session->userdata('unik'), // tidak pakai kode unik
			'subtotal'			=> $this->cart->total(),
			'total_belanja'		=> $grandTotal, 
			'total_berat'		=> $total_berat/1000,
			'tanggal_waktu_order'=> date('Y-m-d H:i:s'),
			'tanggal_order'		=> date('Y-m-d'),
			'tanggal_jatuh_tempo'=> $date_maju,
			'jenis_pembayaran'	=> $method,
			//'bank_pembayaran'	=> '-',
			'status'			=> '2hd8jPl613!2_^5',
			'dibayar'			=> 'belum',
			'ip'				=> $this->input->ip_address(),
			'browser'			=> $this->agent->browser(),
			'platform'			=> $this->agent->platform(),
			'baca'				=> 'belum',
		);
		$this->checkout_model->saving_order_data_customer($data_customer);

		//// SIMPAN DATA EXPEDISI ////////////////////////////////////////////////////////////////////
		$data_expedisi = array(
			'no_order_ex' => $random,
			'alamat'	=> $address.' '.$city.' '.$prov.' '.$kdp,
			'provinsi'  => $prov,
			'kota'		=> $city,
			'layanan' 	=> $layanan,
			'etd' 		=> $etd,
			'tarif'		=> $tarif,
		);
		$this->checkout_model->saving_expedition($data_expedisi);

		//// JIKA PROMO TELAH DI APPPLY OLEH CUSTOMER, MAKA INPUT PROMONYA KE DATABASE /////////////./////////
		if($this->session->userdata("type") != ""){
			$kupon = $this->session->userdata('kupon');

			$cekuse = $this->checkout_model->cekmailusevoucher($kupon,$email);
			if($cekuse > 0){ // PROMO DAPAT DI APPLY PER USER 3X
				$this->session->set_flashdata('error', 'Anda telah menggunakan voucher ini sebelumnya');
				// UNSET VOUCHER
				$this->session->unset_userdata('kupon ');
				$this->session->unset_userdata('action');
				$this->session->unset_userdata('keterangan');
				$this->session->unset_userdata('type');
				$this->session->unset_userdata('valid');
				$this->session->unset_userdata('access');
				redirect($this->agent->referrer());

			}else{

				if($this->session->userdata("type") == "disc_apply"){
					$action_voucherx = $this->session->userdata('action').'%';
				}else{
					$action_voucherx = $this->session->userdata('action');
				}
				// saving customer order with voucher
				$data_customer_with_voucher = array( 
					'no_order_vou'	=> $random,
					'id_customer'	=> $id,
					'voucher'		=> $this->session->userdata('kupon'),
					'action_voucher'=> $this->session->userdata('action'),
					'date_filter'	=> date('Y-m-d'),
					'date_use_voucher'	=> date('Y-m-d H:i:s'),
				);
				$this->checkout_model->savingCustomerwithvoucher($data_customer_with_voucher);

				// tambahkan ke voucher digunakan oleh email customer [table voucher_use]
				$data_voucheruse = array(
					'id_customer'	=> $id,
					'emailuse'		=> $email,
					'voucher'		=> $this->session->userdata('kupon'),
					'qty'			=> 1,
					'date_use'		=> date('Y-m-d H:i:s'),
				);
				$this->checkout_model->savingvoucheruse($data_voucheruse);						
			}
		}

		//// SAVING ORDER /////////////////////////////////////////////////////////////////////////////////
		foreach ($this->cart->contents() as $item){
			if($item['before'] == 0){
				$harga_before = "";
			}else{
				$harga_before = $item['before'];
			}
			$harga_after = $item['price'];
			
			foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
				if(empty($option_value)){
					$option_size = "";
					$option_color = "";
				}else{
					$option = $item['options'];
					$option_size = $option['Size'];
					$option_color =  $option['Warna'];
				}
			}

			$data_order[] = array(
	  			'no_order_pro' 	=> $random,
	  			'id_produk'		=> $item['id'],
	  			'nama_produk' 	=> $item['name'],
	  			//'kategori_divisi' => $item['gender'],
	  			'gambar'		=> $item['image'],
	  			'artikel'		=> $item['artikel'],
	  			'merk'			=> $item['merk'],
	  			'point'			=> $item['point'],
	  			'diskon'		=> $item['diskon'],
	  			'ukuran' 		=> $option_size,
	  			'warna'			=> $option_color,
	  			'qty' 			=> $item['qty'],
	  			'harga_fix'		=> $harga_after,
	  			'harga_before'  => $harga_before,    
	  			//'subtotal'		=> $item['subtotal'],
	  			'berat' 		=> $item['berat'],
			);
		} 
		$this->checkout_model->saving_order($data_order);

		// EMAIL KE CUSTOMER
		$this->mailTocustomer($email,$nama,$note_ol,$telp,$method,$invoice,$date_maju,$grandTotal);	
		// EMAIL KE ADMIN DAN AKAN DIAKHIR DI FUNCTION INI //
		$this->mailToadmin($email,$nama,$telp,$method,$invoice,$date_maju,$grandTotal);
		// END ORDER TRANSACTION //
	}

	function mailTocustomer($email,$nama,$note_ol,$telp,$method,$invoice,$date_maju,$grandTotal){

	//function mailTocustomer(){

		//$email 	= "dan@asdas.com";
		//$nama 	= "danny";
		//$note_ol= "";
		//$telp 	= "0897238463";
		//$method = "transfer";
		//$invoice= "ST2368479274";
		//$date_maju = date("Y-m-d H:i:s");
		//$grandTotal = 150000;

		// LOAD METHOD DETAIL
		if($method == "transfer"){ // ubah $method
			$loaddatabank = $this->checkout_model->load_bank_data();
			foreach($loaddatabank as $y){
				$method_detail[] =  
					array(
						'nama_bank'		=> "Nama Bank : ".$y->name_bank."<br>",
						'cabang'		=> "Cabang : ".$y->bank_cabang."<br>",
						'a_n'			=> $y->a_n."<br>",
						'nomor'			=> "Nomor Rekening : ".$y->no_rek."<br><br>",
					);
				$instruksi = "Silahkan transfer pada salah satu nomor rekening berikut :<br><br>";
			}
		}else{
				$method_detail[] = 
						array(
							'nama_bank'		=> "", 
							'cabang'		=> "",
							'a_n'			=> "",
							'nomor'			=> "",
						);
				$instruksi = "Anda akan menerima email tentang pembayaran pesanan anda.";
		}

		$data_cs = array(
            'inv'      		=> $invoice,
            'tglOrdercs' 	=> date('d F Y H:i:s'),
            'tglExp'   		=> date('d F Y H:i:s', strtotime($date_maju)), //30 minutes
            'nmlkp'    		=> $nama,
            //'note' 	   		=> $note_ol,
            //'noTelp'   		=> $telp,
            'methode'  		=> $method,
            'instruksi' 	=> $instruksi,
            'methoddetail' 	=> $method_detail,
            'total_belanja' => number_format($grandTotal,0,".","."),
        );
      	$config = Array(
			'mailtype'  => 'html', 
		);
		
		$this->email->initialize($config); 
		//$this->load->library('parser');
      	$this->email->from('belanja@starsstore.id'); // change it to yours
      	$this->email->to($email);// change it to yours
      	$this->email->subject('Pesanan Anda di Starsstore.id #'.$invoice.'');
      	$body = $this->load->view('em_info_notification_group/f_cus_mail_order',$data_cs, TRUE);
      	$this->email->message($body);
      	$this->email->send();

	}

	function mailToadmin($email,$nama,$telp,$method,$invoice,$date_maju,$grandTotal){

	//function mailToadmin(){

		//$email 	= "dan@asdas.com";
		//$nama 	= "danny";
		//$note_ol= "";
		//$telp 	= "0897238463";
		//$method = "multiple_payment_channel";
		//$invoice= "ST2368479274";
		//$date_maju = date("Y-m-d H:i:s");
		//$grandTotal = 150000;

		// KELUARKAN DATA EMAIL ADMIN
		$dataadm = $this->checkout_model->keluarkan_dt_adm(); 
		foreach($dataadm->result() as $yp){
			if($yp->status == "e_admin"){
				$admmail = $yp->em_acc;
			}
		}	

		$data_cs = array(
            'inv'      => $invoice,
            'tglOrdercs' => date('d F Y H:i:s'),
            'tglExp'   => date('d F Y H:i:s', strtotime($date_maju)),
            'nmlkp'    => $nama,
            'noTelp'   => $telp,
            'methode'  => $method,
            'total_belanja' => number_format($grandTotal,0,".","."),
        );
      	$config = Array(
			'mailtype'  => 'html', 
		);
		
		$this->email->initialize($config);
		//$this->load->library('parser');
      	$this->email->from('noreply@starsstore.id'); // change it to yours
      	$this->email->to($admmail);// change it to yours
      	//$this->email->bcc();
      	$this->email->subject('Admin! Ada Pesanan Baru #'.$invoice.'');
      	$body = $this->load->view('em_info_notification_group/f_cus_mail_order_for_adm_manage',$data_cs, TRUE);
      	$this->email->message($body);
      	$this->email->send();

      	$infocs = $this->encrypt->encode($email.'|'.$nama.'|'.$method.'|'.$invoice.'|'.$date_maju.'|'.$grandTotal);
      	$this->success($infocs);
	}

	//function cek(){
	//	echo $this->encrypt->encode('dannysetyawan2@gmail.com|mochammad danny setyawan|transfer|ST6237643224|2020-03-15 15:19:00|150000');
	//}

	function unfinish(){
		$this->session->set_flashdata('error','Terjadi Kesalahan, Mohon ulangi kembali');
		redirect($this->agent->referrer());
	}

	function success($infocs){ //
		//$infocs = "cgkSMBgYOOK3kLDoGXbFjuFs2JgGpMDEcfvhV+R3IUAlbMfnlhnjSixlAtb4iJ5cyzD9udWSf5a5UbNTMhPgBLI9WoxOJE3rxkUEyiasgMq0F4osnV6zpbnXtpTByQc01OxHXS2mJwV+iKzFWyndGIusH0mMV7XY9JM5pYA/koDXQSEiaTjQuuyIMoEqs93S0uMz3nTWJ03V3bHy8bw2BQ==";
		$infocs1 = $this->encrypt->decode($infocs);
		$cs = explode('|', $infocs1);
		$email 		= $cs[0];
		$nama		= $cs[1];
		$method 	= $cs[2];
		$invoice 	= $cs[3];
		$date_maju 	= $cs[4];
		$grandTotal = $cs[5];

		if($method == "transfer"){ // ubah $method
			$loaddatabank = $this->checkout_model->load_bank_data();
			foreach($loaddatabank as $y){
				$method_detail[] =  
					array(
						'nama_bank'		=> "Nama Bank : ".$y->name_bank."<br>",
						'cabang'		=> "Cabang : ".$y->bank_cabang."<br>",
						'a_n'			=> $y->a_n."<br>",
						'nomor'			=> "Nomor Rekening : ".$y->no_rek."<br><br>",
					);
				$instruksi = "Silahkan transfer pada salah satu nomor rekening berikut :<br><br>";
			}
		}else{
				$method_detail[] = 
						array(
							'nama_bank'		=> "",
							'cabang'		=> "",
							'a_n'			=> "",
							'nomor'			=> "",
						);
				$instruksi = "Pembayaran anda akan terverifikasi otomatis. Anda akan menerima email tentang pembayaran pesanan anda.";
		}

		// Send Session Flashdata to Halaman Success | Jika tidak ada session halaman success tidak bisa diakses (diarahkan ke halaman keranjang belanja)
		$this->session->set_flashdata('notran',''.$invoice.'');
		$this->session->set_flashdata('email',''.$email.'');
		$this->session->set_flashdata('nama',''.$nama.'');
		$this->session->set_flashdata('totbel',''.$grandTotal.'');
		$this->session->set_flashdata('method',''.$method.'');
		$this->session->set_flashdata('instruksi',''.$instruksi.'');
		$this->session->set_flashdata('exp',''.$date_maju.'');

		//// DESTROY KUPON & CART /////	/////////////////////////////////////////////////////////////////////////
		//if($this->session->userdata('kupon') != ""){
			$this->session->unset_userdata('kupon');
			$this->session->unset_userdata('action');
			$this->session->unset_userdata('keterangan');
			$this->session->unset_userdata('type');
			$this->session->unset_userdata('valid'); 
			$this->session->unset_userdata('access');
		//}
		$this->session->unset_userdata('invoice');
		$this->session->unset_userdata('random');
      	$this->cart->destroy();
		$datatransfer['method_detail'] = $method_detail;
		//$info = array_merge($email,$nama,$method,$invoice,$date_maju,$grandTotal);
		$data['title'] = "<title>Pesanan Telah Dibuat</title>";
		$data['meta_desc'] = "<meta name='description' content='pesanan telah selesai dibuat' />";
		$data['meta_key'] = "<meta name='keywords' content='pesanan selesai'/>";
		$this->load->view('theme/v1/header', $data);
		$this->load->view('theme/v1/success',$datatransfer); //$info
		$this->load->view('theme/v1/footer');
	}

	//function test_mail(){
	//	$this->load->view('em_info_notification_group/f_cus_mail_order_for_adm_manage');
	//	$config = Array(
    //            'protocol' => 'smtp',
    //            'smtp_host' => 'ssl://smtp.googlemail.com',
    //            'smtp_port' => 465,
    //            'smtp_user' => 'dannysetyawan2@gma',
    //            'smtp_pass' => 'xxx',
    //            'mailtype'  => 'html', 
    //            'charset'   => 'iso-8859-1'
    //    );

    //    $this->load->library('email', $config);
	//	$this->load->library('parser');
    //  	$this->email->from('belanja@starsstore.id'); // change it to yours
    //  	$this->email->to('dannysetyawan1@gmail.com');// change it to yours
    //  	$this->email->subject('Pesanan Anda di Starsstore.id #');
    //  	$body = "tes mail from starsstore";
    //  	$this->email->message($body);
    //  	$this->email->send();
	//}

}