<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	$get_data_setting = for_header_front_end();
	$get_data_cst = info_customer_login();
	foreach($get_data_cst as $tg){
		$hal = $tg->nama_lengkap;
	}
	foreach($get_data_setting as $meta){
	if(empty($title) && empty($meta_desc) && empty($meta_key)){?>
		<title><?php echo $meta->site_title?></title>
		<meta name="description" content="<?php echo $meta->meta_desc?>" />
		<meta name="keywords" content="<?php echo $meta->meta_key?>"/>
	<?php }else{?>
	<?php 
		echo $title;
		echo $meta_desc;
		echo $meta_key;
	}}?>
	<meta name="google-site-verification" content=""/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index,follow"/>
	<meta name="copyright" content="This website has been registered and trademark of PT. STARS INTERNASIONAL, Inc "/>
	<meta charset="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index,follow"/>
	<meta name="copyright" content="This website has been registered and trademark of PT. STARS INTERNASIONAL, Inc "/>
    <meta name="author" content="PT. Stars Internasional, Inc">
    <meta name="language" content="Indonesia">
    <meta name="revisit-after" content="7">
    <meta name="webcrawlers" content="all">
    <meta name="rating" content="general">
    <meta name="spiders" content="all">
    <?php $get_data_setting = for_header_front_end();?>
    <?php foreach($get_data_setting as $data):?>
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" />
    <?php endforeach;?>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/font-awesome.css');?>">
	<link href="<?php echo base_url();?>assets/global/bootstraphelppage.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url('assets/theme/v1/');?>css/animate.css">	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/global/autoCom/jquery.autocomplete.css" type="text/css">
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-78739398-3"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-78739398-3');
	</script>
	<!-- Facebook Pixel Code -->
	<script>
	  !function(f,b,e,v,n,t,s)
	  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	  n.queue=[];t=b.createElement(e);t.async=!0;
	  t.src=v;s=b.getElementsByTagName(e)[0];
	  s.parentNode.insertBefore(t,s)}(window, document,'script',
	  'https://connect.facebook.net/en_US/fbevents.js');
	  fbq('init', '1472453182816875');
	  fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	  src="https://www.facebook.com/tr?id=1472453182816875&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->
</head>
<body class="body body-side">
<div id="mySidenav" class="sidenav"> 
	<div class="head-side-menu text-center">
		<div class="top-menu-slide">
			<label class="inf-log" >Layanan Pelanggan<br>Hai, ada yang bisa kami bantu?</label>
		</div>
	</div>
  	<div class="menu-menu">						
  		<ul class="list-unstyled menu-tab1">
			<li><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-home"></i> Home</a></li>
			<li><a href="<?php echo base_url('kontak-kami');?>"><i class="glyphicon glyphicon-comment"></i> Kontak Kami</a></li>
		</ul>
	</div>
	<div class="menu-menu-kategori hidden">	
		<div class="back-to-menu"><i class="glyphicon glyphicon-chevron-left"></i> kembali</div>					
  		<ul class="list-unstyled menu-tab1 scroll-menu" style="height: 300px;">
  			<?php $get_data_setting = for_header_front_end_kategori();?>
				<?php foreach($get_data_setting as $data):?>
					<li>
						<a href="<?php echo base_url();?>kategori/<?php echo $data->slug?>"><?php echo $data->kategori?></a>
					</li>
				<?php endforeach;?>
		</ul>
	</div>
	<h5 style="position: absolute;bottom: 50px;padding-left: 20px;">Selamat Berbelanja!</h5>
		<div class="menu-tab-bottom">
			<label class="facebook"></label>
			<label class="instagram"></label>
			<label class="twitter"></label>
			<label class="youtube"></label>
		</div>
</div>
<div class="load-ship" style="display:none;"><img src="<?php echo base_url('assets/images/load-pro.gif');?>" width="100"><br /><label>sedang memuat<br>klik <i style="color:green" class="refresh">refresh</i> untuk memuat kembali</label></div>
<div class="bg-form-che for-search-mobile hidden"><img class="padload" width="100" src="<?php echo base_url('assets/images/loadbar.gif')?>"></div>
<div class="bg-nav-side close-bg-side" style="display:none;"></div>
<div class="bg-form for-search" style="display:none;"></div>
<div class="bg-form-white for-search-mobile" style="display:none;"></div>
	<div class="container-fluid" style="padding-left:0;padding-right:0;">
	<div class="header fixed-header">
		<div class="navigasi">
			<div class="container">
				<div class="row">
				<!-------------- Mobile -------------->
					<div class="hidden-lg hidden-md hidden-sm col-sm-1 col-xs-2 pull-left">
						<h3 style="padding-top:-5px;"><span style="top:-7px;" class="glyphicon" onclick="openNav();">&#9776;</span></h3>
					</div>
					<div class="hidden-lg hidden-md hidden-sm col-xs-8 text-center" style="margin-top: 10px;">
						<a class="text-center" href="<?php echo base_url();?>">
						<?php $get_data_setting = for_header_front_end();?>
							<?php foreach($get_data_setting as $data):?>
							<img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" width="120">
						<?php endforeach;?>
						</a>
					</div>
				<!-------------- Dekstop -------------->
				<!-------------- Menu Kategori -------------->
					<div class="col-lg-4 col-sm-4 hidden-xs">
						<a href="<?php echo base_url();?>">
							<?php $get_data_setting = for_header_front_end();?>
							<?php foreach($get_data_setting as $data):?>
								<img src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" class="img-responsive" style="padding:10px 0px 10px 0px;height: 50px;">
								<span style="border-left: 1px solid white;position: absolute;top:5px;line-height: 40px;left: 150px;">&nbsp</span>
							<?php endforeach;?>
						</a>
						<span class="text_back vn">Bantuan</span>
					</div>
					<div class="col-lg-8 col-sm-8 hidden-sm hidden-xs log text-center">
						<a class="text_back" href="<?php echo base_url();?>"><i class="glyphicon glyphicon-arrow-left"></i> Kembali ke menu utama</a>
					</div>
				</div>
			</div>
		</div>
		</div>
		<div class="cntrlSc">
			<div class="container">
				<div class="col-md-2 hidden-xs"></div>
				<div class="col-md-8 col-xs-12 col-search">
					<input style="padding-left: 10px !important;" type="search" class="form-control jl search-bar" name="search" placeholder="Apa yang anda ingin tanyakan ?.">
					<span type="submit" class="cariSepatu yls" style="margin-top: -8px;"><i class="glyphicon glyphicon-search"></i></span>
				</div>
				<div class="col-md-2 hidden-xs"></div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url('assets/global/jquery-3.1.1.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/global/autoCom/jquery.autocomplete.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/global/')?>s497sd_09.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/global/js.cookie.js')?>"></script>
	<script type="text/javascript" src="<?php //echo base_url('qusour894/js/bootstrap.min.js');?>"></script>

