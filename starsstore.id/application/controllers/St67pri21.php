<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class St67pri21 extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		if($this->session->userdata('log_access') == "TRUE_OK_1"){
			redirect(base_url('trueaccon2194/info_type_user_log'));
		}
	}

	 function index(){
	 	if($this->session->userdata('lock_screen') == "accesslocktrue"){
			redirect(base_url('lock_screen_default'));
		}else{
			$this->load->view('manage/login');
		}
	 }	 
}
