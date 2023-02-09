<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blacklist extends CI_Controller { 

	function __construct(){
		parent:: __construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/blacklist_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){
         $this->blacklist_adm->update_baca();
        $data['list'] = $this->blacklist_adm->get_list_blacklist();
		$this->load->view('manage/header');
		$this->load->view('manage/blacklist/index',$data);	
		$this->load->view('manage/footer');
		log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Daftar Blacklist');
	}

    function readyes($id){
        $this->blacklist_adm->update_baca($id);
        redirect(base_url('trueaccon2194/blacklist'));
    }

	function importdata()
    {
        $tb=$this->input->post('tb1');
        $fl=$this->input->post('file');
        $br=$this->input->post('mulai');
        $config['upload_path'] = './';
        $config['allowed_types'] = 'xls|xlsx';
        //$config['max_size'] = 1024 * 8;
        $config['encrypt_name'] = TRUE;
 
        $this->load->library('upload', $config);
        
        
        if ($this->upload->do_upload('file'))        
        {
            $data = $this->upload->data();
            // truncate table master_barang
            $this->backup_and_restore_adm->truncate_data();
            $nama=$data['file_name'];
            if(file_exists("./".$nama))
            {
                $file="./".$nama;
                $this->tools->importdata($file,$tb,$br,TRUE);
                unlink($file);
                echo json_encode('Berhasil import data');                
            }else{
                echo json_encode('Gagal, karena kesalahan file atau file tidak ditemukan');
            }
        }else{
            echo json_encode('Gagal upload file');
        }
        
    }
    
    function exportdata()
    {
        $tb=$this->input->post('tb1');
        $title=$this->input->post('title');
        $desc=$this->input->post('description');
        
        $namafile="Export ".$tb."-".time();
        $folderpath="./";
        $this->tools->exportdata($tb,$title,$desc,$namafile,$folderpath);
        if(file_exists("./".$namafile.'.xls'))
        {
            echo json_encode('<a href="'.base_url().$namafile.'.xls" target="_blank"> Download File</a>');
        }else{
            echo json_encode('Gagal, karena kesalahan file atau file '.$namafile.'.xls tidak ditemukan');
        }
    }

}