<html lang="en" class="no-js">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	$get_data_setting = for_header_front_end();
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
	<meta charset="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index,follow"/>
	<meta name="copyright" content="This website has been registered and trademark of PT. STARS INTERNASIONAL, Inc "/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo base_url();?>assets/theme/v1/css/responsive.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/theme/v1/css/main.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/theme/v1/css/bootstrap.css" rel="stylesheet" type="text/css">
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
<body style="background-image: url('assets/images/ic_email/not3_bg_image.jpg'); background-repeat: repeat;">	
<div class="bg-parallax-daftar">
	<div class="log-content container" style="padding-left: 150px;padding-right: 150px;">
		<div class="row">
			<div class="col-lg-12 col-xs-12 text-center">
				<?php $get_data_setting = for_header_front_end();?>
				<?php foreach($get_data_setting as $data):?>
					<img class="lazy" src="<?php echo base_url('assets/images/')?><?php echo $data->konten;?>" style="margin-top:-10px;width:120px;display: initial;">
				<?php endforeach;?>
			</div>
			<div class="col-lg-12 col-xs-12">
			<div class="text-center head-title-pro">
				<span id="title" class="head-t"></span>
			</div>
			<div id="shf" class="iopk">
				<div class="col-md-12 col-xs-12 info-success"><?php echo $this->session->flashdata('berhasil');?></div>
				<div class="col-md-12 col-xs-12 info-warning"><?php echo $this->session->flashdata('error');?></div>
				<input type="hidden" name="cosreg" class="cosreg" value="<?php $a = $this->encrypt->encode('Kjs$2%3^+54lNA)163*^$2$319'); $b = base64_encode($a); echo $b?>">
				<div class="row">
					<div class="col-md-12 col-xs-12 re">
					<h4>DAFTAR STARS OFFICIAL STORE</h4>
					<br>
						<span class="jud">Nama Lengkap*</span>
						<input type="text" name="name_l" placeholder="masukkan nama lengkap anda" class="form-control list-form na" required>
						<i class="inf-n o"></i>
					</div>
					<div class="col-md-12 col-xs-12 re">
						<span class="jud">Email*</span>
						<input type="email" name="email_m" placeholder="masukkan email anda" class="form-control list-form em" required>
						<i class="inf-e o"></i>
					</div>
					<div class="col-md-12 col-xs-12 re">
						<span class="jud">Password*</span>
	  						<input type="password" name="ps_d" id="ps" placeholder="masukkan password anda" class="form-control list-form pa passwordx" aria-describedby="basic-addon2" required>
						<i class="inf-p o"></i>
					</div>
					<div class="col-md-12 col-xs-12">
						<span class="jud">Nomor Telepon*</span>
						<input type="number" name="no_l" placeholder="masukkan nomor telepon anda" class="form-control list-form no" required>
						<i class="inf-t o"></i>
					</div>
					<div class="col-md-12 col-xs-12 re">
						<div class="radio"><label><input type="radio" name="gen" class="gen" checked value="pria" required>Pria</label></div>
						<div class="radio"><label><input type="radio" name="gen" class="gen" value="wanita" required>Wanita</label></div>
					</div>
				</div>
				<p ><label class="ag"><input type="checkbox" name="aggre" class="aggre" checked required> Saya telah membaca dan menyetujui <a style="color:red" href="<?php echo base_url('bantuan/syarat-dan-ketentuan');?>">syarat dan ketentuan pengguna</a></label><br>
				<i class="inf-aggre o"></i>
				</p>
				<button name="klik_daftar" onclick="newRegister();" class="reg-new no-b btn btn-lg btn-block" style="background-color:#d80e0e;color:white;">Daftar</button>
			</div><br>
			<?php $get_data_setting_footer = for_footer();?>
			<p class="text-center"><?php foreach($get_data_setting_footer as $data){?><?php echo $data->konten?><?php }?></p>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript">var baseURL = '<?php echo base_url();?>';</script>
	<script src="<?php echo base_url('assets/global/jquery-3.1.1.min.js');?>"></script>
	<script src="<?php echo base_url('assets/global/JQuery.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/global/dataTables.bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/global/js.cookie.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/global/autoCom/jquery.autocomplete.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/global/')?>s497sd_09.js"></script>
</html>