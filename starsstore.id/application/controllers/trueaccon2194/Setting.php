<?php if( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Setting extends CI_Controller { 

	protected $key = 'MSY374BDND9NSFSV21N336DMVC06862N';
	protected $iv =  'MBX5294N4MXB27452NG102ND63BN5241';

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('sec47logaccess/setting_adm');
		$this->data['id'] = $this->session->userdata('id');
		$this->data['username'] = $this->session->userdata('username');
		if($this->session->userdata('log_access') != "TRUE_OK_1"){
			redirect(base_url());
		}
	}

	function index(){
		$data['f'] = $this->setting_adm->get_data_cabang_toko();
		$data['g'] = $this->setting_adm->get_daftar_rek();
		$data['t'] = $this->setting_adm->get_setting_page_default();
		$r = $this->setting_adm->get_setting();
		foreach($r as $k){
			if($k['nama'] == "logo"){
				$ilogo = $k['id'];
				$logo = $k['konten'];
			}else{
				
			}
			if($k['nama'] == "footer"){
				$ifooter = $k['id'];
				$footer = $k['konten'];
			}else{
				
			}
			if($k['nama'] == "nama_toko"){
				$itoko = $k['id'];
				$toko = $k['konten'];
			}else{
				
			}
			if($k['nama'] == "cara_belanja"){
				$icarbel = $k['id'];
				$carbel = $k['konten'];
			}else{
				
			}
			if($k['nama'] == "desc_toko"){
				$idesc_toko = $k['id'];
				$desc_toko = $k['konten'];
			}else{
				
			}
		}
		$t = $this->setting_adm->get_setting_email();
		foreach($t as $y){
			if($y['status'] == "e_admin"){
				$iadmin = $y['id_acc_em_user'];
				$admin = $y['em_acc'];
			}else{
				
			}
			if($y['status'] == "e_finance"){
				$ifinance = $y['id_acc_em_user'];
				$finance = $y['em_acc'];
			}else{
				
			}
			if($y['status'] == "e_support"){
				$isupport = $y['id_acc_em_user'];
				$support = $y['em_acc'];
			}else{
				
			}
			if($y['status'] == "e_sales"){
				$isales = $y['id_acc_em_user'];
				$sales = $y['em_acc'];
			}else{
				
			}
			if($y['status'] == "e_cc"){
				$icc = $y['id_acc_em_user'];
				$cc = $y['em_acc'];
			}else{
				
			}
			if($y['status'] == "e_bcc"){
				$ibcc = $y['id_acc_em_user'];
				$bcc = $y['em_acc'];
			}else{
				
			}
		}
		// setting
		$data['ilogo'] = $ilogo;
		$data['logo'] = $logo;
		$data['ifooter'] = $ifooter;
		$data['footer'] = $footer;
		$data['itoko'] = $itoko;
		$data['toko']	= $toko;
		$data['icarbel'] = $icarbel;
		$data['carbel']	= $carbel;
		$data['desc_toko']	= $desc_toko;
		$data['idesc_toko']	= $idesc_toko;
		//setting email
		$data['iadmin'] = $iadmin;
		$data['admin'] = $admin;
		$data['ifinance'] = $ifinance;
		$data['finance'] = $finance;
		$data['isupport'] = $isupport;
		$data['support'] = $support;
		$data['isales'] = $isales;
		$data['sales'] = $sales;
		$data['icc'] = $icc;
		$data['cc'] = $cc;
		$data['ibcc'] = $ibcc;
		$data['bcc'] = $bcc;

		log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Setting');
		$this->load->view('manage/header');
		$this->load->view('manage/system/setting/index', $data);
		$this->load->view('manage/footer');
	}

	function tambah_rekening(){
		$this->load->view('manage/header');
		$this->load->view('manage/system/setting/tambah_rekening');
		$this->load->view('manage/footer');
	}

	function tambah_other_store(){
		$this->load->view('manage/header');
		$this->load->view('manage/system/setting/tambah_other_store');
		$this->load->view('manage/footer');
	}

	function libur(){
		$id = $this->security->xss_clean($this->input->get('id'));

		$data = array(
			'aktif' => $id,
		);
		$this->setting_adm->liburkan($data);
	} 

	function company(){
		$id = $this->security->xss_clean($this->input->get('id'));

		$data = array(
			'aktif' => $id,
		);
		$this->setting_adm->company($data);
	} 

	function aktif_store_page(){
		$id = $this->security->xss_clean($this->input->get('id'));

		$data = array(
			'aktif' => $id,
		);
		$this->setting_adm->set_page_store($data);
	}

	function setNotif(){
		$id = $this->security->xss_clean($this->input->get('id'));

		$data = array(
			'aktif' => $id,
		);
		$this->setting_adm->setNot($data);
	}

	function searchadminbar(){
		$s1 = $this->security->xss_clean($this->input->get('s'));
		$s2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$s1);
		$s3 = strip_tags($s2);
		$search = htmlentities($s3);	

		$cariInv 		= $this->setting_adm->cariInv($search);
		$cariRetur		= $this->setting_adm->cariRetur($search);
		$cariKontak 	= $this->setting_adm->cariKontak($search);
		$cariProduk 	= $this->setting_adm->cariProduk($search);

		if(empty($cariInv) && empty($cariRetur) && empty($cariKontak) && empty($cariProduk)){
			echo "<em>Tidak ada data yang ditemukan ...</em>";
		}else{
			// CARI INVOICE
			if(!empty($cariInv)){
				echo('<div class="desc-fil"><center>---- Pencarian pada nomor transaksi ----</center>');
				echo '<ul class="list-unstyled rpor">';
				foreach($cariInv as $inv):

					$id = $this->encrypt->encode($inv->no_order_cus); 
					$idp = base64_encode($id);

					if($inv->status == "2hd8jPl613!2_^5"){
	                    $status = "<label style='margin-left:5px;font-size:9px;' class='label label-warning'>Menunggu Pembayaran</label>";
	                }else if($inv->status == "*^56t38H53gbb^%$0-_-"){
	                    $status = "<label style='margin-left:5px;font-size:9px;' class='label label-primary'>Pembayaran Diterima</label>";
	                }else if($inv->status == "Uywy%u3bShi)payDhal"){
	                    $status = "<label style='margin-left:5px;font-size:9px;' class='label label-primary'>Dalam Pengiriman</label>";
	                }else if($inv->status == "ScUuses8625(62427^#&9531(73"){
	                    $status = "<label style='margin-left:5px;font-size:9px;' class='label label-success'>Diterima</label>";
	                }else if($inv->status == "batal"){
	                    $status = "<label style='margin-left:5px;font-size:9px;' class='label label-danger'>Dibatalkan</label>"; 
	                }

	                if($inv->buy_in == "lazada"){
	                	$gbr = base_url('assets/images/marketplace/lazada_logo.png');
	                }else if($inv->buy_in == "tokopedia"){
	                	$gbr = base_url('assets/images/marketplace/tokopedia_logo.png');
	                }else if($inv->buy_in == "shopee"){
	                	$gbr = base_url('assets/images/marketplace/shopee_logo.png');
	                }else if($inv->buy_in == "bukalapak"){
	                	$gbr = base_url('assets/images/marketplace/bukalapak_logo.png');
	                }else if($inv->buy_in == "blibli"){
	                	$gbr = base_url('assets/images/marketplace/blibli.png');
	                }else if($inv->buy_in == "blanja"){
	                	$gbr = base_url('assets/images/marketplace/blanja.png');
	                }else if($inv->buy_in == "jd_id"){
	                	$gbr = base_url('assets/images/marketplace/jd_id.png');
	                }else if($inv->buy_in == "zalora"){
	                	$gbr = base_url('assets/images/marketplace/zalora.png');
	                }else if($inv->buy_in == "E-commerce"){
	                	$gbr = base_url('assets/images/marketplace/stars.jpg');
	                }else{
	                	$gbr = base_url('assets/images/marketplace/stars.jpg');
	                }

			    	$opsi = "<a style='padding:5px;' class='pull-right btn btn-default' href='".base_url('trueaccon2194/order/detail/'.$idp.'')."'><i style='font-size:9px;' class='glyphicon glyphicon-print'></i></a> <a style='padding:5px;margin-right:10px;' href='".base_url('trueaccon2194/online_store/edit/'.$idp.'')."' class='pull-right btn btn-warning edit'><i style='font-size:8px;' class='glyphicon glyphicon-pencil'></i></a>";

					echo '<li style="height:50px;">';
                	echo '<img src="'.$gbr.'" class="lazy pull-left" height="50" /> 
							<h4 style="margin-bottom:0;font-weight:700;"><span style="padding-left:5px;">#'.$inv->invoice.'</span>
							</h4>';
					echo '<div style="margin-left:55px;font-size:12px;font-weight:600;margin-bottom:5px;">Rp '.number_format($inv->total_belanja,0,".",".").'</div>';
					echo $status.''.$opsi;
					echo '</li>';
				endforeach;
				echo '</ul>';
				echo '</div>';
			}
			// CARI RETUR
			if(!empty($cariRetur)){
				echo('<div class="desc-fil" style="margin-top:40px;"><center>---- Pencarian pada nomor retur ----</center>');
				echo '<ul class="list-unstyled rpor">';
				foreach($cariRetur as $r):

					$id = $this->encrypt->encode($r->id_retur_info); 
					$idp = base64_encode($id);

					if($r->status_retur == "JGErnoahs3721"){
                      $status = "<label style='margin-left:5px;font-size:9px;' class='label label-danger'>Tidak Aktif / Dibatalkan</label>";
                    }else if($r->status_retur == "Kgh3YTsuccess"){
                      $status = "<label style='margin-left:5px;font-size:9px;' class='label label-success'>Sukses</label>";
                    }else if($r->status_retur == "Ksgtvwt%t2ditangguhkan"){
                      $status = "<label style='margin-left:5px;font-size:9px;' class='label label-warning'>Sedang diproses</label>";
                    }
	                
	                $gbr = base_url('assets/images/marketplace/stars.jpg');

			    	$opsi = "<a style='padding:5px;' class='pull-right btn btn-default' href='".base_url('trueaccon2194/retur/cetak_laporan_retur/'.$idp.'')."'><i style='font-size:9px;' class='glyphicon glyphicon-print'></i></a> <a style='padding:5px;margin-right:10px;' href='".base_url('trueaccon2194/retur/edit_data/'.$idp.'')."' class='pull-right btn btn-warning edit'><i style='font-size:8px;' class='glyphicon glyphicon-pencil'></i></a>";

					echo '<li style="height:50px;">';
                	echo '<img src="'.$gbr.'" class="lazy pull-left" height="50" /> 
							<h4 style="margin-bottom:0;font-weight:700;"><span style="padding-left:5px;">#'.$r->id_retur_info.'</span>
							</h4>';
					echo '<div style="margin-left:55px;font-size:12px;font-weight:600;margin-bottom:5px;">#'.$r->invoice.'</div>';
					echo $status.''.$opsi;
					echo '</li>';
				endforeach;
				echo '</ul>';
				echo '</div>';
			}
			// CARI KONTAK
			if(!empty($cariKontak)){
				echo('<div class="desc-fil" style="margin-top:40px;"><center>---- Pencarian pada nomor bantuan ----</center>');
				echo '<ul class="list-unstyled rpor">';
				foreach($cariKontak as $x):

					$id = $this->encrypt->encode($x->id_kontak); 
					$idp = base64_encode($id);

					if($x->status == "ditangguhkanmenunggu"){
                      $status = "<label style='margin-left:5px;font-size:9px;' class='label label-warning'>Menungu Balasan</label>";
                    }else if($x->status == "dibalaskan"){
                      $status = "<label style='margin-left:5px;font-size:9px;' class='label label-danger'>Dijawab</label>";
                    }else{
                      $status = "<label style='margin-left:5px;font-size:9px;' class='label label-danger'>Dibatalkan</label>";
                    }
	                
	                $gbr = base_url('assets/images/marketplace/stars.jpg');

			    	$opsi = "<a style='padding:5px;' class='pull-right btn btn-default' href='".base_url('trueaccon2194/kontak/reply_and_read/'.$idp.'')."'><i style='font-size:9px;' class='glyphicon glyphicon-eye-open'></i></a>";

					echo '<li style="height:50px;">';
                	echo '<img src="'.$gbr.'" class="lazy pull-left" height="50" /> 
							<h4 style="margin-bottom:0;font-weight:700;"><span style="padding-left:5px;">#'.$x->no_kontak.'</span>
							</h4>';
					echo '<div style="margin-left:55px;font-size:10px;margin-bottom:5px;">'.date('d F Y H:i:s', strtotime($x->date_create)).'</div>';
					echo $status.''.$opsi;
					echo '</li>';
				endforeach;
				echo '</ul>';
				echo '</div>';
			}
			// CARI PRODUK
			if(!empty($cariProduk)){
				echo('<div class="desc-fil" style="margin-top:40px;"><center>---- Pencarian pada produk ----</center>');
				echo '<ul class="list-unstyled rpor">';
				foreach($cariProduk as $produk):

					$id = $this->encrypt->encode($produk->id_produk); 
	        		$idx = base64_encode($id);

					if($produk->status == "on"){
						$status = "<label style='margin-left:5px;font-size:9px;' class='label label-success'>Aktif</label>";
					}else{
						$status = "<label style='margin-left:5px;font-size:9px;' class='label label-danger'>Tidak Aktif</label>";
					}

					if($produk->harga_dicoret == 0 || empty($produk->harga_dicoret)){ 
			        	$price = "<label style='font-size:12px; font-weight:600;margin-left:5px;'>Rp. ".number_format($produk->harga_fix,0,".",".")."</label>";
			    	}else{
			        	$price = "<s style='color:#989898;font-size:12px;margin-left:5px;'>Rp. ".number_format($produk->harga_dicoret,0,".",".")."</s> <span style='font-size:12px;font-weight:600;'>Rp. ".number_format($produk->harga_fix,0,".",".")."</span> <label class='label-diskon' style='margin-left:5px;font-size:10px;'>".round(($produk->harga_dicoret - $produk->harga_fix) / $produk->harga_dicoret * 100)." %</label>";
			    	}
			    	$opsi = "<a style='padding:5px;' target='_new' class='pull-right btn btn-default' href='".base_url('produk/'.$produk->slug.'')."'><i style='font-size:9px;' class='glyphicon glyphicon-eye-open'></i></a> <a style='padding:5px;margin-right:10px;' href='".base_url('trueaccon2194/produk/edit_data/'.$idx.'')."' class='pull-right btn btn-warning edit'><i style='font-size:8px;' class='glyphicon glyphicon-pencil'></i></a>";
					echo '<li style="height:50px;">';
                	echo '<img src="'.$produk->gambar.'" data-original="'.$produk->gambar.'" class="lazy pull-left" height="50" /> 
							<h5 style="margin-bottom:0;font-weight:700;"><span style="padding-left:5px;">'.$nama = word_limiter($produk->nama_produk,3).'</span>
							</h5>';
					echo $price.'<br>';
					echo $status.''.$opsi;
					echo '</li>';
				endforeach;
				echo '</ul>';
				echo '</div>';
			}
		}
	} 

	function simpannoteadmin(){
		$note = $this->input->post('note');
		$datanote = array(
			'konten'		=> $note,
			'diubah_oleh'	=> $this->data['id'],
			'diubah_tgl'	=> date("Y-m-d H:i:s"),
		);

		//print_r($datanote);
		$this->setting_adm->simpan_note($datanote);
	}

	function add_toko(){
		$ak1 = $this->security->xss_clean($this->input->post('akun'));
		$ak2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$ak1);
		$ak3 = strip_tags($ak2);
		$ak = htmlentities($ak3);	

		$lk1 = $this->security->xss_clean($this->input->post('link'));
		$lk2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$lk1);
		$lk3 = strip_tags($lk2);
		$lk = htmlentities($lk3);	

		$kt1 = $this->security->xss_clean($this->input->post('keterangan'));
		$kt2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$kt1);
		$kt3 = strip_tags($kt2);
		$kt = htmlentities($kt3);	

		$gb1 = $this->security->xss_clean($this->input->post('gambar'));
		$gb2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$gb1);
		$gb3 = strip_tags($gb2);
		$gb = htmlentities($gb3);	

		$st1 = $this->security->xss_clean($this->input->post('status'));
		$st2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$st1);
		$st3 = strip_tags($st2);
		$st = htmlentities($st3);	

		$data = array(
			'nama' 	=> $ak,
			'link'	=> $lk,
			'keterangan'	=> $kt,
			'gambar'		=> $gb,
			'status'			=> $st,
			'user'		=> $this->data['id'],
			'tanggal'	=> date('Y-m-d H:i:s'),
			);
		$this->setting_adm->add_other_store($data);
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Toko '.$ak.' ditambah!');
		log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Toko Lain ('.$nb.')');
		redirect(base_url('trueaccon2194/setting'));
	}

	function edit_other_store($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$data['g'] = $this->setting_adm->get_other_store($b);
		$this->load->view('manage/header');
		$this->load->view('manage/system/setting/edit_other_store', $data);
		$this->load->view('manage/footer');
	}

	function update_toko(){
		$id = base64_decode($this->input->post('kry'));
		$idx = $this->encrypt->decode($id);

		$ak1 = $this->security->xss_clean($this->input->post('akun'));
		$ak2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$ak1);
		$ak3 = strip_tags($ak2);
		$ak = htmlentities($ak3);		

		$lk1 = $this->security->xss_clean($this->input->post('link'));
		$lk2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$lk1);
		$lk3 = strip_tags($lk2);
		$lk = htmlentities($lk3);	

		$kt1 = $this->security->xss_clean($this->input->post('keterangan'));
		$kt2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$kt1);
		$kt3 = strip_tags($kt2);
		$kt = htmlentities($kt3);	

		$gb1 = $this->security->xss_clean($this->input->post('gambar'));
		$gb2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$gb1);
		$gb3 = strip_tags($gb2);
		$gb = htmlentities($gb3);	

		$st1 = $this->security->xss_clean($this->input->post('status'));
		$st2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$st1);
		$st3 = strip_tags($st2);
		$st = htmlentities($st3);

		$data = array(
			'nama' 	=> $ak,
			'link'	=> $lk,
			'keterangan'	=> $kt,
			'gambar'		=> $gb,
			'status'			=> $st,
			'user'		=> $this->data['id'],
			'tanggal'	=> date('Y-m-d H:i:s'),
			);
		$this->setting_adm->update_toko($idx, $data);
		$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Toko '.$nb.' diupdate!');
		log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Toko Lain'.$nb.'');
		redirect(base_url('trueaccon2194/setting'));
	}

	function add_rekening(){
		$a = base64_decode($this->input->post('kry'));
		$b = $this->encrypt->decode($a);

		$nb1 = $this->security->xss_clean($this->input->post('bank_name'));
		$nb2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nb1);
		$nb3 = strip_tags($nb2);
		$nb = htmlentities($nb3);	

		$cn1 = $this->security->xss_clean($this->input->post('code_network'));
		$cn2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$cn1);
		$cn3 = strip_tags($cn2);
		$cn = htmlentities($cn3);	

		$cb1 = $this->security->xss_clean($this->input->post('cabang'));
		$cb2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$cb1);
		$cb3 = strip_tags($cb2);
		$cb = htmlentities($cb3);	

		$nr1 = $this->security->xss_clean($this->input->post('no_rek'));
		$nr2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nr1);
		$nr3 = strip_tags($nr2);
		$nr = htmlentities($nr3);	

		$an1 = $this->security->xss_clean($this->input->post('a_n'));
		$an2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$an1);
		$an3 = strip_tags($an2);
		$an = htmlentities($an3);	

		if($b != "N7r2bskHr28"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses menambah rekening dihalaman admin";
			$this->setting_adm->savingHack($aktifitas);
			//redirect(base_url()); 
		}else{

			$data = array(
				'name_bank' 	=> $nb,
				'code_network'	=> $cn,
				'bank_cabang'	=> $cb,
				'no_rek'		=> $nr,
				'a_n'			=> $an,
				'aktife_stat_bank'	=> 'on',
				'created'		=> $this->data['id'],
				'created_date'	=> date('Y-m-d H:i:s'),
				);
			$this->setting_adm->add_rek($data);
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Bank '.$nb.' ditambah!');
			log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Menambah Bank '.$nb.'');
			redirect(base_url('trueaccon2194/setting'));
		}
	}

	function edit($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$data['g'] = $this->setting_adm->get_rek($b);
		$this->load->view('manage/header');
		$this->load->view('manage/system/setting/edit_rek', $data);
		$this->load->view('manage/footer');
	}

	function update_rekening(){
		$a = base64_decode($this->input->post('kry'));
		$b = $this->encrypt->decode($a);

		$id1 = $this->security->xss_clean($this->input->post('ibn'));
		$id2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$id1);
		$id3 = strip_tags($id2);
		$id = htmlentities($id3);

		$a1 = base64_decode($id);
		$idx = $this->encrypt->decode($a1);

		$nb1 = $this->security->xss_clean($this->input->post('bank_name'));
		$nb2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nb1);
		$nb3 = strip_tags($nb2);
		$nb = htmlentities($nb3);	

		$cn1 = $this->security->xss_clean($this->input->post('code_network'));
		$cn2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$cn1);
		$cn3 = strip_tags($cn2);
		$cn = htmlentities($cn3);	

		$cb1 = $this->security->xss_clean($this->input->post('cabang'));
		$cb2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$cb1);
		$cb3 = strip_tags($cb2);
		$cb = htmlentities($cb3);	

		$nr1 = $this->security->xss_clean($this->input->post('no_rek'));
		$nr2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nr1);
		$nr3 = strip_tags($nr2);
		$nr = htmlentities($nr3);	

		$an1 = $this->security->xss_clean($this->input->post('a_n'));
		$an2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$an1);
		$an3 = strip_tags($an2);
		$an = htmlentities($an3);	

		if($b != "N7r2bskHr28"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses mengupdate rekening dihalaman admin";
			$this->setting_adm->savingHack($aktifitas);
			//redirect(base_url()); 
		}else{

			$data = array(
				'name_bank' 	=> $nb,
				'code_network'	=> $cn,
				'bank_cabang'	=> $cb,
				'no_rek'		=> $nr,
				'a_n'			=> $an,
				);
			$this->setting_adm->edit_rek($idx, $data);
			$this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Bank '.$nb.' diupdate!');
			log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Bank '.$nb.'');
			redirect(base_url('trueaccon2194/setting'));
		}
	}

	function hapus($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$cek = $this->setting_adm->get_data_rek($b);
		foreach($cek as $r){
			$id = $r->id;
			$nama = $r->name_bank;
		}
		$this->setting_adm->hapus($b);
		$this->session->set_flashdata('success', 'Bank '.$nama.' dihapus.');
		log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Bank '.$nama.' ('.$b.')');
		redirect('trueaccon2194/setting');
	}

	function update_email(){
		$a = base64_decode($this->input->post('jwh'));
		$b = $this->encrypt->decode($a);

		$a1 = base64_decode($this->input->post('iadmin'));
		$ad22 = $this->encrypt->decode($a1);

		$ad1f = $this->security->xss_clean($this->input->post('admin'));
		$ad2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$ad1f);
		$ad3f = strip_tags($ad2f);
		$ad = htmlentities($ad3f);	

		$ad1 = $this->security->xss_clean($this->input->post('adminx'));
		$ad2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$ad1);
		$ad3 = strip_tags($ad2);
		$ad11 = htmlentities($ad3);

		$a2 = base64_decode($this->input->post('ifinance'));
		$fn22 = $this->encrypt->decode($a2);

		$fn1f = $this->security->xss_clean($this->input->post('finance'));
		$fn2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$fn1f);
		$fn3f = strip_tags($fn2f);
		$fn = htmlentities($fn3f);	

		$fn1 = $this->security->xss_clean($this->input->post('financex'));
		$fn2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$fn1);
		$fn3 = strip_tags($fn2);
		$fn11 = htmlentities($fn3);	

		$a3 = base64_decode($this->input->post('isupport'));
		$sp22 = $this->encrypt->decode($a3);

		$sp1f = $this->security->xss_clean($this->input->post('support'));
		$sp2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$sp1f);
		$sp3f = strip_tags($sp2f);
		$sp = htmlentities($sp3f);	

		$sp1 = $this->security->xss_clean($this->input->post('supportx'));
		$sp2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$sp1);
		$sp3 = strip_tags($sp2);
		$sp11 = htmlentities($sp3);

		$a4 = base64_decode($this->input->post('isales'));
		$sl22 = $this->encrypt->decode($a4);

		$sl1f = $this->security->xss_clean($this->input->post('sales'));
		$sl2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$sl1f);
		$sl3f = strip_tags($sl2f);
		$sl = htmlentities($sl3f);

		$sl1 = $this->security->xss_clean($this->input->post('salesx'));
		$sl2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$sl1);
		$sl3 = strip_tags($sl2);
		$sl11 = htmlentities($sl3);	

		$a5 = base64_decode($this->input->post('icc'));
		$cc22 = $this->encrypt->decode($a5);

		$cc1f = $this->security->xss_clean($this->input->post('cc'));
		$cc2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$cc1f);
		$cc3f = strip_tags($cc2f);
		$cc = htmlentities($cc3f);

		$cc1 = $this->security->xss_clean($this->input->post('ccx'));
		$cc2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$cc1);
		$cc3 = strip_tags($cc2);
		$cc11 = htmlentities($cc3);

		$a6 = base64_decode($this->input->post('ibcc'));
		$bcc22 = $this->encrypt->decode($a6);

		$bcc1f = $this->security->xss_clean($this->input->post('bcc'));
		$bcc2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$bcc1f);
		$bcc3f = strip_tags($bcc2f);
		$bcc = htmlentities($bcc3f);

		$bcc1 = $this->security->xss_clean($this->input->post('bccx'));
		$bcc2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$bcc1);
		$bcc3 = strip_tags($bcc2);
		$bcc11 = htmlentities($bcc3);

		if($b != "78354g3h4"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses mengupdate email dihalaman admin";
			$this->setting_adm->savingHack($aktifitas);
			//redirect(base_url()); 
		}else{

			if($ad != $ad11){
				$data_email = array(
					'em_acc' 	=> $ad,
					'change'	=> $this->data['id'],
					'date_change'	=> date('Y-m-d H:i:s'),
				);
				$this->setting_adm->update_admin($ad22, $data_email);
			}else{

			}
			if($fn != $fn11){
				$data_email = array(
					'em_acc' 	=> $fn,
					'change'	=> $this->data['id'],
					'date_change'	=> date('Y-m-d H:i:s'),
				);
				$this->setting_adm->update_finance($fn22, $data_email);
			}else{

			}
			if($sp != $sp11){
				$data_email = array(
					'em_acc' 	=> $sp,
					'change'	=> $this->data['id'],
					'date_change'	=> date('Y-m-d H:i:s'),
				);
				$this->setting_adm->update_support($sp22, $data_email);
			}else{

			}
			if($sl != $sl11){
				$data_email = array(
					'em_acc' 	=> $sl,
					'change'	=> $this->data['id'],
					'date_change'	=> date('Y-m-d H:i:s'),
				);
				$this->setting_adm->update_sales($sl22, $data_email);
			}else{

			}
			if($cc != $cc11){
				$data_email = array(
					'em_acc' 	=> $cc,
					'change'	=> $this->data['id'],
					'date_change'	=> date('Y-m-d H:i:s'),
				);
				$this->setting_adm->update_cc($cc22, $data_email);
			}else{

			}
			if($bcc != $bcc11){
				$data_email = array(
					'em_acc' 	=> $bcc,
					'change'	=> $this->data['id'],
					'date_change'	=> date('Y-m-d H:i:s'),
				);
				$this->setting_adm->update_bcc($bcc22, $data_email);
			}else{

			}
			
			$this->session->set_flashdata('success', 'Setting Email diupdate');
			log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Setting Email');
			redirect('trueaccon2194/setting');
		}

	}

	function update_setting(){
		$a = base64_decode($this->input->post('jwhkkk'));
		$b = $this->encrypt->decode($a);

		$ilogo1 = base64_decode($this->input->post('ilogo'));
		$ilogo = $this->encrypt->decode($ilogo1);

		$logo = $_FILES['logo']['name'];

		$logox1f = $this->security->xss_clean($this->input->post('logox'));
		$logox2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$logox1f);
		$logox3f = strip_tags($logox2f);
		$logox = htmlentities($logox3f);

		$a2 = base64_decode($this->input->post('ifooter'));
		$fo22 = $this->encrypt->decode($a2);

		$fo1f = $this->security->xss_clean($this->input->post('footer'));
		$fo2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$fo1f);
		$fo3f = strip_tags($fo2f);
		$fo = htmlentities($fo3f);	

		$fo1 = $this->security->xss_clean($this->input->post('footerx'));
		$fo2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$fo1);
		$fo3 = strip_tags($fo2);
		$fo11 = htmlentities($fo3);	

		$toko3 = base64_decode($this->input->post('itoko'));
		$toko22 = $this->encrypt->decode($toko3);

		$toko1f = $this->security->xss_clean($this->input->post('toko'));
		$toko2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$toko1f);
		$toko3f = strip_tags($toko2f);
		$toko = htmlentities($toko3f);	

		$toko1 = $this->security->xss_clean($this->input->post('tokox'));
		$toko2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$toko1);
		$toko3 = strip_tags($toko2);
		$toko11 = htmlentities($toko3);	

		$icarbel1 = base64_decode($this->input->post('icarbel'));
		$icarbel = $this->encrypt->decode($icarbel1);

		//$carbel = $_FILES['carbel']['name'];

		$carbelx1f = $this->security->xss_clean($this->input->post('carbelx'));
		$carbelx2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$carbelx1f);
		$carbelx3f = strip_tags($carbelx2f);
		$carbelx = htmlentities($carbelx3f);

		$desc1f = $this->security->xss_clean($this->input->post('desc_toko'));
		$desc2f = str_replace("/<\/?(p)[^>]*><script></script>", "",$desc1f);
		$desc3f = strip_tags($desc2f);
		$desc = htmlentities($desc3f);	

		$desc1xf = $this->security->xss_clean($this->input->post('desc_tokox'));
		$desc2xf = str_replace("/<\/?(p)[^>]*><script></script>", "",$desc1xf);
		$desc3xf = strip_tags($desc2xf);
		$descx = htmlentities($desc3xf);	

		$iddesc1 = base64_decode($this->input->post('idesc_toko'));
		$iddesc = $this->encrypt->decode($iddesc1);

		$config['upload_path']          = 'assets/images';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		//$config['max_size']             = 300;
		$config['overwrite']            = TRUE;

		$this->upload->initialize($config);

		if($b != "Hg9167!09^"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses mengupdate setting website dihalaman admin";
			$this->setting_adm->savingHack($aktifitas);
			//redirect(base_url()); 
		}else{

			if($logo != ""){
				// unlink logo sebelumnya
				$nm = FCPATH.'assets/images/'.$logox;
				unlink($nm);
				//upload logo
				$this->upload->do_upload('logo');
				$this->upload->data();

				$data_sett = array(
					'konten'		=> $logo,
					'diubah_oleh'	=> $this->data['id'],
					'diubah_tgl'	=> date('Y-m-d H:i:s'),
				);
				$this->setting_adm->update_logo_utama($ilogo, $data_sett);
				
			}else{

			}

			if($fo != $fo11){
				$data_sett = array(
					'konten'		=> $fo,
					'diubah_oleh'	=> $this->data['id'],
					'diubah_tgl'	=> date('Y-m-d H:i:s'),
				);
				$this->setting_adm->update_footer($fo22, $data_sett);
			}else{

			}
			if($toko != $toko11){
				$data_sett = array(
					'konten'		=> $toko,
					'diubah_oleh'	=> $this->data['id'],
					'diubah_tgl'	=> date('Y-m-d H:i:s'),
				);
				$this->setting_adm->update_footer($toko22, $data_sett);
			}else{

			}
			//if($carbel != ""){
				// unlink logo sebelumnya
			//	unlink('assets/images/'.$carbelx);
				//upload logo
			//	$this->upload->do_upload('carbel');
			//	$this->upload->data();

			//	$data_sett = array(
			//		'konten'		=> $carbel,
			//		'diubah_oleh'	=> $this->data['id'],
			//		'diubah_tgl'	=> date('Y-m-d H:i:s'),
			//	);
			//	$this->setting_adm->update_logo_carbel($icarbel, $data_sett);
			//}else{

			//}
			if($desc != $descx){
				$data_sett = array(
					'konten'		=> $desc,
					'diubah_oleh'	=> $this->data['id'],
					'diubah_tgl'	=> date('Y-m-d H:i:s'),
				);
				$this->setting_adm->update_desc($iddesc, $data_sett);
			}else{

			}
			$this->session->set_flashdata('success', 'Setting diupdate');
			log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Setting Website');
			redirect('trueaccon2194/setting');
		}

	}

	function simpan_halaman(){
		$a = base64_decode($this->input->post('kypost'));
		$b = $this->encrypt->decode($a);

		$a1 = base64_decode($this->input->post('ipost'));
		$b1 = $this->encrypt->decode($a1);

		$judul1 = $this->security->xss_clean($this->input->post('judul'));
		$judul2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$judul1);
		$judul3 = strip_tags($judul2);
		$judul = htmlentities($judul3);	

		$mk1 = $this->security->xss_clean($this->input->post('meta_key'));
		$mk2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$mk1);
		$mk3 = strip_tags($mk2);
		$mk = htmlentities($mk3);	

		$md1 = $this->security->xss_clean($this->input->post('meta_desc'));
		$md2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$md1);
		$md3 = strip_tags($md2);
		$md = htmlentities($md3);	

		$sl1 = $this->security->xss_clean($this->input->post('slug'));
		$sl2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$sl1);
		$sl3 = strip_tags($sl2);
		$sl = htmlentities($sl3);	

		$kt = $this->security->xss_clean($this->input->post('konten'));

		if($b != "Post_judul"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses mengupdate setting halaman ".$judul." dihalaman admin";
			$this->setting_adm->savingHack($aktifitas);
			//redirect(base_url()); 
		}else{

			$data_halaman = array(
				'slug'		=> $sl,
				'meta_desc'	=> $md,
				'meta_key'	=> $mk,
				'judul'		=> $judul,
				'konten'	=> $kt,
				'date_edit'	=> date('Y-m-d H:i:s'),
				'id_edit'	=> $this->data['id'],
			);
			//print_r($data_halaman);
			$this->setting_adm->update_halaman($b1, $data_halaman);
		}
		$this->session->set_flashdata('success', 'Halaman diupdate');
		log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Halaman '.$judul.' dihalaman admin');
		redirect('trueaccon2194/setting');
	}

	function tambah_halaman(){
		//$a = base64_decode($id);
		//$b = $this->encrypt->decode($a);
		$data['kat'] = $this->setting_adm->get_kategori_halaman();
		$this->load->view('manage/header');
		$this->load->view('manage/system/setting/add_halaman', $data);
		$this->load->view('manage/footer');
	}

	function add_halaman(){
		$a = base64_decode($this->input->post('kypost'));
		$b = $this->encrypt->decode($a);

		$ktg1 = $this->security->xss_clean($this->input->post('kat'));
		$ktg2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$ktg1);
		$ktg3 = strip_tags($ktg2);
		$ktg = htmlentities($ktg3);	

		$judul1 = $this->security->xss_clean($this->input->post('judul'));
		$judul2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$judul1);
		$judul3 = strip_tags($judul2);
		$judul = htmlentities($judul3);	

		$mk1 = $this->security->xss_clean($this->input->post('meta_key'));
		$mk2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$mk1);
		$mk3 = strip_tags($mk2);
		$mk = htmlentities($mk3);	

		$md1 = $this->security->xss_clean($this->input->post('meta_desc'));
		$md2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$md1);
		$md3 = strip_tags($md2);
		$md = htmlentities($md3);	

		$sl1 = $this->security->xss_clean($this->input->post('slug'));
		$sl2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$sl1);
		$sl3 = strip_tags($sl2);
		$sl = htmlentities($sl3);	

		$kt = $this->input->post('konten');

		if($b != "Post_judul"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses menambah halaman ".$judul.", dihalaman admin";
			$this->setting_adm->savingHack($aktifitas);
			//redirect(base_url()); 
		}else{

			$data_halaman = array(
				'id_kategori'	=> $ktg,
				'slug'		=> $sl,
				'meta_desc'	=> $md,
				'meta_key'	=> $mk,
				'judul'		=> $judul,
				'konten'	=> $kt,
				'status'	=> 'on',
				'date_create'	=> date('Y-m-d H:i:s'),
				'id_create'	=> $this->data['id'],
			);
			//print_r($data_halaman);
			$this->setting_adm->tambah_halaman_baru($data_halaman);
		}
		$this->session->set_flashdata('success', 'Halaman ditambah');
		log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Halaman '.$judul.' dihalaman admin');
		redirect('trueaccon2194/setting');
	}

	function daftar_halaman(){
		$data['list'] = $this->setting_adm->get_halaman_added();
		$this->load->view('manage/header');
		$this->load->view('manage/system/setting/list', $data);
		$this->load->view('manage/footer');
	}

	function edit_halaman($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$data['kat'] = $this->setting_adm->get_kategori_halaman();
		$data['d'] = $this->setting_adm->get_data_halaman($b);
		$this->load->view('manage/header');
		$this->load->view('manage/system/setting/edit_halaman', $data);
		$this->load->view('manage/footer');
	}

	function update_halaman(){
		$a = base64_decode($this->input->post('kypost'));
		$b = $this->encrypt->decode($a);

		$a1 = base64_decode($this->input->post('ilamanpost'));
		$b1 = $this->encrypt->decode($a1);

		$ktg1 = $this->security->xss_clean($this->input->post('kat'));
		$ktg2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$ktg1);
		$ktg3 = strip_tags($ktg2);
		$ktg = htmlentities($ktg3);	

		$judul1 = $this->security->xss_clean($this->input->post('judul'));
		$judul2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$judul1);
		$judul3 = strip_tags($judul2);
		$judul = htmlentities($judul3);	

		$mk1 = $this->security->xss_clean($this->input->post('meta_key'));
		$mk2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$mk1);
		$mk3 = strip_tags($mk2);
		$mk = htmlentities($mk3);	

		$md1 = $this->security->xss_clean($this->input->post('meta_desc'));
		$md2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$md1);
		$md3 = strip_tags($md2);
		$md = htmlentities($md3);	

		$sl1 = $this->security->xss_clean($this->input->post('slug'));
		$sl2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$sl1);
		$sl3 = strip_tags($sl2);
		$sl = htmlentities($sl3);	

		$kt = $this->input->post('konten');

		if($b != "Post_judul"){
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi untuk akses mengupdate halaman ".$judul.", dihalaman admin";
			$this->setting_adm->savingHack($aktifitas);
			//redirect(base_url()); 
		}else{

			$data_halaman = array(
				'id_kategori'	=> $ktg,
				'slug'		=> $sl,
				'meta_desc'	=> $md,
				'meta_key'	=> $mk,
				'judul'		=> $judul,
				'konten'	=> $kt,
				//'status'	=> 'on',
				'date_edit'	=> date('Y-m-d H:i:s'),
				'id_edit'	=> $this->data['id'],
			);
			//print_r($data_halaman);
			$this->setting_adm->update_halaman_baru($b1, $data_halaman);
		}
		$this->session->set_flashdata('success', 'Halaman '.$judul.' diupdate');
		log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Halaman '.$judul.' dihalaman admin');
		redirect('trueaccon2194/setting/daftar_halaman');
	}

	function hapus_halaman($id){
		$a = base64_decode($id);
		$b = $this->encrypt->decode($a);
		$this->setting_adm->hapus_halaman_baru($b);
		$this->session->set_flashdata('success', 'Halaman dihapus');
		log_helper('sistem', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Halaman dihalaman admin');
		redirect('trueaccon2194/setting/daftar_halaman');
	}

	function user_profile(){
		$this->load->view('manage/header');
		$this->load->view('manage/system/setting/user');
		$this->load->view('manage/footer');
	}

	function update_user(){
		$a = base64_decode($this->security->xss_clean($this->input->post('is')));
		$idx = $this->encrypt->decode($a);

		$gb_filtering 	= $this->security->xss_clean($this->input->post('gb'));
		$gb = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$gb_filtering);

		$ava_filtering 	= $this->security->xss_clean($this->input->post('avatar'));
		$ava = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$ava_filtering);
		$ava1 = $_FILES['avatar']['name'];

		$nama_filtering 	= $this->security->xss_clean($this->input->post('nama'));
		$nama = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$nama_filtering);

		$email_filtering 	= $this->security->xss_clean($this->input->post('email'));
		$email = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$email_filtering);

		$user_filtering 	= $this->security->xss_clean($this->input->post('user'));
		$user = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$user_filtering);

		$pass1_filtering 	= $this->security->xss_clean($this->input->post('pass1'));
		$pass1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$pass1_filtering);

		$pass2_filtering 	= $this->security->xss_clean($this->input->post('pass2'));
		$pass2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$pass2_filtering);	


		$id_user = $this->data['id'];

		$config['upload_path']          = 'assets/images/user';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 300;
		$config['overwrite']            = TRUE;
		
		$this->upload->initialize($config);

		if($pass1 == "" && $pass2 == "" && $ava1 == ""){
			//echo "password kosong update ava tidak";
			$data = array(
				'username'		=> $user,
				'nama_depan' 	=> $nama,
				'email' 		=> $email,
				'modifikasi' 	=> date('Y-m-d H:i:s'),
				'user_modif' 	=> $id_user,
			);
			
			$this->setting_adm->update_user($idx, $data);
			log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate User ('.$nama.')');
			$this->session->set_flashdata('success', 'User '.$nama.' Diupdate.');
			//redirect('trueaccon2194/user_preference');
			$this-> logout_system_for_change_data($nama);

		}else if($pass1 != "" && $pass2 != "" && $ava1 != ""){
			//echo "update password dan ava";
			//panggil protected function
			$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
			$iv_size = mcrypt_enc_get_iv_size($cipher);
			// Encrypt
			if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
			{
				$encrypt_default_rand = mcrypt_generic($cipher, $pass2);
				mcrypt_generic_deinit($cipher);
			}

			// link avatar
			//$av = "".base_url('qusour894/img/user/')."".$ava1."";
			// hapus gambar sebelumnya
			unlink('assets/images/user/'.$gb);
			//upload gambar
			$this->upload->do_upload('avatar');
			$this->upload->data();

			$data = array(
				'username'		=> $user,
				'password'		=> bin2hex($encrypt_default_rand),
				'nama_depan' 	=> $nama,
				'email' 		=> $email,
				'gb_user'		=> $ava1,
				'modifikasi' 	=> date('Y-m-d H:i:s'),
				'user_modif' 	=> $id_user,
			);
			
			$this->setting_adm->update_user($idx, $data);
			log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate password dan avatar user ('.$nama.')');
			$this->session->set_flashdata('success', 'User '.$nama.' Diupdate.');
			//redirect('trueaccon2194/user_preference');
			$this-> logout_system_for_change_data($nama);
		}else if($ava1 != ""){
			//echo "update ava";
			// link avatar
			$av = "".base_url('assets/iamges/user/')."".$ava1."";
			// hapus gambar sebelumnya
			unlink('assets/images/user/'.$gb);
			//upload gambar
			$this->upload->do_upload('avatar');
			$this->upload->data();

			$data = array(
				'username'		=> $user,
				'nama_depan' 	=> $nama,
				'email' 		=> $email,
				'gb_user'		=> $ava1,
				'modifikasi' 	=> date('Y-m-d H:i:s'),
				'user_modif' 	=> $id_user,
			);
			
			$this->setting_adm->update_user($idx, $data);
			log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Avatar User ('.$nama.')');
			$this->session->set_flashdata('success', 'Avatar Diupdate.');
			//redirect('trueaccon2194/user_preference');
			$this-> logout_system_for_change_data($nama);
		}else if($pass1 != "" && $pass2 != ""){
			//echo "password diisi";
			//panggil protected function
			$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
			$iv_size = mcrypt_enc_get_iv_size($cipher);
			// Encrypt
			if (mcrypt_generic_init($cipher, $this->key, $this->iv) != -1)
			{
				$encrypt_default_rand = mcrypt_generic($cipher, $pass2);
				mcrypt_generic_deinit($cipher);
			}

			$data = array(
				'username'		=> $user,
				'password'		=> bin2hex($encrypt_default_rand),
				'nama_depan' 	=> $nama,
				'email' 		=> $email,
				'modifikasi' 	=> date('Y-m-d H:i:s'),
				'user_modif' 	=> $id_user,
			);
			
			$this->setting_adm->update_user($idx, $data);
			log_helper('user', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate password user ('.$nama.')');
			$this->session->set_flashdata('success', 'Password Diupdate.');
			$this-> logout_system_for_change_data($nama);
			//redirect('trueaccon2194/user_preference');
		}
	}

	function logout_system_for_change_data($nama){
	 	$this->session->sess_destroy();
	 	$this->session->set_flashdata('error', 'Untuk otorisasi, silahkan login kembali');
	 	log_helper("logout", " User ".$nama." Keluar dari halaman Administrator karena mengupdate data user");
	 	redirect(base_url('st67pri21'));
	}

	function simpan_dan_libur_on(){

		$kontent = $this->security->xss_clean($this->input->post('notifPrei'));

		$data = array(
			'aktif' 	=> "on",
			'konten'	=> $kontent,
		);
		$this->setting_adm->liburkan($data);
		redirect($this->agent->referrer());
	}

	function liburoff(){
		$data = array(
			'aktif' 	=> "",			
		);
		$this->setting_adm->liburkan($data);	
	}
}