<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alat_promosi extends CI_Controller { 
 
	function __construct(){ 
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/alat_promosi_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){ 
			redirect(base_url());
		}
	}

	function index(){ // get data produk in list data
		$judul['judul'] = $this->alat_promosi_adm->get_id_judul();
		$success = array( 'error' => '', 'success' => '');
		$list_data['get_list'] = $this->alat_promosi_adm->get_list_promo();
		$data = array_merge($success, $list_data, $judul);
		$this->load->view('manage/header');
		$this->load->view('manage/promosi/alat_promosi/index', $data);
		$this->load->view('manage/footer');
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Promo slide utama');
		
	}

	function popup_homepage(){
		$data['r']	= $this->alat_promosi_adm->get_setting_popup();
		$this->load->view('manage/header');
		$this->load->view('manage/promosi/alat_promosi/popup_homepage',$data);
		$this->load->view('manage/footer');
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Popup Homepage');
	}

	function simpan_settingpopup(){
		$tipepopup 	= $this->security->xss_clean($this->input->post('tipepopup'));
		if($tipepopup == "newsletter"){
			$keteranganatas 	= $this->input->post('editor1');
			$keteranganbawah 	= $this->input->post('keteranganbawah');
			$data = array(
				'konten'	=> $this->security->xss_clean($this->input->post('tipepopup')),
				'meta_desc'	=> $keteranganatas,
				'meta_key'	=> $keteranganbawah,
			);
			$this->alat_promosi_adm->save_setting_popup($data);
		}else if($tipepopup == "popup"){
			$gambar 	= $this->input->post('gambar');
			$data = array(
				'konten'		=> $this->security->xss_clean($this->input->post('tipepopup')),
				'site_title'	=> $gambar,
			);
			$this->alat_promosi_adm->save_setting_popup($data);
		}else{ // turn off / on popup
			$status = $this->input->post('status');
			if($status == ""){
				$statusx = "";
			}else{
				$statusx = "on";
			}
			$data = array(
				'aktif'	=> $statusx,
			);
			$this->alat_promosi_adm->save_setting_popup($data);
		}
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Popup telah disetting');
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') mengubah setting popup');
		redirect($this->agent->referrer());
	}

	function free_ongkir(){
		$data['freeongkir'] = $this->alat_promosi_adm->get_data_city();
		$this->load->view('manage/header');
		$this->load->view('manage/promosi/alat_promosi/free_ongkir',$data);
		$this->load->view('manage/footer');
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Popup Homepage');
	}

	function settingfreeongkir(){
		$status_filtering 	= $this->security->xss_clean($this->input->post('st'));
        $status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$status_filtering);

        //simpan statusfreeongkir
        if($status == "on"){
        	$statusx = "on";
        }else{
        	$statusx = "";
        }
        $settingstatus = array(
        	'aktif'			=> $statusx,
        	'diubah_oleh'	=> $this->data['id'],
        	'diubah_tgl'	=> date('Y-m-d H:i:s'),
        );
        $this->db->where('nama','free_ongkir_all_city');
        $this->db->update('setting',$settingstatus);
	}

	function simpankotafreeongkir(){
		$id_filtering 	= $this->security->xss_clean($this->input->post('idcity'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);

        $city_filtering 	= $this->security->xss_clean($this->input->post('city'));
        $city = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$city_filtering);

        $cek = $this->alat_promosi_adm->cek_id_city($id); // cek jika ada
        if($cek > 0){ // jika ada
        	echo "alreadycity";
        }else{ // jika tidak ada maka input
        	$data = array(
        		'id_kota'	=> $id,
        		'kota'		=> $city,
        	);
        	$this->alat_promosi_adm->save_city_freeongkir($data);

        	//load data ongkir
        	$load = $this->alat_promosi_adm->get_data_cityfreeongkir();
        	$no = 0;
        	echo "<ul class='list-unstyled cityfree'>";
        	foreach($load as $y){
        		$no++;
        		echo '<li><b>'.$no.'. '.$y->kota.'</b><a class="pull-right" href="javascript:void(0);" onclick="hapus_kota_freeongkir(this)" data-id="'.$y->id_kota.'"><i class="glyphicon glyphicon-trash"></i></a></li>';
        	}
        	echo "</ul>";
        }
	}

	function hapuskota(){
		$id 	= $this->security->xss_clean($this->input->get('id'));
		$this->db->where('id_kota',$id);
		$this->db->delete('kota_free_ongkir');

		//load data ongkir
    	$load = $this->alat_promosi_adm->get_data_cityfreeongkir();
    	$no = 0;
    	echo "<ul class='list-unstyled cityfree'>";
    	foreach($load as $y){
    		$no++;
    		echo '<li><b>'.$no.'. '.$y->kota.'</b><a class="pull-right" href="javascript:void(0);" onclick="hapus_kota_freeongkir(this)" data-id="'.$y->id_kota.'"><i class="glyphicon glyphicon-trash"></i></a></li>';
    	}
    	echo "</ul>";
	}

	function ubah_judul($id){
		$a = $this->encrypt->encode($id); 
		$b = base64_encode($a);
		$get = $this->alat_promosi_adm->get_judul($b);
		echo json_encode($get);
	}

	function update_judul(){
		$id_filtering 	= $this->security->xss_clean($this->input->post('id_judul'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);
        $data_filtering 	= $this->security->xss_clean($this->input->post('judul'));
        $judul = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
		$id_user = $this->data['id'];
		$data = array(
				'judul'		   	=> $judul,
				'user_pengubah'	=> $id_user,
				'diubah'   		=> date('Y-m-d H:i:s'),
			);
		$this->alat_promosi_adm->update_judul(array('id_promo' => $id), $data);
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') update judul promo slide utama ( '.$judul.' )');
	}

	function update_flag(){
		$id_filtering 	= $this->security->xss_clean($this->input->post('id_flag'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);

        $data_filtering 	= $this->security->xss_clean($this->input->post('flag'));
        $judul = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

        $tgl1_filtering 	= $this->security->xss_clean($this->input->post('tgl1'));
        $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1_filtering);

        $tgl2_filtering 	= $this->security->xss_clean($this->input->post('tgl2'));
        $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2_filtering);

		$id_user = $this->data['id'];
		$data = array(
				'promo'		   	=> $judul,
				'tgl_mulai'		=> $tgl1,
				'tgl_akhir'		=> $tgl2,
				'user'			=> $id_user,
			);
		$this->alat_promosi_adm->update_flag(array('id' => $id), $data);
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') update home flag ( '.$judul.' )');
	}

	function nonaktif_flag(){
		$id_filtering 	= $this->security->xss_clean($this->input->post('id_flag'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);

		$id_user = $this->data['id'];
		$data = array(
				'status'		=> 'off',
				'user'			=> $id_user,
			);
		$this->alat_promosi_adm->off_flag(array('id' => $id), $data);
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') menonaktfikan home flag');
	}

	function aktif_flag(){
		$id_filtering 	= $this->security->xss_clean($this->input->post('id_flag'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);

		$id_user = $this->data['id'];
		$data = array(
				'status'		=> 'on',
				'user'			=> $id_user,
			);
		$this->alat_promosi_adm->on_flag(array('id' => $id), $data);
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') mengaktfikan home flag');
	}

	function tambah_promo(){ //load semua data yang ditampilkan pada form tambah produk
		$data['get_kriteria'] = $this->alat_promosi_adm->get_kriteria();	
		$data['get_kriteria_rentang'] = $this->alat_promosi_adm->get_kriteria_rentang();	
		$data['get_kriteria_rentang_harga'] = $this->alat_promosi_adm->get_kriteria_rentang_harga();	
		$this->load->view('manage/header');
		$this->load->view('manage/promosi/alat_promosi/add', $data);
		$this->load->view('manage/footer');
	}

	function proses_tambah_promo(){ // proses tambah data produk
		$promo1 = $this->input->post('jenis_promo1');
		$promo2 = $this->input->post('jenis_promo2');
		$promo3 = $this->input->post('jenis_promo3');
		$mulai = $this->input->post('tgl_mulai');
		$mulaix = date('d F Y H:i:s', strtotime($mulai));
		$akhir = $this->input->post('tgl_akhir');
		$akhirx = date('d F Y H:i:s', strtotime($akhir));
		$nama_promo = $this->input->post('nama_promo');

		if(empty($promo1) && empty($promo2) && empty($promo3)){

			$id_user = $this->data['id'];
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
        	//adding data
			$this->alat_promosi_adm->add_promo_banner($id_user, $data); 
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Promo '.$nama_promo.' dari '.$mulaix.' sampai '.$akhirx.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo "'.$nama_promo.'" ditambahkan mulai dari '.$mulaix.' sampai dengan '.$akhirx.'');
			redirect('trueaccon2194/promo_slide_utama');


		}else if(!empty($promo1)){
			$id_user = $this->data['id'];
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
        	//adding data
			$this->alat_promosi_adm->add_promo1($id_user, $data); 
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Promo '.$nama_promo.' dari '.$mulaix.' sampai '.$akhirx.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo "'.$nama_promo.'" ditambahkan mulai dari '.$mulaix.' sampai dengan '.$akhirx.'');
			redirect('trueaccon2194/promo_slide_utama');

		}else if(!empty($promo2)){

			$id_user = $this->data['id'];
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
        	//adding data
			$this->alat_promosi_adm->add_promo2($id_user, $data); 
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Promo '.$nama_promo.' dari '.$mulaix.' sampai '.$akhirx.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo "'.$nama_promo.'" ditambahkan mulai dari '.$mulaix.' sampai dengan '.$akhirx.'');
			redirect('trueaccon2194/promo_slide_utama');

		}else if(!empty($promo3)){

			$id_user = $this->data['id'];
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
        	//adding data
			$this->alat_promosi_adm->add_promo3($id_user, $data); 
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Promo '.$nama_promo.' dari '.$mulaix.' sampai '.$akhirx.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo '.$nama_promo.' ditambahkan mulai dari '.$mulaix.' sampai dengan '.$akhirx.'');
			redirect('trueaccon2194/promo_slide_utama');

		}else{

			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah promo');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
		}
	}

	function edit_promo($ids){
		$a = base64_decode($ids);
		$id = $this->encrypt->decode($a);
		$data['get_kriteria'] = $this->alat_promosi_adm->get_kriteria_edit();	
		$data['get_kriteria_rentang'] = $this->alat_promosi_adm->get_kriteria_rentang_edit();	
		$data['get_kriteria_rentang_harga'] = $this->alat_promosi_adm->get_kriteria_rentang_harga_edit();	
		$data['data'] = $this->alat_promosi_adm->get_list_promo_edit($id);

		$status = $this->alat_promosi_adm->get_list_promo_edit($id);
		if (empty($status['status'])){
		
				$data['status1'] = '';
		
		}elseif($status['status'] == 'on'){
		
				$data['status1'] = 'checked';
		
		}elseif($status['status'] == 'expired'){
		
				$data['status1'] = '';
		}
		
		
		$data['status_post'] = $status;
		$this->load->view('manage/header');
		$this->load->view('manage/promosi/alat_promosi/edit_data', $data);
		$this->load->view('manage/footer');
	}

	function edit_promo_proses(){
		$promo1 = $this->input->post('jenis_promo1');
		$promo2 = $this->input->post('jenis_promo2');
		$promo3 = $this->input->post('jenis_promo3');
		$mulai = $this->input->post('tgl_mulai');
		$mulaix = date('d F Y H:i:s', strtotime($mulai));
		$akhir = $this->input->post('tgl_akhir');
		$akhirx = date('d F Y H:i:s', strtotime($akhir));
		$nama_promo = $this->input->post('nama_promo');

		if(empty($promo1) && empty($promo2) && empty($promo3)){

			$id_user = $this->data['id'];
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
        	//adding data
			$this->alat_promosi_adm->update_promo_banner($id_user, $data); 
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Edit Promo '.$nama_promo.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo "'.$nama_promo.'" Berhasil diubah');
			redirect('trueaccon2194/promo_slide_utama');


		}else if(!empty($promo1)){
			$id_user = $this->data['id'];
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
        	//adding data
			$this->alat_promosi_adm->update_promo1($id_user, $data); 
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Edit Promo '.$nama_promo.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo "'.$nama_promo.'" Berhasil diubah');
			redirect('trueaccon2194/promo_slide_utama');

		}else if(!empty($promo2)){

			$id_user = $this->data['id'];
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
        	//adding data
			$this->alat_promosi_adm->update_promo2($id_user, $data); 
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Edit Promo '.$nama_promo.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo "'.$nama_promo.'" Berhasil diubah');
			redirect('trueaccon2194/promo_slide_utama');

		}else if(!empty($promo3)){

			$id_user = $this->data['id'];
			$data_filtering = $this->security->xss_clean($this->input->post());
        	$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
        	//adding data
			$this->alat_promosi_adm->update_promo3($id_user, $data); 
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Edit Promo '.$nama_promo.'');
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo "'.$nama_promo.'" Berhasil diubah');
			redirect('trueaccon2194/promo_slide_utama');

		}else{

			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Mengubah promo');
			$this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
		}
	} 

	function cek_expired_promo(){
		$cek = $this->alat_promosi_adm->cek_exp();
		foreach($cek as $r){
			$id = $r->id_promo;
			$now = date('Y-m-d H:i:s');
			$dateData = $r->tgl_akhir;

			if($now > $dateData){
				$this->alat_promosi_adm->ganti_status_exp($id);
			}
		}
	}

	function cek_expired_flag(){
		$cek = $this->alat_promosi_adm->cek_exp_flag();
		foreach($cek as $r){
			$id = $r->id;
			$now = date('Y-m-d');
			$dateData = $r->tgl_akhir;

			if($now > $dateData){
				$this->alat_promosi_adm->ganti_status_exp_flag($id);
			}
		}
	}

	function home_flag(){
		$g = $this->alat_promosi_adm->home_flag();
		echo json_encode($g);
	}

	function hapus_promo($id){
		$this->alat_promosi_adm->hapus_promo($id);
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Hapus ID promo '.$id.'');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo "'.$nama_promo.'" dihapus');
		redirect(base_url('trueaccon2194/promo_slide_utama'));
	}

	function on($id){
		$this->alat_promosi_adm->on($id);
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Mengaktifkan ID promo '.$id.'');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo "'.$nama_promo.'" diaktifkan');
		redirect(base_url('trueaccon2194/promo_slide_utama'));
	}

	function off($id){
		$this->alat_promosi_adm->off($id);
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Menonaktifkan ID promo '.$id.'');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Promo "'.$nama_promo.'" dinonaktifkan');
		redirect(base_url('trueaccon2194/promo_slide_utama'));
	}
	
}