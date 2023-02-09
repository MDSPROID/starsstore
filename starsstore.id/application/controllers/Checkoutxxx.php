<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkoutxxx extends CI_Controller {

	protected $key = 'LAJ391BD01N10DN37403NC62NXKSST28';
	protected $iv =  '01M364BS721X365MXMGW036C5N24931N';

	function __construct(){
		parent::__construct();
		$this->load->library(array('form_validation')); //'veritrans','midtrans'
		$this->load->model(array('checkout_model','users'));
		$this->load->library('email');
		$this->session->unset_userdata('check_success');
		//$params = array('server_key' => 'SB-Mid-server-6cQ7lEBgacSGPm0nu386y8oG', 'production' => false);
		//$this->veritrans->config($params);
		$this->load->helper('url');

		$this->data['id'] = $this->session->userdata('mail_enc');
		$get_data_set = toko_libur();
		if($get_data_set['aktif'] == "on"){
			redirect(base_url('toko-libur'));
		}
	}

	function fgrand(){
		//$cashback = $this->security->xss_clean($this->input->get('c'));
		//$ongkirx = $this->encrypt->encode($this->security->xss_clean($this->input->get('p')));
		//$ongkir  = base64_encode($ongkirx);
		//$grandx  = $this->encrypt->encode($this->security->xss_clean($this->input->get('g')));
		//$grand   = base64_encode($grandx);
		$ongkir = $this->security->xss_clean($this->input->post('p'));
		$grand = $this->security->xss_clean($this->input->post('g'));

		print_r($ongkir);
		//echo number_format($grand+$ongkir,0,".",".");

	}

	function verifyorder($id){
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
			$iduser = $this->data['id'];
			if(!empty($this->session->userdata('id'))){
				$data['cs'] = $this->users->get_data_customer($iduser);
				//$data['address'] = $this->users->get_data_alamat_customer($iduser); // tidak dipakai
			}else{
				$data['cs'] = $this->users->get_data_customer($iduser);
			}
			
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

	function halaman_checkout(){
		if($this->session->userdata('log_access') != "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"){
		    $this->session->set_flashdata('error','Harap login untuk melanjutkan checkout');
		    $dataredirect['redirect'] = 'login-to-checkout';
			$this->session->set_userdata($dataredirect);
		    redirect('login-pelanggan');
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
			$id = $this->data['id'];
			$data['info_customer'] = $this->users->get_data_customer($id);
			$data['voucher'] = "";
			$data['loadBn'] = $this->checkout_model->load_bank_data();
			$data['total_berat'] = $sum;
			$data['title'] = "<title>Payment Checkout</title>";
			$data['meta_desc'] = "<meta name='description' content='payment checkout' />";
			$data['meta_key'] = "<meta name='keywords' content='payment checkout, pembayaran,'/>";
			$this->load->view('theme/v1header');
			$this->load->view('theme/v1checkout', $data);
			$this->load->view('theme/v1footer');
		}
	}

	function login_page_order(){
		$data['title'] = "<title>Mendaftar Akun</title>";
		$data['meta_desc'] = "<meta name='description' content='Mendaftar akun baru untuk memesan' />";
		$data['meta_key'] = "<meta name='keywords' content='Pendaftaran akun baru untuk pesanan'/>";
		$this->load->view('log_page_order', $data);
	}

	function loginuserakanorderpesanan(){

		$this->form_validation->set_rules('name_l', 'Nama', 'required|xss_clean');
		$this->form_validation->set_rules('email_m', 'Email', 'required|xss_clean|valid_email');
		$this->form_validation->set_rules('ps_d', 'Password', 'required');
		$this->form_validation->set_rules('no_l', 'Nomor Telepon', 'required|xss_clean');
		$this->form_validation->set_rules('gen', 'Jenis Kelamin', 'required|xss_clean');
		$this->form_validation->set_rules('aggre', 'TOS', 'required|xss_clean');

		$a = base64_decode($this->input->post('ges'));
		$b = $this->encrypt->decode($a);

		if($b != "8JHhOnsbrhs276"){
			echo "In78*7nsdf*&523)(%$@";
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses daftar customer baru untuk order";
			$this->users->savingHack($aktifitas);
		}else{
			
		if($this->form_validation->run() != FALSE ){

			$nama 	= $this->security->xss_clean($this->input->post('name_l'));
			$email 	= $this->security->xss_clean($this->input->post('email_m'));
			$pass 	= $this->security->xss_clean($this->input->post('ps_d'));
			$no_telp = $this->security->xss_clean($this->input->post('no_l'));
			$gender	 = $this->security->xss_clean($this->input->post('gen'));
			$accept	 = $this->security->xss_clean($this->input->post('aggre'));

				//panggil protected function
	 			$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
				$iv_size = mcrypt_enc_get_iv_size($cipher);
 
				// Encrypt
				if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
				{
    				$encrypt_default_rand = mcrypt_generic($cipher, $pass);
    				mcrypt_generic_deinit($cipher);
				}

				$data = array(
					'email'  		=> $email,
               		'password'     	=> bin2hex($encrypt_default_rand),
               		'nama_lengkap'	=> $nama,
               		'telp'			=> $no_telp,
               		'gender'		=> $gender,	
               		'status'    	=> 'a@kti76f0',
               		'level'			=> 'regcusok4*##@!9))921',
               		'akses'			=> '9x4$58&(3*+',
               		'created'		=> date("Y-m-d H:i:s"),
               		'ip_register_first'	=> $this->input->ip_address(),
            	);
            	//insert data
				$this->users->reg_new_data_customer($data);

				$dataadm = $this->checkout_model->keluarkan_dt_adm();
				foreach($dataadm->result() as $yp){
					if($yp->status == "e_admin"){
						$admmail = $yp->em_acc;
					}
				}	

				$data_cs = array(
					'nakap' => $nama
				);

				$config['protocol']		= 'smtp';
       			$config['smtp_host']    = 'mail.starsallthebest.com';
        		$config['smtp_port']    = '587';
        		$config['smtp_timeout'] = '30';
        		$config['smtp_user']    = 'admin@starsallthebest.com';
        		$config['smtp_pass']    = 'gitarkiwa';
        		$config['charset']    	= 'utf-8';
        		$config['newline']    	= "\r\n";
        		$config['mailtype'] 	= 'html'; // or html
        		$config['charset'] 		= 'iso-8859-1';

				$this->load->library('parser');
        		$this->load->library('email', $config);
      			$this->email->set_newline("\r\n");
      			$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
				$this->email->set_header('Content-type', 'text/html');
      			$this->email->from('noreply@domain.com', 'starsallthebest'); // change it to yours
      			$this->email->to($email);// change it to yours
      			$this->email->cc($admmail);
      			$this->email->subject('Pendaftaran Berhasil');
      			$body = $this->parser->parse('em_info_notification_group/f_cus_mail_reg_first',$data_cs,TRUE);
      			$this->email->message($body);
      			$this->email->send();

				//Login otomatis
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
				echo "Cus876^467Jkjh@$^%(_+";
			}else{
				echo "eX09&HJG7K%^Gksdjhk3)62";
			}
		}
				
	}
	
	public function pilihKota($province){	
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

	function hasilFilter()
	{
		$origin = "444";
		$destination = $this->security->xss_clean($this->input->get('destination'));
		$exp = explode('|', $destination);
		$id_kota = $exp[0];
		$nama_kota = $exp[1];

		$t 		= $this->input->get('lock_w');
		$qty 	= $this->input->get('qt');
		$b 		= base64_decode($t);
		$berat 	= $this->encrypt->decode($b);
		$courier = $this->input->get('courier');
 
		$data = array(	'origin' => $origin,
						'destination' => $id_kota, 
						'berat' => $berat*$qty, 
						'courier' => $courier 

		); 
		if($destination == 0){
			echo "Pilih Kota Anda!";
		}else{
			$this->load->view('rajaongkir/getCost', $data);
		}
	}

	function hasilFilter2()
	{
		$origin = "444";
		$destination = $this->security->xss_clean($this->input->get('destination'));
		$exp = explode('|', $destination);
		$id_kota = $exp[0];
		$nama_kota = $exp[1];

		$t 		= $this->input->get('lock_w');
		$qty 		= $this->input->get('qt');
		$b 		= base64_decode($t);
		$berat 	= $this->encrypt->decode($b);
		$courier = $this->input->get('courier');

		$data = array(	'origin' => $origin,
						'destination' => $id_kota, 
						'berat' => $berat*$qty, 
						'courier' => $courier 

		);
		if($destination == 0){
			echo "Pilih Kota Anda!";
		}else{
			$this->load->view('rajaongkir/getCost', $data);
		}
	}

	function fast_checkout(){
		// inialisasi ID 
		$in = $this->security->xss_clean($this->input->get('gex'));
		$ins1 = base64_decode($in);
		$ins = $this->encrypt->decode($ins1);
		
		$idp1 = $this->security->xss_clean($this->input->get('i'));
		$idProduk1 = base64_decode($idp1);
		$idProduk = $this->encrypt->decode($idProduk1);

		$fl1 = $this->security->xss_clean($this->input->get('fullname'));
		$fl2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$fl1);
		$fl3 = strip_tags($fl2);
		$fullname = htmlentities($fl3);

		$m1 = $this->security->xss_clean($this->input->get('email'));
		$m2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$m1);
		$m3 = strip_tags($m2);
		$mail = htmlentities($m3);

		$t1 = $this->security->xss_clean($this->input->get('telepon'));
		$t2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$t1);
		$t3 = strip_tags($t2);
		$telp = htmlentities($t3);

		$al1 = $this->security->xss_clean($this->input->get('almt'));
		$al2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$al1);
		$al3 = strip_tags($al2);
		$address = htmlentities($al3);

		$note1 = $this->security->xss_clean($this->input->get('notee'));
		$note2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$note1);
		$note3 = strip_tags($note2);
		$note = htmlentities($note3);

		$prov1 = $this->security->xss_clean($this->input->get('prov'));
		$prov2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$prov1);
		$prov3 = strip_tags($prov2);
		$prov = htmlentities($prov3);

		$ct1 = $this->security->xss_clean($this->input->get('city'));
		$ct2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$ct1);
		$ct3 = strip_tags($ct2);
		$city = htmlentities($ct3);

		$q1 = $this->security->xss_clean($this->input->get('qt'));
		$q2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$q1);
		$q3 = strip_tags($q2);
		$qty = htmlentities($q3);

		$size = $this->security->xss_clean($this->input->get('siz'));

		// explode size (ID,Value)
		$exsize1 	= explode(',', $size);
		// id size
        $exidsize1 	= $exsize1[0];
        $exidsize2	= base64_decode($exidsize1);
        $exidsize 	= $this->encrypt->decode($exidsize2);
        // size
        $exsize11   = $exsize1[1];
        $exsize2 	= base64_decode($exsize11);
        $exsize  	= $this->encrypt->decode($exsize2);

		$cl1 = $this->security->xss_clean($this->input->get('clr'));
		$cl2 = base64_decode($cl1);
		$color = $this->encrypt->decode($cl2);

		$cll1 = $this->security->xss_clean($this->input->get('clr1'));
		$cll2 = base64_decode($cll1);
		$colorr = $this->encrypt->decode($cll2);

		$w1 = $this->security->xss_clean($this->input->get('w'));
		$w2 = base64_decode($w1);
		$weight = $this->encrypt->decode($w2);

		$exp1 = $this->security->xss_clean($this->input->get('exp'));
		$exp2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$exp1);
		$exp3 = strip_tags($exp2);
		$exp = htmlentities($exp3);

		$exr1 = $this->security->xss_clean($this->input->get('resex'));
		$exr2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$exr1);
		$exr3 = strip_tags($exr2);
		$resex = htmlentities($exr3);

		if($ins != "D4nNy_proGr4mM3R"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses fast checkout";
			$this->users->savingHack($aktifitas);
		}else{
			if($fullname == "" || $mail == "" || $telp == "" || $address == "" || $prov == "" || $city == "" || $qty == "" || $color == "" || $size == "" || $weight == "" || $exp == "" || $resex == ""){
				echo "accessDenied";
			}else{

				//generate invoice
				$length =5;
				$random= "";
				srand((double)microtime()*1000000);
	 
				$data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
				$data .= "1234567890";
	 
				for($i = 0; $i < $length; $i++){
					$random .= substr($data, (rand()%(strlen($data))), 1);
				}

				// Awalan Invoice
				$utama = "STFC";

				// ID Customer Login
				//$id = $this->data['id'];

				//tanggal
				$tgl_text = date('D');
				$tgl = date('d', strtotime($tgl_text));

				// Bulan 
				$bln_text = date('M');
				$bln = date('m', strtotime($bln_text));

	    		// Tahun
	    		$year  = date('y');	

	    		// Hasil generate
	    		$invoice = $utama.$random.$tgl.$bln.$year;
	    		
	    		//Note tambahan order
	    		if($note == ""){
	       			$note_ol = "-";
	       		}else{
	       			$note_ol = $note;
	       		}

	       		//generate code unique
				$length =3;
				$uniq= "";
				srand((double)microtime()*1000000);
				$data = "1234567890";
	 
				for($i = 0; $i < $length; $i++){
					$uniq .= substr($data, (rand()%(strlen($data))), 1);
				}
				$data_code = $uniq;

				// get produk data 
				$getProduk = $this->checkout_model->get_produk_for_fc($idProduk);
				foreach($getProduk as $g){
					$id_produk 	= $g->id_produk;
					$pr_name	= $g->nama_produk;
					$art 		= $g->artikel;
					$merk		= $g->merk;
					$diskon 	= $g->diskon;
					$harga_before = $g->harga_retail;
					$harga_net  = $g->harga_net;
					$gb 		= $g->gambar;
				}

				//ambil tarif
				$exp = explode('|', $resex);
	  			$tarif = $exp[2];
	  			$date_maju1 = date('Y-m-d H:i:s', strtotime('10 hours'));
	       		// saving data customer order only
				$data_customer = array(
					'nama_lengkap'		=> $fullname,
					'no_telp'			=> $telp,
					'email'				=> $mail,
					'buy_in'			=> 'E-commerce',
					'fast_checkout'		=> 'Fast_checkout',
					'no_order_cus'		=> $random,
					'invoice'			=> $invoice,
					'catatan_pembelian' => $note_ol,
					'kode_pembayaran'	=> $data_code,
					'subtotal'			=> $harga_net*$qty,
					'total_belanja'		=> ($harga_net*$qty)+$data_code+$tarif,
					'total_berat'		=> ($weight/1000)*$qty,
					'tanggal_waktu_order'=> date('Y-m-d H:i:s'),
					'tanggal_order'		=> date('Y-m-d'),
					'tanggal_jatuh_tempo'=> $date_maju1,
					'jenis_pembayaran'	=> 'bt',
					'bank_pembayaran'	=> '39725',
					'status'			=> '2hd8jPl613!2_^5',
					'dibayar'			=> 'belum',
					'ip'				=> $this->input->ip_address(),
					'browser'			=> $this->agent->browser(),
					'platform'			=> $this->agent->platform(),
					'baca'				=> 'belum',
				);
				$this->checkout_model->saving_order_data_customer($data_customer);

				// saving expedition data
				$exp = explode('|', $resex);
	  			$data_expedisi = array(
	      			'no_order_ex' => $random,
	      			'alamat'	=> $address,
	      			'provinsi'  => $prov,
	      			'kota'		=> $city,
	      			'layanan' 	=> $exp[0],
	      			'etd' 		=> $exp[1],
	      			'tarif'		=> $exp[2],
	  			);
	  			$this->checkout_model->saving_expedition($data_expedisi);

	  			// saving order
				$data_order[] = array(
		  			'no_order_pro' 	=> $random,
		  			'id_produk'		=> $id_produk,
		  			'nama_produk' 	=> $pr_name,
		  			'gambar'		=> $gb,
		  			'artikel'		=> $art,
		  			'merk'			=> $merk,
		  			//'milik'			=> $item['milik'],
		  			//'jenis'			=> $item['jenis'],
		  			//'point'			=> $item['point'],
		  			'diskon'		=> $diskon,
		  			'ukuran' 		=> $exsize,
		  			'warna'			=> $colorr,
		  			'qty' 			=> $qty,
		  			//'odv'			=> $item['odv'],
		  			'harga_fix'		=> $harga_net,
		  			'harga_before'  => $harga_before,         		
		  			'berat' 		=> $weight/1000,
				);
				 
				//saving order
				$this->checkout_model->saving_order($data_order);

				// payment
				$idbnk = "39725";
				$bnkm =  $this->checkout_model->selectInfbnk($idbnk);
				foreach($bnkm->result() as $ery){
					$banking_select_opt = $ery->name_bank;
					$cabangBnk = $ery->bank_cabang;
					$banking_number = $ery->no_rek;
					$banking_a_n = $ery->a_n;
				}

				$method = "Transfer";
				$banking_select  = $banking_select_opt;
				$banking_inf_cab = $cabangBnk;
				$banking_inf_no	 = $banking_number;
				$banking_inf_an  = $banking_a_n;

				// Kurangi Stok Produk
	         	$kat_id = $id_produk;
	         	$idc    = $color;
	         	$idsz   = $exidsize;

	            $get_data_pro_id = $this->checkout_model->get_id_data($kat_id, $idc, $idsz);
	            foreach($get_data_pro_id as $gy){
	            	//kurangi stok berdasarkan 1 warna dan size, meski size berbeda, dan id produk sama dapat dibedakan dan dikurangi karena memakai where yang tepat ().
	            	$data_stok_pro = array(
		                'id_produk_optional'=> $gy->id_produk_optional,
		                'id_opsi_get_color' => $gy->id_opsi_get_color,
		                'id_opsi_get_size' 	=> $gy->id_opsi_get_size,
		                'stok'  			=> $gy->stok - $qty,
	            	);
	            		$id_pr 		= $gy->id_produk_optional;
		                $idcolor 	= $gy->id_opsi_get_color;
		                $idsize 	= $gy->id_opsi_get_size;
	            	// mulai pengurangan stok disini
	            	$this->checkout_model->kurangi_stok($data_stok_pro, $id_pr, $idcolor, $idsize);
	            }

				//destroy session kupon
				//$this->session->unset_userdata('type');
				//destroy session cart kecuali user
				//$this->cart->destroy();
				// set invoice berdasarkan 1x10 jam
				$date_maju = date('Y-m-d H:i:s', strtotime('10 hours'));
				// get id_seller dari database produk jika ada maka kirim email ke customer kalau produknya terbeli [BELUM BUAT]

				// parsing to email customer
				//$this->orderMailSendinformationGawecustomer($address, $note_ol, $pay, $bnk, $invoice, $random, $resex, $prov, $city, $date_maju);
				// parsing to email admin
				$total_b = ($harga_net*$qty)+$data_code+$tarif;
				$this->orderMailsendfastcheckout($fullname, $invoice, $total_b);
				//$this->orderMailSendinformationGaweadminBro($address, $note_ol, $pay, $bnk, $invoice, $random, $resex, $prov, $city, $date_maju);

				// keluarkan data customer 
				
				$nmlkpi    = $fullname;
				$notelp271 = $telp;
				$em_cus = $mail;

				// keluarkan data customer di order_customer
				$filecs = $this->checkout_model->get_data_order_cs($random);
				foreach($filecs->result() as $fil){
					$code_unik = $fil->kode_pembayaran;
					$subt 	   = $fil->subtotal;
					$tot_bel   = $fil->total_belanja;
					$tot_ber   = $fil->total_berat;
				}

				//$random = "03XS2";
				// get data from $random (pot. invoice)
				$data_produk = $this->checkout_model->get_data_produk_for_send_to_email($random);
				foreach($data_produk->result() as $ft){
					if($ft->diskon == "0"){
						$discft = "";
					}else{
						$discft = "<i style='font-size: 10px;padding:3px;background-color:red;color:white;' class='label-diskon-detail'>$ft->diskon%</i>";
					}

					if($ft->ukuran == ""){
						$ukr = "";
					}else{
						$ukr = "<li class='gf'>Ukuran : $ft->ukuran</li>";
					}

					if($ft->warna == ""){
						$wrn = "";
					}else{
						$wrn = "<li class='gf'>Warna : $ft->warna</li>";
					}

					if($ft->harga_before == "0"){
						$hg_before = "";
					}else{
						$hg_before = "<s style='color:#a8a8a8;font-weight:initial;'>Rp. $ft->harga_before</s>";
					}

				$dp[] = array(
					'id'				=> $ft->idpr_order,
					'nor_order_pro'		=> $ft->no_order_pro,
					'nama_produk'		=> $ft->nama_produk,
					'artikel'			=> $ft->artikel,
					'merk'				=> $ft->merk,
					'diskon'			=> $discft,
					'ukuran'			=> $ukr,
					'warna'				=> $wrn,
					'qty'				=> $ft->qty,
					'harga_before'		=> $hg_before,
					'harga_fix'			=> number_format($ft->harga_fix,0,".","."),
					);
				}
				//print_r($dp);
		       	
		       	$exp = explode('|', $resex);    
		      	$data_cs = array(
		            'inv'      => $invoice,
		            'tglOrdercs' => date('d F Y H:i:s'),
		            'tglExp'   => $date_maju,
		            'nmlkp'    => $fullname,
		            'almtkp'   => $address,
		            'note' 	   => $note_ol,
		            'kota'     => $city,
		            'prov'     => $prov,
		            'layanan'  => $exp[0],
		            'etd'      => $exp[1],
		            'tarif'    => $exp[2],
		            'noTelp'   => $telp,
		            'methode'  => $method,
		            'bnk_option' => $banking_select,
		            'cabang'   => $banking_inf_cab,
		            'no_rek'   => $banking_inf_no,
		            'an_bnk'   => $banking_inf_an,
		            'subtotal' => number_format($subt,0,".","."),
		            'kode_pembayaran' => $code_unik,
		            'total_belanja' => number_format($tot_bel,0,".","."),
		            'berat_total' => $tot_ber,
		            'data_order' => $dp
		         );

		        //print_r($data_cs);      	
		      	$config = Array(
					'mailtype'  => 'html', 
				);
				
				$this->email->initialize($config);
				$this->load->library('parser');
		      	$this->email->from('noreply@starsstore.id'); // change it to yours
		      	$this->email->to($em_cus);// change it to yours
		      	$this->email->subject('Invoice Pembelian');
		      	$body = $this->parser->parse('em_info_notification_group/f_cus_mail_order',$data_cs,TRUE);
		      	$this->email->message($body);
		      	$this->email->send();
//				echo "S5ihs7Hdf52lpP";
			}
		}

	}

	function orderMailsendfastcheckout($fullname, $invoice, $total_b){
		$config = Array(
				'mailtype'  => 'html', 
			);
			
			$this->email->initialize($config);
			//$this->load->library('parser');
	      	$this->email->from('noreply@starsstore.id'); // change it to yours
	      	$this->email->to('ecommercestars@gmail.com');// change it to yours
	      	$this->email->subject('Pesanan Baru (Fast Checkout)');
	      	$this->email->message("Pesanan Baru<br>jangan kirim barang terlebih dahulu sebelum pelanggan melakukan pembayaran. berikut detail pesanannya :<br><br>Nama pelanggan : ".$fullname."<br>Invoice : ".$invoice."<br>Total Belanja : Rp. ".$total_b." ");
	      	$this->email->send();
	      	echo "S5ihs7Hdf52lpP";
	}

 	function confirm_order(){ //$initial

/////////////////////////////////////////// FORM /////////////////////////////////////////////////////////////////////////

		//$ins = strip_tags(base64_decode($initial));
		//$b = $this->encrypt->decode($ins);

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

//// NOTE ORDER //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if($note == ""){
   			$note_ol = "-";
   		}else{
   			$note_ol = $note;
   		}

//// BERAT /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

		$pay1 = $this->security->xss_clean($this->input->post('payment'));
		$pay2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$pay1);
		$pay3 = strip_tags($pay2);
		$pay4 = htmlentities($pay3);

		$pay5 = base64_decode($pay4);
		$payment = $this->encrypt->decode($pay5);


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

			// validasi form kosong
			//if($nama == "" || $email == "" || $telp == "" || $prov == "" || $city == "" || $address == "" || $total_berat == "" || $expedisi == "" || $payment == ""){
			if($this->form_validation->run() == FALSE ){
				
				$this->session->set_flashdata('error', 'Isi form yang masih kosong / centang pengiriman / anda harus menyetujui syarat dan ketentuan!');
				redirect($this->agent->referrer());

			}else{

				$idsescus = $this->session->userdata('id_cs');

				$createacc1 = $this->security->xss_clean($this->input->post('createaccount'));
				$createacc2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$createacc1);
				$createacc3 = strip_tags($createacc2);
				$createacc4 = htmlentities($createacc3);

				/// JIKA CUSTOMER MENCENTANG "BUAT AKUN SEKALIGUS" MAKA DIBUATKAN AKUN DAN SEKALIGUS MENAMBAHKAN POINT KE AKUN BARU TERSEBUT 

				//(UPDATE TERBARU, CENTANG BUAT AKUN SEKALIGUS DITIADAKAN. DAN LANGSUNG PENGECEKKAN JIKA EMAIL SUDAH TERDAFTAR MAKA OTOMATIS LOGIN, JIKA EMAIL BLM TERDAFTAR MAKA OTOMATIS DIBUATKAN AKUN)

				if(empty($idsescus){ // jika session login kosong maka cek email apa sudah jadi member apa belum
				// $createacc4 == "on" posisi jika belum login dan centang ON // buat akun

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
						
						//if($cek->num_rows() > 0){
 
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
								$sess_data['id_cs']				= $s->id;
								$sess_data['mail_encrypt']      = $s->email_encrypt;
								$sess_data['last_login']    	= $s->last_login;
								$sess_data['log_access']    	= "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";

								$this->session->set_userdata($sess_data);
								$this->users->updateLastloginCustomer($s->id);
								$this->users->saving_ipdevicebrowser($s->id,$email);
							}

							$id = $this->session->userdata('id_cs');

						//}

						// SIMPAN ALAMAT
						//$data_alamat_cs = array(
						//	'id_cs_alamat' 	=> $sess_data['id'],
						//	'alamat'		=> $address,
						//);
						//$this->checkout_model->simpan_alamat_cs_checkout($data_alamat_cs);

						// TAMBAHKAN POINT CUSTOMER BARU
						//$point_produk = $this->session->userdata('totalPoint');
						//$get_t_p_cs = array(
						//	'point_terkumpul' => $point_produk,
						//);

						//$id = $sess_data['id'];

						// UPDATE POINT YANG TERKUMPUL DARI SETIAP PEMBELANJAAN
						//$this->checkout_model->upgradePoint($get_t_p_cs, $id);

						// kirim email informasi akun ke customer
						$data_cs = array(
							'nakap' => $nama,
							'info'	=> "Akun anda :<br>Email : <b>".$email."</b><br>Password : <b>".$telp."</b><br> Silahkan ubah password anda. Terima Kasih telah mendaftar. Nikmati kemudahan berbelanja dan banyak promo untuk anda."
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

		      			//$idcustomersession = $this-;//$sess_data['id'];

					}else{ // jika email sudah terdaftar redirect kembali

						$cek = $this->checkout_model->validasi_data_login($email);
						foreach($cek->result() as $data){
							$sess_data['id_cs']         = $data->id;
							$sess_data['mail_encrypt']  = $data->email_encrypt;
							$sess_data['last_login']    = $data->last_login;
							$sess_data['log_access']    = "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS"; 
							$sess_data['provider']		= $data->provider_login;

							$this->session->set_userdata($sess_data);
							$this->users->updateLastloginCustomer($data->id);
							$this->users->saving_ipdevicebrowser($data->id,$email);
						}

						$id = $this->session->userdata('id_cs');

						//$this->session->set_flashdata('error', 'Email telah terdaftar, gunakan email lain atau login');
						//redirect($this->agent->referrer());
					}

				}else if(!empty($idsescus)) { // posisi jika belum login dan centang OFF // tidak buat akun

					$id = $this->session->userdata('id_cs');

				//if(!empty($idsescus)){ //jika tombol create tidak dicentang berarti tidak buat akun bisa jadi sudah login atau bisa jadi belum login cuma guest checkout

					//// POINT CUSTOMER ///////////////////////////////////////////////////////////////////////////////////////

					//$id = $this->data['id'];
					//$pnt = $this->checkout_model->get_point_customer($id); // GET POINT TERKUMPUL 
					//foreach($pnt->result() as $hs){
					//	if(empty($hs->point_terkumpul)){
					//		$poics = 0;
					//	}else{
					//		$poics = $hs->point_terkumpul;
					//	}
					//}

					// SIMPAN ALAMAT
					//$data_alamat_cs = array(
					//	'id_cs_alamat' => $idsescus,
					//	'alamat'	=> $address,
					//);
					//$this->checkout_model->simpan_alamat_cs_checkout($data_alamat_cs);

					// TAMBAHKAN POINT CUSTOMER
					//$point_produk = $this->session->userdata('totalPoint');
					//$point_customer = $poics;
					//$get_t_p_cs = array(
					//	'point_terkumpul' => $point_customer+$point_produk,
					//);
					//// UPDATE POINT YANG TERKUMPUL DARI SETIAP PEMBELANJAAN
					//$this->checkout_model->upgradePoint($get_t_p_cs, $id);

				//}else if(empty($idsescus) && $createacc4 != "on"){

				//	$idcustomersession = 0;
				//	echo "4";

				}//else{
				//	$id = 0;
				//}

				//print_r($idcustomersession);

				//// GRATIS ONGKIR / TIDAK //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//if($this->session->userdata("type") == "ongkir_apply"){
				//	$resex = "0";
				//}else{
				//	$resex1 = $this->security->xss_clean($this->input->post('checkshipping'));
				//	$resex2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$resex1);
				//	$resex3 = strip_tags($resex2);
				//	$resex = htmlentities($resex3);
				//}	

				//// PROMO ONGKIR ATAU TIDAK ///////////////////////////////////////////////////////////////////////////////
				if($this->session->userdata("type") == "ongkir_apply"){
					// gratis ongkir bisanya pilih expedisi, 
					// tapi kalau pilih sub expedisi (REG, OKE, DLL) 
					// tidak diijinkan. karena ujung2nya REGULER yang dipakai xixixi
					$layanan = strtoupper($expedisi);
					$etd 	= "3-4 Hari";
					$tarif 	= 0;
					$resex = "0";

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

				//// GENERATE INVOICE //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$length =5;
				$random= "";
				srand((double)microtime()*1000000);
				$data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
				$data .= "1234567890";
				for($i = 0; $i < $length; $i++){
					$random .= substr($data, (rand()%(strlen($data))), 1);
				}
				// AWALAN INVOICE
				$utama = "ST";
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

				//// FUNGSI INI ADALAH UNTUK M EMBEDAKAN VAR RANDOM INVOICE, KALAU BANK TRANSFER DAN KARTU KREDIT RANDOM INVOICENYA LANGSUNG GENERATE, TAPI JIKA MELALUI MULTIPLE CHANNEL RANDOM IVOICE DIDAPAT DARI SESSION

				if($payment == "bank_t_ransfer" || $payment == "cre_dit_card"){ 	
					$randomx = $random;
				}else{
					$randomx = $this->session->userdata('random');
				}

				//// SAVING EXPEDITION DATA /////////////////////////////////////////////////////////////////////////////////////////////

				$data_expedisi = array(
					'no_order_ex' => $randomx,
					'alamat'	=> $address.' '.$city.' '.$prov.' '.$kdp,
					'provinsi'  => $prov,
					'kota'		=> $city,
					'layanan' 	=> $layanan,
					'etd' 		=> $etd,
					'tarif'		=> $tarif,
				);

				$this->checkout_model->saving_expedition($data_expedisi);

				//// GRAND TOTAL ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				if($this->session->userdata('type') == "disc_apply"){
					// TOTAL - (TOTAL * DISKON / 100) + KODE UNIK + PENGIRIMAN
					$grandTotal = $this->cart->total() - ($this->cart->total() * $this->session->userdata('action') / 100) + $this->session->userdata('unik') + $tarif;

				}else if($this->session->userdata("type") == "ongkir_apply"){
					// TOTAL + KODE UNIK 
					$grandTotal = $this->cart->total() + $this->session->userdata('unik');
				}else{
					// TOTAL + KODE UNIK + PENGIRIMAN 
					$grandTotal = $this->cart->total() + $this->session->userdata('unik') + $tarif;
				}
				//// END GRAND TOTAL ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				//// JIKA PROMO TELAH DI APPPLY OLEH CUSTOMER, MAKA INPUT PROMONYA KE DATABASE ////////////////////////////////

				if($this->session->userdata("type") != ""){
					$kupon = $this->session->userdata('kupon');

					$cekuse = $this->checkout_model->cekmailusevoucher($kupon,$email);
					if($cekuse > 0){
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
						//$idcustomersession = $this->session->userdata('id_cs');
						$vouc = $this->session->userdata('kupon');
						$acvouc = $this->session->userdata('action');
						$data_customer_with_voucher = array( 
							'no_order_vou'	=> $randomx,
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
				}else{

					$vouc = "";
					$acvouc = "";
					$action_voucherx = "-";
				}

				//// SAVING ORDER /////////////////////////////////////////////////////////////////////////////////////////////////////////
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

					//// MENGAPA SAVING ORDER DIBEDAKAN? KARENA UNTUK PEMBAYARAN BANK TRANSFER DAN CREDIT CARD INVOICE DIDAPAT DARI RANDOM, TAPI KALAU PEMBAYARAN LAINNYA (GOPAY) INVOICE DAN RANDOM NYA SUDAH DISESSIONKAN DAN PERLU DITANGKAP. (TIDAK PERLU GENERATE LAGI)

					$data_order[] = array(
			  			'no_order_pro' 	=> $randomx,
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

				// KELUARKAN DATA EMAIL ADMIN
				$dataadm = $this->checkout_model->keluarkan_dt_adm(); 
				foreach($dataadm->result() as $yp){
					if($yp->status == "e_admin"){
						$admmail = $yp->em_acc;
					}
				}	

$date_maju = date('Y-m-d H:i:s', strtotime('3 hours'));

////////////////////////////////////// END INIALISASI GLOBAL /////////////////////////////////////////////////////////////// 

//// KURANGI STOK (BARU DAN GLOBAL)  ///

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

//// END KURANGI STOK (BARU DAN GLOBAL)  ///

//// PAYMENT METHOD BANK TRANSFER /////////////////////////////////////////////////////////////////////////////////////////////////////////

if($payment == "bank_t_ransfer"){ 	

				$bnk1 = $this->security->xss_clean($this->input->post('bnk'));
				$bnk2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$bnk1);
				$bnk3 = strip_tags($bnk2);
				$bnk4 = htmlentities($bnk3);

				$bnk5 = base64_decode($bnk4);
				$bnk = $this->encrypt->decode($bnk5);

				// MULAI TANGGAL 14 MARET 2020 FUNCTION KURANGI STOK DIJADIKAN GLOBAL //

				//// MENGAPA SIMPAN DATA & KURANGI STOK DITARUH DISINI? KARENA PERLAKUAN VARIABLE INVOICE BERBEDA (BUKAN GLOBAL) PADA PAYMENT OTHER INVOICE DI SESSION KAN. KALAU LAINNYA TIDAK DISESSION (GENERATE DARI CONTROLLER).

				//// SIMPAN DATA PESANAN & KURANGI STOK  ///////////////////////////////////////////////////////////////////////////////////

				$data_customer = array(
					'nama_lengkap'		=> $nama,
					'no_telp'			=> $telp,
					'email'				=> $email,
					'buy_in'			=> 'E-commerce',
					'no_order_cus'		=> $randomx,
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
					'jenis_pembayaran'	=> "Bank Transfer",
					//'bank_pembayaran'	=> $bnk,
					'status'			=> '2hd8jPl613!2_^5',
					'dibayar'			=> 'belum',
					'ip'				=> $this->input->ip_address(),
					'browser'			=> $this->agent->browser(),
					'platform'			=> $this->agent->platform(),
					'baca'				=> 'belum',
				);
				$this->checkout_model->saving_order_data_customer($data_customer);

				

		        // cek payment bank transfer jika tidak ada maka kemungkinan dihack

				//$bnkm =  $this->checkout_model->selectInfbnk($bnk); 
				//foreach($bnkm->result() as $ery){
				//	$banking_select_opt = $ery->name_bank;
				//	$cabangBnk = $ery->bank_cabang;
				//	$banking_number = $ery->no_rek;
				//	$banking_a_n = $ery->a_n;
				//}

				$method = "transfer";//$payment;
				//$banking_select  = $banking_select_opt;
				//$banking_inf_cab = $cabangBnk;
				//$banking_inf_no	 = $banking_number;
				//$banking_inf_an  = $banking_a_n;

				// BANK TRANSFER DIBERIKAN SEMUA INFO SEMUA BANK KE CUSTOMER UNTUK KE ADMIN CUMA METODE PEMBAYARAN
				//$banking_select,$banking_inf_cab,$banking_inf_no,$banking_inf_an,
				$this->mailTocustomer($email,$nama,$address,$note_ol,$city,$prov,$layanan,$etd,$tarif,$telp,$method,$vouc,$action_voucherx,$invoice,$date_maju,$total_berat,$grandTotal);	
				// EMAIL KE ADMIN // $banking_select,$banking_inf_cab,$banking_inf_no,$banking_inf_an,
				$this->mailToadmin($admmail,$email,$nama,$address,$note_ol,$city,$prov,$layanan,$etd,$tarif,$telp,$method,$vouc,$action_voucherx,$invoice,$date_maju,$total_berat,$grandTotal);

				// Send Session Flashdata to Halaman Success | Jika tidak ada session halaman success tidak bisa diakses (diarahkan ke halaman keranjang belanja)
				//$this->session->set_flashdata('bayar',''.$method.'');
				//$this->session->set_flashdata('tlp',''.$telp.'');
				//$this->session->set_flashdata('nama',''.$nama.'');
				//$this->session->set_flashdata('notran',''.$invoice.'');
				//$this->session->set_flashdata('totbel',''.$grandTotal.'');
				// redirect ke halaman success
				//redirect('checkout/success');

//// PAYMENT METHOD KARTU KREDIT /////////////////////////////////////////////////////////////////////////////////////////////////////////

}else if($payment == "cre_dit_card"){

				//// SIMPAN DATA PESANAN & KURANGI STOK  ///////////////////////////////////////////////////////////////////////////////////

				$data_customer = array(
					'nama_lengkap'		=> $nama,
					'no_telp'			=> $telp,
					'email'				=> $email,
					'buy_in'			=> 'E-commerce',
					'no_order_cus'		=> $randomx,
					'invoice'			=> $invoice,
					'id_customer'		=> $this->data['id'],
					'catatan_pembelian' => $note_ol,
					'kode_pembayaran'	=> 0,//$this->session->userdata('unik'), // tidak pakai kode unik
					'subtotal'			=> $this->cart->total(),
					'total_belanja'		=> $grandTotal, // TOTAL BELUM DIBUAT
					'total_berat'		=> $total_berat/1000,
					'tanggal_waktu_order'=> date('Y-m-d H:i:s'),
					'tanggal_order'		=> date('Y-m-d'),
					'tanggal_jatuh_tempo'=> $date_maju,
					'jenis_pembayaran'	=> $payment,
					'bank_pembayaran'	=> '-',
					'status'			=> '2hd8jPl613!2_^5',
					'dibayar'			=> 'belum',
					'ip'				=> $this->input->ip_address(),
					'browser'			=> $this->agent->browser(),
					'platform'			=> $this->agent->platform(),
					'baca'				=> 'belum',
				);
				$this->checkout_model->saving_order_data_customer($data_customer);

				// Kurangi Stok Produk
		        //foreach($this->cart->contents() as $item) {
		        // 	$kat_id = $item['id'];
		        // 	$idc    = $item['optidcolor'];
		        // 	$idsz   = $item['optidsize'];

		        //    $get_data_pro_id = $this->checkout_model->get_id_data($kat_id, $idc, $idsz);
		        //    foreach($get_data_pro_id as $gy){
		            	//kurangi stok berdasarkan 1 warna dan size, meski size berbeda, dan id produk sama dapat dibedakan dan dikurangi karena memakai where yang tepat ().
		        //    	$data_stok_pro = array(
			    //            'id_produk_optional'=> $gy->id_produk_optional,
			    //            'id_opsi_get_color' => $gy->id_opsi_get_color,
			    //            'id_opsi_get_size' 	=> $gy->id_opsi_get_size,
			    //            'stok'  			=> $gy->stok - $item['qty'],
		        //    	);
		        //    		$id_pr 		= $gy->id_produk_optional;
			    //            $idcolor 	= $gy->id_opsi_get_color;
			    //            $idsize 	= $gy->id_opsi_get_size;
		            	// mulai pengurangan stok disini
		        //    	$this->checkout_model->kurangi_stok($data_stok_pro, $id_pr, $idcolor, $idsize);
		        //    }
		        //}	

				$token_id = $this->input->post('token_id');
				$transaction_details = array(
					'order_id' 		=> $invoice,
					'gross_amount' 	=> $grandTotal
				);

				// PESANAN
				$no = 0;
				foreach ($this->cart->contents() as $item){
					$no++;
					if($no == 1){
		                $shipping = $tarif; //+ $this->session->userdata('unik');
		                $notee = " + Ongkos kirim";//" + (Ongkos kirim & kode unik)";
		            }else{
		                $shipping = 0;
		                $notee = "";
		            }

		            if($this->session->userdata('type') == "disc_apply"){
	            	//$ifapplyvoucher = " (".$this->session->userdata('action')."%)";
		            	$disc_apply = $item['price'] * $this->session->userdata('action') / 100; // MENGHITUNG DISKON PER ITEM (PERMINTAAN MIDTRANS)
		            }else if($this->session->userdata("type") == "ongkir_apply"){
		            	//$ifapplyvoucher = " *Gratis Ongkir";
		            	$disc_apply = 0;
		            }else{
		            	//$ifapplyvoucher = "";
		            	$disc_apply = 0;
		            }

					$items[] = array(
						'id' 			=> $item['id'],
						'price' 		=> ($item['price']-$disc_apply) + $shipping,
						'quantity' 		=> $item['qty'],
						'name' 			=> $item['name'] //.$notee
					);
				}

				// Populate customer's billing address
				$billing_address = array(
					'first_name' 	=> $nama,
					'last_name' 	=> "",
					'address' 		=> $address,
					'city' 			=> $city,
					'postal_code' 	=> "",
					'phone' 		=> $telp,
					'country_code'	=> 'IDN'
					);

				// Populate customer's shipping address
				$shipping_address = array(
					'first_name' 	=> $nama,
					'last_name' 	=> "",
					'address' 		=> $address,
					'city' 			=> $city,
					'postal_code' 	=> "",
					'phone' 		=> $telp,
					'country_code'=> 'IDN'
					);

				// Populate customer's Info
				$customer_details = array(
					'first_name' 	=> $nama,
					'last_name' 	=> "",
					'email' 		=> $mail,
					'phone' 		=> $telp,
					'billing_address' => $billing_address,
					'shipping_address'=> $shipping_address
					);

				$transaction_data = array(
					'payment_type'      => 'credit_card', 
					'item_details'       => $items,
					'customer_details'   => $customer_details,
					'credit_card'       => array(
					   'token_id'  => $token_id,
					   'bank'    => 'bni'
					   ),
					'transaction_details'   => $transaction_details,
				);
				
				$params = array('server_key' => 'SB-Mid-server-6cQ7lEBgacSGPm0nu386y8oG', 'production' => false);
				$this->load->library('veritrans',$params);
				$response = null;
				try
				{
					$response= $this->veritrans->vtdirect_charge($transaction_data);
				} 
				catch (Exception $e) 
				{
		    		echo $e->getMessage();	
				}

				$method = "cc_card";
				$banking_select  = "";
				$banking_inf_cab = "";
				$banking_inf_no	 = "";
				$banking_inf_an  = "";

				//$date_maju = date('Y-m-d H:i:s', strtotime('3 hours')); 
				//$banking_select,$banking_inf_cab,$banking_inf_no,$banking_inf_an,
				$this->mailTocustomer($email,$nama,$address,$note_ol,$city,$prov,$layanan,$etd,$tarif,$telp,$method,$vouc,$action_voucherx,$invoice,$date_maju,$total_berat,$grandTotal);
				// EMAIL KE ADMIN //$method,$banking_select,$banking_inf_cab,$banking_inf_no,$banking_inf_an,
				$this->mailToadmin($admmail,$email,$nama,$address,$note_ol,$city,$prov,$layanan,$etd,$tarif,$telp,$vouc,$action_voucherx,$invoice,$date_maju,$total_berat,$grandTotal);

//// PAYMENT METHOD MULTIPLE CHANNEL /////////////////////////////////////////////////////////////////////////////////////////////////////////

}else if($payment == "multiple_chan_nel"){

				$randx = $this->session->userdata('random');
				$inv = $this->session->userdata('invoice');

				//// SIMPAN DATA PESANAN & KURANGI STOK  ///////////////////////////////////////////////////////////////////////////////////

				$data_customer = array(
					'nama_lengkap'		=> $nama,
					'no_telp'			=> $telp,
					'email'				=> $email,
					'buy_in'			=> 'E-commerce',
					'no_order_cus'		=> $randx,
					'invoice'			=> $inv,
					'id_customer'		=> $this->data['id'],
					'catatan_pembelian' => $note_ol,
					'kode_pembayaran'	=> 0,//$this->session->userdata('unik'), // tidak pakai kode unik
					'subtotal'			=> $this->cart->total(),
					'total_belanja'		=> $grandTotal, 
					'total_berat'		=> $total_berat/1000,
					'tanggal_waktu_order'=> date('Y-m-d H:i:s'),
					'tanggal_order'		=> date('Y-m-d'),
					'tanggal_jatuh_tempo'=> $date_maju,
					'jenis_pembayaran'	=> $payment,
					'bank_pembayaran'	=> '-',
					'status'			=> '2hd8jPl613!2_^5',
					'dibayar'			=> 'belum',
					'ip'				=> $this->input->ip_address(),
					'browser'			=> $this->agent->browser(),
					'platform'			=> $this->agent->platform(),
					'baca'				=> 'belum',
				);
				$this->checkout_model->saving_order_data_customer($data_customer);

				// Kurangi Stok Produk
		        //foreach($this->cart->contents() as $item) {
		        // 	$kat_id = $item['id'];
		        // 	$idc    = $item['optidcolor'];
		        // 	$idsz   = $item['optidsize'];

		        //    $get_data_pro_id = $this->checkout_model->get_id_data($kat_id, $idc, $idsz);
		        //    foreach($get_data_pro_id as $gy){
		            	//kurangi stok berdasarkan 1 warna dan size, meski size berbeda, dan id produk sama dapat dibedakan dan dikurangi karena memakai where yang tepat ().
		        //    	$data_stok_pro = array(
			    //            'id_produk_optional'=> $gy->id_produk_optional,
			    //            'id_opsi_get_color' => $gy->id_opsi_get_color,
			    //            'id_opsi_get_size' 	=> $gy->id_opsi_get_size,
			    //            'stok'  			=> $gy->stok - $item['qty'],
		        //    	);
		        //    		$id_pr 		= $gy->id_produk_optional;
			    //            $idcolor 	= $gy->id_opsi_get_color;
			    //            $idsize 	= $gy->id_opsi_get_size;
		            	// mulai pengurangan stok disini
		        //    	$this->checkout_model->kurangi_stok($data_stok_pro, $id_pr, $idcolor, $idsize);
		        //    }
		        //}	

				$method = "other";
				$banking_select  = "";
				$banking_inf_cab = "";
				$banking_inf_no	 = "";
				$banking_inf_an  = "";

				//$date_maju = date('Y-m-d H:i:s', strtotime('3 hours')); //$banking_select,$banking_inf_cab,$banking_inf_no,$banking_inf_an,
				$this->mailTocustomer_for_other_payment($email,$nama,$address,$note_ol,$city,$prov,$layanan,$etd,$tarif,$telp,$method,$vouc,$action_voucherx,$inv,$date_maju,$total_berat,$grandTotal);

				// EMAIL KE ADMIN //$banking_select,$banking_inf_cab,$banking_inf_no,$banking_inf_an,
				//$this->mailToadmin_for_other_payment($admmail,$email,$nama,$address,$note_ol,$city,$prov,$layanan,$etd,$tarif,$telp,$method,$vouc,$action_voucherx,$inv,$date_maju,$total_berat,$grandTotal);
}
				
			}
		}
	}

	function mailTocustomer($mail,$nama,$address,$note_ol,$city,$prov,$layanan,$etd,$tarif,$telp,$method,$vouc,$action_voucherx,$invoice,$date_maju,$total_berat,$grandTotal){

		foreach ($this->cart->contents() as $item){

			if($item['diskon'] == "" || $item['diskon'] == 0){
				$discft = "";
			}else{
				$discft = "<i style='font-size: 10px;padding:3px;background-color:red;color:white;' class='label-diskon-detail'>".$item['diskon']."%</i>";
			}

			foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
				if(empty($option_value)){
					$ukr = "";
					$wrn = "";
				}else{
					$option = $item['options'];
					$ukr = "<li class='gf' style='font-size:10px;'>Ukuran : ".$option['Size']."</li>";
					$wrn =  "<li class='gf' style='font-size:10px;'>Warna : ".$option['Warna']."</li>";
				}
			}

			if($item['before'] == "0"){
				$hg_before = "";
			}else{
				$hg_before = "<s style='color:#a8a8a8;font-weight:initial;'>Rp. ".number_format($item['before'],0,".",".")."</s>";
			}

			$dp[] = array(
				'nama_produk'		=> $item['name'],
				'artikel'			=> $item['artikel'],
				'merk'				=> $item['merk'],
				'diskon'			=> $discft,
				'ukuran'			=> $ukr,
				'warna'				=> $wrn,
				'qty'				=> $item['qty'],
				'harga_before'		=> $hg_before,
				'harga_fix'			=> number_format($item['price'],0,".","."),
			);
		}

		// LOAD METHOD DETAIL
		if($method == "transfer"){ // ubah $method
			$loaddatabank = $this->checkout_model->load_bank_data();
			foreach($loaddatabank as $y){
				$method_detail[] =  
					array(
						'nama_bank'		=> "Nama Bank : ".$y->name_bank."<br>",
						'cabang'		=> "Cabang : ".$y->bank_cabang."<br>",
						'a_n'			=> "A.N : ".$y->a_n."<br>",
						'nomor'			=> "Nomor Rekening : ".$y->no_rek."<br><br>",
					);

					//"
					//Nama Bank : ".$y->name_bank."<br>
					//Cabang : ".$y->bank_cabang."<br>
					//A.N : ".$y->a_n."<br>
					//Nomor Rekening : ".$y->no_rek."<br><br>
					//";
				$instruksi = "Silahkan transfer pada salah satu nomor rekening berikut :<br><br>";
			}
		}else if($method == "cc_card"){
			$method_detail[] = 
					array(
						'nama_bank'		=> "",
						'cabang'		=> "",
						'a_n'			=> "",
						'nomor'			=> "",
					);
			$instruksi = "";
		}else{
			$method_detail[] = 
					array(
						'nama_bank'		=> "",
						'cabang'		=> "",
						'a_n'			=> "",
						'nomor'			=> "",
					);
			$instruksi = "";
		}

		$data_cs = array(
	            'inv'      => $invoice,
	            'tglOrdercs' => date('d F Y H:i:s'),
	            'tglExp'   => $date_maju, //30 minutes
	            'nmlkp'    => $nama,
	            'almtkp'   => $address,
	            'note' 	   => $note_ol,
	            'kota'     => $city,
	            'prov'     => $prov,
	            'layanan'  => $layanan,
	            'etd'      => $etd,
	            'tarif'    => number_format($tarif,0,".","."),
	            'noTelp'   => $telp,
	            'methode'  => $method,
	            'instruksi' => $instruksi,
	            'methoddetail' => $method_detail,
	            //'bnk_option' => $banking_select,
	            //'cabang'   => $banking_inf_cab,
	            //'no_rek'   => $banking_inf_no,
	            //'an_bnk'   => $banking_inf_an,
	            'voucher'  => strtoupper($vouc),
	            'action_voucher' => $action_voucherx,
	            //'subtotal' => number_format($item['subtotal'],0,".","."),
	            'kode_pembayaran' => 0,//$this->session->userdata('unik'), // tidak pakai kode unik$this->session->userdata('unik'),
	            'total_belanja' => number_format($grandTotal,0,".","."),
	            'berat_total' => $total_berat/1000,
	            'data_order' => $dp
	        );

	      	$config = Array(
				'mailtype'  => 'html', 
			);
			
			$this->email->initialize($config);

			$this->load->library('parser');
	      	$this->email->from('belanja@starsstore.id'); // change it to yours
	      	$this->email->to($mail);// change it to yours
	      	$this->email->subject('Pesanan Anda di Starsstore.id #'.$invoice.'');
	      	$body = $this->parser->parse('em_info_notification_group/f_cus_mail_order',$data_cs,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
	      	//redirect($this->agent->referrer());
	}

	//$banking_select,$banking_inf_cab,$banking_inf_no,$banking_inf_an,
	function mailToadmin($admmail,$mail,$nama,$address,$note_ol,$city,$prov,$layanan,$etd,$tarif,$telp,$method,$vouc,$action_voucherx,$invoice,$date_maju,$total_berat,$grandTotal){

		foreach ($this->cart->contents() as $item){

			if($item['diskon'] == "" || $item['diskon'] == 0){
				$discft = "";
			}else{
				$discft = "<i style='font-size: 10px;padding:3px;background-color:red;color:white;' class='label-diskon-detail'>".$item['diskon']."%</i>";
			}
			foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
			if(empty($option_value)){
				$ukr = "";
				$wrn = "";
			}else{
				$option = $item['options'];
				$ukr = "<li class='gf'>Ukuran : ".$option['Size']."</li>";
				$wrn =  "<li class='gf'>Warna : ".$option['Warna']."</li>";
			}
			}

			if($item['before'] == "0"){
				$hg_before = "";
			}else{
				$hg_before = "<s style='color:#a8a8a8;font-weight:initial;'>Rp. ".number_format($item['before'],0,".",".")."</s>";
			}

			$dp[] = array(
				'nama_produk'		=> $item['name'],
				'artikel'			=> $item['artikel'],
				'merk'				=> $item['merk'],
				'diskon'			=> $discft,
				'ukuran'			=> $ukr,
				'warna'				=> $wrn,
				'qty'				=> $item['qty'],
				'harga_before'		=> $hg_before,
				'harga_fix'			=> number_format($item['price'],0,".","."),
			);
		}

		// LOAD METHOD DETAIL
		if($method == "transfer"){ // ubah $method

			// jika transfer bank tidak menampilkan data bank, cukup metode pembayarannya dia pakai...
			//$loaddatabank = $this->checkout_model->load_bank_data();
			//foreach($loaddatabank as $y){
				$method_detail[] =  
					array(
						'nama_bank'		=> "",
						'cabang'		=> "",
						'a_n'			=> "",
						'nomor'			=> "",
					);

					//"
					//Nama Bank : ".$y->name_bank."<br>
					//Cabang : ".$y->bank_cabang."<br>
					//A.N : ".$y->a_n."<br>
					//Nomor Rekening : ".$y->no_rek."<br><br>
					//";
				$instruksi = "";
			//}
		}else if($method == "cc_card"){
			$method_detail[] = 
					array(
						'nama_bank'		=> "",
						'cabang'		=> "",
						'a_n'			=> "",
						'nomor'			=> "",
					);
			$instruksi = "";
		}else{
			$method_detail[] = 
					array(
						'nama_bank'		=> "",
						'cabang'		=> "",
						'a_n'			=> "",
						'nomor'			=> "",
					);
			$instruksi = "";
		}

		$data_cs = array(
            'inv'      => $invoice,
            'tglOrdercs' => date('d F Y H:i:s'),
            'tglExp'   => $date_maju,
            'nmlkp'    => $nama,
            'almtkp'   => $address,
            'note' 	   => $note_ol,
            'kota'     => $city,
            'prov'     => $prov,
            'layanan'  => $layanan,
            'etd'      => $etd,
            'tarif'    => number_format($tarif,0,".","."),
            'noTelp'   => $telp,
            'methode'  => $method,
            'instruksi' => $instruksi,
            'methoddetail' => $method_detail,
            //'bnk_option' => $banking_select,
            //'cabang'   => $banking_inf_cab,
            //'no_rek'   => $banking_inf_no,
            //'an_bnk'   => $banking_inf_an,
            'voucher'  => strtoupper($vouc),
            'action_voucher' => $action_voucherx,
            //'subtotal' => number_format($item['subtotal'],0,".","."),
            'kode_pembayaran' => 0,//$this->session->userdata('unik'), // tidak pakai kode unik
            'total_belanja' => number_format($grandTotal,0,".","."),
            'berat_total' => $total_berat/1000,
            'data_order' => $dp
         );
      	$config = Array(
			'mailtype'  => 'html', 
		);
		
		$this->email->initialize($config);

		$this->load->library('parser');
      	$this->email->from('admin@starsstore.id'); // change it to yours
      	$this->email->to($admmail);// change it to yours
      	//$this->email->bcc();
      	$this->email->subject('Admin! Ada Pesanan Baru #'.$invoice.'');
      	$body = $this->parser->parse('em_info_notification_group/f_cus_mail_order_for_adm_manage',$data_cs,TRUE);
      	$this->email->message($body);
      	$this->email->send();

      	//// DESTROY KUPON & CART ////////////////////////////////////////////////////////////////////////////////////////////////////////////

		if($this->session->userdata('kupon') != ""){
			$this->session->unset_userdata('kupon ');
			$this->session->unset_userdata('action');
			$this->session->unset_userdata('keterangan');
			$this->session->unset_userdata('type');
			$this->session->unset_userdata('valid');
			$this->session->unset_userdata('access');
		}

		$this->session->unset_userdata('invoice');
		$this->session->unset_userdata('random');
      	$this->cart->destroy();

      	redirect(base_url('success'));
	}

	function mailTocustomer_for_other_payment($admmail,$mail,$nama,$address,$note_ol,$city,$prov,$layanan,$etd,$tarif,$telp,$method,$vouc,$action_voucherx,$invoice,$date_maju,$total_berat,$grandTotal){

		foreach ($this->cart->contents() as $item){

			if($item['diskon'] == "" || $item['diskon'] == 0){
				$discft = "";
			}else{
				$discft = "<i style='font-size: 10px;padding:3px;background-color:red;color:white;' class='label-diskon-detail'>".$item['diskon']."%</i>";
			}
			foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
			if(empty($option_value)){
				$ukr = "";
				$wrn = "";
			}else{
				$option = $item['options'];
				$ukr = "<li class='gf'>Ukuran : ".$option['Size']."</li>";
				$wrn =  "<li class='gf'>Warna : ".$option['Warna']."</li>";
			}
			}

			if($item['before'] == "0"){
				$hg_before = "";
			}else{
				$hg_before = "<s style='color:#a8a8a8;font-weight:initial;'>Rp. ".number_format($item['before'],0,".",".")."</s>";
			}

			$dp[] = array(
				'nama_produk'		=> $item['name'],
				'artikel'			=> $item['artikel'],
				'merk'				=> $item['merk'],
				'diskon'			=> $discft,
				'ukuran'			=> $ukr,
				'warna'				=> $wrn,
				'qty'				=> $item['qty'],
				'harga_before'		=> $hg_before,
				'harga_fix'			=> number_format($item['price'],0,".","."),
			);
		}

		// LOAD METHOD DETAIL
		if($method == "transfer"){ // ubah $method

			// jika transfer bank tidak menampilkan data bank, cukup metode pembayarannya dia pakai...
			//$loaddatabank = $this->checkout_model->load_bank_data();
			//foreach($loaddatabank as $y){
				$method_detail[] =  
					array(
						'nama_bank'		=> "",
						'cabang'		=> "",
						'a_n'			=> "",
						'nomor'			=> "",
					);

					//"
					//Nama Bank : ".$y->name_bank."<br>
					//Cabang : ".$y->bank_cabang."<br>
					//A.N : ".$y->a_n."<br>
					//Nomor Rekening : ".$y->no_rek."<br><br>
					//";
				$instruksi = "";
			//}
		}else if($method == "cc_card"){
			$method_detail[] = 
					array(
						'nama_bank'		=> "",
						'cabang'		=> "",
						'a_n'			=> "",
						'nomor'			=> "",
					);
			$instruksi = "";
		}else{
			$method_detail[] = 
					array(
						'nama_bank'		=> "",
						'cabang'		=> "",
						'a_n'			=> "",
						'nomor'			=> "",
					);
			$instruksi = "";
		}

		$data_cs = array(
            'inv'      => $invoice,
            'tglOrdercs' => date('d F Y H:i:s'),
            'tglExp'   => $date_maju,
            'nmlkp'    => $nama,
            'almtkp'   => $address,
            'note' 	   => $note_ol,
            'kota'     => $city,
            'prov'     => $prov,
            'layanan'  => $layanan,
            'etd'      => $etd,
            'tarif'    => number_format($tarif,0,".","."),
            'noTelp'   => $telp,
            'methode'  => $method,
            'instruksi' => $instruksi,
            'methoddetail' => $method_detail,
            //'bnk_option' => $banking_select,
            //'cabang'   => $banking_inf_cab,
            //'no_rek'   => $banking_inf_no,
            //'an_bnk'   => $banking_inf_an,
            'voucher'  => strtoupper($vouc),
            'action_voucher' => $action_voucherx,
            //'subtotal' => number_format($item['subtotal'],0,".","."),
            'kode_pembayaran' => 0,//$this->session->userdata('unik'), // tidak pakai kode unik
            'total_belanja' => number_format($grandTotal,0,".","."),
            'berat_total' => $total_berat/1000,
            'data_order' => $dp
         );
      	$config = Array(
			'mailtype'  => 'html', 
		);
		
		$this->email->initialize($config);

		$this->load->library('parser');
      	$this->email->from('admin@starsstore.id'); // change it to yours
      	$this->email->to($admmail);// change it to yours
      	//$this->email->bcc();
      	$this->email->subject('Admin! Ada Pesanan Baru #'.$invoice.'');
      	$body = $this->parser->parse('em_info_notification_group/f_cus_mail_order_for_adm_manage',$data_cs,TRUE);
      	$this->email->message($body);
      	$this->email->send();

      	//// DESTROY KUPON & CART ////////////////////////////////////////////////////////////////////////////////////////////////////////////

		if($this->session->userdata('kupon') != ""){
			$this->session->unset_userdata('kupon ');
			$this->session->unset_userdata('action');
			$this->session->unset_userdata('keterangan');
			$this->session->unset_userdata('type');
			$this->session->unset_userdata('valid');
			$this->session->unset_userdata('access');
		}

		$this->session->unset_userdata('invoice');
		$this->session->unset_userdata('random');
      	$this->cart->destroy();

      	redirect(base_url('success'));
	}

	function unfinish(){
		$this->session->set_flashdata('error','Terjadi Kesalahan, Mohon ulangi kembali');
		redirect($this->agent->referrer());
	}

	function success(){
		$data['title'] = "<title>Pesanan Baru</title>";
		$data['meta_desc'] = "<meta name='description' content='pesanan telah selesai' />";
		$data['meta_key'] = "<meta name='keywords' content='pesanan selesai'/>";
		$this->load->view('theme/v1/header', $data);
		$this->load->view('theme/v1/success');
		$this->load->view('theme/v1/footer');
	}

	function notifPesanan(){

		$this->load->model('adm21stellar/order_adm');

		echo 'test notification handler';
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);

		if($result){ 
			$notif = $this->veritrans->status($result->order_id);
		}

		//error_log(print_r($result,TRUE));

		//notification handler sample

		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;
		//$inv = $order_id;

		if ($transaction == 'capture') {
		  	// For credit card transaction, we need to check whether transaction is challenge by FDS or not
		  	if ($type == 'credit_card'){
		    	if($fraud == 'challenge'){
		     		// TODO set payment status in merchant's database to 'Challenge by FDS'
		      		// TODO merchant should decide whether this transaction is authorized or not in MAP
		      		$status = "2hd8jPl613!2_^5";
		      		$content = "Silahkan melakukan pembayaran untuk pesanan anda #".$order_id."";
		      		// change status
					$this->order_adm->changeStat1($order_id,$status);
		      		//echo "Transaction order_id: " . $order_id ." is challenged by FDS";
		    	}else {
		      		// TODO set payment status in merchant's database to 'Success'
		      		$status = "*^56t38H53gbb^%$0-_-";
		      		$content = "Pembayaran untuk pesanan anda #".$order_id." telah kami terima, kami segera memproses pesanan anda. terima kasih";
		      		// change status
					$this->order_adm->changeStat1($order_id,$status);
					// get email customer 
					$getMail = $this->order_adm->get_mail($order_id);
					$mailCs = $getMail['email'];

					$data_order = array(
						'invoice' 	=> $order_id,
						'status'	=> $status,
						'content'	=> $content
					);

					$config = Array(
						'mailtype'  => 'html', 
					);

					$this->email->initialize($config);
			      	$this->email->from('belanja@starsstore.id'); // change it to yours
			      	$this->email->to($mailCs);// change it to yours
			      	$this->email->subject('Order anda');
			      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
			      	$this->email->message($body);
			      	$this->email->send();
					log_helper('onlinestore', '[SISTEM] Mengubah status Order Invoice #'.$order_id.' menjadi '.$status.'');
		      		//echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
		      	}
		    }
		}else if($transaction == 'settlement'){
		  	// TODO set payment status in merchant's database to 'Settlement'
      		$status = "*^56t38H53gbb^%$0-_-";
      		$content = "Pembayaran untuk pesanan anda #".$order_id." telah kami terima, kami segera memproses pesanan anda. terima kasih";
      		// change status
			$this->order_adm->changeStat1($order_id,$status);
			// get email customer 
			$getMail = $this->order_adm->get_mail($order_id);
			$mailCs = $getMail['email'];

			$data_order = array(
				'invoice' 	=> $order_id,
				'status'	=> $status,
				'content'	=> $content
			);

			$config = Array(
				'mailtype'  => 'html', 
			);

			$this->email->initialize($config);
	      	$this->email->from('belanja@starsstore.id'); // change it to yours
	      	$this->email->to($mailCs);// change it to yours
	      	$this->email->subject('Order anda');
	      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
			log_helper('onlinestore', '[SISTEM] Mengubah status Order Invoice #'.$order_id.' menjadi '.$status.'');
		  	//echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
		}else if($transaction == 'pending'){
		  	// TODO set payment status in merchant's database to 'Pending'
		  	$status = "2hd8jPl613!2_^5";
		  	$content = "Silahkan melakukan pembayaran untuk pesanan anda #".$order_id."";
		  	// change status
			$this->order_adm->changeStat1($order_id,$status);
		  	//echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
		}else if ($transaction == 'deny') {
		  	// TODO set payment status in merchant's database to 'Denied'
		  	$status = "batal";
		  	$content = "Pesanan anda #".$order_id." kami cancel, karena tidak memenuhi syarat.";
		  	// change status
			$this->order_adm->changeStat1($order_id,$status);
			// get email customer 
			$getMail = $this->order_adm->get_mail($order_id);
			$mailCs = $getMail['email'];

			$data_order = array(
				'invoice' 	=> $order_id,
				'status'	=> $status,
				'content'	=> $content
			);

			$config = Array(
				'mailtype'  => 'html', 
			);

			$this->email->initialize($config);
	      	$this->email->from('belanja@starsstore.id'); // change it to yours
	      	$this->email->to($mailCs);// change it to yours
	      	$this->email->subject('Order anda');
	      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
			log_helper('onlinestore', '[SISTEM] Mengubah status Order Invoice #'.$order_id.' menjadi '.$status.'');
		  	//echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
		}else if($transaction == "cancel"){
			$status = "batal";
			$content = "Pesanan anda #".$order_id." kami cancel, karena tidak memenuhi syarat.";
			// change status
			$this->order_adm->changeStat1($order_id,$status);
			// get email customer 
			$getMail = $this->order_adm->get_mail($order_id);
			$mailCs = $getMail['email'];

			$data_order = array(
				'invoice' 	=> $order_id,
				'status'	=> $status,
				'content'	=> $content
			);

			$config = Array(
				'mailtype'  => 'html', 
			);

			$this->email->initialize($config);
	      	$this->email->from('belanja@starsstore.id'); // change it to yours
	      	$this->email->to($mailCs);// change it to yours
	      	$this->email->subject('Order anda');
	      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
			log_helper('onlinestore', '[SISTEM] Mengubah status Order Invoice #'.$order_id.' menjadi '.$status.'');
		  	//echo "Payment using " . $type . " for transaction order_id: " . $order_id . " cancel by merchant.";

		}else if($transaction == "expire"){
			$status = "batal";
			$content = "Pesanan anda #".$order_id." kami cancel, karena telah kadaluarsa.";
			// change status
			$this->order_adm->changeStat1($order_id,$status);
			// get email customer 
			$getMail = $this->order_adm->get_mail($order_id);
			$mailCs = $getMail['email'];

			$data_order = array(
				'invoice' 	=> $order_id,
				'status'	=> $status,
				'content'	=> $content
			);

			$config = Array(
				'mailtype'  => 'html', 
			);

			$this->email->initialize($config);
	      	$this->email->from('belanja@starsstore.id'); // change it to yours
	      	$this->email->to($mailCs);// change it to yours
	      	$this->email->subject('Order anda');
	      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
			log_helper('onlinestore', '[SISTEM] Mengubah status Order Invoice #'.$order_id.' menjadi '.$status.'');
		  	//echo "Payment using " . $type . " for transaction order_id: " . $order_id . " cancel by merchant.";
		}else if($transaction == "refund"){
			$status = "batal";
			$content = "Pesanan anda #".$order_id." kami cancel, dan dana telah dikembalikan kepada anda.";
			// change status
			$this->order_adm->changeStat1($order_id,$status);
			// get email customer 
			$getMail = $this->order_adm->get_mail($order_id);
			$mailCs = $getMail['email'];

			$data_order = array(
				'invoice' 	=> $order_id,
				'status'	=> $status,
				'content'	=> $content
			);

			$config = Array(
				'mailtype'  => 'html', 
			);

			$this->email->initialize($config);
	      	$this->email->from('belanja@starsstore.id'); // change it to yours
	      	$this->email->to($mailCs);// change it to yours
	      	$this->email->subject('Order anda');
	      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
			log_helper('onlinestore', '[SISTEM] Mengubah status Order Invoice #'.$order_id.' menjadi '.$status.'');
		  	//echo "Payment using " . $type . " for transaction order_id: " . $order_id . " cancel by merchant.";
		}else if($transaction == "partial_refund"){
			$status = "*^56t38H53gbb^%$0-_-";
			$content = "Pesanan anda #".$order_id." kami proses, dan dana telah sebagian dikembalikan kepada anda.";
			// change status
			$this->order_adm->changeStat1($order_id,$status);
			// get email customer 
			$getMail = $this->order_adm->get_mail($order_id);
			$mailCs = $getMail['email'];

			$data_order = array(
				'invoice' 	=> $order_id,
				'status'	=> $status,
				'content'	=> $content
			);

			$config = Array(
				'mailtype'  => 'html', 
			);

			$this->email->initialize($config);
	      	$this->email->from('belanja@starsstore.id'); // change it to yours
	      	$this->email->to($mailCs);// change it to yours
	      	$this->email->subject('Order anda');
	      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
			log_helper('onlinestore', '[SISTEM] Mengubah status Order Invoice #'.$order_id.' menjadi '.$status.'');
		  	//echo "Payment using " . $type . " for transaction order_id: " . $order_id . " cancel by merchant.";
		}

	}


	//function kirimemail(){
	    //$data = array(
          //  'inv'        => "Jsh22531",
        //    'tglOrdercs' => date('d F Y H:i:s'),
      //      'tglExp'     => date('Y-m-d'),
    //        'nmlkp'      => "danny",
  //      );
//
//		$pengaturan = array(
//			'mailtype'  => 'html', 
//		);
//		
//		$this->email->initialize($pengaturan);
//		
//		$body = $this->load->view('email/f_cus_mail_order',$data,TRUE);
//			
//		$this->email->from('dannysetyawan1@gmail.com');
//		$this->email->to('dannysetyawan2@gmail.com');
//		//$this->email->cc('another@another-example.com');
//		//$this->email->bcc('them@their-example.com');
//		$this->email->subject('Email Test');
//		$this->email->message($body);
//		if($this->email->send()){
//			echo "berhasil";
//		}else{
//			show_error($this->email->print_debugger());
//		}
//	}

}