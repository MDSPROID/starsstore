<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bestseller extends CI_Controller { 

	function __construct(){
		parent:: __construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/bestseller_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){

		$get_bestseller = $this->bestseller_adm->get_bestsell();
		$this->data['get_best'] = $get_bestseller;

		$this->load->view('manage/header');
		$this->load->view('manage/sales/bestseller/index', $this->data);	
		$this->load->view('manage/footer');
		log_helper('bestseller', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Best Seller');
	}

	function proses_tambah_merk(){
		$target = $this->input->post('merk');
		if($this->input->post()){
					$data_filtering = $this->security->xss_clean($this->input->post());
        			$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
					$id_user = $this->data['id'];
					$this->merk_adm->add($data,$id_user);
					log_helper('bestseller', ''.$this->data['username'].' ('.$this->data['id'].') Tambah Merk ('.$target.')');
				}else{
					log_helper('bestseller', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Tambah Merk ('.$target.')');
				}
	}

	function edit_merk($id){ // edit dan simpan kategori yang diedit

		$update = $this->merk_adm->get_data_merk($id);


		if ($update['aktif'] == 'on'){
					$this->data['status1'] = 'checked';
				}else{
					$this->data['status1'] = '';
				}

		$this->data['updatedata'] = $update;

		$this->load->view('manage/header');
		$this->load->view('manage/merk/edit',$this->data);
		$this->load->view('manage/footer');
	}

	function update_merk(){
		$id = $this->input->post('id');
		$target = $this->input->post('merk');
		if($this->input->post()){
				$data_filtering = $this->security->xss_clean($this->input->post());
        		$data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
				$id_user = $this->data['id'];
				$this->merk_adm->update_merk($data,$id,$id_user);
				log_helper('bestseller', ''.$this->data['username'].' ('.$this->data['id'].') Update Merk ('.$target.')');
				redirect('trueaccon2194/merk');
		}
	}

	function merk_dihapuskan(){ // hapus kategori yang dipilih
		$id = $this->input->get('id');
		$target = $this->input->get('name');
		$this->merk_adm->merk_telah_dihapus($id);
		echo json_encode(array("status" => TRUE));
		log_helper('bestseller', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Merk ('.$target.')');
	}

	function delete_select() { // request hapus pada menu pilihan dropdown
			$this->merk_adm->remove_selected();
			log_helper('bestseller', ''.$this->data['username'].' ('.$this->data['id'].') Hapus Merk');
			redirect('trueaccon2194/merk');
		}

}