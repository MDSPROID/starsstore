<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checking_available extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('home');
		$this->load->model('users');
		$get_data_set = toko_libur();
		if($get_data_set['aktif'] == "on"){
			redirect(base_url('toko-libur'));
		}
	}

	function cek_stok(){

		$id 		= strip_tags($this->security->xss_clean($this->input->post('get_m')));
		$ids		= base64_decode($id);
        $get_id 	= $this->encrypt->decode($ids);

        $genderx 	= strip_tags($this->security->xss_clean($this->input->post('gen')));
		$genderxx	= base64_decode($genderx);
        $get_idgender= $this->encrypt->decode($genderxx);

		$gambar 	= strip_tags($this->security->xss_clean($this->input->post('get_gm')));
		$gbs		= base64_decode($gambar);
        $get_gb 	= $this->encrypt->decode($gbs);

		$nama 		= strip_tags($this->security->xss_clean($this->input->post('get_pd_n')));
		$namas		= base64_decode($nama);
        $get_nama 	= $this->encrypt->decode($namas);

		$slug 		= strip_tags($this->security->xss_clean($this->input->post('gsg')));
		$slugs		= base64_decode($slug);
        $get_slug 	= $this->encrypt->decode($slugs);

		$artikel 	= strip_tags($this->security->xss_clean($this->input->post('atl')));
		$artikels	= base64_decode($artikel);
        $get_atl	= $this->encrypt->decode($artikels);

		$merk 		= strip_tags($this->security->xss_clean($this->input->post('get_mr')));
		$merks		= base64_decode($merk);
        $get_mr 	= $this->encrypt->decode($merks);

		$point 		= strip_tags($this->security->xss_clean($this->input->post('get_pt')));
		$points		= base64_decode($point);
        $get_pt 	= $this->encrypt->decode($points);

		$diskon		= strip_tags($this->security->xss_clean($this->input->post('get_dk')));
		$diskons	= base64_decode($diskon);
        $get_dk 	= $this->encrypt->decode($diskons);

		$berat		= strip_tags($this->security->xss_clean($this->input->post('get_bt')));
		$berats		= base64_decode($berat);
        $get_bt 	= $this->encrypt->decode($berats);

		$before		= strip_tags($this->security->xss_clean($this->input->post('get_be')));
		$befores	= base64_decode($before);
        $get_be 	= $this->encrypt->decode($befores);

		$after		= strip_tags($this->security->xss_clean($this->input->post('get_at')));
		$afters		= base64_decode($after);
        $get_at 	= $this->encrypt->decode($afters);

// EXPLODE SIZE DAN ID SIZE

		$size 		= strip_tags($this->security->xss_clean($this->input->post('sie')));

		if($size == "-" || $size == ""){
			$exidsize = 1;	
			$exsize = "-";
		}else{
			$exsize1 	= explode('|', $size);
			// id size
	        $exidsize1 	= $exsize1[0];
	        $exidsize2	= base64_decode($exidsize1);
	        $exidsize 	= $this->encrypt->decode($exidsize2);
	        // size
	        $exsize11   = $exsize1[1];
	        $exsize2 	= base64_decode($exsize11);
	        $exsize  	= $this->encrypt->decode($exsize2);
	    }

// EXPLODE WARNA DAN ID WARNA

		$color	= strip_tags($this->security->xss_clean($this->input->post('col')));

		if($color == "-" || $color == ""){
			$exidcolor = 1;
			$excolor = "-";
		}else{
	        $excolor1 	= explode('|', $color);
	        // id color
	        $exidcolor2 = $excolor1[0];
	        $exidcolor3	= base64_decode($exidcolor2);
	        $exidcolor 	= $this->encrypt->decode($exidcolor3);
	        // color
	        $excolor11   = $excolor1[1];
			$excolor2	= base64_decode($excolor11);
	        $excolor 	= $this->encrypt->decode($excolor2);        
	    }

		$request_order_qty 	=  strip_tags($this->security->xss_clean($this->input->post('qty')));

		//$berat = 0;
		//$berat += ($beratx * $request_order_qty);
		//$stok_product_in_bascket = $this->homex->cek_global_bascket($id);
		//foreach($stok_product_in_bascket as $stok_bascket){
		//	$data_produk2['stok2'] = $stok_bascket->jumlah;
		//}
		//$stok_bascket_in_product = $stok_bascket->jumlah;
		
		// CEK STOK ID PRODUK DIDATABASE
		$stok_product = $this->home->cek_global_stok($get_id,$exidsize,$exidcolor);
		foreach($stok_product as $stok_global){
			//$data_produk['stok1'] = $stok_global->stok;
			$stok_asli = $stok_global->stok;
		}
	    
		//$stok_gabungan = $stok_bascket_in_product + $jml;

		//$sumqty =0;
		//foreach ($this->cart->contents() as $items){
		//	$id 	= $items['id'];
		//	$jml 	= $items['qty'];

		//	$totalqty = array(
		//		'totalqtyincart' => $jml,
		//		);
		//	$sumqty += $total['totalqtyincart'];
		//}
		
		$no = 0;
 		if($size == ""){
 			echo 0;//"ghysqw";
 		}else if($request_order_qty < $stok_asli){
			//$data_produk_in_bascket = $this->homex->add_to_bascket($id,$nama,$artikel,$merk,$point,$diskon,$berat,$after,$before,$size,$color,$jml);

			// diskon
			if($get_be > 0 || $get_be != ""){
				$disc = round(($get_be - $get_at) / $get_be * 100); // hitung manual diskon
			}else{
				$disc = "";
			}
			
			//$nama_produk = str_replace("/", "", $get_nama); //str_replace(/^[a-zA-Z0-9_]+([-.][a-zA-Z0-9_]+)*$/,"",$get_nama);
			$this->session->set_flashdata('berhasil', 'Produk <b>'.$get_nama.'</b> Berhasil ditambahkan ke keranjang belanja anda!');
			
			$data = array(
			'no'			=> $no++,
    		'id' 			=> $get_id,
    		'image'			=> $get_gb,
    		'gender'		=> $get_idgender,
    		'name'			=> $get_nama,
    		'slug'			=> $get_slug,
    		'artikel'		=> $get_atl,
    		'merk'			=> $get_mr,
    		'point'			=> $get_pt,
    		'diskon'		=> $disc,
    		'berat'			=> $get_bt,
    		'price'			=> round($get_at),
    		'before'		=> round($get_be),
    		//'odv'			=> round($get_odv),
    		'optidcolor'	=> $exidcolor,
    		'optidsize'		=> $exidsize,
    		'options'		=> array('Size' => $exsize, 'Warna' => $excolor),
    		'qty'			=> $request_order_qty,
    		);
    		$this->cart->insert($data);	
    		//print_r($data);
			echo 1;
		}else{
			echo 2;
		}
	}

	function cek_stok_fast_checkout(){
		
		$id 		= strip_tags($this->security->xss_clean($this->input->post('get_m')));
		$ids		= base64_decode($id);
        $get_id 	= $this->encrypt->decode($ids);

// EXPLODE SIZE DAN ID SIZE

		$size 		= strip_tags($this->security->xss_clean($this->input->post('sie')));
		$exsize1 	= explode(',', $size);
		// id size
        $exidsize1 	= $exsize1[0];
        $exidsize2	= base64_decode($exidsize1);
        $exidsize 	= $this->encrypt->decode($exidsize2);
        // size
        $exsize11   = $exsize1[1];
        $exsize2 	= base64_decode($exsize11);
        $exsize  	= $this->encrypt->decode($exsize2);

// EXPLODE WARNA DAN ID WARNA

		$color	= strip_tags($this->security->xss_clean($this->input->post('col')));
        $excolor1 	= explode(',', $color);
        // id color
        $exidcolor2 = $excolor1[0];
        $exidcolor3	= base64_decode($exidcolor2);
        $exidcolor 	= $this->encrypt->decode($exidcolor3);
        // color
        $excolor11   = $excolor1[1];
		$excolor2	= base64_decode($excolor11);
        $excolor 	= $this->encrypt->decode($excolor2);        

		$request_order_qty 	=  strip_tags($this->security->xss_clean($this->input->post('qty')));

		// CEK STOK ID PRODUK DIDATABASE
		$stok_product = $this->home->cek_global_stok($get_id,$exidsize,$exidcolor);
		foreach($stok_product as $stok_global){
			//$data_produk['stok1'] = $stok_global->stok;
		}

		$stok_asli = $stok_global->stok;
 		if($request_order_qty < $stok_asli){
			echo"available_stok";
		}else{
			echo"stok0";
		}
	}

	function adding_rev($id){
		$no1 = base64_decode($id);
		$no = $this->encrypt->decode($no1);
		// cek apa order id ini sudah melakukan review, jika sudah, tolak untuk akses halaman ini
		$cek_review = $this->users->cek_review_order($no);
		foreach($cek_review->result() as $g){
			$sudah = $g->sudah_review;

			if($sudah == "sudah_kok"){
				redirect(base_url());
			}else{
			// jika belum melakukan review, arahkan ke halaman review produk masing2 kolom (banyak kolom tergantung jumlah produk yang diorder dalam satu invoice)
				$data['get_produk'] = $this->users->get_id_produk($no);
				$data['ur']	= $id;
				//print_r($id);
				$this->load->view('review_invoice', $data);
			}
			//if(empty($id)){
			//	redirect(base_url());
			//}else if(){

			//}
		}
	}

	function rev_pro(){

		$a = base64_decode($this->input->post('joss'));
		$b = $this->encrypt->decode($a);

		$no1 =base64_decode($this->input->post('ur'));
		$no = $this->encrypt->decode($no1);

		if($b != "ReVjd7(653*n3"){
			redirect($this->agent->referrer());
			//SAVING DATA HACKER
			$aktifitas = "memecahkan kode enkripsi memberikan review produk";
			$this->users->savingHack($aktifitas);
		}else{

			$this->form_validation->set_rules('comment[]', 'Komentar', 'required|xss_clean');
			$this->form_validation->set_rules('rt[]', 'Rating', 'required|xss_clean');
			if($this->form_validation->run() != FALSE ){
				$cm1 = $this->security->xss_clean($this->input->post('comment[]'));
				$cm = str_replace("/<\/?(p)[^>]*><script></script>", "",$cm1);

				$rt1 = $this->security->xss_clean($this->input->post('rt[]'));
				$rt = str_replace("/<\/?(p)[^>]*><script></script>", "",$rt1);

				$id1 = $this->security->xss_clean($this->input->post('rasuk[]'));
				$id = str_replace("/<\/?(p)[^>]*><script></script>", "",$id1);

				// rating untuk produk_review
				foreach($rt as $t){
					if($t == "1"){
						$rating1[] = "1stars.png";
					}else if($t == "2"){
						$rating1[] = "2stars.png";
					}else if($t == "3"){
						$rating1[] = "3stars.png";
					}else if($t == "4"){
						$rating1[] = "4stars.png";
					}else if($t == "5"){
						$rating1[] = "5stars.png";
					}
				}

				// keluarkan data customer yang terkait dengan invoice
				$data_cs = $this->users->get_cs($no);
				foreach($data_cs->result() as $p){
					$idcs = $p->id;
					$naleng = $p->nama_lengkap;
				}

/////////////// untuk produk_review
				$count = count($id);
				$data_rev = array();
				for($i=0;$i<$count;$i++){
					$data_rev[] = array(
						'id_produk'		=> $id[$i],
						'id_cs'			=> $idcs,
						'nama_review'	=> $naleng,
						'review'		=> $cm[$i],
						'rating'		=> $rating1[$i],
						'tgl_review'	=> date('Y-m-d H:i:s'),
						'status'		=> 'ditinjau',
					);
				}
				//print_r($data_rev);
				// insert review to produk_review
				$this->users->add_review($data_rev);

/////////////// untuk produk
				foreach($id as $idpr){
					$idk = $idpr;
					// ambil rating produk dari database
					$get_rating_buat_total = $this->users->get_rat_pro($idk);
					foreach($get_rating_buat_total as $g){
						$rating_produk_total[] = $g->rating_produk;
					}
					//print_r($rating_produk_total); // sudah benar. hasil 18 : 25	
				}
				
				// sederhanakan array rating option
				foreach($rt as $e){
					$rty[] = $e;
					$rtyy = $e;
				}

				// hitung kalkulasi totl rating nanti kasih IF condition
				$count = count($id);
				for($i=0;$i<$count;$i++){
					$totrat = $rating_produk_total[$i] + $rty[$i];
					// hasil jumlah total rating + rating yang dipost direview ini
					if($totrat <= 5){
						$finaltotal[] = 1;
					}else if($totrat <= 10){
						$finaltotal[] = 2;
					}else if($totrat <= 15){
						$finaltotal[] = 3;
					}else if($totrat <= 20){
						$finaltotal[] = 4;
					}else if($totrat <= 25 || $totrat > 25){
						$finaltotal[] = 5;
					}
					//print_r($finaltotal);
				}

				$count = count($id);
				//$data_rev = array();
				for($i=0;$i<$count;$i++){
					$data_rev1[] = array(
						'id_produk'		=> $id[$i],
						'rating_produk'	=> $rating_produk_total[$i] + $rty[$i], // $rating_produk_total + 
						'rating_produk_for_filter' => $finaltotal[$i],
					);
				}
				//print_r($data_rev1);
				// update ratting produk
				$this->users->update_produk_for_review($data_rev1);
/////////////////////////////////////////////////////////////////////
				// update table sudah_review order_customer
				$sudah = array(
					'sudah_review' => 'sudah_kok',
				);
				$this->users->update_stat_rev($no, $sudah);
				redirect('review-berhasil');
			}else{
				$this->session->set_flashdata('error','Isi form dengan lengkap.');
				redirect($this->agent->referrer());
			}

		}

	}

	function addreview_manual(){
		$a = base64_decode($this->input->post('revP'));
		$b = $this->encrypt->decode($a);

		$nm1 = $this->security->xss_clean($this->input->post('nm_rev'));
		$nm = str_replace("/<\/?(p)[^>]*><script></script>", "",$nm1);

		$rv1 = $this->security->xss_clean($this->input->post('rev'));
		$rv = str_replace("/<\/?(p)[^>]*><script></script>", "",$rv1);

		$st1 = $this->security->xss_clean($this->input->post('star'));
		$st = str_replace("/<\/?(p)[^>]*><script></script>", "",$st1); 

		$data_rev = array(
			'id_produk' 	=> $b,
			'nama_review'	=> $nm,
			'review'		=> $rv,
			'rating'		=> $st,
			'tgl_review'	=> date('Y-m-d H:i:s'),
			'status'		=> 'ditinjau',
		);

		$this->users->add_review_manual($data_rev);
		$this->session->set_flashdata('berhasil','Terima kasih telah mereview produk.');
		redirect($this->agent->referrer());
	}

	function addpertanyaanproduk(){
		$a = base64_decode($this->input->post('qnaP'));
		$b = $this->encrypt->decode($a);

		$nm1 = $this->security->xss_clean($this->input->post('nm_qna'));
		$nm = str_replace("/<\/?(p)[^>]*><script></script>", "",$nm1);

		$qna1 = $this->security->xss_clean($this->input->post('qna'));
		$qna = str_replace("/<\/?(p)[^>]*><script></script>", "",$qna1);

		$nmp1 = $this->security->xss_clean($this->input->post('nmp'));
		$nmp = str_replace("/<\/?(p)[^>]*><script></script>", "",$nmp1);

		$data_qna = array(
			'id_produk' 	=> $b,
			'nama'			=> $nm,
			'pertanyaan'	=> $qna,
			'tgl_q_n_a'		=> date('Y-m-d H:i:s'),
		);

		$this->users->add_qna($data_qna);

		$this->load->model('checkout_model');
		// keluarkan data admin dan daftar email cc
		$dataadm = $this->checkout_model->keluarkan_dt_adm();
		foreach($dataadm->result() as $yp){
			if($yp->status == "e_sales"){
				$salesmail = $yp->em_acc;
			}
		}
		$config = Array(
			'mailtype'  => 'html', 
		);

		$this->email->initialize($config);		
		$this->email->from('noreply@starsstore.id','Stars Official Store (E-commerce)');
		$this->email->to($salesmail);
		$this->email->subject('Diskusi produk terbaru '.$nmp.'');
		$body = "Halo Stars Official Store.<br>Customer <b>".$nm."</b> menanyakan produk ".$nmp.".<br><br><i>' ".$qna." </i>'<br><br>Mohon segera dibalas pada halaman admin pada menu <b>Review dan Q&A Produk</b> agar customer mendapat pelayanan terbaik dari stars official store.<br><br>Best Regards<br><br><br><i>*Jangan membalas email ini, email ini otomatis dikirim oleh sistem.</i>";
		$this->email->message($body);
		$this->email->send();

		$this->session->set_flashdata('berhasil','Pertanyaan berhasil dikirim, tunggu balasan dari kami.');
		redirect($this->agent->referrer());
	}

	function page_success_review(){
		$this->load->view('review_berhasil');
	}

	function requestProduct(){
		$id1 = $this->security->xss_clean($this->input->post('op'));
		$id = str_replace("/<\/?(p)[^>]*><script></script>", "",$id1);

		$get_id = base64_decode($id);
        $nama_produk    = $this->encrypt->decode($get_id);

        $ml1 = $this->security->xss_clean($this->input->post('mlcs'));
		$ml = str_replace("/<\/?(p)[^>]*><script></script>", "",$ml1);

        $this->load->model('checkout_model');
        $dataadm = $this->checkout_model->keluarkan_dt_adm();
		foreach($dataadm->result() as $yp){
			if($yp->status == "e_admin"){
				$admmail = $yp->em_acc;
			}
		}	

		$config = Array(
			'mailtype'  => 'html', 
		);

		$data_order = array(
			'content'	=> 'Hai admin, apakah produk <b>'.$nama_produk.'</b> masih tersedia?. jika iya mohon kabari saya di email saya <b>'.$ml.'</b>',
		);
		
		$this->email->initialize($config);
      	$this->email->from('noreply@starsstore.id'); // change it to yours
      	$this->email->to($admmail);// change it to yours
      	$this->email->subject('Request Ketersediaan Produk '.$nama_produk.'');
      	$body = $this->load->view('em_info_notification_group/st_order/request_produk',$data_order,TRUE);
      	$this->email->message($body);
      	$this->email->send();
      	$this->mailTocs($nama_produk, $ml);
	}

	function mailTocs($nama_produk, $ml){
		$this->load->model('checkout_model');
        $dataadm = $this->checkout_model->keluarkan_dt_adm();
		foreach($dataadm->result() as $yp){
			if($yp->status == "e_admin"){
				$admmail = $yp->em_acc;
			}
		}	

		$config = Array(
			'mailtype'  => 'html', 
		);

		$data_order = array(
			'content'	=> 'Terima kasih telah melakukan permintaan Ketersediaan produk <b>'.$nama_produk.'</b>, mohon menunggu balasan email dari kami. ',
		);
		
		$this->email->initialize($config);
      	$this->email->from('noreply@starsstore.id'); // change it to yours
      	$this->email->to($ml);// change it to yours
      	$this->email->subject('Request Ketersediaan Produk '.$nama_produk.'');
      	$body = $this->load->view('em_info_notification_group/st_order/request_produk',$data_order,TRUE);
      	$this->email->message($body);
      	$this->email->send();
      	$this->session->set_flashdata('berhasil','Permintaan telah berhasil dikirim');
      	redirect($this->agent->referrer());
	}
}