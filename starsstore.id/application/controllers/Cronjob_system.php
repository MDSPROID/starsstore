<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob_system extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->model(array('home','users')); 
  }
  
// notification or updating by cron job 

  function cekmutasi_sync_order(){
    $this->load->view('manage/CrMt');
  }

  function report_progres_kinerja_by_mail(){
    $this->load->model('checkout_model');
    $this->load->model('sec47logaccess/user_preference_adm');
    $this->data['g'] = $this->user_preference_adm->get_data_kinerja_tgl_now();
    $attach= $this->user_preference_adm->get_data_attach_kinerja_tgl_now();
    // keluarkan data admin dan daftar email cc
    $dataadm = $this->checkout_model->keluarkan_dt_adm();
    foreach($dataadm->result() as $yp){
      if($yp->status == "e_admin"){
        $admmail = $yp->em_acc;
      }
      if($yp->status == "e_cc"){
          $ccmail = $yp->em_acc;
      }
    }
    $config = Array(
      'mailtype'  => 'html', 
    );

    $this->email->initialize($config);    
    $this->email->from('noreply@starsstore.id','PT. Stars Internasional');
    $this->email->to($admmail);
    $this->email->cc($ccmail);
    //$this->email->bcc('them@their-example.com');
    $this->email->subject('Laporan Kerja Tim Promosi & E-commerce');
    $body = $this->load->view('laporan_pdf/report_kinerja_by_mail', $this->data, TRUE);
    $this->email->message($body);
    foreach($attach as $t){
      $this->email->attach(base_url('assets/images/images/kinerja/'.$t->file.''));
    }
    $this->email->send();
  }

  function cron_job_system_p(){
    // CEK EXPIRED PROMO
    //$this->load->model('sec47logaccess/alat_promosi_adm');
    //$cek = $this->alat_promosi_adm->cek_exp();
    //foreach($cek as $r){
    //  $id = $r->id_promo;
    //  $now = date('Y-m-d H:i:s');
    //  $dateData = $r->tgl_akhir; 

    //  if($now > $dateData){
    //    $this->alat_promosi_adm->ganti_status_exp($id);
    //  }
    //}

    // CEK EXPIRED BANNER
    //$this->load->model('sec47logaccess/`');
    //$cek = $this->alat_promosi_adm->cek_exp_flag();
    //foreach($cek as $r){
    //  $id = $r->id;
    //  $now = date('Y-m-d');
    //  $dateData = $r->tgl_akhir;

    //  if($now > $dateData){
    //    $this->alat_promosi_adm->ganti_status_exp_flag($id);
    //  }
    //}

    // CEK EXPIRED VOUCHER
    $this->load->model('sec47logaccess/voucher_adm');
    $cek = $this->voucher_adm->cek_exp();
    foreach($cek as $r){
      $id = $r->id;
      $now = date('Y-m-d H:i:s');
      $dateData = $r->valid_until;

      if($now > $dateData){
        $this->voucher_adm->ganti_status_exp($id);
      }else{
        
      }
    }

    // CEK RESET ID CUSTOMER
    $this->load->model('users');
    $cek = $this->users->cek_exp();
    foreach($cek->result() as $r){
      $id = $r->id_cs;
      $now = date('Y-m-d H:i:s');
      $dateData = $r->date_expired;

      if($now > $dateData){
        $this->users->hapus($id);
      }else{ 
        
      }
    }

    // CEK PROMO MASAL BERAKHIR
    $this->load->model('sec47logaccess/produk_adm');
    $cek = $this->produk_adm->cek_exp_promo_masal();
    foreach($cek->result() as $r){
      $id = $r->id;
      $now = date('Y-m-d');
      $dateData = $r->berakhir;

      if($r->status == "on"){
        if($now > $dateData){

          // KEMBALIKAN HARGA KE NORMAL (NON DISKON)
          $produkx = $this->produk_adm->get_produk_group($id);
          foreach($produkx->result() as $j){

            $data_produk = array(
                  'id_produk_optional' => $j->id_produk_optional,
                  'harga_dicoret'   => "",
                  'harga_fix'       => $j->harga_dicoret,
                );
                $this->db->where('id_produk_optional', $j->id_produk_optional);
                $this->db->update('produk_get_color', $data_produk);
          }

          // UBAH STATUS PROMO
          $data_promo = array(
            'status'  => '',
          );  
          $this->db->where('id', $id);
            $this->db->update('produk_group_name', $data_promo);
          
        }else{ 
          
        }
      }
    }

        // hapus aktifitas user
        $this->load->model('log_activity');
        $this->log_activity->delete_old_log();
  }

  function cekprodukbarulayakjual(){
    $this->db->truncate('produk_all_stok');
    $this->load->model('sec47logaccess/produk_adm');
      $cekartikeldata = $this->produk_adm->get_data_by_art4();
      foreach($cekartikeldata as $gh){
        $artxx = $gh->art_id;

        $curl = curl_init();
        $proxy = '192.168.0.219:80';

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://sm.stars.co.id/ws/lap_stock.php?api=0x010042602D856FE11654537274084EAA64C036BF6BBB8F985A9D&art_id=".$artxx."",
        //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10, 
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        //CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded",
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if($err){
          $this->session->set_flashdata('error', 'Gagal mengambil data dari server #: '.$err.'');
          //log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal cek stok artikel terbaru dari server stars');
        }else{
          $totalstok = 0;
          $data = json_decode($response, true);
          for ($l=0; $l < count($data['stock']); $l++){ 
            $totalstok += $data['stock'][$l]['psg'];
          }

          if($totalstok >= 700){ // jika stok kurang dari atau sama dengan 700 psg maka laporkan ke email admin dan nonaktifkan produk
            $data_stok = array(
              'art' => $artxx,
              'stok'  => $totalstok,
            );
            $this->db->insert('produk_all_stok',$data_stok);
            //echo $artxx.' : '.$totalstok.'<br>';
          }
        }
      }
  }

  function cekstokotomatisforproductecom(){ 
  // CEK DIGABUNG JUGA UNTUK MEMATIKAN PRODUK YANG STOKNYA < 700 DAN JUGA UPDATE STOK_GLOBAL PRODUK YG MASIH AKTIF

    $this->load->model('sec47logaccess/produk_adm');
    $cekartikeldata = $this->produk_adm->get_data_by_art();
    foreach($cekartikeldata as $gh){
      $artxx = $gh->artikel;

      $curl = curl_init();
      $proxy = '192.168.0.219:80';

      curl_setopt_array($curl, array(
      CURLOPT_URL => "http://sm.stars.co.id/ws/lap_stock.php?api=0x010042602D856FE11654537274084EAA64C036BF6BBB8F985A9D&art_id=".$artxx."",
      //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10, 
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      //CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
      ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if(!$err){
        $totalstok = 0;
        $data = json_decode($response, true);
        for ($l=0; $l < count($data['stock']); $l++){ 
          $totalstok += $data['stock'][$l]['psg'];
          //$art_id = $data['stock'][$l]['art_id'];
          //$cekartikeldata = $this->produk_adm->get_data_by_art($art_id);
        }

        if($totalstok <= 700){ // jika stok kurang dari atau sama dengan 700 psg maka laporkan ke email admin dan nonaktifkan produk
          $dataartikel[] = $artxx;
          // NON AKTIFKAN PRODUK OTOMATIS MASUKKAN KE DATABASE
          $datastatusprodukwithstok = array(
            'stok_global' => $totalstok,
            'last_check_stok' => date("Y-m-d"),
            'status'    => '',
          );
          $this->db->update('produk',$datastatusprodukwithstok,array('artikel' => $artxx));
          // dan insert into table produk_dump 
          //$produk_dumpx = array( 
          //  'artikel'     => $artxx,
          //  'stok_terakhir' => $totalstok,
          //  'tgl_input'   => date("Y-m-d H:i:s"),
          //  'tgl'     => date("Y-m-d"),
          //);
          //$this->db->insert('produk_dump', $produk_dumpx); // TIDAK PERLU DIINPUT KE TABLE PRODUK_DUMP
          log_helper('produk', '[SYSTEM] menonaktifkan artikel '.$artxx.' karena stok '.$totalstok.' psg yang harusnya 700 psg (telah dicek otomatis dari server stars)');

        }else{ // jika stok masih baik update stok_global terbaru
          $dataprodukwithstok = array(
            'stok_global' => $totalstok,
            'last_check_stok' => date("Y-m-d"),
          );
          $this->db->update('produk',$dataprodukwithstok,array('artikel' => $artxx));
        }
      }
    }

    // message
    $laporanproduk = array();
    $message_text = array();
    $today = date('d/m/Y');
    $guid = json_encode($dataartikel);
    $judul = "*STARS OFFICIAL STORE*\n*Product Report ".$today."*\n";

    $laporanproduk[] = "*PRODUK DINONAKTIFKAN*\n ".$guid."\n---------------------------\n";

    $laporanprodukx = implode('', $laporanproduk);
    $message_textx = "".$judul."\n".$laporanprodukx; //%0A

    $TOKEN  = "1279929527:AAEE_nTqzu9zkTOo51TiuBvh2m49oYM0U6E"; 
    $chatid = "820509510";//for testing on bot only"820509510"; 
    // ----------- code -------------

    $method = "sendMessage";
    $url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
    $post = [
     'chat_id' => $chatid,
     'parse_mode' => 'Markdown', // aktifkan ini jika ingin menggunakan format type HTML, bisa juga diganti menjadi Markdown
     'text' => $message_textx
    ];

    $header = [
     "X-Requested-With: XMLHttpRequest",
     "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36" 
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_REFERER, $refer);
    //curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post );   
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $datas = curl_exec($ch);
    $error = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);


    $debug['text'] = $message_textx;
    $debug['code'] = $status;
    $debug['status'] = $error;
    $debug['respon'] = json_decode($datas, true);
    print_r($debug);
  }

  function cekstokotomatisforproductecom_nonOffProduk(){ 
  // HANYA MENGUPDATE STOK GLOBAL PRODUK SAJA

    $this->load->model('sec47logaccess/produk_adm');
    $cekartikeldata = $this->produk_adm->get_data_by_art();
    foreach($cekartikeldata as $gh){
      $artxx = $gh->artikel;

      $curl = curl_init();
      $proxy = '192.168.0.219:80';

      curl_setopt_array($curl, array(
      CURLOPT_URL => "http://sm.stars.co.id/ws/lap_stock.php?api=0x010042602D856FE11654537274084EAA64C036BF6BBB8F985A9D&art_id=".$artxx."",
      //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10, 
      CURLOPT_TIMEOUT => 500,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
      ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if(!$err){
      
        $totalstok = 0;
        $data = json_decode($response, true);
        for ($l=0; $l < count($data['stock']); $l++){ 
          $totalstok += $data['stock'][$l]['psg'];
          //$art_id = $data['stock'][$l]['art_id'];
          //$cekartikeldata = $this->produk_adm->get_data_by_art($art_id);
        }

        $dataprodukwithstok = array(
            'stok_global' => $totalstok,
            'last_check_stok' => date("Y-m-d"),
        );        
        $this->db->update('produk',$dataprodukwithstok, array('artikel' => $artxx));
      }
    }
  }

  function cekStokbyrims(){
    $this->load->model('sec47logaccess/produk_adm');
    $data_filtering = $this->security->xss_clean($this->input->post('getinvdata'));
    $datax = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

    $curl = curl_init();
    $proxy = '192.168.0.219:80';

    curl_setopt_array($curl, array(
    CURLOPT_URL => "http://sm.stars.co.id/ws/lap_stock.php?api=0x010042602D856FE11654537274084EAA64C036BF6BBB8F985A9D&art_id=TJ6728-881",
    //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10, 
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    //CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
    CURLOPT_HTTPHEADER => array(
      "content-type: application/x-www-form-urlencoded",
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if($err){
      $this->session->set_flashdata('error', 'Gagal mengambil data dari server #: '.$err.'');
      //log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal cek stok artikel '.$datax.' dari server stars');
      echo  "<span class='pull-right' style='font-size:20px;font-weight:bold;color:red;cursor:pointer;' onclick='closecekStok();'>X</span>";
      echo "Gagal cek stok. periksa koneksi internet.";
    }else{
      $totalstok = 0;
      $totaltoko = 0;
      $nomor = 0;
      $data = json_decode($response, true);
      for ($l=0; $l < count($data['stock']); $l++){ 
        $totalstok += $data['stock'][$l]['psg'];
        $totaltoko += count($data['stock'][$l]['str_id']);
      }
      echo  "<span class='pull-right' style='font-size:20px;font-weight:bold;color:red;cursor:pointer;' onclick='closecekStok();'>X</span><div style='text-align:left;margin-bottom:20px;'>Artikel <b>: ".$datax."</b><br>Total Stok Semua Toko <b>: ".$totalstok." PSG</b><br>Total toko yang memiliki stok <b>: ".$totaltoko." Toko</b></div><div class='table-responsive'>";
      for ($l=0; $l < count($data['stock']); $l++){ 
      $nomor++;
        $edptokox = $data['stock'][$l]['str_id'];
        //PERPENDEK KATA
        $maxword1 = 3;
        $maxword2 = 2;
        $maxword3 = 1;

        // potong kata first dan last
        $firstnamex = substr($edptokox, 0, $maxword1);
        $lsnamex = substr($edptokox, -2, $maxword2);
        $edptoko = $firstnamex.'-'.$lsnamex;

        //$cek = $this->produk_adm->cek_toko($edptoko);
        //if($cek['nama_toko'] == ""){
        //  $namatoko = "[ Unknown Store ]";
        //}else{
        //  $namatoko = $cek['nama_toko'];
        //}

        if($data['stock'][$l]['psg'] == 0 || $data['stock'][$l]['psg'] == ""){
          $jmlpasangtoko = "<i style='color:red'>0</i>";
        }else{
          $jmlpasangtoko = $data['stock'][$l]['psg'];
        }

        echo "<div style='background-color:#f9f9f9;border:white;box-shadow:3px 3px 6px 0px #d5d5d5;padding:10px;text-align:left;'> 
              <label class='label label-primary' style='font-weight:bold;font-size14px;margin-right:5px;position: absolute;left: 30px;margin-top: -10px;'>".$nomor."</label>
                <div style='margin-left:20px;'>
                  <b></b><br>
                  Kode EDP : ".$data['stock'][$l]['str_id']."<br>
                 
                  Total Stok diToko : <b>".$jmlpasangtoko." PSG</b><br><br>
                 
                </div>
              </div><br>";

      }
      
      echo "</tbody></table>";
      echo "</div>";
      //log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cek stok artikel '.$datax.' dari server stars');
    }
  }

  function notif_closing(){
    // CEK WAKTU CLOSING (TGL CLOSING)
    $tgl = date('d');
        if($tgl == 25 || $tgl == 27 || $tgl == 29 || $tgl == 30 || $tgl == 31 || $tgl == 1 || $tgl == 2 || $tgl == 3){
          // send notif email to admin, finance, dan sales

          $data_email = $this->home->load_email();
          $mail = array();
          foreach($data_email as $g){
            $mail[] = $g->em_acc;
          }

          $mailx = implode(',',$mail);

          $data_email_rev = array(
        'judul' => "Persiapan Closing Bulan Ini.",
        'isi'   => "Salam stars all the best,<br><br>Hai admin, bag. finance, dan bag. sales. waktunya mempersiapkan closing untuk bulan ini. berikut langkah-langkah untuk mempersiapkan closing bulanan.<br>
        <ul class='stepclosing'>
                    <li>Cek status semua pesanan disemua marketplace & E-commerce</li>
                    <li>Pastikan pertelaan barang masuk dan keluar yang dikirim toko telah dimasukkan ke POS (Pemindahan antar kode EDP toko)</li>
                    <li>Masukkan semua bukti transfer per transaksi</li>
                    <li>Masukkan penjualan di POS, pastikan sama jumlah pasang dan rupiah dengan laporan barang terjual</li>
                    <li>Masukkan pertelaan barang masuk & keluar di POS dan di E-commerce (Pastikan sama nilai pasang dan rupiahnya)</li>
                    <li>Masukkan biaya-biaya yang menggunakan uang penjualan (buat di ms. word)</li>
                    <li>Cetak RPP/ RPK, barang terjual, pertelaan barang masuk dan keluar, cover biaya dan bukti-bukti pembayaran,</li>
                    <li>Sertakan RPP versi POS untuk dilampirkan ke pembukuan RPP/ RPK</li>
                    <li>Export dan upload penjualan, pertelaan dan RPP/ RPK versi POS ke sm.stars.co.id</li>
                </ul>",
      );
          $config = Array(
        'mailtype'  => 'html', 
      );

      $this->email->initialize($config);
      $this->email->from('noreply@starsstore.id');
          $this->email->to('holding@starsstore.id');
          $this->email->cc($mailx);
          $this->email->subject("Persiapan Closing Bulan Ini");
          $body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
          $this->email->message($body);
          $this->email->send();
        }
  }

  function cron_job_backup_two_daily(){
    // BACKUP DATABASE SETIAP 2 HARI DAN DIKIRIM KE ALAMAT EMAIL MAINTENANCE / DEVELOPER / SUPPORTING
    $this->build_backups();
  }

  function sync_data_store_from_gilang_server(){ // cek setiap hari sekali
    $curl = curl_init();
      $proxy = '192.168.0.219:80';

      curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.nandagilang.com/starsstore/",
      //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10, 
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      //CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$courier",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
      ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if($err){
        $this->session->set_flashdata('error', 'Gagal mengambil data dari server #: '.$err.'');
        log_helper('onlinestore', ''.$this->data['username'].' ('.$this->data['id'].') Gagal cek data toko dari server gilang');
        echo "Gagal cek data toko. periksa koneksi internet.";
      }else{
        
        $data = json_decode($response, true);
        foreach($data['toko'] as $l){
          $edptokox = $l['Str_Id'];
          //PERPENDEK KATA
          $maxword1 = 3;
          $maxword2 = 2;

          // potong kata first dan last
          $firstnamex = substr($edptokox, 0, $maxword1);
          $lsnamex = substr($edptokox, -2, $maxword2);
          $edptoko = $firstnamex.'-'.$lsnamex;

          $ceknewstore = $this->home->cek_newstore($edptoko);
          if($ceknewstore['kode_edp'] == ""){ // jika data toko tidak ada didatabase maka (toko baru) input data

            // hilangkan tanda + pada nomor telpon
            $notelptoko = str_replace('+', '', $l['NoHp']);
            if($l['KD'] == "N" || $l['KD'] == "n" || $l['KD'] == null){
              $statustoko = "";
            }else if($l['KD'] == "Y"){
          $statustoko = "on";
            }

            if($l['almt'] == null){
              $alamat = "-";
            }else{
              $alamat = $l['almt'];
            }

            $data_toko = array(
              'nama_toko' => $l['nama'],
              'alamat'  => $alamat,
              'kode_sms'  => '-',
              'kode_edp'  => $edptoko,
              'spv'   => '-',
              'ass'   => '-',
              'wa_toko' => $notelptoko,
              'spv_nomor' => $notelptoko,
              'toko_aktif'=> $statustoko,
            );
            $this->db->insert('toko',$data_toko);

          }else{ // jika data toko sudah ada maka update, siapa tahu update nomor telp, kode edp, dll

            // hilangkan tanda + pada nomor telpon
            $notelptoko = str_replace('+', '', $l['NoHp']);
            if($l['KD'] == "N" || $l['KD'] == "n" || $l['KD'] == null){
              $statustoko = "";
            }else if($l['KD'] == "Y"){
          $statustoko = "on";
            }

            if($l['almt'] == null){
              $alamat = "-";
            }else{
              $alamat = $l['almt'];
            }

              $data_toko = array(
              'nama_toko' => $l['nama'],
              'alamat'  => $alamat,
              'kode_sms'  => '-',
              'kode_edp'  => $edptoko,
              'spv'   => '-',
              'ass'   => '-',
              'wa_toko' => $notelptoko,
              'spv_nomor' => $notelptoko,
              'toko_aktif'=> $statustoko,
            );
            $this->db->where('kode_edp', $edptoko);
            $this->db->update('toko',$data_toko);
          }
        }
        echo "sukses";
        log_helper('onlinestore', 'Sistem berhasil sync data toko dari server gilang');
      }
  }

  function build_backups(){
    $date = date('Y-m-d');
    $this->database_backup($date);
    //$this->project_backup($date);
    $this->send_backup($date);
  }

  function database_backup($date){
    $this->load->helper('file');
    $this->load->dbutil();
    @ $backup =& $this->dbutil->backup();
    write_file('global/database_'.$date.'.zip', $backup);
  }

  function project_backup($date){
    $this->load->library('zip');
    $this->zip->read_dir(FCPATH, FALSE);
    $this->zip->archive('global/project_'.$date.'.zip');
  }

  function send_backup($date){
    $data_email = $this->home->load_email_all();
      //$mail = array();
      foreach($data_email as $g){
        if($g->status == "e_support"){
          $mail = $g->em_acc;
        }
      }
      
      $tglx = date('d F Y');
    $config = Array(
        'mailtype'  => 'html', 
      );

    $this->email->initialize($config);
    $this->email->from('noreply_by_system@starsstore.id');
        $this->email->to($mail);  
        //$this->email->attach('global/project_'.$date.'.zip');
        $this->email->attach(base_url('global/database_'.$date.'.zip'));
        $this->email->subject('Backup Program dan Database '.$tglx.'');
        //$body = $this->load->view('em_info_notification_group/f_cus_send_mail',$data_email_rev,TRUE);
        $this->email->message('Backup Program dan Database '.$tglx.'');
        if($this->email->send()){
          unlink('global/database_'.$date.'.zip');
          //unlink(PUBPATH . "global/".'project_'.$date.'.zip');
        }else{
          show_error($this->email->print_debugger());
        }
  }

// CEK ORDER CUSTOMER DARI E-COMMERCE
  
  function cek_expired_order(){
    $this->load->model('sec47logaccess/order_adm');
    $cek = $this->order_adm->cek_exp();
    if($cek->num_rows() > 0){
      foreach($cek->result() as $r){
        $id = $r->id;
        $email = $r->email;
        $inv = $r->invoice;
        $now = date('Y-m-d H:i:s');
        $dateData = $r->tanggal_jatuh_tempo;

        if($now > $dateData){
          $this->order_adm->ganti_status_exp($id);
          //$g = $this->order_adm->getMailcs($id);
          //foreach($g as $f){
          //  $email = $email;
          //  $inv = $f->invoice;
          //}
          $config = Array(
            'mailtype'  => 'html', 
          );
          $data_order = array(
            'invoice'   => $inv,
            'status'  => '<i style="color:red;">dibatalkan</i>',
            'content' => '<p style="text-align:justify;">Pesanan anda kami batalkan karena tidak memenuhi syarat. atau kami tidak menerima pembayaran anda. jika anda telah mentransfer sejumlah uang. <a href="'.base_url('bantuan').'">Klik disini</a> untuk menghubungi kami.</p>',
          );
          $judulEmail = "Order anda";
          $this->email->initialize($config);
              $this->email->from('noreply@starsstore.id'); // change it to yours
              $this->email->to($email);// change it to yours
              $this->email->subject('Starsstore - Pembatalan Pesanan Anda #'.$inv.'');
              $body = $this->load->view('em_info_notification_group/st_order/status_order',$data_order,TRUE);
              $this->email->message($body);
              $this->email->send();
              log_helper('onlinestore', 'Sistem mengubah otomatis order no. invoice '.$inv.' menjadi batal');
        }else{
          //echo "GAK EXPIRED";
        }
      }
    }
  } 

  function sync_stok_produk(){
    $cekstatus = $this->home->cek_sync_produk_status();
    if($cekstatus == "on"){ // jka status sync on maka cronjob aktif jika ada stok yang <700 maka langsung di off kan
      $this->cekstokotomatisforproductecom();
    }else{ // jka status sync off maka cronjob tidak aktif
      $this->cekstokotomatisforproductecom_nonOffProduk(); // cek dan update stok saja tanpa menonaktifkan produk
    }
  }

// end notification or updating by cron job

  function our_store(){
    $data['r'] = $this->home->get_our_store();
    $this->load->view('theme/v1/header');
    $this->load->view('theme/v1/our_store', $data);
    $this->load->view('theme/v1/footer');
  }

  function konfirmasi(){
    // generate SKU Produk
    $length =10; 
    $sku= "";
    srand((double)microtime()*1000000);
    $datax = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
    $datax .= "1234567890";
    for($i = 0; $i < $length; $i++){
      $sku .= substr($datax, (rand()%(strlen($datax))), 1);
      $data['identity'] = "BK_".$sku;
    }

    $id_customer = $this->session->userdata('id_cs');
    $data['pesanan'] = $this->home->get_pesanan_belum_dibayar($id_customer);
    $data['bank'] = $this->home->daftar_rekening_pusat(); 
    $this->load->view('theme/v1/header');
    $this->load->view('theme/v1/konfirmasi',$data);
    $this->load->view('theme/v1/footer'); 
  }

  function checkpesanankonfirmasi(){
    $idx1 = $this->security->xss_clean($this->input->post('pesanan'));
    $idx2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$idx1);
    $idx3 = strip_tags($idx2);
    $idx = htmlentities($idx3);

    // cek id pesanan
    $cek1 = $this->home->cek_pesanan($idx);
    if($cek1->num_rows() > 0){ // jika ketemu maka update
      $cek2 = $this->home->cek_konfirm_already($idx);
      if($cek2->num_rows() > 0){ // jika sudah pernah dikonfirmasi
        echo "405";
      }else{
        echo "467";
      }
    }else{
      echo "200";
    }
  }

  function proses_konfirmasi(){
    $vrnx1 = $this->security->xss_clean($this->input->post('kIns'));
    $vrnx2 = base64_decode($vrnx1);
    $vrnx = $this->encrypt->decode($vrnx2);

    $idx1 = $this->security->xss_clean($this->input->post('sku_m'));
    $idx2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$idx1);
    $idx3 = strip_tags($idx2);
    $idx = htmlentities($idx3);

    $id1 = $this->security->xss_clean($this->input->post('id_pesanan'));
    $id2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$id1);
    $id3 = strip_tags($id2);
    $id = htmlentities($id3);

    $nm1 = $this->security->xss_clean($this->input->post('nama'));
    $nm2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nm1);
    $nm3 = strip_tags($nm2);
    $nm = htmlentities($nm3);

    $em1 = $this->security->xss_clean($this->input->post('email'));
    $em2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$em1);
    $em3 = strip_tags($em2);
    $em = htmlentities($em3);

    $bnk1 = $this->security->xss_clean($this->input->post('bank'));
    $bnk2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$bnk1);
    $bnk3 = strip_tags($bnk2);
    $bnkx = htmlentities($bnk3);

    $bnkxx = explode('|', $bnkx);
    $namebank1 = base64_decode($bnkxx[0]);
    $nobank2 = base64_decode($bnkxx[1]);

    $bank_gabung = $namebank1." - ".$nobank2;

    //$tgl1 = $this->security->xss_clean($this->input->post('tgl_transfer'));
    //$tgl2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$tgl1);
    //$tgl3 = strip_tags($tgl2);
    //$tgl = htmlentities($tgl3);

    $nmn1 = $this->security->xss_clean($this->input->post('nominal'));
    $nmn2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$nmn1);
    $nmn3 = strip_tags($nmn2);
    $nmn = htmlentities($nmn3);

    $note1 = $this->security->xss_clean($this->input->post('catatan'));
    $note2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$note1);
    $note3 = strip_tags($note2);
    $note = htmlentities($note3);   

    if($note == ""){  
      $notex = "-";
    }else{
      $notex = $note;
    }

    if($vrnx != "KntJs628%243@729&2!46"){

      $this->load->model('sec47logaccess/setting_adm');
      $aktifitas = "memecahkan kode enkripsi untuk input bukti pembayaran ".$id."";
      $this->setting_adm->savingHack($aktifitas);

    }else{ 

      // cek id pesanan
      $cek = $this->home->cek_pesanan($id);
      if($cek->num_rows() == 0){ // jika tidak ketemu

        // hapus bukti transfer supaya tidak memenuhi database 

        $foto = $this->db->get_where('bukti_transfer',array('identity_bukti'=>$idx));

        //print_r($foto->num_rows());
        if($foto->num_rows()>0){
          $hasil    = $foto->row();
          $nama_foto  = $hasil->gambar;

          $srcx = str_replace(''.base_url('assets/images/konfirmasi_pesanan/').'','', $nama_foto);
          $file = FCPATH.'assets/images/konfirmasi_pesanan/'.$srcx.'';
          //if(file_exists($file = FCPATH.'/assets/images/konfirmasi_pesanan/'.$nama_foto)){
            unlink($file);
            //print_r($file);
          //}
          $this->db->delete('bukti_transfer',array('identity_bukti'=>$idx));
        }

        $this->session->set_flashdata('error','Nomor pesanan tidak ditemukan');
        redirect($this->agent->referrer());

      }else{ // JIKA KETEMU MAKA DICEK LAGI

        $cek2 = $this->home->cek_konfirm_already($id);
        if($cek2->num_rows() > 0){ // jika sudah pernah dikonfirmasi

          // hapus bukti transfer supaya tidak memenuhi database 

          $foto = $this->db->get_where('bukti_transfer',array('identity_bukti'=>$idx));

          //print_r($foto->num_rows());
          if($foto->num_rows()>0){
            $hasil    = $foto->row();
            $nama_foto  = $hasil->gambar;

            $srcx = str_replace(''.base_url('assets/images/konfirmasi_pesanan/').'','', $nama_foto);
            $file = FCPATH.'assets/images/konfirmasi_pesanan/'.$srcx.'';
            //if(file_exists($file = FCPATH.'/assets/images/konfirmasi_pesanan/'.$nama_foto)){
              unlink($file);
              //print_r($file);
            //}
            $this->db->delete('bukti_transfer',array('identity_bukti'=>$idx));
          }
            
          $this->session->set_flashdata('error','Nomor pesanan sudah dikonfirmasi');
          redirect($this->agent->referrer());

        }else{

          // update status
          $status = array(
            'status'  => "*^56t38H53gbb^%$0-_-",
          );
          $this->home->update_status_pesanan($status, $id);

          $this->form_validation->set_rules('id_pesanan', 'ID Pesanan', 'required|xss_clean');
          $this->form_validation->set_rules('nama', 'Nama lengkap', 'required|xss_clean');
          $this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
          $this->form_validation->set_rules('bank', 'Bank', 'required|xss_clean');
          //$this->form_validation->set_rules('tgl_transfer', 'Tanggal Transfer', 'required|xss_clean');
          $this->form_validation->set_rules('nominal', 'Nominal', 'required|xss_clean');

          if($this->form_validation->run() != FALSE ){  
            // simpan data
            $data_konfirmasi = array(
              'identity_pembayaran' => $idx,
              'id_pesanan'      => $id,
              'nama'          => $nm,
              'email'         => $em,
              'bank'          => $bank_gabung,
              'tgl'         => date("Y-m-d"),
              'nominal'       => $nmn,
              'catatan'       => $notex,
              'tgl_input_data'    => date("Y-m-d H:i:s"),
            );
            $this->home->simpan_bukti_pembayaran($data_konfirmasi);
            
            // kirim email ke customer
            $this->load->library('email');
            $balas_konfirmasi = "<p style='text-align:justify;'>Terima kasih telah mengirimkan bukti pembayaran dengan rincian sebagai berikut :<br><br>Nomor pesanan : <b>".$id."</b><br>Nama : <b>".$nm."</b><br>Bank : <b>".$bank_gabung."</b><br>Nominal : <b>Rp. ".number_format($nmn,0,".",".")."</b><br>Catatan : <b>".$notex."</b><br><br>Kami akan mengecek bukti pembayaran anda, Terima kasih.</p>";
                $config = Array(
              'mailtype'  => 'html', 
            );
            
            $this->email->initialize($config);
                $this->email->from('noreply@starsstore.id');
                $this->email->to($em);
                $this->email->subject('Starsstore - Konfirmasi Pembayaran '.$id.'');
                $this->email->message($balas_konfirmasi);
                $this->email->send();

                $this->send_konfirm_to_admin($idx,$id,$nm,$em,$bank_gabung,$nmn,$notex);

          }else{

            $this->session->set_flashdata('error','Lengkapi form terlebih dahulu');
            redirect($this->agent->referrer());
          }
        }
      }

    }
  }

  function send_konfirm_to_admin($idx,$id,$nm,$em,$bank_gabung,$nmn,$notex){
    // kirim email ke customer
    // KELUARKAN DATA EMAIL ADMIN
    $this->load->model('checkout_model');
    $dataadm = $this->checkout_model->keluarkan_dt_adm();
    foreach($dataadm->result() as $yp){
      if($yp->status == "e_admin"){
        $admmail = $yp->em_acc;
      }
    } 

    $this->load->library('email');

    $balas_konfirmasi = "<p style='text-align:justify;'>Pelanggan telah memberikan bukti transfer pembayaran mohon dicek, rincian sebagai berikut :<br><br>Nomor pesanan : <b>".$id."</b><br>Nama : <b>".$nm."</b><br>Bank : <b>".$bank_gabung."</b><br>Nominal : <b>Rp. ".number_format($nmn,0,".",".")."</b><br>Catatan : <b>".$notex."</b><br><br>Salam Stars.</p>";

        $config = Array(
      'mailtype'  => 'html', 
    );
    
    $this->email->initialize($config);
        $this->email->from('noreply@starsstore.id');
        $this->email->to($admmail);
        $this->email->subject('Starsstore - Konfirmasi Pembayaran Pelanggan '.$id.'');
        //$body = $this->load->view($balas_konfirmasi,TRUE);
        $this->email->message($balas_konfirmasi);
        $this->email->send();
 
        $this->session->set_flashdata('berhasil','Konfirmasi telah dikirim.');
        redirect($this->agent->referrer());
  }

  // GANTI FUNGSI UNTUK KONFIRMASI PEMBAYARAN
  function upload_bukti_transfer(){
    $config['upload_path']   = FCPATH.'/assets/images/konfirmasi_pesanan/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg'; //|pdf|doc|docx
        $config['encrypt_name']  = TRUE;
        $config['overwrite']     = FALSE;
        
        $this->upload->initialize($config); 

        if($this->upload->do_upload('userfile')){

          $gbr = $this->upload->data();

          // DAPATKAN UKURAN GAMBAR DAN SUSUTKAN 30%
          $gambar = FCPATH.'/assets/images/konfirmasi_pesanan/'.$gbr['file_name'].'';
          $data = getimagesize($gambar);
          $width = round($data[0] * 95 / 100); //susutkan 95%
          $height = round($data[1] * 95 / 100); // susutkan 95%

          //print_r($width.' | '.$height);

          $this->image_lib->initialize(array(
                'image_library' => 'gd2', //library yang kita gunakan
                'source_image'  => './assets/images/konfirmasi_pesanan/'. $gbr['file_name'],
                'maintain_ratio'=> FALSE,
                //'create_thumb' => TRUE,
                'quality'   => '100%',
                'width'     => $width,
                'height'    => $height,
            ));
            $this->image_lib->resize();


            $gambar = base_url('assets/images/konfirmasi_pesanan/'.$gbr['file_name'].'');

          $token  = $this->input->post('token_foto');
          
          //$id   = $this->session->userdata('sellerID');
          //$nama   = base_url('assets/images/konfirmasi_pesanan/'.$this->upload->data('file_name').'');

          $idk = $this->input->post('identitas');
          
          $this->db->insert('bukti_transfer',array('identity_bukti'=>$idk, 'token'=>$token, 'gambar'=>$gambar));
        }
  }

  //Untuk menghapus foto
  function removeDocument(){

    //Ambil token foto
    $token = $this->input->post('token');

    $foto = $this->db->get_where('bukti_transfer',array('token'=>$token));

    //print_r($foto->num_rows());
    if($foto->num_rows()>0){
      $hasil    = $foto->row();
      $nama_foto  = $hasil->gambar;

      $srcx = str_replace(''.base_url('assets/images/konfirmasi_pesanan/').'','', $nama_foto);
      $file = FCPATH.'assets/images/konfirmasi_pesanan/'.$srcx.'';
      //if(file_exists($file = FCPATH.'/assets/images/konfirmasi_pesanan/'.$nama_foto)){
        unlink($file);
        //print_r($file);
      //}
      $this->db->delete('bukti_transfer',array('token'=>$token));
    }
    //unlink(FCPATH.'assets/images/konfirmasi_pesanan/bb84ed10dc0d809bbd299124b95e0846.PNG');

    echo "{}";
  }

  function error(){
    $data['produk_lain'] = $this->home->get_produk_latest();
    $this->load->view('theme/v1/header');
    $this->load->view('theme/v1/404', $data);
    $this->load->view('theme/v1/footer');
  }

  function affiliate($id){
    $aff = base64_decode($id);
    $aff_s = $this->encrypt->decode($aff);
    $data_info = array(
            'id_banner' => $aff_s,
            'ip'        => $this->input->ip_address(),
            'device'    => $this->agent->browser(),
            'browser'   => $this->agent->platform(),
            'bulan'     => date("M"),
            'tgl'       => date("Y-m-d H:i:s"),
            'tanggal'   => date("Y-m-d"),
        );

        $this->home->write_banner($data_info);
  }

  function berlangganan(){
    $ins = $this->security->xss_clean($this->input->post('token_session_config'));
    $a = base64_decode($ins);
    $b = $this->encrypt->decode($a);

    $news1 = $this->security->xss_clean($this->input->post('newsletter'));
    $news2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$news1);
    $news3 = strip_tags($news2);
    $news = htmlentities($news3);

    if($b != "Jsd63)263&31).?"){
      //SAVING DATA HACKER
      $this->load->model('sec47logaccess/setting_adm');
      $aktifitas = "memecahkan kode enkripsi untuk input email newsletter di front end";
      $this->setting_adm->savingHack($aktifitas);
    }else{
      $cek_already = $this->home->cek_already_email($news);
      if($cek_already->num_rows() == 0){
        $this->home->add_email_new_newsletter($news);
        $this->load->library('email');
        $data_newsletter = array(
          'isi' => $news,
          );
            $config = Array(
          'mailtype'  => 'html', 
        );
        
        $this->email->initialize($config);
            $this->email->from('newsletter@starsallthebest.com'); // change it to yours
            $this->email->to($news);// change it to yours
            $this->email->subject('Berlangganan Email');
            $body = $this->load->view('em_info_notification_group/f_cus_newsletter',$data_newsletter,TRUE);
            $this->email->message($body);
            $this->email->send();
        $data['news'] = $news;
        $data['caption'] = "Terima kasih telah berlangganan email kami, nantikan seputar promo dan produk terbaru dari kami.";
        $this->load->view('theme/v1/header');
        $this->load->view('theme/v1/newsletter', $data);
        $this->load->view('theme/v1/footer');
      }else{
        $data['news'] = $news;
        $data['caption'] = "Email telah terdaftar, gunakan email lain";
        $this->load->view('theme/v1/header');
        $this->load->view('theme/v1/newsletter', $data);
        $this->load->view('theme/v1/footer');
      }
    }
  }

  function research_product(){
    $in = $this->input->post('search_data');
    //produk 
    $result1 = $this->home->get_autocomplete($in);
    //merk
    $result2 = $this->home->get_autocomplete2($in);

    if(empty($result1) && empty($result2)){
      echo "<em> Produk tidak ditemukan ...</em>";
    }else{
      if(!empty($result1)){
        echo('<div class="desc-fil">Pencarian pada produk</div>');
        echo '<ul class="list-unstyled rpor">';
        foreach($result1 as $produk):
          if($produk->diskon == 0 || empty($produk->diskon)){
            $disc1 =  "";
          }else{
            $disc1 = "<label class='diskon'>$produk->diskon%</label>";
          }
          //$diskon = $produk->harga_retail-($produk->harga_retail*$produk->diskon/100);
          if($produk->diskon == 0 || empty($produk->diskon)){
            $price = '<span style="position:absolute;right:15px;" class="harga_retail">Rp.'.number_format($produk->harga_retail,0,".",".").'</span>'; 
          }else{
            $price = '<span style="position:absolute;right:15px;"><s class="discount-title" style="font-size:12px;">Rp.'.number_format($produk->harga_retail,0,".",".").'</s> <harga class="harga_retail">Rp.'.number_format($produk->diskon_rupiah,0,".",".").'</harga></span>'; 
          }
          if($produk->rating_produk == 0){
              $rat = "<img src='".base_url()."assets/images/img/rating/0stars.png' data-original='assets/images/img/rating/0stars.png' class='lazy'  width='70'>";
          }elseif($produk->rating_produk <= 5){
              $rat = "<img src='".base_url()."assets/images/img/rating/1stars.png' data-original='assets/images/img/rating/1stars.png' class='lazy'  width='70'>";
          }elseif($produk->rating_produk <= 10){
              $rat = "<img src='".base_url()."assets/images/img/rating/2stars.png' data-original='assets/images/img/rating/2stars.png' class='lazy'  width='70'>";
          }elseif($produk->rating_produk <= 15){
              $rat = "<img src='".base_url()."assets/images/img/rating/3stars.png' data-original='assets/images/img/rating/3stars.png' class='lazy'  width='70'>";
          }elseif($produk->rating_produk <= 20){
              $rat = "<img src='".base_url()."assets/images/img/rating/4stars.png' data-original='assets/images/img/rating/4stars.png' class='lazy'  width='70'>";
          }elseif($produk->rating_produk <= 25 || $produk->rating_produk > 25){ 
              $rat = "<img src='".base_url()."assets/images/img/rating/5stars.png' data-original='assets/images/img/rating/5stars.png' class='lazy'  width='70'>";
          }
          echo '<li style="height:50px;"><a href="'.base_url('produk/'.$produk->slug).'">';
          //echo $disc1;
                  echo '<img src="'.$produk->gambar.'" data-original="'.$produk->gambar.'" class="lazy pull-left" height="50" /> 
              <h5 style="margin-bottom:0;font-weight:700;"><span style="padding-left:5px;">'.$nama = word_limiter($produk->nama_produk,5).'</span>
              </h5>';
          echo '<span style="padding-left:5px;">'.$rat.'</span>';
          echo $price;
          echo '</a></li>';
        endforeach;
        echo '</ul>';
      }
      if(!empty($result2)){
        echo('<div class="desc-fil" style="margin-bottom:0;margin-top:20px;">Merk</div>');
        foreach($result2 as $row):
          echo '<a class="dropdown-item" style="margin-right:10px;" href="'.base_url('katalog/brand/'.$row->slug).'"><img src="'.$row->logo.'" width="100"></a>';
        endforeach;
      }
    }
  }

  function subpagefacebook(){
    $this->load->view('theme/v1/header');
    $this->load->view('theme/v1/form_aplikasi');
    $this->load->view('theme/v1/footer');
  }

  function tambahdatasubpage(){
    $this->form_validation->set_rules('edp', 'Kode EDP', 'required|xss_clean');
    $this->form_validation->set_rules('name', 'Nama Supervisor', 'required|xss_clean');
    $this->form_validation->set_rules('name_fb', 'Nama Facebook Supervisor', 'required|xss_clean');
    $this->form_validation->set_rules('alamat', 'Alamat Toko', 'required|xss_clean');
    $this->form_validation->set_rules('ig', 'Instagram Toko', 'required|xss_clean');
    $this->form_validation->set_rules('hp', 'Nomor HP Toko', 'required|xss_clean');
    if($this->form_validation->run() != FALSE ){
      $kodeEdp  = $this->security->xss_clean($this->input->post('edp'));
      $nama   = $this->security->xss_clean($this->input->post('name'));
      $namafb   = $this->security->xss_clean($this->input->post('name_fb'));
      $alamat   = $this->security->xss_clean($this->input->post('alamat'));
      $ig   = $this->security->xss_clean($this->input->post('ig'));
      $hp   = $this->security->xss_clean($this->input->post('hp'));

      // cek bila sudah pernah memasukkan
      $cek = $this->home->cek_data_spv($kodeEdp);
      if($cek->num_rows() > 0){
        $this->session->set_flashdata('error','Data Sudah ada sebelumnya');
        redirect($this->agent->referrer());
      }else{
        $data_toko = array(
          'nama_fb' => $namafb,
          'nama_spv'  => $nama,
          'code_edp'  => $kodeEdp,
          'alamat'  => $alamat,
          'ig'  => $ig,
          'hp'  => $hp,
        );
        $this->home->add_data_supervisor($data_toko);
        redirect(base_url('selesai'));
      }
    }else{
      $this->session->set_flashdata('error','Isi form dengan lengkap.');
      redirect($this->agent->referrer());
    }
  }

  function selesai_tambahdatasubpage(){
    $this->load->view('theme/v1/header');
    $this->load->view('theme/v1/form_aplikasi_end');
    $this->load->view('theme/v1/footer');
  }

  function lacak_orderan(){
    $this->load->view('theme/v1/header');
    $this->load->view('theme/v1/form_lacak');
    $this->load->view('theme/v1/footer');
  }

  function proses_lacak_pesananFix(){
    $inv1 = $this->security->xss_clean($this->input->post('invoiceNo'));
    $inv2 = str_replace("/<\/?(p)[^>]*><script></script>", "",$inv1);
    $inv3 = strip_tags($inv2);
    $inv = htmlentities($inv3);

    $r = $this->home->lacakPesananfix($inv);
    if($r == "" || empty($r)){
      $this->session->set_flashdata('error', 'Nomor invoice tidak ditemukan.');
      redirect($this->agent->referrer());
    }else{
      $this->data['lacak'] = $this->home->lacakPesananfix($inv);
      $this->load->view('theme/v1/header');
      $this->load->view('theme/v1/form_proses_lacak_pesanan', $this->data);
      $this->load->view('theme/v1/footer');
    }
  }

  function promo(){
    $data['promo'] = $this->home->getPromo();
    $this->load->view('theme/v1/header');
    $this->load->view('theme/v1/promo_menarik', $data);
    $this->load->view('theme/v1/footer');
  }

  function tentang_kami(){
    $myApiKey="AIzaSyAdgRhhXUsATFGL7OPWx1vHgnnx-dwBNDI"; // Provide your API Key
    $myChannelID="UCuy1wqC_-Wh8k5tFrm-q7sg"; // Provide your Channel ID
    $maxResults="25"; // Number of results to display
     
    // Make an API call to store list of videos to JSON variable
    $myQuery = "https://www.googleapis.com/youtube/v3/search?key=$myApiKey&channelId=$myChannelID&part=snippet,id&order=date&maxResults=$maxResults";
    $videoList = file_get_contents($myQuery);
     
    // Convert JSON to PHP Array
    $decoded = json_decode($videoList, true);
     
    // Run a loop to display list of videos
    foreach ($decoded['items'] as $items){
      $id = $items['id']['videoId'];
      $title= $items['snippet']['title'];
      $description = $items['snippet']['description'];
      $thumbnail = $items['snippet']['thumbnails']['default']['url'];
       
      // Display list with some basic CSS formatting
      echo "<p style='display:inline-block;width:200px;margin:10px;text-align:center;vertical-align:top'>";
      echo "<img src='$thumbnail'>";
      echo "<strong>$title</strong>";
      echo "<small>$description</small>";
      echo "";
    }
    //$data['promo'] = $this->home->getPromo();
    //$this->load->view('theme/v1/header');
    //$this->load->view('theme/v1/tentang-kami');
    //$this->load->view('theme/v1/footer');
  }

  function get_sales(){
    $message_text = array();
    $today = date('d/m/y');
    $judul = "STARS OFFICIAL STORE<br>".$today."<br>"; //%0A
    $getData = $this->home->penj_by_sosmed_dan_mp_all_price_calc();
    //echo "Sales Report ".$today."%0A";
    foreach($getData as $u){
      $market = $u->buy_in;
      $getSTD  = $this->home->penj_by_sosmed_dan_mp_all_price_calc_by_std($market);
      $getSTY  = $this->home->penj_by_sosmed_dan_mp_all_price_calc_by_sty($market);
      $turnover_sty   = (($u->turn_over+$getSTD['turn_over_std'])+$getSTY['turn_over_sty']);
      $pasang_sty   = (($u->jual_pasang+$getSTD['jual_pasang_std'])+$getSTY['jual_pasang_sty']);

      $message_text[] = "".$u->buy_in." ".$u->jual_pasang."-".number_format($u->turn_over,0,".",",")." A:".round(($u->turn_over/$u->jual_pasang),2)." STD= ".($u->jual_pasang+$getSTD['jual_pasang_std'])."-".number_format(($u->turn_over+$getSTD['turn_over_std']),0,".",",")." A:".round(($u->turn_over+$getSTD['turn_over_std'])/($u->jual_pasang+$getSTD['jual_pasang_std']))." STY= ".(($u->jual_pasang+$getSTD['jual_pasang_std'])+$getSTY['jual_pasang_sty'])."-".number_format(($u->turn_over+$getSTD['turn_over_std'])+$getSTY['turn_over_sty'],0,".",",")." A:".round($turnover_sty/$pasang_sty)."<br>-------<br><br>";
    }

    $messagex = implode('', $message_text);
    $message_textx = "".$judul."".$messagex." ";

    $bulan_awal_tahun_ini = date('Y')."-01-01";
        $bulan_kemarin_tahun_inix = date('Y-m-d', strtotime('-1 month'));//, strtotime('-1 month'));
        //echo date("Y-m-t", strtotime($bulan_kemarin_tahun_inix));

        echo $message_textx;

        //print_r($message_text);
        //echo $bulan_kemarin_tahun_ini;
  } 

  function kirimlaporansalesbytelegramxxxx(){ 
    $this->load->model('sec47logaccess/onlinestore_adm');
    // message
    $message_text = array();
    $today = date('Y-m-d H:i:s', strtotime('1 day'));
    $judul = "STARS OFFICIAL STORE%0ASales Report ".$today."";
    // value pasang & turn over
    $pasang = 0;
    $turnover = 0;
    $a_pasang = 0;
    // STD
    $pasang_std = 0;
    $turnover_std = 0;
    $a_std = 0;
    // STY
    $pasang_sty = 0;
    $turnover_sty = 0;
    $a_sty = 0;

    $getMarket = $this->onlinestore_adm->get_marketplace();
    foreach($getMarket as $m){
      $market = $m->val_market;
      $getData = $this->home->get_penjualan_hari_ini_by_market($market);

      foreach($getData as $u){
        //$market = $u->buy_in;
        $getSTD  = $this->home->penj_by_sosmed_dan_mp_all_price_calc_by_std($market);
        $getSTY  = $this->home->penj_by_sosmed_dan_mp_all_price_calc_by_sty($market);

        // value pasang & turn over
        $pasang = $u->jual_pasang;
        $turnover = $u->turn_over;
        //if($pasang == 0 || $turnover == 0){
        //  $a_pasang = 0;
        //}else{
        //  $a_pasang = $turnover/$pasang;
        //}
        // STD
        $pasang_std = $getSTD['jual_pasang_std'];
        $turnover_std = $getSTD['turn_over_std'];
        //if($pasang_std == 0 || $turnover_std == 0){
        //  $a_std = 0;
        //}else{
        //  $a_std = ($turnover+$turnover_std)/($pasang+$pasang_std);
        //}
        // STY
        $pasang_sty = $getSTY['jual_pasang_sty'];
        $turnover_sty = $getSTY['turn_over_sty'];
        //if($pasang_sty == 0 || $turnover_sty == 0){
        //  $a_sty = 0;
        //}else{
        //  $a_sty = (($turnover+$getSTD['turn_over_std'])+$getSTY['turn_over_sty'])/(($pasang+$getSTD['jual_pasang_std'])+$getSTY['jual_pasang_sty']);
        //}

        $message_text[] = "".$market."%0A-------%0A";

    //$getData = $this->home->penj_by_sosmed_dan_mp_all_price_calc();
    //foreach($getData as $u){
      //$market = $u->buy_in;
      //$getSTD  = $this->home->penj_by_sosmed_dan_mp_all_price_calc_by_std($market);
      //$getSTY  = $this->home->penj_by_sosmed_dan_mp_all_price_calc_by_sty($market);
      //$turnover_sty   = (($u->turn_over+$getSTD['turn_over_std'])+$getSTY['turn_over_sty']);
      //$pasang_sty   = (($u->jual_pasang+$getSTD['jual_pasang_std'])+$getSTY['jual_pasang_sty']);
      
      //$message_text[] = "".$u->buy_in." ".$u->jual_pasang."-".number_format($u->turn_over,0,".",",")." A:".round(($u->turn_over/$u->jual_pasang),2)." STD= ".($u->jual_pasang+$getSTD['jual_pasang_std'])."-".number_format(($u->turn_over+$getSTD['turn_over_std']),0,".",",")." A:".round(($u->turn_over+$getSTD['turn_over_std'])/($u->jual_pasang+$getSTD['jual_pasang_std']))." STY= ".(($u->jual_pasang+$getSTD['jual_pasang_std'])+$getSTY['jual_pasang_sty'])."-".number_format(($u->turn_over+$getSTD['turn_over_std'])+$getSTY['turn_over_sty'],0,".",",")." A:".round($turnover_sty/$pasang_sty)."%0A-------%0A";
      }
    }

    $messagex = implode('', $message_text);
    $message_textx = "".$judul."%0A%0A".$messagex." ";

    $secret_token = "1279929527:AAEE_nTqzu9zkTOo51TiuBvh2m49oYM0U6E";
    $telegram_id  = "820509510";//"-468150997";

    $url = "https://api.telegram.org/bot" . $secret_token . "/sendMessage?chat_id=" . $telegram_id;
      $url = $url . "&text=hAI";//.$message_textx."";
      $ch = curl_init();
      $optArray = array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true
      );
      curl_setopt_array($ch, $optArray);
      $result = curl_exec($ch);
      curl_close($ch);

      echo $messagex;

    /*----------------------
    only basic POST method :
    -----------------------*/
    //$telegram_id = $_POST ['telegram_id'];
    //$message_text = $_POST ['message_text'];

    /*--------------------------------
    Isi TOKEN dibawah ini: 
    --------------------------------*/
    //$secret_token = "Isi TOKEN disini";
    sendMessage($telegram_id, $messagex, $secret_token);
  }

  function kirimlaporansalesbytelegram(){

    $this->load->model('sec47logaccess/onlinestore_adm');
    // message
    $totalseluruhmarketplace = array();
    $message_text = array();
    $today = date('d/m/Y', strtotime("-1 day"));
    $judul = "*STARS OFFICIAL STORE*\n*Sales Report ".$today."*\n";
    // value pasang & turn over
    $pasang = 0;
    $pasangx = 0;
    $turnover = 0;
    $turnoverx = 0;
    $a_pasang = 0;
    // STD
    $pasang_std = 0;
    $pasang_stdx = 0;
    $turnover_std = 0;
    $turnover_stdx = 0;
    $a_std = 0;
    // STY
    $pasang_sty = 0;
    $pasang_styx = 0;
    $turnover_sty = 0;
    $turnover_styx = 0;
    $a_sty = 0;

    $getMarket = $this->onlinestore_adm->get_marketplace();
    foreach($getMarket as $m){
      $market = $m->val_market;
      if($market == "whatsapp_marketing"){
        $marketx = "Whatsapp Official";
      }else{
        $marketx = $market;
      }

      $getData = $this->home->get_penjualan_hari_ini_by_market($market);

      foreach($getData as $u){
        //$market = $u->buy_in;
        $getSTD  = $this->home->penj_by_sosmed_dan_mp_all_price_calc_by_std($market);
        $getSTY  = $this->home->penj_by_sosmed_dan_mp_all_price_calc_by_sty($market);

        // value pasang & turn over
        $pasang   = $u->jual_pasang;
        $pasangx   += $u->jual_pasang;
        $turnover   = $u->turn_over;
        $turnoverx += $u->turn_over;
        //if($pasang == 0 || $turnover == 0){
        //  $a_pasang = 0;
        //}else{
        //  $a_pasang = $turnover/$pasang;
        //}
        // STD
        $pasang_std   = $getSTD['jual_pasang_std'];
        $pasang_stdx   += $getSTD['jual_pasang_std'];
        $turnover_std   = $getSTD['turn_over_std'];
        $turnover_stdx += $getSTD['turn_over_std'];
        //if($pasang_std == 0 || $turnover_std == 0){
        //  $a_std = 0;
        //}else{
        //  $a_std = ($turnover+$turnover_std)/($pasang+$pasang_std);
        //}
        // STY
        $pasang_sty   = $getSTY['jual_pasang_sty'];
        $pasang_styx   += $getSTY['jual_pasang_sty'];
        $turnover_sty   = $getSTY['turn_over_sty'];
        $turnover_styx += $getSTY['turn_over_sty'];
        //if($pasang_sty == 0 || $turnover_sty == 0){
        //  $a_sty = 0;
        //}else{
        //  $a_sty = (($turnover+$getSTD['turn_over_std'])+$getSTY['turn_over_sty'])/(($pasang+$getSTD['jual_pasang_std'])+$getSTY['jual_pasang_sty']);
        //}

        //$message_text[] = $market."\n-------\n";
        
        if($turnover != 0 && $pasang != 0){
            $tp = round(($turnover/$pasang),2);
            $tp1 = round(($turnover+$turnover_std)/($pasang+$pasang_std));
            $tp2 = round((($turnover+$turnover_std)+$turnover_sty)/(($pasang+$pasang_std)+$pasang_sty));
        }else{
            $tp = 0;
            $tp1 = 0;
            $tp2 = 0;
        }
        
        $message_text[] = 
        $marketx." ".$pasang."-".number_format($turnover,0,".",",")." A:".$tp." STD= ".($pasang+$pasang_std)."-".number_format(($turnover+$turnover_std),0,".",",")." A:".$tp1." STY= ".(($pasang+$pasang_std)+$pasang_sty)."-".number_format(($turnover+$turnover_std)+$turnover_sty,0,".",",")." A:".$tp2."\n---------------------------\n";
      }
    }
    
    // print_r($message_text);
    // return false;
    
    if($turnoverx != 0 && $pasangx != 0){
            $tp = round($turnoverx/$pasangx);
            $tp1 = round(($turnoverx+$turnover_stdx)/($pasangx+$pasang_stdx));
            $tp2 = round((($turnoverx+$turnover_stdx)+$turnover_styx)/(($pasangx+$pasang_stdx)+$pasang_styx));
        }else{
            $tp = 0;
            $tp1 = 0;
            $tp2 = 0;
        }
    
    $totalseluruhmarketplace[] = "*GRAND TOTAL E-COMMERCE*\n ".$pasangx."-".number_format($turnoverx,0,".",",")." A:".$tp." STD= ".($pasangx+$pasang_stdx)."-".number_format(($turnoverx+$turnover_stdx),0,".",",")." A:".$tp1." STY= ".(($pasangx+$pasang_stdx)+$pasang_styx)."-".number_format(($turnoverx+$turnover_stdx)+$turnover_styx,0,".",",")." A:".$tp2."\n---------------------------\n";

    $totalseluruhmarketplacex = implode('', $totalseluruhmarketplace);
    $messagex = implode('', $message_text);
    $message_textx = "".$judul."\n".$messagex."\n".$totalseluruhmarketplacex; //%0A

    $TOKEN  = "1279929527:AAEE_nTqzu9zkTOo51TiuBvh2m49oYM0U6E"; 
    $chatid = "-468150997";//for testing on bot only"820509510"; 
    // ----------- code -------------

    $method = "sendMessage";
    $url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
    $post = [
     'chat_id' => $chatid,
     'parse_mode' => 'Markdown', // aktifkan ini jika ingin menggunakan format type HTML, bisa juga diganti menjadi Markdown
     'text' => $message_textx
    ];

    $header = [
     "X-Requested-With: XMLHttpRequest",
     "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36" 
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_REFERER, $refer);
    //curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post );   
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $datas = curl_exec($ch);
    $error = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);


    $debug['text'] = $message_textx;
    $debug['code'] = $status;
    $debug['status'] = $error;
    $debug['respon'] = json_decode($datas, true);

    //print_r($debug);
  }

}
