<?php 
$get_data_setting = for_header();
$user_log = info_user_login();
?>
<html>
    <head>
        
        <!-- Title -->
        <title>Administrator</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <?php $get_data_setting = for_header_front_end();?>
        <?php foreach($get_data_setting as $data):?>
            <link rel="shortcut icon" href="<?php echo base_url('assets/manage/img/')?><?php echo $data->konten;?>" />
        <?php endforeach;?>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="index,no-follow"/>
        <meta name="copyright" content="This website has been registered and trademark of PT. STARS INTERNASIONAL, Inc "/>
        
        <!-- Styles -->        
         
        <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>-->
        <link href="<?php echo base_url('assets/manage/js/pace-master/themes/blue/pace-theme-flash.css');?>" rel="stylesheet"/>
        <link href="<?php echo base_url('assets/manage/js/uniform/css/uniform.default.min.css')?>" rel="stylesheet"/>
        <link href="<?php echo base_url('assets/manage/js/fontawesome/css/font-awesome.css');?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/manage/js/line-icons/simple-line-icons.css');?>" rel="stylesheet" type="text/css"/> 
        <link href="<?php echo base_url('assets/manage/js/offcanvasmenueffects/css/menu_cornerbox.css');?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('assets/manage/js/waves/waves.min.css');?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('assets/manage/js/switchery/switchery.min.css');?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/manage/js/3d-bold-navigation/css/style.css');?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/manage/js/slidepushmenus/css/component.css');?>" rel="stylesheet" type="text/css"/> 
        <link href="<?php echo base_url('assets/manage/js/metrojs/MetroJs.min.css');?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('assets/manage/js/toastr/toastr.min.css');?>" rel="stylesheet" type="text/css"/>  
          
        <!-- Theme Styles -->
        <link href="<?php echo base_url('assets/manage/css/bootstrap.css');?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/manage/css/jquery.fancybox-1.3.4.css');?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/manage/css/circle.css');?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/manage/css/modern.min.css');?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/manage/css/themes/green.css');?>" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/manage/css/custom.css');?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/manage/js/autoCom/jquery.autocomplete.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/manage/css/owl.carousel.css" type="text/css">

        <!-- JS Style -->
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery-3.1.1.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery-1.10.2.min.js');?>"></script>

        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery/JQuery.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/highcharts.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/highcharts-3d.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/exporting.js');?>"></script>
        <script type='text/javascript' src="<?php echo base_url('assets/manage/js/tinymce/tinymce.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/bootstrap.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/js.cookie.js')?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/jquery.dataTables.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/clipboard.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/dataTables.bootstrap.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/sistem_adm.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/manage/js/googlemap.js');?>"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdgRhhXUsATFGL7OPWx1vHgnnx-dwBNDI&callback=loadMap"></script>
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>

<body class="page-header-fixed pace-done compact-menu">
      <div class="bg_black clbg_black" style="display:none;width: 120%;margin-top: -101px;height: 1000%;z-index: 9910;background-color: black;opacity: 0.8;position: fixed;">
</div>
<div class="preview_form prev-form" style="display:none;">
  <h3 style="margin-top:-16px;margin-right:-16px;font-size: 20px;"><a href="javascript:void(0);" class="pull-right close_preview_produk label label-warning" style="border-radius:1px;">X</a></h3>
  <h4 class="nama_produk"></h4>
  <hr>
    <div class="col-md-6 col-xs-6" style="margin-bottom:10px;">
      <span>Kategori :</span>
      <div class="kategori teks" style="text-transform:uppercase;font-weight:bold;"></div>
    </div>
    <div class="col-md-6 col-xs-6" style="margin-bottom:10px;">
      <span>Parent :</span>
      <div class="parent teks" style="text-transform:uppercase;font-weight:bold;"></div>
    </div>
    <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Milik :</span>
      <div class="milik teks" style="text-transform:uppercase;font-weight:bold;"></div>
    </div>
    <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Jenis :</span>
      <div class="jenis teks" style="text-transform:uppercase;font-weight:bold;"></div>
    </div>
    <div style="display:none;" class="hidden-xs"></div>
    <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Artikel :</span>
      <div class="artikel teks" style="text-transform:uppercase;font-weight:bold;"></div> 
    </div>
    <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Merk :</span>
      <div class="merk teks" style="text-transform:uppercase;font-weight:bold;"></div>
    </div>
    <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Point :</span>
      <div class="point teks" style="text-transform:uppercase;font-weight:bold;"></div>
    </div>
    <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Retail :</span>
      <div style="text-transform:uppercase;font-weight:bold;" class="teks">Rp. <span class="retail"></span></div>
    </div>
    <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Odv :</span>
      <div style="text-transform:uppercase;font-weight:bold;" class="teks">Rp. <span class="odv"></span></div>
    </div>
     <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Diskon :</span>
      <div style="text-transform:uppercase;font-weight:bold;"><span class="diskon teks"></span>&nbsp</div>
    </div>
    <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Stok :</span>
      <div style="text-transform:uppercase;font-weight:bold;"><span class="stok teks"></span>&nbsp</div>
    </div>
    <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Berat :</span>
      <div style="text-transform:uppercase;font-weight:bold;" class="teks"><span class="berat" ></span>KG</div>
    </div>
    <div class="col-md-3 col-xs-4" style="margin-bottom:10px;">
      <span>Status :</span><br>
      <div style="text-transform:uppercase;font-weight:bold;"><span class="status teks"></span>&nbsp</div>
    </div>
     <div class="col-md-12 col-xs-12" style="margin-bottom:10px;">
      <span>Slug :</span>
      <div class="slug teks" style="text-transform:uppercase;font-weight:bold;"></div>
    </div>
    <div class="col-md-12 col-xs-12" style="margin-bottom:10px;">
      <span>Tags :</span>
      <div class="tags teks" style="text-transform:uppercase;font-weight:bold;"></div>
    </div>
     <div class="col-md-12 col-xs-12" style="margin-bottom:10px;">
      <span>Dibuat :</span>
      <div class="teks" style="text-transform:uppercase;font-weight:bold;"><span class="dibuat"></span> | <span class="dibuat_tgl"></span></div>
    </div>
     <div class="col-md-12 col-xs-12" style="margin-bottom:10px;">
      <span>Diedit :</span>
      <div class="teks" style="text-transform:uppercase;font-weight:bold;"><span class="diubah"></span> | <span class="diubah_tgl"></span></div>
    </div>
</div>

        <div class="overlay"></div>
        <div class="menu-wrap">
            <nav class="profile-menu">
                <div class="profile">                 
                    <?php
                      foreach($user_log as $datas){
                      if(empty($datas->gb_user)){
                    ?>
                      <img src="<?php echo base_url('assets/manage/img/default.png')?>" width="60">
                      <span><?php echo word_limiter($datas->nama_depan,1);?></span>
                    <?php } else{?>
                      <img src="<?php echo base_url('assets/manage/img/user/'.$datas->gb_user)?>" width="60" height="60">
                      <span><?php echo word_limiter($datas->nama_depan,1);?></span>
                    <?php }}?>

                </div>
                <div class="profile-menu-list">
                    <a href="<?php echo base_url('trueaccon2194/setting/user_profile')?>"><i class="fa fa-user"></i><span>Profile</span></a>
                    <a href="<?php echo base_url('trueaccon2194/user_preference/progres_kinerja')?>"><i class="fa fa-bar-chart"></i><span>Progres Kinerja</span></a>
                    <a href="<?php echo base_url('trueaccon2194/info_type_user_log/logout_system')?>"><i class="fa fa-sign-out"></i><span>Logout</span></a>
                </div>
            </nav>
            <button class="close-button" id="close-button">Close Menu</button>
            <div style="top:250px;right:10px;position: absolute;">
                <div class="ios-switch pull-right switch-md">
                    <input type="checkbox" class="js-switch pull-right compact-menu-check" >
                </div>
            </div>
        </div>
        <form class="search-form" action="#" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control search-input" onkeyup="srcOrderHelp(this);" placeholder="Cari sesuatu...">
                <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic clbg_black" type="button"><i class="fa fa-times"></i></button>
                </span>
            </div><!-- Input Group -->
        </form><!-- Search Form -->
        <div class="search-form resultheader" style="display: none;"></div>
        <main class="page-content content-wrap">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="sidebar-pusher">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="logo-box text-center" style="background-color: #2b384e;">
                        <?php $get_data_setting = for_header_front_end();?>
                        <?php foreach($get_data_setting as $data):?>
                        <a href="<?php echo base_url()?>" target="_new">
                            <img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" width="100">
                        </a>
                        <?php endforeach;?>
                    </div><!-- Logo Box -->
                    <div class="search-button">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                    </div>
                    <div class="topmenu-outer">
                        <div class="top-menu">
                            <ul class="nav navbar-nav navbar-left">
                                <li class="hidden">    
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                                </li>
                                <li class="hidden">
                                    <a href="#cd-nav" class="waves-effect waves-button waves-classic cd-nav-trigger"><i class="fa fa-diamond"></i></a>
                                </li>
                                <li class="hidden">    
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-md dropdown-list theme-settings" role="menu">
                                        <li class="hidden li-group">
                                            <ul class="list-unstyled">
                                                <li class="no-link" role="presentation">
                                                    Fixed Header 
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right fixed-header-check" checked>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="li-group">
                                            <ul class="list-unstyled">
                                                <li class="hidden no-link" role="presentation">
                                                    Fixed Sidebar 
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right fixed-sidebar-check" >
                                                    </div>
                                                </li>
                                                <li class="hidden no-link" role="presentation">
                                                    Horizontal bar 
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right horizontal-bar-check">
                                                    </div>
                                                </li>
                                                <li class="hidden no-link" role="presentation">
                                                    Toggle Sidebar 
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right toggle-sidebar-check">
                                                    </div>
                                                </li>
                                                <li class="no-link" role="presentation">
                                                    Compact Menu 
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right compact-menu-check" >
                                                    </div>
                                                </li>
                                                <li class="hidden no-link" role="presentation">
                                                    Hover Menu 
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right hover-menu-check">
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class=" hidden li-group">
                                            <ul class="list-unstyled">
                                                <li class="no-link" role="presentation">
                                                    Choose Theme Color
                                                    <div class="color-switcher">
                                                        <a class="colorbox color-blue" href="?theme=blue" title="Blue Theme" data-css="blue"></a>
                                                        <a class="colorbox color-green" href="?theme=green" title="Green Theme" data-css="green"></a>
                                                        <a class="colorbox color-red" href="?theme=red" title="Red Theme" data-css="red"></a>
                                                        <a class="colorbox color-white" href="?theme=white" title="White Theme" data-css="white"></a>
                                                        <a class="colorbox color-purple" href="?theme=purple" title="purple Theme" data-css="purple"></a>
                                                        <a class="colorbox color-dark" href="?theme=dark" title="Dark Theme" data-css="dark"></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="hidden no-link"><button class="btn btn-default reset-options">Reset Options</button></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li>  
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"><i class="fa fa-certificate" style="color:green"></i></a>
                                    <ul class="dropdown-menu title-caret dropdown-lg" role="menu">
                                        <li><p class="drop-title"><b>Selamat datang di program stars ecommerce v 1.2<br>Apa yang baru dari program ini?</b></p></li>
                                        <li class="dropdown-menu-list slimscroll messages" style="padding: 10px;">
                                            <ul class="list-unstyled">
                                              <li style="padding: 5px;">Mutasi rekening & cek otomatis pembayaran</li>
                                              <li style="padding: 5px;">Note untuk admin bila ingin menulis sesuatu (icon pensil pojok kanan atas)</li>
                                              <li style="padding: 5px;">Sinkron data produk dengan gambar di master</li>
                                              <li style="padding: 5px;">Dapat mengetahui toko mana yang menangani pesanan dan invoice berubah alamat pengirimnya (dari toko / pusat)</li>
                                              <li style="padding: 5px;">Analisis traffic aktifitas pengunjung dengan mengunjungi produk (di menu produk dilihat)</li>
                                              <li style="padding: 5px;">Table produk terbaru</li>
                                              <li style="padding: 5px;">Diskon produk masal dengan waktu tertentu</li>
                                              <li style="padding: 5px;">Standarisasi tata cara packing dan pengiriman untuk toko (https://www.starsstore.id/standarisasi-pelayanan-online-toko)</li>
                                              <li style="padding: 5px;">Store Map Toko Stars untu admin (untuk publik masih dikembangkan)</li>
                                              <li style="padding: 5px;">Fitur pencarian di dashboard admin</li>
                                              <li style="padding: 5px;">Free ongkir untuk kota tertentu</li>
                                              <li style="padding: 5px;">Voucher minimum pembelanjaan</li>
                                              <li style="padding: 5px;">Menu Galeri telah aktif</li>
                                              <li style="padding: 5px;">Laporan RPP/RPK otomatis dihitung dari menu barang terjual</li>
                                              <li style="padding: 5px;">Tema Ecommerce bisa diganti-ganti (masih v1)</li>
                                              <li style="padding: 5px;">Management produk sinkron dengan gambar RIM</li>
                                              <li style="padding: 5px;">Update harga cukup sekali di sm.stars.co.id upload di sistem</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>  
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"><i class="fa fa-exchange"></i></a>
                                    <ul class="dropdown-menu title-caret dropdown-lg" role="menu">
                                        <li><p class="drop-title"><b>Kurs mata uang negara</b></p></li>
                                        <li class="dropdown-menu-list slimscroll messages" style="padding: 10px;">
                                            <?php 
                                                $kurs = kursbca();
                                                echo $kurs
                                            ?>
                                        </li>
                                        <li class="drop-all" style="padding: 10px;"><i>Sumber : Bank BCA</i></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                <?php $get_data_kontak = notif_kontak();
                                $notifkontak = 0;
                                foreach($get_data_kontak as $r){
                                    $notifkontak = $r->kt;
                                }
                                ?>
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"><i class="fa fa-envelope"></i><span class="badge badge-success pull-right"><?php echo $notifkontak?></span></a>
                                    <ul class="dropdown-menu title-caret dropdown-lg" role="menu">
                                        <li><p class="drop-title">Anda memiliki <?php echo $notifkontak?> pesan baru!</p></li>
                                        <li class="dropdown-menu-list slimscroll messages">
                                            <ul class="list-unstyled">
                                                <?php $get_data_kontak1 = isi_notif_kontak();
                                                foreach($get_data_kontak1 as $r){?>
                                                <li>
                                                    <a href="<?php echo base_url()?>trueaccon2194/kontak/reply_and_read/<?php $id = $r->id_kontak; $idp = base64_encode($id); echo $idp ?>">
                                                        <div class="msg-img">
                                                            <?php if($r->baca == "belum"){?>
                                                                <div class="online on"></div>
                                                            <?php }?>
                                                            <img class="img-circle" src="<?php echo base_url('assets/manage/img/default.png');?>" alt=""></div>
                                                        <p class="msg-name"><?php echo $r->nama?></p>
                                                        <p class="msg-text"><?php echo word_limiter($r->pertanyaan,5);?></p>
                                                        <p class="msg-time"><?php echo $r->date_create?></p>
                                                    </a>
                                                </li>
                                                <?php }?>
                                            </ul>
                                        </li>
                                        <li class="drop-all"><a href="<?php echo base_url('trueaccon2194/kontak')?>" class="text-center">Semua kontak</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <?php 
                                        // Pelanggan
                                        $get_data_customer = notif_new_customer();
                                        $notifCustomer = 0;
                                        foreach($get_data_customer as $r){
                                            $notifCustomer = $r->cus;
                                        }
                                        // pesanan
                                        $get_data_order = notif_order();
                                        $notifOrder = 0;
                                        foreach($get_data_order as $r){
                                            $notifOrder = $r->pesanan;
                                        }
                                        // Stok
                                        $get_data_stok = notif_stok();
                                        $notifStok = 0; 
                                        foreach($get_data_stok as $r){
                                            $notifStok = $r->stok;
                                        }
                                        // voucher end
                                        $get_data_voucher = notif_voucher_end();
                                        $notifVoucher = 0;
                                        foreach($get_data_voucher as $r){
                                            $notifVoucher = $r->vou;
                                        }
                                        // stok critical voucher
                                        $get_data_stok_end_voucher = notif_voucher_stok_end();
                                        $notifstokVoucher = 0;
                                        foreach($get_data_stok_end_voucher as $r){
                                            $notifstokVoucher = $r->voustok;
                                        }
                                        // banner end
                                        $get_data_banner_end = banner_end();
                                        $notifbanner= 0;
                                        foreach($get_data_banner_end as $r){
                                            $notifbanner = $r->banner;
                                        }
                                        // blacklist
                                        $get_data_blacklist = list_blacklist();
                                        $notifblacklist= 0;
                                        foreach($get_data_blacklist as $r){
                                            $notifblacklist= $r->blacklist;
                                        }
                                        // total notifikasi
                                        $totalNotif = 0;
                                        $totalNotif = $notifCustomer + $notifOrder + $notifStok + $notifVoucher + $notifstokVoucher + $notifbanner + $notifblacklist;
                                        ?>
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"><i class="fa fa-bell"></i><span class="badge badge-success pull-right"><?php echo $totalNotif;?></span></a>
                                    <ul class="dropdown-menu title-caret dropdown-lg" role="menu">
                                        <li><p class="drop-title">Anda memiliki <?php echo $totalNotif;?> notifikasi !</p></li>
                                        <li class="dropdown-menu-list slimscroll tasks">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a href="<?php echo base_url('trueaccon2194/customer');?>">
                                                        <div class="task-icon badge badge-success"><i class="icon-user"></i></div>
                                                        <span class="badge badge-roundless badge-success pull-right"><?php echo $notifCustomer?></span>
                                                        <p class="task-details">Pelanggan Baru.</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url('trueaccon2194/order');?>">
                                                        <div class="task-icon badge badge-info"><i class="glyphicon glyphicon-shopping-cart"></i></div>
                                                        <span class="badge badge-roundless badge-info pull-right"><?php echo $notifOrder?></span>
                                                        <p class="task-details">Pesanan Baru</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url('trueaccon2194/stok');?>">
                                                        <div class="task-icon badge badge-warning"><i class="glyphicon glyphicon-alert"></i></div>
                                                        <span class="badge badge-roundless badge-warning pull-right"><?php echo $notifStok?></span>
                                                        <p class="task-details">Stok Produk Hampir Habis</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url('trueaccon2194/voucher');?>">
                                                        <div class="task-icon badge badge-danger"><i class="glyphicon glyphicon-gift"></i></div>
                                                        <span class="badge badge-roundless badge-danger pull-right"><?php echo $notifstokVoucher?></span><span class="badge badge-roundless badge-danger pull-right"><?php echo $notifVoucher?></span>
                                                        <p class="task-details">Voucher Berakhir dan Stok Voucher habis.</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url('trueaccon2194/media_promosi');?>">
                                                        <div class="task-icon badge badge-danger"><i class="glyphicon glyphicon-picture"></i></div>
                                                        <span class="badge badge-roundless badge-danger pull-right"><?php echo $notifbanner?></span>
                                                        <p class="task-details">Banner Berakhir.</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url('trueaccon2194/blacklist');?>">
                                                        <div class="task-icon badge badge-danger"><i class="icon-ban"></i></div>
                                                        <span class="badge badge-roundless badge-danger pull-right"><?php echo $notifblacklist?></span>
                                                        <p class="task-details">Deteksi blacklist.</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="drop-all"><a href="#" class="text-center"></a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <?php
                                            foreach($user_log as $datas){
                                            if(empty($datas->gb_user)){
                                        ?>
                                            <span class="user-name"><?php echo $datas->nama_depan?><i class="fa fa-angle-down"></i></span>
                                            <img class="img-circle avatar" src="<?php echo base_url('assets/manage/img/default.png')?>" width="40" height="40" alt="">
                                        <?php } else{?>
                                            <span class="user-name"><?php echo $datas->nama_depan?><i class="fa fa-angle-down"></i></span>
                                            <img class="img-circle avatar" src="<?php echo base_url('assets/manage/img/user/'.$datas->gb_user)?>" width="40" height="40" alt="">
                                        <?php }}?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-list" role="menu">
                                        <li role="presentation"><a href="<?php echo base_url('trueaccon2194/setting/user_profile');?>"><i class="fa fa-user"></i>Profile</a></li>
                                        <li role="presentation"><a href="<?php echo base_url('lock_screen_default');?>"><i class="fa fa-lock"></i>Lock screen</a></li>
                                        <li>
                                            <div class="infouser1">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">Login Info</h4>
                                                </div>
                    
                                                <div class="panel-body">
                                                    <div class="server-load">
                                                        <?php 
                                                            $user_log = info_user_login();
                                                            foreach($user_log as $datas){
                                                        ?>
                                                        <ul class="list-unstyled">
                                                            <li style="padding-bottom:10px;border-bottom:1px solid #eee;">User : <?php echo $datas->nama_depan;?></li>
                                                             <?php
                                                                foreach($user_log as $datas){
                                                                    if($datas->akses == "G7)*#_fsRe"){
                                                                        $ak = "Administrator";
                                                                    }elseif($datas->akses == "FnC%4%7d8B"){
                                                                        $ak = "Finance";
                                                                    }elseif($datas->akses == "S_lf63*%@)"){
                                                                        $ak = "Sales";
                                                                    }elseif($datas->akses == "pG5Y$7(#1@"){
                                                                        $ak = "Support";
                                                                    }elseif($datas->akses == "WrTd3*6)^@"){
                                                                        $ak = "Writer";
                                                                    }
                                                                }
                                                            ?>
                                                            <li style="padding-top:10px;padding-bottom:10px;border-bottom:1px solid #eee;">Akses : <?php echo $ak?></li>
                                                            <li style="padding-top:10px;padding-bottom:10px;border-bottom:1px solid #eee;">Login Terakhir: <br><?php echo date('d F Y H:i:s', strtotime($this->session->userdata('last_login')));?></li>
                                                            <li style="padding-top:10px;padding-bottom:10px;border-bottom:1px solid #eee;">IP : <?php echo $this->input->ip_address();?></li>
                                                            <li style="padding-top:10px;padding-bottom:10px;border-bottom:1px solid #eee;">Browser : <?php echo $this->agent->browser();?></li>
                                                            <li style="padding-top:10px;padding-bottom:10px;border-bottom:1px solid #eee;">OS : <?php echo $this->agent->platform();?></li>
                                                            <li style="padding-top:10px;padding-bottom:10px;border-bottom:1px solid #eee;"><a href="<?php echo base_url('trueaccon2194/report_order/download_form');?>">Download Hasil Aplikasi</a></li>
                                                       </ul>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('trueaccon2194/info_type_user_log/logout_system')?>" class="log-out waves-effect waves-button waves-classic">
                                        <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                                    </a>
                                </li>
                            </ul><!-- Nav -->
                        </div><!-- Top Menu -->
                    </div>
                </div>
            </div><!-- Navbar -->
            <div class="page-sidebar sidebar" style="overflow: inherit !important;">
                <div class="page-sidebar-inner slimscroll" style="overflow: inherit !important;">
                    <div class="sidebar-header">
                        <div class="sidebar-profile">
                            <a href="javascript:void(0);" id="profile-menu-link">
                                <div class="sidebar-profile-image">
                                    <?php
                                        foreach($user_log as $datas){
                                        if(empty($datas->gb_user)){
                                    ?>
                                        <img class="img-circle img-responsive" src="<?php echo base_url('assets/manage/img/default.png')?>" height="60" width="60">
                                    <?php } else{?>
                                        <img class="img-circle img-responsive" src="<?php echo base_url('assets/manage/img/user/'.$datas->gb_user)?>" width="60" height="60">
                                        
                                    <?php }}?>
                                </div>
                                <div class="sidebar-profile-details">
                                    <?php
                                        foreach($user_log as $datas){
                                            if($datas->akses == "G7)*#_fsRe"){
                                                $ak = "Administrator";
                                            }elseif($datas->akses == "FnC%4%7d8B"){
                                                $ak = "Finance";
                                            }elseif($datas->akses == "S_lf63*%@)"){
                                                $ak = "Sales";
                                            }elseif($datas->akses == "pG5Y$7(#1@"){
                                                $ak = "Support";
                                            }elseif($datas->akses == "WrTd3*6)^@"){
                                                $ak = "Writer";
                                            }
                                        if(empty($datas->gb_user)){
                                    ?>
                                        <span><?php echo $datas->nama_depan?><br><small><?php echo $ak?></small></span>
                                    <?php } else{?>
                                        <span><?php echo $datas->nama_depan?><br><small><?php echo $ak?></small></span>
                                    <?php }}?>
                                    
                                </div>
                            </a>
                        </div>
                    </div>
                    <ul class="menu accordion-menu">
                        <li class="active"><a href="<?php echo base_url('trueaccon2194/info_type_user_log')?>" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard </p></a></li> 
                        <li>
                            <?php if($this->session->userdata('ymarket1') == "checked"){?>
                                <a href="<?php echo base_url('trueaccon2194/online_store')?>" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-globe"></span><p>Market Place</p></a>
                            <?php }else{ }?>
                        </li>
                        <?php if($this->session->userdata('ymail1') == "checked"){?>
                        <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-envelope"></span><p>Newsletter</p><span class="arrow"></span></a>
                        <?php }?>
                            <?php if($this->session->userdata('ymail1') == "checked"){?>
                            <ul class="sub-menu">
                            <?php }?>
                                <?php if($this->session->userdata('yinbox1') == "checked"){?>
                                    <li><a href="<?php echo base_url('trueaccon2194/email')?>">Email & Broadcast WA</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ywrite1') == "checked"){?>
                                    <li><a href="<?php echo base_url('trueaccon2194/email/broadcast')?>">Broadcast Email</a></li>
                                <?php }else{ }?>
                            <?php if($this->session->userdata('ymail1') == "checked"){?>
                            </ul>
                            <?php }else{ }?>
                        <?php if($this->session->userdata('ymail1') == "checked"){?>
                        </li>
                        <?php }else{ }?>
                        <?php if($this->session->userdata('yproduk1') == "checked"){?>
                        <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-tags"></span><p>Produk</p><span class="arrow"></span></a>
                        <?php }?>
                            <?php if($this->session->userdata('yproduk1') == "checked"){?>
                            <ul class="sub-menu">
                            <?php }?>
                                <?php if($this->session->userdata('ydafpro1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/produk')?>">Daftar Produk</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ymaster1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/produk/master_barang')?>">Master Barang</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ykatparkat1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/kategori_dan_parent_kategori')?>">Kategori & Parent Kategori</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ykatdiv1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/kategori_divisi')?>">Kategori Divisi</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yopsipro1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/opsional')?>">Opsional Produk</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ymerk1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/merk')?>">Merk</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ystok1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/stok')?>">Stok</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yrevpro1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/review_produk')?>">Review dan Q&A Produk</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yprobeli1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/produk_dibeli')?>">Produk dibeli</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yproview1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/produk_dilihat')?>">Produk dilihat</a></li>
                                <?php }else{ }?>
                            <?php if($this->session->userdata('yproduk1') == "checked"){?>
                            </ul>
                            <?php }?>
                        <?php if($this->session->userdata('yproduk1') == "checked"){?>
                        </li>
                        <?php }?>
                        <?php if($this->session->userdata('ysales1') == "checked"){?>
                        <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-shopping-cart"></span><p>Sales <?php if($notifOrder > 0){ echo "<span style='background-color:#22BAA0;color:white;border-radius:50px;padding:3px 6px;' class='badge-success'>$notifOrder</span>"; }else{ }?></p><span class="arrow"></span></a>
                        <?php }?>
                            <?php if($this->session->userdata('ysales1') == "checked"){?>
                            <ul class="sub-menu">
                            <?php }?>
                            <?php if($this->session->userdata('ybestseller1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/bestseller')?>">Best Seller</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yorder1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/order')?>">Order & Konfirmasi<?php if($notifOrder > 0){ echo "<span class='badge badge-success'>$notifOrder</span>"; }else{ }?></a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ypajak1') == "checked"){?>
                                <li class="hidden"><a href="#">Pajak</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yretur1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/retur')?>">Retur</a></li>
                                <?php }else{ }?>
                            <?php if($this->session->userdata('ysales1') == "checked"){?> 
                            </ul>
                            <?php }?>
                        <?php if($this->session->userdata('ysales1') == "checked"){?>
                        </li>
                        <?php }?>
                        <?php if($this->session->userdata('ycustomer1') == "checked"){?>
                        <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-user"></span><p>Customer  <?php if($notifCustomer > 0){ echo "<span style='background-color:#22BAA0;color:white;border-radius:50px;padding:3px 6px;' class='badge-success'>$notifCustomer</span>"; }else{ }?></p><span class="arrow"></span></a>
                        <?php }?>
                            <?php if($this->session->userdata('ycustomer1') == "checked"){?>
                            <ul class="sub-menu">
                            <?php }?>
                                <?php if($this->session->userdata('ydatacustomer1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/customer')?>">Data Customer <?php if($notifOrder > 0){ echo "<span class='badge badge-success'>$notifCustomer</span>"; }else{ }?></a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ypointcustomer1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/point_customer')?>">Point Customer</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ycustomeronline1') == "checked"){?>
                                <li class="hidden"><a href="<?php echo base_url('trueaccon2194/customer_online')?>">Customer Online</a></li>
                                <?php }else{ }?>
                            <?php if($this->session->userdata('ycustomer1') == "checked"){?>
                            </ul>
                            <?php }?>
                        <?php if($this->session->userdata('ycustomer1') == "checked"){?>
                        </li>
                        <?php }?>
                        <?php if($this->session->userdata('ylaporan1') == "checked"){?>
                        <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-stats"></span><p>Laporan</p><span class="arrow"></span></a>
                        <?php }?>
                            <?php if($this->session->userdata('ylaporan1') == "checked"){?>
                            <ul class="sub-menu">
                            <?php }?>
                                <?php if($this->session->userdata('yorderlap1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/report_order/')?>">Rasio Perolehan</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yrpp1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/rpp_rpk/')?>">RPP / RPK</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yinout1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/inout/')?>">Barang Masuk & Keluar</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yutang1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/hutang_piutang/')?>">Laporan Hutang &Piutang</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ypajaklap1') == "checked"){?>
                                <li class="hidden"><a href="#">Pajak</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ypengiriman1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/laporan_pengiriman/')?>">Pengiriman</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yreturlap1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/laporan_retur/')?>">Retur</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yvoucherlap1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/laporan_voucher/')?>">Voucher</a></li>
                                <?php }else{ }?>
                            <?php if($this->session->userdata('ylaporan1') == "checked"){?>
                            </ul>
                            <?php }?>
                        <?php if($this->session->userdata('ypromosi1') == "checked"){?>
                        </li>
                        <?php }?>
                        <?php if($this->session->userdata('ypromosi1') == "checked"){?>
                        <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-gift"></span><p>Promosi</p><span class="arrow"></span></a>
                        <?php }?>
                            <?php if($this->session->userdata('ypromosi1') == "checked"){?>
                            <ul class="sub-menu">
                            <?php }?>
                                <?php if($this->session->userdata('yvouandcou1') == "checked"){?>
                                <li style="display: none;"><a href="<?php echo base_url('trueaccon2194/voucher')?>">Voucher & Kupon</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ypromoslideutama1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/alat_promosi')?>">Alat Promosi</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ybannerslider1') == "checked"){?>
                                <li style="display: none;"><a href="<?php echo base_url('trueaccon2194/media_promosi')?>">Banner & Slider</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ygallery1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/galeri')?>">Gallery</a></li>
                                <?php }else{ }?>
                            <?php if($this->session->userdata('ypromosi1') == "checked"){?>
                            </ul>
                            <?php }?>
                        <?php if($this->session->userdata('ypromosi1') == "checked"){?>
                        </li>
                        <?php }?>
                        <?php if($this->session->userdata('ysistem1') == "checked"){?>
                        <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-hdd"></span><p>Sistem</p><span class="arrow"></span></a>
                        <?php }?>
                            <?php if($this->session->userdata('ysistem1') == "checked"){?>
                            <ul class="sub-menu">
                            <?php }?>
                                <?php if($this->session->userdata('ysetting1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/setting')?>">Setting</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yuser1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/user_preference')?>">User</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('yuseractivity1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/data_record')?>">User Activity</a></li>
                                <?php }else{ }?>
                                <?php if($this->session->userdata('ybackuprestore1') == "checked"){?>
                                <li><a href="<?php echo base_url('trueaccon2194/backup_and_restore')?>">Backup & Restore</a></li>
                                <?php }else{ }?>
                            <?php if($this->session->userdata('ysistem1') == "checked"){?>
                            </ul>
                            <?php }?>
                        <?php if($this->session->userdata('ysistem1') == "checked"){?>
                        </li>
                        <?php }?>
                    </ul>
                </div><!-- Page Sidebar Inner -->
            </div><!-- Page Sidebar -->
            <div class="page-inner">
            <?php 
              $qna = notif_qna();
                    if($qna['cus'] > 0){
                      echo "<a href='".base_url('trueaccon2194/review_produk')."'>
                            <div class='notifclosing' style='padding-bottom:0;'>
                              <div class='paddnot' style='border-left:5px solid #28a745'>
                                <h3 class='neth3' style='margin-bottom:0;'>Ada ".$qna['cus']." Customer bertanya. mohon dibalas segera</h3>
                              </div>
                            </div>
                            </a>
                      ";
                    }
            ?>
            <?php 
                $tgl = date('d');
                if($tgl == 25 || $tgl == 26 || $tgl == 27 || $tgl == 28 || $tgl == 29 || $tgl == 30 || $tgl == 31 || $tgl == 1 || $tgl == 2 || $tgl == 3){
                    // button setting notifikasi
                    $get_st = notif_closing();
                    if($get_st['aktif'] == "on"){
                        echo "<div class='notifclosing' style='padding-bottom:0;'>
                                    <div class='paddnot'>
                                        <h3 class='neth3'>Persiapan Closing Bulanan</h3>
                                        <ul class='stepclosing' style='display:none;'>
                                            <li>Cek status semua pesanan disemua marketplace & E-commerce</li>
                                            <li>Pastikan pertelaan barang masuk dan keluar yang dikirim toko telah dimasukkan ke POS (Pemindahan antar kode EDP toko)</li>
                                            <li>Masukkan semua bukti transfer per transaksi</li>
                                            <li>Masukkan penjualan di POS, pastikan sama jumlah pasang dan rupiah dengan laporan barang terjual</li>
                                            <li>Masukkan pertelaan barang masuk & keluar di POS dan di E-commerce (Pastikan sama nilai pasang dan rupiahnya)</li>
                                            <li>Masukkan biaya-biaya yang menggunakan uang penjualan (buat di ms. word)</li>
                                            <li>Cetak RPP/ RPK, barang terjual, pertelaan barang masuk dan keluar, cover biaya dan bukti-bukti pembayaran,</li>
                                            <li>Sertakan RPP versi POS untuk dilampirkan ke pembukuan RPP/ RPK</li>
                                            <li>Export dan upload penjualan, pertelaan dan RPP/ RPK versi POS ke sm.stars.co.id</li>
                                        </ul>
                                        <input type='checkbox' name='libur' data-enggine='' onchange='setNotif(this);' class='js-switch pull-right fixed-header-check' checked> Hide
                                    </div>
                                </div>";
                    }else{
                        echo "<div class='notifclosing'>
                                    <div class='paddnot'>
                                        <h3 class='neth3'>Persiapan Closing Bulanan</h3>
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
                                        </ul>
                                        <input type='checkbox' name='libur' data-enggine='on' onchange='setNotif(this);' class='js-switch pull-right fixed-header-check'> Hide
                                    </div>
                                </div>";
                    }
                }else{
                    // ubah tombol ke default
                    $CI =& get_instance();
                    $CI->load->model('home');
                    $CI->home->set_status_default_notif_closing();
                }
            ?>
            <i class="glyphicon glyphicon-pencil note-admin" onclick="showNote();" style="background-color: #22BAA0;padding: 10px;border-radius: 50px;color: white;position: fixed;right: 10px;top:70px; font-size: 16px;z-index: 1;box-shadow: 2px 3px 5px 0px #bfbfbf;"></i>
                