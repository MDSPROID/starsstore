<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backup_and_restore extends CI_Controller { 

	function __construct(){
		parent:: __construct();
		$this->load->library('tools'); 
		$this->load->database();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/backup_and_restore_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){
		$this->load->view('manage/header');
		$this->load->view('manage/system/sistem/index');	
		$this->load->view('manage/footer');
		log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Backup dan Restore Data');
	}

    function uploadsqlMaster(){
        //resize and check Image
        $config['upload_path']          = 'assets/datacrush';
        $config['allowed_types']        = 'sql|x-sql';
        //$config['max_size']             = 300;
        $config['overwrite']            = TRUE;

        $this->upload->initialize($config);

        if(!$this->upload->do_upload('filesqlUpload')){
            $this->session->set_flashdata('error', ''.$this->upload->display_errors().'');
            redirect($this->agent->referrer());
        }else{
            //Kosongkan table brgcp
            $this->backup_and_restore_adm->truncate_brgcp();
            // panggil file di folder datacrush dengan extenstion .sql
            $this->upload->do_upload('filesqlUpload');

            $file    = $this->upload->data();  //DIUPLOAD DULU KE DIREKTORI 
            $fupload = $file['file_name'];
                        
            $isi_file = file_get_contents('./assets/datacrush/' . $fupload); //PANGGIL FILE YANG TERUPLOAD
            $string_query = rtrim( $isi_file, "\n;" );
            $array_query = explode(";", $string_query);   //JALANKAN QUERY MERESTORE KEDATABASE

            foreach($array_query as $query){
                if(!empty(trim($query))){
                    $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                    $this->db->query($query);
                    $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
                }
            }

            $path_to_file = './assets/datacrush/' . $fupload;
            
            unlink($path_to_file);   // HAPUS FILE YANG TERUPLOAD
            $this->session->set_flashdata('success', 'File '.$fupload.' sukses diupload');
            redirect($this->agent->referrer());
        }
    }

    function syncdata(){
        $master = $this->backup_and_restore_adm->master_barang_dan_brgcp();

        // sync harga retail 
        foreach($master as $t){
            if($t->retail != $t->retprc){
                $art67 = $t->artikel;
                $data = array(
                    'retail'  => $t->retprc,
                );
                $this->backup_and_restore_adm->update_data($art67,$data);
            } 
        }

        // sync data artikel yang belum ada di master_barang (karena table brgcp lebih lengkap artikel drpd master barang)
        //$datamaster = $this->backup_and_restore_adm->data_master();
        //$databrgcp  = $this->backup_and_restore_adm->data_brgcp();

        //foreach($datamaster as $m){
            
        //}
        $this->session->set_flashdata('success', 'Sync data sukses.');
        redirect($this->agent->referrer());
    }

	function importdata(){
        $tb = $this->security->xss_clean($this->input->post('tb1'));
        $fl = $this->security->xss_clean($this->input->post('file'));
        $br = $this->security->xss_clean($this->input->post('mulai'));
        $truncate = $this->security->xss_clean($this->input->post('trn'));

        $config['upload_path'] = './';
        $config['allowed_types'] = 'xls|xlsx'; 
        //$config['encrypt_name'] = TRUE;
 
        $this->load->library('upload', $config);
        
        
        if ($this->upload->do_upload('file'))        
        {

            //if($tb == "master_barang"){
                // truncate table master_barang
            //    $this->backup_and_restore_adm->truncate_data();
            //    $data = $this->upload->data();
            //    $nama=$data['file_name'];
            //    if(file_exists("./".$nama))
            //    {
            //        $file="./".$nama;
            //        $this->tools->importdata($file,$tb,$br,TRUE);
            //        unlink($file);
            //        echo json_encode('Berhasil import data');                
            //    }else{
             //       echo json_encode('Gagal, karena kesalahan file atau file tidak ditemukan');
            //   }

            //}else{
                if($truncate == "on"){
                    $this->backup_and_restore_adm->truncate_data_tb($tb);
                }

                $data = $this->upload->data();
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
            //}
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