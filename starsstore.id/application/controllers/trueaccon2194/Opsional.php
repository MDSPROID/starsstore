<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Opsional extends CI_Controller { 

	function __construct(){
		parent:: __construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/opsional_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){

		$get_warna = $this->opsional_adm->get_warnax();
		$this->data['get_opsi_warna'] = $get_warna;

		$get_size = $this->opsional_adm->get_sizex();
		$this->data['get_opsi_size'] = $get_size;

		$this->load->view('manage/header');
		$this->load->view('manage/opsional/index', $this->data);	
		$this->load->view('manage/footer');
		log_helper('opsi', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Opsional Produk');
	}

	function proses_tambah_opsi_warna(){
		if($this->input->post()){
					$data_filtering 	= $this->security->xss_clean($this->input->post());
        			$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
					$id_user = $this->data['id'];
					$this->opsional_adm->add_warna($data, $id_user);
					log_helper('warna', ''.$this->data['username'].' ('.$this->data['id'].') Menambah warna');
				}else{
					log_helper('warna', ''.$this->data['username'].' ('.$this->data['id'].') Gagal menambah warna');
				}
	}

	function proses_update_opsi_color(){
		$id_user = $this->data['id'];
		$id_filtering 	= $this->security->xss_clean($this->input->post('id_warna'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);
        $data_filtering 	= $this->security->xss_clean($this->input->post('get_warna'));
        $warna = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
		$data = array(
				'id_opsi_color' => $id,
				'opsi_color'    => $warna,
				'diubah'	   => $id_user,
				'diubah_tgl'   => date('Y-m-d H:i:s'),
			);
		$this->opsional_adm->update_warna(array('id_opsi_color' => $id), $data);
		log_helper('warna', ''.$this->data['username'].' ('.$this->data['id'].') Update warna '.$warna.'');
	}

	function warna_dihapuskan(){ // hapus kategori yang dipilih
		$name = $this->input->get('name');
		$id = $this->input->get('id');
		$this->opsional_adm->warna_telah_dihapus($id);
		log_helper('warna', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus warna '.$name.'');
	}

	function ambil_data_warna($id){
		$a = $this->encrypt->encode($id); 
		$b = base64_encode($a);
		$get = $this->opsional_adm->get_data_color($b);
		echo json_encode($get);
	}
//////////////////////// SIZE ///////////////////////////////////////////////////////////////////////////

	function proses_tambah_opsi_size(){
		if($this->input->post()){
        			$data_filtering 	= $this->security->xss_clean($this->input->post());
        			$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
					$id_user = $this->data['id'];
					$this->opsional_adm->add_ukuran($data, $id_user);
					log_helper('ukuran', ''.$this->data['username'].' ('.$this->data['id'].') Menambah ukuran');
				}else{
					log_helper('ukuran', ''.$this->data['username'].' ('.$this->data['id'].') Gagal menambah ukuran');
				}
	}

	function proses_update_opsi_size(){
		$id_filtering 	= $this->security->xss_clean($this->input->post('id_ukuran'));
        $id = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);
        $data_filtering 	= $this->security->xss_clean($this->input->post('get_ukuran'));
        $size = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
		$id_user = $this->data['id'];
		$data = array(
				'id_opsi_size' => $id,
				'opsi_size'    => $size,
				'diubah'	   => $id_user,
				'diubah_tgl'   => date('Y-m-d H:i:s'),
			);
		$this->opsional_adm->update_ukuran(array('id_opsi_size' => $this->input->post('id_ukuran')), $data);
		log_helper('ukuran', ''.$this->data['username'].' ('.$this->data['id'].') update ukuran '.$size.'');
		
	}

	function ukuran_dihapuskan(){ // hapus kategori yang dipilih
		$name = $this->input->get('name');
		$id = $this->input->get('id');
		$this->opsional_adm->ukuran_telah_dihapus($id);
		log_helper('warna', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus ukuran '.$name.'');
	}

	function ambil_data_ukuran($id){
		$a = $this->encrypt->encode($id); 
		$b = base64_encode($a);
		$get = $this->opsional_adm->get_data_size($b);
		echo json_encode($get);
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$this->merk_adm->remove_selected();
			log_helper("merk", "menghapus merk yang dipilih");
			redirect('admin/kategori');
		}

}