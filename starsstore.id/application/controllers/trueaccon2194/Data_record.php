<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_record extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('sec47logaccess/data_record_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}
 
	function index(){

		$get_data = $this->data_record_adm->get_record();
		$this->data['get_all'] = $get_data;

		$this->load->view('manage/header');
		$this->load->view('manage/system/data_record/index', $this->data);
		$this->load->view('manage/footer');

	}

}