<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('cart_model');   
		$this->load->model(array('home','users')); 
		$this->session->unset_userdata('check_success');
		$this->data['id'] = $this->session->userdata('id');
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

	function index(){
		$data['kupon']	= $this->cart_model->get_all_coupon();
		$data['get_rand'] = $this->cart_model->get_produk_random();
		$this->session->set_flashdata('success', '');
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
		//$data_point['totalPoint'] = $t_point;
		// generate id transaksi
		//$uniqid = md5(time() . mt_rand(1,1000000));
		$id1 = $this->encrypt->encode("*J72Hy390_2*");
		$securecode = base64_encode($id1);

		$data['total_berat'] = $sum;
		$data['id_transaksi'] = $securecode;
		//$this->session->set_userdata($data_point); 
		$this->session->set_flashdata('success', '');
		$this->load->view('theme/v1/header');
		$this->load->view('theme/v1/cart', $data);
		$this->load->view('theme/v1/footer');
	}

	function cekValid(){

		// JIKA SISTEM FREE ONGKIR ALL CITY = ON
		$r = free_ongkir_all_city();
        if($r['aktif'] == "on"){        
        	echo "Gratis Ongkir";
        }else{
			// cek kota cover free ongkir
			$destination = $this->security->xss_clean($this->input->get('h')); // idkota

			$cekKota = $this->cart_model->cekKota($destination);
			if($cekKota > 0){
				echo "200";
			}else{

				$origin = "444"; // ID surabaya
				$ttt = $this->security->xss_clean($this->input->get('g'));
				$www = base64_decode($ttt);
				$berat = $this->encrypt->decode($www);
				$courier = "jne"; // KURIR JNE
				
				// OPSI PILIHAN KURIR DINONAKTIFKAN 

				//echo "	<div class='cc-selector'>";
				//$ex = $this->cart_model->get_ex();
				//foreach($ex as $x){
				//	echo "<input id='".$x->nama."' class='courier' type='radio' name='courier' onclick='get_courier(this)' value='".$x->nama."' required />
				//		  	<label class='courier-cc ".$x->nama."' for='".$x->nama."'></label>";
				//}
				//echo "</div>";


				$curl = curl_init();
				$proxy = '192.168.0.219:80';

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
				  //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10, 
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
				  CURLOPT_HTTPHEADER => array(
				    "content-type: application/x-www-form-urlencoded",
				    "key: 8e7d9a6d463e525fc266871130a04f88" 
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if($err){
				  echo "Periksa koneksi internet anda.";//"cURL Error #:" . $err;
				}else{
				  //echo $response;
				  $data = json_decode($response, true);
					for ($k=0; $k < count($data['rajaongkir']['results']); $k++) {
						if(!$data['rajaongkir']['results'][$k]['costs']){
							echo "Expedisi tidak tersedia, silahkan pilih expedisi lain."; 
						}else{
							for ($l=0; $l < count($data['rajaongkir']['results'][$k]['costs']); $l++) {			 
					      		$tarif1 = $data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value'];
					      		$tarif2 = $this->encrypt->encode($tarif1);
					      		$tarif = base64_encode($tarif2);

					      		echo "
					      			<div class='radio'>
										<label style='width: 100%;'>
											<h5 style='margin-top:2px;'>Estimasi ".$data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['etd']." hari  &nbsp<b class='pull-right'>Rp. ".number_format($data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value'],0,".",".")."</b>
											</h5>
										</label>
									</div>
					      			";
					      	}
						}

					}

				}

			}
		}
	}

	// PERHITUNGAN ONGKIR UNTUK HALAMAN CHECKOUT
	function cekCity(){

		// JIKA SISTEM FREE ONGKIR ALL CITY = ON
		$r = free_ongkir_all_city();
        if($r['aktif'] == "on"){        
        	echo "
					<div class='radio' style='margin-top:0;'>
						<label style='width: 100%;'>
						<input checked required data-price='0' style='display:none;' onclick='getPriceongkir(this)' type='radio' name='checkshipping' 

						value='JNE|3-4 hari|0'>
							<h5 style='margin-top:2px;'>Gratis Ongkir  &nbsp<b class='pull-right'>Rp. 0</b>
							</h5>
						</label>
					</div>
				";
        }else{
			// cek kota cover free ongkir
			$destination = $this->security->xss_clean($this->input->get('h')); // idkota
			$cekKota = $this->cart_model->cekKota($destination);
			if($cekKota > 0){
				echo "200";
			}else{

				if($this->session->userdata("type") == "ongkir_apply"){
					echo "
							<div class='radio'>
								<label style='width: 100%;'>
								<input checked required data-price='0' onclick='getPriceongkir(this)' type='radio' name='checkshipping' 

								value='JNE|3-4 hari|0'>
									<h5 style='margin-top:2px;'>Estimasi 3-4 hari  &nbsp<b class='pull-right'>Rp. 0</b>
									</h5>
								</label>
							</div>
						";

				}else{

					$origin = "444"; // ID surabaya
					$ttt = $this->security->xss_clean($this->input->get('g'));
					$www = base64_decode($ttt);
					$berat = $this->encrypt->decode($www);
					$courier = "jne"; // KURIR JNE
					
					// OPSI PILIHAN KURIR DINONAKTIFKAN 

					//echo "	<div class='cc-selector'>";
					//$ex = $this->cart_model->get_ex();
					//foreach($ex as $x){
					//	echo "<input id='".$x->nama."' class='courier' type='radio' name='courier' onclick='get_courier(this)' value='".$x->nama."' required />
					//		  	<label class='courier-cc ".$x->nama."' for='".$x->nama."'></label>";
					//}
					//echo "</div>";


					$curl = curl_init();
					$proxy = '192.168.0.219:80';

					curl_setopt_array($curl, array(
					  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
					  //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10, 
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
					  CURLOPT_HTTPHEADER => array(
					    "content-type: application/x-www-form-urlencoded",
					    "key: 8e7d9a6d463e525fc266871130a04f88"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if($err){
					  echo "Periksa koneksi internet anda.";//"cURL Error #:" . $err;
					}else{
					  //echo $response;
					  $data = json_decode($response, true);
						for ($k=0; $k < count($data['rajaongkir']['results']); $k++) {
							if(!$data['rajaongkir']['results'][$k]['costs']){
								echo "Expedisi tidak tersedia, silahkan pilih expedisi lain."; 
							}else{
								for ($l=0; $l < count($data['rajaongkir']['results'][$k]['costs']); $l++) {			 
						      		$tarif1 = $data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value'];
						      		$tarif2 = $this->encrypt->encode($tarif1);
						      		$tarif = base64_encode($tarif2);

						      		echo "
						      			<div class='radio'>
											<label style='width: 100%;'>
											<input required data-price='".$data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value']."' onclick='getPriceongkir(this)' type='radio' name='checkshipping' 

											value='".strtoupper($data['rajaongkir']['results'][$k]['name']).",".$data['rajaongkir']['results'][$k]['costs'][$l]['service'].",".$data['rajaongkir']['results'][$k]['costs'][$l]['description']."|".$data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['etd']."hari|".$tarif."'>
												<h5 style='margin-top:2px;'>Estimasi ".$data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['etd']." hari  &nbsp<b class='pull-right'>Rp. ".number_format($data['rajaongkir']['results'][$k]['costs'][$l]['cost'][0]['value'],0,".",".")."</b>
												</h5>
											</label>
										</div>
						      			";
						      	}
							}

						}

					}
				}

			}
		}
	}

	// END PERHITUNGAN ONGKIR UNTUK HALAMAN CHECKOUT

	function update(){
		$a1 = base64_decode($this->input->post('olbnm')); 
		$id = $this->encrypt->decode($a1);

		$a2 = base64_decode($this->input->post('fqazx')); 
		$name = $this->encrypt->decode($a2);

		$a3 = base64_decode($this->input->post('cf')); 
		$idc = $this->encrypt->decode($a3);

		$a4 = base64_decode($this->input->post('sfz')); 
		$ids = $this->encrypt->decode($a4);
		
		$rowid 	= $this->input->post('rowid');
		$qty 	= $this->input->post('qty');

		$cek_stok = $this->cart_model->cek_stok_produk($id, $idc, $ids);
			foreach($cek_stok as $stok_db){
		}

		if($qty == 0){
			$this->session->set_flashdata('error', 'Quantity harus diatas 0');
			redirect('cart');
		}

		$stok_in_db = $stok_db->stok;
		if($qty <= $stok_in_db){
            $info = array(
                'rowid' => $rowid,
                'qty'   => $qty
            );
            $this->cart->update($info);
            $this->session->set_flashdata('berhasil', 'Quantity produk <b>'.$name.'</b> berhasil diubah!');

            // JIKA ADA VOUCHER MAKA TERAPKAN ATURAN VOUCHER
            if(!empty($this->session->userdata('kupon'))){ 

	             // rumus baru kode dapat diapply jika telah memenuhi syarat total belanja
				$total_belanja = $this->cart->total();
				$voucher = $this->session->userdata('kupon');
				$ambil_data = $this->cart_model->get_voucher($voucher); // AMBIL ACTION MINIM PEMBELANJAAN
				foreach($ambil_data->result() as $data){
					$minbelanjavoucher = $data->action_minim_pembelanjaan;
					$actionvoucher = $data->action;
					$tipevoucher = $data->type;

					// URAIKAN ACTION APA SATUAN ATAU LEBIH?
					$actx = explode('|', $actionvoucher);
					$identityvoucher = $actx[0];
				}

				if($total_belanja < $minbelanjavoucher){ // jika setelah update minim belanja tidak memenuhi syarat ??
					if($identityvoucher == "free"){ // TIPE VOUCHER BARU (FREE ITEM)
						// hapus free_item
						foreach ($this->cart->contents() as $itemsx){
							if($itemsx['gender'] == "free_item"){
								$produk = array(
						            'rowid' => $itemsx['rowid'],
						            'qty'   => 0,
						        );
						        //print_r($produk);
						        $this->cart->update($produk);
							}
						}
						// hapus voucher
			        	$this->session->unset_userdata('kupon');
						$this->session->unset_userdata('action');
						$this->session->unset_userdata('keterangan');
						$this->session->unset_userdata('type');
						$this->session->unset_userdata('valid');
						$this->session->unset_userdata('access');
						//echo "2";
						$this->session->set_flashdata('error', 'jumlah belanja tidak memenuhi syarat, voucher tidak bisa digunakan');

					}else if($actionvoucher == "" || $actionvoucher != ""){ // JIKA ACTION KOSONG ATAU TIDAK, MAKA HAPUS GRATIS ONGKIR / DISKON
						$this->session->unset_userdata('kupon');
						$this->session->unset_userdata('action');
						$this->session->unset_userdata('keterangan');
						$this->session->unset_userdata('type');
						$this->session->unset_userdata('valid');
						$this->session->unset_userdata('access');
						$this->session->set_flashdata('error', 'jumlah belanja tidak memenuhi syarat, voucher tidak bisa digunakan');
						//echo "1";
					}

				}else if($this->session->userdata('type') == "discplus_apply"){ // jika voucher discount 10%,30%,50%
				// KEMBALIKAN HARGA KE AWAL 
					//echo "3";
	// JIKA BELI 1//
					$total_itemx = $this->cart->total_items();
					if($total_itemx == 1){ // JIKA CUMA 1 PASANG MAKA DIHITUNG DISKON PERTAMA. MISAL 10,30,50 GUNAKAN 10 UNTUK DISKON PRODUKNYA

						foreach ($this->cart->contents() as $items){
							$ubah_harga = array(
								'rowid' 	=> $items['rowid'],
				            	'before' 	=> 0, // harga sebelum diskon (harga awal)
				            	'price'   	=> $items['before'],
				            	'diskon'	=> "",
				        	);

				        	$this->cart->update($ubah_harga);
				        	$this->session->set_flashdata('notif1', 'produk_error_voucher');
	            			$this->session->set_flashdata('baca1', 'Harga dinormalkan, apply voucher lagi');
						}

		// JIKA PRODUK LEBIH DARI 1 PASANG TAPI MENGKLAIM VOUCHER INI GUNAKAN DISKON TERENDAH (YANG PERTAMA)

					}else if($total_itemx > 1){ 

						$harga = array();
		        		foreach ($this->cart->contents() as $items){
		        			$harga[] = $items['subtotal'];

		        			$min = min($harga); // set harga terendah produk
		        			$max = max($harga); // set harga tertinggi produk

		        		}

		        		//PAKAI NOMOR UNTUK MENENTUKAN PSG 1, 2, 3, DST LALU TIAP2 PSG COCOKKAN DENGAN HARGA MIN ATAU MAX, BARU BISA DIKETAHUI DISKONNYA BERAPA.
		    			$no = 0;
		    			foreach ($this->cart->contents() as $items){
		    				$no++;
		// PASANG 1	DISKONKAN TERENDAH
		    				if($no == 1){
								$ubah_harga1 = array(
									'rowid' 	=> $items['rowid'],
					            	'before' 	=> 0, // harga sebelum diskon (harga awal)
					            	'price'   	=> $items['before'],
					            	'diskon'	=> "",
					        	);
					        	$this->cart->update($ubah_harga1);
					        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
	            				$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');

		    				}

		// PASANG 2	DISKONKAN DENGAN ACUAN HARGA HARUS SAMA ATAU LEBIH KECIL DARIPADA PASANG 1
		    				if($no == 2){
								$ubah_harga2 = array(
									'rowid' 	=> $items['rowid'],
					            	'before' 	=> 0, // harga sebelum diskon (harga awal)
					            	'price'   	=> $items['before'],
					            	'diskon'	=> "",
					        	);
					        	$this->cart->update($ubah_harga2);
					        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
	            				$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');
		    				}

		// PASANG 3	DISKONKAN DENGAN ACUAN HARGA HARUS SAMA ATAU LEBIH KECIL DARIPADA PASANG 2
		    				if($no == 3){
								$ubah_harga3 = array(
									'rowid' 	=> $items['rowid'],
					            	'before' 	=> 0, // harga sebelum diskon (harga awal)
					            	'price'   	=> $items['before'],
					            	'diskon'	=> "",
					        	);
					        	$this->cart->update($ubah_harga3);
					        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
	            				$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');
		    				}

		    			} 
		    		}

		    		$this->session->unset_userdata('kupon');
					$this->session->unset_userdata('action');
					$this->session->unset_userdata('keterangan');
					$this->session->unset_userdata('type');
					$this->session->unset_userdata('valid');
					$this->session->unset_userdata('access');

				}//else{
					//$this->session->unset_userdata('kupon');
					//$this->session->unset_userdata('action');
					//$this->session->unset_userdata('keterangan');
					//$this->session->unset_userdata('type');
					//$this->session->unset_userdata('valid');
					//$this->session->unset_userdata('access');
				//}
			}
        redirect('cart');
		}else{
			$this->session->set_flashdata('error', 'Stok terbatas. silahkan isi jumlah yang lain!');
            redirect('cart');
		}        
	}	

	function hapus_item(){
		$id = $this->input->get('id');

		$produk = array(
            'rowid' => $id,
            'qty'   => 0
        );
        $this->cart->update($produk);

        // JIKA ADA VOUCHER MAKA TERAPKAN ATURAN VOUCHER
        if(!empty($this->session->userdata('kupon'))){ 

        	// rumus baru kode dapat diapply jika telah memenuhi syarat total belanja
        	$total_belanja = $this->cart->total();
        	$voucher = $this->session->userdata('kupon');
        	$ambil_data = $this->cart_model->get_voucher($voucher); // AMBIL ACTION MINIM PEMBELANJAAN
			foreach($ambil_data->result() as $data){
				$minbelanjavoucher = $data->action_minim_pembelanjaan;
				$actionvoucher = $data->action;
				$tipevoucher = $data->type;

				// URAIKAN ACTION APA SATUAN ATAU LEBIH?
				$actx = explode('|', $actionvoucher);
				$identityvoucher = $actx[0];
			}
	        if($total_belanja < $minbelanjavoucher){ // jika setelah update minim belanja tidak memenuhi syarat ??
		        if($identityvoucher == "free"){ 
					// hapus free_item
					foreach ($this->cart->contents() as $itemsx){
						if($itemsx['gender'] == "free_item"){
							$produk = array(
					            'rowid' => $itemsx['rowid'],
					            'qty'   => 0,
					        );
					        //print_r($produk);
					        $this->cart->update($produk);
						}
					}
					// hapus voucher
		        	$this->session->unset_userdata('kupon');
					$this->session->unset_userdata('action');
					$this->session->unset_userdata('keterangan');
					$this->session->unset_userdata('type');
					$this->session->unset_userdata('valid');
					$this->session->unset_userdata('access');
					//echo "2";
					$this->session->set_flashdata('error', 'jumlah belanja tidak memenuhi syarat, voucher tidak bisa digunakan');
				}else if($actionvoucher == "" || $actionvoucher != ""){ // JIKA ACTION KOSONG ATAU TIDAK, MAKA HAPUS GRATIS ONGKIR / DISKON
					$this->session->unset_userdata('kupon');
					$this->session->unset_userdata('action');
					$this->session->unset_userdata('keterangan');
					$this->session->unset_userdata('type');
					$this->session->unset_userdata('valid');
					$this->session->unset_userdata('access');
					$this->session->set_flashdata('error', 'jumlah belanja tidak memenuhi syarat, voucher tidak bisa digunakan');
					//echo "1";
				}
	        }else if($this->session->userdata('type') == "discplus_apply"){
				// KEMBALIKAN HARGA KE AWAL 

	// JIKA BELI 1//
				$total_itemx = $this->cart->total_items();
				if($total_itemx == 1){ // JIKA CUMA 1 PASANG MAKA DIHITUNG DISKON PERTAMA. MISAL 10,30,50 GUNAKAN 10 UNTUK DISKON PRODUKNYA

					foreach ($this->cart->contents() as $items){
						$ubah_harga = array(
							'rowid' 	=> $items['rowid'],
			            	'before' 	=> 0, // harga sebelum diskon (harga awal)
			            	'price'   	=> $items['before'],
			            	'diskon'	=> "",
			        	);

			        	$this->cart->update($ubah_harga);
			        	$this->session->set_flashdata('notif1', 'produk_error_voucher');
	            		$this->session->set_flashdata('baca1', 'Harga dinormalkan, apply voucher lagi');
					}

	// JIKA PRODUK LEBIH DARI 1 PASANG TAPI MENGKLAIM VOUCHER INI GUNAKAN DISKON TERENDAH (YANG PERTAMA)

				}else if($total_itemx > 1){ 

					$harga = array();
	        		foreach ($this->cart->contents() as $items){
	        			$harga[] = $items['subtotal'];

	        			$min = min($harga); // set harga terendah produk
	        			$max = max($harga); // set harga tertinggi produk

	        		}

	        		//PAKAI NOMOR UNTUK MENENTUKAN PSG 1, 2, 3, DST LALU TIAP2 PSG COCOKKAN DENGAN HARGA MIN ATAU MAX, BARU BISA DIKETAHUI DISKONNYA BERAPA.
	    			$no = 0;
	    			foreach ($this->cart->contents() as $items){
	    				$no++;
	// PASANG 1	DISKONKAN TERENDAH
	    				if($no == 1){
							$ubah_harga1 = array(
								'rowid' 	=> $items['rowid'],
				            	'before' 	=> 0, // harga sebelum diskon (harga awal)
				            	'price'   	=> $items['before'],
				            	'diskon'	=> "",
				        	);
				        	$this->cart->update($ubah_harga1);
				        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
	            			$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');

	    				}

	// PASANG 2	DISKONKAN DENGAN ACUAN HARGA HARUS SAMA ATAU LEBIH KECIL DARIPADA PASANG 1
	    				if($no == 2){
							$ubah_harga2 = array(
								'rowid' 	=> $items['rowid'],
				            	'before' 	=> 0, // harga sebelum diskon (harga awal)
				            	'price'   	=> $items['before'],
				            	'diskon'	=> "",
				        	);
				        	$this->cart->update($ubah_harga2);
				        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
	            			$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');
	    				}

	// PASANG 3	DISKONKAN DENGAN ACUAN HARGA HARUS SAMA ATAU LEBIH KECIL DARIPADA PASANG 2
	    				if($no == 3){
							$ubah_harga3 = array(
								'rowid' 	=> $items['rowid'],
				            	'before' 	=> 0, // harga sebelum diskon (harga awal)
				            	'price'   	=> $items['before'],
				            	'diskon'	=> "",
				        	);
				        	$this->cart->update($ubah_harga3);
				        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
	            			$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');
	    				}

	    			} 
	    		}

	    		$this->session->unset_userdata('kupon');
				$this->session->unset_userdata('action');
				$this->session->unset_userdata('keterangan');
				$this->session->unset_userdata('type');
				$this->session->unset_userdata('valid');
				$this->session->unset_userdata('access');

			}//else{
				//$this->session->unset_userdata('kupon');
				//$this->session->unset_userdata('action');
				//$this->session->unset_userdata('keterangan');
				//$this->session->unset_userdata('type');
				//$this->session->unset_userdata('valid');
				//$this->session->unset_userdata('access');
			//} 
  		}
	}

	function empty_cart(){
		$this->cart->destroy();
		if($this->session->userdata('type') == "discplus_apply"){
			// KEMBALIKAN HARGA KE AWAL 

// JIKA BELI 1//
			$total_itemx = $this->cart->total_items();
			if($total_itemx == 1){ // JIKA CUMA 1 PASANG MAKA DIHITUNG DISKON PERTAMA. MISAL 10,30,50 GUNAKAN 10 UNTUK DISKON PRODUKNYA

				foreach ($this->cart->contents() as $items){
					$ubah_harga = array(
						'rowid' 	=> $items['rowid'],
		            	'before' 	=> 0, // harga sebelum diskon (harga awal)
		            	'price'   	=> $items['before'],
		            	'diskon'	=> "",
		        	);

		        	$this->cart->update($ubah_harga);
		        	$this->session->set_flashdata('notif1', 'produk_error_voucher');
            		$this->session->set_flashdata('baca1', 'Harga dinormalkan, apply voucher lagi');
				}

// JIKA PRODUK LEBIH DARI 1 PASANG TAPI MENGKLAIM VOUCHER INI GUNAKAN DISKON TERENDAH (YANG PERTAMA)

			}else if($total_itemx > 1){ 

				$harga = array();
        		foreach ($this->cart->contents() as $items){
        			$harga[] = $items['subtotal'];

        			$min = min($harga); // set harga terendah produk
        			$max = max($harga); // set harga tertinggi produk

        		}

        		//PAKAI NOMOR UNTUK MENENTUKAN PSG 1, 2, 3, DST LALU TIAP2 PSG COCOKKAN DENGAN HARGA MIN ATAU MAX, BARU BISA DIKETAHUI DISKONNYA BERAPA.
    			$no = 0;
    			foreach ($this->cart->contents() as $items){
    				$no++;
// PASANG 1	DISKONKAN TERENDAH
    				if($no == 1){
						$ubah_harga1 = array(
							'rowid' 	=> $items['rowid'],
			            	'before' 	=> 0, // harga sebelum diskon (harga awal)
			            	'price'   	=> $items['before'],
			            	'diskon'	=> "",
			        	);
			        	$this->cart->update($ubah_harga1);
			        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            			$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');

    				}

// PASANG 2	DISKONKAN DENGAN ACUAN HARGA HARUS SAMA ATAU LEBIH KECIL DARIPADA PASANG 1
    				if($no == 2){
						$ubah_harga2 = array(
							'rowid' 	=> $items['rowid'],
			            	'before' 	=> 0, // harga sebelum diskon (harga awal)
			            	'price'   	=> $items['before'],
			            	'diskon'	=> "",
			        	);
			        	$this->cart->update($ubah_harga2);
			        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            			$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');
    				}

// PASANG 3	DISKONKAN DENGAN ACUAN HARGA HARUS SAMA ATAU LEBIH KECIL DARIPADA PASANG 2
    				if($no == 3){
						$ubah_harga3 = array(
							'rowid' 	=> $items['rowid'],
			            	'before' 	=> 0, // harga sebelum diskon (harga awal)
			            	'price'   	=> $items['before'],
			            	'diskon'	=> "",
			        	);
			        	$this->cart->update($ubah_harga3);
			        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            			$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');
    				}

    			} 
    		}

    		$this->session->unset_userdata('kupon');
			$this->session->unset_userdata('action');
			$this->session->unset_userdata('keterangan');
			$this->session->unset_userdata('type');
			$this->session->unset_userdata('valid');
			$this->session->unset_userdata('access');

		}else{
			$this->session->unset_userdata('kupon');
			$this->session->unset_userdata('action');
			$this->session->unset_userdata('keterangan');
			$this->session->unset_userdata('type');
			$this->session->unset_userdata('valid');
			$this->session->unset_userdata('access');
		}
		redirect('cart');
	}

	function hapus_voucher($voucher){
		$Vid = base64_decode($voucher);
		$idvoucher = $this->encrypt->decode($Vid);

		$voucher = $idvoucher;
    	$ambil_data = $this->cart_model->get_voucher($voucher); // AMBIL ACTION MINIM PEMBELANJAAN
		foreach($ambil_data->result() as $data){
			$minbelanjavoucher = $data->action_minim_pembelanjaan;
			$actionvoucher = $data->action;
			$tipevoucher = $data->type;

			// URAIKAN ACTION APA SATUAN ATAU LEBIH?
			$actx = explode('|', $actionvoucher);
			$identityvoucher = $actx[0];
		}

	   	if($identityvoucher == "free"){ 
				// hapus free_item
				foreach ($this->cart->contents() as $itemsx){
					if($itemsx['gender'] == "free_item"){
						$produk = array(
				            'rowid' => $itemsx['rowid'],
				            'qty'   => 0,
				        );
				        //print_r($produk);
				        $this->cart->update($produk);
					}
				}
				// hapus voucher
	        	$this->session->unset_userdata('kupon');
				$this->session->unset_userdata('action');
				$this->session->unset_userdata('keterangan');
				$this->session->unset_userdata('type');
				$this->session->unset_userdata('valid');
				$this->session->unset_userdata('access');

		}else if($this->session->userdata('type') == "discplus_apply"){
			// KEMBALIKAN HARGA KE AWAL 

// JIKA BELI 1//
			$total_itemx = $this->cart->total_items();
			if($total_itemx == 1){ // JIKA CUMA 1 PASANG MAKA DIHITUNG DISKON PERTAMA. MISAL 10,30,50 GUNAKAN 10 UNTUK DISKON PRODUKNYA

				foreach ($this->cart->contents() as $items){
					$ubah_harga = array(
						'rowid' 	=> $items['rowid'],
		            	'before' 	=> 0, // harga sebelum diskon (harga awal)
		            	'price'   	=> $items['before'],
		            	'diskon'	=> "",
		        	);

		        	$this->cart->update($ubah_harga);
		        	$this->session->set_flashdata('notif1', 'produk_error_voucher');
            		$this->session->set_flashdata('baca1', 'Harga dinormalkan, apply voucher lagi');
				}

// JIKA PRODUK LEBIH DARI 1 PASANG TAPI MENGKLAIM VOUCHER INI GUNAKAN DISKON TERENDAH (YANG PERTAMA)

			}else if($total_itemx > 1){ 

				$harga = array();
        		foreach ($this->cart->contents() as $items){
        			$harga[] = $items['subtotal'];

        			$min = min($harga); // set harga terendah produk
        			$max = max($harga); // set harga tertinggi produk

        		}

        		//PAKAI NOMOR UNTUK MENENTUKAN PSG 1, 2, 3, DST LALU TIAP2 PSG COCOKKAN DENGAN HARGA MIN ATAU MAX, BARU BISA DIKETAHUI DISKONNYA BERAPA.
    			$no = 0;
    			foreach ($this->cart->contents() as $items){
    				$no++;
// PASANG 1	DISKONKAN TERENDAH
    				if($no == 1){
						$ubah_harga1 = array(
							'rowid' 	=> $items['rowid'],
			            	'before' 	=> 0, // harga sebelum diskon (harga awal)
			            	'price'   	=> $items['before'],
			            	'diskon'	=> "",
			        	);
			        	$this->cart->update($ubah_harga1);
			        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            			$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');
    				}

// PASANG 2	DISKONKAN DENGAN ACUAN HARGA HARUS SAMA ATAU LEBIH KECIL DARIPADA PASANG 1
    				if($no == 2){
						$ubah_harga2 = array(
							'rowid' 	=> $items['rowid'],
			            	'before' 	=> 0, // harga sebelum diskon (harga awal)
			            	'price'   	=> $items['before'],
			            	'diskon'	=> "",
			        	);
			        	$this->cart->update($ubah_harga2);
			        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            			$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');
    				}

// PASANG 3	DISKONKAN DENGAN ACUAN HARGA HARUS SAMA ATAU LEBIH KECIL DARIPADA PASANG 2
    				if($no == 3){
						$ubah_harga3 = array(
							'rowid' 	=> $items['rowid'],
			            	'before' 	=> 0, // harga sebelum diskon (harga awal)
			            	'price'   	=> $items['before'],
			            	'diskon'	=> "",
			        	);
			        	$this->cart->update($ubah_harga3);
			        	$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            			$this->session->set_flashdata('baca'.$no.'', 'Harga dinormalkan, apply voucher lagi');
    				}

    			} 
    		}

    		$this->session->unset_userdata('kupon');
			$this->session->unset_userdata('action');
			$this->session->unset_userdata('keterangan');
			$this->session->unset_userdata('type');
			$this->session->unset_userdata('valid');
			$this->session->unset_userdata('access');

		}else{
			$this->session->unset_userdata('kupon');
			$this->session->unset_userdata('action');
			$this->session->unset_userdata('keterangan');
			$this->session->unset_userdata('type');
			$this->session->unset_userdata('valid');
			$this->session->unset_userdata('access');
		}

		$this->session->set_flashdata('error', 'Voucher '.strtoupper($idvoucher).' tidak digunakan');
		redirect($this->agent->referrer());
	}

	function apply_coupon(){
		// cek jika voucher sudah pernah diapply UNSESSION terlebih dahulu
		if($this->session->userdata('kupon') != ""){
			$this->session->unset_userdata('kupon');
			$this->session->unset_userdata('action');
			$this->session->unset_userdata('keterangan');
			$this->session->unset_userdata('type');
			$this->session->unset_userdata('valid');
			$this->session->unset_userdata('access');
		}

		$id_customer = $this->data['id'];
		$today = date("Y-m-d");
		$voucher = strip_tags($this->security->xss_clean($this->input->get('voucher')));


		// cek jika customer pernah menggunakan voucher ini
		$cek_already_use = $this->cart_model->cek_pengguna($id_customer, $voucher);

		//cek validitas voucher
		$cek_valid = $this->cart_model->cek_validasi_voucher($voucher);
		foreach($cek_valid->result() as $rowone){
			$date = $rowone->valid_until;
			$status = $rowone->aktif;
			$tipe = $rowone->type;
		}

		//cek ketersediaan stok voucher 
		$stok_voucher = $this->cart_model->ambil_quantity_voucher($voucher);
			foreach($stok_voucher as $dat){
				$qty_stok = $dat->qty;
		}

		if(!$this->cart->contents()){
			echo "cart_null";
		}else if($cek_valid->num_rows() == 0){
			//$this->session->set_flashdata('error', 'Kupon tidak valid.');
			//redirect('cart');
			echo "v_n_valid";
		}else if($date < $today){
			//$this->session->set_flashdata('error', 'Kupon sudah expired.');
			//redirect('cart');
			echo "v_ex";
		}else if($cek_already_use->num_rows() > 0){
			//$this->session->set_flashdata('error', 'Kupon '.$voucher.' sudah pernah digunakan.');
			//redirect('cart');
			echo "v_repl";
		}else if($qty_stok == 0){
			//$this->session->set_flashdata('error', 'Kupon '.$voucher.' sudah habis.');
			//redirect('cart');
			echo "v_las";
		}else if($cek_valid->num_rows() > 0 && $today <= $date && $cek_already_use->num_rows() == 0 && $status == "on"){

			if($tipe == "totalbelanja_apply"){ // rumus baru kode dapat diapply jika telah memenuhi syarat total belanja
				$total_belanja = $this->cart->total();

				$ambil_data = $this->cart_model->get_voucher($voucher); // AMBIL ACTION MINIM PEMBELANJAAN
				foreach($ambil_data->result() as $data){
					$minbelanjavoucher = $data->action_minim_pembelanjaan;
					$actionvoucher = $data->action;
					$tipevoucher = $data->type;

					// URAIKAN ACTION APA SATUAN ATAU LEBIH?
					$actx = explode('|', $actionvoucher);
					$identityvoucher = $actx[0];
					//echo count($actx);
				}

				if($total_belanja >= $minbelanjavoucher){
					if($actionvoucher == ""){ // JIKA ACTION KOSONG, TOTAL BELANJA JIKA TERCAPAI MAKA CUSTOMER MENDAPAT GRATIS ONGKIR
						//ambil data voucher valid untuk dijadikan session
						$ambil_data = $this->cart_model->get_voucher($voucher);
						foreach($ambil_data->result() as $data){
							$data_voucher['kupon']	= $data->voucher_and_coupons;
							$data_voucher['action'] 	= $data->action;
							$data_voucher['action_minim'] 	= $data->action_minim_pembelanjaan;
							$data_voucher['keterangan'] = $data->keterangan;
							$data_voucher['type']		= "ongkir_apply"; // ONGKIR APPLY
							$data_voucher['valid']		= $data->valid_until; 
							$data_voucher['access']     = "voucher_validation_ok";
							$this->session->set_userdata($data_voucher);
						}
						
					}else if($identityvoucher == "free"){ // TIPE VOUCHER BARU (FREE ITEM)
						
						$ambil_data = $this->cart_model->get_voucher($voucher);
						foreach($ambil_data->result() as $data){
							$data_voucher['kupon']	= $data->voucher_and_coupons;
							$data_voucher['action'] 	= $data->action;
							$data_voucher['action_minim'] 	= $data->action_minim_pembelanjaan;
							$data_voucher['keterangan'] = $data->keterangan;
							$data_voucher['type']		= "free_item"; // ONGKIR APPLY
							$data_voucher['valid']		= $data->valid_until; 
							$data_voucher['access']     = "voucher_validation_ok";
							$this->session->set_userdata($data_voucher);

							// extract artikel yang akan dijadikan free item
							$art 	= explode('|', $data->action);
							$art 	= $art[1];
							$price 	= $art[2];

							// get data artikel ke database produk
							$t = $this->cart_model->getdata($art);

							//if($t->harga_dicoret > 0 || $t->harga_dicoret != ""){
							//	$disc = round(($t->harga_dicoret - $t->harga_fix) / $t->harga_dicoret * 100); // hitung manual diskon
							//}else{
								$disc = 0;
							//}
							if($t['harga_dicoret'] == "" || $t['harga_dicoret'] == 0){
								$hargaproduk = $t['harga_fix'];
							}else{
								$hargaproduk = $t['harga_dicoret'];
							}

							$data_siap = array(
								'no'			=> 00,
					    		'id' 			=> $t['id_produk'],
					    		'image'			=> $t['gambar'],
					    		'gender'		=> 'free_item',
					    		'name'			=> $t['nama_produk'],
					    		'slug'			=> $t['slug'],
					    		'artikel'		=> $t['artikel'],
					    		'merk'			=> $t['merk'],
					    		'point'			=> $t['point'],
					    		'diskon'		=> $disc,
					    		'berat'			=> $t['berat'],
					    		'price'			=> 0,//round($t->harga_fix),
					    		'before'		=> round($hargaproduk),
					    		//'odv'			=> round($get_odv),
					    		'optidcolor'	=> 1,
					    		'optidsize'		=> 1,
					    		'options'		=> array('Size' => '-', 'Warna' => '-'),
					    		'qty'			=> 1,
					    	);
					    	$this->cart->insert($data_siap);	
						}

					}else if($actionvoucher != ""){ // JIKA ACTION TIDAK KOSONG, TOTAL BELANJA JIKA TERCAPAI MAKA CUSTOMER MENDAPAT DISKON

						//ambil data voucher valid untuk dijadikan session
						$ambil_data = $this->cart_model->get_voucher($voucher);
						foreach($ambil_data->result() as $data){
							$data_voucher['kupon']	= $data->voucher_and_coupons;
							$data_voucher['action'] 	= $data->action;
							$data_voucher['action_minim'] 	= $data->action_minim_pembelanjaan;
							$data_voucher['keterangan'] = $data->keterangan;
							$data_voucher['type']		= "disc_apply"; // ONGKIR APPLY
							$data_voucher['valid']		= $data->valid_until; 
							$data_voucher['access']     = "voucher_validation_ok";
							$this->session->set_userdata($data_voucher);
						}

					}else{
						//ambil data voucher valid untuk dijadikan session
						$ambil_data = $this->cart_model->get_voucher($voucher);
						foreach($ambil_data->result() as $data){
							$data_voucher['kupon']	= $data->voucher_and_coupons;
							$data_voucher['action'] 	= $data->action;
							$data_voucher['action_minim'] 	= $data->action_minim_pembelanjaan;
							$data_voucher['keterangan'] = $data->keterangan;
							$data_voucher['type']		= "disc_apply"; // ONGKIR APPLY
							$data_voucher['valid']		= $data->valid_until; 
							$data_voucher['access']     = "voucher_validation_ok";
							$this->session->set_userdata($data_voucher);
						}						
					}
				}else{
					echo "n_valid_total";
				}



			}else if($tipe == "discplus_apply"){

				//ambil data voucher valid untuk dijadikan session

				$ambil_data = $this->cart_model->get_voucher($voucher);
				foreach($ambil_data->result() as $data){
					$data_voucher['kupon']		= $data->voucher_and_coupons;
					$data_voucher['action'] 	= $data->action;
					$data_voucher['action_minim'] 	= $data->action_minim_pembelanjaan;
					$data_voucher['keterangan'] = $data->keterangan;
					$data_voucher['type']		= $data->type;
					$data_voucher['valid']		= $data->valid_until; 
					$data_voucher['access']     = "voucher_validation_ok";

					$actionvoucher = $data->action;

					// URAIKAN ACTION APA SATUAN ATAU LEBIH?
					$actx = explode(',', $actionvoucher);
					$act = count($actx);
					$action1 = $actx[0];
					
					$action2 = $actx[1];
					$action3 = $actx[2];
					//$action4 = $actx[3];
					//$action5 = $actx[4];
					//$action6 = $actx[5];

					// maksimum diskon cuma sampai 6 diskon plus plus
				}

				// TENTUKAN DISKON PALING KECIL DAN PALING BESAR //
				//$diskonall = array();
        		//$actionv[] = $actx;
        		//foreach($actionv as $v){ // MENDEFINISIKAN DISKON MIN DAN MAX
        		//	$diskonmin = min($v);
        		//	$diskonmax = max($v);

        		//	$diskonall = $v; // VARIABLE GLOBAL DISKON UNTUK DIBANDINGKAN
        		//}        	

// MENCARI DISKON TERENDAH, TERTINGGI, TENGAH2 (MENGURAIKAN)
        		//foreach($diskonall as $vx){
        		//	if($vx == $diskonmin){ // MENCARI DISKON MIN
        		//		$action1 = $vx;
        		//	}

        		//	if($vx == $diskonmax){ // MENCARI DISKON MAX
        		//		$action2 = $vx;
        		//	}

        		//	if($vx != $diskonmin && $vx != $diskonmax){ // MENCARI DISKON TENGAH2, TIDAK TERKECIL TIDAK TERTINGGI
        		//		$actionother = $vx;
        		//	}
        		//}

// MENCARI HARGA TERENDAH, TERTINGGI, TENGAH2 (MENGURAIKAN)
				$total_itemx = $this->cart->total_items();
				if($total_itemx == 1){ // JIKA CUMA 1 PASANG MAKA DIHITUNG DISKON PERTAMA. MISAL 10,30,50 GUNAKAN 10 UNTUK DISKON PRODUKNYA
					// SESSION KAN Voucher
					$this->session->set_userdata($data_voucher);

					foreach ($this->cart->contents() as $items){
						$ubah_harga = array(
							'rowid' 	=> $items['rowid'],
			            	'before' 	=> $items['price'], // harga sebelum diskon (harga awal)
			            	'price'   	=> $items['price'] - ($items['price']*$action1/100), // harga setelah diskon
			            	'diskon'	=> $action1,
			        	);

			        	$this->cart->update($ubah_harga);
					}

					$this->session->set_flashdata('error', 'Diskon telah diterapkan');

				}else if($total_itemx > 1){ // JIKA PRODUK LEBIH DARI 1 PASANG TAPI MENGKLAIM VOUCHER INI GUNAKAN DISKON TERENDAH (YANG PERTAMA)

					$harga = array();
            		foreach ($this->cart->contents() as $items){
            			$harga[] = $items['subtotal'];

            			$min = min($harga); // set harga terendah produk
            			$max = max($harga); // set harga tertinggi produk

            		}

            		//foreach($harga as $x1){

//PAKAI NOMOR UNTUK MENENTUKAN PSG 1, 2, 3, DST LALU TIAP2 PSG COCOKKAN DENGAN HARGA MIN ATAU MAX, BARU BISA DIKETAHUI DISKONNYA BERAPA.
            			$no = 0;
            			foreach ($this->cart->contents() as $items){
            				$no++;
// PASANG 1	DISKONKAN TERENDAH
            				if($no == 1){
            					if($items['qty'] > 1){ // JIKA QUANTITY LEBIH DARI SATU MAKA TIDAK BISA DIHITUNG
            						$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            						$this->session->set_flashdata('baca'.$no.'', 'Voucher tidak bisa klaim produk ini, baca syarat dan ketentuan voucher');


            					}else{
            						$ubah_harga1 = array(
										'rowid' 	=> $items['rowid'],
						            	'before' 	=> $items['price'], // harga sebelum diskon (harga awal)
						            	'price'   	=> $items['price'] - ($items['price']*$action1/100), // harga setelah diskon
						            	'diskon'	=> $action1,
						        	);
						        	$this->cart->update($ubah_harga1);
						        	$hargapasang1 = $items['price'] - ($items['price']*$action1/100);
						        	$this->session->set_flashdata('error', 'Diskon telah diterapkan');

						        	// SESSION KAN Voucher
									$this->session->set_userdata($data_voucher);
            					}

            				}

// PASANG 2	DISKONKAN DENGAN ACUAN HARGA HARUS SAMA ATAU LEBIH KECIL DARIPADA PASANG 1
            				if($no == 2){
            					if($items['qty'] > 1){ // JIKA QUANTITY LEBIH DARI SATU MAKA TIDAK BISA DIHITUNG
            						$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            						$this->session->set_flashdata('baca'.$no.'', 'Voucher tidak bisa klaim produk ini, baca syarat dan ketentuan voucher');

            					}else if($items['price'] <= $hargapasang1){ // HARGA PASANG KE 2 HARUS SAMA / LEBIH KECIL DRPD PASANG 1
            						$ubah_harga2 = array(
										'rowid' 	=> $items['rowid'],
						            	'before' 	=> $items['price'], // harga sebelum diskon (harga awal)
						            	'price'   	=> $items['price'] - ($items['price']*$action2/100), // harga setelah diskon
						            	'diskon'	=> $action2,
						        	);
						        	$this->cart->update($ubah_harga2);
						        	$hargapasang2 = $items['price'] - ($items['price']*$action2/100);
						        	$this->session->set_flashdata('error', 'Diskon telah diterapkan');
						        	// SESSION KAN Voucher
									$this->session->set_userdata($data_voucher);
            					}else{
            						$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            						$this->session->set_flashdata('baca'.$no.'', 'Voucher tidak bisa klaim produk ini, baca syarat dan ketentuan voucher');
            					}
            				}

// PASANG 3	DISKONKAN DENGAN ACUAN HARGA HARUS SAMA ATAU LEBIH KECIL DARIPADA PASANG 2
            				if($no == 3){
            					if($items['qty'] > 1){ // JIKA QUANTITY LEBIH DARI SATU MAKA TIDAK BISA DIHITUNG
            						$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            						$this->session->set_flashdata('baca'.$no.'', 'Voucher tidak bisa klaim produk ini, baca syarat dan ketentuan voucher');
            					}else if($items['price'] <= $hargapasang1){ // HARGA PASANG KE 2 HARUS SAMA / LEBIH KECIL DRPD PASANG 1
            						$ubah_harga3 = array(
										'rowid' 	=> $items['rowid'],
						            	'before' 	=> $items['price'], // harga sebelum diskon (harga awal)
						            	'price'   	=> $items['price'] - ($items['price']*$action3/100), // harga setelah diskon
						            	'diskon'	=> $action3,
						        	);
						        	$this->cart->update($ubah_harga3);
						        	$hargapasang2 = $items['price'] - ($items['price']*$action3/100);
						        	$this->session->set_flashdata('error', 'Diskon telah diterapkan');
						        	// SESSION KAN Voucher
									$this->session->set_userdata($data_voucher);
            					}else{
            						$this->session->set_flashdata('notif'.$no.'', 'produk_error_voucher');
            						$this->session->set_flashdata('baca'.$no.'', 'Voucher tidak bisa klaim produk ini, baca syarat dan ketentuan voucher');
            					}
            				}

            			}            		

            		//}

				}


			}else{

				//simpan kode voucher dan id customer sebagai penanda jika pernah menggunakan kode voucher ini
				//$this->cart_model->simpan_kode_dan_id_customer($id_customer, $voucher);  // FITUR TERBARU REDEEM VOUCHER TANPA LOGIN.  FUNGSI INI BISA DIPAKAI DI MENU CHECKOUT
				
				//mengambil data quantity voucher di database  // FITUR TERBARU REDEEM VOUCHER TANPA LOGIN.  FUNGSI INI BISA DIPAKAI DI MENU CHECKOUT
				//$quantity_voucher = $this->cart_model->ambil_quantity_voucher($voucher);
				//	foreach($quantity_voucher as $res){
				//		$qty_total = $res->qty;
				//	}

				//Kurangi quantity global voucher yang digunakan
				//$this->cart_model->kurangi_quantity_voucher($voucher, $qty_total);

				//ambil data voucher valid untuk dijadikan session
				$ambil_data = $this->cart_model->get_voucher($voucher);
				foreach($ambil_data->result() as $data){
					$data_voucher['kupon']	= $data->voucher_and_coupons;
					$data_voucher['action'] 	= $data->action;
					$data_voucher['action_minim'] 	= $data->action_minim_pembelanjaan;
					$data_voucher['keterangan'] = $data->keterangan;
					$data_voucher['type']		= $data->type;
					$data_voucher['valid']		= $data->valid_until; 
					$data_voucher['access']     = "voucher_validation_ok";

					$this->session->set_userdata($data_voucher);
				}

				$this->session->set_flashdata('berhasil', 'Kupon <b>'.$voucher.'</b> berhasil diterapkan');
				//redirect('cart');
			}


		}
	}
}