<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model(array('home','users')); 
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
 
	function pro_condition_details($read){

		$get_id_by_encrypt = $this->home->get_id_produk_detail($read);
		foreach($get_id_by_encrypt->result() as $get){
			$id = $get->id_produk;
			$sku = $get->sku_produk;
			$get_id = $this->encrypt->encode($get->id_produk);
			$get_id_last = base64_encode($get_id);
			$stat = $get->status;
		}
		// jika produk non aktif 
		if($get_id_by_encrypt->num_rows() == 0){
			$this->load->model('home');
			$data['produk_lain'] = $this->home->get_produk_latest();
			$this->load->view('theme/v1/header');
			$this->load->view('theme/v1/404', $data);
			$this->load->view('theme/v1/footer');
		}else if($stat == "dump"){
			$this->load->model('home');
			$data['produk_lain'] = $this->home->get_produk_latest();
			$this->load->view('theme/v1/header');
			$this->load->view('theme/v1/404', $data);
			$this->load->view('theme/v1/footer');
		}else if($stat == "on" || $stat == "soldout"){
		// masukkan ke table produk_viewed
			$data['kupon']				= $this->home->get_coupon();
			$this->home->put_in_product_viewed($id);
			$data['next_produk'] 		= $this->home->next_p();
			$data['produk_lain'] 		= $this->home->get_produk_randoms();
			$data['detail_k'] 			= $this->home->produk_detail($get_id_last);
			$data['gambar_tambahan'] 	= $this->home->produk_gambar_tambahan($sku); 
			$data['kategori'] 			= $this->home->produk_kategori($get_id_last);
			$data['get_option_size'] 	= $this->home->produk_option_size($get_id_last);
			$data['get_option_color'] 	= $this->home->produk_option_color($get_id_last);
			$data['get_option_color_add'] = $this->home->produk_option_color_add($get_id_last);
			$data['rev']				= $this->home->produk_review($get_id_last);
			$data['qna']				= $this->home->diskusi_produk($get_id_last);
			$data['get_size_produk'] 	= $this->home->get_size_produk_detail($id);
			$umur_p = $this->home->umur_produk($get_id_last); 

			if($umur_p->num_rows() > 0){
				$data['umur'] = "<label class='diskon-detail'>New Arrival</label>";
			}else{
				$data['umur'] = "";
			} 

			$info = $this->home->produk_detail($get_id_last);

			foreach ($info as $d) {
				$title = $d->nama_produk;
				$desc  = $d->tags;
				$keyword = $d->tags;
			}

			$data_s['title'] = "<title>".$title."</title>";
			$data_s['meta_desc'] = "<meta name='description' content='".$desc."' />";
			$data_s['meta_key'] = "<meta name='keywords' content='".$keyword."'/>";

	//		$data_head = array($title, $meta_desc, $meta_key);
			$this->load->view('theme/v1/header', $data_s);
			$this->load->view('theme/v1/produk_detail', $data);
			$this->load->view('theme/v1/footer'); 
		}else{
			$this->load->model('home');
			$data['produk_lain'] = $this->home->get_produk_latest();
			$this->load->view('theme/v1/header');
			$this->load->view('theme/v1/404', $data);
			$this->load->view('theme/v1/footer');
		}
	}

	function get_price(){
		$id = $this->security->xss_clean($this->input->post('yt'));
		$cl = $this->security->xss_clean($this->input->post('clo'));
		$sz = $this->security->xss_clean($this->input->post('szo'));

		// WARNA
		if($cl == "" || $cl == null){ // jika warna dipilih semua ID == 1
			$idcolor = 1;	
			$color = "-";
		}else{

			$excolor1 	= explode('|', $cl);
			// id warna
	        $exidcolor1 = $excolor1[0];
	        $exidcolor2	= base64_decode($exidcolor1);
	        $idcolor 	= $this->encrypt->decode($exidcolor2);
	        // warna
	        $excolor11   = $excolor1[1];
	        $excolor2 	= base64_decode($excolor11);
	        $color   	= $this->encrypt->decode($excolor2);

	    }	    

		// SIZE
		if($sz == "" || $sz == null){ // jika ukuran dipilih semua ID == 1
			$idsize = 1;	
			$size = "-";
		}else{

			$exsize1 	= explode('|', $sz);
			// id size
	        $exidsize1 	= $exsize1[0];
	        $exidsize2	= base64_decode($exidsize1);
	        $idsize 	= $this->encrypt->decode($exidsize2);
	        // size
	        $exsize11   = $exsize1[1];
	        $exsize2 	= base64_decode($exsize11);
	        $size   	= $this->encrypt->decode($exsize2);
	    }

        // cari harga berdasarkan warna dan size
        $hstPrice = $this->home->get_price($id,$idcolor,$idsize);
        //print_r($hstPrice->result());

        if($hstPrice->num_rows() == 0){
        	$priceh = "<i style='color:red;'>Harga tidak tersedia.</i>";
        	$be = "";
        	$at = "";
        }else{
	        foreach($hstPrice->result() as $p){
	        	if(empty($p->harga_dicoret) || $p->harga_dicoret == 0){
	                $priceh = "<span class='price'>Rp ".number_format($p->harga_fix,0,".",".")."</span>";
	                $be = "";
	                $atx = $p->harga_fix;
	                // encryption
	                $atxx = $this->encrypt->encode($atx);
	                $at = base64_encode($atxx);
	            }else{
	                $priceh = "<span class='price'><del>Rp ".number_format($p->harga_dicoret,0,".",".")."</del> Rp ".number_format($p->harga_fix,0,".",".")." <label class='label-diskon-detail'>".round(($p->harga_dicoret - $p->harga_fix) / $p->harga_dicoret * 100)."%</label></span> ";
	                $bex = $p->harga_dicoret;
	                $atx = $p->harga_fix;
	                // encryption
	                $atxx = $this->encrypt->encode($atx);
	                $at = base64_encode($atxx);

	                $bexx = $this->encrypt->encode($bex);
	                $be = base64_encode($bexx);
	            }
	        }
	    }
        $this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('pricehtml'=> $priceh,'be'=> $be, 'at'=> $at)));
	}
}