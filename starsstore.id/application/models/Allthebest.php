<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Allthebest extends CI_Controller {

	function __construct(){
		parent::__construct(); 
		$this->load->library('encrypt');
		$this->load->model(array('home','users','sec47logaccess/onlinestore_adm')); 

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

	//function generate(){
		//$this->load->view('theme/v1/generate');

		//inialisasi jenis voucher
	//	$voucher1 = "1"; // voucher seharga Rp. 100.000
	//	$voucher2 = "2"; // voucher seharga Rp. 50.000
	//	$voucher3 = "3"; // voucher seharga Rp. 20.000
	//	$voucher4 = "4"; // voucher seharga Rp. 10.000
	//	$voucher5 = "5"; // voucher seharga Rp. 5000

		//generate kode voucher
	//	$length =10000;
	//	$unik= "";
	//	srand((double)microtime()*1000000);
	//	$data2 = "1234567890";

	//	for($i = 0; $i < $length; $i++){
	//		$unik .= substr($data2, (rand()%(strlen($data2))), 1);
	//		$code_voucher = $unik;

			// beri hadiah Rp. 100.000
	//		if($code_voucher >= "00001" && $code_voucher <= "00050"){
	//			$data_voucher = array( // masukkan ke database
	//				'nomor_voucher' => $code_voucher,
	//				'hadiah'		=> $voucher1,
	//			);
	//			$this->voucher_model->simpan_voucher_1($data_voucher); // masukkan ke database
	//		}

			// beri hadiah Rp. 50.000
	//		if($code_voucher >= "00051" && $code_voucher <= "00100"){
	//			$data_voucher = array( // masukkan ke database
	//				'nomor_voucher' => $code_voucher,
	//				'hadiah'		=> $voucher2,
	//			);
	//			$this->voucher_model->simpan_voucher_2($data_voucher); // masukkan ke database
	//		}

			// beri hadiah Rp. 20.000
	//		if($code_voucher >= "00101" && $code_voucher <= "00250"){
	//			$data_voucher = array( // masukkan ke database
	//				'nomor_voucher' => $code_voucher,
	//				'hadiah'		=> $voucher3,
	//			);
	//			$this->voucher_model->simpan_voucher_3($data_voucher); // masukkan ke database
	//		}

			// beri hadiah Rp. 10.000
	//		if($code_voucher >= "00251" && $code_voucher <= "00500"){
	//			$data_voucher = array( // masukkan ke database
	//				'nomor_voucher' => $code_voucher,
	//				'hadiah'		=> $voucher4,
	//			);
	//			$this->voucher_model->simpan_voucher_4($data_voucher); // masukkan ke database
	//		}

			// beri hadiah Rp. 5.000
	//		if($code_voucher >= "00501" && $code_voucher <= "01000"){
	//			$data_voucher = array( // masukkan ke database
	//				'nomor_voucher' => $code_voucher,
	//				'hadiah'		=> $voucher5,
	//			);
	//			$this->voucher_model->simpan_voucher_5($data_voucher); // masukkan ke database
	//		}

			// Distribusi Kupon

	//		$load_data_voucher1 = $this->voucher_model->ambil_data(); // pengambilan jenis voucher dari database di limit 5
	//		foreach($load_data_voucher as $v){
	//			$group_voucher = array('box'=>'1', 'voucher'=> $v->voucher);
	//			$this->db->insert('distribusi_voucher', $group_voucher); // masukkan ke database distribusi voucher (per box)
	//		}

	//	}

	//}
 
	public function index(){
		$data['get_produk_by_kategori_utama'] = $this->home->get_data_produk_kat_utama();
		//$data['promo_flag'] = $this->home->get_promo_flag();
		$data['brand'] = $this->home->get_brand();
		$data['get_slider_utama'] = $this->home->get_data_slide_utama();
		$data['get_produk_discount'] = $this->home->get_produk_discount();
		$data['get_produk_last'] = $this->home->get_produk_latest2();
		//$data['get_promo_slide_utama'] = $this->home->get_promo_slide();
		//$data['getParentkategori']	= $this->home->get_parent_kategori();
		//$data['grup_produk']	= $this->home->get_produk_grup();
		$this->load->view('theme/v1/header');
		$this->load->view('theme/v1/utama', $data);
		$this->load->view('theme/v1/footer');
	}

	function linktreestarsversion(){ 
		$this->load->view('theme/v1/linktree');
	}

	function prosedur_toko(){
		$this->load->view('theme/global/index');
	}

	function cek_estimasi_ongkir(){
		$this->load->view('theme/v1/cek_estimasi_ongkir');
	}

	function store_locator(){
		// cek aktif apa tidak halaman ini
		$cek = $this->home->get_store_locator();
		if($cek['aktif'] == "on"){
			$data_filtering = $this->security->xss_clean($this->input->post('searchtoko'));
        	$dataxx = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

			if(empty($dataxx)){
				$data['resultx'] = "";
				$this->load->view('theme/v1/header');
				$this->load->view('theme/v1/store_locator',$data);
				$this->load->view('theme/v1/footer');		
			}else{
				// cek kata kunci
				$cek_kata = $this->home->cekKata($dataxx);
				$data['resultx'] = $cek_kata;
				$this->load->view('theme/v1/header');
				$this->load->view('theme/v1/store_locator', $data);
				$this->load->view('theme/v1/footer');		
			}

		}else{
			$data['get_produk_last'] = $this->home->get_produk_latest();
			$this->load->view('theme/v1/header');
			$this->load->view('theme/v1/404', $data);
			$this->load->view('theme/v1/footer');
		}
	}

	function caritoko(){
		$data_filtering = $this->security->xss_clean($this->input->post('key'));
        $dataxx = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

        $cek_kata = $this->home->cekKata($dataxx);

        foreach($cek_kata->result() as $t){
    	$hsl = $t->nama_toko;

    		if(preg_match("/SN/", $hsl) || preg_match("/KAKIKU/", $hsl) || preg_match("/FOOT/", $hsl) || preg_match("/SHOES/", $hsl) || preg_match("/JEANS/", $hsl) || preg_match("/DEALOVE/", $hsl) || preg_match("/HIJAB/", $hsl) ){

			}else{

				if($cek_kata->num_rows() > 0 ){
			
	        		echo "<div class='item-col col-xs-6 col-sm-3 post-10670 product type-product status-publish has-post-thumbnail product_cat-uncategorized product_cat-electronics product_cat-food-bevereages product_cat-hamburger product_cat-potato-chips product_cat-saw product_cat-contruction product_cat-organic first instock featured shipping-taxable purchasable product-type-variable'>
							<div class='product-wrapper'>
								<div class='list-col4'>
									<div class='product-image bg-store'>
										<span class='shadow'></span>
	                                </div>
	                            </div>
								<div class='list-col8'>
									<div class='gridview'>  
										<h2 class='product-name' style='text-align:center;'>
	                                    	<a href='javascript:void(0);' style='text-transform: uppercase;font-size:14px;'><b>".$t->nama_toko."</b></a>
	                                	</h2>      
										<div class='price-box'>
	                                        <span class='woocommerce-Price-amount amount' style='text-align:center'>
	                                            <small>".$t->alamat."</small>
	                                        </span>
	                                    </div>  
									</div>
								</div>
								<div class='clearfix'></div>
							</div>
						</div>";
				}else{
		        	echo "<div class='col-md-12 text-center' style='padding:5px;'><h4 style='margin:0;'>Maaf kota yang anda cari tidak ditemukan toko stars.</h4></div>";
		        }
    		}
        }
	}
 
	function invoicepage(){
		$this->load->view('theme/v1/inv_page');
	} 

	function cariinv(){
		$data_filtering = $this->security->xss_clean($this->input->post('getinvdata'));
        $dataxx = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

        $cekInv = $this->home->cekinvorder($dataxx);
        if($cekInv->num_rows() > 0){

        	echo "<h5>Hasil '".$dataxx."'</h5>";

        	echo "
        		<div class='table-responsive'>
    			<table class='ble table-striped table-hover table-bordered' cellspacing='0' width='100%' style='box-shadow:0px 0px 8px 0px #bababa;background-color:white;'>
    				<thead>
    					<tr>
    						<th style='text-align:center;padding:10px;'>Tanggal Order </th>
    						<th style='text-align:center;padding:10px;'>Nomor Pesanan</th>
			              	<th style='text-align:center;padding:10px;'>Opsi</th>
    					</tr>
    				</thead>
    				<tbody>
        	";

        	foreach($cekInv->result() as $r){
        		$a = $this->encrypt->encode($r->invoice);
        		$gn = base64_encode($a);

              	// jika ada uploadan label pengiriman maka tampilkan filenya
              	if($r->tokenlabel == ""){
              		$cetaklabel = "<a style='background-color:black;padding:3px 5px;color:white;margin:0 5px 5px 0;' class='btn' target='_new' href='".base_url('cetaklabel/'.$gn.'')."'>Cetak Label Pengiriman</a>";
              		$cetaklabeldefault = "";
              	}else{
              		$cetaklabel = "<a style='background-color:black;padding:3px 5px;color:white;margin:0 5px 5px 0;' class='btn' target='_new' href='".$r->labelpengiriman."'>Cetak Label Pengiriman</a>";
              		$cetaklabeldefault = "<a style='background-color:red;padding:3px 5px;color:white;margin:0 5px 5px 0; ' class='btn' target='_new' href='".base_url('cetaklabel/'.$gn.'')."'>Cetak Label Pengiriman Stars</a>";
              	}

        		echo "
					<tr>
						<td style='text-align:center;padding:5px;'>".date('d/m/y', strtotime($r->tanggal_order))."</td>
						<td style='text-align:center;padding:5px;'>".$r->invoice."</td>
						<td class='alignbtn' style='padding:5px;font-size:14px;'><a style='background-color:black;padding:3px 5px;color:white;margin:0 5px 5px 0;' class='btn' target='_new' href='".base_url('cetakinv/'.$gn.'')."'>Cetak Struk</a> ".$cetaklabel." ".$cetaklabeldefault."</td>
					</tr>
        		";
        	}

        	echo "
        		</tbody>
        			</table>
        		</div>
        	";
        }else{
        	echo "tidak ada data";
        }
	}

	function cetakinv($id){
		$this->load->model('sec47logaccess/onlinestore_adm');

		$data['detailorder'] 	= $this->onlinestore_adm->checkingInv2($id);
		$data['produk'] 		= $this->onlinestore_adm->checkingdataorder2($id);
		$data['tokopengirim']	= $this->onlinestore_adm->get_data_tokopengirim($id);

		$this->load->view('theme/v1/detailinvorderpage',$data);
	}

	function cetaklabel($id){
		$this->load->model('sec47logaccess/onlinestore_adm');

		$data['detailorder'] 	= $this->onlinestore_adm->checkingInv2($id);
		$data['produk'] 		= $this->onlinestore_adm->checkingdataorder2($id);
		$data['tokopengirim']	= $this->onlinestore_adm->get_data_tokopengirim($id);

		$this->load->view('theme/v1/detailinvorderlabel',$data);
	}
	
// notification or updating by cron job

	function cekmutasi_sync_order(){
		$this->load->view('manage/CrMt');
	}

	function report_progres_kinerja_by_mail(){
		$this->load->model('checkout_model');
		$this->load->model('sec47logaccess/user_preference_adm');
		$this->data['g'] = $this->user_preference_adm->get_data_kinerja_tgl_now();
		$attach= $this->user_preference_adm->get_data_attach_kinerja_tgl_now();
		// keluarkan data admin dan daftar email cc
		$dataadm = $this->checkout_model->keluarkan_dt_adm();
		foreach($dataadm->result() as $yp){
			if($yp->status == "e_admin"){
				$admmail = $yp->em_acc;
			}
			if($yp->status == "e_cc"){
					$ccmail = $yp->em_acc;
			}
		}
		$config = Array(
			'mailtype'  => 'html', 
		);

		$this->email->initialize($config);		
		$this->email->from('noreply@starsstore.id','PT. Stars Internasional');
		$this->email->to($admmail);
		$this->email->cc($ccmail);
		//$this->email->bcc('them@their-example.com');
		$this->email->subject('Laporan Kerja Tim Promosi & E-commerce');
		$body = $this->load->view('laporan_pdf/report_kinerja_by_mail', $this->data, TRUE);
		$this->email->message($body);
		foreach($attach as $t){
			$this->email->attach(base_url('assets/images/images/kinerja/'.$t->file.''));
		}
		$this->email->send();
	}

	function cron_job_system_p(){
		// CEK EXPIRED PROMO
		$this->load->model('sec47logaccess/alat_promosi_adm');
		$cek = $this->alat_promosi_adm->cek_exp();
		foreach($cek as $r){
			$id = $r->id_promo;
			$now = date('Y-m-d H:i:s');
			$dateData = $r->tgl_akhir;

			if($now > $dateData){
				$this->alat_promosi_adm->ganti_status_exp($id);
			}
		}

		// CEK EXPIRED BANNER
		$this->load->model('sec47logaccess/alat_promosi_adm');
		$cek = $this->alat_promosi_adm->cek_exp_flag();
		foreach($cek as $r){
			$id = $r->id;
			$now = date('Y-m-d');
			$dateData = $r->tgl_akhir;

			if($now > $dateData){
				$this->alat_promosi_adm->ganti_status_exp_flag($id);
			}
		}

		// CEK EXPIRED VOUCHER
		$this->load->model('sec47logaccess/voucher_adm');
		$cek = $this->voucher_adm->cek_exp();
		foreach($cek as $r){
			$id = $r->id;
			$now = date('Y-m-d H:i:s');
			$dateData = $r->valid_until;

			if($now > $dateData){
				$this->voucher_adm->ganti_status_exp($id);
			}else{
				
			}
		}

		// CEK RESET ID CUSTOMER
		$this->load->model('users');
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

		// CEK PROMO MASAL BERAKHIR
		$this->load->model('sec47logaccess/produk_adm');
		$cek = $this->produk_adm->cek_exp_promo_masal();
		foreach($cek->result() as $r){
			$id = $r->id;
			$now = date('Y-m-d');
			$dateData = $r->berakhir;

			if($r->status == "on"){
				if($now > $dateData){

					// KEMBALIKAN HARGA KE NORMAL (NON DISKON)
					$produkx = $this->produk_adm->get_produk_group($id);
					foreach($produkx->result() as $j){

						$data_produk = array(
				          'id_produk_optional' => $j->id_produk_optional,
				          'harga_dicoret'   => "",
				          'harga_fix'       => $j->harga_dicoret,
				        );
				        $this->db->where('id_produk_optional', $j->id_produk_optional);
				        $this->db->update('produk_get_color', $data_produk);
					}

					// UBAH STATUS PROMO
					$data_promo = array(
						'status'	=> '',
					);	
					$this->db->where('id', $id);
				   	$this->db->update('produk_group_name', $data_promo);
					
				}else{ 
					
				}
			}
		}

        // hapus aktifitas user
        $this->load->model('log_activity');
        $this->log_activity->delete_old_log();
	}

	function cekprodukbarulayakjual(){
		$this->db->truncate('produk_all_stok');
		$this->load->model('sec47logaccess/produk_adm');
	    $cekartikeldata = $this->produk_adm->get_data_by_art4();
	    foreach($cekartikeldata as $gh){
	      $artxx = $gh->art_id;

	      $curl = curl_init();
	      $proxy = '192.168.0.219:80';

	      curl_setopt_array($curl, array(
	      CURLOPT_URL => "http://sm.stars.co.id/ws/lap_stock.php?api=0x010042602D856FE11654537274084EAA64C036BF6BBB8F985A9D&art_id=".$artxx."",
	      //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => "",
	      CURLOPT_MAXREDIRS => 10, 
	      CURLOPT_TIMEOUT => 30,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => "GET",
	      //CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
	      CURLOPT_HTTPHEADER => array(
	        "content-type: application/x-www-form-urlencoded",
	      ),
	      ));

	      $response = curl_exec($curl);
	      $err = curl_error($curl);

	      curl_close($curl);

	      if($err){
	        $this->session->set_flashdata('error', 'Gagal mengambil data dari server #: '.$err.'');
	        //log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal cek stok artikel terbaru dari server stars');
	      }else{
	        $totalstok = 0;
	        $data = json_decode($response, true);
	        for ($l=0; $l < count($data['stock']); $l++){ 
	          $totalstok += $data['stock'][$l]['psg'];
	        }

	        if($totalstok >= 700){ // jika stok kurang dari atau sama dengan 700 psg maka laporkan ke email admin dan nonaktifkan produk
	          $data_stok = array(
	          	'art'	=> $artxx,
	          	'stok'	=> $totalstok,
	          );
	          $this->db->insert('produk_all_stok',$data_stok);
	          //echo $artxx.' : '.$totalstok.'<br>';
	        }
	      }
	    }
	}

	function cekstokotomatisforproductecom(){
    $this->load->model('sec47logaccess/produk_adm');
    $cekartikeldata = $this->produk_adm->get_data_by_art();
    foreach($cekartikeldata as $gh){
      $artxx = $gh->artikel;

      $curl = curl_init();
      $proxy = '192.168.0.219:80';

      curl_setopt_array($curl, array(
      CURLOPT_URL => "http://sm.stars.co.id/ws/lap_stock.php?api=0x010042602D856FE11654537274084EAA64C036BF6BBB8F985A9D&art_id=".$artxx."",
      //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10, 
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      //CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
      ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if($err){
        $this->session->set_flashdata('error', 'Gagal mengambil data dari server #: '.$err.'');
        //log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal cek stok artikel '.$datax.' dari server stars');
        echo  "<span class='pull-right' style='font-size:20px;font-weight:bold;color:red;cursor:pointer;' onclick='closecekStok();'>X</span>";
        echo "Gagal cek stok. periksa koneksi internet.";
      }else{
        $totalstok = 0;
        $data = json_decode($response, true);
        for ($l=0; $l < count($data['stock']); $l++){ 
          $totalstok += $data['stock'][$l]['psg'];
          //$art_id = $data['stock'][$l]['art_id'];
          //$cekartikeldata = $this->produk_adm->get_data_by_art($art_id);
        }

        if($totalstok <= 700){ // jika stok kurang dari atau sama dengan 700 psg maka laporkan ke email admin dan nonaktifkan produk
          $dataartikel[] = $artxx;
        }
      }
    }
    $guid = json_encode($dataartikel);
    $this->load->model('checkout_model');
    // keluarkan data admin dan daftar email cc
    $dataadm = $this->checkout_model->keluarkan_dt_adm();
    foreach($dataadm->result() as $yp){
      if($yp->status == "e_admin"){
        $admmail = $yp->em_acc;
      }
      if($yp->status == "e_sales"){
        $ccmmail = $yp->em_acc;
      }
    }
    $config = Array(
      'mailtype'  => 'html', 
    );

    $this->email->initialize($config);    
    $this->email->from('cekstokproduk@starsstore.id','PT. Stars Internasional');
    $this->email->to($admmail);
    //$this->email->cc($ccmail);
    $this->email->subject('Laporan Produk Yang dinonaktifkan Sistem');
    $body = "Berikut daftar produk yang dinonaktifkan sistem karena stok dibawah 700 pasang (tidak mencukupi untuk syarat penjualan online). segera nonaktifkan produk-produk yang ada didaftar ini dari Marketplace Tokopedia, Bukalapak, Shopee, Lazada, dan marketplace lainnya :<br><br>".$guid." ";
    $this->email->message($body);          
    $this->email->send();
  }

  function cekStokbyrims(){
  	$this->load->model('sec47logaccess/produk_adm');
    $data_filtering = $this->security->xss_clean($this->input->post('getinvdata'));
    $datax = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

    $curl = curl_init();
    $proxy = '192.168.0.219:80';

    curl_setopt_array($curl, array(
    CURLOPT_URL => "http://sm.stars.co.id/ws/lap_stock.php?api=0x010042602D856FE11654537274084EAA64C036BF6BBB8F985A9D&art_id=TJ6728-881",
    //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10, 
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    //CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
    CURLOPT_HTTPHEADER => array(
      "content-type: application/x-www-form-urlencoded",
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if($err){
      $this->session->set_flashdata('error', 'Gagal mengambil data dari server #: '.$err.'');
      //log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal cek stok artikel '.$datax.' dari server stars');
      echo  "<span class='pull-right' style='font-size:20px;font-weight:bold;color:red;cursor:pointer;' onclick='closecekStok();'>X</span>";
      echo "Gagal cek stok. periksa koneksi internet.";
    }else{
      $totalstok = 0;
      $totaltoko = 0;
      $nomor = 0;
      $data = json_decode($response, true);
      for ($l=0; $l < count($data['stock']); $l++){ 
        $totalstok += $data['stock'][$l]['psg'];
        $totaltoko += count($data['stock'][$l]['str_id']);
      }
      echo  "<span class='pull-right' style='font-size:20px;font-weight:bold;color:red;cursor:pointer;' onclick='closecekStok();'>X</span><div style='text-align:left;margin-bottom:20px;'>Artikel <b>: ".$datax."</b><br>Total Stok Semua Toko <b>: ".$totalstok." PSG</b><br>Total toko yang memiliki stok <b>: ".$totaltoko." Toko</b></div><div class='table-responsive'>";
      for ($l=0; $l < count($data['stock']); $l++){ 
      $nomor++;
        $edptokox = $data['stock'][$l]['str_id'];
        //PERPENDEK KATA
        $maxword1 = 3;
        $maxword2 = 2;
        $maxword3 = 1;

        // potong kata first dan last
        $firstnamex = substr($edptokox, 0, $maxword1);
        $lsnamex = substr($edptokox, -2, $maxword2);
        $edptoko = $firstnamex.'-'.$lsnamex;

        //$cek = $this->produk_adm->cek_toko($edptoko);
        //if($cek['nama_toko'] == ""){
        //  $namatoko = "[ Unknown Store ]";
        //}else{
        //  $namatoko = $cek['nama_toko'];
        //}

        if($data['stock'][$l]['psg'] == 0 || $data['stock'][$l]['psg'] == ""){
          $jmlpasangtoko = "<i style='color:red'>0</i>";
        }else{
          $jmlpasangtoko = $data['stock'][$l]['psg'];
        }

        echo "<div style='background-color:#f9f9f9;border:white;box-shadow:3px 3px 6px 0px #d5d5d5;padding:10px;text-align:left;'> 
              <label class='label label-primary' style='font-weight:bold;font-size14px;margin-right:5px;position: absolute;left: 30px;margin-top: -10px;'>".$nomor."</label>
                <div style='margin-left:20px;'>
                  <b></b><br>
                  Kode EDP : ".$data['stock'][$l]['str_id']."<br>
                 
                  Total Stok diToko : <b>".$jmlpasangtoko." PSG</b><br><br>
                 
                </div>
              </div><br>";

      }
      
      echo "</tbody></table>";
      echo "</div>";
      //log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cek stok artikel '.$datax.' dari server stars');
    }
  }

	function notif_closing(){
		// CEK WAKTU CLOSING (TGL CLOSING)
		$tgl = date('d');
        if($tgl == 25 || $tgl == 27 || $tgl == 29 || $tgl == 30 || $tgl == 31 || $tgl == 1 || $tgl == 2 || $tgl == 3){
        	// send notif email to admin, finance, dan sales

        	$data_email = $this->home->load_email();
        	$mail = array();
        	foreach($data_email as $g){
        		$mail[] = $g->em_acc;
        	}

        	$mailx = implode(',',$mail);

        	$data_email_rev = array(
				'judul'	=> "Persiapan Closing Bulan Ini.",
				'isi' 	=> "Salam stars all the best,<br><br>Hai admin, bag. finance, dan bag. sales. waktunya mempersiapkan closing untuk bulan ini. berikut langkah-langkah untuk mempersiapkan closing bulanan.<br>
				<ul class='stepclosing'>
                    <li>Cek status semua pesanan disemua marketplace & E-commerce</li>
                    <li>Pastikan pertelaan barang masuk dan keluar yang dikirim toko telah dimasukkan ke POS (Pemindahan antar kode EDP toko)</li>
                    <li>Masukkan semua bukti transfer per transaksi</li>
                    <li>Masukkan penjualan di POS, pastikan sama jumlah pasang dan rupiah dengan laporan barang terjual</li>
                    <li>Masukkan pertelaan barang masuk & keluar di POS dan di E-commerce (Pastikan sama nilai pasang dan rupiahnya)</li>
                    <li>Masukkan biaya-biaya yang menggunakan uang penjualan (buat di ms. word)</li>
                    <li>Cetak RPP/ RPK, barang terjual, pertelaan barang masuk dan keluar, cover biaya dan bukti-bukti pembayaran,</li>
                    <li>Sertakan RPP versi POS untuk dilampirkan ke pembukuan RPP/ RPK</li>
                    <li>Export dan upload penjualan, pertelaan dan RPP/ RPK versi POS ke sm.stars.co.id</li>
                </ul>",
			);
        	$config = Array(
				'mailtype'  => 'html', 
			);

			$this->email->initialize($config);
			$this->email->from('noreply@starsstore.id');
	      	$this->email->to('holding@starsstore.id');
	      	$this->email->cc($mailx);
	      	$this->email->subject("Persiapan Closing Bulan Ini");
	      	$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
	      	$this->email->message($body);
	      	$this->email->send();
        }
	}

	function cron_job_backup_two_daily(){
		// BACKUP DATABASE SETIAP 2 HARI DAN DIKIRIM KE ALAMAT EMAIL MAINTENANCE / DEVELOPER / SUPPORTING
		$this->build_backups();
	}

	function sync_data_store_from_gilang_server(){ // cek setiap hari sekali
		$curl = curl_init();
	    $proxy = '192.168.0.219:80';

	    curl_setopt_array($curl, array(
	    CURLOPT_URL => "https://www.nandagilang.com/starsstore/",
	    //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_ENCODING => "",
	    CURLOPT_MAXREDIRS => 10, 
	    CURLOPT_TIMEOUT => 30,
	    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    CURLOPT_CUSTOMREQUEST => "GET",
	    //CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
	    CURLOPT_HTTPHEADER => array(
	      "content-type: application/x-www-form-urlencoded",
	    ),
	    ));

	    $response = curl_exec($curl);
	    $err = curl_error($curl);

	    curl_close($curl);

	    if($err){
	      $this->session->set_flashdata('error', 'Gagal mengambil data dari server #: '.$err.'');
	      log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Gagal cek data toko dari server gilang');
	      echo "Gagal cek data toko. periksa koneksi internet.";
	    }else{
	      
	      $data = json_decode($response, true);
	      foreach($data['toko'] as $l){
	        $edptokox = $l['Str_Id'];
	        //PERPENDEK KATA
	        $maxword1 = 3;
	        $maxword2 = 2;

	        // potong kata first dan last
	        $firstnamex = substr($edptokox, 0, $maxword1);
	        $lsnamex = substr($edptokox, -2, $maxword2);
	        $edptoko = $firstnamex.'-'.$lsnamex;

	        $ceknewstore = $this->home->cek_newstore($edptoko);
	        if($ceknewstore['kode_edp'] == ""){ // jika data toko tidak ada didatabase maka (toko baru) input data

	        	// hilangkan tanda + pada nomor telpon
	        	$notelptoko = str_replace('+', '', $l['NoHp']);
	        	if($l['KD'] == "N" || $l['KD'] == "n" || $l['KD'] == null){
	        		$statustoko = "";
	        	}else if($l['KD'] == "Y"){
					$statustoko = "on";
	        	}

	        	if($l['almt'] == null){
	        		$alamat = "-";
	        	}else{
	        		$alamat = $l['almt'];
	        	}

	        	$data_toko = array(
	        		'nama_toko'	=> $l['nama'],
	        		'alamat' 	=> $alamat,
	        		'kode_sms'	=> '-',
	        		'kode_edp'	=> $edptoko,
	        		'spv'		=> '-',
	        		'ass'		=> '-',
	        		'wa_toko'	=> $notelptoko,
	        		'spv_nomor'	=> $notelptoko,
	        		'toko_aktif'=> $statustoko,
	        	);
	        	$this->db->insert('toko',$data_toko);

	        }else{ // jika data toko sudah ada maka update, siapa tahu update nomor telp, kode edp, dll

	        	// hilangkan tanda + pada nomor telpon
	        	$notelptoko = str_replace('+', '', $l['NoHp']);
	        	if($l['KD'] == "N" || $l['KD'] == "n" || $l['KD'] == null){
	        		$statustoko = "";
	        	}else if($l['KD'] == "Y"){
					$statustoko = "on";
	        	}

	        	if($l['almt'] == null){
	        		$alamat = "-";
	        	}else{
	        		$alamat = $l['almt'];
	        	}

	          	$data_toko = array(
	        		'nama_toko'	=> $l['nama'],
	        		'alamat' 	=> $alamat,
	        		'kode_sms'	=> '-',
	        		'kode_edp'	=> $edptoko,
	        		'spv'		=> '-',
	        		'ass'		=> '-',
	        		'wa_toko'	=> $notelptoko,
	        		'spv_nomor'	=> $notelptoko,
	        		'toko_aktif'=> $statustoko,
	        	);
	        	$this->db->where('kode_edp', $edptoko);
	        	$this->db->update('toko',$data_toko);
	        }
	      }
	      echo "sukses";
	      log_helper('onlinestore', 'Sistem berhasil sync data toko dari server gilang');
	    }
	}

	function build_backups(){
		$date = date('Y-m-d');
		$this->database_backup($date);
		//$this->project_backup($date);
		$this->send_backup($date);
	}

	function database_backup($date){
		$this->load->helper('file');
		$this->load->dbutil();
		@ $backup =& $this->dbutil->backup();
		write_file('global/database_'.$date.'.zip', $backup);
	}

	function project_backup($date){
		$this->load->library('zip');
		$this->zip->read_dir(FCPATH, FALSE);
		$this->zip->archive('global/project_'.$date.'.zip');
	}

	function send_backup($date){
		$data_email = $this->home->load_email_all();
    	//$mail = array();
    	foreach($data_email as $g){
    		if($g->status == "e_support"){
    			$mail = $g->em_acc;
    		}
    	}
    	
    	$tglx = date('d F Y');
		$config = Array(
				'mailtype'  => 'html', 
			);

		$this->email->initialize($config);
		$this->email->from('noreply_by_system@starsstore.id');
      	$this->email->to($mail);	
      	//$this->email->attach('global/project_'.$date.'.zip');
      	$this->email->attach(base_url('global/database_'.$date.'.zip'));
      	$this->email->subject('Backup Program dan Database '.$tglx.'');
      	//$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
      	$this->email->message('Backup Program dan Database '.$tglx.'');
      	if($this->email->send()){
      		unlink('global/database_'.$date.'.zip');
      		//unlink(PUBPATH . "global/".'project_'.$date.'.zip');
      	}else{
      		show_error($this->email->print_debugger());
      	}
	}

// CEK ORDER CUSTOMER DARI E-COMMERCE
	
	function cek_expired_order(){
		$this->load->model('sec47logaccess/order_adm');
		$cek = $this->order_adm->cek_exp();
		foreach($cek as $r){
			$id = $r->id;
			$email = $r->email;
			$inv = $r->invoice;
			$now = date('Y-m-d H:i:s');
			$dateData = $r->tanggal_jatuh_tempo;

			if($now > $dateData){
				$this->order_adm->ganti_status_exp($id);
				//$g = $this->order_adm->getMailcs($id);
				//foreach($g as $f){
				//	$email = $email;
				//	$inv = $f->invoice;
				//}
				$config = Array(
					'mailtype'  => 'html', 
				);
				$data_order = array(
					'invoice' 	=> $inv,
					'status'	=> '<i style="color:red;">dibatalkan</i>',
					'content'	=> '<p style="text-align:justify;">Pesanan anda kami batalkan karena tidak memenuhi syarat. atau kami tidak menerima pembayaran anda. jika anda telah mentransfer sejumlah uang. <a href="'.base_url('bantuan').'">Klik disini</a> untuk menghubungi kami.</p>',
				);
				$judulEmail = "Order anda";
				$this->email->initialize($config);
		      	$this->email->from('noreply@starsstore.id'); // change it to yours
		      	$this->email->to($email);// change it to yours
		      	$this->email->subject('Starsstore - Pembatalan Pesanan Anda #'.$inv.'');
		      	$body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
		      	$this->email->message($body);
		      	$this->email->send();
		      	log_helper('onlinestore', 'Sistem mengubah otomatis order no. invoice '.$inv.' menjadi batal');
			}else{
				//echo "GAK EXPIRED";
			}
		}
	}	

// end notification or updating by cron job

	function our_store(){
		$data['r'] = $this->home->get_our_store();
		$this->load->view('theme/v1/header');
		$this->load->view('theme/v1/our_store', $data);
		$this->load->view('theme/v1/footer');
	}

	function konfirmasi(){
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

		$id_customer = $this->session->userdata('id_cs');
		$data['pesanan'] = $this->home->get_pesanan_belum_dibayar($id_customer);
		$data['bank']	= $this->home->daftar_rekening_pusat(); 
		$this->load->view('theme/v1/header');
		$this->load->view('theme/v1/konfirmasi',$data);
		$this->load->view('theme/v1/footer');	
	}

	function checkpesanankonfirmasi(){
		$idx1 = $this->security->xss_clean($this->input->post('pesanan'));
		$idx2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$idx1);
		$idx3 = strip_tags($idx2);
		$idx = htmlentities($idx3);

		// cek id pesanan
		$cek1 = $this->home->cek_pesanan($idx);
		if($cek1->num_rows() > 0){ // jika ketemu maka update
			$cek2 = $this->home->cek_konfirm_already($idx);
			if($cek2->num_rows() > 0){ // jika sudah pernah dikonfirmasi
				echo "405";
			}else{
				echo "467";
			}
		}else{
			echo "200";
		}
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

		//$tgl1 = $this->security->xss_clean($this->input->post('tgl_transfer'));
		//$tgl2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$tgl1);
		//$tgl3 = strip_tags($tgl2);
		//$tgl = htmlentities($tgl3);

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
			$cek = $this->home->cek_pesanan($id);
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

				$cek2 = $this->home->cek_konfirm_already($id);
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
					$status = array(
						'status'	=> "*^56t38H53gbb^%$0-_-",
					);
					$this->home->update_status_pesanan($status, $id);

					$this->form_validation->set_rules('id_pesanan', 'ID Pesanan', 'required|xss_clean');
					//$this->form_validation->set_rules('nama', 'Nama lengkap', 'required|xss_clean');
					//$this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
					//$this->form_validation->set_rules('bank', 'Bank', 'required|xss_clean');
					//$this->form_validation->set_rules('tgl_transfer', 'Tanggal Transfer', 'required|xss_clean');
					//$this->form_validation->set_rules('nominal', 'Nominal', 'required|xss_clean');

					if($this->form_validation->run() != FALSE ){	
						// simpan data
						$data_konfirmasi = array(
							'identity_pembayaran'	=> $idx,
							'id_pesanan'			=> $id,
							'nama'					=> "-",//$nm,
							'email'					=> "-",//$em,
							'bank'					=> "-",//$bank_gabung,
							'tgl'					=> date("Y-m-d"),
							'nominal'				=> $nmn,
							'catatan'				=> $notex,
							'tgl_input_data'		=> date("Y-m-d H:i:s"),
						);
						$this->home->simpan_bukti_pembayaran($data_konfirmasi);
						
						// kirim email ke customer
						$this->load->library('email');
						$balas_konfirmasi = "<p style='text-align:justify;'>Terima kasih telah mengirimkan bukti pembayaran dengan rincian sebagai berikut :<br><br>Nomor pesanan : <b>".$id."</b><br>Nama : <b>".$nm."</b><br>Bank : <b>".$bank_gabung."</b><br>Nominal : <b>Rp. ".number_format($nmn,0,".",".")."</b><br>Catatan : <b>".$notex."</b><br><br>Kami akan mengecek bukti pembayaran anda, Terima kasih.</p>";
				      	$config = Array(
							'mailtype'  => 'html', 
						);
						
						$this->email->initialize($config);
				      	$this->email->from('noreply@starsstore.id');
				      	$this->email->to($em);
				      	$this->email->subject('Starsstore - Konfirmasi Pembayaran '.$id.'');
				      	$this->email->message($balas_konfirmasi);
				      	//$this->email->send();
				      	$this->send_konfirm_to_admin($idx,$id,$nm,$em,$bank_gabung,$nmn,$notex);

					}else{

						$this->session->set_flashdata('error','Lengkapi form terlebih dahulu');
						redirect($this->agent->referrer());
					}
				}
			}

		}
	}

	function send_konfirm_to_admin($idx,$id,$nm,$em,$bank_gabung,$nmn,$notex){
		// kirim email ke customer
		// KELUARKAN DATA EMAIL ADMIN
		$this->load->model('checkout_model');
		$dataadm = $this->checkout_model->keluarkan_dt_adm();
		foreach($dataadm->result() as $yp){
			if($yp->status == "e_admin"){
				$admmail = $yp->em_acc;
			}
		}	

		$this->load->library('email');

		$balas_konfirmasi = "<p style='text-align:justify;'>Pelanggan telah memberikan bukti transfer pembayaran mohon dicek, rincian sebagai berikut :<br><br>Nomor pesanan : <b>".$id."<br>Catatan : <b>".$notex."</b><br><br>Salam Stars.</p>";

		//$balas_konfirmasi = "<p style='text-align:justify;'>Pelanggan telah memberikan bukti transfer pembayaran mohon dicek, rincian sebagai berikut :<br><br>Nomor pesanan : <b>".$id."</b><br>Nama : <b>".$nm."</b><br>Bank : <b>".$bank_gabung."</b><br>Nominal : <b>Rp. ".number_format($nmn,0,".",".")."</b><br>Catatan : <b>".$notex."</b><br><br>Salam Stars.</p>";

      	$config = Array(
			'mailtype'  => 'html', 
		);
		
		$this->email->initialize($config);
      	$this->email->from('noreply@starsstore.id');
      	$this->email->to($admmail);
      	$this->email->subject('Starsstore - Konfirmasi Pembayaran Pelanggan '.$id.'');
      	//$body = $this->load->view($balas_konfirmasi,TRUE);
      	$this->email->message($balas_konfirmasi);
      	$this->email->send();
 
      	$this->session->set_flashdata('berhasil','Konfirmasi telah dikirim.');
      	redirect($this->agent->referrer());
	}

	// GANTI FUNGSI UNTUK KONFIRMASI PEMBAYARAN
	function upload_bukti_transfer(){
		$config['upload_path']   = FCPATH.'/assets/images/konfirmasi_pesanan/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg'; //|pdf|doc|docx
        $config['encrypt_name']  = TRUE;
        $config['overwrite']     = FALSE;
        
        $this->upload->initialize($config); 

        if($this->upload->do_upload('userfile')){

        	$gbr = $this->upload->data();

        	// DAPATKAN UKURAN GAMBAR DAN SUSUTKAN 30%
        	$gambar = FCPATH.'/assets/images/konfirmasi_pesanan/'.$gbr['file_name'].'';
	        $data = getimagesize($gambar);
	        $width = round($data[0] * 95 / 100); //susutkan 95%
	        $height = round($data[1] * 95 / 100); // susutkan 95%

	        //print_r($width.' | '.$height);

        	$this->image_lib->initialize(array(
                'image_library' => 'gd2', //library yang kita gunakan
                'source_image' 	=> './assets/images/konfirmasi_pesanan/'. $gbr['file_name'],
                'maintain_ratio'=> FALSE,
                //'create_thumb' => TRUE,
                'quality'		=> '100%',
                'width' 		=> $width,
                'height' 		=> $height,
            ));
            $this->image_lib->resize();


            $gambar = base_url('assets/images/konfirmasi_pesanan/'.$gbr['file_name'].'');

        	$token  = $this->input->post('token_foto');
        	
        	//$id 	= $this->session->userdata('sellerID');
        	//$nama 	= base_url('assets/images/konfirmasi_pesanan/'.$this->upload->data('file_name').'');

        	$idk = $this->input->post('identitas');
        	$this->db->insert('bukti_transfer',array('identity_bukti'=>$idk, 'token'=>$token, 'gambar'=>$gambar));

        }
	}

	//Untuk menghapus foto
	function removeDocument(){

		//Ambil token foto
		$token = $this->input->post('token');

		$foto = $this->db->get_where('bukti_transfer',array('token'=>$token));

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
			$this->db->delete('bukti_transfer',array('token'=>$token));
		}
		//unlink(FCPATH.'assets/images/konfirmasi_pesanan/bb84ed10dc0d809bbd299124b95e0846.PNG');

		echo "{}";
	}

	function error(){
		$data['produk_lain'] = $this->home->get_produk_latest();
		$this->load->view('theme/v1/header');
		$this->load->view('theme/v1/404', $data);
		$this->load->view('theme/v1/footer');
	}

	function affiliate($id){
		$aff = base64_decode($id);
		$aff_s = $this->encrypt->decode($aff);
		$data_info = array(
            'id_banner' => $aff_s,
            'ip'        => $this->input->ip_address(),
            'device'    => $this->agent->browser(),
            'browser'   => $this->agent->platform(),
            'bulan'     => date("M"),
            'tgl'       => date("Y-m-d H:i:s"),
            'tanggal'   => date("Y-m-d"),
        );

        $this->home->write_banner($data_info);
	}

	function berlangganan(){
		$ins = $this->security->xss_clean($this->input->post('td'));
		$a = base64_decode($ins);
		$b = $this->encrypt->decode($a);

		$news1 = $this->security->xss_clean($this->input->post('in'));
		$news2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$news1);
		$news3 = strip_tags($news2);
		$news = htmlentities($news3);

		// inialisasi value email or nomor
		$this->form_validation->set_rules('in', 'Email', 'required|xss_clean|valid_email');
		if($this->form_validation->run() == TRUE){ // JIKA VALUE ADALAH EMAIL
			if($b != "Jsd63)263&31).?"){
				//SAVING DATA HACKER
				$this->load->model('sec47logaccess/setting_adm');
				$aktifitas = "memecahkan kode enkripsi untuk input email newsletter di front end";
				$this->setting_adm->savingHack($aktifitas);
			}else{
				$cek_already = $this->home->cek_already_email($news); // cek email jika sudah pernah ada didatabase
				$cek_already_in_dataorder = $this->home->cek_already_email_in_dataorder($news); // cek didata order
				if($cek_already->num_rows() == 0){
					if($cek_already_in_dataorder->num_rows() == 0){

						$this->home->add_email_new_newsletter($news); // input ke data newsletter
						$this->load->library('email');
						$data_newsletter = array(
							'isi' => $news,
							);
				      	$config = Array(
							'mailtype'  => 'html', 
						);
						
						$this->email->initialize($config);
				      	$this->email->from('newsletter@starsallthebest.com'); // change it to yours
				      	$this->email->to($news);// change it to yours
				      	$this->email->subject('Berlangganan Email');
				      	$body = $this->load->view('em_info_notification_group/f_cus_newsletter',$data_newsletter,TRUE);
				      	$this->email->message($body);
				      	$this->email->send();
						//$data['news'] = $news;
						//$data['caption'] = "Terima kasih telah berlangganan email kami, nantikan seputar promo dan produk terbaru dari kami.";
						//$this->load->view('theme/v1/header');
						//$this->load->view('theme/v1/newsletter', $data);
						//$this->load->view('theme/v1/footer');
						echo true;
					}
				}else{
					echo "alreadydatamail";
				}
			}
				
		}else if($this->form_validation->run() == FALSE){ // jika value nomor telpon
			if($b != "Jsd63)263&31).?"){
				//SAVING DATA HACKER
				$this->load->model('sec47logaccess/setting_adm');
				$aktifitas = "memecahkan kode enkripsi untuk input email newsletter di front end";
				$this->setting_adm->savingHack($aktifitas);
			}else{
				$x1 = substr($news,0,2);
				if($x1 == "08"){ // cek apa benar ini nomor telpon (08xxxx)
					$cek_already = $this->home->cek_already_notelp($news); // cek email jika sudah pernah ada didatabase
					$cek_already_in_dataorder = $this->home->cek_already_notelp_in_dataorder($news); // cek didata order
					if($cek_already->num_rows() == 0){
						if($cek_already_in_dataorder->num_rows() == 0){
							$this->home->add_notelp_new_newsletter($news); // input ke data newsletter
							// SEND WHATSAPP OR SMS (MASIH DALAM PENGEMBANGAN)
							echo true;
						}
					}else{
						echo "alreadydatatelp";
					}
				}else{
					echo "noformattelp";
				}
			}
		}else{
			echo "23749";
		}
	}

	function research_product(){
		$in = $this->input->post('search_data');
		//produk 
		$result1 = $this->home->get_autocomplete($in);
		//merk
		$result2 = $this->home->get_autocomplete2($in);

		if(empty($result1) && empty($result2)){
			echo "<em> Produk tidak ditemukan ...</em>";
		}else{
			if(!empty($result1)){
				echo('<div class="desc-fil">Pencarian pada produk</div>');
				echo '<ul class="list-unstyled rpor">';
				foreach($result1 as $produk):
					if($produk->diskon == 0 || empty($produk->diskon)){
						$disc1 =  "";
					}else{
						$disc1 = "<label class='diskon'>$produk->diskon%</label>";
					}
					//$diskon = $produk->harga_retail-($produk->harga_retail*$produk->diskon/100);
					if($produk->diskon == 0 || empty($produk->diskon)){
						$price = '<span style="position:absolute;right:15px;" class="harga_retail">Rp.'.number_format($produk->harga_retail,0,".",".").'</span>';	
					}else{
						$price = '<span style="position:absolute;right:15px;"><s class="discount-title" style="font-size:12px;">Rp.'.number_format($produk->harga_retail,0,".",".").'</s> <harga class="harga_retail">Rp.'.number_format($produk->diskon_rupiah,0,".",".").'</harga></span>';	
					}
					if($produk->rating_produk == 0){
							$rat = "<img src='".base_url()."assets/images/img/rating/0stars.png' data-original='assets/images/img/rating/0stars.png' class='lazy'  width='70'>";
					}elseif($produk->rating_produk <= 5){
							$rat = "<img src='".base_url()."assets/images/img/rating/1stars.png' data-original='assets/images/img/rating/1stars.png' class='lazy'  width='70'>";
					}elseif($produk->rating_produk <= 10){
							$rat = "<img src='".base_url()."assets/images/img/rating/2stars.png' data-original='assets/images/img/rating/2stars.png' class='lazy'  width='70'>";
					}elseif($produk->rating_produk <= 15){
							$rat = "<img src='".base_url()."assets/images/img/rating/3stars.png' data-original='assets/images/img/rating/3stars.png' class='lazy'  width='70'>";
					}elseif($produk->rating_produk <= 20){
							$rat = "<img src='".base_url()."assets/images/img/rating/4stars.png' data-original='assets/images/img/rating/4stars.png' class='lazy'  width='70'>";
					}elseif($produk->rating_produk <= 25 || $produk->rating_produk > 25){	
							$rat = "<img src='".base_url()."assets/images/img/rating/5stars.png' data-original='assets/images/img/rating/5stars.png' class='lazy'  width='70'>";
					}
					echo '<li style="height:50px;"><a href="'.base_url('produk/'.$produk->slug).'">';
					//echo $disc1;
                	echo '<img src="'.$produk->gambar.'" data-original="'.$produk->gambar.'" class="lazy pull-left" height="50" /> 
							<h5 style="margin-bottom:0;font-weight:700;"><span style="padding-left:5px;">'.$nama = word_limiter($produk->nama_produk,5).'</span>
							</h5>';
					echo '<span style="padding-left:5px;">'.$rat.'</span>';
					echo $price;
					echo '</a></li>';
				endforeach;
				echo '</ul>';
			}
			if(!empty($result2)){
				echo('<div class="desc-fil" style="margin-bottom:0;margin-top:20px;">Merk</div>');
				foreach($result2 as $row):
					echo '<a class="dropdown-item" style="margin-right:10px;" href="'.base_url('katalog/brand/'.$row->slug).'"><img src="'.$row->logo.'" width="100"></a>';
				endforeach;
			}
		}
	}

	function subpagefacebook(){
		$this->load->view('theme/v1/header');
		$this->load->view('theme/v1/form_aplikasi');
		$this->load->view('theme/v1/footer');
	}

	function tambahdatasubpage(){
		$this->form_validation->set_rules('edp', 'Kode EDP', 'required|xss_clean');
		$this->form_validation->set_rules('name', 'Nama Supervisor', 'required|xss_clean');
		$this->form_validation->set_rules('name_fb', 'Nama Facebook Supervisor', 'required|xss_clean');
		$this->form_validation->set_rules('alamat', 'Alamat Toko', 'required|xss_clean');
		$this->form_validation->set_rules('ig', 'Instagram Toko', 'required|xss_clean');
		$this->form_validation->set_rules('hp', 'Nomor HP Toko', 'required|xss_clean');
		if($this->form_validation->run() != FALSE ){
			$kodeEdp 	= $this->security->xss_clean($this->input->post('edp'));
			$nama 	= $this->security->xss_clean($this->input->post('name'));
			$namafb 	= $this->security->xss_clean($this->input->post('name_fb'));
			$alamat 	= $this->security->xss_clean($this->input->post('alamat'));
			$ig 	= $this->security->xss_clean($this->input->post('ig'));
			$hp 	= $this->security->xss_clean($this->input->post('hp'));

			// cek bila sudah pernah memasukkan
			$cek = $this->home->cek_data_spv($kodeEdp);
			if($cek->num_rows() > 0){
				$this->session->set_flashdata('error','Data Sudah ada sebelumnya');
				redirect($this->agent->referrer());
			}else{
				$data_toko = array(
					'nama_fb'	=> $namafb,
					'nama_spv'	=> $nama,
					'code_edp'	=> $kodeEdp,
					'alamat'	=> $alamat,
					'ig'	=> $ig,
					'hp'	=> $hp,
				);
				$this->home->add_data_supervisor($data_toko);
				redirect(base_url('selesai'));
			}
		}else{
			$this->session->set_flashdata('error','Isi form dengan lengkap.');
			redirect($this->agent->referrer());
		}
	}

	function selesai_tambahdatasubpage(){
		$this->load->view('theme/v1/header');
		$this->load->view('theme/v1/form_aplikasi_end');
		$this->load->view('theme/v1/footer');
	}

	function lacak_orderan(){
		$this->load->view('theme/v1/header');
		$this->load->view('theme/v1/form_lacak');
		$this->load->view('theme/v1/footer');
	}

	function proses_lacak_pesananFix(){
		$inv1 = $this->security->xss_clean($this->input->post('invoiceNo'));
		$inv2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$inv1);
		$inv3 = strip_tags($inv2);
		$inv = htmlentities($inv3);

		$r = $this->home->lacakPesananfix($inv);
		if($r == "" || empty($r)){
			$this->session->set_flashdata('error', 'Nomor invoice tidak ditemukan.');
			redirect($this->agent->referrer());
		}else{
			$this->data['lacak'] = $this->home->lacakPesananfix($inv);
			$this->load->view('theme/v1/header');
			$this->load->view('theme/v1/form_proses_lacak_pesanan', $this->data);
			$this->load->view('theme/v1/footer');
		}
	}

	function promo(){
		$data['promo'] = $this->home->getPromo();
		$this->load->view('theme/v1/header');
		$this->load->view('theme/v1/promo_menarik', $data);
		$this->load->view('theme/v1/footer');
	}

	function tentang_kami(){
		$myApiKey="AIzaSyAdgRhhXUsATFGL7OPWx1vHgnnx-dwBNDI"; // Provide your API Key
		$myChannelID="UCuy1wqC_-Wh8k5tFrm-q7sg"; // Provide your Channel ID
		$maxResults="25"; // Number of results to display
		 
		// Make an API call to store list of videos to JSON variable
		$myQuery = "https://www.googleapis.com/youtube/v3/search?key=$myApiKey&channelId=$myChannelID&part=snippet,id&order=date&maxResults=$maxResults";
		$videoList = file_get_contents($myQuery);
		 
		// Convert JSON to PHP Array
		$decoded = json_decode($videoList, true);
		 
		// Run a loop to display list of videos
		foreach ($decoded['items'] as $items){
			$id = $items['id']['videoId'];
			$title= $items['snippet']['title'];
			$description = $items['snippet']['description'];
			$thumbnail = $items['snippet']['thumbnails']['default']['url'];
			 
			// Display list with some basic CSS formatting
			echo "<p style='display:inline-block;width:200px;margin:10px;text-align:center;vertical-align:top'>";
			echo "<img src='$thumbnail'>";
			echo "<strong>$title</strong>";
			echo "<small>$description</small>";
			echo "";
		}
		//$data['promo'] = $this->home->getPromo();
		//$this->load->view('theme/v1/header');
		//$this->load->view('theme/v1/tentang-kami');
		//$this->load->view('theme/v1/footer');
	}

	function generate_review(){
		$this->load->model('sec47logaccess/produk_adm');
	    $cekartikeldata = $this->produk_adm->get_data_by_art();
	    foreach($cekartikeldata as $gh){
	      	$id = $gh->id_produk;
	      	$nama = array(
		    	'1' => "Andi",
		    	'2' => "Christ",
		    	'3' => "Rizal",
		    	'4' => "Erik",
		    	'5' => "Ucup",
		    	'6' => "Febra",
		    	'7' => "Teguh",
		    	'8' => "fikri",
		    	'9' => "Ega",
		    	'10' => "Rizki",
		    	'11' => "Rima",
		    	'12' => "Sanjaya",
		    	'13' => "Willy",
		    	'14' => "Zio",
		    	'15' => "Damar",
		    	'16' => "Leo",
		    	'17' => "Chimoot",
		    	'18' => "Armat",
		    	'19' => "Lusi",
		    	'20' => "Vidya",
		    	'21' => "Dicka",
		    	'22' => "Dinda",
		    	'23' => "Elisabet",
		    	'24' => "Moch",
		    	'25' => "Boni",
		    	'26' => "Silvia",
		    	'27' => "Nino",
		    	'28' => "Nico",
		    	'29' => "Rico",
		    	'30' => "Andre",
		    	'31' => "Tiyok",
		    	'32' => "Dejan",
		    	'33' => "Dini",
		    	'34' => "Iman",
		    	'35' => "Adistia",
		    	'36' => "Adam",
		    	'37' => "Cakmat",
		    	'38' => "Clara",
		    	'39' => "Monzots",
		    	'40' => "Tommy",
		    	'41' => "Dedik",
		    	'42' => "Danny",
		    	'43' => "Kusnul",
		    	'44' => "Devina",
		    	'45' => "Zahra",
		    	'46' => "Vanindya",
		    	'47' => "Edi",
		    	'48' => "Sigit",
		    	'49' => "Aris",
		    	'50' => "Didi",
		    );
		    $name1 = array_rand($nama); 
		    $name2 = array_rand($nama); 
		    $name3 = array_rand($nama); 
		    $name4 = array_rand($nama); 
		    $name5 = array_rand($nama); 

		    $reviewx = array(
		    	"a" => "Pengiriman cepat, produk sesuai",
		    	"b" => "Barang sudah diterima, terimakasih.... Belum di coba semoga hasilnya bagus",
		    	"c" => "Bagusss recommended, barang dibungkus rapih. good lah pokonya",
		    	"d" => "Tq ya produknya bagus",
		    	"e" => "Mantap tenan, pengiriman banter",
		    	"f" => "Mantap...sesuai foto bgt,makasih om...bisa jadi langganan terus",
		    	"g" => "Produk sesuai dg pesanan..kualitas oke..penjual responsif",
		    	"h" => "Fix keren ni barang, Pengiriman sesuai pesanan",
		    	"i" => "Barang bagus...sepatunya ringan dan empuk.",
		    	"j" => "Produk sesuai dg pesanan.. kualitas oke..penjual responsif dan pengiriman super cepat..terima kasih",
		    	"k"	=> "Oke oceeee",
		    	"l"	=> "Respon cepat, barang tepat sesuai pesanan.",
		    	"m"	=> "Produk mantap. Pengiriman dan respon cepat. Biar bintang yg bicara",
		    	"n"	=> "100 % original. Made in Indonesia. Poll",
		    	"o"	=> "Barangnya ok",
		    	"p"	=> "Seller fast respone... Sesuai pesanan, Ukuran pas banget 40 2/3. Pasti beli sepatu di toko ini lagi..",
		    	"q"	=> "Barang diterima dengan baik",
		    	"r"	=> "Pelayanannya sgt bagusss.",	
		    	"s"	=> "barang dibungkus rapih. good lah pokonya",
		    	"t"	=> "Seller fast respon, pengiriman cepat, barang sesuai deskripsi, recomended bgt, pasti akan beli lg",
		    	"u"	=> "Manteps",
		    	"v"	=> "Kualitas mantap,bobot ringan ,enak buat lari dan jalan jalan,empuk,terimakasih ",
		    	"w"	=> "barang bagus, seller responsif",
		    	"x"	=> "Mantap lah",
		    	"y"	=> "Sepatunya keren pas liat aslinya , top markotop",
		    	"z"	=> "barang dibungkus rapih. Mantap",
		    	"aa"	=> "ok barang tepat waktu dan kualitas bagus",
		    	"ab"	=> "Sipp barang oke, tdk ada problem sedikit pun",
		    	"ac"	=> "hmmm,, not bad lahh",
		    	"ad"	=> "Barang sudah diterima.. Mantul. Seller juga ramah, konfirmasi sebelum pengiriman.. Terimakasih",
		    	"ae"	=> "Alhamdulillah amanah dan tepat waktu",
		    	"af"	=> "Lumayan lah ada harga ada barang",
		    	"ag"	=> "mantepp, bungkus rapi, sukaaa",
		    	"ah"	=> "Terima kasih barang sudah smpe dg slmt",
		    	"ai"	=> "Pengiriman lumayan cepet peroduk bagus sesuai dengan harga",
		    	"aj"	=> "Barangnya sesuai digambar dan ukuranya pas , recommended buat yang nyari sepatu kece ini",
		    	"ak"	=> "Lumayan barangnya bagus,harganya terjangkau",
		    	"al"	=> "Ok gan, Top",
		    	"am"	=> "Jozztt",
		    	"an"	=> "Terima kasih. Barangnya udah sampai, dalam kondisi baik dan sesuai pesanan.",
		    	"ao"	=> "Mantabblahhh",
		    	"ap"	=> "Barang bagus mudah2an awet trims bt smuanya",
		    );
		    $review1 = array_rand($reviewx);
		    $review2 = array_rand($reviewx);
		    $review3 = array_rand($reviewx);
		    $review4 = array_rand($reviewx);
		    $review5 = array_rand($reviewx);

		    // random time
		    $start_date = "2019-12-01 00:00:00";
		    $end_date = "2020-05-04 00:00:00";
		    $min = strtotime($start_date);
	    	$max = strtotime($end_date);
	    	$int1 = rand($min, $max);
	    	$int2 = rand($min, $max);
	    	$int3 = rand($min, $max);
	    	$int4 = rand($min, $max);
	    	$int5 = rand($min, $max);

	    	// rating produk
	    	$start_rating 	= "15";
	    	$end_rating 	= "25";
	    	$rating = rand($start_rating, $end_rating);

	      	$cek_already_review = $this->produk_adm->cek_review($id);
	    	if($cek_already_review->num_rows() == 0){ // jika review belum pernah sama sekali maka insert review
	    		$data_review1 = array(
			    	"id_produk" 	=> $id,
			    	"id_cs"			=> 0,
			    	"nama_review"   => $nama[$name1],
			    	"review"		=> $reviewx[$review1],
			    	"rating"		=> "5stars.png",
			    	"tgl_review"	=> date("Y-m-d H:i:s",$int1),
			    	"status"		=> "on",
			    );
			    $this->db->insert('produk_review', $data_review1);

			    $data_review2 = array(
			    	"id_produk" 	=> $id,
			    	"id_cs"			=> 0,
			    	"nama_review"   => $nama[$name2],
			    	"review"		=> $reviewx[$review2],
			    	"rating"		=> "4stars.png",
			    	"tgl_review"	=> date("Y-m-d H:i:s",$int2),
			    	"status"		=> "on",
			    );
			    $this->db->insert('produk_review', $data_review2);

			    $data_review3 = array(
			    	"id_produk" 	=> $id,
			    	"id_cs"			=> 0,
			    	"nama_review"   => $nama[$name3],
			    	"review"		=> $reviewx[$review3],
			    	"rating"		=> "5stars.png",
			    	"tgl_review"	=> date("Y-m-d H:i:s",$int3),
			    	"status"		=> "on",
			    );
			    $this->db->insert('produk_review', $data_review3);

			    $data_review4 = array(
			    	"id_produk" 	=> $id,
			    	"id_cs"			=> 0,
			    	"nama_review"   => $nama[$name4],
			    	"review"		=> $reviewx[$review4],
			    	"rating"		=> "5stars.png",
			    	"tgl_review"	=> date("Y-m-d H:i:s",$int4),
			    	"status"		=> "on",
			    );
			    $this->db->insert('produk_review', $data_review4);

			    $data_review5 = array(
			    	"id_produk" 	=> $id,
			    	"id_cs"			=> 0,
			    	"nama_review"   => $nama[$name5],
			    	"review"		=> $reviewx[$review5],
			    	"rating"		=> "4stars.png",
			    	"tgl_review"	=> date("Y-m-d H:i:s",$int5),
			    	"status"		=> "on",
			    );
			    $this->db->insert('produk_review', $data_review5);

			    // update rating produk di DB produk
			    $data_review_produk = array(
			    	'id_produk'		=> $id,
			    	'rating_produk' => $rating,
			    );
			    //print_r($data_review_produk)."<br><br>";

			    $this->db->where('id_produk', $id);
			    $this->db->update('produk', $data_review_produk);

	      	}
	     }
	}

	function artikelcek(){
		$this->load->view('theme/v1/artikelcek');
	}

	function searchart(){
		$this->load->model('sec47logaccess/produk_adm');
	    // tangkap variabel keyword dari URL
	    $keyword = $this->uri->segment(2);
	    // cari di database
	    $data = $this->produk_adm->cariDataartikel($keyword);

	    // format keluaran di dalam array
	    if($data->num_rows() == 0){
	      $arr['query'] = $keyword;
	      $arr['suggestions'][] = array(
	        'value' => 'Tidak ada hasil',
	        'artikel' => 'Tidak ada hasil', 
	      );
	    }
	    foreach($data->result() as $row)
	    {
	      $arr['query'] = $keyword;
	      $arr['suggestions'][] = array(
	        'value' => $row->art_id,
	        'artikel' => $row->art_id,
	      );
	    }
	    // minimal PHP 5.2
	    echo json_encode($arr);
	    
	}

	function cekStokbyrimsx(){
		$this->load->model('sec47logaccess/produk_adm');
	    $data_filtering = $this->security->xss_clean($this->input->post('getinvdata'));
	    $datax = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

	    $curl = curl_init();
	    $proxy = '192.168.0.219:80';

	    curl_setopt_array($curl, array(
	    CURLOPT_URL => "http://sm.stars.co.id/ws/lap_stock.php?api=0x010042602D856FE11654537274084EAA64C036BF6BBB8F985A9D&art_id=".$datax."",
	    //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_ENCODING => "",
	    CURLOPT_MAXREDIRS => 10, 
	    CURLOPT_TIMEOUT => 30,
	    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    CURLOPT_CUSTOMREQUEST => "GET",
	    //CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
	    CURLOPT_HTTPHEADER => array(
	      "content-type: application/x-www-form-urlencoded",
	    ),
	    ));

	    $response = curl_exec($curl);
	    $err = curl_error($curl);

	    curl_close($curl);

	    if($err){
	      $this->session->set_flashdata('error', 'Gagal mengambil data dari server #: '.$err.'');
	      //log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal cek stok artikel '.$datax.' dari server stars');
	      echo  "<span class='pull-right' style='font-size:20px;font-weight:bold;color:red;cursor:pointer;' onclick='closecekStok();'>X</span>";
	      echo "Gagal cek stok. periksa koneksi internet.";
	    }else{
	      $totalstok = 0;
	      $totaltoko = 0;
	      $data = json_decode($response, true);
	      for ($l=0; $l < count($data['stock']); $l++){ 
	        $totalstok += $data['stock'][$l]['psg'];
	        $totaltoko += count($data['stock'][$l]['str_id']);
	      }
	      // harga
	      $cekharga = $this->produk_adm->syncPrice($datax);

	      echo  "<span style='font-size:20px;font-weight:bold;color:red;cursor:pointer;' onclick='closecekStok();'>X</span><div style='text-align:left;margin-bottom:20px;'>Artikel <b>: ".$datax." - Rp.".number_format($cekharga['retprc'],0,".",".")."</b><br>Total Stok Semua Toko <b>: ".$totalstok." PSG</b><br>Total toko yang memiliki stok <b>: ".$totaltoko." Toko</b></div><div id='reportcesktok' class='table-responsive'>";
	      $data = json_decode($response, true);
	      $nomor = 0;
	      for ($l=0; $l < count($data['stock']); $l++){ 
	      $nomor++;
	        $edptokox = $data['stock'][$l]['str_id'];
	        //PERPENDEK KATA
	        $maxword1 = 3;
	        $maxword2 = 2;
	        $maxword3 = 1;

	        // potong kata first dan last
	        $firstnamex = substr($edptokox, 0, $maxword1);
	        $lsnamex = substr($edptokox, -2, $maxword2);
	        $edptoko = $firstnamex.'-'.$lsnamex;

	        $cek = $this->produk_adm->cek_toko($edptoko);
	        if($cek['nama_toko'] == ""){
	          $namatoko = "[ Unknown Store ]";
	        }else{
	          $namatoko = $cek['nama_toko'];
	        }

	        // Inisialisasi Ukuran
	        $artxd = explode('-', $datax);
	        $lsartx = $artxd[1];
	        $lsart = substr($lsartx, 0, $maxword3);
	        if($lsart == 0 || $lsart == 1){
	          $u1 = "<label class='label label-default' style='font-size:12px;'>15 => ".$data['stock'][$l]['u1']."</label>";
	          $u2 = "<label class='label label-default' style='font-size:12px;'>16 => ".$data['stock'][$l]['u2']."</label>";
	          $u3 = "<label class='label label-default' style='font-size:12px;'>17 => ".$data['stock'][$l]['u3']."</label>";
	          $u4 = "<label class='label label-default' style='font-size:12px;'>18 => ".$data['stock'][$l]['u4']."</label>";
	          $u5 = "<label class='label label-default' style='font-size:12px;'>19 => ".$data['stock'][$l]['u5']."</label>";
	          $u6 = "<label class='label label-default' style='font-size:12px;'>20 => ".$data['stock'][$l]['u6']."</label>";
	          $u7 = "<label class='label label-default' style='font-size:12px;'>21 => ".$data['stock'][$l]['u7']."</label>";
	          $u8 = "<label class='label label-default' style='font-size:12px;'>22 => ".$data['stock'][$l]['u8']."</label>";
	          $u9 = "<label class='label label-default' style='font-size:12px;'>23 => ".$data['stock'][$l]['u9']."</label>";
	          $u10 = "<label class='label label-default' style='font-size:12px;'>24 => ".$data['stock'][$l]['u10']."</label>";
	          $u11 = "<label class='label label-default' style='font-size:12px;'>25 => ".$data['stock'][$l]['u11']."</label>";
	          $u12 = "<label class='label label-default' style='font-size:12px;'>26 => ".$data['stock'][$l]['u12']."</label>";
	          $u13 = "<label class='label label-default' style='font-size:12px;'>27 => ".$data['stock'][$l]['u13']."</label>";
	        }else if($lsart == 3){
	          $u1 = "<label class='label label-default' style='font-size:12px;'>24 => ".$data['stock'][$l]['u1']."</label>";
	          $u2 = "<label class='label label-default' style='font-size:12px;'>25 => ".$data['stock'][$l]['u2']."</label>";
	          $u3 = "<label class='label label-default' style='font-size:12px;'>26 => ".$data['stock'][$l]['u3']."</label>";
	          $u4 = "<label class='label label-default' style='font-size:12px;'>27 => ".$data['stock'][$l]['u4']."</label>";
	          $u5 = "<label class='label label-default' style='font-size:12px;'>28 => ".$data['stock'][$l]['u5']."</label>";
	          $u6 = "<label class='label label-default' style='font-size:12px;'>29 => ".$data['stock'][$l]['u6']."</label>";
	          $u7 = "<label class='label label-default' style='font-size:12px;'>30 => ".$data['stock'][$l]['u7']."</label>";
	          $u8 = "<label class='label label-default' style='font-size:12px;'>31 => ".$data['stock'][$l]['u8']."</label>";
	          $u9 = "<label class='label label-default' style='font-size:12px;'>32 => ".$data['stock'][$l]['u9']."</label>";
	          $u10 = "<label class='label label-default' style='font-size:12px;'>33 => ".$data['stock'][$l]['u10']."</label>";
	          $u11 = "<label class='label label-default' style='font-size:12px;'>34 => ".$data['stock'][$l]['u11']."</label>";
	          $u12 = "<label class='label label-default' style='font-size:12px;'>35 => ".$data['stock'][$l]['u12']."</label>";
	          $u13 = "<label class='label label-default' style='font-size:12px;'>36 => ".$data['stock'][$l]['u13']."</label>";
	        }else if($lsart == 4 || $lsart == 5 || $lsart == 6 || $lsart == 7){
	          $u1 = "<label class='label label-default' style='font-size:12px;'>30 => ".$data['stock'][$l]['u1']."</label>";
	          $u2 = "<label class='label label-default' style='font-size:12px;'>31 => ".$data['stock'][$l]['u2']."</label>";
	          $u3 = "<label class='label label-default' style='font-size:12px;'>32 => ".$data['stock'][$l]['u3']."</label>";
	          $u4 = "<label class='label label-default' style='font-size:12px;'>33 => ".$data['stock'][$l]['u4']."</label>";
	          $u5 = "<label class='label label-default' style='font-size:12px;'>34 => ".$data['stock'][$l]['u5']."</label>";
	          $u6 = "<label class='label label-default' style='font-size:12px;'>35 => ".$data['stock'][$l]['u6']."</label>";
	          $u7 = "<label class='label label-default' style='font-size:12px;'>36 => ".$data['stock'][$l]['u7']."</label>";
	          $u8 = "<label class='label label-default' style='font-size:12px;'>37 => ".$data['stock'][$l]['u8']."</label>";
	          $u9 = "<label class='label label-default' style='font-size:12px;'>38 => ".$data['stock'][$l]['u9']."</label>";
	          $u10 = "<label class='label label-default' style='font-size:12px;'>39 => ".$data['stock'][$l]['u10']."</label>";
	          $u11 = "<label class='label label-default' style='font-size:12px;'>40 => ".$data['stock'][$l]['u11']."</label>";
	          $u12 = "<label class='label label-default' style='font-size:12px;'>41 => ".$data['stock'][$l]['u12']."</label>";
	          $u13 = "<label class='label label-default' style='font-size:12px;'>42 => ".$data['stock'][$l]['u13']."</label>";
	        }else if($lsart == 8){
	          $u1 = "<label class='label label-default' style='font-size:12px;'>34 => ".$data['stock'][$l]['u1']."</label>";
	          $u2 = "<label class='label label-default' style='font-size:12px;'>35 => ".$data['stock'][$l]['u2']."</label>";
	          $u3 = "<label class='label label-default' style='font-size:12px;'>36 => ".$data['stock'][$l]['u3']."</label>";
	          $u4 = "<label class='label label-default' style='font-size:12px;'>37 => ".$data['stock'][$l]['u4']."</label>";
	          $u5 = "<label class='label label-default' style='font-size:12px;'>38 => ".$data['stock'][$l]['u5']."</label>";
	          $u6 = "<label class='label label-default' style='font-size:12px;'>39 => ".$data['stock'][$l]['u6']."</label>";
	          $u7 = "<label class='label label-default' style='font-size:12px;'>40 => ".$data['stock'][$l]['u7']."</label>";
	          $u8 = "<label class='label label-default' style='font-size:12px;'>41 => ".$data['stock'][$l]['u8']."</label>";
	          $u9 = "<label class='label label-default' style='font-size:12px;'>42 => ".$data['stock'][$l]['u9']."</label>";
	          $u10 = "<label class='label label-default' style='font-size:12px;'>43 => ".$data['stock'][$l]['u10']."</label>";
	          $u11 = "<label class='label label-default' style='font-size:12px;'>44 => ".$data['stock'][$l]['u11']."</label>";
	          $u12 = "<label class='label label-default' style='font-size:12px;'>45 => ".$data['stock'][$l]['u12']."</label>";
	          $u13 = "<label class='label label-default' style='font-size:12px;'>46 => ".$data['stock'][$l]['u13']."</label>";
	        }

	        if($data['stock'][$l]['psg'] == 0 || $data['stock'][$l]['psg'] == ""){
	          $jmlpasangtoko = "<i style='color:red'>0</i>";
	        }else{
	          $jmlpasangtoko = $data['stock'][$l]['psg'];
	        }

	        if($datax == "BB4499-992" || $datax == "BB6599-992" || $datax == "BB1599-992" || $datax == "SZ6501-992" || $datax == "SZ1501-992" || $datax == "SZ4401-992"){ // artikel non sepatu / sandal
	          $size = "Artikel Non Sepatu / Sandal (Tidak tampil ukuran)";
	        }else{
	          $size = "".$u1." ".$u2." ".$u3." ".$u4." ".$u5." ".$u6." ".$u7." ".$u8." ".$u9." ".$u10." ".$u11." ".$u12." ".$u13."";
	        } 

	        echo "<div style='background-color:#f9f9f9;border:white;box-shadow:3px 3px 6px 0px #d5d5d5;padding:10px;text-align:left;'> 
	              <label class='label label-primary' style='font-weight:bold;font-size14px;margin-right:5px;position: absolute;left: 30px;margin-top: -10px;'>".$nomor."</label>
	                <div style='margin-left:20px;'>
	                  <b>".$namatoko."</b><br>
	                  ".$cek['alamat']."<br>
	                  Kode EDP : ".$data['stock'][$l]['str_id']."<br>
	                  Nomor HP Toko : <a target='_new' href='https://wa.me/".$cek['spv_nomor']."'> ".$cek['spv_nomor']."</a> | <a href='tel:".$cek['spv_nomor']."'><i class='glyphicon glyphicon-phone'></i></a><br>
	                  Total Stok diToko : <b>".$jmlpasangtoko." PSG</b><br><br>
	                  ".$size."
	                </div>
	              </div><br>";

	      }
	      
	      echo "</tbody></table>";
	      echo "</div>";
	      //log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cek stok artikel '.$datax.' dari server stars');
	    }
	}

	function sinkrondatatopos(){
		$api =  $this->security->xss_clean($this->input->get('api'));
		$market =  $this->security->xss_clean($this->input->get('market'));
		$tgl1 =  $this->security->xss_clean($this->input->get('tgl1'));
		$tgl2 =  $this->security->xss_clean($this->input->get('tgl2'));
		$key = "XN1JKJ48N048CN8964CN78GSDF1";
		if($api != $key || $tgl1 == "" || $tgl2 == "" || $market == ""){
			echo "AKSES DITOLAK";
		}else{
			$dataSales = array();
			//$dataProduk = array();
			$getSales = $this->home->getDataProduk($market, $tgl1, $tgl2);
			foreach($getSales->result() as $d){
	        	// cek data ganda di database
	        	$idSales = $d->Sls_id;
        		$dataSales[] = array(
        			// SALES //
	        		'Sls_id' 	=> $d->Sls_id,
	        		'tgl' 		=> $d->tgl,
	        		'us_id'		=> $d->us_id,
	        		'jns' 		=> $d->jns,
	        		'card' 		=> $d->card,
	        		'kasir'		=> $d->kasir,	
	        		// PRODUK //
	        		'Sls_id1' 	=> $d->Sls_id,
	        		'Art_id' 	=> $d->Art_id,
	        		'RetPrc'	=> $d->RetPrc,
	        		'Psg' 		=> $d->Psg,
	        		'Uk' 		=> $d->Uk,
	        		'ur'		=> $d->ur,
	        		'ket'		=> $d->ket,
	        	);

	        	//$getProduk = $this->home->getDataProduk($market, $idSales);
	        	//foreach($getProduk->result() as $p){
	        	//	$dataProduk[] = array(
		        //		'Sls_id' 	=> $p->Sls_id,
		        //		'Art_id' 	=> $p->Art_id,
		        //		'RetPrc'	=> $p->RetPrc,
		        //		'Psg' 		=> $p->Psg,
		        //		'Uk' 		=> $p->Uk,
		        //		'ur'		=> $p->ur,
		        //		'ket'		=> $p->ket,
		        //	);
		        	//echo json_encode(array('produksales' => $dataProduk));
	        	//}
	        	
		     }

		    $encode_data = json_encode(array('sales'=>$dataSales));
			echo $encode_data;
			log_helper('laporan', 'Server mendapat request untuk melakukan sinkron data sales semua marketplace dari server starsstore ke server POS semua marketplace'); //$market
		}
	}
}
