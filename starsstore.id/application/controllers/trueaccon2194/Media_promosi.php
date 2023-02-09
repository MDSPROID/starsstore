<?php if( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Media_promosi extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/media_promosi_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){
		$data = array('error' => '', 'success' => '', 'error1' => '', 'success1' => '', 'error2' => '', 'success2' => '');
		$data['get_list'] = $this->media_promosi_adm->get_banner();
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Banner & Slider');
		$this->load->view('manage/header');
		$this->load->view('manage/promosi/banner/index', $data);
		$this->load->view('manage/footer');
	}

	function cek_expired_banner(){
		$cek = $this->media_promosi_adm->cek_exp();
		foreach($cek as $r){
			$id = $r->id_banner;
			$kett = $r->ket;
			$now = date('Y-m-d');
			$dateData = $r->tgl_akhir;

			if($dateData > $now){
//				echo "expired";
				log_helper('promosi', '[SYSTEM] mengganti status Banner '.$kett.' menjadi expired');
				$this->media_promosi_adm->ganti_status_exp($id);
			}else{
				echo "gak expired";
			}
		}
	}

	function edit($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);

		$cek_posisi_banner = $this->media_promosi_adm->cek_posisi($b);
		
		if($cek_posisi_banner['posisi'] == "utama"){
			$data['g'] = $cek_posisi_banner;
			$this->load->view('manage/header');
			$this->load->view('manage/promosi/banner/edit', $data);
			$this->load->view('manage/footer');
		}else { 
			$data['g'] = $cek_posisi_banner;

			if($cek_posisi_banner['status_banner'] == 'on'){
					$data['status1'] = 'checked';
				}else{
					$data['status1'] = '';
				}
			$this->load->view('manage/header');
			$this->load->view('manage/promosi/banner/edit2', $data);
			$this->load->view('manage/footer');
		}
	}

	function hapus($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$this->media_promosi_adm->hapus($b);
		$this->session->set_flashdata('success', 'Banner dihapus.');
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Hapus ID Banner '.$b.'');
		redirect(base_url('trueaccon2194/media_promosi'));
	}

	function on($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$this->media_promosi_adm->on($b);
		$this->session->set_flashdata('success', 'Banner diaktifkan.');
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Mengaktifkan ID Banner '.$b.'');
		redirect(base_url('trueaccon2194/media_promosi'));
	}

	function off($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$this->media_promosi_adm->off($b);
		$this->session->set_flashdata('success', 'Banner dinonaktifkan.');
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Menonaktifkan ID Banner '.$b.'');
		redirect(base_url('trueaccon2194/media_promosi'));
	}

	function tambah_banner(){
		$this->load->view('manage/header');
		$this->load->view('manage/promosi/banner/add');
		$this->load->view('manage/footer');
	}

	function tambah_banner_video(){
		$this->load->view('manage/header');
		$this->load->view('manage/promosi/banner/add2');
		$this->load->view('manage/footer');
	}

	//function edit_banner2(){
		//resize and check Image
	//	$config['upload_path']          = 'qusour894/img/banner';
	//	$config['allowed_types']        = 'gif|jpg|png|jpeg';
	//	$config['max_size']             = 300;
	//	$config['overwrite']            = TRUE;

	//	$this->load->library('upload', $config);

	//	if ( ! $this->upload->do_upload('banner2')){
	//		$databanner['banner1'] = $this->media_promosi_adm->get_banner1();
	//		$databanner['banner2'] = $this->media_promosi_adm->get_banner2();
	//		$databanner['banner3'] = $this->media_promosi_adm->get_banner3();
	//		$error = array('error' => '', 'success' => '', 'error1' => $this->upload->display_errors(''), 'success1' => '', 'error2' => '', 'success2' => '');
	//		$data = array_merge($databanner, $error);

	//		log_helper('promosi', 'Gagal mengubah Banner 2');
	//		$this->load->view('manage/header');
	//		$this->load->view('manage/system/banner/index',$data);
	//		$this->load->view('manage/footer');
	//	}else{
	//		$this->upload->do_upload('banner2');
	//		$id = $this->input->post('id');
	//		$img_before = $this->input->post('image_before');
	//		unlink('qusour894/img/banner/'.$img_before);
	//		$image = $_FILES['banner2']['name'];
	//		$data = array(
	//			'banner' => $image,
	//			'posisi' => 'utama',
	//			'tgl' => date('Y:m:d H:i:s'),
	//			'user' => $this->data['id'],
	//		);
	//		$this->media_promosi_adm->update_banner2(array('id_banner' => $id),$data);
			
	//		log_helper('promosi', 'Mengubah Banner 2 ('.$image.')');
	//		$databanner['banner1'] = $this->media_promosi_adm->get_banner1();
	//		$databanner['banner2'] = $this->media_promosi_adm->get_banner2();
	//		$databanner['banner3'] = $this->media_promosi_adm->get_banner3();
	//		$success = array( 'error' => '', 'success' => '', 'error1' => '', 'success1' => 'banner diubah', 'error2' => '', 'success2' => '');
	//		$data = array_merge($databanner, $success);

	//		$this->load->view('manage/header');
	//		$this->load->view('manage/system/banner/index', $data);
	//		$this->load->view('manage/footer');
	//	}
	//}

	function banner_perform($id){
		$a = base64_decode($id);
		$idx = $this->encrypt->decode($a);
		$data['slide_preview'] = $this->media_promosi_adm->get_data_preview_slide($idx);
		$data['slide_periode'] = $this->media_promosi_adm->get_total_counter_slide_periode($idx);
		$data['total_counter_slide'] = $this->media_promosi_adm->get_total_counter_slide($idx);
		$data['total_counter_slide_per_day'] = $this->media_promosi_adm->get_counter_slide_perday($idx);
		$data['total_counter_slide_per_week'] = $this->media_promosi_adm->get_counter_slide_perweek($idx);
		$data['total_counter_slide_per_month'] = $this->media_promosi_adm->get_counter_slide_permonth($idx);

		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Preview ID Banner ('.$idx.')');
		$this->load->view('manage/header');
		$this->load->view('manage/promosi/banner/perform', $data);
		$this->load->view('manage/footer');
	}

	function ambil_data_slide($id){
		$get = $this->media_promosi_adm->get_data_slide($id);
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Preview ID Banner ('.$idx.')');
		echo json_encode($get);
	}

	function update_banner_selain_utama(){
		$idbn = $this->input->post('idbn');
		$a = base64_decode($idbn);
		$id = $this->encrypt->decode($a);
		$posisi = $this->input->post('posisi');
		$jenis = $this->input->post('jenis');
		$image = $this->input->post('banner');
		$url = $this->input->post('url');
		$perclick = $this->input->post('perclick');
		$ket = $this->input->post('ket');
		$tgl_awal = $this->input->post('tgl_mulai');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$status = $this->input->post('status');

		if($posisi == "utama_4" || $posisi == "utama_5"){
			$imagemobile = $this->input->post('bannermobile');
			$data = array(
				'banner'	=> $image,
				'perclick'	=> $perclick,
				'link' 		=> $url,
				'ket' 		=> $ket,
				'jenis'		=> $jenis,
				'posisi' 	=> $posisi,
				'for_banner3'=> $imagemobile,
				'status_banner' => $status,
				'tgl_mulai' => $tgl_awal,
				'tgl_akhir' => $tgl_akhir,
				'user' 		=> $this->data['id'],
			);
			//print_r($data);
			$this->media_promosi_adm->update_slider_lain($id,$data);
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Banner ('.$ket.')');
			$this->session->set_flashdata('success', 'Banner Diupdate.');
			redirect('trueaccon2194/media_promosi');
		}else{
			$data = array(
				'banner'	=> $image,
				'perclick'	=> $perclick,
				'link' 		=> $url,
				'ket' 		=> $ket,
				'jenis'		=> $jenis,
				'posisi' 	=> $posisi,
				'status_banner' => $status,
				'tgl_mulai' => $tgl_awal,
				'tgl_akhir' => $tgl_akhir,
				'user' 		=> $this->data['id'],
			);
			//print_r($data);
			$this->media_promosi_adm->update_slider_lain($id,$data);
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Banner ('.$ket.')');
			$this->session->set_flashdata('success', 'Banner Diupdate.');
			redirect('trueaccon2194/media_promosi');
		}
	}

	function update_banner_utama(){
		$idbn = $this->input->post('idbn');
		$a = base64_decode($idbn);
		$id = $this->encrypt->decode($a);
		$posisi = $this->input->post('posisi');
		$perclick = $this->input->post('perclick');
		$url = $this->input->post('url');
		$ket = $this->input->post('ket');
		$image = $this->input->post('banner');
		$tgl_awal = $this->input->post('tgl_mulai');
		$tgl_akhir = $this->input->post('tgl_akhir');


		$data = array(
			'banner'	=> $image,
			'perclick'	=> $perclick,
			'link' 		=> $url,
			'ket' 		=> $ket,
			//'jenis'		=> 'gambar',
			//'posisi' 	=> 'utama',
			//'status_banner' => 'on',
			'tgl_mulai' => $tgl_awal,
			'tgl_akhir' => $tgl_akhir,
			'user' 		=> $this->data['id'],

			//'banner' => $image,
			//'link' => $url,
			//'ket' => $ket,
			//'jenis' => 'gambar',
			//'posisi' => $posisi,
			//'status_banner' => 'Y',
			//'tgl' => date('d-m-Y H:i:s'),
			//'bulan' => date('M'),
			//'user' => $this->data['id'],
		);
		//print_r($data);
		$this->media_promosi_adm->update_slider($id,$data);
		log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Banner ('.$ket.')');
		$this->session->set_flashdata('success', 'Banner Diupdate.');
		redirect('trueaccon2194/media_promosi');
	}

	function add_banner(){

			$posisi = $this->input->post('posisi');
			$perclick = $this->input->post('perclick');
			$url = $this->input->post('url');
			$ket = $this->input->post('ket');
			$image = $this->input->post('banner');
			$tgl_awal = $this->input->post('tgl_mulai');
			$tgl_akhir = $this->input->post('tgl_akhir');

			$data = array(
				'banner'	=> $image,
				'perclick'	=> $perclick,
				'link' 		=> $url,
				'ket' 		=> $ket,
				'jenis'		=> 'gambar',
				'posisi' 	=> 'utama',
				'status_banner' => 'on',
				'tgl_mulai' => $tgl_awal,
				'tgl_akhir' => $tgl_akhir,
				'user' 		=> $this->data['id'],
			);
			$this->media_promosi_adm->insert_slider($data);
			log_helper('promosi', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Slide ('.$ket.')');
			$this->session->set_flashdata('success', 'Banner Disimpan.');
			redirect('trueaccon2194/media_promosi');
	}

}