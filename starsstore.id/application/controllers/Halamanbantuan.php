<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Halamanbantuan extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('Halaman_bantuan_m');
		$this->load->model(array('checkout_model','users'));
		$this->load->library('email');
		// cek cookie - GET
	    $cookie = get_cookie('Bismillahirrohmanirrohim');
	    if($cookie != ""){
	    	if($this->session->userdata('log_access') == ""){ //jika session login tidak ada maka dibuatkan login otomatis
	    		// cek cookie jika ada cookies dibrowser maka buatkan session user otomatis
		        $cek = $this->users->get_by_cookie($cookie);
		        foreach($cek->result() as $data){
		        	$email = $data->email;
		        	$sess_user['id']					= $data->id;
		        	$sess_data['mail_encrypt']  		= $data->email_encrypt;
		            $sess_user['last_login']            = $data->last_login;
		            $sess_user['log_access'] 			= "CUS_OKAY^*%$*($%@@)^783527_FIX_ACCESS";
					$sess_data['provider']				= $data->provider_login;
		            $this->session->set_userdata($sess_user);
		            $this->users->updateLastloginCustomer($data->id);
		            $this->users->saving_ipdevicebrowser($data->id, $email);
		        }
	    	}
	    }
	}

	function caribantu(){
		// tangkap variabel keyword dari URL
		$keyword = $this->uri->segment(2);

		// cari di database
		$data = $this->Halaman_bantuan_m->cariData($keyword);

		// format keluaran di dalam array
		if($data->num_rows() == 0){
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=> 'Tidak ada hasil',
				'judul'	=> 'Tidak ada hasil',
				'link'	=> base_url('bantuan/'),
			);
		}
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=> $row->judul,
				'judul'	=> $row->judul,
				'link'	=> base_url('bantuan/'.$row->slug.''),
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	function groupbantuan(){

		$data['title'] = "<title>Bantuan</title>";
		$data['meta_desc'] = "<meta name='description' content='Halaman Bantuan' />";
		$data['meta_key'] = "<meta name='keywords' content='bantuan, halaman bantuan, informasi pelanggan, pertanyaan, faq'/>";
		$this->load->view('theme/v1/headerHelp',$data);
		$this->load->view('theme/v1/bantuan_utama');
	}

	function asd(){
		$sql =  $this->Halaman_bantuan_m->get_all_bantuan();
        if($sql->num_rows() != 0){
        	$hasil = '';
        foreach($sql->result() as $row){
            $kat_id = $row->id_kategori_halaman;

            $sql2 = $this->Halaman_bantuan_m->get_all_bantuan2($kat_id);

 			$hasil .= "<div class='col-md-3 col-xs-12 dsg'><div class='hlp co_num1'>";
            $hasil .= "<h3 class='djnl'>".$row->kategori."</h3>";
                $hasil .= "<ul class='list-unstyled'>";
                    foreach($sql2->result_array() as $row2){
                        $hasil .= "<li class='ct-sub'>
                                <a href='".base_url('bantuan/')."".$row2->slug."'>".$row2->judul." <i class='glyphicon glyphicon-play plb pull-right'></i></a></li>";
                    }
                $hasil .= '</ul>';
        }
        $hasil .= '</div></div>';
        }
	}


	function halaman_bantuan($slug){
		// get_data_page
		$gdPage = $this->Halaman_bantuan_m->get_detail_page($slug);
		foreach($gdPage as $j){
			$jd 	  = $j->judul;
			$metaDesc = $j->meta_desc;
			$metaKey  = $j->meta_key;
		}
		$data['title'] = "<title>".$jd."</title>";
		$data['meta_desc'] = "<meta name='description' content='".$metaDesc."' />";
		$data['meta_key'] = "<meta name='keywords' content='".$metaKey."'/>";
		$data['info'] = $gdPage;
		$this->load->view('theme/v1/headerHelp',$data);
		$this->load->view('theme/v1/bantuan_page');
	}

	function kontak_kami(){
		$data['title'] = "<title>Kontak Kami</title>";
		$data['meta_desc'] = "<meta name='description' content='kontak kami' />";
		$data['meta_key'] = "<meta name='keywords' content='kontak kami, bantuan'/>";
		$data['kat_help'] = $this->Halaman_bantuan_m->get_isi_kategori_bantuan();
		$this->load->view('theme/v1/headerHelp',$data);
		$this->load->view('theme/v1/kontak_kami');
	}

	function submitPertanyaan(){
		$nama1 = $this->security->xss_clean($this->input->post('n'));
		$nama2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nama1);
		$nama3 = strip_tags($nama2);
		$nama = htmlentities($nama3);

		$email1 = $this->security->xss_clean($this->input->post('e'));
		$email2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$email1);
		$email3 = strip_tags($email2);
		$email = htmlentities($email3);

		$kt1 = $this->security->xss_clean($this->input->post('k'));
		$kt2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$kt1);
		$kt3 = strip_tags($kt2);
		$kt = htmlentities($kt3);

		$kll1 = $this->security->xss_clean($this->input->post('kll'));
		$kll2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$kll1);
		$kll3 = strip_tags($kll2);
		$kll = htmlentities($kll3);

		$ins = base64_decode($this->input->post('kni'));
		$b = $this->encrypt->decode($ins);

		if($b != "KntJs628%243@729&2!46"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses halaman kontak kami";
			$this->users->savingHack($aktifitas);
		}else{

			if($nama == ""){
				echo "Jsb385&2b$293-063";
			}else if($email == ""){
				echo "Jsb385&2b$293-063";
			}else if($kt == ""){
				echo "Jsb385&2b$293-063";
			}else if($kll == ""){
				echo "Jsb385&2b$293-063";
			}

			//generate invoice
			$length =5;
			$random= "";
			srand((double)microtime()*1000000);
 
			$data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
			$data .= "1234567890";
 
			for($i = 0; $i < $length; $i++){
				$random .= substr($data, (rand()%(strlen($data))), 1);
			}

			// Awalan kode kontak
			$utama = "KT";

    		// Hasil generate
    		$codeContact = $utama.$random;

    		// simpan ke database
    		// input to table kontak
			$data_kontak = array(
				'no_kontak'	=> $codeContact,
				'nama'		=> $nama,
				'email'		=> $email,
				'kategori_keluhan'	=> $kt,
				'pertanyaan' => $kll,
				'status'	=> "ditangguhkanmenunggu",
				'date_create' => date('Y-m-d H:i:s'),
				'ip'		=>	$this->input->ip_address(),
				'browser'	=> $this->agent->browser(),
				'os'		=> $this->agent->platform(),
				'baca'		=> 'belum',
				);
			$this->Halaman_bantuan_m->insToKontakData($data_kontak);

			// keluarkan data admin dan daftar email cc
			$dataadm = $this->checkout_model->keluarkan_dt_adm();
			foreach($dataadm->result() as $yp){
				if($yp->status == "e_support"){
					$supmail = $yp->em_acc;
				}
			}
			// config email
			$config = Array(
				'mailtype'  => 'html', 
			);

			$this->email->initialize($config);

			$data_cs = 'Tiket anda : '.$codeContact.'<br>Nama : '.$nama.'<br>Email : '.$email.'<br>Kategori Pertanyaan : '.$kt.'<br>Pertanyaan : '.$kll.'<br>Tanggal : '.date('d M Y H:i:s').'<br>Status : <i style="color:#e88404;">Menunggu</i><br><br>Terima kasih telah menghubungi kami. kami akan segera merespon pertanyaan anda dan akan membalasnya melalui email yang terkait.';

	      	$this->email->from('noreply@starsstore.id'); // change it to yours
	      	$this->email->to($email);// change it to yours
	      	$this->email->subject('Starsstore - Tiket Support Anda '.$codeContact.'');
	      	$this->email->message($data_cs);

			if($this->email->send()){
				//echo "KsgPsh5h28#2834*241";
				$this->replyTocontactsupport($codeContact, $email, $nama, $kt, $kll);
			}else{
				show_error($this->email->print_debugger());
			}
		}
	}

	function tg(){
		// keluarkan data admin dan daftar email cc
			$dataadm = $this->checkout_model->keluarkan_dt_adm();
			foreach($dataadm->result() as $yp){
				if($yp->status == "e_support"){
					$supmail = $yp->em_acc;
				}
				if($yp->status == "e_cc"){
					$ccmail = $yp->em_acc;
				}
			}
			$gab = "$supmail, $ccmail";
			echo $gab;
	}

	function replyTocontactsupport($codeContact, $email, $nama, $kt, $kll){
			// keluarkan data admin dan daftar email cc
			$dataadm = $this->checkout_model->keluarkan_dt_adm();
			foreach($dataadm->result() as $yp){
				if($yp->status == "e_admin"){
					$admmail = $yp->em_acc;
				}
				if($yp->status == "e_support"){
					$supmail = $yp->em_acc;
				}
				if($yp->status == "e_cc"){
					$ccmail = $yp->em_acc;
				}
			}
			$gab = "$admmail, $ccmail";
			$config = Array(
				'mailtype'  => 'html', 
			);
			$this->email->initialize($config);
			//$this->load->library('parser');
			//$body = $this->parser->parse('em_info_notification_group/f_cus_mail_order_for_adm_manage',$data,TRUE);
			
			$this->email->from('no-reply@starsallthebest.com','starsallthebest');
			$this->email->to($supmail);
			$this->email->cc($gab);
			//$this->email->bcc('them@their-example.com');
			$this->email->subject('Tiket Support Pelanggan '.$codeContact.'');
			$this->email->message('Sebuah tiket support dibuat atas nama pelanggan : '.$nama.'<br> Tiket : '.$codeContact.'<br>Email : '.$email.'<br>Kategori Pertanyaan : '.$kt.'<br>Pertanyaan : '.$kll.'<br>Tanggal : '.date('d M Y H:i:s').'<br>Status : <i style="color:#e88404;">Menunggu</i><br><br>Harap segera merespon dengan membalasnya melalui email yang terkait.');
			if($this->email->send()){
				echo "KsgPsh5h28#2834*241";
			}else{
				show_error($this->email->print_debugger());
			}
	}

	function successhub(){
		$data['title'] = "<title>Pertanyaan Sukses Terkirim</title>";
		$data['meta_desc'] = "<meta name='description' content='kontak kami' />";
		$data['meta_key'] = "<meta name='keywords' content='kontak kami, bantuan'/>";
		$this->load->view('theme/v1/headerHelp',$data);
		$this->load->view('theme/v1/berhasilKontak');
		
	}

}