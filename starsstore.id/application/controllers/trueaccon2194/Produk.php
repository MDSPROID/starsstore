<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller { 
  private $filename_import = "import_data_upload";
  private $fileupload = "Template_Upload_Produk_Starsstore";

  function __construct(){ 
    parent::__construct();
    $this->load->model('sec47logaccess/produk_adm'); 
    $this->data['id'] = $this->session->userdata('id');
    $this->load->library(array('upload','encrypt'));
    $this->data['username'] = $this->session->userdata('username'); 
    if($this->session->userdata('log_access') != "TRUE_OK_1"){
      redirect(base_url());
    }    
  }  
  
  function index(){ // get data produk in list data
    $tong['tong'] = $this->produk_adm->get_list_produk_tong_sampah();
    $success = array( 'error' => '', 'success' => '');
    //$list_data['get_list'] = $this->produk_adm->get_list_produk();
    $ukuran['ukuran'] = $this->produk_adm->get_list_size();
    $ukuran['color'] = $this->produk_adm->get_list_color();
    $ukuran['kategori'] = $this->produk_adm->get_kategori();
    $data = array_merge($success,$tong,$ukuran);
    $this->load->view('manage/header');
    $this->load->view('manage/produk/index', $data);
    $this->load->view('manage/footer');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Produk'); 
  }

  function settingsyncstok(){
    $status_filtering   = $this->security->xss_clean($this->input->post('st'));
    $status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$status_filtering);

    //simpan statusfreeongkir
    if($status == "on"){
      $statusx = "on";
    }else{
      $statusx = "";
    }
    $settingstatus = array(
      'aktif'     => $statusx,
      'diubah_oleh' => $this->data['id'],
      'diubah_tgl'  => date('Y-m-d H:i:s'),
    );
    $this->db->where('nama','sync_stok_produk');
    $this->db->update('setting',$settingstatus);
  }
 
  function produk_analisis(){
    $data['tong']     = $this->produk_adm->get_list_produk_tong_sampah();
    $data['get_list'] = $this->produk_adm->get_list_produk_for_new_table();
    $this->load->view('manage/header');
    $this->load->view('manage/produk/produk_analisis', $data);
    $this->load->view('manage/footer');
  }

  function load_produk_serverside(){
    $list_data = $this->produk_adm->get_datatables();//get_list_produk();
    //$dx = json_encode($list_data, true);
    $data = array();
    $no = $_POST['start'];
    foreach($list_data as $x){
      $no++;
      $row = array();

      // ID & SKU
      $idp = $x->id_produk;
      $skup = $x->sku_produk;

      // HARGA
      if($x->harga_dicoret == 0 || empty($x->harga_dicoret)){ 
        $harga = "Rp. ".number_format($x->harga_fix,0,".",".")."";
      }else{
        $harga = "<s style='color:#989898 ;'>Rp. ".number_format($x->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($x->harga_fix,0,".",".")."</span> <label class='label-diskon' style='margin-left:5px;'>".round(($x->harga_dicoret - $x->harga_fix) / $x->harga_dicoret * 100)." %</label>";
      }
      // END HARGA

      // STATUS LABEL
      if($x->status == "on"){
        $stx = "<label style='top:7px;position:relative;' class='label label-success'>Aktif</label>";
      }else{
        $stx = "<label style='top:7px;position:relative;' class='label label-danger'>Tidak aktif</label>";
      }
      // END STATUS LABEL

      // stok global (baru)
      if($x->stok_global == ""){
        $stok_global = 0;
      }else{
        $stok_global = $x->stok_global;
      }

      // jumlah gambar tambahan *NEW

      $getGB = $this->produk_adm->get_gbdata($skup);
      //if($getGB['totalgambar'] > 0){
      $jumlahgambar = $getGB['totalgambar'];
      //}else{
      //  $jumlahgambar = 0;
      //}

      // warna
      $idprodukforcolor = $x->id_produk;
      $warna =  $this->produk_adm->get_color_list($idprodukforcolor);

      // last check stok // NEW
      if($x->last_check_stok == "0000-00-00" ){
        $last_check_stok =  " - ";
      }else{
        $last_check_stok = date("d/m/y",strtotime($x->last_check_stok));
      }

      $id = $this->encrypt->encode($x->id_produk);  
      $idx = base64_encode($id);
      $row[] = date('d/m/y', strtotime($x->tgl_dibuat));
      $row[] = "<img src='".$x->gambar."' height='70' onError='this.onerror=null;this.src='".base_url('assets/images/produk/default.jpg')."'><br>".$stx."<br> <label style='top:18px;position:relative;' class='label label-primary'>".$x->kategori." - ".$x->parent_kategori."</label><br><br>Total Gambar : ".$jumlahgambar;
      $row[] = "<a target='_new' href='".base_url('trueaccon2194/produk/edit_data/'.$idx.'')."'>".$x->nama_produk."</a>";
      $row[] = "<center><a href='javscript:void(0);' onclick='uploadanyimage(".$x->id_produk.");'>".$x->artikel."<br><img src='".$x->logo."' height='50' onError='this.onerror=null;this.src='".base_url('assets/images/produk/default.jpg')."'><br><br><label class='label label-default' style='font-size:12px;'><b>Warna : ".$warna['opsi_color']."</b></label></center>";
      $row[] = $stok_global." Psg<br><span style='font-size:12px;'>Last Cek :<br>".$last_check_stok."</span>";
      $row[] = $harga;

// STOK 20
          $r20 = $this->produk_adm->get_list_produk_for_option_size20($idp);  
          if($r20['stok'] == 0 || $r20['stok'] == ""){
            $row20 = "";
          }else if($r20['stok'] <= 5){
              $row20 = "<label class='btn btn-danger'>".$r20['stok']."</label>";
            }else if($r20['stok'] <= 10){
              $row20 = "<label class='btn btn-warning'>".$r20['stok']."</label>";
            }else if($r20['stok'] <= 30){
              $row20 = "<label class='btn btn-primary'>".$r20['stok']."</label>";
            }else if($r20['stok'] > 30){
              $row20 = "<label class='btn btn-success'>".$r20['stok']."</label>";
            }
            $row[] = $row20;
// STOK 21
            $r21 = $this->produk_adm->get_list_produk_for_option_size21($idp);  
            if($r21['stok'] == 0 || $r21['stok'] == ""){
            $row21 = "";
          }else if($r21['stok'] <= 5){
              $row21 = "<label class='btn btn-danger'>".$r21['stok']."</label>";
            }else if($r21['stok'] <= 10){
              $row21 = "<label class='btn btn-warning'>".$r21['stok']."</label>";
            }else if($r21['stok'] <= 30){
              $row21 = "<label class='btn btn-primary'>".$r21['stok']."</label>";
            }else if($r21['stok'] > 30){
              $row21 = "<label class='btn btn-success'>".$r21['stok']."</label>";
            }
            $row[] = $row21;
// STOK 22
            $r22 = $this->produk_adm->get_list_produk_for_option_size22($idp);  
            if($r22['stok'] == 0 || $r22['stok'] == ""){
            $row22 = "";
          }else if($r22['stok'] <= 5){
              $row22 = "<label class='btn btn-danger'>".$r22['stok']."</label>";
            }else if($r22['stok'] <= 10){
              $row22 = "<label class='btn btn-warning'>".$r22['stok']."</label>";
            }else if($r22['stok'] <= 30){
              $row22 = "<label class='btn btn-primary'>".$r22['stok']."</label>";
            }else if($r22['stok'] > 30){
              $row22 = "<label class='btn btn-success'>".$r22['stok']."</label>";
            }
            $row[] = $row21;
// STOK 23
      $r23 = $this->produk_adm->get_list_produk_for_option_size23($idp);  
            if($r23['stok'] == 0 || $r23['stok'] == ""){
            $row23 = "";
          }else if($r23['stok'] <= 5){
              $row23 = "<label class='btn btn-danger'>".$r23['stok']."</label>";
            }else if($r23['stok'] <= 10){
              $row23 = "<label class='btn btn-warning'>".$r23['stok']."</label>";
            }else if($r23['stok'] <= 30){
              $row23 = "<label class='btn btn-primary'>".$r23['stok']."</label>";
            }else if($r23['stok'] > 30){
              $row23 = "<label class='btn btn-success'>".$r23['stok']."</label>";
            }
            $row[] = $row23;
// STOK 24
            $r24 = $this->produk_adm->get_list_produk_for_option_size24($idp);  
            if($r24['stok'] == 0 || $r24['stok'] == ""){
              $row24 = "";
            }else if($r24['stok'] <= 5){
              $row24 = "<label class='btn btn-danger'>".$r24['stok']."</label>";
            }else if($r24['stok'] <= 10){
              $row24 = "<label class='btn btn-warning'>".$r24['stok']."</label>";
            }else if($r24['stok'] <= 30){
              $row24 = "<label class='btn btn-primary'>".$r24['stok']."</label>";
            }else if($r24['stok'] > 30){
              $row24 = "<label class='btn btn-success'>".$r24['stok']."</label>";
            }
            $row[] = $row24;
// STOK 25
            $r25 = $this->produk_adm->get_list_produk_for_option_size25($idp);  
            if($r25['stok'] == 0 || $r25['stok'] == ""){
              $row25 = "";
            }else if($r25['stok'] <= 5){
              $row25 = "<label class='btn btn-danger'>".$r25['stok']."</label>";
            }else if($r25['stok'] <= 10){
              $row25 = "<label class='btn btn-warning'>".$r25['stok']."</label>";
            }else if($r25['stok'] <= 30){
              $row25 = "<label class='btn btn-primary'>".$r25['stok']."</label>";
            }else if($r25['stok'] > 30){
              $row25 = "<label class='btn btn-success'>".$r25['stok']."</label>";
            }
            $row[] = $row25;
// STOK 26
            $r26 = $this->produk_adm->get_list_produk_for_option_size26($idp);  
            if($r26['stok'] == 0 || $r26['stok'] == ""){
              $row26 = "";
            }else if($r26['stok'] <= 5){
              $row26 = "<label class='btn btn-danger'>".$r26['stok']."</label>";
            }else if($r26['stok'] <= 10){
              $row26 = "<label class='btn btn-warning'>".$r26['stok']."</label>";
            }else if($r26['stok'] <= 30){
              $row26 = "<label class='btn btn-primary'>".$r26['stok']."</label>";
            }else if($r26['stok'] > 30){
              $row26 = "<label class='btn btn-success'>".$r26['stok']."</label>";
            }
            $row[] = $row26;
// STOK 27
            $r27 = $this->produk_adm->get_list_produk_for_option_size27($idp);  
            if($r27['stok'] == 0 || $r27['stok'] == ""){
              $row27 = "";
            }else if($r27['stok'] <= 5){
              $row27 = "<label class='btn btn-danger'>".$r27['stok']."</label>";
            }else if($r27['stok'] <= 10){
              $row27 = "<label class='btn btn-warning'>".$r27['stok']."</label>";
            }else if($r27['stok'] <= 30){
              $row27 = "<label class='btn btn-primary'>".$r27['stok']."</label>";
            }else if($r27['stok'] > 30){
              $row27 = "<label class='btn btn-success'>".$r27['stok']."</label>";
            }
            $row[] = $row27;
// STOK 28
            $r28 = $this->produk_adm->get_list_produk_for_option_size28($idp);  
            if($r28['stok'] == 0 || $r28['stok'] == ""){
              $row28 = "";
            }else if($r28['stok'] <= 5){
              $row28 = "<label class='btn btn-danger'>".$r28['stok']."</label>";
            }else if($r28['stok'] <= 10){
              $row28 = "<label class='btn btn-warning'>".$r28['stok']."</label>";
            }else if($r28['stok'] <= 30){
              $row28 = "<label class='btn btn-primary'>".$r28['stok']."</label>";
            }else if($r28['stok'] > 30){
              $row28 = "<label class='btn btn-success'>".$r28['stok']."</label>";
            }
            $row[] = $row28;
// STOK 29
            $r29 = $this->produk_adm->get_list_produk_for_option_size29($idp);  
            if($r29['stok'] == 0 || $r29['stok'] == ""){
              $row29 = "";
            }else if($r29['stok'] <= 5){
              $row29 = "<label class='btn btn-danger'>".$r29['stok']."</label>";
            }else if($r29['stok'] <= 10){
              $row29 = "<label class='btn btn-warning'>".$r29['stok']."</label>";
            }else if($r29['stok'] <= 30){
              $row29 = "<label class='btn btn-primary'>".$r29['stok']."</label>";
            }else if($r29['stok'] > 30){
              $row29 = "<label class='btn btn-success'>".$r29['stok']."</label>";
            }
            $row[] = $row29;
// STOK 30
            $r30 = $this->produk_adm->get_list_produk_for_option_size30($idp);  
            if($r30['stok'] == 0 || $r30['stok'] == ""){
              $row30 = "";
            }else if($r30['stok'] <= 5){
              $row30 = "<label class='btn btn-danger'>".$r30['stok']."</label>";
            }else if($r30['stok'] <= 10){
              $row30 = "<label class='btn btn-warning'>".$r30['stok']."</label>";
            }else if($r30['stok'] <= 30){
              $row30 = "<label class='btn btn-primary'>".$r30['stok']."</label>";
            }else if($r30['stok'] > 30){
              $row30 = "<label class='btn btn-success'>".$r30['stok']."</label>";
            }
            $row[] = $row30;
// STOK 31
            $r31 = $this->produk_adm->get_list_produk_for_option_size31($idp);  
            if($r31['stok'] == 0 || $r31['stok'] == ""){
              $row31 = "";
            }else if($r31['stok'] <= 5){
              $row31 = "<label class='btn btn-danger'>".$r31['stok']."</label>";
            }else if($r31['stok'] <= 10){
              $row31 = "<label class='btn btn-warning'>".$r31['stok']."</label>";
            }else if($r31['stok'] <= 30){
              $row31 = "<label class='btn btn-primary'>".$r31['stok']."</label>";
            }else if($r31['stok'] > 30){
              $row31 = "<label class='btn btn-success'>".$r31['stok']."</label>";
            }
            $row[] = $row31;
// STOK 32
            $r32 = $this->produk_adm->get_list_produk_for_option_size32($idp);  
            if($r32['stok'] == 0 || $r32['stok'] == ""){
              $row32 = "";
            }else if($r32['stok'] <= 5){
              $row32 = "<label class='btn btn-danger'>".$r32['stok']."</label>";
            }else if($r32['stok'] <= 10){
              $row32 = "<label class='btn btn-warning'>".$r32['stok']."</label>";
            }else if($r32['stok'] <= 30){
              $row32 = "<label class='btn btn-primary'>".$r32['stok']."</label>";
            }else if($r32['stok'] > 30){
              $row32 = "<label class='btn btn-success'>".$r32['stok']."</label>";
            }
            $row[] = $row32;
// STOK 33
            $r33 = $this->produk_adm->get_list_produk_for_option_size33($idp);  
            if($r33['stok'] == 0 || $r33['stok'] == ""){
              $row33 = "";
            }else if($r33['stok'] <= 5){
              $row33 = "<label class='btn btn-danger'>".$r33['stok']."</label>";
            }else if($r33['stok'] <= 10){
              $row33 = "<label class='btn btn-warning'>".$r33['stok']."</label>";
            }else if($r33['stok'] <= 30){
              $row33 = "<label class='btn btn-primary'>".$r33['stok']."</label>";
            }else if($r33['stok'] > 30){
              $row33 = "<label class='btn btn-success'>".$r33['stok']."</label>";
            }
            $row[] = $row33;
// STOK 34
            $r34 = $this->produk_adm->get_list_produk_for_option_size34($idp);  
            if($r34['stok'] == 0 || $r34['stok'] == ""){
              $row34 = "";
            }else if($r34['stok'] <= 5){
              $row34 = "<label class='btn btn-danger'>".$r34['stok']."</label>";
            }else if($r34['stok'] <= 10){
              $row34 = "<label class='btn btn-warning'>".$r34['stok']."</label>";
            }else if($r34['stok'] <= 30){
              $row34 = "<label class='btn btn-primary'>".$r34['stok']."</label>";
            }else if($r34['stok'] > 30){
              $row34 = "<label class='btn btn-success'>".$r34['stok']."</label>";
            }
            $row[] = $row34;
// STOK 35
            $r35 = $this->produk_adm->get_list_produk_for_option_size35($idp);  
            if($r35['stok'] == 0 || $r35['stok'] == ""){
              $row35 = "";
            }else if($r35['stok'] <= 5){
              $row35 = "<label class='btn btn-danger'>".$r35['stok']."</label>";
            }else if($r35['stok'] <= 10){
              $row35 = "<label class='btn btn-warning'>".$r35['stok']."</label>";
            }else if($r35['stok'] <= 30){
              $row35 = "<label class='btn btn-primary'>".$r35['stok']."</label>";
            }else if($r35['stok'] > 30){
              $row35 = "<label class='btn btn-success'>".$r35['stok']."</label>";
            }
            $row[] = $row35;
// STOK 36
            $r36 = $this->produk_adm->get_list_produk_for_option_size36($idp);  
            if($r36['stok'] == 0 || $r36['stok'] == ""){
              $row36 = "";
            }else if($r36['stok'] <= 5){
              $row36 = "<label class='btn btn-danger'>".$r36['stok']."</label>";
            }else if($r36['stok'] <= 10){
              $row36 = "<label class='btn btn-warning'>".$r36['stok']."</label>";
            }else if($r36['stok'] <= 30){
              $row36 = "<label class='btn btn-primary'>".$r36['stok']."</label>";
            }else if($r36['stok'] > 30){
              $row36 = "<label class='btn btn-success'>".$r36['stok']."</label>";
            }
            $row[] = $row36;
// STOK 37
            $r37 = $this->produk_adm->get_list_produk_for_option_size37($idp);  
            if($r37['stok'] == 0 || $r37['stok'] == ""){
              $row37 = "";
            }else if($r37['stok'] <= 5){
              $row37 = "<label class='btn btn-danger'>".$r37['stok']."</label>";
            }else if($r37['stok'] <= 10){
              $row37 = "<label class='btn btn-warning'>".$r37['stok']."</label>";
            }else if($r37['stok'] <= 30){
              $row37 = "<label class='btn btn-primary'>".$r37['stok']."</label>";
            }else if($r37['stok'] > 30){
              $row37 = "<label class='btn btn-success'>".$r37['stok']."</label>";
            }
            $row[] = $row37;
// STOK 38
            $r38 = $this->produk_adm->get_list_produk_for_option_size38($idp);  
            if($r38['stok'] == 0 || $r38['stok'] == ""){
              $row38 = "";
            }else if($r38['stok'] <= 5){
              $row38 = "<label class='btn btn-danger'>".$r38['stok']."</label>";
            }else if($r38['stok'] <= 10){
              $row38 = "<label class='btn btn-warning'>".$r38['stok']."</label>";
            }else if($r38['stok'] <= 30){
              $row38 = "<label class='btn btn-primary'>".$r38['stok']."</label>";
            }else if($r38['stok'] > 30){
              $row38 = "<label class='btn btn-success'>".$r38['stok']."</label>";
            }
            $row[] = $row38;
// STOK 39
            $r39 = $this->produk_adm->get_list_produk_for_option_size39($idp);  
            if($r39['stok'] == 0 || $r39['stok'] == ""){
              $row39 = "";
            }else if($r39['stok'] <= 5){
              $row39 = "<label class='btn btn-danger'>".$r39['stok']."</label>";
            }else if($r39['stok'] <= 10){
              $row39 = "<label class='btn btn-warning'>".$r39['stok']."</label>";
            }else if($r39['stok'] <= 30){
              $row39 = "<label class='btn btn-primary'>".$r39['stok']."</label>";
            }else if($r39['stok'] > 30){
              $row39 = "<label class='btn btn-success'>".$r39['stok']."</label>";
            }
            $row[] = $row39;
// STOK 40
            $r40 = $this->produk_adm->get_list_produk_for_option_size40($idp);  
            if($r40['stok'] == 0 || $r40['stok'] == ""){
              $row40 = "";
            }else if($r40['stok'] <= 5){
              $row40 = "<label class='btn btn-danger'>".$r40['stok']."</label>";
            }else if($r40['stok'] <= 10){
              $row40 = "<label class='btn btn-warning'>".$r40['stok']."</label>";
            }else if($r40['stok'] <= 30){
              $row40 = "<label class='btn btn-primary'>".$r40['stok']."</label>";
            }else if($r40['stok'] > 30){
              $row40 = "<label class='btn btn-success'>".$r40['stok']."</label>";
            }
            $row[] = $row40;
// STOK 41
            $r41 = $this->produk_adm->get_list_produk_for_option_size41($idp);  
            if($r41['stok'] == 0 || $r41['stok'] == ""){
              $row41 = "";
            }else if($r41['stok'] <= 5){
              $row41 = "<label class='btn btn-danger'>".$r41['stok']."</label>";
            }else if($r41['stok'] <= 10){
              $row41 = "<label class='btn btn-warning'>".$r41['stok']."</label>";
            }else if($r41['stok'] <= 30){
              $row41 = "<label class='btn btn-primary'>".$r41['stok']."</label>";
            }else if($r41['stok'] > 30){
              $row41 = "<label class='btn btn-success'>".$r41['stok']."</label>";
            }
            $row[] = $row41;
// STOK 42
            $r42 = $this->produk_adm->get_list_produk_for_option_size42($idp);  
            if($r42['stok'] == 0 || $r42['stok'] == ""){
              $row42 = "";
            }else if($r42['stok'] <= 5){
              $row42 = "<label class='btn btn-danger'>".$r42['stok']."</label>";
            }else if($r42['stok'] <= 10){
              $row42 = "<label class='btn btn-warning'>".$r42['stok']."</label>";
            }else if($r42['stok'] <= 30){
              $row42 = "<label class='btn btn-primary'>".$r42['stok']."</label>";
            }else if($r42['stok'] > 30){
              $row42 = "<label class='btn btn-success'>".$r42['stok']."</label>";
            }
            $row[] = $row42;
// STOK 43
            $r43 = $this->produk_adm->get_list_produk_for_option_size43($idp);  
            if($r43['stok'] == 0 || $r43['stok'] == ""){
              $row43 = "";
            }else if($r43['stok'] <= 5){
              $row43 = "<label class='btn btn-danger'>".$r43['stok']."</label>";
            }else if($r43['stok'] <= 10){
              $row43 = "<label class='btn btn-warning'>".$r43['stok']."</label>";
            }else if($r43['stok'] <= 30){
              $row43 = "<label class='btn btn-primary'>".$r43['stok']."</label>";
            }else if($r43['stok'] > 30){
              $row43 = "<label class='btn btn-success'>".$r43['stok']."</label>";
            }
            $row[] = $row43;
// STOK 44
            $r44 = $this->produk_adm->get_list_produk_for_option_size44($idp);  
            if($r44['stok'] == 0 || $r44['stok'] == ""){
              $row44 = "";
            }else if($r44['stok'] <= 5){
              $row44 = "<label class='btn btn-danger'>".$r44['stok']."</label>";
            }else if($r44['stok'] <= 10){
              $row44 = "<label class='btn btn-warning'>".$r44['stok']."</label>";
            }else if($r44['stok'] <= 30){
              $row44 = "<label class='btn btn-primary'>".$r44['stok']."</label>";
            }else if($r44['stok'] > 30){
              $row44 = "<label class='btn btn-success'>".$r44['stok']."</label>";
            }
            $row[] = $row44;
// STOK 45
            $r45 = $this->produk_adm->get_list_produk_for_option_size45($idp);  
            if($r45['stok'] == 0 || $r45['stok'] == ""){
              $row45 = "";
            }else if($r45['stok'] <= 5){
              $row45 = "<label class='btn btn-danger'>".$r45['stok']."</label>";
            }else if($r45['stok'] <= 10){
              $row45 = "<label class='btn btn-warning'>".$r45['stok']."</label>";
            }else if($r45['stok'] <= 30){
              $row45 = "<label class='btn btn-primary'>".$r45['stok']."</label>";
            }else if($r45['stok'] > 30){
              $row45 = "<label class='btn btn-success'>".$r45['stok']."</label>";
            }
            $row[] = $row45;

// OPSI PRODUK

      if($x->status == "on"){
            $status = "<a style='padding:3px 8px;' href='".base_url('trueaccon2194/produk/off/'.$x->id_produk.'')."' class='btn btn-danger edit'>OFF</a>";
          }else{
            $status = "<a style='padding:3px 8px;' href='".base_url('trueaccon2194/produk/on/'.$x->id_produk.'')."' class='btn btn-success edit'>ON</a>";
          }          
          
          $id = $this->encrypt->encode($x->id_produk); 
          $idx = base64_encode($id);
          // edit
          $edit = "<a target='_new' href='".base_url('trueaccon2194/produk/edit_data/'.$idx.'')."' class='btn btn-warning edit'><i class='glyphicon glyphicon-pencil'></i></a>";
          // remove
          $remove = "<a href='javascript:void(0)'' class='btn btn-danger hapus' data-id='".$idx."' data-name='".$x->nama_produk."' onclick='pindahkan_tong(this);'><i class='glyphicon glyphicon-remove'></i></a>";
          $duplikat = "<a href='".base_url('trueaccon2194/produk/duplikat_data/'.$idx.'')."' class='btn btn-primary'><i class='glyphicon glyphicon-copy'></i></a>";
          
          $row[] = $status.''.$edit.''.$remove.''.$duplikat;

      $data[] = $row;
    }

    $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->produk_adm->count_all(),
            "recordsFiltered" => $this->produk_adm->count_filtered(),
            "data" => $data,
        );
    echo json_encode($output);
  }

  function produk_grouping(){
    $tong['tong'] = $this->produk_adm->get_list_produk_grouping_tong_sampah();
    $success = array( 'error' => '', 'success' => '');
    $list_data['get_list'] = $this->produk_adm->get_list_produk_grouping();
    $data = array_merge($success, $list_data, $tong);
    $this->load->view('manage/header');
    $this->load->view('manage/produk/produk_grouping_index', $data);
    $this->load->view('manage/footer');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Produk Grouping');
  }

  function daftar_grup(){
    $success = array( 'error' => '', 'success' => '');
    $list_data['get_list'] = $this->produk_adm->get_list_grouping();
    $data = array_merge($success, $list_data);
    $this->load->view('manage/header');
    $this->load->view('manage/produk/daftar_grup', $data);
    $this->load->view('manage/footer');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Daftar Group / Group Promo');
  }

  function detail_grup(){
    $idx = $this->security->xss_clean($this->input->get('id'));
    $idxx = base64_decode($idx);
    $id = $this->encrypt->decode($idxx);
    $name = $this->security->xss_clean($this->input->get('name'));
    
    $get = $this->produk_adm->get_produk_grup_show($id);
    $no = 0;
    echo '<ul class="list-unstyled">';
    foreach($get as $r){
      $no++;
      if($r->gambar == ""){
        $gb = base_url('assets/images/default.jpg');
      }else{
        $gb = $r->gambar;
      }

      if($r->harga_dicoret == 0 || empty($r->harga_dicoret)){ 
              $harga_net = "Rp. ".number_format($r->harga_fix,0,".",".")."";
          }else{
              $harga_net = "<s style='color:#989898 ;'>Rp. ".number_format($r->harga_dicoret,0,".",".")."</s> <span>Rp. ".number_format($r->harga_fix,0,".",".")."</span>";
          }
      echo "<li style='height:50px;margin-bottom:10px;'>".$no.".
          <div style='padding-left: 30px;margin-top: -20px;'>
            <h5 style='font-weight:700;margin-top:0;'>
            <img class='img-responsive pull-left' style='display: initial;' src='".$gb."' width='50'>
              <div style='padding-left:60px;'> 
                $r->nama_produk<br> [$r->artikel]<br>Rp. ".$harga_net."
              </div>
            </h5>
                  </div>
                </li>";
    }
    echo "</ul>";
  }

  function edit_daftar_grup($id){
    $idx = base64_decode($id);
    $idxx = $this->encrypt->decode($idx);
    $data['idn'] = $idxx;
    $data['dt'] = $this->produk_adm->get_nama_group($idxx);
    $data['list'] = $this->produk_adm->get_group($idxx);
    
    $this->load->view('manage/header');
    $this->load->view('manage/produk/produk_grouping_manual_edit', $data);
    $this->load->view('manage/footer');
  }

  function manual(){
    $data['list'] = $this->produk_adm->get_list_produk_grouping();
    $this->load->view('manage/header');
    $this->load->view('manage/produk/produk_grouping_manual', $data);
    $this->load->view('manage/footer');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Produk Grouping Manual'); 
  }

  function group_promo(){
    $data['list'] = $this->produk_adm->get_list_produk_grouping();
    $this->load->view('manage/header');
    $this->load->view('manage/produk/produk_grouping_promo', $data);
    $this->load->view('manage/footer');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Produk Group Promo'); 
  }

  function otomatis(){
    $this->load->view('manage/header');
    $this->load->view('manage/produk/produk_grouping_otomatis');
    $this->load->view('manage/footer');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Produk Grouping Otomatis');   
  }

  function create_grouping_manual(){
    $nama = $this->security->xss_clean($this->input->post('name_grup'));
    $gambar = $this->security->xss_clean($this->input->post('gambar'));
    $ket = $this->security->xss_clean($this->input->post('keterangan'));
    $mulai = $this->security->xss_clean($this->input->post('tgl_mulai'));
    $akhir = $this->security->xss_clean($this->input->post('tgl_akhir'));
    $posisi = $this->security->xss_clean($this->input->post('posisi'));
    $produk = $this->security->xss_clean($this->input->post('idproduk'));

    $this->form_validation->set_rules('idproduk[]','Produk', 'required');
    if ($this->form_validation->run() == FALSE){
      $this->session->set_flashdata('error', 'Isi form dengan lengkap'); 
      redirect($this->agent->referrer());
    }else{
      $iduser = $this->data['id'];
      $this->produk_adm->create_group_manual($iduser, $nama, $gambar, $ket, $mulai, $akhir, $posisi, $produk);
    }
    $this->session->set_flashdata('success', 'Anda Berhasil Menambahkan group produk '.$nama.'');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menambahkan Group Produk '.$nama.''); 
    redirect(base_url('trueaccon2194/produk/daftar_grup'));
  }

  function create_grouping_promo(){
    $nama = $this->security->xss_clean($this->input->post('name_grup'));
    $gambar = $this->security->xss_clean($this->input->post('gambar'));
    $ket = $this->security->xss_clean($this->input->post('keterangan'));
    $mulai = $this->security->xss_clean($this->input->post('tgl_mulai'));
    $akhir = $this->security->xss_clean($this->input->post('tgl_akhir'));
    $posisi = $this->security->xss_clean($this->input->post('posisi'));
    $produk = $this->security->xss_clean($this->input->post('idproduk'));
    $diskon = $this->security->xss_clean($this->input->post('diskon'));

    $this->form_validation->set_rules('idproduk[]','Produk', 'required');
    if ($this->form_validation->run() == FALSE){
      $this->session->set_flashdata('error', 'Isi form dengan lengkap'); 
      redirect($this->agent->referrer());
    }else{
      $iduser = $this->data['id'];
      $this->produk_adm->create_group_promo($iduser, $nama, $gambar, $ket, $mulai, $akhir, $posisi, $produk);

      // diskon masal produk yang dicentang
      $count = count($produk);
      for($i=0; $i<$count; $i++) {
        
        $produkx = $this->db->get_where('produk_get_color',array('id_produk_optional'=>$produk[$i]));
        $hasil    = $produkx->row();
        $harga_fix  = $hasil->harga_fix; 

        $data_produk = array(
          'id_produk_optional' => $produk[$i],
          'harga_dicoret'   => $harga_fix,
          'harga_fix'       => $harga_fix - ($harga_fix * $diskon / 100),
        );

        $this->db->where('id_produk_optional', $produk[$i]);
        $this->db->update('produk_get_color', $data_produk);
      }

    }
    $this->session->set_flashdata('success', 'Anda Berhasil Menambahkan group produk '.$nama.'');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menambahkan Group Promo '.$nama.''); 
    redirect(base_url('trueaccon2194/produk/daftar_grup'));
  }

  function create_grouping_otomatis(){
    $low = $this->security->xss_clean($this->input->post('lowprice'));
    $high = $this->security->xss_clean($this->input->post('highprice'));
    $gambar = $this->security->xss_clean($this->input->post('gambar'));
    $posisi = $this->security->xss_clean($this->input->post('posisi'));

    $this->form_validation->set_rules('lowprice[]','Produk', 'required');
    $this->form_validation->set_rules('highprice[]','Produk', 'required');
    $this->form_validation->set_rules('gambar[]','Produk', 'required');
    $this->form_validation->set_rules('posisi[]','Produk', 'required');

    if ($this->form_validation->run() == FALSE){
      $this->session->set_flashdata('error', 'Isi form dengan lengkap');
      redirect($this->agent->referrer());
    }else{
      $iduser = $this->data['id'];
      // mencari produk dengan kisaran harga
      $count = count($low);
      for($i=0; $i<$count; $i++) {
        $nm = 'Grup Produk Kisaran Rp.'.$low[$i].' - Rp.'.$high[$i].'';
        $sl1 = $nm;
        $sl2 = strtolower($sl1);
        $sl3 = str_replace(' ','-',$sl2);

        //buat group produk
        $data_grup = array(
          'name_group'  => 'Grup Produk Kisaran Rp.'.$low[$i].' - Rp.'.$high[$i].'',
          'slug'      => $sl3,
          'gambar'    => $gambar[$i],
          'status'    => 'on',
          'posisi'    => $posisi[$i],
          'user_buat'   => $iduser,
          'dibuat'    => date('Y-m-d'),
        );
        $this->db->insert('produk_group_name', $data_grup);

        $insert_id = $this->db->insert_id();

        $getProduk = $this->produk_adm->getRange($low[$i], $high[$i]);
        foreach($getProduk as $h){
          $data_produk = array(
                  'id_group_name'   => $insert_id,
                  'id_produk_group'   => $h->id_produk,
              );
          
              $this->db->insert('produk_group', $data_produk);
              
              //$tandai = array(
              //  'grup' => 'aktif',
              //);
              //$this->db->where('id_produk', $h->id_produk);
              //$this->db->update('produk_grouping', $tandai);
        }
        log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menambahkan Group Produk Otomatis Kisaran Harga Rp.'.$low[$i].' - Rp.'.$high[$i].''); 
      }
    }
    $this->session->set_flashdata('success', 'Group produk Otomatis ditambahkan');
    redirect(base_url('trueaccon2194/produk/daftar_grup'));
  }

  function update_grouping_manual(){
    $idgroup = $this->security->xss_clean($this->input->post('idg'));
    $nama = $this->security->xss_clean($this->input->post('name_grup'));
    $gambar = $this->security->xss_clean($this->input->post('gambar'));
    $ket = $this->security->xss_clean($this->input->post('keterangan'));
    $mulai = $this->security->xss_clean($this->input->post('tgl_mulai'));
    $akhir = $this->security->xss_clean($this->input->post('tgl_akhir'));
    $posisi = $this->security->xss_clean($this->input->post('posisi'));
    $produk = $this->security->xss_clean($this->input->post('idproduk'));
    $status = $this->security->xss_clean($this->input->post('status'));

    $this->form_validation->set_rules('idproduk[]','Produk', 'required');
    if ($this->form_validation->run() == FALSE){
      $this->session->set_flashdata('error', 'Isi form dengan lengkap');
      redirect($this->agent->referrer());
    }else{
      $iduser = $this->data['id'];
      $this->produk_adm->update_group_manual($iduser, $idgroup, $nama, $gambar, $ket, $mulai, $akhir, $posisi, $produk, $status);
    }
    $this->session->set_flashdata('success', 'Group produk '.$nama.' Berhasil diubah.');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Group Produk '.$nama.'');  
    redirect(base_url('trueaccon2194/produk/daftar_grup'));
  }

  function off_group($idgroup){ // off status produk
    $this->produk_adm->off_group($idgroup);
    $this->session->set_flashdata('error', 'Group dinonaktifkan!');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menonaktifkan ID Group Produk ('.$idgroup.')');
    redirect($this->agent->referrer());
  }

  function on_group($idgroup){ // on status produk
    $this->produk_adm->on_group($idgroup);
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Mengaktifkan ID Group Produk ('.$idgroup.')');
    $this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Group diaktifkan!');
    redirect($this->agent->referrer());
  }

  function hapus_group($idgroup){ // hapus produk

    // get nama grup
    $t = $this->produk_adm->get_namegroup($idgroup);
    $nama = $t['name_group'];

    $r = $this->produk_adm->get_produkyangdigrup($idgroup);
    foreach($r as $t){
      $idprodukdarigrup[] = $t->id_produk_group;
    }

    $this->produk_adm->hapus_group($idgroup, $idprodukdarigrup);
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Group Produk ('.$nama.')');
    $this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Group dihapus!');
    redirect($this->agent->referrer());
  }

  function export_excel_group($id){
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

    $objPHPExcel = new PHPExcel();
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
      $style_col = array(
        'font' => array('bold' => true), // Set font nya jadi bold
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );
      // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
      $style_row = array(
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );

      // Create a first sheet, representing sales data
    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "GRUP PRODUK"); // Set kolom A1 dengan tulisan "DATA SISWA"
    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('GRUP PRODUK');

      $objPHPExcel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
      

      $grup = $this->produk_adm->get_grup_all($id);
    foreach($grup as $g){
      // id grup
      $idgrup = $id;
      // nama group
      $nama_grup = $g->name_group;
      // hitung
      $data_produk1 = $this->produk_adm->data_produk_by_id_group($idgrup);
        //table header
      $objPHPExcel->getActiveSheet()->setCellValue('A3',$g->name_group,'('.$data_produk1->num_rows().')');
      $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
      $heading = array("NAMA PROJECT","ARTIKEL","HARGA AWAL","HARGA NET","DISKON (%)");
          //loop heading
          $rowNumberH = 4;
        $colH = 'A';
        foreach($heading as $h){
            $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
            $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
            $colH++;    
        }

      $data_produk = $this->produk_adm->data_produk_by_id_group($idgrup);

        $baris = 5;
        foreach($data_produk->result() as $data){

          if($data->harga_dicoret == "" || $data->harga_dicoret == 0){
              $harga_awal = 0;
              $harga_net = $data->harga_fix;
              $diskon = 0;
            }else{
              $harga_awal = $data->harga_dicoret;
              $harga_net = $data->harga_fix;
              $diskon = round(($data->harga_dicoret - $data->harga_fix) / $data->harga_dicoret * 100);
            }

            //pemanggilan sesuaikan dengan nama kolom tabel
            $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $data->nama_produk); // NAMA PRODUK
            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $data->artikel); // ARTIKEL
            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $harga_awal); // HARGA RETAIL / SEBELUM DISKON
            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $harga_net); // HARGA NET
            $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $diskon); // DISKON
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
            $baris++;
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
          $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
          $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
          $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
          $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
          }
          // Redirect output to a client’s web browser (Excel5)
      $filename = urlencode("Grup Produk ".$nama_grup.".xls");
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');
      $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save('php://output');
          log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Grup Produk (Excel) '.$nama_grup.' ');

        }
  }
  function searchart(){
    // tangkap variabel keyword dari URL
    $keyword = $this->uri->segment(4);

    // cari di database
    $data = $this->produk_adm->cariDataartikel($keyword);

    // format keluaran di dalam array
    if($data->num_rows() == 0){
      $arr['query'] = $keyword;
      $arr['suggestions'][] = array(
        'value' => 'Tidak ada hasil',
        'artikel' => 'Tidak ada hasil', 
      );
    }
    foreach($data->result() as $row)
    {
      $arr['query'] = $keyword;
      $arr['suggestions'][] = array(
        'value' => $row->art_id,
        'artikel' => $row->art_id,
      );
    }
    // minimal PHP 5.2
    echo json_encode($arr);
  }

  function daftar_produk_dinonaktifkan_sistem(){
    //$data['produk'] = $this->produk_adm->get_produk_dump();
    $this->load->view('manage/header');
    $this->load->view('manage/produk/produk_dump');
    $this->load->view('manage/footer');
  }

  function load_produk_dump(){
    $list_data = $this->produk_adm->get_datatables_dump();//get_list_produk();
    //$dx = json_encode($list_data, true);
    $data = array();
    $no = $_POST['start'];
    foreach($list_data as $x){
      $no++;
      $row = array();

      $id = $this->encrypt->encode($x->id_produk); 
      $idx = base64_encode($id);
      $row[] = "<img src='".$x->gambar."' height='70' onError='this.onerror=null;this.src='".base_url('assets/images/produk/default.jpg')."'>";
      $row[] = "<a href='".base_url('trueaccon2194/produk/edit_data/'.$idx.'')."'>".$x->nama_produk."</a>";
      $row[] = $x->artikel;
      $row[] = $x->stok_terakhir;
      $row[] = date("d F Y H:i:s", strtotime($x->tgl_input));

      $data[] = $row;
    }

    $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->produk_adm->count_all_dump(),
            "recordsFiltered" => $this->produk_adm->count_filtered_dump(),
            "data" => $data,
        );
    echo json_encode($output);
  }

  // MENU TAMBAH PRODUK SYNC DATA KE RIM MENGGUNAKAN TABLE PRODUK_ALL_STOK DINONAKTIFKAN
  // TABLENYA DIBUAT STOK PRODUK AKTIF SAJA
  function tambahproduksyncrim(){
    $lmt = $this->security->xss_clean($this->input->post('lmt'));
     echo  '<span class="pull-right" style="font-size:20px;font-weight:bold;color:red;cursor:pointer;" onclick="closecekStok();">X</span>
          <div id="cetakareacekstok" style="margin-bottom:20px;text-align:left;" class="table-responsive">
            <center><b style="font-size:20px;text-align:center;">Produk Baru Layak Jual (Stok > 700)</b><br>
              <div class="print">
                <a href="javascript:void(0);" id="cek" onclick="lihatRiwayat();">[ riwayat pengecekkan ]</a> <span id="tutupcek" style="display:none;">[ <a href="javascript:void(0);" onclick="tutupRiwayat();">Tutup riwayat</a> | <a href="javascript:void(0);" onclick="hapusRiwayat();">Hapus riwayat</a> ]</span>
              </div>
            </center><br><br>
            <div id="riwayatcek"></div>
            <div id="reportcesktok">';

      $cekartikeldata = $this->produk_adm->get_data_by_art2($lmt);
      $no = 0;
      $dataartikel = "";
      foreach($cekartikeldata as $gh){ // keluarkan data request by random di brgcp
        $no++;
        $artxx = $gh->art;
        $dataartikel[] = $artxx;

        $cekartikeldata2 = $this->produk_adm->get_data_by_art3($artxx); // cek didatabase produk apakah produk sudah ada (status ON)
        if($cekartikeldata2->num_rows() == 0){
          echo '
          <div class="col-md-4 col-xs-12 p-produk'.$no.'" onclick="brproduk(this);" id="x-produk" data-id="'.$no.'" data-st="0" data-produk="'.$artxx.'" style="font-weight:700;margin-top: 0;border:1px solid grey;">
            <img onError="this.onerror=null;this.src="'.base_url('assets/images/produk/default.jpg').'"" class="img-responsive pull-left" style="height:50px;display: initial;" src="'.base_url('assets/images/produk/Rim/'.$artxx.'.jpg').'" width="50">
            <div style="padding-left:60px;">
              <span style="font-size:12px;">'.$gh->art.'</span><br>
              '.$gh->stok.' PSG
            </div>
          </div>
        ';
        //if($no++ === $lmt) break;
        }
        
      }

    echo '</div></div>';
    $guid = json_encode($dataartikel);
    log_helper('cekstokonline', 'Produk Baru Layak Jual : '.$guid.' Limit '.$lmt.'');
  }

  function cekproduksyncrim(){
    echo  '<span class="pull-right" style="font-size:20px;font-weight:bold;color:red;cursor:pointer;" onclick="closecekStok();">X</span>
          <div id="cetakareacekstok" style="margin-bottom:20px;text-align:left;" class="table-responsive">
            <center><b style="font-size:20px;text-align:center;">Produk Aktif Tidak Layak Jual (Stok < 700)</b><br>
              <div class="print">
                <a href="javascript:void(0);" id="cek" onclick="lihatRiwayat();">[ riwayat pengecekkan ]</a> <span id="tutupcek" style="display:none;">[ <a href="javascript:void(0);" onclick="tutupRiwayat();">Tutup riwayat</a> | <a href="javascript:void(0);" onclick="hapusRiwayat();">Hapus riwayat</a> ]</span>
              </div>
            </center><br><br>
            <div id="riwayatcek"></div>
            <div id="reportcesktok">';

    $cekartikeldata = $this->produk_adm->get_data_by_art();
    $no = 0;
    $dataartikel = "";
    foreach($cekartikeldata as $gh){
      $no++;
      $artxx = $gh->artikel;
      if($gh->gambar == ""){
        $gb = base_url('assets/images/default.jpg');
      }else{
        $gb = $gh->gambar;
      }
 
      $curl = curl_init();
      $proxy = '192.168.0.219:80';

      curl_setopt_array($curl, array(
      CURLOPT_URL => "http://sm.stars.co.id/ws/lap_stock.php?api=0x010042602D856FE11654537274084EAA64C036BF6BBB8F985A9D&art_id=".$artxx."",
      //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10, 
      CURLOPT_TIMEOUT => 30,
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

        $totalstok = 0;
        $data = json_decode($response, true);
        for ($l=0; $l < count($data['stock']); $l++){ 
          // total stok masing2 produk 
          $totalstok += $data['stock'][$l]['psg'];

          //$art_id = $data['stock'][$l]['art_id'];
          //$cekartikeldata = $this->produk_adm->get_data_by_art($art_id);
        }

        if($totalstok <= 700){ // jika stok kurang dari atau sama dengan 700 psg maka laporkan ke email admin dan nonaktifkan produk
          $dataartikel[] = $artxx;
          //echo $dataartikel.'Jumlah Stok : '.$totalstok.'<br>';
          echo '
            <div class="col-md-4 col-xs-12 p-produk'.$no.'" onclick="brproduk(this);" id="b-produk" data-id="'.$no.'" data-st="1" data-produk="'.$artxx.'" style="font-weight:700;margin-top: 0;border:1px solid grey;">
              <img onError="this.onerror=null;this.src="'.base_url('assets/images/produk/default.jpg').'"" class="img-responsive pull-left" style="display: initial;" src="'.$gb.'" width="50">
              <div style="padding-left:60px;">
                '.word_limiter($gh->nama_produk,3).'<br><span style="font-size:12px;">'.$gh->artikel.'</span><br>
                '.$totalstok.' PSG
              </div>
            </div>
          ';
        }
    }
    echo '</div></div>';

    $guid = json_encode($dataartikel);
    log_helper('cekstokonline', 'Produk Aktif Tidak Layak Jual : '.$guid.'');
  }

  function cekriwayat(){
    $cek = $this->produk_adm->cek_riwayat();
    $no = 0;
    foreach($cek as $y){
      $no++;

      echo "<div style='background-color:#f9f9f9;border:white;box-shadow:3px 3px 6px 0px #d5d5d5;padding:10px;text-align:left;'> 
              <label class='label label-primary' style='font-weight:bold;font-size14px;margin-right:5px;position: absolute;left: 30px;margin-top: -10px;'>".$no."</label>
              <div style='margin-left:20px;'>
                <b>Tanggal ".date('d F Y H:i:s', strtotime($y->log_time))."</b><br>
                ".$y->log_desc."
              </div>
            </div><br>";
    }
  }

  function hapusriwayat(){
    $this->produk_adm->hapus_riwayat();
  }

  function cekStokbyrims(){
    $data_filtering = $this->security->xss_clean($this->input->post('getinvdata'));
    $datax = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

    $curl = curl_init();
    $proxy = '192.168.0.219:80';

    curl_setopt_array($curl, array(
    CURLOPT_URL => "http://sm.stars.co.id/ws/lap_stock.php?api=0x010042602D856FE11654537274084EAA64C036BF6BBB8F985A9D&art_id=".$datax."",
    //CURL_SETOPT($curl, CURLOPT_PROXY, $proxy),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10, 
    CURLOPT_TIMEOUT => 30,
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
      $data = json_decode($response, true);
      for ($l=0; $l < count($data['stock']); $l++){ 
        $totalstok += $data['stock'][$l]['psg'];
        $totaltoko += count($data['stock'][$l]['str_id']);
      }
      // harga
      $cekharga = $this->produk_adm->syncPrice($datax);

      echo  "<span class='pull-right' style='font-size:20px;font-weight:bold;color:red;cursor:pointer;' onclick='closecekStok();'>X</span><div style='text-align:left;margin-bottom:20px;'>Artikel <b>: ".$datax." - Rp.".number_format($cekharga['retprc'],0,".",".")."</b><br>Total Stok Semua Toko <b>: ".$totalstok." PSG</b><br>Total toko yang memiliki stok <b>: ".$totaltoko." Toko</b></div><div id='reportcesktok' class='table-responsive'>";
      $data = json_decode($response, true);
      $nomor = 0;
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

        $cek = $this->produk_adm->cek_toko($edptoko);
        if($cek['nama_toko'] == ""){
          $namatoko = "[ Unknown Store ]";
        }else{
          $namatoko = $cek['nama_toko'];
        }

        // Inisialisasi Ukuran
        $artxd = explode('-', $datax);
        $lsartx = $artxd[1];
        $lsart = substr($lsartx, 0, $maxword3);
        if($lsart == 0 || $lsart == 1){
          $u1 = "<label class='label label-default' style='font-size:12px;'>15 => ".$data['stock'][$l]['u1']."</label>";
          $u2 = "<label class='label label-default' style='font-size:12px;'>16 => ".$data['stock'][$l]['u2']."</label>";
          $u3 = "<label class='label label-default' style='font-size:12px;'>17 => ".$data['stock'][$l]['u3']."</label>";
          $u4 = "<label class='label label-default' style='font-size:12px;'>18 => ".$data['stock'][$l]['u4']."</label>";
          $u5 = "<label class='label label-default' style='font-size:12px;'>19 => ".$data['stock'][$l]['u5']."</label>";
          $u6 = "<label class='label label-default' style='font-size:12px;'>20 => ".$data['stock'][$l]['u6']."</label>";
          $u7 = "<label class='label label-default' style='font-size:12px;'>21 => ".$data['stock'][$l]['u7']."</label>";
          $u8 = "<label class='label label-default' style='font-size:12px;'>22 => ".$data['stock'][$l]['u8']."</label>";
          $u9 = "<label class='label label-default' style='font-size:12px;'>23 => ".$data['stock'][$l]['u9']."</label>";
          $u10 = "<label class='label label-default' style='font-size:12px;'>24 => ".$data['stock'][$l]['u10']."</label>";
          $u11 = "<label class='label label-default' style='font-size:12px;'>25 => ".$data['stock'][$l]['u11']."</label>";
          $u12 = "<label class='label label-default' style='font-size:12px;'>26 => ".$data['stock'][$l]['u12']."</label>";
          $u13 = "<label class='label label-default' style='font-size:12px;'>27 => ".$data['stock'][$l]['u13']."</label>";
        }else if($lsart == 3){
          $u1 = "<label class='label label-default' style='font-size:12px;'>24 => ".$data['stock'][$l]['u1']."</label>";
          $u2 = "<label class='label label-default' style='font-size:12px;'>25 => ".$data['stock'][$l]['u2']."</label>";
          $u3 = "<label class='label label-default' style='font-size:12px;'>26 => ".$data['stock'][$l]['u3']."</label>";
          $u4 = "<label class='label label-default' style='font-size:12px;'>27 => ".$data['stock'][$l]['u4']."</label>";
          $u5 = "<label class='label label-default' style='font-size:12px;'>28 => ".$data['stock'][$l]['u5']."</label>";
          $u6 = "<label class='label label-default' style='font-size:12px;'>29 => ".$data['stock'][$l]['u6']."</label>";
          $u7 = "<label class='label label-default' style='font-size:12px;'>30 => ".$data['stock'][$l]['u7']."</label>";
          $u8 = "<label class='label label-default' style='font-size:12px;'>31 => ".$data['stock'][$l]['u8']."</label>";
          $u9 = "<label class='label label-default' style='font-size:12px;'>32 => ".$data['stock'][$l]['u9']."</label>";
          $u10 = "<label class='label label-default' style='font-size:12px;'>33 => ".$data['stock'][$l]['u10']."</label>";
          $u11 = "<label class='label label-default' style='font-size:12px;'>34 => ".$data['stock'][$l]['u11']."</label>";
          $u12 = "<label class='label label-default' style='font-size:12px;'>35 => ".$data['stock'][$l]['u12']."</label>";
          $u13 = "<label class='label label-default' style='font-size:12px;'>36 => ".$data['stock'][$l]['u13']."</label>";
        }else if($lsart == 4 || $lsart == 5 || $lsart == 6 || $lsart == 7){
          $u1 = "<label class='label label-default' style='font-size:12px;'>30 => ".$data['stock'][$l]['u1']."</label>";
          $u2 = "<label class='label label-default' style='font-size:12px;'>31 => ".$data['stock'][$l]['u2']."</label>";
          $u3 = "<label class='label label-default' style='font-size:12px;'>32 => ".$data['stock'][$l]['u3']."</label>";
          $u4 = "<label class='label label-default' style='font-size:12px;'>33 => ".$data['stock'][$l]['u4']."</label>";
          $u5 = "<label class='label label-default' style='font-size:12px;'>34 => ".$data['stock'][$l]['u5']."</label>";
          $u6 = "<label class='label label-default' style='font-size:12px;'>35 => ".$data['stock'][$l]['u6']."</label>";
          $u7 = "<label class='label label-default' style='font-size:12px;'>36 => ".$data['stock'][$l]['u7']."</label>";
          $u8 = "<label class='label label-default' style='font-size:12px;'>37 => ".$data['stock'][$l]['u8']."</label>";
          $u9 = "<label class='label label-default' style='font-size:12px;'>38 => ".$data['stock'][$l]['u9']."</label>";
          $u10 = "<label class='label label-default' style='font-size:12px;'>39 => ".$data['stock'][$l]['u10']."</label>";
          $u11 = "<label class='label label-default' style='font-size:12px;'>40 => ".$data['stock'][$l]['u11']."</label>";
          $u12 = "<label class='label label-default' style='font-size:12px;'>41 => ".$data['stock'][$l]['u12']."</label>";
          $u13 = "<label class='label label-default' style='font-size:12px;'>42 => ".$data['stock'][$l]['u13']."</label>";
        }else if($lsart == 8){
          $u1 = "<label class='label label-default' style='font-size:12px;'>34 => ".$data['stock'][$l]['u1']."</label>";
          $u2 = "<label class='label label-default' style='font-size:12px;'>35 => ".$data['stock'][$l]['u2']."</label>";
          $u3 = "<label class='label label-default' style='font-size:12px;'>36 => ".$data['stock'][$l]['u3']."</label>";
          $u4 = "<label class='label label-default' style='font-size:12px;'>37 => ".$data['stock'][$l]['u4']."</label>";
          $u5 = "<label class='label label-default' style='font-size:12px;'>38 => ".$data['stock'][$l]['u5']."</label>";
          $u6 = "<label class='label label-default' style='font-size:12px;'>39 => ".$data['stock'][$l]['u6']."</label>";
          $u7 = "<label class='label label-default' style='font-size:12px;'>40 => ".$data['stock'][$l]['u7']."</label>";
          $u8 = "<label class='label label-default' style='font-size:12px;'>41 => ".$data['stock'][$l]['u8']."</label>";
          $u9 = "<label class='label label-default' style='font-size:12px;'>42 => ".$data['stock'][$l]['u9']."</label>";
          $u10 = "<label class='label label-default' style='font-size:12px;'>43 => ".$data['stock'][$l]['u10']."</label>";
          $u11 = "<label class='label label-default' style='font-size:12px;'>44 => ".$data['stock'][$l]['u11']."</label>";
          $u12 = "<label class='label label-default' style='font-size:12px;'>45 => ".$data['stock'][$l]['u12']."</label>";
          $u13 = "<label class='label label-default' style='font-size:12px;'>46 => ".$data['stock'][$l]['u13']."</label>";
        }

        if($data['stock'][$l]['psg'] == 0 || $data['stock'][$l]['psg'] == ""){
          $jmlpasangtoko = "<i style='color:red'>0</i>";
        }else{
          $jmlpasangtoko = $data['stock'][$l]['psg'];
        }

        if($datax == "BB4499-992" || $datax == "BB6599-992" || $datax == "BB1599-992" || $datax == "SZ6501-992" || $datax == "SZ1501-992" || $datax == "SZ4401-992"){ // artikel non sepatu / sandal
          $size = "Artikel Non Sepatu / Sandal (Tidak tampil ukuran)";
        }else{
          $size = "".$u1." ".$u2." ".$u3." ".$u4." ".$u5." ".$u6." ".$u7." ".$u8." ".$u9." ".$u10." ".$u11." ".$u12." ".$u13."";
        } 

        echo "<div style='background-color:#f9f9f9;border:white;box-shadow:3px 3px 6px 0px #d5d5d5;padding:10px;text-align:left;'> 
              <label class='label label-primary' style='font-weight:bold;font-size14px;margin-right:5px;position: absolute;left: 30px;margin-top: -10px;'>".$nomor."</label>
                <div style='margin-left:20px;'>
                  <b>".$namatoko."</b><br>
                  ".$cek['alamat']."<br>
                  Kode EDP : ".$data['stock'][$l]['str_id']."<br>
                  Nomor HP Toko : <a target='_new' href='https://wa.me/".$cek['spv_nomor']."'> ".$cek['spv_nomor']."</a> | <a href='tel:".$cek['spv_nomor']."'><i class='glyphicon glyphicon-phone'></i></a><br>
                  Total Stok diToko : <b>".$jmlpasangtoko." PSG</b><br><br>
                  ".$size."
                </div>
              </div><br>";

      }
      
      echo "</tbody></table>";
      echo "</div>";
      //log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cek stok artikel '.$datax.' dari server stars');
    }
  }

  function daftar_produk_dihapus(){
    $data['tong'] = $this->produk_adm->get_list_produk_tong_sampah();
    $this->load->view('manage/header');
    $this->load->view('manage/produk/dump_produk_page', $data);
    $this->load->view('manage/footer');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Daftar Produk Dihapus');
  }

  function off($id){ // off status produk
    $this->produk_adm->off_produk($id);
    $this->session->set_flashdata('error', 'Produk dinonaktifkan!');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menonaktifkan ID Produk ('.$id.')');
    redirect('trueaccon2194/produk');
  }

  function on($id){ // on status produk
    $this->produk_adm->on_produk($id);
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Mengaktifkan ID Produk ('.$id.')');
    $this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Produk diaktifkan!');
    redirect('trueaccon2194/produk');
  }

  function onoffproduk(){ // on off status produk 
    $data_filtering = $this->security->xss_clean($this->input->post('getinvdata'));
    $dataxx = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

    $id_filtering = $this->security->xss_clean($this->input->post('idproduk'));
    $idxx = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$id_filtering);

    $this->produk_adm->on_off_produk($idxx,$dataxx);
  }

  function tambah_produk(){ //load semua data yang ditampilkan pada form tambah produk
    // generate SKU Produk
    $length =10; 
    $sku= "";
    srand((double)microtime()*1000000);
    $data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
    $data .= "1234567890";
    for($i = 0; $i < $length; $i++){
      $sku .= substr($data, (rand()%(strlen($data))), 1);
      $this->data['identity_product'] = "SKU_".$sku;
    }
    $this->data['get_kat_divisix'] = $this->produk_adm->get_kat_divisi();
    $this->data['get_sizex'] = $this->produk_adm->get_size();
    $this->data['get_colorx'] = $this->produk_adm->get_color();
    $this->data['get_merkx'] = $this->produk_adm->get_merk();
    //$this->data['get_milikx'] = $this->produk_adm->get_milik();
    //$this->data['get_jenisx'] = $this->produk_adm->get_jenis();
    $this->data['list_seller'] = $this->produk_adm->getsellerdata();
    $this->data['get_kategories'] = $this->produk_adm->get_kategori();
    $this->data['get_parent_kategori'] = $this->produk_adm->get_parent_kategori();    

    $this->load->view('manage/header');
    $this->load->view('manage/produk/add', $this->data);
    $this->load->view('manage/footer');
  }

  function preview_produk($id){ // get preview data
    $data = $this->produk_adm->get_list_produk_for_preview($id);
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Preview ID Produk ('.$id.')');
    echo json_encode($data);
  }

  function proses_tambah_produk(){ // proses tambah data produk
    
    if($this->input->post()){

          $nama_produk = $this->input->post('nama');
      $data_filtering = $this->security->xss_clean($this->input->post());
          $data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);
 
      $id_user = $this->data['id'];

// BERI STATUS BARANG - SEKARANG TIDAK PERLU KAENA STATUS BARANG STANDART / DISKONTINYU HANYA UNTUK DI PRICE CALCULATION SAJA

      // ambil odv dan retail dari master berdasarkan artikel
      //$art = $this->input->post('artikel');
      //$get_dataart = $this->produk_adm->get_master_by_artikel($art);
      //foreach($get_dataart as $y){
      //  $odvM     = $y->odv;
      //  $retailM  = $y->retail; 

      ////$odv  = $r->odv;    // odv dari RIMS
      ////$retail = $r->retail; // retail dari RIMS

      // mencari margin dari data diatas
      //$margin = round(($retailM - $odvM) / $retailM * 100);

      // memberi status barang berdasarkan hasil margin
      //if($margin >= 45){
      //  $status_barang = "Standart";
        //mencari ODV bisnis
      //  $odv_bisnis = 55 * $retailM / 100;

      //}else if($margin >= 0 && $margin < 45){
      //  $status_barang = "Diskontinyu";
        //mencari ODV bisnis
      //  $odv_bisnis = ($retailM - $odvM) * 30 / 100 + $odvM;
      
      //}else if($margin <= 0){
      //  $status_barang = "ODV 0";
      //  $odv_bisnis = "0";
      //}
 
      // menghitung suggested retail bisnis
      //$sugges = $odv_bisnis + (20 * $retailM / 100);

      // menghitung fixed retail
 
      //}

// END BERI STATUS BARANG - SEKARANG TIDAK PERLU KAENA STATUS BARANG STANDART / DISKONTINYU HANYA UNTUK DI PRICE CALCULATION SAJA

      $this->produk_adm->add($id_user, $data); //($id_user, $data, $odvM, $retailM, $status_barang, $odv_bisnis);
      log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menambah produk '.$nama_produk.'');
      $this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Produk '.$nama_produk.' ditambahkan!');
      redirect('trueaccon2194/produk');
        
    }else{
      log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Menambah produk');
      $this->session->set_flashdata('error', 'Periksa form atau periksa koneksi anda');
    }
       
  }

  function duplikat_data($idp){

    // get data only tidak termasuk gambar tambah dan color size
    $g = $this->produk_adm->get_data_all($idp);
      $data_duplikat = array(
        'nama_produk'   => $g['nama_produk'],
        'slug'      => $g['slug'],
        //'milik'     => $g['milik'],
        'jenis'     => $g['jenis'],
        'artikel'     => $g['artikel'],
        'merk'      => $g['merk'],
        'note'      => $g['note'],
        'keterangan'  => $g['keterangan'],
        'tags'      => $g['tags'],
        'id_kategori_divisi' => $g['id_kategori_divisi'],
        'kategori'    => $g['kategori'],
        'parent'    => $g['parent'],
        //'other'   => masih rencana
        'harga_retail'  => $g['harga_retail'],
        'harga_odv'   => $g['harga_odv'],
        //'harga_net'   => $g['harga_net'] - ($g['diskon'] / 100 * $g['harga_retail']),
        'diskon'    => $g['diskon'],
        'diskon_rupiah' => $g['diskon_rupiah'],
        'idseller'    => $g['idseller'],
        'berat'     => $g['berat'],
        'gambar'    => $g['gambar'],
        'point'     => $g['point'],
        'status'    => $g['status'],
        'rating_produk' => $g['rating_produk'],
        'rating_produk_for_filter' => $g['rating_produk_for_filter'],
        'first_delivery'=> $g['first_delivery'],
        'last_arrival'  => $g['last_arrival'],
        'dibuat'    => $this->data['id'],
        'tgl_dibuat'  => date('Y-m-d h:i:s'),
        );
      //print_r($data_duplikat);
    $this->produk_adm->duplikat_data($data_duplikat);
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menduplikat Produk ('.$g['nama_produk'].')');
    $this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Produk '.$g['nama_produk'].' telah diduplikat!');
    redirect(base_url('trueaccon2194/produk'));
  }
 

  function edit_data($id){
    // GET SKU
    $idf = base64_decode($id);
    $idp = $this->encrypt->decode($idf);
    $pd = $this->produk_adm->get_sku($idp);
    $sku = $pd['sku_produk'];

    $this->data['get_kat_divisi']   = $this->produk_adm->get_data_divisi_all();
    $this->data['get_d_seller']     = $this->produk_adm->get_data_seller();
    $this->data['get_stok_color_size_pilihan']  = $this->produk_adm->get_data_option_and_stok($id);
    $this->data['get_data_sizex_all']   = $this->produk_adm->get_data_size_all();
    $this->data['get_data_colorx_all']  = $this->produk_adm->get_data_color_all();
    $this->data['get_colorx']       = $this->produk_adm->get_data_coloring($id);
    $this->data['get_additional_image'] = $this->produk_adm->get_data_imaging($sku);
    $this->data['get_merkx']      = $this->produk_adm->get_merk();
    $this->data['get_kategorix']    = $this->produk_adm->get_kategori();
    $this->data['get_parent_kategorix'] = $this->produk_adm->get_parent_kategori();
    //$this->data['get_milik']      = $this->produk_adm->get_data_milik();
    //$this->data['get_jenis']      = $this->produk_adm->get_data_jenis();
    $this->data['get_data']       = $this->produk_adm->get_data_all($id);

    $status = $this->produk_adm->get_data_all($id);
    if (empty($status['status'])){
    
        $this->data['status1'] = '';
    
    }elseif($status['status'] == 'on'){
    
        $this->data['status1'] = 'checked';
    
    } 
    
    $this->data['status_post'] = $status;
    $this->load->view('manage/header');
    $this->load->view('manage/produk/edit_data', $this->data);
    $this->load->view('manage/footer');
  }

  function update_produk(){ // proses tambah data produk
    $id = $this->input->post('id_produk');
    $nama_produk = $this->input->post('nama');

    if($this->input->post()){

      $data_filtering = $this->security->xss_clean($this->input->post());
      $data = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

      $id_user = $this->data['id'];

// BERI STATUS BARANG - SEKARANG TIDAK PERLU KAENA STATUS BARANG STANDART / DISKONTINYU HANYA UNTUK DI PRICE CALCULATION SAJA

      //// ambil odv dan retail dari master berdasarkan artikel
      //$art = $this->input->post('artikel');
      //$get_dataart = $this->produk_adm->get_master_by_artikel($art);
      //foreach($get_dataart as $y){
      //  $odvM     = $y->odv;
      //  $retailM  = $y->retail; 

      ////$odv  = $r->odv;    // odv dari RIMS
      ////$retail = $r->retail; // retail dari RIMS

      //// mencari margin dari data diatas
      //$margin = round(($retailM - $odvM) / $retailM * 100);

      //// memberi status barang berdasarkan hasil margin
      //if($margin >= 45){
      //  $status_barang = "Standart";
      //  //mencari ODV bisnis
      //  $odv_bisnis = 55 * $retailM / 100;

      //}else if($margin >= 0 && $margin < 45){
      //  $status_barang = "Diskontinyu";
      //  //mencari ODV bisnis
      //  $odv_bisnis = ($retailM - $odvM) * 30 / 100 + $odvM;

      //}else if($margin <= 0){
      //  $status_barang = "ODV 0";
      //  $odv_bisnis = "0";
      //}


      // menghitung suggested retail bisnis
      //$sugges = $odv_bisnis + (20 * $retailM / 100);

      // menghitung fixed retail
      //}

// END BERI STATUS BARANG - SEKARANG TIDAK PERLU KAENA STATUS BARANG STANDART / DISKONTINYU HANYA UNTUK DI PRICE CALCULATION SAJA

      $this->produk_adm->update_produk($id,$id_user,$data); //update_produk($id,$id_user,$data,$status_barang);
      log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Mengedit Produk ('.$nama_produk.')');
      $this->session->set_flashdata('success', '<i class="glyphicon glyphicon-ok"></i> Produk '.$nama_produk.' telah diubah!');
      redirect('trueaccon2194/produk');
    }else{
      log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Gagal Mengubah Produk ('.$nama_produk.')');
      $this->session->set_flashdata('error', 'Periksa form atau periksa koneksi internet anda');
    }
    
  }

  function produk_dibuang(){
    $id = $this->input->get('id');
    $name = $this->input->get('name');
    $this->produk_adm->buang_produk($id);
    $this->session->set_flashdata('error', 'Produk '.$name.' dipindah ke tong sampah!');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Membuang ke tong sampah Produk ('.$name.')');
  }

  function produk_renew(){
    $id = $this->input->get('id');
    $name = $this->input->get('name');
    $this->produk_adm->renew_produk($id);
    $this->session->set_flashdata('success', 'Produk '.$name.' diatur ulang menjadi aktif!');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Mengatur ulang dan mengaktifkan Produk ('.$name.')');
  }

  function produk_dihapus(){
    $id = $this->input->get('id'); 
    $name = $this->input->get('name');
    $sku = $this->input->get('sku');
    // unlink gambar utama
    $gb_utama = $this->produk_adm->get_gb_utama($id);
    $file_utama = $gb_utama['gambar'];
    $url = base_url();
    $nm = FCPATH.str_replace($url, '',$file_utama);
    unlink($nm);
    // unlink gambar tambahan
    $gb_tb = $this->produk_adm->get_gb_tambahan($sku);
    foreach($gb_tb as $tb){
      $file_tb = FCPATH.'assets/images/produk/'.$tb->gambar.'';
      unlink($file_tb);
    }
    $this->produk_adm->hapus_produk($id,$sku);
    $this->session->set_flashdata('error', 'Produk '.$name.' dihapus!');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Menghapus Produk ('.$name.')');
  }

  function delete_select() { 
    $check = $this->security->xss_clean($this->input->post('checklist'));
    if(empty($check)){
      $this->session->set_flashdata('error', 'Tidak ada data yang dipilih.');
      redirect($this->agent->referrer()); 
    }else{
      $this->produk_adm->remove_dipilih($check);
      log_helper("produk", "Membuang Produk yang dipilih");
      $this->session->set_flashdata('error', 'Produk berhasil dibuang');
      redirect($this->agent->referrer());
    }
  }

  function delete_select_color(){
    $id = $this->input->get('id');
    $this->produk_adm->delete_warna_select($id);
    echo json_encode(array("status" => TRUE));
  }

  function delete_select_size(){
    $id = $this->input->get('id');
    $this->produk_adm->delete_size_select($id);
    echo json_encode(array("status" => TRUE));
  }

  function delete_select_image(){
    $id = $this->input->get('id');
    $src = $this->input->get('src');
    $file = FCPATH.'assets/images/produk/'.$src.'';
    unlink($file);
    $this->produk_adm->delete_image_select($id);
    echo json_encode(array("status" => TRUE));
  }

  function master_barang(){
    //$this->data['master'] = $this->produk_adm->get_master();
    $this->load->view('manage/header');
    $this->load->view('manage/produk/master_barang');
    $this->load->view('manage/footer');
  }

  function get_data_for_calculation1(){
    $art = $this->security->xss_clean($this->input->post('art'));
 
    //GET DATA FROM MASTER
    $result = $this->produk_adm->get_data_from_produk($art);
    
    foreach($result as $r){ 
      $retail   = $r->retprc;
      //$net    = $r->harga_net;  // retail dari RIMS
      
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode(array('retail'=> $retail))); //'net'=> $net,
    }
  }

  function get_data_for_calculation(){
    $art = $this->security->xss_clean($this->input->post('art'));

    //GET DATA FROM MASTER
    $result = $this->produk_adm->get_data_from_master($art);
    
    foreach($result as $r){
      //$odv  = $r->odv;    // odv dari RIMS OFF
      $retail = $r->retprc; // retail dari RIMS

      // mencari margin dari data diatas OFF
      // $margin = round(($retail - $odv) / $retail * 100); OFF

      // memberi status barang berdasarkan hasil margin OFF
      //if($margin >= 45){ OFF
        //$status_barang = "Standart";
        //mencari ODV bisnis OFF
        //$odv_bisnis = 55 * $retail / 100;

      //}else if($margin >= 0 && $margin < 45){
        //$status_barang = "Diskontinyu";
        //mencari ODV bisnis
        //$odv_bisnis = ($retail - $odv) * 30 / 100 + $odv;

      //}else if($margin <= 0){
        //$status_barang = "ODV 0";
        //$odv_bisnis = "0";
      //}

      // tambahan
      //if($margin <= 0){
        // menghitung suggested retail bisnis
        //$sugges = "Mengikuti Harga ditoko";

        // menghitung margin bisnis
        //$margin_bisnis = "Berdasarkan Harga Retail yang ditentukan ditoko";
      //}else{
        // menghitung suggested retail bisnis
        //$sugges = $odv_bisnis + (20 * $retail / 100);

        // menghitung margin bisnis
        //$margin_bisnis = $sugges - $odv_bisnis;
      //}


      // menghitung suggested retail bisnis
      //$sugges = $odv_bisnis + (20 * $retail / 100);

      // menghitung margin bisnis
      //$margin_bisnis = $sugges - $odv_bisnis;
      
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode(array('odv'=> '-','retail'=> $retail,'margin'=> '-','status'=> '-', 'odv_bisnis'=> '-', 'suggested'=> '-', 'margin_bisnis'=> '-')));
    // json_encode(array('odv'=> $odv,'retail'=> $retail,'margin'=> $margin,'status'=> $status_barang, 'odv_bisnis'=> $odv_bisnis, 'suggested'=> $sugges, 'margin_bisnis'=> $margin_bisnis))
    }
  }

  function update_harga(){
    $data_produk = $this->produk_adm->data_produk_dan_master();
    foreach($data_produk as $t){

      if($t->harga1 == "" || $t->harga1== 0){ // harga1 as harga_dicoret

        if($t->harga2 != $t->retprc){

          $id_produkk = $t->id_produk;
          if($t->harga1 == "" || $t->harga1 == 0){ // jika harga dicoret == 0
            // harga dicoret
            $harga_dicoret_update = "";
            // diskon
            $disc = "";
            // harga fix
            $harga_fix_update = $t->retprc;
            // diskon rupiah
            $disc_rupiah = "";
          }else{
            // harga dicoret
            $harga_dicoret_update = $t->retprc;
            // mencari diskon pada harga sebelum diupdate
            $disc = round(($t->harga1 - $t->harga2) / $t->harga1 * 100);
            // harga fix
            $harga_fix_update = $t->retprc - ($t->retprc * $disc / 100);
            // diskon rupiah 
            $disc_rupiah = $t->retprc - $harga_fix_update;
          }

          $id_color = $t->id_opsi_get_color;
          $id_size  = $t->id_opsi_get_size;
          $data = array(
            //'artikel_produk' => $t->artikel1,
            //'harga_sebelum'  => $t->harga1,
            //'harga_sesudah'  => $t->harga2,
            //'harga_retail_update'   => $harga_retail_update,
            //'harga_net_update'    => round($harga_net_update),
            //'selisih'       => round($harga_selisih),
            //'diskon'     => $disc,
            //'artikel_master' => $t->artikel2,
            //'harga_retail'   => $t->retprc,
            'harga_dicoret'  => $harga_dicoret_update,
            //'harga_odv'   => $t->odv,
            'harga_fix'   => $harga_fix_update,
            //'diskon_rupiah' => $disc_rupiah,
          );

          //print_r($data);
          
          $this->produk_adm->update_harga_produk($id_produkk,$id_color,$id_size,$data);

          // masuk ke database produk mana saja yang mengalami perubahan harga
          $idr = $this->data['id'];
          $d_pro = array(
            'id_produk_diskon'  => $id_produkk,
            'diskon'      => $disc,
            'diskon_rupiah'   => $disc_rupiah,
            'retail_before'   => $t->harga2,
            'retail_after'    => $harga_fix_update,
            'tgl'       => date('Y-m-d'),
            'tgl_waktu'     => date('Y-m-d H:i:s'),
            'user_pengubah'   => $idr,
          );
          //print_r($d_pro);
          $this->produk_adm->produk_berubah_harga($d_pro);
        }
      }else{
        if($t->harga1 != $t->retprc){
          $id_produkk = $t->id_produk;
          if($t->harga1 == "" || $t->harga1 == 0){
            // harga dicoret
            $harga_dicoret_update = "";
            // diskon
            $disc = "";
            // harga fix
            $harga_fix_update = $t->retprc;
            // diskon rupiah
            $disc_rupiah = "";
          }else{
            // harga dicoret
            $harga_dicoret_update = $t->retprc;
            // mencari diskon pada harga sebelum diupdate
            $disc = round(($t->harga1 - $t->harga2) / $t->harga1 * 100);
            // harga fix
            $harga_fix_update = $t->retprc - ($t->retprc * $disc / 100);
            // diskon rupiah 
            $disc_rupiah = $t->retprc - $harga_fix_update;
          }

          $id_color = $t->id_opsi_get_color;
          $id_size  = $t->id_opsi_get_size;
          $data = array(
            //'artikel_produk' => $t->artikel1,
            //'harga_sebelum'  => $t->harga1,
            //'harga_sesudah'  => $t->harga2,
            //'harga_retail_update'   => $harga_retail_update,
            //'harga_net_update'    => round($harga_net_update),
            //'selisih'         => round($harga_selisih),
            //'diskon'     => $disc,
            //'artikel_master' => $t->artikel2,
            //'harga_retail'   => $t->retprc,
            'harga_dicoret' => $harga_dicoret_update,
            //'harga_odv'   => $t->odv,
            'harga_fix'   => $harga_fix_update,
            //'diskon_rupiah' => $disc_rupiah,
          );

          //print_r($data);
          
          $this->produk_adm->update_harga_produk($id_produkk,$id_color,$id_size,$data);

          // masuk ke database produk mana saja yang mengalami perubahan harga
          $idr = $this->data['id'];
          $d_pro = array(
            'id_produk_diskon'  => $id_produkk,
            'diskon'      => $disc,
            'diskon_rupiah'   => $disc_rupiah,
            'retail_before'   => $t->harga2,
            'retail_after'    => $harga_fix_update,
            'tgl'       => date('Y-m-d'),
            'tgl_waktu'     => date('Y-m-d H:i:s'),
            'user_pengubah'   => $idr,
          );
          //print_r($d_pro);
          $this->produk_adm->produk_berubah_harga($d_pro);
        }
      }
    }

      //$this->session->set_flashdata('success', 'Harga Produk telah diupdate!');
      log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Mengupdate Harga Produk');
      //redirect('trueaccon2194/produk');
  }

   function tambahproduksyncrimbyexcel($limit){
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    // ubah format tanggal
    $tgl = date("d-m-Y", strtotime(now()));

    $objPHPExcel = new PHPExcel();
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );      
    // Create a first sheet, representing sales data
    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PRODUK STOK GLOBAL > 700"); // Set kolom A1
    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('Data Produk');

      $objPHPExcel->getActiveSheet()->mergeCells('A1:AE1'); // Set Merge Cell pada kolom A1 sampai AE1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
    //table header
    $heading = array("Nama Project","Artikel","Harga RIMS","Stok Global");
    //loop heading
    $rowNumberH = 3;
    $colH = 'A'; 
    foreach($heading as $h){
        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
        $colH++;    
    }
    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    // lopping
    // mulai isi data pada baris ke 4
    $baris = 4;
    $lmt = $limit;//$this->security->xss_clean($this->input->post('lmt'));
    $cekartikeldata = $this->produk_adm->get_data_by_art2byexcel($lmt);
    $dataartikel = "";
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

        $totalstok = 0;
        $data = json_decode($response, true);
        for ($l=0; $l < count($data['stock']); $l++){ 
          // total stok masing2 produk 
          $totalstok += $data['stock'][$l]['psg'];
        }

        if($totalstok > 300){

          //pemanggilan sesuaikan dengan nama kolom tabel
          $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $gh->prj);
          $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $gh->art_id);
          $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $gh->retprc); 
          $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $totalstok);
         // echo $gh->art_id.' | '.$gh->prj.' | '.$gh->retprc.' | '.$totalstok;
        }

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 

      // Redirect output to a client’s web browser (Excel5)
      $filename = urlencode("Data_Produk_Limit_".$lmt.".xls"); 
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');
      $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save('php://output');
      log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cek dan cetak Data Produk RIMS limit '.$lmt.' by (Excel)');
      echo "Data behasil diimport ke excel";
    }


  }


  function download_excel_produk(){
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    // ubah format tanggal
    $tgl = date("d-m-Y", strtotime(now()));

    $objPHPExcel = new PHPExcel();
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
      $style_col = array(
        'font' => array('bold' => true), // Set font nya jadi bold
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );
      // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
      $style_row = array(
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );      
      // Create a first sheet, representing sales data
      $objPHPExcel->setActiveSheetIndex(0);

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA STOK PRODUK E-COMMERCE"); // Set kolom A1
      // Rename sheet
      $objPHPExcel->getActiveSheet()->setTitle('Data Produk');

        $objPHPExcel->getActiveSheet()->mergeCells('A1:AE1'); // Set Merge Cell pada kolom A1 sampai AE1
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
      //table header
      $heading = array("No","Nama Project","Artikel","Harga Awal","Harga Nett","Diskon (%)","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44");
          //loop heading
       $rowNumberH = 3;
        $colH = 'A'; 
        foreach($heading as $h){
            $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
            $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
            $colH++;    
        }
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
          // lopping
          // mulai isi data pada baris ke 4
          $baris = 4;
          $dataP = $this->produk_adm->get_list_produk();
          $no = 0;
          foreach ($dataP as $frow){
          $no++;
          $idProduk = count($frow->id_produk);

          if($frow->harga_dicoret == "" || $frow->harga_dicoret == 0){
            $harga_awal = 0;
            $harga_net = $frow->harga_fix;
            $diskon = 0;
          }else{
            $harga_awal = $frow->harga_dicoret;
            $harga_net = $frow->harga_fix;
            $diskon = round(($frow->harga_dicoret - $frow->harga_fix) / $frow->harga_dicoret * 100);
          }

          // STOK SIZE
          $idp = $frow->id_produk;
          //$ck = $this->produk_adm->get_list_produk_for_option_size($idp);    

              //pemanggilan sesuaikan dengan nama kolom tabel
          $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $no);
          $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $frow->nama_produk);
          $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $frow->artikel);
          $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $harga_awal); 
          $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $harga_net);
          $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $diskon);
                
            $r20 = $this->produk_adm->get_list_produk_for_option_size20($idp);  
            if($r20['stok'] == 0 || $r20['stok'] == ""){
              $stok20 = "";
            }else{
              $stok20 = $r20['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, $stok20); 

            $r21 = $this->produk_adm->get_list_produk_for_option_size21($idp);  
            if($r21['stok'] == 0 || $r21['stok'] == ""){
              $stok21 = "";
            }else{
              $stok21 = $r21['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, $stok21); 
            
            $r22 = $this->produk_adm->get_list_produk_for_option_size22($idp);  
            if($r22['stok'] == 0 || $r22['stok'] == ""){
              $stok22 = "";
            }else{
              $stok22 = $r22['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, $stok22); 
            
            $r23 = $this->produk_adm->get_list_produk_for_option_size23($idp);  
            if($r23['stok'] == 0 || $r23['stok'] == ""){
              $stok23 = "";
            }else{
              $stok23 = $r23['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, $stok23); 
            
            $r24 = $this->produk_adm->get_list_produk_for_option_size24($idp);  
            if($r24['stok'] == 0 || $r24['stok'] == ""){
              $stok24 = "";
            }else{
              $stok24 = $r24['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, $stok24); 
            
            $r25 = $this->produk_adm->get_list_produk_for_option_size25($idp);  
            if($r25['stok'] == 0 || $r25['stok'] == ""){
              $stok25 = "";
            }else{
              $stok25 = $r25['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, $stok25); 
            
            $r26 = $this->produk_adm->get_list_produk_for_option_size26($idp);  
            if($r26['stok'] == 0 || $r26['stok'] == ""){
              $stok26 = "";
            }else{
              $stok26 = $r26['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, $stok26); 
            
            $r27 = $this->produk_adm->get_list_produk_for_option_size27($idp);  
            if($r27['stok'] == 0 || $r27['stok'] == ""){
              $stok27 = "";
            }else{
              $stok27 = $r27['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("N".$baris, $stok27); 
            
            $r28 = $this->produk_adm->get_list_produk_for_option_size28($idp);  
            if($r28['stok'] == 0 || $r28['stok'] == ""){
              $stok28 = "";
            }else{
              $stok28 = $r28['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("O".$baris, $stok28); 
            
            $r29 = $this->produk_adm->get_list_produk_for_option_size29($idp);  
            if($r29['stok'] == 0 || $r29['stok'] == ""){
              $stok29 = "";
            }else{
              $stok29 = $r29['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("P".$baris, $stok29); 
            
            $r30 = $this->produk_adm->get_list_produk_for_option_size30($idp);  
            if($r30['stok'] == 0 || $r30['stok'] == ""){
              $stok30 = "";
            }else{
              $stok30 = $r30['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("Q".$baris, $stok30); 
            
            $r31 = $this->produk_adm->get_list_produk_for_option_size31($idp);  
            if($r31['stok'] == 0 || $r31['stok'] == ""){
              $stok31 = "";
            }else{
              $stok31 = $r31['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("R".$baris, $stok31); 

            $r32 = $this->produk_adm->get_list_produk_for_option_size32($idp);  
            if($r32['stok'] == 0 || $r32['stok'] == ""){
              $stok32 = "";
            }else{
              $stok32 = $r32['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("S".$baris, $stok32); 
            
            $r33 = $this->produk_adm->get_list_produk_for_option_size33($idp);  
            if($r33['stok'] == 0 || $r33['stok'] == ""){
              $stok33 = "";
            }else{
              $stok33 = $r33['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("T".$baris, $stok33); 
            
            $r34 = $this->produk_adm->get_list_produk_for_option_size34($idp);  
            if($r34['stok'] == 0 || $r34['stok'] == ""){
              $stok34 = "";
            }else{
              $stok34 = $r34['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("U".$baris, $stok34); 

            $r35 = $this->produk_adm->get_list_produk_for_option_size35($idp);  
            if($r35['stok'] == 0 || $r35['stok'] == ""){
              $stok35 = "";
            }else{
              $stok35 = $r35['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("V".$baris, $stok35); 
            
            $r36 = $this->produk_adm->get_list_produk_for_option_size36($idp);  
            if($r36['stok'] == 0 || $r36['stok'] == ""){
              $stok36 = "";
            }else{
              $stok36 = $r36['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("W".$baris, $stok36); 
            
            $r37 = $this->produk_adm->get_list_produk_for_option_size37($idp);  
            if($r37['stok'] == 0 || $r37['stok'] == ""){
              $stok37 = "";
            }else{
              $stok37 = $r37['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("X".$baris, $stok37); 
            
            $r38 = $this->produk_adm->get_list_produk_for_option_size38($idp);  
            if($r38['stok'] == 0 || $r38['stok'] == ""){
              $stok38 = "";
            }else{
              $stok38 = $r38['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("Y".$baris, $stok38); 
            
            $r39 = $this->produk_adm->get_list_produk_for_option_size39($idp);  
            if($r39['stok'] == 0 || $r39['stok'] == ""){
              $stok39 = "";
            }else{
              $stok39 = $r39['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("Z".$baris, $stok39);
            
            $r40 = $this->produk_adm->get_list_produk_for_option_size40($idp);  
            if($r40['stok'] == 0 || $r40['stok'] == ""){
              $stok40 = "";
            }else{
              $stok40 = $r40['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("AA".$baris, $stok40); 
            
            $r41 = $this->produk_adm->get_list_produk_for_option_size41($idp);  
            if($r41['stok'] == 0 || $r41['stok'] == ""){
              $stok41 = "";
            }else{
              $stok41 = $r41['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("AB".$baris, $stok41); 
            
            $r42 = $this->produk_adm->get_list_produk_for_option_size42($idp);  
            if($r42['stok'] == 0 || $r42['stok'] == ""){
              $stok42 = "";
            }else{
              $stok42 = $r42['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("AC".$baris, $stok42); 
            
            $r43 = $this->produk_adm->get_list_produk_for_option_size43($idp);  
            if($r43['stok'] == 0 || $r43['stok'] == ""){
              $stok43 = "";
            }else{
              $stok43 = $r43['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("AD".$baris, $stok43); 
            
            $r44 = $this->produk_adm->get_list_produk_for_option_size44($idp);  
            if($r44['stok'] == 0 || $r44['stok'] == ""){
              $stok44 = "";
            }else{
              $stok44 = $r44['stok'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue("AE".$baris, $stok44); 

              // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('W'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('X'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('Y'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('Z'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('AA'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('AB'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('AC'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('AD'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('AE'.$baris)->applyFromArray($style_row);
              $baris++;
          }
          // end lopping

           // Set width kolom
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(10); 
        
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        //$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

    // Redirect output to a client’s web browser (Excel5)
    $filename = urlencode("Data_Semua_Produk_E-commerce.xls"); 
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Data Semua Produk (Excel)');
  }

  function filter_produk_excel(){
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

    $excelx = $this->security->xss_clean($this->input->post('excel_filter'));
    $excel = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$excelx);

    if($excel == "excel_produk_by_filter_to_shopee"){
      $this->filter_produk_excel_to_shopee();
    }else if($excel == "excel_produk_by_filter_to_lazada"){
      $this->filter_produk_excel_to_lazada();
    }else if($excel == "excel_produk_by_filter_to_tokopedia"){
      $this->filter_produk_excel_to_tokopedia();
    }else if($excel == "excel_produk_by_filter_to_bukalapak"){
      $this->filter_produk_excel_to_bukalapak();
    }else if($excel == "excel_produk_by_filter_to_blibli"){
      $this->filter_produk_excel_to_blibli();
    }else{

      // FORM FILTER
      $filter_statusx = $this->security->xss_clean($this->input->post('status_produk'));
      $filter_status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_statusx);

      if($filter_status == "on"){
        $filter_statusxx = "Aktif";
      }else if($filter_status == "off"){
        $filter_statusxx = "Tidak Aktif";
      }else{
        $filter_statusxx = "-";
      }

      $filter_sortbyx = $this->security->xss_clean($this->input->post('sort_by'));
      $filter_sortby = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sortbyx);

      if($filter_sortby == "a_z"){
        $filter_sortbyxx = "A - Z";
      }else if($filter_sortby == "z_a"){
        $filter_sortbyxx = "Z - A";
      }else if($filter_sortby == "low"){
        $filter_sortbyxx = "Harga Terendah - Harga Tertinggi";
      }else if($filter_sortby == "high"){
        $filter_sortbyxx = "Harga Tertinggi - Harga Terendah";
      }else if($filter_sortby == "first_end"){
        $filter_sortbyxx = "Produk lama - produk baru";
      }else if($filter_sortby == "end_first"){
        $filter_sortbyxx = "Produk baru - produk lama";
      }else{
        $filter_sortbyxx = "-";
      }

      $filter_sizex = $this->security->xss_clean($this->input->post('size'));
      $filter_size = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sizex);

      // cari size berdasarkan id
      $caris = $this->produk_adm->carisizeberdasarkanid($filter_size);
      if(!empty($filter_size)){
        $filter_sizexx = $caris['opsi_size'];
      }else{
        $filter_sizexx = "-";
      }

      $filter_colorx = $this->security->xss_clean($this->input->post('color'));
      $filter_color = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_colorx);    

      // cari size berdasarkan id
      $caric = $this->produk_adm->caricolorberdasarkanid($filter_color);
      if(!empty($filter_color)){
        $filter_colorxx = $caric['opsi_color'];
      }else{
        $filter_colorxx = "-";
      }

      $tgl1x = $this->security->xss_clean($this->input->post('tglupload1'));
      $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1x);    

      $tgl2x = $this->security->xss_clean($this->input->post('tglupload2'));
      $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2x);  

      if($tgl1 == "" || $tgl2 == ""){
        $tgl1ch = "";
        $tgl2ch = "";
      }else{
        $tgl1ch = date("d/m/y", strtotime($tgl1));  
        $tgl2ch = date("d/m/y", strtotime($tgl2));  
      }

      // END FORM FILTER
      // ubah format tanggal
      $tgl = date("d-m-Y", strtotime(now()));

      $objPHPExcel = new PHPExcel();
      // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
      $style_col = array(
        'font' => array('bold' => true), // Set font nya jadi bold
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );
      // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
      $style_row = array(
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );      
      // Create a first sheet, representing sales data
      $objPHPExcel->setActiveSheetIndex(0);

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", "DATA STOK PRODUK E-COMMERCE"); // Set kolom A1
      // Rename sheet
      $objPHPExcel->getActiveSheet()->setTitle('Data Produk');

      $objPHPExcel->getActiveSheet()->mergeCells('A1:AF1'); // Set Merge Cell pada kolom A1 sampai AE1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

      // buat informasi apa yang ditarik
      $objPHPExcel->getActiveSheet()->setCellValue("A2","Status");
      $objPHPExcel->getActiveSheet()->setCellValue("A3","Sort By");
      $objPHPExcel->getActiveSheet()->setCellValue("A4","Ukuran");
      $objPHPExcel->getActiveSheet()->setCellValue("A5","Warna");
      $objPHPExcel->getActiveSheet()->setCellValue("A6","Tanggal Upload");
      // tampilkan hasil informasi yang ditarik
      $objPHPExcel->getActiveSheet()->setCellValue('B2',$filter_statusxx);
      $objPHPExcel->getActiveSheet()->setCellValue('B3',$filter_sortbyxx);
      $objPHPExcel->getActiveSheet()->setCellValue('B4',$filter_sizexx);
      $objPHPExcel->getActiveSheet()->setCellValue('B5',$filter_colorxx);
      $objPHPExcel->getActiveSheet()->setCellValue('B6',$tgl1ch." - ".$tgl2ch);
      // style
      $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE);
      $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
      $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(TRUE);
      $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE);
      $objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
      //table header

      // HEADING DARI NOMOR - DISKON
      $heading1 = array("No","Nama Project","Artikel","Merk","Stok Global","Harga Awal","Harga Nett","Diskon (%)","STOK SIZE","Total Gambar");
        //loop heading
      $rowNumberH1 = 7;
      $colH1 = 'A'; 
      foreach($heading1 as $h1){
        if($colH1 == "I"){ // untuk kolom G  beda (stok size)
          // Set Merge Cell kolom stok size
          $objPHPExcel->getActiveSheet()->mergeCells($colH1.$rowNumberH1.':AG7');
          $objPHPExcel->getActiveSheet()->setCellValue($colH1.$rowNumberH1,$h1);
          $objPHPExcel->getActiveSheet()->getStyle($colH1.$rowNumberH1.':'.$colH1.($rowNumberH1+1))->getFont()->setSize(20); 
          $objPHPExcel->getActiveSheet()->getStyle($colH1.$rowNumberH1.':AG7',$h1)->applyFromArray($style_col);

        }else{ // untuk kolom A - F

          $objPHPExcel->getActiveSheet()->setCellValue($colH1.$rowNumberH1,$h1);
          // Set Merge Cell pada kolom A1 sampai AE1
          $objPHPExcel->getActiveSheet()->mergeCells($colH1.$rowNumberH1.':'.$colH1.($rowNumberH1+2)); 
          $objPHPExcel->getActiveSheet()->getStyle($colH1.$rowNumberH1.':'.$colH1.($rowNumberH1+2))->getFont()->setBold(TRUE); 
          $objPHPExcel->getActiveSheet()->getStyle($colH1.$rowNumberH1.':'.$colH1.($rowNumberH1+2),$h1)->applyFromArray($style_col);
        }
        $colH1++;    
      }

      $heading2 = array("20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44");
        //loop heading
      $rowNumberH2 = 9;
      $colH2 = 'I'; 
      foreach($heading2 as $h2){
        $objPHPExcel->getActiveSheet()->setCellValue($colH2.$rowNumberH2,$h2);
        $objPHPExcel->getActiveSheet()->getStyle($colH2.$rowNumberH2,$h2)->getFont()->setBold(TRUE); 
        $objPHPExcel->getActiveSheet()->getStyle($colH2.$rowNumberH2,$h2)->applyFromArray($style_col);
        $colH2++;   
      }
          
      // Apply style header yang telah kita buat tadi ke masing-masing kolom header
      // lopping
      // mulai isi data pada baris ke 4
      $baris = 10;
      $no = 0;
      $dataP = $this->produk_adm->filter_produk_excel($filter_status,$filter_sortby,$filter_size,$filter_color,$tgl1,$tgl2);
      foreach ($dataP as $frow){
      $no++;
      $idProduk = count($frow->id_produk);
        if($frow->harga_dicoret == "" || $frow->harga_dicoret == 0){
          $harga_awal = 0;
          $harga_net = $frow->harga_fix;
          $diskon = 0;
        }else{
          $harga_awal = $frow->harga_dicoret;
          $harga_net = $frow->harga_fix;
          $diskon = round(($frow->harga_dicoret - $frow->harga_fix) / $frow->harga_dicoret * 100);
        }

        // STOK SIZE
        $idp = $frow->id_produk;
        $ck = $this->produk_adm->get_list_produk_for_option_size($idp);    

        //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $no);
        $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $frow->nama_produk);
        $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $frow->artikel);
        $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $frow->merk);
        $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $frow->stok_global); 
        $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $harga_awal); 
        $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, $harga_net);
        $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, $diskon);
              
        $r20 = $this->produk_adm->get_list_produk_for_option_size20($idp);  
        if($r20['stok'] == 0 || $r20['stok'] == ""){
          $stok20 = "";
        }else{
          $stok20 = $r20['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, $stok20); 

        $r21 = $this->produk_adm->get_list_produk_for_option_size21($idp);  
        if($r21['stok'] == 0 || $r21['stok'] == ""){
          $stok21 = "";
        }else{
          $stok21 = $r21['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, $stok21); 
        
        $r22 = $this->produk_adm->get_list_produk_for_option_size22($idp);  
        if($r22['stok'] == 0 || $r22['stok'] == ""){
          $stok22 = "";
        }else{
          $stok22 = $r22['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, $stok22); 
        
        $r23 = $this->produk_adm->get_list_produk_for_option_size23($idp);  
        if($r23['stok'] == 0 || $r23['stok'] == ""){
          $stok23 = "";
        }else{
          $stok23 = $r23['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, $stok23); 
            
        $r24 = $this->produk_adm->get_list_produk_for_option_size24($idp);  
        if($r24['stok'] == 0 || $r24['stok'] == ""){
          $stok24 = "";
        }else{
          $stok24 = $r24['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, $stok24); 
        
        $r25 = $this->produk_adm->get_list_produk_for_option_size25($idp);  
        if($r25['stok'] == 0 || $r25['stok'] == ""){
          $stok25 = "";
        }else{
          $stok25 = $r25['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("N".$baris, $stok25); 
        
        $r26 = $this->produk_adm->get_list_produk_for_option_size26($idp);  
        if($r26['stok'] == 0 || $r26['stok'] == ""){
          $stok26 = "";
        }else{
          $stok26 = $r26['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("O".$baris, $stok26); 
            
        $r27 = $this->produk_adm->get_list_produk_for_option_size27($idp);  
        if($r27['stok'] == 0 || $r27['stok'] == ""){
          $stok27 = "";
        }else{
          $stok27 = $r27['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("P".$baris, $stok27); 
        
        $r28 = $this->produk_adm->get_list_produk_for_option_size28($idp);  
        if($r28['stok'] == 0 || $r28['stok'] == ""){
          $stok28 = "";
        }else{
          $stok28 = $r28['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("Q".$baris, $stok28); 
        
        $r29 = $this->produk_adm->get_list_produk_for_option_size29($idp);  
        if($r29['stok'] == 0 || $r29['stok'] == ""){
          $stok29 = "";
        }else{
          $stok29 = $r29['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("R".$baris, $stok29); 
            
        $r30 = $this->produk_adm->get_list_produk_for_option_size30($idp);  
        if($r30['stok'] == 0 || $r30['stok'] == ""){
          $stok30 = "";
        }else{
          $stok30 = $r30['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("S".$baris, $stok30); 
        
        $r31 = $this->produk_adm->get_list_produk_for_option_size31($idp);  
        if($r31['stok'] == 0 || $r31['stok'] == ""){
          $stok31 = "";
        }else{
          $stok31 = $r31['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("T".$baris, $stok31); 

        $r32 = $this->produk_adm->get_list_produk_for_option_size32($idp);  
        if($r32['stok'] == 0 || $r32['stok'] == ""){
          $stok32 = "";
        }else{
          $stok32 = $r32['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("U".$baris, $stok32); 
        
        $r33 = $this->produk_adm->get_list_produk_for_option_size33($idp);  
        if($r33['stok'] == 0 || $r33['stok'] == ""){
          $stok33 = "";
        }else{
          $stok33 = $r33['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("V".$baris, $stok33); 
        
        $r34 = $this->produk_adm->get_list_produk_for_option_size34($idp);  
        if($r34['stok'] == 0 || $r34['stok'] == ""){
          $stok34 = "";
        }else{
          $stok34 = $r34['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("W".$baris, $stok34); 

        $r35 = $this->produk_adm->get_list_produk_for_option_size35($idp);  
        if($r35['stok'] == 0 || $r35['stok'] == ""){
          $stok35 = "";
        }else{
          $stok35 = $r35['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("X".$baris, $stok35); 
            
        $r36 = $this->produk_adm->get_list_produk_for_option_size36($idp);  
        if($r36['stok'] == 0 || $r36['stok'] == ""){
          $stok36 = "";
        }else{
          $stok36 = $r36['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("Y".$baris, $stok36); 
        
        $r37 = $this->produk_adm->get_list_produk_for_option_size37($idp);  
        if($r37['stok'] == 0 || $r37['stok'] == ""){
          $stok37 = "";
        }else{
          $stok37 = $r37['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("Z".$baris, $stok37); 
        
        $r38 = $this->produk_adm->get_list_produk_for_option_size38($idp);  
        if($r38['stok'] == 0 || $r38['stok'] == ""){
          $stok38 = "";
        }else{
          $stok38 = $r38['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("AA".$baris, $stok38); 
        
        $r39 = $this->produk_adm->get_list_produk_for_option_size39($idp);  
        if($r39['stok'] == 0 || $r39['stok'] == ""){
          $stok39 = "";
        }else{
          $stok39 = $r39['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("AB".$baris, $stok39);
        
        $r40 = $this->produk_adm->get_list_produk_for_option_size40($idp);  
        if($r40['stok'] == 0 || $r40['stok'] == ""){
          $stok40 = "";
        }else{
          $stok40 = $r40['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("AC".$baris, $stok40); 
            
        $r41 = $this->produk_adm->get_list_produk_for_option_size41($idp);  
        if($r41['stok'] == 0 || $r41['stok'] == ""){
          $stok41 = "";
        }else{
          $stok41 = $r41['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("AD".$baris, $stok41); 
        
        $r42 = $this->produk_adm->get_list_produk_for_option_size42($idp);  
        if($r42['stok'] == 0 || $r42['stok'] == ""){
          $stok42 = "";
        }else{
          $stok42 = $r42['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("AE".$baris, $stok42); 
        
        $r43 = $this->produk_adm->get_list_produk_for_option_size43($idp);  
        if($r43['stok'] == 0 || $r43['stok'] == ""){
          $stok43 = "";
        }else{
          $stok43 = $r43['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("AF".$baris, $stok43); 
      
        $r44 = $this->produk_adm->get_list_produk_for_option_size44($idp);  
        if($r44['stok'] == 0 || $r44['stok'] == ""){
          $stok44 = "";
        }else{
          $stok44 = $r44['stok'];
        }
        $objPHPExcel->getActiveSheet()->setCellValue("AG".$baris, $stok44);    

        // NEW TOTAL GAMBAR
        $skup = $frow->sku_produk;
        $getGB = $this->produk_adm->get_gbdata($skup);
        $jumlahgambar = $getGB['totalgambar'];                           

        $objPHPExcel->getActiveSheet()->setCellValue("AH".$baris, $jumlahgambar); 

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('W'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('X'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('Y'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('Z'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AA'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AB'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AC'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AD'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AE'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AF'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AG'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AH'.$baris)->applyFromArray($style_row);
        $baris++;
      }
      // end lopping

        // Set width kolom
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(10); 
          
        //$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
      // Redirect output to a client’s web browser (Excel5)
      $filename = urlencode("Data_Produk_E-commerce_By_Filter_status_produk_".$filter_statusxx."_sort_by_".$filter_sortbyxx."_ukuran_".$filter_sizexx."_warna_".$filter_colorxx."_range_tanggal_".$tgl1ch."-".$tgl2ch.".xls");
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');
      $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save('php://output');
      log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Data Produk (Excel) dengan filter status produk '.$filter_statusxx.' sort by '.$filter_sortbyxx.' ukuran '.$filter_sizexx.' warna '.$filter_colorxx.'_range_tanggal_'.$tgl1ch.'-'.$tgl2ch.'');
    }
  }

  function tampilgambar(){
    $dataP = $this->produk_adm->filter_produk();  
    //$dataP = $this->produk_adm->filter_produk_excel($filter_status,$filter_sortby,$filter_size,$filter_color);
    foreach ($dataP as $frow){
      //$no++;

      //get gambar sampai 5 gambar 
      $no = 0;
      $gambar1 = "";
      $gambar2 = "";
      $gambar3 = "";
      $gambar4 = "";
      $gambar5 = "";
      $sku = $frow->sku_produk;
      $gb = $this->produk_adm->get_gambar($sku);
      foreach($gb as $h){
        $no++;
        if($no == 1){
          $gambar1 = $h->gambar;
        }
        if($no == 2){
          $gambar2 = $h->gambar;
        }
        if($no == 3){
          $gambar3 = $h->gambar;
        }
        if($no == 4){
          $gambar4 = $h->gambar;
        }
        if($no == 5){
          $gambar5 = $h->gambar;
        }
      }

      echo $frow->nama_produk.'<br>';
      echo $frow->gambar.'<br><br>';
      echo $gambar1.'<br>';
      echo $gambar2.'<br>';
      echo $gambar3.'<br>';
      echo $gambar4.'<br>';
      echo $gambar5.'<br>';
    }
  }

  function filter_produk_excel_to_shopee(){
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    // FORM FILTER
    $filter_statusx = $this->security->xss_clean($this->input->post('status_produk'));
    $filter_status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_statusx);

    if($filter_status == "on"){
      $filter_statusxx = "Aktif";
    }else if($filter_status == "off"){
      $filter_statusxx = "Tidak Aktif";
    }else{
      $filter_statusxx = "-";
    }

    $filter_sortbyx = $this->security->xss_clean($this->input->post('sort_by'));
    $filter_sortby = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sortbyx);

    if($filter_sortby == "a_z"){
      $filter_sortbyxx = "A - Z";
    }else if($filter_sortby == "z_a"){
      $filter_sortbyxx = "Z - A";
    }else if($filter_sortby == "low"){
      $filter_sortbyxx = "Harga Terendah - Harga Tertinggi";
    }else if($filter_sortby == "high"){
      $filter_sortbyxx = "Harga Tertinggi - Harga Terendah";
    }else if($filter_sortby == "first_end"){
      $filter_sortbyxx = "Produk lama - produk baru";
    }else if($filter_sortby == "end_first"){
      $filter_sortbyxx = "Produk baru - produk lama";
    }else{
      $filter_sortbyxx = "-";
    }

    $filter_sizex = $this->security->xss_clean($this->input->post('size'));
    $filter_size = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sizex);

    // cari size berdasarkan id
    $caris = $this->produk_adm->carisizeberdasarkanid($filter_size);
    if(!empty($filter_size)){
      $filter_sizexx = $caris['opsi_size'];
    }else{
      $filter_sizexx = "-";
    }

    $filter_colorx = $this->security->xss_clean($this->input->post('color'));
    $filter_color = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_colorx);    

    // cari size berdasarkan id
    $caric = $this->produk_adm->caricolorberdasarkanid($filter_color);
    if(!empty($filter_color)){
      $filter_colorxx = $caric['opsi_color'];
    }else{
      $filter_colorxx = "-";
    }

    $tgl1x = $this->security->xss_clean($this->input->post('tglupload1'));
    $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1x);    

    $tgl2x = $this->security->xss_clean($this->input->post('tglupload2'));
    $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2x);  

    if($tgl1 == "" || $tgl2 == ""){
      $tgl1ch = "";
      $tgl2ch = "";
    }else{
      $tgl1ch = date("d/m/y", strtotime($tgl1));  
      $tgl2ch = date("d/m/y", strtotime($tgl2));  
    }

    // END FORM FILTER
    // ubah format tanggal
    $tgl = date("d-m-Y", strtotime(now()));

    $objPHPExcel = new PHPExcel();
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );      
    // Create a first sheet, representing sales data
    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA STOK PRODUK E-COMMERCE TO SHOPEE"); // Set kolom A1
    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('Data Produk');

      $objPHPExcel->getActiveSheet()->mergeCells('A1:CL1'); // Set Merge Cell pada kolom A1 sampai CL
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1
      // buat informasi apa yang ditarik
      $objPHPExcel->getActiveSheet()->setCellValue('A3','Status');
      $objPHPExcel->getActiveSheet()->setCellValue('A4','Sort By');
      $objPHPExcel->getActiveSheet()->setCellValue('A5','Ukuran');
      $objPHPExcel->getActiveSheet()->setCellValue('A6','Warna');
      $objPHPExcel->getActiveSheet()->setCellValue('A7','Tgl Upload');
      // tampilkan hasil informasi yang ditarik
      $objPHPExcel->getActiveSheet()->setCellValue('B3',$filter_statusxx);
      $objPHPExcel->getActiveSheet()->setCellValue('B4',$filter_sortbyxx);
      $objPHPExcel->getActiveSheet()->setCellValue('B5',$filter_sizexx);
      $objPHPExcel->getActiveSheet()->setCellValue('B6',$filter_colorxx);
      $objPHPExcel->getActiveSheet()->setCellValue('B7',$tgl1ch." - ".$tgl2ch);
      //table header
      $heading = array(
        "Kategori",                       
        "Nama Produk",             
        "Deskripsi Produk",
        "SKU Induk",
        "Kode Integrasi Variasi",
        "Nama Variasi 1",
        "Varian Untuk Variasi 1",
        "Foto Produk per Varian",
        "Nama Variasi 2",
        "Varian untuk Variasi 2",
        "Harga",
        "Stok",
        "Kode Variasi",
        "Foto Sampul",
        "Foto Produk 1",
        "Foto Produk 2",
        "Foto Produk 3",
        "Foto Produk 4",
        "Foto Produk 5",
        "Foto Produk 6",
        "Foto Produk 7",
        "Foto Produk 8",
        "Berat",
        "Panjang",
        "Lebar",
        "Tinggi",
        "J&T Express",
        "JNE Reguler (Cashless)",
        "JNE YES (Cashless)",
        "GoSend Instant",
      );
      //loop heading
      $rowNumberH = 8;
      $colH = 'A'; 
      foreach($heading as $h){
          $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
          $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
          $colH++;    
      }
      // Apply style header yang telah kita buat tadi ke masing-masing kolom header
      // lopping
      // mulai isi data pada baris ke 4
      $baris = 9;
      //$no=0;
      $dataP = $this->produk_adm->filter_produk_excel_shopee($filter_status,$filter_sortby,$filter_size,$filter_color,$tgl1,$tgl2);
      foreach ($dataP as $frow){
        //$no++;

        $idProduk = count($frow->id_produk);

        if($frow->harga_dicoret == "" || $frow->harga_dicoret == 0){
          $harga_awal = 0;
          $harga_net = $frow->harga_fix;
          $diskon = 0;
        }else{
          $harga_awal = $frow->harga_dicoret;
          $harga_net = $frow->harga_dicoret; // BARU BIAR BISA NGESET DISKON
          $diskon = round(($frow->harga_dicoret - $frow->harga_fix) / $frow->harga_dicoret * 100);
        }

        if($frow->berat == "0.5"){
          $berat = 1000;
        }else{
          $berat = $frow->berat*1000;
        }

        // STOK SIZE
        $idp = $frow->id_produk;
        $ck = $this->produk_adm->get_list_produk_for_option_size($idp);    

        // DESKRIPSI TAMBAHAN (SIZE CHART)
        $art1x = $frow->artikel;
        $get_size_produk = $this->produk_adm->get_size_produk($art1x);
        $g = $get_size_produk->row_array();
        $j1 = "Kode Produk : ".$frow->artikel."<br>Size Chart (EU) :<br>";
        $j2 = array();
        foreach($get_size_produk->result() as $u){
          $j2[] = "Size ".$u->opsi_size." Panjang ".$u->cm."cm <br>";
        }
        $j3 = "<br>*Tanyakan ketersediaan stok kepada kami*<br>Happy Shopping !";

        $size1 = implode('|',$j2);
        $size = str_replace('|', '', $size1);

        $keterangan = $frow->keterangan."<br><br>".$j1."".$size."".$j3."";

        $gambar1 = "";
        $gambar2 = "";
        $gambar3 = "";
        $gambar4 = "";
        $gambar5 = "";
        //get gambar sampai 5 gambar 
        $no = 0;
        $sku = $frow->sku_produk;
        $gbppp = $this->produk_adm->get_gambar($sku);
        foreach($gbppp as $gbx){
          $no++;
          if($no == 1){
            $gambar1 = $gbx->gambar;
          }
          if($no == 2){
            $gambar2 = $gbx->gambar;
          }
          if($no == 3){
            $gambar3 = $gbx->gambar;
          }
          if($no == 4){
            $gambar4 = $gbx->gambar;
          }
          if($no == 5){
            $gambar5 = $gbx->gambar;
          }
        }

        //echo $frow->nama_produk.' | '.$frow->gambar_utama;

        //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("A".$baris,"");
        $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $frow->nama_produk);
        $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, strip_tags($keterangan));
        $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $frow->artikel); 
        $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $frow->artikel);
        $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, "Ukuran");
        $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, $frow->opsi_size);
        $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, "");
        $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, "");
        $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, "");
        $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, $harga_net);
        $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, "20");
        $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, $frow->artikel);
        $objPHPExcel->getActiveSheet()->setCellValue("N".$baris, $frow->gambar_utama);
        $objPHPExcel->getActiveSheet()->setCellValue("O".$baris, $gambar2);
        $objPHPExcel->getActiveSheet()->setCellValue("P".$baris, $gambar3);
        $objPHPExcel->getActiveSheet()->setCellValue("Q".$baris, $gambar4);
        $objPHPExcel->getActiveSheet()->setCellValue("R".$baris, $gambar5);
        $objPHPExcel->getActiveSheet()->setCellValue("S".$baris, "");
        $objPHPExcel->getActiveSheet()->setCellValue("T".$baris, "");
        $objPHPExcel->getActiveSheet()->setCellValue("U".$baris, "");
        $objPHPExcel->getActiveSheet()->setCellValue("V".$baris, "");
        $objPHPExcel->getActiveSheet()->setCellValue("W".$baris, $berat);
        $objPHPExcel->getActiveSheet()->setCellValue("X".$baris, "0");
        $objPHPExcel->getActiveSheet()->setCellValue("Y".$baris, "0");
        $objPHPExcel->getActiveSheet()->setCellValue("Z".$baris, "0");
        $objPHPExcel->getActiveSheet()->setCellValue("AA".$baris, "Aktif");
        $objPHPExcel->getActiveSheet()->setCellValue("AB".$baris, "Aktif");
        $objPHPExcel->getActiveSheet()->setCellValue("AC".$baris, "Aktif");
        $objPHPExcel->getActiveSheet()->setCellValue("AD".$baris, "Aktif");

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('W'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('X'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('Y'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('Z'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AA'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AB'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AC'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('AD'.$baris)->applyFromArray($style_row);

      $baris++;
      }
      // end lopping

      // Set width kolom
      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
      $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
      $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true); 

      // Redirect output to a client’s web browser (Excel5)
      $filename = urlencode("Data_Produk_E-commerce_To_Shopee_By_Filter_status produk_".$filter_statusxx."_sort_by_".$filter_sortbyxx."_ukuran_".$filter_sizexx."_warna_".$filter_colorxx."_range_tanggal_".$tgl1ch."-".$tgl2ch.".xls");
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');
      $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save('php://output');
      log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Data Produk (Excel) Ke Shopee dengan filter status produk '.$filter_statusxx.' sort by '.$filter_sortbyxx.' ukuran '.$filter_sizexx.' warna '.$filter_colorxx.'_range_tanggal_'.$tgl1ch.'-'.$tgl2ch.'');
  }

  function filter_produk_excel_to_lazada(){
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    // FORM FILTER
    $filter_statusx = $this->security->xss_clean($this->input->post('status_produk'));
    $filter_status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_statusx);

    if($filter_status == "on"){
      $filter_statusxx = "Aktif";
    }else if($filter_status == "off"){
      $filter_statusxx = "Tidak Aktif";
    }else{
      $filter_statusxx = "-";
    }

    $filter_sortbyx = $this->security->xss_clean($this->input->post('sort_by'));
    $filter_sortby = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sortbyx);

    if($filter_sortby == "a_z"){
      $filter_sortbyxx = "A - Z";
    }else if($filter_sortby == "z_a"){
      $filter_sortbyxx = "Z - A";
    }else if($filter_sortby == "low"){
      $filter_sortbyxx = "Harga Terendah - Harga Tertinggi";
    }else if($filter_sortby == "high"){
      $filter_sortbyxx = "Harga Tertinggi - Harga Terendah";
    }else if($filter_sortby == "first_end"){
      $filter_sortbyxx = "Produk lama - produk baru";
    }else if($filter_sortby == "end_first"){
      $filter_sortbyxx = "Produk baru - produk lama";
    }else{
      $filter_sortbyxx = "-";
    }

    $filter_sizex = $this->security->xss_clean($this->input->post('size'));
    $filter_size = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sizex);

    // cari size berdasarkan id
    $caris = $this->produk_adm->carisizeberdasarkanid($filter_size);
    if(!empty($filter_size)){
      $filter_sizexx = $caris['opsi_size'];
    }else{
      $filter_sizexx = "-";
    }

    $filter_colorx = $this->security->xss_clean($this->input->post('color'));
    $filter_color = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_colorx);    

    // cari size berdasarkan id
    $caric = $this->produk_adm->caricolorberdasarkanid($filter_color);
    if(!empty($filter_color)){
      $filter_colorxx = $caric['opsi_color'];
    }else{
      $filter_colorxx = "-";
    }

    $filter_kategorix = $this->security->xss_clean($this->input->post('kategori'));
    $filter_kategori = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_kategorix);    

    $findkategori = $this->produk_adm->find_kategori($filter_kategori);

    $tgl1x = $this->security->xss_clean($this->input->post('tglupload1'));
    $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1x);    

    $tgl2x = $this->security->xss_clean($this->input->post('tglupload2'));
    $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2x);  

    if($tgl1 == "" || $tgl2 == ""){
      $tgl1ch = "";
      $tgl2ch = "";
    }else{
      $tgl1ch = date("d/m/y", strtotime($tgl1));  
      $tgl2ch = date("d/m/y", strtotime($tgl2));  
    }

    // END FORM FILTER
    // ubah format tanggal
    $tgl = date("d-m-Y", strtotime(now()));

    $objPHPExcel = new PHPExcel();
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );      
    // Create a first sheet, representing sales data
    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA STOK PRODUK E-COMMERCE TO LAZADA - ".strtoupper($findkategori['kategori']).""); // Set kolom A1
    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('Data Produk '.$findkategori['kategori'].'');

    $objPHPExcel->getActiveSheet()->mergeCells('A1:CL1'); // Set Merge Cell pada kolom A1 sampai CL
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1
    // buat informasi apa yang ditarik
    $objPHPExcel->getActiveSheet()->setCellValue('A3','Status');
    $objPHPExcel->getActiveSheet()->setCellValue('A4','Sort By');
    $objPHPExcel->getActiveSheet()->setCellValue('A5','Ukuran');
    $objPHPExcel->getActiveSheet()->setCellValue('A6','Warna');
    $objPHPExcel->getActiveSheet()->setCellValue('A7','Tgl Upload');
    // tampilkan hasil informasi yang ditarik
    $objPHPExcel->getActiveSheet()->setCellValue('B3',$filter_statusxx);
    $objPHPExcel->getActiveSheet()->setCellValue('B4',$filter_sortbyxx);
    $objPHPExcel->getActiveSheet()->setCellValue('B5',$filter_sizexx);
    $objPHPExcel->getActiveSheet()->setCellValue('B6',$filter_colorxx);
    $objPHPExcel->getActiveSheet()->setCellValue('B7',$tgl1ch." - ".$tgl2ch);

    // DILAZADA SETIAP KATEGORI BEDA2 POSISI KOLOMNYA MAKANYA DIKASIH IF CONDITION
      if($findkategori['kategori'] == "Pria" || $findkategori['kategori'] == "Anak - anak"){
        //table header
        $heading = array(
         "PrimaryCategory",
         "Brand",
         "color_family",
         "model",
         "kids_years",
         "belt_material",
         "belt_styles",
         "fa_create_year",
         "is_unisex",
         "leather_material",
         "kid_occasion",
         "fa_patern",
         "kid_accessories",
         "clothing_material",
         "hats_style",
         "hat_brim_styles",
         "jackets_closure_type",
         "hoodie_style_type",
         "sleeves",
         "collar_type",
         "jacket_coat_styles",
         "pants_fit_type",
         "pants_lenght",
         "m_pantshort_fit_type",
         "pants_fly",
         "waist_type",
         "kids_sleep_styles",
         "m_top_neckline",
         "m_swimwear_styles",
         "number_of_pieces",
         "tee_sleeve_length",
         "umbrella_category",
         "socks_tight_style",
         "toe_shape",
         "boot_shaft_height",
         "kid_boot_type",
         "kid_material_filter",
         "shoes_closuretype",
         "fa_general_styles",
         "men_shoes_closure",
         "occasion",
         "kid_accessory_type",
         "kid_sneaker_height",
         "kid_sneaker_type",
         "mens_trend",
         "tie_width",
         "scarves_styles",
         "lenght",
         "top_fit_types",
         "shalat_styles",
         "m_sleeve_lenght",
         "jeans_wash_color",
         "material_filter",
         "jeans_decoration",
         "jeans_fit_type",
         "tee_neckline",
         "m_underware_style",
         "sleep_lounge_syles",
         "shoe_accessory_type",
         "sneaker_upperheight",
         "sneakers_style",
         "name",  // kolom BJ
         "name_en",
         "description",
         "description_en",
         "short_description",  
         "short_description_en",
         "hazmat",
         "warranty_type",
         "product_warranty",
         "warranty",
         "video",
         "price",
         "special_price",
         "special_from_date",
         "special_to_date",
         "SellerSku",
         "AssociatedSku",
         "quantity",
         "package_content",
         "package_lenght",
         "package_width",
         "package_height",
         "package_weight",
         "MainImage",
         "Image2",
         "Image3",
         "Image4",
         "Image5",
         "Image6",
         "Image7",
         "Image8",
         "package_contents_en",
         "size",
         "color_thumbnail",
        );
        //loop heading
        $rowNumberH = 8;
        $colH = 'A'; 
        foreach($heading as $h){
            $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
            $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
            $colH++;    
        }
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        // lopping
        // mulai isi data pada baris ke 4
        $baris = 9;
        $dataP = $this->produk_adm->filter_produk_excel_lazada($filter_status,$filter_sortby,$filter_size,$filter_color,$filter_kategori,$tgl1,$tgl2);
        foreach ($dataP as $frow){

          $idProduk = count($frow->id_produk);

          if($frow->harga_dicoret == "" || $frow->harga_dicoret == 0){
            $harga_awal = $frow->harga_fix;
            $harga_net = "";
            $diskon = 0;
          }else{
            $harga_awal = $frow->harga_dicoret;
            $harga_net = $frow->harga_fix; // BARU BIAR BISA NGESET DISKON
            $diskon = round(($frow->harga_dicoret - $frow->harga_fix) / $frow->harga_dicoret * 100);
          }

          $gambar1 = "";
          $gambar2 = "";
          $gambar3 = "";
          $gambar4 = "";
          $gambar5 = "";
          //get gambar sampai 5 gambar 
          $no = 0;
          $sku = $frow->sku_produk;
          $gbppp = $this->produk_adm->get_gambar($sku);
          foreach($gbppp as $gbx){
            $no++;
            if($no == 1){
              $gambar1 = $gbx->gambar;
            }
            if($no == 2){
              $gambar2 = $gbx->gambar;
            }
            if($no == 3){
              $gambar3 = $gbx->gambar;
            }
            if($no == 4){
              $gambar4 = $gbx->gambar;
            }
            if($no == 5){
              $gambar5 = $gbx->gambar;
            }
          }

          // UKURAN
          $idp = $frow->id_produk;
          $sz = $this->produk_adm->get_list_produk_for_option_size($idp);    

          // WARNA
          $idp = $frow->id_produk;
          $ck = $this->produk_adm->get_list_produk_for_option_color($idp);     

          // DESKRIPSI TAMBAHAN (SIZE CHART)
          $art1x = $frow->artikel;
          $get_size_produk = $this->produk_adm->get_size_produk($art1x);
          $g = $get_size_produk->row_array();
          $j1 = "Kode Produk : ".$frow->artikel."<br>Size Chart (EU) :<br>";
          $j2 = array();
          foreach($get_size_produk->result() as $u){
            $j2[] = "Size ".$u->opsi_size." Panjang ".$u->cm."cm <br>";
          }
          $j3 = "<br>*Tanyakan ketersediaan stok kepada kami*<br>Happy Shopping !";

          $size1 = implode('|',$j2);
          $size = str_replace('|', '', $size1);

          $keterangan = $frow->keterangan."<br><br>".$j1."".$size."".$j3.""; 

          // merk 
          if($frow->merk == "Jane Vanda"){
            $merk = "Jane vanda";
          }else if($frow->merk == "Benn-x"){
            $merk = "Bennx";
          }else if($frow->merk == "Tiffany Kenanga"){
            $merk = "TiffanyKenanga SIGNATURE";
          }else if($frow->merk == "RAJ"){
            $merk = "RA Jeans";
          }else if($frow->merk == "mickelson"){
            $merk = "MICKELSON";
          }else if($frow->merk == "RAJ"){
            $merk = "RA Jeans Footwear";
          }else{
            $merk = $frow->merk;
          }

          //pemanggilan sesuaikan dengan nama kolom tabel
          $objPHPExcel->getActiveSheet()->setCellValue("A".$baris,"");
          $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, "Stars"); //$merk
          $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $ck['opsi_color']);
          $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("N".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("O".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("P".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("Q".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("R".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("S".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("T".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("U".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("V".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("W".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("X".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("Y".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("Z".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AA".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AB".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AC".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AD".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AE".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AF".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AG".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AH".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AI".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AJ".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AK".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AL".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AM".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AN".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AO".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AP".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AQ".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AR".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AS".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AT".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AU".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AV".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AW".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AX".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AY".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AZ".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BA".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BB".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BC".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BD".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BE".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BF".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BF".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BG".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BH".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BI".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BJ".$baris, $frow->nama_produk); 
          $objPHPExcel->getActiveSheet()->setCellValue("BK".$baris, $frow->nama_produk); 
          $objPHPExcel->getActiveSheet()->setCellValue("BL".$baris, $keterangan); 
          $objPHPExcel->getActiveSheet()->setCellValue("BM".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BN".$baris, $keterangan); 
          $objPHPExcel->getActiveSheet()->setCellValue("BO".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BQ".$baris, "Tidak Ada Garansi"); 
          $objPHPExcel->getActiveSheet()->setCellValue("BR".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BS".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BT".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BU".$baris, $harga_awal); 
          $objPHPExcel->getActiveSheet()->setCellValue("BV".$baris, $harga_net); 
          $objPHPExcel->getActiveSheet()->setCellValue("BW".$baris, date("d/m/y")." Diketik lagi format YYYY-MM-DD");
          $objPHPExcel->getActiveSheet()->setCellValue("BX".$baris, date('d/m/y', strtotime('2 years'))." Diketik lagi format YYYY-MM-DD"); // sampai 2 tahun 
          $objPHPExcel->getActiveSheet()->setCellValue("BY".$baris, $frow->artikel." ".$frow->opsi_size); //$sz['opsi_size']
          $objPHPExcel->getActiveSheet()->setCellValue("BZ".$baris, $frow->artikel); 
          $objPHPExcel->getActiveSheet()->setCellValue("CA".$baris, "20"); //$ck['stok']
          $objPHPExcel->getActiveSheet()->setCellValue("CB".$baris, "sepasang"); 
          $objPHPExcel->getActiveSheet()->setCellValue("CC".$baris, "30"); 
          $objPHPExcel->getActiveSheet()->setCellValue("CD".$baris, "20"); 
          $objPHPExcel->getActiveSheet()->setCellValue("CE".$baris, "10"); 
          $objPHPExcel->getActiveSheet()->setCellValue("CF".$baris, $frow->berat); 
          $objPHPExcel->getActiveSheet()->setCellValue("CG".$baris, $frow->gambar); 
          $objPHPExcel->getActiveSheet()->setCellValue("CH".$baris, $gambar2); 
          $objPHPExcel->getActiveSheet()->setCellValue("CI".$baris, $gambar3); 
          $objPHPExcel->getActiveSheet()->setCellValue("CJ".$baris, $gambar4); 
          $objPHPExcel->getActiveSheet()->setCellValue("CK".$baris, $gambar5); 
          $objPHPExcel->getActiveSheet()->setCellValue("CL".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CM".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CN".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CO".$baris, "sepasang"); 
          $objPHPExcel->getActiveSheet()->setCellValue("CP".$baris, "EU:".$frow->opsi_size); 
          $objPHPExcel->getActiveSheet()->setCellValue("CQ".$baris, ""); 

          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
          $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('W'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('X'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('Y'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('Z'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AA'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AB'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AC'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AD'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AE'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AF'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AG'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AH'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AI'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AJ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AK'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AL'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AM'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AN'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AO'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AP'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AQ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AR'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AS'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AT'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AU'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AV'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AW'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AX'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AY'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AZ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BA'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BB'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BC'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BD'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BE'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BF'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BG'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BH'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BI'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BJ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BK'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BL'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BM'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BN'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BO'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BP'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BQ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BR'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BS'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BT'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BU'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BV'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BW'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BX'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BY'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BZ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CA'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CB'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CC'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CD'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CE'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CF'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CG'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CH'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CI'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CJ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CK'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CL'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CM'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CN'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CO'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CP'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CQ'.$baris)->applyFromArray($style_row);

          $baris++;
        }
        // end lopping

           // Set width kolom
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);  
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CI')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CJ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CK')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CL')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CM')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CN')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CO')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CP')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CQ')->setAutoSize(true); 
    }else if($findkategori['kategori'] == "Wanita"){
      //table header
        $heading = array(
         "PrimaryCategory",
         "Brand",
         "color_family",
         "model",
         "fa_patern",
         "belt_material",
         "belt_styles",
         "fa_create_year",
         "kids_years",
         "leather_material",
         "kid_occasion",
         "is_unisex",
         "pants_lenght",  
         "clothing_material",
         "waist_type",
         "bottoms_types",
         "pants_fly",
         "skirt_length",
         "dress_shape",
         "dress_length",
         "sleeves",
         "number_of_pieces",
         "w_blouse_sleevestyle",
         "collar_type",
         "kid_accessories",
         "hair_accessories",
         "hats_style",
         "hat_brim_styles",
         "hoodie_style_type",
         "jacket_coat_styles",
         "jackets_closure_type",
         "sock_tight_style",
         "kid_swimwear",
         "tops_type",
         "umbrella_category",
         "kid_underwear_styles",
         "kid_sleep_styles",
         "material_filter",
         "toe_shape",
         "heel_height",
         "type_of_heels",
         "boot_shaft_height",
         "kid_boot_type",
         "shoes_closuretype",
         "shoes_decoration",
         "kid_flat_type",
         "kid_material_filter",
         "kid_accessory_type",
         "kid_sneaker_height",
         "kid_sneaker_type",
         "bag_shape",
         "wallet_types",
         "fa_general_styles",
         "occasion",
         "shoe_accessory_type",
         "men_shoes_closure",
         "mens_trend",
         "sneaker_upperheight",
         "sneakers_style",
         "main_stone",
         "material_type",
         "metal",
         "scarves_styles",
         "beach_style",
         "tee_neckline",
         "tee_sleeve_length",
         "womens_trend",
         "w_sleeve_length",
         "jeans_decoration",
         "jeans_fit_type",
         "denim_features",
         "pants_fit_type",
         "intimates_types",
         "bras_types",
         "panties_styles",
         "lingerie_styles",
         "shapers_styles",
         "sleep_lounge_styles",
         "materinity_bottom_styles",
         "clothing_decoration",
         "listed_year_season",
         "pants_style",
         "w_swimwear_style",
         "swimwear_type",
         "maternity_top_styles",
         "accessories_types",
         "mus_dress_styles",
         "hijab_styles",
         "shalat_styles",
         "mus_top_styles",
         "top_types",
         "skirt_style",
         "sandal_type",
         "name",
         "name_en",
         "description",
         "description_en",
         "short_description",  
         "short_description_en",
         "hazmat",
         "warranty_type",
         "product_warranty",
         "warranty",
         "video",
         "price",
         "special_price",
         "special_from_date",
         "special_to_date",
         "SellerSku",
         "AssociatedSku",
         "quantity",
         "package_content",
         "package_lenght",
         "package_width",
         "package_height",
         "package_weight",
         "MainImage",
         "Image2",
         "Image3",
         "Image4",
         "Image5",
         "Image6",
         "Image7",
         "Image8",
         "package_contents_en",
         "size",
         "color_thumbnail",
        );
        //loop heading
        $rowNumberH = 8;
        $colH = 'A'; 
        foreach($heading as $h){
            $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
            $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
            $colH++;    
        }
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        // lopping
        // mulai isi data pada baris ke 4
        $baris = 9;
        $no=0;
        $dataP = $this->produk_adm->filter_produk_excel_lazada($filter_status,$filter_sortby,$filter_size,$filter_color,$filter_kategori,$tgl1,$tgl2);
        foreach ($dataP as $frow){
          $no++;

          $idProduk = count($frow->id_produk);

          if($frow->harga_dicoret == "" || $frow->harga_dicoret == 0){
            $harga_awal = $frow->harga_fix;
            $harga_net = "";
            $diskon = 0;
          }else{
            $harga_awal = $frow->harga_dicoret;
            $harga_net = $frow->harga_fix; // BARU BIAR BISA NGESET DISKON
            $diskon = round(($frow->harga_dicoret - $frow->harga_fix) / $frow->harga_dicoret * 100);
          }

          $gambar1 = "";
          $gambar2 = "";
          $gambar3 = "";
          $gambar4 = "";
          $gambar5 = "";
          //get gambar sampai 5 gambar 
          $no = 0;
          $sku = $frow->sku_produk;
          $gbppp = $this->produk_adm->get_gambar($sku);
          foreach($gbppp as $gbx){
            $no++;
            if($no == 1){
              $gambar1 = $gbx->gambar;
            }
            if($no == 2){
              $gambar2 = $gbx->gambar;
            }
            if($no == 3){
              $gambar3 = $gbx->gambar;
            }
            if($no == 4){
              $gambar4 = $gbx->gambar;
            }
            if($no == 5){
              $gambar5 = $gbx->gambar;
            }
          }

          // UKURAN
          $idp = $frow->id_produk;
          $sz = $this->produk_adm->get_list_produk_for_option_size($idp);    

          // WARNA
          $idp = $frow->id_produk;
          $ck = $this->produk_adm->get_list_produk_for_option_color($idp);     

          // DESKRIPSI TAMBAHAN (SIZE CHART)
          $art1x = $frow->artikel;
          $get_size_produk = $this->produk_adm->get_size_produk($art1x);
          $g = $get_size_produk->row_array();
          $j1 = "Kode Produk : ".$frow->artikel."<br>Size Chart (EU) :<br>";
          $j2 = array();
          foreach($get_size_produk->result() as $u){
            $j2[] = "Size ".$u->opsi_size." Panjang ".$u->cm."cm <br>";
          }
          $j3 = "<br>*Tanyakan ketersediaan stok kepada kami*<br>Happy Shopping !";

          $size1 = implode('|',$j2);
          $size = str_replace('|', '', $size1);

          $keterangan = $frow->keterangan."<br><br>".$j1."".$size."".$j3.""; 

          // merk 
          if($frow->merk == "Jane Vanda"){
            $merk = "Jane vanda";
          }else if($frow->merk == "Benn-x"){
            $merk = "Bennx";
          }else if($frow->merk == "Tiffany Kenanga"){
            $merk = "TiffanyKenanga SIGNATURE";
          }else if($frow->merk == "RAJ"){
            $merk = "RA Jeans";
          }else if($frow->merk == "mickelson"){
            $merk = "MICKELSON";
          }else if($frow->merk == "RAJ"){
            $merk = "RA Jeans Footwear";
          }else{
            $merk = $frow->merk;
          }

          //pemanggilan sesuaikan dengan nama kolom tabel
          $objPHPExcel->getActiveSheet()->setCellValue("A".$baris,"");
          $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, "Stars"); //$merk
          $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $ck['opsi_color']);
          $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("N".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("O".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("P".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("Q".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("R".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("S".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("T".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("U".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("V".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("W".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("X".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("Y".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("Z".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AA".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AB".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AC".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AD".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AE".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AF".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AG".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AH".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AI".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AJ".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AK".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AL".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AM".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AN".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AO".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AP".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AQ".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AR".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AS".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AT".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AU".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AV".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AW".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AX".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AY".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("AZ".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BA".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BB".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BC".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BD".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BE".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BF".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BF".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BG".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BH".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BI".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BJ".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BK".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BL".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BM".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BN".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BO".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BP".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BQ".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BR".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BS".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BT".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BU".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BV".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BW".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BX".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BY".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("BZ".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CA".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CB".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CC".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CD".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CE".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CF".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CG".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CH".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CI".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CJ".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CK".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CL".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CM".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CN".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CO".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CP".$baris, $frow->nama_produk); 
          $objPHPExcel->getActiveSheet()->setCellValue("CQ".$baris, $frow->nama_produk); 
          $objPHPExcel->getActiveSheet()->setCellValue("CR".$baris, $keterangan); 
          $objPHPExcel->getActiveSheet()->setCellValue("CS".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CT".$baris, $keterangan); 
          $objPHPExcel->getActiveSheet()->setCellValue("CU".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CV".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CW".$baris, "Tidak Ada Garansi"); 
          $objPHPExcel->getActiveSheet()->setCellValue("CX".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CY".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("CZ".$baris, $harga_awal); 
          $objPHPExcel->getActiveSheet()->setCellValue("DA".$baris, $harga_net); 
          $objPHPExcel->getActiveSheet()->setCellValue("DB".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("DC".$baris, date("d/m/y")." Diketik lagi format YYYY-MM-DD");
          $objPHPExcel->getActiveSheet()->setCellValue("DD".$baris, date('d/m/y', strtotime('2 years'))." Diketik lagi format YYYY-MM-DD"); // sampai 2 tahun 
          $objPHPExcel->getActiveSheet()->setCellValue("DE".$baris, $frow->artikel." ".$frow->opsi_size);//$sz['opsi_size']); 
          $objPHPExcel->getActiveSheet()->setCellValue("DF".$baris, $frow->artikel); 
          $objPHPExcel->getActiveSheet()->setCellValue("DG".$baris, "20");  //$ck['stok']
          $objPHPExcel->getActiveSheet()->setCellValue("DH".$baris, "sepasang"); 
          $objPHPExcel->getActiveSheet()->setCellValue("DI".$baris, "30"); 
          $objPHPExcel->getActiveSheet()->setCellValue("DJ".$baris, "20"); 
          $objPHPExcel->getActiveSheet()->setCellValue("DK".$baris, "10"); 
          $objPHPExcel->getActiveSheet()->setCellValue("DL".$baris, $frow->berat); 
          $objPHPExcel->getActiveSheet()->setCellValue("DM".$baris, $frow->gambar); 
          $objPHPExcel->getActiveSheet()->setCellValue("DN".$baris, $gambar2); 
          $objPHPExcel->getActiveSheet()->setCellValue("DO".$baris, $gambar3); 
          $objPHPExcel->getActiveSheet()->setCellValue("DP".$baris, $gambar4); 
          $objPHPExcel->getActiveSheet()->setCellValue("DQ".$baris, $gambar5); 
          $objPHPExcel->getActiveSheet()->setCellValue("DR".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("DS".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("DT".$baris, ""); 
          $objPHPExcel->getActiveSheet()->setCellValue("DU".$baris, "sepasang"); 
          $objPHPExcel->getActiveSheet()->setCellValue("DV".$baris, "EU:".$frow->opsi_size); 
          $objPHPExcel->getActiveSheet()->setCellValue("DW".$baris, ""); 

          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
          $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('W'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('X'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('Y'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('Z'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AA'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AB'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AC'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AD'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AE'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AF'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AG'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AH'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AI'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AJ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AK'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AL'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AM'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AN'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AO'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AP'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AQ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AR'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AS'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AT'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AU'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AV'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AW'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AX'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AY'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('AZ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BA'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BB'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BC'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BD'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BE'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BF'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BG'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BH'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BI'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BJ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BK'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BL'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BM'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BN'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BO'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BP'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BQ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BR'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BS'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BT'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BU'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BV'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BW'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BX'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BY'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('BZ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CA'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CB'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CC'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CD'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CE'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CF'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CG'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CH'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CI'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CJ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CK'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CL'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CM'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CN'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CO'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CP'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CQ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CR'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CS'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CT'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CU'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CV'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CW'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CX'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CY'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('CZ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DA'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DB'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DC'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DD'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DE'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DF'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DG'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DH'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DI'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DJ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DK'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DL'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DM'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DN'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DO'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DP'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DQ'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DR'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DS'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DT'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DU'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DV'.$baris)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('DW'.$baris)->applyFromArray($style_row);


          $baris++;
        }
        // end lopping

           // Set width kolom
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);  
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CI')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CJ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CK')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CL')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CM')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CN')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CO')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CP')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CQ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CR')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CS')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CT')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CU')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CV')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CW')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CX')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CY')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('CZ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DA')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DB')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DC')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DD')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DE')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DF')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DG')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DH')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DI')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DJ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DK')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DL')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DM')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DN')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DO')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DP')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DQ')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DR')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DS')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DT')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DU')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DV')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('DW')->setAutoSize(true); 
    }

    // Redirect output to a client’s web browser (Excel5)
    $filename = urlencode("Data_Produk_E-commerce_To_Lazada_".$findkategori['kategori']."_By_Filter_status produk_".$filter_statusxx."_sort_by_".$filter_sortbyxx."_ukuran_".$filter_sizexx."_warna_".$filter_colorxx."_range_tanggal_".$tgl1ch."-".$tgl2ch.".xls");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Data Produk (Excel) Ke Lazada '.$findkategori['kategori'].' dengan filter status produk '.$filter_statusxx.' sort by '.$filter_sortbyxx.' ukuran '.$filter_sizexx.' warna '.$filter_colorxx.'_range_tanggal_'.$tgl1ch.'-'.$tgl2ch.'');   
  }

  function filter_produk_excel_to_tokopedia(){
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    // FORM FILTER
    $filter_statusx = $this->security->xss_clean($this->input->post('status_produk'));
    $filter_status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_statusx);

    if($filter_status == "on"){
      $filter_statusxx = "Aktif";
    }else if($filter_status == "off"){
      $filter_statusxx = "Tidak Aktif";
    }else{
      $filter_statusxx = "-";
    }

    $filter_sortbyx = $this->security->xss_clean($this->input->post('sort_by'));
    $filter_sortby = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sortbyx);

    if($filter_sortby == "a_z"){
      $filter_sortbyxx = "A - Z";
    }else if($filter_sortby == "z_a"){
      $filter_sortbyxx = "Z - A";
    }else if($filter_sortby == "low"){
      $filter_sortbyxx = "Harga Terendah - Harga Tertinggi";
    }else if($filter_sortby == "high"){
      $filter_sortbyxx = "Harga Tertinggi - Harga Terendah";
    }else if($filter_sortby == "first_end"){
      $filter_sortbyxx = "Produk lama - produk baru";
    }else if($filter_sortby == "end_first"){
      $filter_sortbyxx = "Produk baru - produk lama";
    }else{
      $filter_sortbyxx = "-";
    }

    $filter_sizex = $this->security->xss_clean($this->input->post('size'));
    $filter_size = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sizex);

    // cari size berdasarkan id
    $caris = $this->produk_adm->carisizeberdasarkanid($filter_size);
    if(!empty($filter_size)){
      $filter_sizexx = $caris['opsi_size'];
    }else{
      $filter_sizexx = "-";
    }

    $filter_colorx = $this->security->xss_clean($this->input->post('color'));
    $filter_color = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_colorx);    

    // cari size berdasarkan id
    $caric = $this->produk_adm->caricolorberdasarkanid($filter_color);
    if(!empty($filter_color)){
      $filter_colorxx = $caric['opsi_color'];
    }else{
      $filter_colorxx = "-";
    }

    $tgl1x = $this->security->xss_clean($this->input->post('tglupload1'));
    $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1x);    

    $tgl2x = $this->security->xss_clean($this->input->post('tglupload2'));
    $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2x);  

    if($tgl1 == "" || $tgl2 == ""){
      $tgl1ch = "";
      $tgl2ch = "";
    }else{
      $tgl1ch = date("d/m/y", strtotime($tgl1));  
      $tgl2ch = date("d/m/y", strtotime($tgl2));  
    }

    // END FORM FILTER
    // ubah format tanggal
    $tgl = date("d-m-Y", strtotime(now()));

    $objPHPExcel = new PHPExcel();
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
      $style_col = array(
        'font' => array('bold' => true), // Set font nya jadi bold
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );
      // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
      $style_row = array(
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );      
      // Create a first sheet, representing sales data
      $objPHPExcel->setActiveSheetIndex(0);

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA STOK PRODUK E-COMMERCE TO TOKOPEDIA"); // Set kolom A1
      // Rename sheet
      $objPHPExcel->getActiveSheet()->setTitle('Data Produk');

        $objPHPExcel->getActiveSheet()->mergeCells('A1:CL1'); // Set Merge Cell pada kolom A1 sampai CL
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1
        // buat informasi apa yang ditarik
        $objPHPExcel->getActiveSheet()->setCellValue('A3','Status');
        $objPHPExcel->getActiveSheet()->setCellValue('A4','Sort By');
        $objPHPExcel->getActiveSheet()->setCellValue('A5','Ukuran');
        $objPHPExcel->getActiveSheet()->setCellValue('A6','Warna');
        $objPHPExcel->getActiveSheet()->setCellValue('A7','Tgl Upload');
        // tampilkan hasil informasi yang ditarik
        $objPHPExcel->getActiveSheet()->setCellValue('B3',$filter_statusxx);
        $objPHPExcel->getActiveSheet()->setCellValue('B4',$filter_sortbyxx);
        $objPHPExcel->getActiveSheet()->setCellValue('B5',$filter_sizexx);
        $objPHPExcel->getActiveSheet()->setCellValue('B6',$filter_colorxx);
        $objPHPExcel->getActiveSheet()->setCellValue('B7',$tgl1ch." - ".$tgl2ch);
      //table header
      $heading = array(
        "Nama Produk",   
        "SKU",
        "Kategori",
        "Deskripsi",
        "Harga",
        "Berat(Gr)",
        "Pesanan Minimum",
        "Status",
        "Jumlah Stok",
        "Etalase",
        "Preorder",
        "Waktu Proses Order",
        "Kondisi",
        "Gambar 1",
        "Gambar 2",
        "Gambar 3",
        "Gambar 4",
        "Gambar 5",
        "URL Video Produk 1",
        "URL Video Produk 2",
        "URL Video Produk 3",
        );
          //loop heading
        $rowNumberH = 8;
        $colH = 'A'; 
        foreach($heading as $h){
            $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
            $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
            $colH++;    
        }
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
          // lopping
          // mulai isi data pada baris ke 4
          $baris = 9;
          $dataP = $this->produk_adm->filter_produk_excel($filter_status,$filter_sortby,$filter_size,$filter_color,$tgl1,$tgl2);
          foreach ($dataP as $frow){

            $idProduk = count($frow->id_produk);

            if($frow->harga_dicoret == "" || $frow->harga_dicoret == 0){
              $harga_awal = 0;
              $harga_net = $frow->harga_fix;
              $diskon = 0;
            }else{
              $harga_awal = $frow->harga_dicoret;
              $harga_net = $frow->harga_dicoret; // TOKOPEDIA BERUBAH OFICIAL AUTO DISKON OFF HARGANYA AWAL NANTI DI SET DISKON SENDIRI
              $diskon = round(($frow->harga_dicoret - $frow->harga_fix) / $frow->harga_dicoret * 100);
            }

            if($frow->berat == "0.5"){
              $berat = 1000;
            }else{
              $berat = $frow->berat*1000;
            }

            $gambar1 = "";
            $gambar2 = "";
            $gambar3 = "";
            $gambar4 = "";
            $gambar5 = "";
            //get gambar sampai 5 gambar 
            $no = 0;
            $sku = $frow->sku_produk;
            $gbppp = $this->produk_adm->get_gambar($sku);
            foreach($gbppp as $gbx){
              $no++;
              if($no == 1){
                $gambar1 = $gbx->gambar;
              }
              if($no == 2){
                $gambar2 = $gbx->gambar;
              }
              if($no == 3){
                $gambar3 = $gbx->gambar;
              }
              if($no == 4){
                $gambar4 = $gbx->gambar;
              }
              if($no == 5){
                $gambar5 = $gbx->gambar;
              }
            }

            // DESKRIPSI TAMBAHAN (SIZE CHART)
            $art1x = $frow->artikel;
            $get_size_produk = $this->produk_adm->get_size_produk($art1x);
            $g = $get_size_produk->row_array();
            $j1 = "Kode Produk : ".$frow->artikel."<br>Size Chart (EU) :<br>";
            $j2 = array();
            foreach($get_size_produk->result() as $u){
              $j2[] = "Size ".$u->opsi_size." Panjang ".$u->cm."cm <br>";
            }
            $j3 = "<br>*Tanyakan ketersediaan stok kepada kami*<br>Happy Shopping !";

            $size1 = implode('|',$j2);
            $size = str_replace('|', '', $size1);

            $keterangan = $frow->keterangan."<br><br>".$j1."".$size."".$j3.""; 

            //pemanggilan sesuaikan dengan nama kolom tabel
            $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $frow->nama_produk);
            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $frow->artikel);
            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, "");
            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, strip_tags($keterangan));
            $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $harga_net); 
            $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $berat);
            $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, "1");
            $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, "Aktif");
            $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, "20");
            $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, "");
            $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, "Tidak");
            $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, "");
            $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, "Baru");
            $objPHPExcel->getActiveSheet()->setCellValue("N".$baris, $frow->gambar_utama);
            $objPHPExcel->getActiveSheet()->setCellValue("O".$baris, $gambar2);
            $objPHPExcel->getActiveSheet()->setCellValue("P".$baris, $gambar3);
            $objPHPExcel->getActiveSheet()->setCellValue("Q".$baris, $gambar4);
            $objPHPExcel->getActiveSheet()->setCellValue("R".$baris, $gambar5);
            $objPHPExcel->getActiveSheet()->setCellValue("S".$baris, "");
            $objPHPExcel->getActiveSheet()->setCellValue("T".$baris, "");
            $objPHPExcel->getActiveSheet()->setCellValue("U".$baris, "");


            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);

            $baris++;
          }
          // end lopping

           // Set width kolom
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true); 

    // Redirect output to a client’s web browser (Excel5)
    $filename = urlencode("Data_Produk_E-commerce_To_Tokopedia_By_Filter_status produk_".$filter_statusxx."_sort_by_".$filter_sortbyxx."_ukuran_".$filter_sizexx."_warna_".$filter_colorxx."_range_tanggal_".$tgl1ch."-".$tgl2ch.".xls");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Data Produk (Excel) Ke Tokopedia dengan filter status produk '.$filter_statusxx.' sort by '.$filter_sortbyxx.' ukuran '.$filter_sizexx.' warna '.$filter_colorxx.'_range_tanggal_'.$tgl1ch.'-'.$tgl2ch.'');
  }

  function filter_produk_excel_to_bukalapak(){
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    // FORM FILTER
    $filter_statusx = $this->security->xss_clean($this->input->post('status_produk'));
    $filter_status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_statusx);

    if($filter_status == "on"){
      $filter_statusxx = "Aktif";
    }else if($filter_status == "off"){
      $filter_statusxx = "Tidak Aktif";
    }else{
      $filter_statusxx = "-";
    }

    $filter_sortbyx = $this->security->xss_clean($this->input->post('sort_by'));
    $filter_sortby = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sortbyx);


    if($filter_sortby == "a_z"){
      $filter_sortbyxx = "A - Z";
    }else if($filter_sortby == "z_a"){
      $filter_sortbyxx = "Z - A";
    }else if($filter_sortby == "low"){
      $filter_sortbyxx = "Harga Terendah - Harga Tertinggi";
    }else if($filter_sortby == "high"){
      $filter_sortbyxx = "Harga Tertinggi - Harga Terendah";
    }else if($filter_sortby == "first_end"){
      $filter_sortbyxx = "Produk lama - produk baru";
    }else if($filter_sortby == "end_first"){
      $filter_sortbyxx = "Produk baru - produk lama";
    }else{
      $filter_sortbyxx = "-";
    }

    $filter_sizex = $this->security->xss_clean($this->input->post('size'));
    $filter_size = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sizex);

    // cari size berdasarkan id
    $caris = $this->produk_adm->carisizeberdasarkanid($filter_size);
    if(!empty($filter_size)){
      $filter_sizexx = $caris['opsi_size'];
    }else{
      $filter_sizexx = "-";
    }

    $filter_colorx = $this->security->xss_clean($this->input->post('color'));
    $filter_color = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_colorx);    

    // cari size berdasarkan id
    $caric = $this->produk_adm->caricolorberdasarkanid($filter_color);
    if(!empty($filter_color)){
      $filter_colorxx = $caric['opsi_color'];
    }else{
      $filter_colorxx = "-";
    }

    $tgl1x = $this->security->xss_clean($this->input->post('tglupload1'));
    $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1x);    

    $tgl2x = $this->security->xss_clean($this->input->post('tglupload2'));
    $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2x);  

    if($tgl1 == "" || $tgl2 == ""){
      $tgl1ch = "";
      $tgl2ch = "";
    }else{
      $tgl1ch = date("d/m/y", strtotime($tgl1));  
      $tgl2ch = date("d/m/y", strtotime($tgl2));  
    }

    // END FORM FILTER
    // ubah format tanggal
    $tgl = date("d-m-Y", strtotime(now()));

    $objPHPExcel = new PHPExcel();
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
      $style_col = array(
        'font' => array('bold' => true), // Set font nya jadi bold
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );
      // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
      $style_row = array(
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );      
      // Create a first sheet, representing sales data
      $objPHPExcel->setActiveSheetIndex(0);

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA STOK PRODUK E-COMMERCE TO BUKALAPAK"); // Set kolom A1
      // Rename sheet
      $objPHPExcel->getActiveSheet()->setTitle('Data Produk');

        $objPHPExcel->getActiveSheet()->mergeCells('A1:CL1'); // Set Merge Cell pada kolom A1 sampai CL
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1
        // buat informasi apa yang ditarik
        $objPHPExcel->getActiveSheet()->setCellValue('A3','Status');
        $objPHPExcel->getActiveSheet()->setCellValue('A4','Sort By');
        $objPHPExcel->getActiveSheet()->setCellValue('A5','Ukuran');
        $objPHPExcel->getActiveSheet()->setCellValue('A6','Warna');
        $objPHPExcel->getActiveSheet()->setCellValue('A7','Tgl Upload');
        // tampilkan hasil informasi yang ditarik
        $objPHPExcel->getActiveSheet()->setCellValue('B3',$filter_statusxx);
        $objPHPExcel->getActiveSheet()->setCellValue('B4',$filter_sortbyxx);
        $objPHPExcel->getActiveSheet()->setCellValue('B5',$filter_sizexx);
        $objPHPExcel->getActiveSheet()->setCellValue('B6',$filter_colorxx);
        $objPHPExcel->getActiveSheet()->setCellValue('B7',$tgl1ch." - ".$tgl2ch);
      //table header
      $heading = array(
        "Nama Barang",                     
        "Stok (Minumum 1)",
        "Berat(Gram)",
        "Harga (Rupiah)",
        "Kondisi (baru/bekas)",
        "Deskripsi",
        "Wajib Asuransi? (Ya/Tidak)",
        "Merek (Bisa pilih beberapa, Contoh: Catnip 308|Thirdday)",
        "Size (Bisa pilih beberapa, Contoh: 38|39|40)",
        "Merek (Pilih salah satu, Contoh: Rasheda)",
        "Jasa Pengiriman (gunakan vertical bar | sebagai pemisah jasa pengiriman contoh: jner | jney)",
        "URL Gambar 1",
        "URL Gambar 2",
        "URL Gambar 3",
        "URL Gambar 4",
        "URL Gambar 5",
        );
          //loop heading
        $rowNumberH = 8;
        $colH = 'A'; 
        foreach($heading as $h){
            $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
            $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
            $colH++;    
        }
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
          // lopping
          // mulai isi data pada baris ke 4
          $baris = 9;
          $dataP = $this->produk_adm->filter_produk_excel_bukalapak($filter_status,$filter_sortby,$filter_size,$filter_color,$tgl1,$tgl2);
          foreach($dataP as $frow){

            $idProduk = count($frow->id_produk);

            if($frow->harga_dicoret == "" || $frow->harga_dicoret == 0){
              $harga_awal = 0;
              $harga_net = $frow->harga_fix;
              $diskon = 0;
            }else{
              $harga_awal = $frow->harga_dicoret;
              $harga_net = $frow->harga_dicoret; // BARU BIAR BISA NGESET DISKON
              $diskon = round(($frow->harga_dicoret - $frow->harga_fix) / $frow->harga_dicoret * 100);
            }

            if($frow->berat == "0.5"){
              $berat = 1000;
            }else{
              $berat = $frow->berat*1000;
            }

            $size_bukalapak = array();
            $id = $frow->id_produk;
            $opsi_size_bukalapak = $this->produk_adm->get_size_bukalapak($id);
            foreach($opsi_size_bukalapak as $rt){
              $size_bukalapak[] = $rt->opsi_size;
            }
            $sizex = implode('|',$size_bukalapak);

            $gambar1 = "";
            $gambar2 = "";
            $gambar3 = "";
            $gambar4 = "";
            $gambar5 = "";
            //get gambar sampai 5 gambar 
            $no = 0;
            $sku = $frow->sku_produk;
            $gbppp = $this->produk_adm->get_gambar($sku);
            foreach($gbppp as $gbx){
              $no++;
              if($no == 1){
                $gambar1 = $gbx->gambar;
              }
              if($no == 2){
                $gambar2 = $gbx->gambar;
              }
              if($no == 3){
                $gambar3 = $gbx->gambar;
              }
              if($no == 4){
                $gambar4 = $gbx->gambar;
              }
              if($no == 5){
                $gambar5 = $gbx->gambar;
              }
            }

            // DESKRIPSI TAMBAHAN (SIZE CHART)
            $art1x = $frow->artikel;
            $get_size_produk = $this->produk_adm->get_size_produk($art1x);
            $g = $get_size_produk->row_array();
            $j1 = "Kode Produk : ".$frow->artikel."<br>Size Chart (EU) :<br>";
            $j2 = array();
            foreach($get_size_produk->result() as $u){
              $j2[] = "Size ".$u->opsi_size." Panjang ".$u->cm."cm <br>";
            }
            $j3 = "<br>*Tanyakan ketersediaan stok kepada kami*<br>Happy Shopping !";

            $size1 = implode('|',$j2);
            $size = str_replace('|', '', $size1);

            $keterangan = $frow->keterangan."<br><br>".$j1."".$size."".$j3.""; 

            //pemanggilan sesuaikan dengan nama kolom tabel
            $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $frow->nama_produk);
            $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, "20");
            $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $berat);
            $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $harga_net); 
            $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, "Baru");            
            $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, strip_tags($keterangan));
            $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, "Tidak");
            $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, $frow->merk);
            $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, $sizex); //size
            $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, $frow->merk);
            $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, "j&tr | jner | jney | jnet");            
            $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, $frow->gambar);
            $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, $gambar2);
            $objPHPExcel->getActiveSheet()->setCellValue("N".$baris, $gambar3);
            $objPHPExcel->getActiveSheet()->setCellValue("O".$baris, $gambar4);
            $objPHPExcel->getActiveSheet()->setCellValue("P".$baris, $gambar5);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);

            $baris++;
          }
          // end lopping

           // Set width kolom
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);  
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true); 

    // Redirect output to a client’s web browser (Excel5)
    $filename = urlencode("Data_Produk_E-commerce_To_Bukalapak_By_Filter_status produk_".$filter_statusxx."_sort_by_".$filter_sortbyxx."_ukuran_".$filter_sizexx."_warna_".$filter_colorxx."_range_tanggal_".$tgl1ch."-".$tgl2ch.".xls");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Data Produk (Excel) Ke Bukalapak dengan filter status produk '.$filter_statusxx.' sort by '.$filter_sortbyxx.' ukuran '.$filter_sizexx.' warna '.$filter_colorxx.'_range_tanggal_'.$tgl1ch.'-'.$tgl2ch.'');
  }

  function filter_produk_excel_to_blibli(){

    // MEMERIKSA FILE TMP_GAMBAR.ZIP HARUS SUDAH DIHAPUS DAN FOLDER TMP_GAMBAR JUGA HARUS DIHAPUS SEBELUM EXPORT
    $file_zip = FCPATH.'tmp_gambar.zip';
    $dir = "tmp_gambar";
    $this->remove_tmp($dir);
  }

  function remove_tmp($dir){
    if(file_exists($dir)){
      //echo "folder ada<br>";
      //echo $dir;
// REMOVE FILE DI DALAM FOLDER TMP_GAMBAR      
      foreach(scandir($dir) as $file) {
          if ('.' === $file || '..' === $file){ continue; }
          if (is_dir("$dir/$file")){ $this->remove_tmp("$dir/$file"); }else{ unlink("$dir/$file"); }
      }
      //$this->remove_folder($dir);
// REMOVE FOLDER DIDALAM TMP_GAMBAR
      foreach(glob($dir . '/*') as $file) {
          if(is_dir($file)){
            $filex = FCPATH.$file;
            unlink($filex);
          }
      }
// REMOVE FOLDER TMP_GAMBAR
      rmdir($dir);
      $this->export_excel_blibli(); // NON AKTIFKAN LINK INI UNTUK MENGHAPUS DIREKTORY TMP_GAMBAR
    }else{
      mkdir("tmp_gambar"); // folder dinamakan tmp_gambar karena seua gambar yang di download telah diset tmp_gambar
      $this->export_excel_blibli();
      //echo "folder tidak ada";
    }
  }

  function remove_folder($dir){ // tidak dipakai
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file)){
          $filex = FCPATH.$file;
          unlink($filex);
        }
    }
    rmdir($dir);
    $this->export_excel_blibli(); // NON AKTIFKAN LINK INI UNTUK MENGHAPUS DIREKTORY TMP_GAMBAR
  }

  function export_excel_blibli(){

    // BUAT FOLDER PENAMPUNGAN GAMBAR AGAR BISA DI ZIP DAN DIDOWNLOAD
    
    $this->load->library('zip');  
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    // FORM FILTER
    $filter_statusx = $this->security->xss_clean($this->input->post('status_produk'));
    $filter_status = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_statusx);

    if($filter_status == "on"){
      $filter_statusxx = "Aktif";
    }else if($filter_status == "off"){
      $filter_statusxx = "Tidak Aktif";
    }else{
      $filter_statusxx = "-";
    }

    $filter_sortbyx = $this->security->xss_clean($this->input->post('sort_by'));
    $filter_sortby = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sortbyx);


    if($filter_sortby == "a_z"){
      $filter_sortbyxx = "A - Z";
    }else if($filter_sortby == "z_a"){
      $filter_sortbyxx = "Z - A";
    }else if($filter_sortby == "low"){
      $filter_sortbyxx = "Harga Terendah - Harga Tertinggi";
    }else if($filter_sortby == "high"){
      $filter_sortbyxx = "Harga Tertinggi - Harga Terendah";
    }else if($filter_sortby == "first_end"){
      $filter_sortbyxx = "Produk lama - produk baru";
    }else if($filter_sortby == "end_first"){
      $filter_sortbyxx = "Produk baru - produk lama";
    }else{
      $filter_sortbyxx = "-";
    }

    $filter_sizex = $this->security->xss_clean($this->input->post('size'));
    $filter_size = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_sizex);

    // cari size berdasarkan id
    $caris = $this->produk_adm->carisizeberdasarkanid($filter_size);
    if(!empty($filter_size)){
      $filter_sizexx = $caris['opsi_size'];
    }else{
      $filter_sizexx = "-";
    }

    $filter_colorx = $this->security->xss_clean($this->input->post('color'));
    $filter_color = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$filter_colorx);    

    // cari size berdasarkan id
    $caric = $this->produk_adm->caricolorberdasarkanid($filter_color);
    if(!empty($filter_color)){
      $filter_colorxx = $caric['opsi_color'];
    }else{
      $filter_colorxx = "-";
    }

    $tgl1x = $this->security->xss_clean($this->input->post('tglupload1'));
    $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1x);    

    $tgl2x = $this->security->xss_clean($this->input->post('tglupload2'));
    $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2x);  

    if($tgl1 == "" || $tgl2 == ""){
      $tgl1ch = "";
      $tgl2ch = "";
    }else{
      $tgl1ch = date("d/m/y", strtotime($tgl1));  
      $tgl2ch = date("d/m/y", strtotime($tgl2));  
    }

    $katx = $this->security->xss_clean($this->input->post('kategori'));
    $filter_kategori = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$katx);    

    $findkategori = $this->produk_adm->find_kategori($filter_kategori);

    // END FORM FILTER
    // ubah format tanggal
    $tgl = date("d-m-Y", strtotime(now()));

    $objPHPExcel = new PHPExcel();
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );      
    // Create a first sheet, representing sales data
    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA STOK PRODUK E-COMMERCE TO BLIBLI - KATEGORI ".strtoupper($findkategori['kategori']).""); // Set kolom A1
    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('Data Produk');

    $objPHPExcel->getActiveSheet()->mergeCells('A1:CL1'); // Set Merge Cell pada kolom A1 sampai CL
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1
    // buat informasi apa yang ditarik
    $objPHPExcel->getActiveSheet()->setCellValue('A3','Status');
    $objPHPExcel->getActiveSheet()->setCellValue('A4','Sort By');
    $objPHPExcel->getActiveSheet()->setCellValue('A5','Ukuran');
    $objPHPExcel->getActiveSheet()->setCellValue('A6','Warna');
    $objPHPExcel->getActiveSheet()->setCellValue('A7','Tgl Upload');
    // tampilkan hasil informasi yang ditarik
    $objPHPExcel->getActiveSheet()->setCellValue('B3',$filter_statusxx);
    $objPHPExcel->getActiveSheet()->setCellValue('B4',$filter_sortbyxx);
    $objPHPExcel->getActiveSheet()->setCellValue('B5',$filter_sizexx);
    $objPHPExcel->getActiveSheet()->setCellValue('B6',$filter_colorxx);
    $objPHPExcel->getActiveSheet()->setCellValue('B7',$tgl1ch." - ".$tgl2ch);
    //table header
    $heading = array(
      "Nama Produk",                     
      "URL Video",
      "Seller SKU",
      "Deskripsi*",
      "Unique Selling Point*",
      "Buyable*",
      "Brand*",
      "Ukuran*",
      "Warna*",
      "Family Colour*",
      "Model/EAN/UPC",
      "Parent",
      "Image 1",
      "Image 2",
      "Image 3",
      "Image 4",
      "Image 5",
      "Tipe Penanganan*",
      "Kode Toko/Gudang*",
      "Panjang (cm)*",
      "Lebar (cm)*",
      "Tinggi (cm)*",
      "Berat (gram)*",
      "Harga (Rp)*",
      "Harga Penjualan (Rp)*",
      "Available Stock*",
      "Minimum Stock*",
      "Material*",
      "Care Label",
      "Dimensi Produk",
      "Kesesuaian Usia",
      "Berat",
      "Kelengkapan Paket",
      "Lain-lain",
    );
    //loop heading
    $rowNumberH = 8;
    $colH = 'A'; 
    foreach($heading as $h){
      $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
      $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
      $colH++;    
    }
    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    // lopping

    // mulai isi data pada baris ke 4

// UNTUK DATA PRODUK
    $baris = 9; // function pakai lazada, lazada, blili perlu memakai gender untuk import produk by excel
    $dataP1 = $this->produk_adm->filter_produk_excel_blibli($filter_status,$filter_sortby,$filter_size,$filter_color,$tgl1,$tgl2);
    foreach($dataP1 as $frow1){

      $idProduk = count($frow1->id_produk);
      if($frow1->harga_dicoret == "" || $frow1->harga_dicoret == 0){
        $harga_awal = $frow1->harga_fix;
        $harga_net = "";
      }else{
        $harga_awal = $frow1->harga_dicoret;
        $harga_net = $frow1->harga_fix; // BARU BIAR BISA NGESET DISKON
      }

      if($frow1->berat == "0.5"){
        $berat = 1000;
      }else{
        $berat = $frow1->berat*1000;
      }

      // UKURAN
      $idp = $frow1->id_produk;
      $sz = $this->produk_adm->get_list_produk_for_option_size($idp);    

      // WARNA
      $idp = $frow1->id_produk;
      $ck = $this->produk_adm->get_list_produk_for_option_color($idp); 

      // merk | karena beberapa merk belum terdaftar blibli maka jika ada yg belum terdaftar maka kosongi
      //if($frow->merk == "Stars"){
      //  $merk = "";
      //}else if($frow->merk == "Jane Vanda"){
      //  $merk = "";
      //}else if($frow->merk == "Axxe"){
      //  $merk = "";
      //}else if($frow->merk == "Starz"){
      //  $merk = "";
      //}else if($frow->merk == "Starlady"){
      //  $merk = "";
      //}else if($frow->merk == "Ova"){
      //  $merk = "";
      //}else 

      if($frow1->merk == "RAJ"){
        $merk = "RA Jeans Footwear";
      }else{
        $merk = $frow1->merk;
      }

      // DESKRIPSI TAMBAHAN (SIZE CHART)
      $art1x = $frow1->artikel;
      $get_size_produk = $this->produk_adm->get_size_produk($art1x);
      $g = $get_size_produk->row_array();
      $j1 = "Kode Produk : ".$frow1->artikel."<br>Size Chart (EU) :<br>";
      $j2 = array();
      foreach($get_size_produk->result() as $u){
        $j2[] = "Size ".$u->opsi_size." Panjang ".$u->cm."cm <br>";
      }
      $j3 = "<br>*Tanyakan ketersediaan stok kepada kami*<br>Happy Shopping !";

      $size1 = implode('|',$j2);
      $size = str_replace('|', '', $size1);

      $keterangan = $frow1->keterangan."<br><br>".$j1."".$size."".$j3.""; 

      $infogambar1 = "";
      $infogambar2 = "";
      $infogambar3 = "";
      $infogambar4 = "";
      $infogambar5 = "";
      //get gambar sampai 5 gambar 
      $no = 0;
      $sku = $frow1->sku_produk;
      $gbppp = $this->produk_adm->get_gambar($sku);
      foreach($gbppp as $gbx){
        $no++;
        if($no == 1){
          $gambar1 = $gbx->gambar;
          $url = $gambar1;
          $info1 = pathinfo($url);
          //$contents = file_get_contents($url);
          //$file = 'tmp_gambar/'.$frow1->artikel.'/'.$info1['basename'];
          //file_put_contents($file, $contents);
          //$this->zip->add_data($file, file_get_contents($file));
          $infogambar1 = $info1['basename'];
        }
        if($no == 2){
          $gambar2 = $gbx->gambar;
          $url = $gambar2;
          $info2 = pathinfo($url);
          //$contents = file_get_contents($url);
          //$file = 'tmp_gambar/'.$frow1->artikel.'/'.$info2['basename'];
          //file_put_contents($file, $contents);
          //$this->zip->add_data($file, file_get_contents($file));
          $infogambar2 = $info2['basename'];
        }
        if($no == 3){
          $gambar3 = $gbx->gambar;
          $url = $gambar3;
          $info3 = pathinfo($url);
          //$contents = file_get_contents($url);
          //$file = 'tmp_gambar/'.$frow1->artikel.'/'.$info3['basename'];
          //file_put_contents($file, $contents);
          //$this->zip->add_data($file, file_get_contents($file));
          $infogambar3 = $info3['basename'];
        }
        if($no == 4){
          $gambar4 = $gbx->gambar;
          $url = $gambar4;
          $info4 = pathinfo($url);
          //$contents = file_get_contents($url);
          //$file = 'tmp_gambar/'.$frow1->artikel.'/'.$info4['basename'];
          //file_put_contents($file, $contents);
          //$this->zip->add_data($file, file_get_contents($file));
          $infogambar4 = $info4['basename'];
        }
        if($no == 5){
          $gambar5 = $gbx->gambar;
          $url = $gambar5;
          $info5 = pathinfo($url);
          //$contents = file_get_contents($url);
          //$file = 'tmp_gambar/'.$frow1->artikel.'/'.$info5['basename'];
          //file_put_contents($file, $contents);
          //$this->zip->add_data($file, file_get_contents($file));
          $infogambar5 = $info5['basename'];
        }
      }

      $info0 = pathinfo($frow1->gambar);
      $infogambarutama = $info0['basename'];

      //pemanggilan sesuaikan dengan nama kolom tabel
      $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $frow1->nama_produk);
      $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, "");
      $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $frow1->artikel);
      $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, strip_tags($keterangan)); 
      $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, "Dengan Bahan Berkualitas");            
      $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, "SKU bisa dibeli di website");
      $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, $merk);
      $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, $frow1->opsi_size); //$sz['opsi_size']
      $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, $ck['opsi_color']); 
      $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, $ck['opsi_color']);
      $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, "");
      $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, "");            
      $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, $infogambarutama);
      $objPHPExcel->getActiveSheet()->setCellValue("N".$baris, $infogambar2);
      $objPHPExcel->getActiveSheet()->setCellValue("O".$baris, $infogambar3);
      $objPHPExcel->getActiveSheet()->setCellValue("P".$baris, $infogambar4);
      $objPHPExcel->getActiveSheet()->setCellValue("Q".$baris, $infogambar5);
      $objPHPExcel->getActiveSheet()->setCellValue("R".$baris, "Regular");
      $objPHPExcel->getActiveSheet()->setCellValue("S".$baris, "Isi Sesuai Kode Toko di Sheet Toko");
      $objPHPExcel->getActiveSheet()->setCellValue("T".$baris, "30");
      $objPHPExcel->getActiveSheet()->setCellValue("U".$baris, "20");
      $objPHPExcel->getActiveSheet()->setCellValue("V".$baris, "10");
      $objPHPExcel->getActiveSheet()->setCellValue("W".$baris, $berat);
      $objPHPExcel->getActiveSheet()->setCellValue("X".$baris, $harga_awal);
      $objPHPExcel->getActiveSheet()->setCellValue("Y".$baris, $harga_net);
      $objPHPExcel->getActiveSheet()->setCellValue("Z".$baris, "20");
      $objPHPExcel->getActiveSheet()->setCellValue("AA".$baris, "1");
      $objPHPExcel->getActiveSheet()->setCellValue("AB".$baris, "Berbahan dasar kualitas tinggi dan kuat");
      $objPHPExcel->getActiveSheet()->setCellValue("AC".$baris, "");
      $objPHPExcel->getActiveSheet()->setCellValue("AD".$baris, "");
      $objPHPExcel->getActiveSheet()->setCellValue("AE".$baris, "");
      $objPHPExcel->getActiveSheet()->setCellValue("AF".$baris, "");
      $objPHPExcel->getActiveSheet()->setCellValue("AG".$baris, "");
      $objPHPExcel->getActiveSheet()->setCellValue("AH".$baris, "");

      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('W'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('X'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('Y'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('Z'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('AA'.$baris)->applyFromArray($style_row);
      $objPHPExcel->getActiveSheet()->getStyle('AB'.$baris)->applyFromArray($style_row);
      $baris++;
    }

    // Set width kolom
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);  
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true); 

// UNTUK GAMBAR PRODUK
    $dataP = $this->produk_adm->filter_produk_excel_bukalapak($filter_status,$filter_sortby,$filter_size,$filter_color,$tgl1,$tgl2);
    foreach($dataP as $frow){
      // buat folder baru per artikel
      mkdir("tmp_gambar/".$frow->artikel."");
      // BUAT ZIP UNTUK GAMBAR UTAMA
      $url = $frow->gambar;
      $info = pathinfo($url);
      $contents = file_get_contents($url);
      $file = 'tmp_gambar/'.$frow->artikel.'/'.$info['basename'];
      file_put_contents($file, $contents);
      $this->zip->add_data($file, file_get_contents($file));

      $infogambar1 = "";
      $infogambar2 = "";
      $infogambar3 = "";
      $infogambar4 = "";
      $infogambar5 = "";
      //get gambar sampai 5 gambar 
      $no = 0;
      $sku = $frow->sku_produk;
      $gbppp = $this->produk_adm->get_gambar($sku);
      foreach($gbppp as $gbx){
        $no++;
        if($no == 1){
          $gambar1 = $gbx->gambar;
          $url = $gambar1;
          $info1 = pathinfo($url);
          $contents = file_get_contents($url);
          $file = 'tmp_gambar/'.$frow->artikel.'/'.$info1['basename'];
          file_put_contents($file, $contents);
          $this->zip->add_data($file, file_get_contents($file));
          $infogambar1 = $info1['basename'];
        }
        if($no == 2){
          $gambar2 = $gbx->gambar;
          $url = $gambar2;
          $info2 = pathinfo($url);
          $contents = file_get_contents($url);
          $file = 'tmp_gambar/'.$frow->artikel.'/'.$info2['basename'];
          file_put_contents($file, $contents);
          $this->zip->add_data($file, file_get_contents($file));
          $infogambar2 = $info2['basename'];
        }
        if($no == 3){
          $gambar3 = $gbx->gambar;
          $url = $gambar3;
          $info3 = pathinfo($url);
          $contents = file_get_contents($url);
          $file = 'tmp_gambar/'.$frow->artikel.'/'.$info3['basename'];
          file_put_contents($file, $contents);
          $this->zip->add_data($file, file_get_contents($file));
          $infogambar3 = $info3['basename'];
        }
        if($no == 4){
          $gambar4 = $gbx->gambar;
          $url = $gambar4;
          $info4 = pathinfo($url);
          $contents = file_get_contents($url);
          $file = 'tmp_gambar/'.$frow->artikel.'/'.$info4['basename'];
          file_put_contents($file, $contents);
          $this->zip->add_data($file, file_get_contents($file));
          $infogambar4 = $info4['basename'];
        }
        if($no == 5){
          $gambar5 = $gbx->gambar;
          $url = $gambar5;
          $info5 = pathinfo($url);
          $contents = file_get_contents($url);
          $file = 'tmp_gambar/'.$frow->artikel.'/'.$info5['basename'];
          file_put_contents($file, $contents);
          $this->zip->add_data($file, file_get_contents($file));
          $infogambar5 = $info5['basename'];
        }
      }

      $info0 = pathinfo($frow->gambar);
      $infogambarutama = $info0['basename'];
    }
// END UNTUK GAMBAR PRODUK

    // Redirect output to a client’s web browser (Excel5)
    $filename = urlencode("Data_Produk_E-commerce_To_Blibli_By_Filter_status produk_".$filter_statusxx."_sort_by_".$filter_sortbyxx."_ukuran_".$filter_sizexx."_warna_".$filter_colorxx."_range_tanggal_".$tgl1ch."-".$tgl2ch.".xls");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
    ob_start();
    $objWriter->save('php://output');
    $myPdfData = ob_get_contents();
    ob_end_clean();

    $file = 'tmp_gambar/' . $filename;
    file_put_contents($file, $myPdfData);
    $this->zip->add_data($filename, file_get_contents($file));
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Cetak Data Produk (Excel) Ke Blibli dengan filter status produk '.$filter_statusxx.' sort by '.$filter_sortbyxx.' ukuran '.$filter_sizexx.' warna '.$filter_colorxx.'_range_tanggal_'.$tgl1ch.'-'.$tgl2ch.'');

    // create zip dan download zip
    $this->zip->archive('tmp_gambar.zip');
    $this->zip->download('tmp_gambar.zip');
    
    //$this->session->set_flashdata('success', 'Data Produk Blibli dengan gambar berhasil diexport');
    //redirect(base_url('trueaccon2194/produk'));

    // function delete zip dan folder 
    //$this->delete_zip();
  }

  function delete_zip(){
    // delete zip 
    $file_zip = FCPATH.'tmp_gambar.zip';
    unlink($file_zip);
    // delete folder tmp_gambar
    $dir = "tmp_gambar";
    foreach (scandir($dir) as $item) {
      $file = FCPATH.'tmp_gambar/'.$item.'';
      unlink($file);
    }
    rmdir('tmp_gambar');
    $this->session->set_flashdata('success', 'Data Produk Blibli dengan gambar berhasil diexport');
    redirect(base_url('trueaccon2194/produk'));
  }

  function cek_perubahan_harga(){
    $tgl1_f = $this->security->xss_clean($this->input->post('tgl1'));
        $tgl1 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl1_f);

        $tgl2_f = $this->security->xss_clean($this->input->post('tgl2'));
        $tgl2 = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$tgl2_f);

        $this->data['get_list'] = $this->produk_adm->cek_produk($tgl1, $tgl2);
        $this->load->view('manage/header');
    $this->load->view('manage/produk/penurunan', $this->data); 
    $this->load->view('manage/footer');
    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Akses Halaman Penurunan Produk');
  }
  
  function search_sub_kategori(){
    $prop_id = $this->security->xss_clean($this->input->post('prov'));
    $xa = $this->produk_adm->get_sub_kat($prop_id);
    if($xa->num_rows() == 0){
      echo "<option value=''>-- Tidak ada kategori --</option>"; 
    }else{
      echo "<option value=''>-- Pilih --</option>"; 
      foreach($xa->result() as $g){
        echo "<option value='".$g->id_parent."'>".$g->parent_kategori."</option>";
      }
    }
  }

  function uploadimagerim(){
    $config['upload_path']   = FCPATH.'/assets/images/produk/dummy_upload/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite']     = TRUE;
        $this->upload->initialize($config);
 
        if($this->upload->do_upload('filelist')){
          $token  = $this->input->post('token');
          $this->upload->data('file_name');
          //$idk = $this->input->post('identitas');
          //$nama   = base_url('assets/images/produk/'.$this->upload->data('file_name').'');
          //$this->db->insert('produk_image',array('identity_produk'=>$idk, 'token'=>$token, 'gambar'=>$nama));
        }
  }

  function uploadimageforproduct(){
    $config['upload_path']   = FCPATH.'/assets/images/produk/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $this->upload->initialize($config);
 
        if($this->upload->do_upload('filelist')){
          $token  = $this->input->post('token');
          $idk    = $this->input->post('identitas');
          $nama   = base_url('assets/images/produk/'.$this->upload->data('file_name').'');

          $this->db->insert('produk_image',array('identity_produk'=>$idk, 'token'=>$token, 'gambar'=>$nama));
        }
  }

  function uploadimageanyproduct(){
    $config['upload_path']   = FCPATH.'/assets/images/produk/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $this->upload->initialize($config);
 
        if($this->upload->do_upload('filelist')){
          $token  = $this->input->post('token');
          $idk    = $this->session->userdata('sku_produk');//$this->input->post('identitasx');
          $nama   = base_url('assets/images/produk/'.$this->upload->data('file_name').'');

          $this->db->insert('produk_image',array('identity_produk'=>$idk, 'token'=>$token, 'gambar'=>$nama));
          // unset session upload any produk
          //$this->session->unset_userdata('sku_produk');
        }
  }

  function hapusimageforproduct(){
    $token = $this->input->post('token');
    // get src
    //$src = $this->produk_adm->get_src($token);
    $foto = $this->db->get_where('produk_image',array('token'=>$token));

    //print_r($foto->num_rows());
    if($foto->num_rows()>0){
      $hasil    = $foto->row();
      $nama_foto  = $hasil->gambar;

      $srcx = str_replace(''.base_url('assets/images/produk/').'','', $nama_foto);
      $file = FCPATH.'assets/images/produk/'.$srcx.'';
      //if(file_exists($file = FCPATH.'/assets/images/konfirmasi_pesanan/'.$nama_foto)){
        unlink($file);
        //print_r($file);
      //}
      $this->db->delete('produk_image',array('token'=>$token));
    }
    echo json_encode(array("status" => TRUE));
  }

  function cariartikelfrommaster(){
    $data_filtering = $this->security->xss_clean($this->input->post('getinvdata'));
        $dataxx = str_replace("/(<\/?)(p)([^>]*>)/(<\/?)(p)([^>]*>)<script></script><?php?>", "",$data_filtering);

        $cekInv = $this->produk_adm->cekartikel($dataxx);
        if($cekInv->num_rows() > 0){

          echo "<h5 style='text-transform:uppercase;'>Hasil '".$dataxx."'</h5>";

          echo "
          <div class='table-responsive'>
      <table id='table_produk' class='ble table-striped table-hover table-bordered' cellspacing='0' width='100%' style='box-shadow:0px 0px 8px 0px #bababa;background-color:white;'>
        <thead>
          <tr>
            <th style='text-align:center;padding:10px;'>Gambar <span style='padding:10px;font-size:12px;' class='hidden-sm hidden-xs glyphicon  glyphicon-sort'></span></th>
            <th style='text-align:center;padding:10px;'>Nama Project <span style='padding:10px;font-size:12px;' class='hidden-sm hidden-xs glyphicon  glyphicon-sort'></span></th>
            <th style='text-align:center;padding:10px;'>Artikel <span style='padding-top:5px;font-size:12px;' class='hidden-sm hidden-xs glyphicon  glyphicon-sort'></span></th>
                    <th style='text-align:center;padding:10px;'>ODV <span style='padding-top:5px;font-size:12px;' class='hidden-sm hidden-xs glyphicon  glyphicon-sort'></span></th>
                    <th style='text-align:center;padding:10px;'>Retail (A) <span style='padding-top:5px;font-size:12px;' class='hidden-sm hidden-xs glyphicon  glyphicon-sort'></span></th>
          </tr>
        </thead>
        <tbody>
          ";

          foreach($cekInv->result() as $r){
            echo "
          <tr>
            <td style='text-align:center;padding:5px;'><img style='width:80px;' src='".base_url('assets/images/produk/Rim/'.$r->art_id.'.jpg')."' onError='this.onerror=null;this.src='".base_url('assets/images/produk/default.jpg')."''></td>
            <td style='text-align:center;padding:5px;'>".$r->prj."</td>
            <td style='text-align:center;padding:5px;'>".$r->art_id."</td>
            <td style='text-align:center;padding:5px;'> - </td>
            <td style='text-align:center;padding:5px;'>".$r->retprc."</td>
          </tr>
            ";
          }
          echo "
            </tbody>
              </table>
            </div>
          ";
          log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Mencari artikel '.$dataxx.' di menu master produk ');
        }else{
          echo "Data belum sinkron dikarenakan gambar belum ada di data produk, harap sinkronkan terlebih dahulu";
        }
  }

  function syncrootwithdb(){
    $id_user = $this->data['id'];
    $maxword = 3;

    $getdb = $this->produk_adm->get_db_brgcp();
    $files = scandir('assets/images/produk/dummy_upload'); //asal Rim
    foreach($files as $file) { //load directory

      //PERPENDEK KATA
      $namex = explode('-', $file);
      $frname = $namex[0];
      $lsname = $namex[1];

      // perpendek kata 
      $lsnamex = substr($lsname, 0, $maxword);

      //echo $name.'<br>';
      //echo $lsnamex.'<br>';
      $newnamex = $frname.'-'.$lsnamex;
      $newnamewithurl = base_url('assets/images/produk/Rim/'.$newnamex.'.jpg'); // asal Rim

      $newname = 'assets/images/produk/dummy_upload/'.$newnamex.'.jpg';
      $oldname = 'assets/images/produk/dummy_upload/'.$file.'';

      // ubah nama file terlebih dahulu
      rename($oldname, $newname);

      // ubah nama
      $cekNama = $this->produk_adm->cekName($newnamex);
      if($cekNama->num_rows() > 0 ){ // jika cocok jangan diinsert berarti sudah ada

        $cekartikel = $this->produk_adm->cekArtinDB($newnamex); // cek apakah artikel sudah ada di tabel produk?
        if($cekartikel == 0){ // jika tidak ada maka insert

          //echo "<img src=".base_url('assets/images/produk/Rim/'.$newnamex.'.jpg').">";
          $x = $this->produk_adm->cekName1($newnamex);
          // slug
          $sl1 = $x['prj'];
          $sl2 = strtolower($sl1);
          $sl3 = str_replace(' ','-',$sl2);
          $sl4 = str_replace('%','-persen',$sl3);
          $sl5 = str_replace('/','-',$sl4);
          //generate code unique for slug | menghindari url sama (ganda)
          $uploads_before = 'assets/images/produk/dummy_upload/'.$newnamex.'.jpg';
          $uploads_after = 'assets/images/produk/Rim/'.$newnamex.'.jpg';

          //echo $uploads_before.$newnamex.'.jpg';
          rename($uploads_before, $uploads_after); // PINDAHKAN FOTO DARI DUMMY_PRODUK KE FOLDER RIM

          $length = 4;
          $random= "";
          srand((double)microtime()*1000000);
     
          $wordnum = "abcdefghijklmnopqrstuvwxyz";
          $wordnum .= "1234567890";
     
          for($i = 0; $i < $length; $i++){
            $random .= substr($wordnum, (rand()%(strlen($wordnum))), 1);
          }

          // generate SKU Produk
          $length =10; 
          $sku= "";
          srand((double)microtime()*1000000);
          $data = "ABCDEFGHI21JKLMN02OPQRS94TUVWXYZ";
          $data .= "1234567890";
          for($i = 0; $i < $length; $i++){
            $sku .= substr($data, (rand()%(strlen($data))), 1);
            $id_sku = "SKU_".$sku;
          }
          //<p>- Gambar Asli (Real Picture)<br />- Kualitas Premium, dari bahan terbaik dan original<br />Bahan lembut dan nyaman dipakai, cocok untuk kegiatan sehari - hari.</p><p><br />*Tanyakan ketersediaan stok kepada kami</p>

          $this->db->insert('produk',array('nama_produk'=>$x['prj'], 'sku_produk'=>$id_sku, 'slug'=>$sl5.'-'.$random, 'artikel'=>$x['art_id'], 'keterangan'=>'', 'berat'=>'0.5', 'gambar'=>$newnamewithurl, 'status'=> '','dibuat'=> $id_user,'tgl_dibuat'=> date('Y-m-d H:i:s'),));

          $last_insert_id = $this->db->insert_id(); // last insert
          // insert gambar tambahan 
          $this->db->insert('produk_image',array('identity_produk'=>$id_sku, 'gambar'=>$newnamewithurl));

          // insert harga dan stok
          $this->db->insert('produk_get_color',array('id_produk_optional'=>$last_insert_id, 'id_opsi_get_color'=> 1, 'id_opsi_get_size'=>1, 'stok'=>10, 'harga_fix'=>$x['retprc'], 'lokasi_barang'=>'store' ));

          log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Sync data gambar dengan database dan insert data otomatis artikel : '.$newnamex.' ');
        }

        }else{ // jika tidak cocok jangan di insert data
          //echo "<h1>TIDAK COCOK</h1>";
        }
    }
  }

  function update_deskripsi_dan_size_chart(){
    //$id         = $this->security->xss_clean($this->input->post('id_produk'));
    //$keterangan = $this->input->post('id_produk');

    $get_size_produk = $this->produk_adm->get_size_produk();
    $g = $get_size_produk->row_array();
    $id = $g['id_produk'];
    $j1 = "Kode Produk : ".$g['artikel']."<br>Size Chart (EU) :<br>";
    $j2 = array();
    foreach($get_size_produk->result() as $u){
      $j2[] = "Size ".$u->opsi_size." Panjang ".$u->cm."cm <br>";
    }
    $j3 = "<br>*Tanyakan ketersediaan stok kepada kami*<br>Happy Shopping !";

    $size1 = implode('|',$j2);
    $size = str_replace('|', '', $size1);

    $data_deskripsi = array(
      "keterangan" => $g['keterangan']."<br><br>".$j1."".$size."".$j3."",
    );

    //print_r($data_deskripsi);
    $this->db->where('id_produk',$id);
    $this->db->update('produk', $data_deskripsi);

    log_helper('produk', ''.$this->data['username'].' ('.$this->data['id'].') Update Size chart pada deskripsi produk');
    $this->session->set_flashdata('success', 'Update Size chart deskripsi berhasil');
    redirect(base_url('trueaccon2194/produk'));
  }

  function hapusprodukdariuploadmasalbyrim(){
    $get = $this->produk_adm->filter_produk();
    foreach($get as $t){
      $this->db->delete('produk',array('id_produk' => $t->id_produk));
      $this->db->delete('produk_get_color',array('id_produk_optional' => $t->id_produk));
    }
  }

  function update_produk_by_excel(){
    // Load plugin PHPExcel nya
    //include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

    $config['upload_path'] = realpath('data_excel_for_update_product');
    $config['allowed_types'] = 'xlsx|xls|csv';
    $config['max_size'] = '10000';
    //$config['encrypt_name'] = true;
    $config['file_name'] = $this->filename_import;
    $this->upload->initialize($config);

    if(!$this->upload->do_upload('fileupload')) { //upload gagal
      $this->session->set_flashdata('error', $this->upload->display_errors());
      redirect(base_url('trueaccon2194/produk'));
    }else{ // BERHASIL
      $excelreader  = new PHPExcel_Reader_Excel2007();
      $loadexcel    = $excelreader->load('data_excel_for_update_product/'.$this->filename_import.'.xlsx'); // Load file yang telah diupload ke folder data_excel_for_update_product
      $sheet        = $loadexcel->getActiveSheet()->toArray(null,true,true,true);
      $data = array();
      $data_harga_stok = array();
      $numrow = 1;
      foreach($sheet as $row){
        if($numrow > 1){
            array_push(
              $data, array(
                'id_produk'         => $row['A'],
                'nama_produk'       => $row['B'],
                'artikel'           => $row['C'],
                'merk'              => $row['H'],
                'keterangan'        => $row['I'], 
                'id_kategori_divisi'=> $row['J'],
                'kategori'          => $row['K'],
                'parent'            => $row['L'],
                'berat'             => $row['M'],
                'status'            => $row['N'],
            ));

            array_push($data_harga_stok, array(
                'id_produk_optional'  => $row['A'],
                'stok'                => $row['D'],
                'harga_dicoret'       => $row['E'],
                'harga_fix'           => $row['F'],
                'lokasi_barang'       => $row['G'], 
            ));   
            
        }
        $numrow++;
      }
      //print_r($data);
      
      $this->db->update_batch('produk', $data, 'id_produk');
      $this->produk_adm->update_harga_stok($data_harga_stok);
      //delete file from server
      unlink(realpath('data_excel_for_update_product/'.$this->filename_import.'.xlsx'));
      $this->session->set_flashdata('success', 'Update data produk berhasil, cek kembali produk yang diupdate');
      redirect(base_url('trueaccon2194/produk'));
    }
  }

  function download_produk_format_upload(){
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    $objPHPExcel = new PHPExcel();
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Create a first sheet, representing sales data
    $objPHPExcel->setActiveSheetIndex(0);
    //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PRODUK E-COMMERCE");
    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('DATA PRODUK E-COMMERCE');

    //$objPHPExcel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
    //$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
    //$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
    //$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
    //table header
    $heading = array("ID","Nama Produk","Artikel","Stok","Harga Awal (dicoret)","Harga Fix","Lokasi Barang","Merk","Keterangan","ID Kategori Divisi","Kategori","Parent Kategori","Berat (KG)","Status");
    //loop heading
    $rowNumberH = 1;
    $colH = 'A';
    foreach($heading as $h){
        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
        $colH++;    
    }
    $baris = 2;
    $produk = $this->produk_adm->get_produk_all_aktif();
    foreach($produk as $data){
        //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("A".$baris, $data->id_produk); 
        $objPHPExcel->getActiveSheet()->setCellValue("B".$baris, $data->nama_produk); 
        $objPHPExcel->getActiveSheet()->setCellValue("C".$baris, $data->artikel);
        $objPHPExcel->getActiveSheet()->setCellValue("D".$baris, $data->stok); 
        $objPHPExcel->getActiveSheet()->setCellValue("E".$baris, $data->harga_dicoret); 
        $objPHPExcel->getActiveSheet()->setCellValue("F".$baris, $data->harga_fix); 
        $objPHPExcel->getActiveSheet()->setCellValue("G".$baris, $data->lokasi_barang); 
        $objPHPExcel->getActiveSheet()->setCellValue("H".$baris, $data->merk); 
        $objPHPExcel->getActiveSheet()->setCellValue("I".$baris, $data->keterangan); 
        $objPHPExcel->getActiveSheet()->setCellValue("J".$baris, $data->id_kategori_divisi); 
        $objPHPExcel->getActiveSheet()->setCellValue("K".$baris, $data->kategori); 
        $objPHPExcel->getActiveSheet()->setCellValue("L".$baris, $data->parent); 
        $objPHPExcel->getActiveSheet()->setCellValue("M".$baris, $data->berat); 
        $objPHPExcel->getActiveSheet()->setCellValue("N".$baris, $data->status); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
        $baris++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
      $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); 
    }

    // BUAT SHEET UNTUK MERK, DIVISI, KATEGORI, PARENT KATEGORI
    $objPHPExcel->createSheet();
    $objPHPExcel->setActiveSheetIndex(1);
    //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', "PERTELAAN BARANG MASUK & KELUAR"); // Set kolom A1
    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('INFORMASI & PETUNJUK');
    $objPHPExcel->getActiveSheet()->setCellValue("A1","Gunakan ID Merk, ID Divisi, ID Kategori dan ID Parent Kategori saat mengisi data produk yang ada disheet Data produk E-commerce"); 
    // MERK
    $headingmerk = array("ID MERK","MERK");
    //loop heading
    $rowNumberHmerk = 3;
    $colHmerk = 'A';
    foreach($headingmerk as $hmerk){
        $objPHPExcel->getActiveSheet()->setCellValue($colHmerk.$rowNumberHmerk,$hmerk);
        $objPHPExcel->getActiveSheet()->getStyle($colHmerk.$rowNumberHmerk,$hmerk)->applyFromArray($style_col);
        $colHmerk++;    
    }
    $mulaimerk = 4;
    $get_merk = $this->produk_adm->get_merk();
    foreach($get_merk as $m){
      //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("A".$mulaimerk, $m->merk_id); 
        $objPHPExcel->getActiveSheet()->setCellValue("B".$mulaimerk, $m->merk); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('A'.$mulaimerk)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$mulaimerk)->applyFromArray($style_row);
        $mulaimerk++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
    }

    // DIVISI
    $headingd = array("ID DIVISI","DIVISI");
    //loop heading
    $rowNumberHd = 3;
    $colHd = 'D';
    foreach($headingd as $hd){
        $objPHPExcel->getActiveSheet()->setCellValue($colHd.$rowNumberHd,$hd);
        $objPHPExcel->getActiveSheet()->getStyle($colHd.$rowNumberHd,$hd)->applyFromArray($style_col);
        $colHd++;    
    }
    $ddivisi = 4;
    $get_divisi = $this->produk_adm->get_data_milik();
    foreach($get_divisi as $m){
      //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("D".$ddivisi, $m->id_milik); 
        $objPHPExcel->getActiveSheet()->setCellValue("E".$ddivisi, $m->milik); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('D'.$ddivisi)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$ddivisi)->applyFromArray($style_row);
        $ddivisi++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
    }

    // KATEGORI
    $headingk = array("ID KATEGORI","KATEGORI");
    //loop heading
    $rowNumberHk = 3;
    $colHk = 'G';
    foreach($headingk as $hk){
        $objPHPExcel->getActiveSheet()->setCellValue($colHk.$rowNumberHk,$hk);
        $objPHPExcel->getActiveSheet()->getStyle($colHk.$rowNumberHk,$hk)->applyFromArray($style_col);
        $colHk++;    
    }
    $kkat = 4;
    $get_kateg = $this->produk_adm->get_kategori();
    foreach($get_kateg as $k){
      //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("G".$kkat, $k->kat_id); 
        $objPHPExcel->getActiveSheet()->setCellValue("H".$kkat, $k->kategori); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('G'.$kkat)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$kkat)->applyFromArray($style_row);
        $kkat++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
      $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
    }

    // PARENT KATEGORI
    $headingp = array("ID PARENT KATEGORI","PARENT KATEGORI");
    //loop heading
    $rowNumberHp = 3;
    $colHp = 'J';
    foreach($headingp as $hp){
        $objPHPExcel->getActiveSheet()->setCellValue($colHp.$rowNumberHp,$hp);
        $objPHPExcel->getActiveSheet()->getStyle($colHp.$rowNumberHp,$hp)->applyFromArray($style_col);
        $colHp++;     
    }
    $pkat = 4;
    $get_parkat = $this->produk_adm->get_parent_kategori();
    foreach($get_parkat as $p){
      //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("J".$pkat, $p->id_parent); 
        $objPHPExcel->getActiveSheet()->setCellValue("K".$pkat, $p->keterangan); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('J'.$pkat)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$pkat)->applyFromArray($style_row);
        $pkat++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
    }

    // Redirect output to a client’s web browser (Excel5)
    $filename = urlencode("Format_Upload_dan_Update_Produk.xlsx");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Export Produk (Excel) untuk keperluan update semua produk ');
  }

  function upload_produk_by_excel(){ 
    // Load plugin PHPExcel nya
    //include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

    $config['upload_path'] = realpath('data_excel_for_update_product');
    $config['allowed_types'] = 'xlsx|xls|csv';
    $config['max_size'] = '10000';
    //$config['encrypt_name'] = true;
    //$config['file_name'] = $this->fileupload;
    $this->upload->initialize($config);

    if(!$this->upload->do_upload('uploadprodukbyexcel')) { //upload gagal
      $this->session->set_flashdata('error', $this->upload->display_errors());
      redirect(base_url('trueaccon2194/produk'));
    }else{ // BERHASIL
      //$this->upload->do_upload('uploadprodukbyexcel'); // upload
      $file    = $this->upload->data();  //DIUPLOAD DULU KE DIREKTORI 
      $fupload = $file['file_name'];

      $excelreader  = new PHPExcel_Reader_Excel2007();
      $loadexcel    = $excelreader->load('data_excel_for_update_product/'.$fupload.''); // Load file yang telah diupload ke folder data_excel_for_update_product
      $sheet        = $loadexcel->getActiveSheet()->toArray(null,true,true,true);
      $data_produk = array();
      $data_harga_stok1 = array();
      $data_harga_stok2 = array();
      $data_harga_stok3 = array();
      $data_harga_stok4 = array();
      $data_harga_stok5 = array();
      $data_gambar1 = array();
      $data_gambar2 = array();
      $data_gambar3 = array();
      $data_gambar4 = array();
      $data_gambar5 = array();
      $numrow = 0;

      foreach($sheet as $row){
        $numrow++;
        if($numrow > 5){
            // ambil id_produk untuk dijadikan acuan data_harga_stok_ukuran_warna
            $art = $row['A'];
            $getidproduk = $this->produk_adm->get_idproduk($art);

            //array_push(
              // data produk
              $data_produk = array(
                'artikel'           => $row['A'],
                'id_kategori_divisi'=> $row['B'],
                'nama_produk'       => $row['C'], 
                //'sku_produk'        => $id_sku,
                'keterangan'        => $row['E'],
                'merk'              => $row['F'],
                'kategori'          => $row['G'],
                'parent'            => $row['H'],
                'berat'             => $row['I'],
                'status'            => $row['J'],
            );

            //print_r($data_produk);
            $this->db->where('artikel',$row['A']);
            $this->db->update('produk', $data_produk);

            // hapus ukuran yang sudah diupload saat syncrootwithdb();
            $this->db->delete('produk_get_color',array('id_produk_optional'=>$getidproduk['id_produk'], 'id_opsi_get_color'=> 1, 'id_opsi_get_size'=>1));

            // GET ID WARNA
            $warna = $row['D'];
            $idwarna = $this->produk_adm->get_id_warna($warna);

            // DATA KOLOM SIZE
            if(!empty($row['O'])){
              // data harga, stok, ukuran
              $size1 = $row['O'];
              $idsize1 = $this->produk_adm->get_id_size1($size1);
              $data_harga_stok1 = array(
                  'id_produk_optional'  => $getidproduk['id_produk'],
                  'id_opsi_get_color'   => $idwarna['id_opsi_color'],
                  'id_opsi_get_size'    => $idsize1['id_opsi_size'],
                  'stok'                => str_replace(' ', '', $row['K']),
                  'harga_dicoret'       => str_replace(' ', '', $row['L']),
                  'harga_fix'           => str_replace(' ', '', $row['M']),
                  'lokasi_barang'       => str_replace(' ', '', $row['N']), 
              );   

              //print_r($data_harga_stok1);
              $this->db->insert('produk_get_color', $data_harga_stok1);
            }

            if(!empty($row['P'])){
              // data harga, stok, ukuran
              $size2 = $row['P'];
              $idsize2 = $this->produk_adm->get_id_size2($size2);
              $data_harga_stok2 = array(
                  'id_produk_optional'  => $getidproduk['id_produk'],
                  'id_opsi_get_color'   => $idwarna['id_opsi_color'],
                  'id_opsi_get_size'    => $idsize2['id_opsi_size'],
                  'stok'                => str_replace(' ', '', $row['K']),
                  'harga_dicoret'       => str_replace(' ', '', $row['L']),
                  'harga_fix'           => str_replace(' ', '', $row['M']),
                  'lokasi_barang'       => str_replace(' ', '', $row['N']), 
              );  

              //print_r($data_harga_stok2);
              $this->db->insert('produk_get_color', $data_harga_stok2);
            }

            if(!empty($row['Q'])){
              // data harga, stok, ukuran
              $size3 = $row['Q'];
              $idsize3 = $this->produk_adm->get_id_size3($size3);
              $data_harga_stok3 = array(
                  'id_produk_optional'  => $getidproduk['id_produk'],
                  'id_opsi_get_color'   => $idwarna['id_opsi_color'],
                  'id_opsi_get_size'    => $idsize3['id_opsi_size'],
                  'stok'                => str_replace(' ', '', $row['K']),
                  'harga_dicoret'       => str_replace(' ', '', $row['L']),
                  'harga_fix'           => str_replace(' ', '', $row['M']),
                  'lokasi_barang'       => str_replace(' ', '', $row['N']), 
              );  

              //print_r($data_harga_stok3);
              $this->db->insert('produk_get_color', $data_harga_stok3);
            }

            if(!empty($row['R'])){
              // data harga, stok, ukuran
              $size4 = $row['R'];
              $idsize4 = $this->produk_adm->get_id_size4($size4);
              $data_harga_stok4 = array(
                  'id_produk_optional'  => $getidproduk['id_produk'],
                  'id_opsi_get_color'   => $idwarna['id_opsi_color'],
                  'id_opsi_get_size'    => $idsize4['id_opsi_size'],
                  'stok'                => str_replace(' ', '', $row['K']),
                  'harga_dicoret'       => str_replace(' ', '', $row['L']),
                  'harga_fix'           => str_replace(' ', '', $row['M']),
                  'lokasi_barang'       => str_replace(' ', '', $row['N']), 
              );  

              //print_r($data_harga_stok4);
              $this->db->insert('produk_get_color', $data_harga_stok4);
            }

            if(!empty($row['S'])){
              // data harga, stok, ukuran
              $size5 = $row['S'];
              $idsize5 = $this->produk_adm->get_id_size5($size5);
              $data_harga_stok5 = array(
                  'id_produk_optional'  => $getidproduk['id_produk'],
                  'id_opsi_get_color'   => $idwarna['id_opsi_color'],
                  'id_opsi_get_size'    => $idsize5['id_opsi_size'],
                  'stok'                => str_replace(' ', '', $row['K']),
                  'harga_dicoret'       => str_replace(' ', '', $row['L']),
                  'harga_fix'           => str_replace(' ', '', $row['M']),
                  'lokasi_barang'       => str_replace(' ', '', $row['N']), 
              );  
  
              //print_r($data_harga_stok5);
              $this->db->insert('produk_get_color', $data_harga_stok5);
            }

            // DATA GAMBAR
            //if(!empty($row['T'])){
            //  array_push($data_gambar1, array(
            //      'identity_produk'     => $id_sku,
            //      'gambar'              => $row['T'], 
            //  ));  

            //  print_r($data_gambar1);
            //}

            //if(!empty($row['U'])){
            //  array_push($data_gambar2, array(
            //      'identity_produk'     => $id_sku,
            //      'gambar'              => $row['U'], 
            //  ));  

            //  print_r($data_gambar2);
            //}

            //if(!empty($row['V'])){
            //  array_push($data_gambar3, array(
            //      'identity_produk'     => $id_sku,
            //      'gambar'              => $row['V'], 
            //  ));  

            //  print_r($data_gambar3);
            //}

            //if(!empty($row['W'])){
            //  array_push($data_gambar4, array(
            //      'identity_produk'     => $id_sku,
            //      'gambar'              => $row['W'], 
            //  ));  

            //  print_r($data_gambar4);
            //}

            //if(!empty($row['X'])){
            //  array_push($data_gambar5, array(
            //      'identity_produk'     => $id_sku,
            //      'gambar'              => $row['X'], 
            //  ));  

            //  print_r($data_gambar5);
            //}
        }
      }
      //print_r($data);
      
      //$this->db->update_batch('produk', $data, 'artikel');
      //$this->produk_adm->update_harga_stok($data_harga_stok);
      //delete file from server
      unlink(realpath('data_excel_for_update_product/'.$fupload.''));
      $this->session->set_flashdata('success', 'Upload Produk dan update masal data produk berhasil.');
      redirect(base_url('trueaccon2194/produk'));
    }
  }

  function download_template_upload_produk(){
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    $objPHPExcel = new PHPExcel();
    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Create a first sheet, representing sales data
    $objPHPExcel->setActiveSheetIndex(0);
    //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PRODUK E-COMMERCE");
    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('TEMPLATE UPLOAD PRODUK');
    $objPHPExcel->getActiveSheet()->setCellValue("A1","PETUNJUK CARA UPLOAD PRODUK STARSSTORE MENGGUNAKAN EXCEL"); 
    $objPHPExcel->getActiveSheet()->setCellValue("A2","Pastikan Anda telah mengupload gambar utama secara masal dan menyinkronkan gambar utama dengan database"); 
    $objPHPExcel->getActiveSheet()->setCellValue("A3","Isi kolom dibawah ini dan jangan ubah-ubah posisi kolom. Semua kolom wajib diisi kecuali size
"); 
    $objPHPExcel->getActiveSheet()->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai E1
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
    //$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
    //table header
    $heading = array("ARTIKEL","DIVISI","NAMA PRODUK","WARNA","KETERANGAN","MERK","KATEGORI","PARENT","BERAT","STATUS","STOK","HARGA DICORET","HARGA FIX","LOKASI BARANG","SIZE 1","SIZE 2","SIZE 3","SIZE 4","SIZE 5");
    //loop heading
    $rowNumberH = 5;
    $colH = 'A';
    foreach($heading as $h){
        $objPHPExcel->getActiveSheet()->setCellValue($colH.$rowNumberH,$h);
        $objPHPExcel->getActiveSheet()->getStyle($colH.$rowNumberH,$h)->applyFromArray($style_col);
        $colH++;    
    }

    // BUAT SHEET UNTUK MERK, DIVISI, KATEGORI, PARENT KATEGORI
    $objPHPExcel->createSheet();
    $objPHPExcel->setActiveSheetIndex(1);
    //$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', "PERTELAAN BARANG MASUK & KELUAR"); // Set kolom A1
    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('INFORMASI & PETUNJUK');
    $objPHPExcel->getActiveSheet()->setCellValue("A1","Gunakan ID Merk, ID Divisi, ID Kategori dan ID Parent Kategori saat mengisi data produk yang ada disheet Data produk E-commerce"); 
    $objPHPExcel->getActiveSheet()->setCellValue("A1","Untuk warna dan ukuran, harus Sesuai dengan informasi warna dan ukuran di excel ini"); 
    // MERK
    $headingmerk = array("ID MERK","MERK");
    //loop heading
    $rowNumberHmerk = 3;
    $colHmerk = 'A';
    foreach($headingmerk as $hmerk){
        $objPHPExcel->getActiveSheet()->setCellValue($colHmerk.$rowNumberHmerk,$hmerk);
        $objPHPExcel->getActiveSheet()->getStyle($colHmerk.$rowNumberHmerk,$hmerk)->applyFromArray($style_col);
        $colHmerk++;    
    }
    $mulaimerk = 4;
    $get_merk = $this->produk_adm->get_merk();
    foreach($get_merk as $m){
      //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("A".$mulaimerk, $m->merk_id); 
        $objPHPExcel->getActiveSheet()->setCellValue("B".$mulaimerk, $m->merk); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('A'.$mulaimerk)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$mulaimerk)->applyFromArray($style_row);
        $mulaimerk++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); 
    }

    // DIVISI
    $headingd = array("ID DIVISI","DIVISI");
    //loop heading
    $rowNumberHd = 3;
    $colHd = 'D';
    foreach($headingd as $hd){
        $objPHPExcel->getActiveSheet()->setCellValue($colHd.$rowNumberHd,$hd);
        $objPHPExcel->getActiveSheet()->getStyle($colHd.$rowNumberHd,$hd)->applyFromArray($style_col);
        $colHd++;    
    }
    $ddivisi = 4;
    $get_divisi = $this->produk_adm->get_data_milik();
    foreach($get_divisi as $m){
      //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("D".$ddivisi, $m->id_milik); 
        $objPHPExcel->getActiveSheet()->setCellValue("E".$ddivisi, $m->milik); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('D'.$ddivisi)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$ddivisi)->applyFromArray($style_row);
        $ddivisi++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
    }

    // KATEGORI
    $headingk = array("ID KATEGORI","KATEGORI");
    //loop heading
    $rowNumberHk = 3;
    $colHk = 'G';
    foreach($headingk as $hk){
        $objPHPExcel->getActiveSheet()->setCellValue($colHk.$rowNumberHk,$hk);
        $objPHPExcel->getActiveSheet()->getStyle($colHk.$rowNumberHk,$hk)->applyFromArray($style_col);
        $colHk++;    
    }
    $kkat = 4;
    $get_kateg = $this->produk_adm->get_kategori();
    foreach($get_kateg as $k){
      //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("G".$kkat, $k->kat_id); 
        $objPHPExcel->getActiveSheet()->setCellValue("H".$kkat, $k->kategori); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('G'.$kkat)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$kkat)->applyFromArray($style_row);
        $kkat++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
      $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
    }

    // PARENT KATEGORI
    $headingp = array("ID PARENT KATEGORI","PARENT KATEGORI");
    //loop heading
    $rowNumberHp = 3;
    $colHp = 'J';
    foreach($headingp as $hp){
        $objPHPExcel->getActiveSheet()->setCellValue($colHp.$rowNumberHp,$hp);
        $objPHPExcel->getActiveSheet()->getStyle($colHp.$rowNumberHp,$hp)->applyFromArray($style_col);
        $colHp++;     
    }
    $pkat = 4;
    $get_parkat = $this->produk_adm->get_parent_kategori();
    foreach($get_parkat as $p){
      //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("J".$pkat, $p->id_parent); 
        $objPHPExcel->getActiveSheet()->setCellValue("K".$pkat, $p->parent_kategori); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('J'.$pkat)->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$pkat)->applyFromArray($style_row);
        $pkat++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); 
      $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); 
    }

    // WARNA
    $headingp = array("WARNA");
    //loop heading
    $rowNumberHp = 3;
    $colHp = 'M';
    foreach($headingp as $hp){
        $objPHPExcel->getActiveSheet()->setCellValue($colHp.$rowNumberHp,$hp);
        $objPHPExcel->getActiveSheet()->getStyle($colHp.$rowNumberHp,$hp)->applyFromArray($style_col);
        $colHp++;     
    }
    $pkat = 4;
    $get_parkat = $this->produk_adm->get_color_all();
    foreach($get_parkat as $p){
      //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("M".$pkat, $p->opsi_color); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('M'.$pkat)->applyFromArray($style_row);
        $pkat++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); 
    }

    // UKURAN
    $headingp = array("UKURAN");
    //loop heading
    $rowNumberHp = 3;
    $colHp = 'O';
    foreach($headingp as $hp){
        $objPHPExcel->getActiveSheet()->setCellValue($colHp.$rowNumberHp,$hp);
        $objPHPExcel->getActiveSheet()->getStyle($colHp.$rowNumberHp,$hp)->applyFromArray($style_col);
        $colHp++;     
    }
    $pkat = 4;
    $get_parkat = $this->produk_adm->get_size_all();
    foreach($get_parkat as $p){
      //pemanggilan sesuaikan dengan nama kolom tabel
        $objPHPExcel->getActiveSheet()->setCellValue("O".$pkat, $p->opsi_size); 
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $objPHPExcel->getActiveSheet()->getStyle('O'.$pkat)->applyFromArray($style_row);
        $pkat++;
        
      $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true); 
    }

    // LOKASI BARANG
    $objPHPExcel->getActiveSheet()->setCellValue("Q3","LOKASI BARANG"); 
    $objPHPExcel->getActiveSheet()->setCellValue("Q4","ecommerce"); 
    $objPHPExcel->getActiveSheet()->setCellValue("Q5","store"); 

    $objPHPExcel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Q4')->applyFromArray($style_row);
    $objPHPExcel->getActiveSheet()->getStyle('Q5')->applyFromArray($style_row);

 
    // Redirect output to a client’s web browser (Excel5)
    $filename = urlencode("Template_Upload_Produk_Starsstore.xlsx");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    log_helper('laporan', ''.$this->data['username'].' ('.$this->data['id'].') Download Template Produk (Excel) untuk keperluan upload produk ');
  }

  function ambil_data_upload($id){
    $a = $this->encrypt->encode($id); 
    $b = base64_encode($a);
    $get = $this->produk_adm->get_data_produk($b);
    $sess_data['sku_produk'] = $get['sku_produk'];
    $this->session->set_userdata($sess_data);
    echo json_encode($get);
  }

}