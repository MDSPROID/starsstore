<?php if( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Stok extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/stok_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		} 
	} 

	function index(){ 
		$this->data = array('error' => '', 'success' => '');
		$this->data['critical_graph'] = $this->stok_adm->get_stok_critical_graph();
		$this->data['critical'] = $this->stok_adm->get_stok_critical();
		$this->data['warning'] = $this->stok_adm->get_stok_warning();
		$this->data['good'] = $this->stok_adm->get_stok_good();	
		$this->data['critical_plus_warning'] = $this->stok_adm->get_stok_critical_and_warning();	
		$this->data['all'] = $this->stok_adm->get_stok_all();
		$this->data['harga'] = $this->stok_adm->get_data_harga_produk();

		$this->load->view('manage/header');
		$this->load->view('manage/stok/index', $this->data); 
		$this->load->view('manage/footer');

		log_helper('stok', 'Akses halaman stok');
	}

	function stok_taking(){
		$this->data['produk_taking'] = $this->stok_adm->get_data_stok_produk();
		$this->data['hasil_taking'] = $this->stok_adm->get_data_stok_produk_hasil_taking();
		$this->load->view('manage/header');
		$this->load->view('manage/stok/stok_taking', $this->data);
		$this->load->view('manage/footer');

		log_helper('stok', 'Akses halaman stok taking');
	}

	function insert_taking(){
		$this->stok_adm->insert_data_stok_taking();		
		log_helper('stok', ''.$this->data['username'].' ('.$this->data['id'].') Insert data stok taking');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Stok taking selesai!');
		redirect(base_url('trueaccon2194/stok/stok_taking'));
	}

	function result_taking($id){
		$this->data['data_taking'] = $this->stok_adm->get_data_result_taking($id);
		$this->load->view('manage/header');
		$this->load->view('manage/stok/result_taking', $this->data);
		$this->load->view('manage/footer');
		log_helper('stok', ''.$this->data['username'].' ('.$this->data['id'].') Melihat hasil stok taking tanggal '.$id.'');
	}

	function hapus_result_taking($id){
		$this->stok_adm->hapus_data_taking($id);
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Hasil stok taking tanggal '.$id.' telah dihapus!');
		redirect(base_url('trueaccon2194/stok/stok_taking'));
		log_helper('stok', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus hasil stok taking tanggal '.$id.'');
	}

	function updating_stok(){
		$this->stok_adm->update_stok();		
		log_helper('stok', ''.$this->data['username'].' ('.$this->data['id'].') Update Masal Produk');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Update Stok Berhasil!');
		redirect(base_url('trueaccon2194/stok'));
	}

	function updating_harga(){
		$this->stok_adm->update_harga();		
		log_helper('stok', ''.$this->data['username'].' ('.$this->data['id'].') Update Masal Harga Produk');
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Update Harga Berhasil!');
		redirect(base_url('trueaccon2194/stok'));
	}

}