<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Off extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('home'); 
	}

	function index(){
		$get_data_set = toko_libur();
		if($get_data_set['aktif'] != "on" || $get_data_set['aktif'] == ""){
			redirect(base_url());
		}else{
			$this->load->view('theme/v1/offline');
		}
	}
}
